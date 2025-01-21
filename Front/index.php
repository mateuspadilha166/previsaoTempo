<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Consulta de Previsão do Tempo</h1>
        </header>

        <!-- Formulário de consulta -->
        <section class="consulta">
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" required>
                </div>
                <div class="form-group">
                    <label for="uf">Estado:</label>
                    <input type="text" name="uf" id="uf" required>
                </div>
                <button type="submit">Consultar</button>
            </form>
        </section>

        <!-- Exibição das previsões -->
        <section class="resultados">
            <?php
            require_once __DIR__ . '/../vendor/autoload.php';

            use App\WebServes\OpenWeatherMap;

            $apiKey = '6dcddb83030da9162abf8bc4f1d30550'; // minha api key
            $obOpenWeatherMap = new OpenWeatherMap($apiKey);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $cidade = $_POST['cidade'];
                $uf = $_POST['uf'];

                // Verificar se a cidade e o estado foram informados
                if (empty($cidade) || empty($uf)) {
                    echo "<p class='erro'>Cidade e estado são obrigatórios!</p>";
                } else {
                    // Consultar previsão futura
                    $previsoesFuturas = $obOpenWeatherMap->consultarPrevisaoFutura($cidade, $uf);

                    if (empty($previsoesFuturas)) {
                        echo "<p class='erro'>Erro ao obter as previsões!</p>";
                    } else {
                        echo "<h2>Previsões para os próximos 5 dias para {$cidade} - {$uf}</h2>";

                        foreach ($previsoesFuturas as $previsao) {
                            $data = date("d/m/Y", strtotime($previsao['dt_txt']));
                            echo "<div class='previsao'>";
                            echo "<p><strong>Data:</strong> {$data}</p>";
                            echo "<p><strong>Temperatura:</strong> {$previsao['main']['temp']}°C</p>";
                            echo "<p><strong>Clima:</strong> " . ucfirst($previsao['weather'][0]['description']) . "</p>";
                            echo "</div><hr>";
                        }
                    }
                }
            }
            ?>
        </section>
    </div>
</body>
</html>
