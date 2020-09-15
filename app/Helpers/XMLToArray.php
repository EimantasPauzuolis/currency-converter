<?php


namespace App\Helpers;


class XMLToArray
{
    public function convert($xml)
    {
        $data = simplexml_load_string($xml);
        return json_decode(json_encode((array) $data), true);
    }
}
