<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\WebServes\OpenWeatherMap;

$apiKey = '6dcddb83030da9162abf8bc4f1d30550'; // minha apt keu
$obOpenWeatherMap = new OpenWeatherMap($apiKey);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];

    // Verificar se a cidade e o estado foram informados
    if (empty($cidade) || empty($uf)) {
        echo "Cidade e estado são obrigatórios!";
    } else {
        // Consultar previsão futura
        $previsoesFuturas = $obOpenWeatherMap->consultarPrevisaoFutura($cidade, $uf);

        if (empty($previsoesFuturas)) {
            echo "Erro ao obter as previsões!";
        } else {
            echo "<h2>Previsões para os próximos 5 dias</h2>";

            foreach ($previsoesFuturas as $previsao) {
                $data = date("d/m/Y", strtotime($previsao['dt_txt']));
                echo "<p>Data: {$data}</p>";
                echo "<p>Temperatura: {$previsao['main']['temp']}°C</p>";
                echo "<p>Clima: " . ucfirst($previsao['weather'][0]['description']) . "</p><hr>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
</head>
<body>
    <h1>Consulta de Previsão do Tempo</h1>
    <form action="index.php" method="POST">
        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" id="cidade" required>
        <label for="uf">Estado:</label>
        <input type="text" name="uf" id="uf" required>
        <button type="submit">Consultar</button>
    </form>
</body>
</html>
