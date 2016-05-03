<?php

header('location: viewEvents.php');

$toRemove = $_POST['element'];
echo $toRemove;

if (isset($toRemove)) {

    $filetxt = './formdata.txt';

    $arr_data = array();

    if(file_exists($filetxt)) {

      $jsondata = file_get_contents($filetxt);

      $arr_data = json_decode($jsondata, true);
    }

    unset($arr_data[$toRemove]);
    $arr_data = array_values(array_filter($arr_data));

    $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);

    if(file_put_contents('./formdata.txt', $jsondata)) echo 'Data successfully saved';
    else echo 'Unable to save data in "./formdata.txt"';
}
?>
