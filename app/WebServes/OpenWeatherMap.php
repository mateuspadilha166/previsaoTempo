<?php
// 
namespace App\WebServes;

class OpenWeatherMap
{
    const BASE_URL = 'http://api.openweathermap.org';

    /* Chave da API */
    private $apiKey;

    /** Método responsável por construir a classe */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Método responsável por retornar a previsão do tempo atual no Brasil
     * @param string $cidade
     * @param string $uf
     * @return array
     */
    public function consultarClimaAtual($cidade, $uf)
    {
        return $this->get('/data/2.5/weather', [
            'q' => $cidade . ', BR-' . $uf . ', BR',
        ]);
    }

    /**
     * Método responsável por retornar a previsão futuras
     * @param string $cidade
     * @param string $uf
     * @return array
     */
    public function consultarPrevisaoFutura($cidade, $uf)
    {
        $previsoes = $this->get('/data/2.5/forecast', [
            'q' => $cidade . ', BR-' . $uf . ', BR',
            'cnt' => 40, // Solicita 5 previsões diárias
        ]);

        $dias = [];
        foreach ($previsoes['list'] as $previsao) {
            //Dia a partir da data (usando o timestamp)
            $data = date("Y-m-d", $previsao['dt']);
            if (!isset($dias[$data])) {
                $dias[$data] = $previsao;
            }
        }

        return array_values($dias); // Retorna um array com uma previsão por dia
    }

    /**
     * Método responsável por realizar uma consulta na API
     * @param string $resource
     * @param array $params
     */
    private function get($resource, $params = [])
    {
        // Parâmetros comuns
        $params['units'] = 'metric'; // Temperatura em Celsius
        $params['lang'] = 'pt_br';  //Aqui é o Brasil
        $params['appid'] = $this->apiKey; // Chave da API

        // Endpoint da API
        $endpoint = self::BASE_URL . $resource . '?' . http_build_query($params);

        // Inicializa o CURL
        $curl = curl_init();

        // Configurações do CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        // Executa o CURL
        $response = curl_exec($curl);
        
        // Fecha a conexão cURL
        curl_close($curl);
        
        // Retorna a resposta como um array
        return json_decode($response, true);
    }
}
