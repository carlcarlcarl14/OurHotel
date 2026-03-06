<?php
$host = getenv('DB_HOST') ?: '127.0.0.1';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'ourhotel';
$db_port = (int)(getenv('DB_PORT') ?: 3306);

$conn = mysqli_connect($host, $username, $password, $db_name, $db_port);

// Backward compatibility: older setup used `datas` DB name.
if (!$conn && !getenv('DB_NAME')) {
    $legacy_db_name = 'datas';
    $conn = mysqli_connect($host, $username, $password, $legacy_db_name, $db_port);
}

if (!$conn) {
    die('Connection Failed! ' . mysqli_connect_error());
}
?>
