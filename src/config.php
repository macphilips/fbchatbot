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
    'app_id' => getenv('APP_ID'),
    'app_secret' => getenv('APP_SECRET'),
    'access_token' => getenv('PAGE_ACCESS_TOKEN'),
    'webhook_verify_token' => getenv('WEBHOOK_VERIFY_TOKEN'),
    'dsn' => getenv('DSN'),
    'db_username' => getenv('DB_USERNAME'),
    'db_password' => getenv('DB_PASSWORD')
];