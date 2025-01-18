<?php 
/**AUTO LOAD DE CLASSE */
require __DIR__ . '/vendor/autoload.php';
//DEPENDENCIAS
use App\WebServes\OpenWeatherMap;

// INSTÂNCIA DA API
$obOpenWeatherMap = new OpenWeatherMap('6dcddb83030da9162abf8bc4f1d30550');

// Recebe a cidade e estado via entrada no terminal
echo "Digite a cidade: ";
$cidade = trim(fgets(STDIN));

echo "Digite o estado (UF): ";
$uf = trim(fgets(STDIN));

// Verifica se os dados foram informados corretamente
if (empty($cidade) || empty($uf)) {
    die("Cidade e estado são obrigatórios!\n");
}

/** Executa a consulta na API com os parâmetros fornecidos */
$dadosClima = $obOpenWeatherMap->consultarClimaAtual($cidade, $uf);

// Exibe as informações do clima
echo 'Cidade: ' . $cidade . '/' . $uf . "\n";
echo 'Temperatura: ' . $dadosClima['main']['temp'] . '°C' . "\n";
echo "Sensação Térmica: " . $dadosClima['main']['feels_like'] . '°C' . "\n";
echo 'Clima: ' . ucfirst($dadosClima['weather'][0]['description']) . "\n";
