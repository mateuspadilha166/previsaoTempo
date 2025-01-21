<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Carregando automaticamente a classe OpenWeatherMap
require __DIR__ . '/../vendor/autoload.php';


// Dependências
use App\WebServes\OpenWeatherMap;

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Previsão do Tempo</h1>
    <div class="container">
        <form action="index.php" method="post">
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" required>
            <label for="uf">Estado</label>
            <input type="text" name="uf" id="uf" required>
            <button type="submit">Consultar</button>
        </form>
    </div>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Instância da API
            $obOpenWeatherMap = new OpenWeatherMap('6dcddb83030da9162abf8bc4f1d30550');
            
            // Recebe cidade e estado
            $cidade = $_POST['cidade'];
            $uf = $_POST['uf'];
            
            // Verifica se os dados foram informados corretamente
            if (empty($cidade) || empty($uf)) {
                die("Cidade e estado são obrigatórios!\n");
            }
            
            // Executa a consulta na API 
            $dadosClima = $obOpenWeatherMap->consultarClimaAtual($cidade, $uf);
            
            // Verifica se a resposta da API contém erro
            if (isset($dadosClima['cod']) && $dadosClima['cod'] == 404) {
                echo '<p>Erro: Cidade não encontrada!</p>';
            } else {
                // Exibe as informações do clima
                echo '<h2>Resultado da Previsão</h2>';
                echo '<p><strong>Cidade:</strong> ' . $cidade . '/' . $uf . '</p>';
                echo '<p><strong>Temperatura:</strong> ' . $dadosClima['main']['temp'] . '°C</p>';
                echo '<p><strong>Sensação Térmica:</strong> ' . $dadosClima['main']['feels_like'] . '°C</p>';
                echo '<p><strong>Clima:</strong> ' . ucfirst($dadosClima['weather'][0]['description']) . '</p>';
            }
        }
    ?>
</body>
</html>
