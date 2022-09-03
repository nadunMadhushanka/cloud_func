<?php

use Google\CloudFunctions\FunctionsFramework;
use Psr\Http\Message\ServerRequestInterface;

// Register the function with Functions Framework.
// This enables omitting the `FUNCTIONS_SIGNATURE_TYPE=http` environment
// variable when deploying. The `FUNCTION_TARGET` environment variable should
// match the first parameter.
FunctionsFramework::http('helloHttp', 'helloHttp');

function helloHttp(ServerRequestInterface $request): string
{
    $name = 'World';
    $body = $request->getBody()->getContents();
    if (!empty($body)) {

        
        $json = json_decode($body, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new RuntimeException(sprintf(
                'Could not parse body: %s',
                json_last_error_msg()
            ));
        }
        $name = $json['body'] ?? $name;
    }
    $queryString = $request->getQueryParams();
    $name = $queryString['body'] ?? $name;



    $url = "https://webhook.site/080536aa-08c7-4f86-bb82-7cc5306a35c9";

     
    $curl = curl_init();
     
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $name);
    curl_exec($curl);  
    curl_close($curl);
   
   return sprintf( htmlspecialchars($name));
}