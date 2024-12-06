<?php

//No es una buena solución, pero resuelve el problema

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$map = [];
$directions = [[0,-1],[1,0],[0,1],[-1,0]];
$posInicial = null;
$pos = null;
$directionIndex = 0;
$direction = $directions[$directionIndex];
$cells = [];

foreach ($data as $j=>$line) {
  foreach (str_split($line) as $i=>$value){
    $map[$i][$j] = $value;
    if($value == '^'){
      $posInicial = [$i,$j];
    }
  }
}

$pos = $posInicial;
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

foreach ($cells as $i=>$cell) {
  if ($i == 0){
    continue;
  }
  $pos = $posInicial;
  $directionIndex = 0;
  $direction = $directions[$directionIndex];
  $copyMap = $map;
  $copyMap[$cell[0]][$cell[1]] = '#';
  $cellsAux = [];
  $cellDirection = [];

  $cellsAux[] = $pos;
  $cellDirection[] = [$pos,$directionIndex];

  while(isset($copyMap[$pos[0]+$direction[0]][$pos[1]+$direction[1]])) {
    if($copyMap[$pos[0]+$direction[0]][$pos[1]+$direction[1]] != '#'){
      $pos = [$pos[0]+$direction[0],$pos[1]+$direction[1]];
      if(!in_array($pos,$cellsAux)){
        $cellsAux[] = $pos;
        $cellDirection[] = [$pos,$directionIndex];
      }else{
        if(in_array([$pos,$directionIndex],$cellDirection)){
          $total++;
          break;
        }
      }
    }else{
      $directionIndex = ($directionIndex + 1)%4;
      $direction = $directions[$directionIndex];
    }
  }
}

echo 'Solution: '.$total;

