<?php
session_start();
require_once 'app/config/config.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
switch($page) {
    case 'home':
    default:
        include 'app/views/home/index.php';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuru AI - Intelligence Grade Fraud Detection</title>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="public/css/components.css">
</head>