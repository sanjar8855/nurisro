<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$TG_TOKEN = '8792268331:AAE1rxU__3YdWOPHj3rrGjr9Cp-O5av0a8w';
$TG_CHAT  = '-5144517106';

$name  = trim($_POST['name']  ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$lang  = trim($_POST['lang']  ?? 'uz');

if (!$name || !$phone || !$email) {
    echo json_encode(['ok' => false, 'error' => 'empty_fields']);
    exit;
}

$labels = [
    'uz' => ['title' => 'NUR Group — Yangi murojaat', 'name' => 'Ism',     'phone' => 'Telefon', 'email' => 'Email'],
    'en' => ['title' => 'NUR Group — New Inquiry',    'name' => 'Name',    'phone' => 'Phone',   'email' => 'Email'],
    'ru' => ['title' => 'NUR Group — Новый запрос',   'name' => 'Имя',     'phone' => 'Телефон', 'email' => 'Email'],
];
$l = $labels[$lang] ?? $labels['uz'];

$text = "🌿 {$l['title']}\n\n"
      . "👤 {$l['name']}: {$name}\n"
      . "📞 {$l['phone']}: {$phone}\n"
      . "📧 {$l['email']}: {$email}\n\n"
      . "🕐 " . date('d.m.Y H:i');

$ch = curl_init("https://api.telegram.org/bot{$TG_TOKEN}/sendMessage");
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => [
        'chat_id' => $TG_CHAT,
        'text'    => $text,
    ],
]);
$res = curl_exec($ch);
curl_close($ch);

echo $res;
