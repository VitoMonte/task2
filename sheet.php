<?php
/*
* BEFORE RUNNING:
* ---------------
* 1. If not already done, enable the Google Sheets API
*    and check the quota for your project at
*    https://console.developers.google.com/apis/api/sheets
* 2. Install the PHP client library with Composer. Check installation
*    instructions at https://github.com/google/google-api-php-client.
*/

// Autoload Composer.
require_once __DIR__ . '/vendor/autoload.php';

define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
define('CREDENTIALS_PATH', 'token.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
define('SCOPES', implode(' ', [Google_Service_Sheets::SPREADSHEETS]));

$client = getClient();

$service = new Google_Service_Sheets($client);

// ID таблицы
$spreadsheetId = '1_FfAGcUc0hSj0ldIcIW1Obg-DjYmKXVbB4ASSyDMoww';  // TODO: Update placeholder value.

// Диапазон ячеек для редактирования
$range = 'Class Data!A2:C';  


// Подготавливаем таблицу к очистке
$requestBody = new Google_Service_Sheets_ClearValuesRequest();

// Подготавливаем данные для внесения в таблицу 
// $values - значение из нашего "контроллера"
$body = new Google_Service_Sheets_ValueRange(['values' => $values ]);

// Как ибудуут интерпретироваться данные
$valueInputOption = 'RAW';
$params = [ 'valueInputOption' => $valueInputOption ];

//Очищаем таблицу перед внесением спикска
$response = $service->spreadsheets_values->clear($spreadsheetId, $range, $requestBody);

// Добавляем пользователей
$result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);


function getClient() 
{
    // TODO: Change placeholder below to generate authentication credentials. See
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');


    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);

    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));


        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if(!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }

        file_put_contents($credentialsPath, json_encode($accessToken));
    }

    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {

        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        
    }

    return $client;
}

/**
* Expands the home directory alias '~' to the full path.
* @param string $path the path to expand.
* @return string the expanded path.
*/
function expandHomeDirectory($path) 
{
    $homeDirectory = getenv('HOME');

    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }

    return str_replace('~', realpath($homeDirectory), $path);
}

