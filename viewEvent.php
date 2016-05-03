<?php

include("view.inc");
$filetxt = './formdata.txt';
$toRemove = $_POST['position'];

if(file_exists($filetxt) && isset($toRemove)) {

  $jsondata = file_get_contents($filetxt);
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

  echo "<body><h1>" . $data[$toRemove]->eventName . "</h1>";
  echo "
    <div id=\"wrapper\">
    <div id=\"top\">
    <div class=\"timePlace\">
    <span>On " . reformatDate($data[$toRemove]->date) . "</span><br /><br />
    <span>Starting at: " . reformatTime($data[$toRemove]->time) . "</span><br /><br />
    <span>Attending: " . sizeof($data[$toRemove]->attending) . "<br />";

    foreach($data[$toRemove]->attending as $person) {
      echo $person . "<br />";//$data[$toRemove]->attending[0]
    }

    echo "</span><br /><br />
    <span>Seats Available: " . $data[$toRemove]->seats . "</span><br /><br />
    <span>
    <form name=\"removeElement\" method=\"POST\" action=\"modifyJSON.php\">
    <input type=\"hidden\" name=\"element\" value=\"$toRemove\">
    <input type=\"submit\" value=\"Remove Event\">
    </form>
    </span>

    <span>
    <form name=\"removeElement\" method=\"POST\" action=\"addAttending.php\">
    <input type=\"hidden\" name=\"attend\" value=\"$toRemove\">
    <input type=\"submit\" value=\"Mark Attending\">
    </form>
    </span>
    </div>
    </div>
    </div>
    </body>
    ";
}
?>
