<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
class LineLogin
{
  #### change your id
  private $clientId;
  private $clientSecret;

  public function __construct()
  {
    $this->clientId = $_ENV['LINE_CLIENT_ID'];
    $this->clientSecret = $_ENV['LINE_CLIENT_SECRET'];
  }
  
  private const string REDIRECT_URL = 'http://localhost/devaree_project/frontend/includes/callback.php';
  private const string AUTH_URL = 'https://access.line.me/oauth2/v2.1/authorize';
  private const string PROFILE_URL = 'https://api.line.me/v2/profile';
  private const string TOKEN_URL = 'https://api.line.me/oauth2/v2.1/token';
  private const string REVOKE_URL = 'https://api.line.me/oauth2/v2.1/revoke';
  private const string VERIFYTOKEN_URL = 'https://api.line.me/oauth2/v2.1/verify';


  function getLink()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);

    $link = self::AUTH_URL . '?response_type=code&client_id=' . $this->clientId . '&redirect_uri=' . self::REDIRECT_URL . '&scope=profile%20openid%20email&state=' . $_SESSION['state'];
    return $link;
  }

  function refresh($token)
  {
    $header = ['Content-Type: application/x-www-form-urlencoded'];
    $data = [
      "grant_type" => "refresh_token",
      "refresh_token" => $token,
      "client_id" => $this->clientId,
      "client_secret" => $this->clientSecret
    ];

    $response = $this->sendCURL(self::TOKEN_URL, $header, 'POST', $data);
    return json_decode($response);
  }

  function token($code, $state)
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    if ($_SESSION['state'] != $state) {
      return false;
    }

    $header = ['Content-Type: application/x-www-form-urlencoded'];
    $data = [
      "grant_type" => "authorization_code",
      "code" => $code,
      "redirect_uri" => self::REDIRECT_URL,
      "client_id" => $this->clientId,
      "client_secret" => $this->clientSecret
    ];

    $response = $this->sendCURL(self::TOKEN_URL, $header, 'POST', $data);
    return json_decode($response);
  }

  function profileFormIdToken($token = null)
  {
    $payload = explode('.', $token->id_token);
    $ret = array(
      'access_token' => $token->access_token,
      'refresh_token' => $token->refresh_token,
      'userId' => '', // Add userId field
      'name' => '',
      'picture' => '',
      'email' => '',
    );

    if (count($payload) == 3) {
      $data = json_decode(base64_decode($payload[1]));
      // Get user ID from 'sub' claim
      if (isset($data->sub))
        $ret['userId'] = $data->sub;

      if (isset($data->name))
        $ret['name'] = $data->name;

      if (isset($data->picture))
        $ret['picture'] = $data->picture;

      if (isset($data->email))
        $ret['email'] = $data->email;
    }
    return (object) $ret;
  }

  function profile($token)
  {
    $header = ['Authorization: Bearer ' . $token];
    $response = $this->sendCURL(self::PROFILE_URL, $header, 'GET');
    return json_decode($response);
  }

  function verify($token)
  {
    $url = self::VERIFYTOKEN_URL . '?access_token=' . $token;
    $response = $this->sendCURL($url, NULL, 'GET');
    return $response;
  }

  function revoke($token)
  {
    $header = ['Content-Type: application/x-www-form-urlencoded'];
    $data = [
      "access_token" => $token,
      "client_id" => $this->clientId,
      "client_secret" => $this->clientSecret
    ];
    $response = $this->sendCURL(self::REVOKE_URL, $header, 'POST', $data);
    return $response;
  }

  private function sendCURL($url, $header, $type, $data = NULL)
  {
    $request = curl_init();

    if ($header != NULL) {
      curl_setopt($request, CURLOPT_HTTPHEADER, $header);
    }

    curl_setopt($request, CURLOPT_URL, $url);
    curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);

    if (strtoupper($type) === 'POST') {
      curl_setopt($request, CURLOPT_POST, TRUE);
      curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query($data));
    }

    curl_setopt($request, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($request);
    return $response;
  }
}
