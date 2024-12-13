<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$directions = [[1,0],[-1,0],[0,1],[0,-1]];
$map = [];
$processed = [];
$regions = [];

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
    $angles = 0;
    foreach ($region as $cell) {
      $north = $cell[0].'-'.($cell[1] - 1);
      $south = ($cell[0]).'-'.($cell[1] + 1);
      $east = ($cell[0]+1).'-'.($cell[1]);
      $west = ($cell[0]-1).'-'.($cell[1]);

      $northWest = ($cell[0]-1).'-'.($cell[1] - 1);
      $southWest = ($cell[0]-1).'-'.($cell[1] + 1);
      $northEast = ($cell[0]+1).'-'.($cell[1] - 1);
      $southEast = ($cell[0]+1).'-'.($cell[1] + 1);

      if(!isset($region[$north]) && !isset($region[$east])){
        $angles++;
      }
      if(!isset($region[$north]) && !isset($region[$west])){
        $angles++;
      }
      if(!isset($region[$south]) && !isset($region[$east])){
        $angles++;
      }
      if(!isset($region[$south]) && !isset($region[$west])){
        $angles++;
      }

      if(isset($region[$north]) && isset($region[$east]) && !isset($region[$northEast])){
        $angles++;
      }
      if(isset($region[$north]) && isset($region[$west]) && !isset($region[$northWest])){
        $angles++;
      }
      if(isset($region[$south]) && isset($region[$east]) && !isset($region[$southEast])){
        $angles++;
      }
      if(isset($region[$south]) && isset($region[$west]) && !isset($region[$southWest])){
        $angles++;
      }
    }
    $total += $angles * count($region);
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



