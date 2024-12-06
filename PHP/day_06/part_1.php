<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$map = [];
$directions = [[0,-1],[1,0],[0,1],[-1,0]];
$pos = null;
$directionIndex = 0;
$direction = $directions[$directionIndex];
$cells = [];

foreach ($data as $j=>$line) {
  foreach (str_split($line) as $i=>$value){
    $map[$i][$j] = $value;
    if($value == '^'){
      $pos = [$i,$j];
    }
  }
}

$cells[] = $pos;

while(isset($map[$pos[0]+$direction[0]][$pos[1]+$direction[1]])) {
  if($map[$pos[0]+$direction[0]][$pos[1]+$direction[1]] != '#'){
    $pos = [$pos[0]+$direction[0],$pos[1]+$direction[1]];
    if(!in_array($pos,$cells)){
      $cells[] = $pos;
    }
  }else{
    $directionIndex = ($directionIndex + 1)%4;
    $direction = $directions[$directionIndex];
  }
}

$total = count($cells);

echo 'Solution: '.$total;

