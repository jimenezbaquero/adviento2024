<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$directions = [[1,0],[-1,0],[0,1],[0,-1]];
$map = [];
$processed = [];
$regions = [];
$pendingProcess = [];

foreach ($data as $i=>$line) {
  foreach (str_split($line) as $j=>$value) {
    $map[$i][$j] = $value;
    $processed[$i][$j] = false;
  }
}

$regionNumber = 0;
$regions[$regionNumber] = [];

foreach($map as $i=>$line) {
  foreach($line as $j=>$cell) {
    if(!$processed[$i][$j] && !in_array([$i,$j],$regions[$regionNumber])) {
      $neigbors = findNeighbors($i,$j,$directions,$map,$processed);
      if(empty($regions[$regionNumber])) {
        $regions[$regionNumber][$i.'-'.$j] = [$i,$j];
      }
      $regions[$regionNumber] = array_merge($regions[$regionNumber],$neigbors);
      $regionNumber++;
      $regions[$regionNumber] = [];
    }
  }
}

foreach ($regions as $key=>$region) {
  if(!empty($region)) {
    $perimeter = 0;
    foreach ($region as $cell) {
      foreach ($directions as $direction) {
        if (!isset($region[$cell[0] + $direction[0].'-'.$cell[1] + $direction[1]])) {
          $perimeter++;
        }
      }
    }
    $total += $perimeter * count($region);
  }
}

echo 'Solution: '.$total;

function findNeighbors($i,$j,$directions,$map,&$processed) {
  $neighbors = [];
  if($processed[$i][$j]) {
    return [];
  }
  $processed[$i][$j] = true;
  foreach ($directions as $direction) {
    if (isset($map[$i + $direction[0]][$j + $direction[1]]) &&
      !$processed[$i + $direction[0]][$j + $direction[1]] &&
      $map[$i][$j] == $map[$i + $direction[0]][$j + $direction[1]]) {
      $neighbors[$i + $direction[0].'-'.$j + $direction[1]] = [$i + $direction[0], $j + $direction[1]];
    }
  }
  foreach ($neighbors as $neighbor) {
    $newNeighbors= findNeighbors($neighbor[0],$neighbor[1],$directions,$map,$processed);
    $neighbors = array_merge($neighbors,$newNeighbors);
  }

  return $neighbors;
}



