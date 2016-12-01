<?php
/*
download.php
Download selected json file from Database
*/

  include('../config/connection.php');
  $jsonID = $_GET['id'];

  $query = "SELECT DISTINCT /**/
            FROM  /**/
            WHERE /**/
            AND /**/ = /**/";
  $result = mysqli_query($dbc,$query);
  $jsonArray = array();

  while($row = mysqli_fetch_assoc($result)) {
    $jsonArray[$row['#']][] = $row['#'];
  }

  $jsonArray = array("Volvo", "BMW", "Toyota");
  //echo json_encode($filename);
  file_put_contents('Manifest.txt', print_r($jsonArray, TRUE));
  $filename = 'Manifest.txt';
  header("Content-type: filetype($filename)");
  header("Content-Disposition: attachment;filename=$filename");
  header("Content-Transfer-Encoding: binary");
  header('Pragma: no-cache');
  header('Expires: 0');
  readfile($filename);

  //header("Location: ../browseManifests.php");
?>
