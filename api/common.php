<?php
require_once('vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dibi\Connection;

ini_set('display_errors', 'off');

define("JWT_KEY", "xp6fi8EHONcjOG9dD8pkMCXYb1hQnGS2A5JOs0uU9iCkftuayY");

function handleError() {
  
  $error = error_get_last();
  if ($error !== null && $error['type'] === E_ERROR) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode($error);
  }
}

function checkAuth() {
  $jwt = apache_request_headers()['Authorization'] ?? false;
  if (!$jwt) {
    return null;
  }

  $jwt = str_replace('Bearer ', '', $jwt);
  try {
    $user = JWT::decode($jwt, new Key(JWT_KEY, 'HS256'));
  } catch (\Exception $e) {
    throw $e;
    return null;
  }

  return $user->user_id;
}

function getSubordinates($db, $userId) {
  $ids = $db->select('id')->from('osoby')->where('osoba_id = %u AND role IS NOT NULL', $userId)->fetchPairs(null, 'id');
  $subordinates = [ $userId ];
  foreach ($ids as $id) {
      $subordinates = array_merge($subordinates, getSubordinates($db, $id));
  }
  return array_unique($subordinates);
}

function getSuperiors($db, $id) {
  $superiors = [];
  while ($id != null) {
      $id = $db->select('osoba_id')->from('osoby')->where('id = %u', $id)->fetchSingle();
      if ($id != null) {
          $superiors[] = $id;
      }
  }
  return $superiors;
}




$db = new Connection([
  'driver' => 'sqlite3',
  'database' => 'budovani-znacky.db',
]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
  $data = json_decode(file_get_contents("php://input"));
} else {
  $data = null;
}


register_shutdown_function('handleError');
// Nastavení CORS hlaviček
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Pokud je request metoda OPTIONS, vrátí povolené metody
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(204);
  exit();
}