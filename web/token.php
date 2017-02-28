<?php
include('../vendor/autoload.php');
include('./randos.php');

use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;


$TWILIO_ACCOUNT_SID = getenv('TWILIO_ACCOUNT_SID');
$TWILIO_CONFIGURATION_SID = getenv('TWILIO_CONFIGURATION_SID');
$TWILIO_API_KEY = getenv('TWILIO_API_KEY');
$TWILIO_API_SECRET = getenv('TWILIO_API_SECRET');

// An identifier for your app - can be anything you'd like
$appName = 'TwilioVideoDemo';

// choose a random username for the connecting user
$identity = randomUsername();

// Create access token, which we will serialize and send to the client
$token = new AccessToken(
    $TWILIO_ACCOUNT_SID, 
    $TWILIO_API_KEY, 
    $TWILIO_API_SECRET, 
    3600, 
    $identity
);

// Grant access to Video
$grant = new VideoGrant();
$grant->setConfigurationProfileSid($TWILIO_CONFIGURATION_SID);
$token->addGrant($grant);

// return serialized token and the user's randomly generated ID
echo json_encode(array(
    'identity' => $identity,
    'token' => $token->toJWT(),
));
