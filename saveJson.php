<?php

header('location: viewEvents.php');

$filetxt = './formdata.txt';
echo $_POST['description'];
if(isset($_POST['name']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['location']) && isset($_POST['description']) && isset($_POST['meet'])) {
  if(empty($_POST['name']) || empty($_POST['date']) || empty($_POST['time']) || empty($_POST['location']) || empty($_POST['description']) || empty($_POST['meet'])) {
    echo 'All fields are required';
  }
  else {
    $formdata = array(
      'eventName'=> $_POST['name'],
      'date'=> $_POST['date'],
      'time'=> $_POST['time'],
      'location'=> $_POST['location'],
      'description'=> $_POST['description'],
      'meetup'=> $_POST['meet'],
      'attending'=> array(),
      'driving'=> "0",
      'seats'=> "0"
    );

    $filetxt = './formdata.txt';

    $arr_data = array();

    if(file_exists($filetxt)) {
      $jsondata = file_get_contents($filetxt);

      $arr_data = json_decode($jsondata, true);
    }

    $arr_data[] = $formdata;

    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);

    if(file_put_contents('./formdata.txt', $jsondata)) echo 'Data successfully saved';
    else echo 'Unable to save data in "./formdata.txt"';
  }
}
else echo 'Form fields not submited';
?>
