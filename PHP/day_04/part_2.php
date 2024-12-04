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
    if($cell != 'A'){
      continue;
    }
    if(!isset($matrix[$i-1][$j-1]) ||
      !isset($matrix[$i-1][$j+1]) ||
      !isset($matrix[$i+1][$j-1]) ||
      !isset($matrix[$i+1][$j+1])) {
      continue;
    }
    if($matrix[$i-1][$j-1] == 'M' &&
      $matrix[$i-1][$j+1] == 'M' &&
      $matrix[$i+1][$j-1] == 'S' &&
      $matrix[$i+1][$j+1] == 'S'){
      $total++;
      continue;
    }
    if($matrix[$i-1][$j-1] == 'M' &&
      $matrix[$i-1][$j+1] == 'S' &&
      $matrix[$i+1][$j-1] == 'M' &&
      $matrix[$i+1][$j+1] == 'S'){
      $total++;
      continue;
    }
    if($matrix[$i-1][$j-1] == 'S' &&
      $matrix[$i-1][$j+1] == 'S' &&
      $matrix[$i+1][$j-1] == 'M' &&
      $matrix[$i+1][$j+1] == 'M'){
      $total++;
      continue;
    }
    if($matrix[$i-1][$j-1] == 'S' &&
      $matrix[$i-1][$j+1] == 'M' &&
      $matrix[$i+1][$j-1] == 'S' &&
      $matrix[$i+1][$j+1] == 'M'){
      $total++;
      continue;
    }
  }
}

echo 'Solution: '.$total;
