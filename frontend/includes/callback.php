<?php
session_start();
require_once('LineLogin.php');

$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error') || !property_exists($token, 'id_token')) {
  header('location: ../index.php');
  exit();
}

$profile = $line->profileFormIdToken($token);
$_SESSION['profile'] = $profile;


if (empty($profile) || !is_array($profile)) {
  header('location: ../index.php');
  exit();
}

header('location: ../index.php');
exit();
