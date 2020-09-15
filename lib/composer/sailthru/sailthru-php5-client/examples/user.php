<?
require('_autoload.php');

$api_key = "SAILTHRU-API-KEY";
$api_secret = "SAILTHRU-API-SECRET";

$client = new Sailthru_Client($api_key, $api_secret);
try {
    // update existing user by Sailthru ID
    $response = $client->saveUser("4e2879472d7acd6d97144f9e", array(
        'keys' => array(
            'email' => 'praj@sailthru.com',
            'twitter' => 'infynyxx',
            'fb' => 726310296
        ),
        'lists' => array(
            'list-1' => 1,
            'list-2' => 1,
            'list-3' => 0
        )
    ));

    //update existing user by email or create new user using email address
    $response = $client->saveUser('praj@sailthru.com', array(
        'key' => 'email',
        'lists' => array(
            'list-1' => 0 // optout from list-1
        )
    ));

    // get user by Sailthru ID
    $fields = array(
        'keys' => 1,
        'vars' => 1,
        'activity' => 1
    );
    $response = $client->getUseBySid("4e2879472d7acd6d97144f9e", $fields);

    // get user by Custom key
    $response = $client->getUserByKey("praj@sailthru.com", 'email', $fields);

    // get last rate limit info
    $rate_limit_info = $client->getLastRateLimitInfo("user", "GET");

} catch (Sail_Client_Exception $e) {
    // deal with exception
}
