<?php
require_once (__DIR__ . "/vendor/autoload.php");

$token = "token";

$params = [
    'message' => "ping",
    'user_id' => "203268308",
];

$vk = new \VK\VKGroupsApi($token);

$resutl = $vk->request("messages.send", $params);

print_r($resutl);