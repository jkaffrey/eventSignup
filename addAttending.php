<?php
include('sessions.php');
header('location: viewEvents.php');

$toRemove = $_POST['attend'];
$user = $_SESSION['username'];
$filetxt = './formdata.txt';

if(file_exists($filetxt) && isset($toRemove) && isset($user)) {

  $jsondata = file_get_contents($filetxt);
  $data = json_decode($jsondata);

  if (in_array($user, $data[$toRemove]->attending)) {
    echo "You are already attending this event. <br />";
  } else {
    array_push($data[$toRemove]->attending, $user);
    echo $data[$toRemove]->attending[1];
  }

  $data = json_encode($data, JSON_PRETTY_PRINT);

  if(file_put_contents('./formdata.txt', $data)) echo 'Data successfully saved';
  else echo 'Unable to save data in "./formdata.txt"';
}
?>
