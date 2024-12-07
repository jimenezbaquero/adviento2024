<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$equations = [];

foreach ($data as $equation) {
  $aux = explode(': ', $equation);
  $equations[] = ['total' => $aux[0], 'numbers' => explode(' ',$aux[1])];
}
$results = [];

foreach ($equations as $equation) {
  $results = [];
  foreach ($equation['numbers'] as $key=>$number) {
    if($key == 0){
      $results[] = $equation['numbers'][0];
      continue;
    }
    foreach ($results as $index=>$result) {
      $results[] = $result+$number;
      $results[] = $result*$number;
      $results[] = $result.$number;
      unset($results[$index]);
    }
  }
  foreach ($results as $result) {
    if($result == $equation['total']){
      $total += $equation['total'];
      break;
    }
  }
}

echo 'Solution: '.$total;

