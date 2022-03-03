<?php

namespace Doap\Client;

class Builder
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var array
     */
    private $body;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var int
     */
    private $method;
    /**
     * @var array
     */
    private $header;
    /**
     * @var array $options
     */
    private $options;
    /**
     * @var false $disableSSL
     */
    private $disableSSL;

    /**
     * @var boolean
     */
    private $showOutputHeader;

    public function __construct($url)
    {
        $this->url = $url;
        $this->method = HTTP_METHOD::GET;
        $this->header = array();
        $this->options = array();
        $this->disableSSL = false;
        $this->showOutputHeader = false;
    }

    public function setUrl($url): Builder
    {
        $this->url = $url;
        return $this;
    }

    public function setMethod(int $method): Builder {
        $this->method = $method;
        return $this;
    }

    public function setBody(array $data): Builder {
        $this->body = $data;
        return $this;
    }

    public function setParameters(array $params): Builder {
        $this->parameters = $params;
        return $this;
    }

    public function addHeader($value): Builder {
        $this->header[] = $value;
        return $this;
    }

    public function addOption(int $opt, $value): Builder {
        $this->options[$opt] = $value;
        return $this;
    }

    public function verifySSL($use = true): Builder {
        $this->disableSSL = !$use;
        return $this;
    }

    public function enableOutputHeader($enable = true) {
        $this->showOutputHeader = $enable;
    }

    public function build(): Request {
        if (!empty($this->parameters)) {
            $this->url .= "?" . http_build_query($this->parameters);
        }
        $ch = curl_init($this->url);
        if (!empty($this->body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);
        }
        foreach ($this->options as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        curl_setopt($ch, CURLOPT_HEADER, $this->showOutputHeader);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, !$this->disableSSL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, !$this->disableSSL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, !$this->disableSSL);
        switch ($this->method) {
            CASE HTTP_METHOD::POST:
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            CASE HTTP_METHOD::PUT:
                curl_setopt($ch, CURLOPT_PUT, true);
                break;
            CASE HTTP_METHOD::DELETE:
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            default:
        }
        return new Request($ch);
    }
}