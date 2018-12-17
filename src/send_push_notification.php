<?php
require __DIR__ . '/../vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

$json = json_decode(file_get_contents(__DIR__.'/data/database.json'), true);

$auth = array(
    'VAPID' => array(
        'subject' => 'https://github.com/Minishlink/web-push-php-example/',
        'publicKey' => 'BDbxFig-GRB7J-5tsr3sj7DRAPMz2W-EOiaP6p9lZJ6LFFBPeKNt-q0BiDUP59edjeV8_ZwEp9yJNz4mcfBKSC4',
        'privateKey' => 'O1g6R3pcKbyXkSBgz1drPpwtXc3GFV_9MyUDPyMMa8g', // in the real world, this would be in a secret file
    ),
);

$webPush = new WebPush($auth);


foreach ($json as $value) {
	$subscription = Subscription::create($value);
	$res = $webPush->sendNotification(
	    $subscription,
	    "Hello!",
	    true
	);
}


// handle eventual errors here, and remove the subscription from your server if it is expired
