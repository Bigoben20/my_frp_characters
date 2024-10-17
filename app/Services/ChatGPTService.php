<?php

namespace App\Services;

use GuzzleHttp\Client;

class ChatGPTService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY'); // .env dosyanıza API anahtarını eklemelisiniz
    }

    public function getChatResponse($request)
    {
        try {
            $body = [
                'model' => 'gpt-4o', // Kullandığınız modele göre değişiklik yapın
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant that answers dnd questions in the style of a DM'],
                    ['role' => 'user', 'content' => $request->message]
                ],
                'temperature' => $request->creativeness,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $this->apiKey,
                    'Content-Type: application/json',
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($body),
            ]);
    
            $response = json_decode(curl_exec($curl),true);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
            curl_close($curl);
    
            if ($httpCode !== 200) {
                ["success" => false, "error" => 'API isteği başarısız oldu. HTTP Kodu: ' . $httpCode];
            }
    
            return ["success" => true, "data" => $response['choices']];
        } catch (\Exception $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
}
