<?php

namespace Wdev\OpenWeatherMap;

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
     * Método responsável por realizar uma consulta GET na API
     * @param string $resource
     * @param array $params
     */
    private function get($resource, $params = [])
    {
       //parametros adicionais 
       $params ['units'] = 'metric';
         $params ['lang'] = 'pt_br';
            $params ['appid'] = $this->apiKey;
        //ENDPOINT
        $endpoint = self::BASE_URL . $resource . '?' . http_build_query($params);
        //INICIA O CURL
        $curl = curl_init();

        //CONFIGURAÇÕES DO CURL
        curl_setopt_array($curl,[
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);
        //REPOSTA
        $response = curl_exec($curl);
        //FECHA O CURL
        curl_close($curl);
        //ele responde em array <3
        return json_decode($response, true);
    }
}
