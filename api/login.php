<?php
require_once 'vendor/autoload.php';
require_once 'common.php';
require_once 'GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php';

$email = $data->email;
$password = $data->password;

$row = $db->select('id, heslo, google_authenticator_key')->from('osoby')->where('email = %s', $email)->fetch();

if (!$row) {
    http_response_code(400);
    echo json_encode('Přihlášení se nezdařilo. Uživatel neexistuje.');
} else if (!password_verify($password, $row->heslo)) {
    http_response_code(400);
    echo json_encode('Přihlášení se nezdařilo. Chybné heslo.');
} else {
  if ($row->google_authenticator_key) {
    echo json_encode([ 'id' => $row->id ]);
  } else {
    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = $ga->createSecret();  
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('ZbynekRybicka.cz - Budování značky', $secret);
    echo json_encode([ 'id' => $row->id, 'qrcode' => $qrCodeUrl, 'secret' => $secret ]);
  }
}
