<?php
/**
 * Created by PhpStorm.
 * User: MOROLARI
 * Date: 11/17/2017
 * Time: 8:26 AM
 */
$json_str = "{
    \"object\": \"page\",
    \"entry\": [
        {
            \"id\": \"148286299255389\",
            \"time\": 1510901362081,
            \"messaging\": [
                {
                    \"sender\": {
                        \"id\": \"2178859302139932\"
                    },
                    \"recipient\": {
                        \"id\": \"148286299255389\"
                    },
                    \"timestamp\": 1510901361919,
                    \"message\": {
                        \"mid\": \"mid.\$cAADcJfbJSJhl-gJ0_1fyL0qS1iCz\",
                        \"seq\": 21,
                        \"text\": \"hello\"
                    }
                }
            ]
        }
    ]
}";

$json = json_decode($json_str,true);

var_dump($json);

echo $json['entry'][0]['messaging'][0]['sender']['id'];

$response = file_get_contents("https://graph.facebook.com/4?fields=name");
$user = json_decode($reponse,true);