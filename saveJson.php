<?php
// Append new form data in json string saved in text file
// From: http://coursesweb.net/php-mysql/

header('location: viewEvents.php');

// path and name of the file
$filetxt = './formdata.txt';
echo $_POST['description'];
// check if all form data are submited, else output error message
if(isset($_POST['name']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['location']) && isset($_POST['description']) && isset($_POST['meet'])) {
  // if form fields are empty, outputs message, else, gets their data
  if(empty($_POST['name']) || empty($_POST['date']) || empty($_POST['time']) || empty($_POST['location']) || empty($_POST['description']) || empty($_POST['meet'])) {
    echo 'All fields are required';
  }
  else {
    // gets and adds form data into an array
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

    // path and name of the file
    $filetxt = './formdata.txt';

    $arr_data = array();        // to store all form data

    // check if the file exists
    if(file_exists($filetxt)) {
      // gets json-data from file
      $jsondata = file_get_contents($filetxt);

      // converts json string into array
      $arr_data = json_decode($jsondata, true);
    }

    // appends the array with new form data
    $arr_data[] = $formdata;

    // encodes the array into a string in JSON format (JSON_PRETTY_PRINT - uses whitespace in json-string, for human readable)
    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);

    // saves the json string in "formdata.txt" (in "dirdata" folder)
    // outputs error message if data cannot be saved
    if(file_put_contents('./formdata.txt', $jsondata)) echo 'Data successfully saved';
    else echo 'Unable to save data in "./formdata.txt"';
  }
}
else echo 'Form fields not submited';
?>
