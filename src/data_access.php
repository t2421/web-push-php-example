<?php
$subscription = array(
    "endpoint" => "https://fcm.googleapis.com/fcm/send/drmy2kUJyuE:APA91bGwSQeZoes96uJbT33-S5V9UYjA_yLK6PLBN4Ce06aJ5PTaXfGmhZl9yr_33O_ANaHhK8Kk8XhYYPF9QBAh4En4o2wxvYxboV32l_SAbQ5lE05EcAJQW6mjWi7Rj7U_PdSZj-vd",
    "authToken" => "6tAZBSpnDn1DTh63Mty5RQ",
    "contentEncoding" => "aes128gcm",
    "publicKey"=>"BE5vqMscz1TpKAQW875RppootqL8uUwbNpNXkhS3JkHVY98fngOP2OwYrD9RR8careHNLFgsNpkj7JQYR7ZMb8U="
);


$method = "DELETE";
$json = json_decode(file_get_contents(__DIR__.'/data/database.json'));

switch ($method) {
    case 'POST':
        $token = $subscription["authToken"];
        $is_exist = false;
        foreach ($json as $value) {
            if($value->authToken == $token){
                $is_exist = true;
                break;
            }
        }
        if(!$is_exist){
            array_push($json, $subscription);
        }

        break;
    case 'PUT':
        // update the key and token of subscription corresponding to the endpoint
        break;
    case 'DELETE':
        $token = $subscription["authToken"];
        $is_exist = false;
        $idx = "";
        foreach ($json as $key => $value) {
            if($value->authToken == $token){
                $is_exist = true;
                $idx = $key;
                break;
            }
        }
        if($is_exist){
            unset($json[$idx]);
            $json = array_values($json);
        }
        break;
    default:
        echo "Error: method not handled";
        return;
}
file_put_contents(__DIR__.'/data/database.json', json_encode($json));
