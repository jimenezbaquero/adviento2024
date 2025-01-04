<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$patterns = [];
$designs = [];

$change = false;

foreach ($data as $row) {
  if($row == ''){
    $change = true;
    continue;
  }
  if(!$change){
    $patterns = explode(', ',$row);
  }else{
    $designs[] = $row;
  }
}

foreach ($designs as $design) {
  $processed = [];
  $total += countCombinations($design, $patterns, $processed);
}

echo 'Solution '.$total;

function countCombinations($design, $patterns, &$processed) {
  if (isset($processed[$design])) {
    return $processed[$design];
  }

  if ($design === '') {
    return 1;
  }

  $totalCombinations = 0;

  foreach ($patterns as $pattern) {
    if (strpos($design, $pattern) === 0) {
      $totalCombinations += countCombinations(substr($design, strlen($pattern)), $patterns, $processed);
    }
  }

  $processed[$design] = $totalCombinations;
  return $totalCombinations;
}

