<?php
require_once('githubAuth.php');
require_once('functions.php');
session_start();

if(isset($_GET['code']))
{
  header('Refresh: 5; URL=./index.php');
  $fields = array( 'client_id'=>clientID, 'client_secret'=>clientSecret, 'code'=>$_GET['code']);
  $postvars = '';
  foreach($fields as $key=>$value) {
    $postvars .= $key . "=" . $value . "&";
  }

  $data = array('url' => 'https://github.com/login/oauth/access_token',
  'data' => $postvars,
  'header' => array("Content-Type: application/x-www-form-urlencoded","Accept: application/json"),
  'method' => 'POST');

  $gitResponce = json_decode(curlRequest($data));

  if($gitResponce->access_token)
  {
    $data = array('url' => 'https://api.github.com/user?access_token='.$gitResponce->access_token,
    'header' => array("Content-Type: application/x-www-form-urlencoded","User-Agent: ".appName,"Accept: application/json"),
    'method' => 'GET');

    $gitUser = json_decode(curlRequest($data));
    $_SESSION['username'] = $gitUser->login;

    echo '
    <center>
    <table>
    <tr align="center">
    <td colspan="2"><a href="'.$gitUser->html_url.'" target="_blank"><img src="'.$gitUser->avatar_url.'" width="200px" height="200px"/></a></td>
    </tr>
    <tr>
    <td>Username: ' . $gitUser->login. '</td>
    </tr>
    <tr align="center">
    <td>Login successful you will redirect in <br />5 seconds or click <a href="./index.html">here</a></td>
    </tr>
    </table>
    </center>';

  }
  else
  {
    echo "Some error occured try again";
  }
}
else
{
  echo '<a href="https://github.com/login/oauth/authorize?scope=user:email&client_id='.clientID.'" title="Login with Github">
  <img src="./resources/login-with-Github.png" />
  </a>';
}


?>
