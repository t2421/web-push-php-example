<?php
$subscription = json_decode(file_get_contents('php://input'), true);

if (!isset($subscription['endpoint'])) {
    echo 'Error: not a subscription';
    return;
}

$method = $_SERVER['REQUEST_METHOD'];
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