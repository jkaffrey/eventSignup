<?php
// Using json-data saved in text file
// From: http://coursesweb.net/php-mysql/
include("sessions.php");
include("table.inc");
// path and name of the file
$filetxt = './formdata.txt';

// check if the file exists
if(file_exists($filetxt)) {
  // gets json-data from file
  $jsondata = file_get_contents($filetxt);

  // converts json string into array
  $data = json_decode($jsondata);

  date_default_timezone_set('America/Denver');
  function reformatDate($curDate) {

    $date = DateTime::createFromFormat('Y-m-d', $curDate);
    $output = $date->format('F j, Y');
    return $output;
  }

  function reformatTime($curTime) {

    $date = new DateTime($curTime);
    return $date->format('h:i a') ;
  }

  echo "<h1>Upcoming Events</h1>";
  echo "<div id=\"wrapper\"><a href=\"index.php\">Add Event</a><br /><table id=\"keywords\" cellspacing=\"0\" cellpadding=\"0\">";
  echo "<thead><tr><th><span>Event Name</span></th><th><span>Date</span></th><th><span>Time</span></th><th><span>Location</span></th><th><span>Description</span></th><th></th></tr></thead>";
  echo "<tbody>";

  //unset($data[3]);

  foreach($data as $key => $value) {
    //echo $key; //get object potion
    //echo $value->youname . ", " . $value->youemail . "<br>";
    echo "<tr id=\"element$key\"><td class=\"lalign\">$value->eventName</td><td>" . reformatDate($value->date) . "</td><td>" . reformatTime($value->time) . "</td><td>$value->location</td><td>" . substr($value->description, 0, 100) . "...</td>
    <td>
    <form name=\"removeElement\" method=\"POST\" action=\"viewEvent.php\">
    <input type=\"hidden\" name=\"position\" value=\"$key\">
    <input type=\"submit\" value=\"View\">
    </form>
    </td>
    </tr>";
  }

  echo "</tbody></table></div></body></html>";
}

else echo 'The file '. $filetxt .' not exists';
?>
