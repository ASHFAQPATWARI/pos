<?php

// Declare the class
class Shortenurl
{

    // Constructor
    function __construct()
    {
        $this->key = '';
    }

    function setkey($key)
    {

        $this->key = $key;
    }

    // Shorten a URL
    function shorten($url)
    {
        // Send information along
        $url_c= 'https://billing.okimononepal.com/';

        $params=array('longUrl'=>$url_c);

        $url =  http_build_query($params);


        $result = json_decode($this->bitly_get_curl($url_c), true);

     print_r($result);

        return (string)$result['data']['link_save']['link'];
    }



    function bitly_get_curl($uri) {
        $output = "";
        try {
            $ch = curl_init('https://api-ssl.bitly.com/v4/shorten');
          //  curl_setopt($ch, CURLOPT_HEADER, 0);
            $authorization = "Authorization: Bearer ".$this->key; // Prepare the authorisation token
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('longUrl'=>$uri)); // Set the posted fields
            $output = curl_exec($ch);
        } catch (Exception $e) {
        }
        return $output;
    }

}
