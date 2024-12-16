<?php

require dirname(DIR) . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(DIR . '/..');
$dotenv->safeLoad();
$environment = $_ENV['ENVIRONMENT'];

$connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
mysqli_set_charset($connection, "utf8mb4"); // To set UTF-8 formatting to the content
