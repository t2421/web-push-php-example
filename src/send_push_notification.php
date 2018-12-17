<?php
require __DIR__ . '/../vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

// here I'll get the subscription endpoint in the POST parameters
// but in reality, you'll get this information in your database
// because you already stored it (cf. push_subscription.php)
$subscription = Subscription::create(json_decode(file_get_contents('php://input'), true));

$auth = array(
    'VAPID' => array(
        'subject' => 'https://github.com/Minishlink/web-push-php-example/',
        'publicKey' => 'BDbxFig-GRB7J-5tsr3sj7DRAPMz2W-EOiaP6p9lZJ6LFFBPeKNt-q0BiDUP59edjeV8_ZwEp9yJNz4mcfBKSC4',
        'privateKey' => 'O1g6R3pcKbyXkSBgz1drPpwtXc3GFV_9MyUDPyMMa8g', // in the real world, this would be in a secret file
    ),
);

$webPush = new WebPush($auth);

$res = $webPush->sendNotification(
    $subscription,
    "Hello!",
    true
);

// handle eventual errors here, and remove the subscription from your server if it is expired
