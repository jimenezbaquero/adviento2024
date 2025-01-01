<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$map = [];
$movements = '';
$toMovements = false;
$directions = [
  '>' => [0,1],
  '<' => [0,-1],
  '^' => [-1,0],
  'v' => [1,0],
];

$position = [];

foreach ($data as $i=>$line) {
  if($line == ''){
    $toMovements = true;
    continue;
  }
  if(!$toMovements) {
    foreach (str_split($line) as $j => $value) {
      $map[$i][$j] = $value;
      if ($value == '@') {
        $position = [$i, $j];
      }
    }
  }else{
    $movements .= $line;
  }
}

foreach (str_split($movements) as $value) {
  $direction = $directions[$value];
  $newPosition = [$position[0] + $direction[0], $position[1] + $direction[1]];

  if($map[$newPosition[0]][$newPosition[1]] == '#'){
    continue;
  }

  if($map[$newPosition[0]][$newPosition[1]] == '.'){
    $map[$position[0]][$position[1]] = '.';
    $map[$newPosition[0]][$newPosition[1]] = '@';
    $position = $newPosition;
    continue;
  }

  $text = '';
  $findDot = false;
  $dotPosition = [];
  $auxPosition = $newPosition;
  while(!$findDot){
    $text .= $map[$auxPosition[0]][$auxPosition[1]];
    $auxPosition = [$auxPosition[0] + $direction[0],$auxPosition[1] + $direction[1]];
    if($map[$auxPosition[0]][$auxPosition[1]] == '.'){
      $findDot = true;
      $dotPosition = [$auxPosition[0],$auxPosition[1]];
    }
    if($map[$auxPosition[0]][$auxPosition[1]] == '#'){
      break;
    }
  }

  if($findDot){
    $map[$position[0]][$position[1]] = '.';
    $map[$newPosition[0]][$newPosition[1]] = '@';
    $map[$dotPosition[0]][$dotPosition[1]] = 'O';
    $position = $newPosition;
  }
}

foreach ($map as $i=>$line) {
  foreach ($line as $j=>$value) {
    if($value == 'O'){
      $total += 100*$i + $j;
    }
  }
}

echo 'Solution: '.$total;