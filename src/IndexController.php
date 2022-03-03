<?php

namespace Doap\Sample;

use Doap\Client\Builder;
use Doap\Client\HTTP_METHOD;

class IndexController
{
    public function index() {
        $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/';
        $request = (new Builder($url))
            ->addHeader("Accept: application/json")
            ->verifySSL(false)
            ->setMethod(HTTP_METHOD::GET)
            ->build();
        $response = $request->send();
        var_dump($response->getBody()->toObject());
    }
}