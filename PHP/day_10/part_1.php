<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$map = [];
$origins = [];
$destinations = [];

foreach ($data as $row=>$line) {
  foreach (str_split($line) as $column=>$value) {
    $map[$row][$column] = $value;
  }
}


$paths = [];
foreach ($map as $i=>$row) {
  foreach ($row as $j => $value) {
    if ($value == 0) {
      $origins[] = [$i, $j];
    }
    if ($value == 9) {
      $destinations[] = [$i, $j];
    }
  }
}

foreach ($origins as $origin){
  $paths = [$origin];

  for($i = 0; $i < 9; $i++) {
    $paths = findPaths($i, $paths, $map);
  }

  $numPaths = 0;
  foreach ($destinations as $destination){
    if(in_array($destination, $paths)){
      $numPaths++;
    }
  }
  $total += $numPaths;
}

echo 'Solution: '.$total;

function findPaths($value,$paths, $map) {
  $response = [];
  $directions = [ [1,0],[-1,0],[0,1],[0,-1]];
  foreach ($paths as $path) {
    foreach ($directions as $direction) {
      if (isset($map[$path[0] + $direction[0]][$path[1] + $direction[1]])) {
        $newPos = $map[$path[0] + $direction[0]][$path[1] + $direction[1]];
        if ($newPos != '.' && $newPos - $value == 1) {
          $response[] = [$path[0] + $direction[0], $path[1] + $direction[1]];
//          echo 'desde '.implode('-',$path).' vamos a '.implode('-',[$path[0] + $direction[0], $path[1] + $direction[1]]).PHP_EOL;
        }
      }
    }
  }

  return $response;
}




