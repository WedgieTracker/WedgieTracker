<?php

require_once('./twitter/TwitterAPIExchange.php');

$settings = array(
    'oauth_access_token' => "xxxx",
    'oauth_access_token_secret' => "xxxx",
    'consumer_key' => "xxxx",
    'consumer_secret' => "xxxx"
);

$url = 'https://api.twitter.com/1.1/users/show.json';
$getfield = '?screen_name=WedgieTracker&skip_status=1';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

$wedgieAccount = array();
$wedgieAccount = json_decode($response, 1);

$wedgiesfromtwitter = $wedgieAccount['statuses_count'];

?>
