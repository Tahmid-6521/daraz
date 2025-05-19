<?php
$bot_token = "7878319358:AAGMN6C6lGG3pF5m6H18Ehguvy4S3jk-FQs";
$admin_chat_id = "7848438953";

// Telegram API URL
$api_url = "https://api.telegram.org/bot$bot_token/";

// Get incoming update from Telegram
$update = json_decode(file_get_contents("php://input"), true);

// If message is set
if (isset($update["message"])) {
    $message = $update["message"];
    $chat_id = $message["chat"]["id"];
    $user = $message["from"];
    $text = $message["text"] ?? "";

    // If /start command is received
    if ($text == "/start") {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Send OTP to admin
        $admin_message = "New access request:\n"
            . "Username: @" . ($user["username"] ?? "NoUsername") . "\n"
            . "User ID: " . $user["id"] . "\n"
            . "OTP: $otp";

        file_get_contents($api_url . "sendMessage?chat_id=$admin_chat_id&text=" . urlencode($admin_message));

        // Reply to user
        $reply = "Access request sent to admin.\nPlease wait for verification.";
        file_get_contents($api_url . "sendMessage?chat_id=$chat_id&text=" . urlencode($reply));
    }
}
?>