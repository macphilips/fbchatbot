<?php

/*
|--------------------------------------------------------------------------
| Application config
|--------------------------------------------------------------------------
|
| Define you config values here.
|
*/

return [
    'webhook_verify_token' => getenv('WEBHOOK_VERIFY_TOKEN'),
    'access_token'         => getenv('PAGE_ACCESS_TOKEN'),
    'app_id'         => getenv('APP_ID'),
    'app_secret'         => getenv('APP_SECRET'),
    'apiai_token'          => getenv('APIAI_TOKEN'),
    'witai_token'          => getenv('WITAI_TOKEN'),
];