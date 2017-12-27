<?php
require_once (__DIR__ . "/vendor/autoload.php");

$token = "my_token";

$params = [
    'message' => "ping",
    'user_id' => "203268308",
];

$resutl = VK\VKGroupsApi::send("get", "messages.send", $token, $params);

print_r($resutl);