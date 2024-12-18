<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$userMessage = $data['message'];

// Xử lý logic trả lời tin nhắn
$botResponse = "Bạn vừa nói: $userMessage. Tôi đang xử lý yêu cầu của bạn.";

echo json_encode(['response' => $botResponse]);
?>