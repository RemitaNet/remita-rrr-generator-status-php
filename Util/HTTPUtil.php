<?php

class HTTPUtil
{

    public static function postMethod($url, $headers, $data = false)
    {
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_POST, 1);
        
        if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public static function getMethod($url, $headers)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
?>