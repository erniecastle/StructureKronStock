<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of meYahoo
 *
 * @author Invest!
 */
//$functions = new meYahoo();
//$var = $functions->getCompany('AAPL');
////$json = json_decode($var);
////$var = json_decode($var);
//
//echo $var;
//$manage = (array) $var->query->results->quote;


class meYahoo {

    function getCompany($symbolKey) {
        $is_array = is_array($symbolKey);
        $imp_symbol = ($is_array) ? implode('%22%2C%22', $symbolKey) : $symbolKey;
        $manage = $this->getResultFromYQL($imp_symbol);
        $manage = (array) $manage->query->results->quote;
        if ($manage['Name'] == null) {
            return null;
        } else {
            return array($manage['Name'], $manage['LastTradePriceOnly']);
        }

        // return $manage[14]->AverageDailyVolume;
        //echo print_r($manage[0]->AverageDailyVolume);
    }

    function getStocksValues($symbolKey) {
        $is_array = is_array($symbolKey);
        $imp_symbol = ($is_array) ? implode('%22%2C%22', $symbolKey) : $symbolKey;
        $manage = $this->getResultFromYQL($imp_symbol);
        $manage = (array) $manage->query->results->quote;
        return $manage;
        // return $manage[14]->AverageDailyVolume;
        //echo print_r($manage[0]->AverageDailyVolume);
    }

    private function getResultFromYQL($simbols) {
        $yql_query_url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from"
                . "%20yahoo.finance.quote%20where%20symbol%20IN%20(%22$simbols%22)&diagnostics=false"
                . "&format=json&env=http://datatables.org/alltables.env";
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        curl_close($session);
        return json_decode($json);
    }

    function getHistory($symbol, $startDate, $endDate) {
        $deto = explode("/", $startDate);
        $deto2 = explode("/", $endDate);

        $yql_query_url = "http://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20yahoo.finance."
                . "historicaldata%20WHERE%20symbol%20%3D%20%22$symbol%22%20AND%20startDate"
                . "%20%3D%20%22$deto[2]-$deto[1]-$deto[0]%22%20AND%20endDate%20%3D%20%22$deto2[2]-$deto2[1]-$deto2[0]%22&format=json&diagnostics"
                . "=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($session);
        curl_close($session);
        $manage = json_decode($json);
        $manage = (array) $manage->query->results->quote;

        $mayor = -999;
        $menor = 99999999;
        foreach ($manage as $valor) {
            if ($valor->Close > $mayor) {
                $mayor = $valor->Close;
            }

            if ($valor->Close < $menor) {
                $menor = $valor->Close;
            }
        }

        $array = array(
            "mayor" => $mayor,
            "menor" => $menor,
        );
        return $array;
    }

}
