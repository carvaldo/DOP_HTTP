<?php /** @noinspection PhpUnused */

namespace Doap\Client;

class Response {
    private $statusCode;
    private $body;

    public function __construct($ch, $result) {
        $this->statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->body = new Body($result);
    }

    public function getStatusCode(): int {
        return intval($this->statusCode);
    }

    public function getBody(): Body
    {
        return $this->body;
    }
}