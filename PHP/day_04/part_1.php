<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$directions = [-1,0,1];

$matrix = [];
foreach ($data as $i=>$row) {
  foreach (str_split($row) as $j=>$cell) {
    $matrix[$i][$j] = $cell;
  }
}

foreach ($matrix as $i=>$row) {
  foreach ($row as $j=>$cell) {
    if($cell != 'X'){
      continue;
    }
    foreach ($directions as $directionX) {
      foreach ($directions as $directionY) {
        if(!isset($matrix[$i+$directionX][$j+$directionY])) {
          continue;
        }
        if($matrix[$i+$directionX][$j+$directionY] != 'M') {
          continue;
        }
        if(!isset($matrix[$i+2*$directionX][$j+2*$directionY])) {
          continue;
        }
        if($matrix[$i+2*$directionX][$j+2*$directionY] != 'A') {
          continue;
        }
        if(!isset($matrix[$i+3*$directionX][$j+3*$directionY])) {
          continue;
        }
        if($matrix[$i+3*$directionX][$j+3*$directionY] != 'S') {
          continue;
        }
        $total++;
      }
    }
  }
}

echo 'Solution: '.$total;
