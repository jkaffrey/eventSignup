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
    <span><strong>Starting at:</strong> " . reformatTime($data[$toRemove]->time) . "</span><br /><br />
    <span><strong>Attending: " . sizeof($data[$toRemove]->attending) . "</strong><br />";

    foreach($data[$toRemove]->attending as $person) {
      echo $person . "<br />";//$data[$toRemove]->attending[0]
    }

    echo "</span><br /><br />
    <span><strong>Seats Available: </strong>" . $data[$toRemove]->seats . "</span><br /><br />
    </div>
    <div class=\"actions\">

    <span>
    <form name=\"removeElement\" method=\"POST\" action=\"addAttending.php\">
    <input type=\"hidden\" name=\"attend\" value=\"$toRemove\">
    <input type=\"submit\" value=\"Mark Attending\">
    </form>
    </span>

    <span>
    <form name=\"removeElement\" method=\"POST\" action=\"modifyJSON.php\">
    <input type=\"hidden\" name=\"element\" value=\"$toRemove\">
    <input type=\"submit\" value=\"Remove Event\">
    </form>
    </span>
    </div>
    <div class=\"description\">
      <span>
        <strong>Description:</strong> " . $data[$toRemove]->description . "
      </span>
    </div>
    </div>
    </div>
    </body>
    ";
}
?>
