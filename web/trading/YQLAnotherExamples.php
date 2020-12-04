<?php

class U_Yahoo{

    private function file_get_contents_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    //return the history quote from the simbol, default begin date is 90 day ago, the default end is today
    public function getHistoryQuote($symbol, $begin = 90, $end = 0){
        if(!$begin && !$end)
            $begin = $end = 0;

        $begin = Date('Y-m-d', strtotime("-{$begin} days"));
        $end = Date('Y-m-d', strtotime("-{$end} days"));
        $url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.historicaldata%20where%20symbol%20%3D%20%22$symbol%22%20and%20startDate%20%3D%20%22$begin%22%20and%20endDate%20%3D%20%22$end%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
        $jason_obj = json_decode( $this->file_get_contents_curl($url) );
        return $jason_obj->query->results->quote;
    }

    //return not just the quote but others informations too
    public function getCurrentData($symbol){
        $is_array = is_array($symbol);

        $imp_symbol = ($is_array)? implode('%22%2C%22', $symbol) : $symbol;

        $url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quote%20where%20symbol%20in%20(%22$imp_symbol%22)&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
        $jason_obj = json_decode( $this->file_get_contents_curl($url) );

        $result = $jason_obj->query->results->quote;

        return (is_array($symbol) and (count($symbol) == 1))? [$result] : $result;
    }

    //return all quotes from the param $symbol passed, if symbol is array, it will return other array indexed by the symbols
    public function getCurrentQuote($symbol){
        if(is_array($symbol)){
            $symbol = empty($symbol)? ['GOOG'] : $symbol;
            $data = $this->getCurrentData($symbol);
            $result = [];

            for ($c = 0; $c < count($data); $c++) { 
                $result[$data[$c]->Symbol] = $data[$c]->LastTradePriceOnly;
            }

            return $result;
        }else
            return $this->getCurrentData($symbol)->LastTradePriceOnly;
    }

}

