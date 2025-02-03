<?php
require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../vendor/autoload.php'; 

use App\WebServes\OpenWeatherMap;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cidade = trim($_POST['cidade']);
    $uf = trim($_POST['uf']);

    if (empty($cidade) || empty($uf)) {
        echo json_encode(['status' => 'error', 'message' => 'Cidade e estado são obrigatórios!']);
        exit;
    }

    $apiKey = '6dcddb83030da9162abf8bc4f1d30550';
    $obOpenWeatherMap = new OpenWeatherMap($apiKey);

    // Consultar previsões futuras
    $previsoesFuturas = $obOpenWeatherMap->consultarPrevisaoFutura($cidade, $uf);

    if (empty($previsoesFuturas)) {
        echo json_encode(['status' => 'error', 'message' => 'Nenhuma previsão encontrada!']);
        exit;
    }

    $html = "<h2>Previsões para os próximos 5 dias para {$cidade} - {$uf}</h2>";
    $peloAmorDeDeusSalvaAprevisao = false;

    foreach ($previsoesFuturas as $previsao) {
        $dataHora = $previsao['dt_txt'];
        $temperatura = $previsao['main']['temp'];
        $descricao = ucfirst($previsao['weather'][0]['description']);

        // Escolher o ícone baseado no clima
        $icone = '';
        if (strpos(strtolower($descricao), 'chuva') !== false || strpos(strtolower($descricao), 'tempestade') !== false) {
            $icone = '<img src="icons/rain.png" alt="Chuva" width="50">';
        } elseif (strpos(strtolower($descricao), 'nublado') !== false) {
            $icone = '<img src="icons/cloudy.png" alt="Nublado" width="50">';
        } elseif (strpos(strtolower($descricao), 'limpo') !== false || strpos(strtolower($descricao), 'ensolarado') !== false) {
            $icone = '<img src="icons/sunny.png" alt="Ensolarado" width="50">';
        }

        // Verificar se a previsão já existe no banco
        $stmt = $pdo->prepare(
            "SELECT COUNT(*) FROM previsao WHERE cidade = :cidade AND estado = :estado AND data_hora = :data_hora"
        );
        $stmt->execute([
            ':cidade' => $cidade,
            ':estado' => $uf,
            ':data_hora' => $dataHora,
        ]);

        if ($stmt->fetchColumn() > 0) {
            continue; // pula se já existir
        }

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO previsao (cidade, estado, temperatura, descricao, data_hora) 
                 VALUES (:cidade, :estado, :temperatura, :descricao, :data_hora)"
            );
            $stmt->execute([
                ':cidade' => $cidade,
                ':estado' => $uf,
                ':temperatura' => $temperatura,
                ':descricao' => $descricao,
                ':data_hora' => $dataHora,
            ]);
            $peloAmorDeDeusSalvaAprevisao = true;
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar previsão: ' . $e->getMessage()]);
            exit;
        }

        $dataFormatada = date("d/m/Y", strtotime($dataHora));
        $html .= "<div class='previsao'>";
        $html .= "<p><strong>Data:</strong> {$dataFormatada}</p>";
        $html .= "<p><strong>Temperatura:</strong> {$temperatura}°C</p>";
        $html .= "<p><strong>Clima:</strong> {$descricao} {$icone}</p>";
        $html .= "</div><hr>";
    }       
    // Se nenhuma previsão foi salva, exibe a mensagem T_T
    if (!$peloAmorDeDeusSalvaAprevisao) {
        $html = "<p>Previsões existentes:</p>" . $html;
    }

    echo json_encode(['status' => 'success', 'message' => $html]);
}
?>
