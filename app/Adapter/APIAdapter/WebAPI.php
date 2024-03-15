<?php

namespace App\Adapter\APIAdapter;

use Illuminate\Support\Facades\Http;

class WebAPI
{
    private $token = false;

    public function __construct()
    {
        // $this->login();
        $this->token = env('CDN_TOKEN');
    }

    public function login()
    {
        $response = Http::post(env('CDN_LOGIN_URL'), [
            'login' => env('CDN_USER'),
            'password' => env('CDN_PASSWORD'),
            'user_type' => 'user_company'
        ]);

        $body = $response->getBody()->getContents();

        $responseData = json_decode($body, true);

        $this->token = $responseData['access_token'];

        return $responseData;
    }

    public function list($path = '')
    {
        $response = Http::get(env('CDN_API_URL').'list/', [
            'token' => $this->token,
            'path' => $path,
        ]);

        $body = $response->getBody()->getContents();

        $responseData = json_decode($body, true);

        return $responseData;
    }

    public function upload($inputFileName, $inputFileData, $path = '')
    {
        $response = Http::attach(
            'test', $inputFileData, $inputFileName, ['Content-Type' => 'image/jpeg']
        )->post(env('CDN_API_URL').'upload/', [
            'token' => $this->token,
            'path' => $path,
            'input' => 'test'
        ]);

        $body = $response->getBody()->getContents();

        $responseData = json_decode($body, true);

        return $responseData;
    }

    public function search($searchFileName = 'test')
    {
        $response = Http::get(env('CDN_API_URL').'search/', [
            'token' => $this->token,
            'search' => $searchFileName,
        ]);

        $body = $response->getBody()->getContents();

        $responseData = json_decode($body, true);

        return $responseData;
    }

    public function delete($filename, $path = '')
    {
        $response = Http::get(env('CDN_API_URL').'delete/', [
            'token' => $this->token,
            'path' => $path,
            'filename' => $filename
        ]);

        $body = $response->getBody()->getContents();

        $responseData = json_decode($body, true);

        return $responseData;
    }
}
