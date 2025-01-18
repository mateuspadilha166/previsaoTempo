<?php 
/**AUTO LOAD DE CLASSE */
require __DIR__ . '/vendor/autoload.php';
//DEPENDENCIAS
use App\WebServes\OpenWeatherMap;
//INSTANCIA DA API
$obOpenWeatherMap = new OpenWeatherMap('6dcddb83030da9162abf8bc4f1d30550');
//verifica o que eu digitei
if(isset($_GET['cidade']) && isset($_GET['uf'])){
    $cidade = $_GET['cidade'];
    $uf = $_GET['uf'];
}
/**Ececuta a consulta na API no arquivo OpenWarder*/
$dadosClima = $obOpenWeatherMap->consultarClimaAtual($cidade, $uf);

//DUBUG
echo 'Cidade:' .$cidade.'/'.$uf.'<br>';
echo 'Temperatura: ' . $dadosClima['main']['temp'] . '°C <br>'."/n";
echo "Sencação Térmica: " . $dadosClima['main']['feels_like'] . '°C <br>'."/n";
//Clima

echo 'Clima: ' . $dadosClima['weather'][0]['description'] . "<br>";
