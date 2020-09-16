<?php

namespace Xhgui\Profiler\Saver;

use RuntimeException;

class UploadSaver implements SaverInterface
{
    /** @var string */
    private $url;
    /** @var int */
    private $timeout;

    public function __construct($url, $token, $timeout)
    {
        $this->url = $url;
        if ($token) {
            $this->url .= '?&token=' . $token;
        }

        $this->timeout = $timeout;
    }

    public function isSupported()
    {
        return function_exists('curl_init');
    }

    public function save(array $data)
    {
        $json = json_encode($data);
        $this->submit($this->url, $json);
    }

    /**
     * @param string $url
     * @param string $payload
     */
    private function submit($url, $payload)
    {
        $ch = curl_init($url);
        if (!$ch) {
            throw new RuntimeException('Failed to create cURL resource');
        }

        $headers = array(
            // Prefer to receive JSON back
            'Accept: application/json',
            // The sent data is JSON
            'Content-Type: application/json',
        );

        $res = curl_setopt_array($ch, array(
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => $this->timeout,
        ));
        if (!$res) {
            throw new RuntimeException('Failed to set cURL options');
        }

        $result = curl_exec($ch);
        if ($result === false) {
            throw new RuntimeException('Failed to submit data');
        }
        curl_close($ch);

        $response = json_decode($result, true);
        if (!$response) {
            throw new RuntimeException('Failed to decode response');
        }

        if (isset($response['error']) && $response['error']) {
            $message = isset($response['message']) ? $response['message'] : 'Error in response';
            throw new RuntimeException($message);
        }
    }
}
