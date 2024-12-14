<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');

$width = 101;
$height = 103;
$map = [];
$robots = [];



foreach($data as $row){
  $aux = explode(" ", $row);
  $auxPos = explode(',',str_replace('p=','',$aux[0]));
  $position = [$auxPos[0],$auxPos[1]];
  $auxVel = explode(',',str_replace('v=','',$aux[1]));
  $velocity = [$auxVel[0],$auxVel[1]];
  $robots[] = ['position'=>$position,'velocity'=>$velocity];
}

$find = false;
$times = 0;

while(!$find){
  $times ++;

  foreach($robots as $key=>$robot){
    $newPos = [teletransport($robot['position'][0]+$robot['velocity'][0],$width),teletransport($robot['position'][1]+$robot['velocity'][1],$height)];
    $robots[$key]['position'] = $newPos;
  }
  $find = existsTree(transformRobots($robots,$width,$height));
}

echo 'Solution: '.$times;

function teletransport($position,$size){
  if($position < 0){
    return $position + $size;
  }
  if ($position >= $size) {
    return $position % $size;
  }
  return $position;
}

function existsTree($map){
  $tree = [
    '1111111111111111111111111111111',
    '1.............................1',
    '1.............................1',
    '1.............................1',
    '1.............................1',
    '1..............1..............1',
    '1.............111.............1',
    '1............11111............1',
    '1...........1111111...........1',
    '1..........111111111..........1',
    '1............11111............1',
    '1...........1111111...........1',
    '1..........111111111..........1',
    '1.........11111111111.........1',
    '1........1111111111111........1',
    '1..........111111111..........1',
    '1.........11111111111.........1',
    '1........1111111111111........1',
    '1.......111111111111111.......1',
    '1......11111111111111111......1',
    '1........1111111111111........1',
    '1.......111111111111111.......1',
    '1......11111111111111111......1',
    '1.....1111111111111111111.....1',
    '1....111111111111111111111....1',
    '1.............111.............1',
    '1.............111.............1',
    '1.............111.............1',
    '1.............................1',
    '1.............................1',
    '1.............................1',
    '1.............................1',
    '1111111111111111111111111111111',
    ];
  $find = false;
  $posiblesSolutions = [];
  foreach ($map as $key=>$line){
    $posibleSolution = strpos($line,$tree[0]);
    if($posibleSolution !== false){
      $posiblesSolutions[] = [$posibleSolution,$key];
    }
  }

  foreach ($posiblesSolutions as $posibleSolution){
    for($i =  0; $i <= count($tree); $i++){
      if (substr($map[$posibleSolution[1]+$i], $posibleSolution[0], strlen($tree[$i])) != $tree[$i]) {
        break;
      }
      $find= true;
      break;
    }
  }
  return $find;
}

function transformRobots($robots,$width,$height){
  $map = [];
  for($j = 0; $j < $height; $j++){
    for($i = 0; $i < $width; $i++){
      $map[$i][$j] = '.';
    }
  }
  foreach ($robots as $robot){
    $position = $robot['position'];
    $map[$position[1]][$position[0]] = '1';
  }

  $response = [];
  foreach ($map as $row){
    $response[] = implode('',$row);
  }
   return $response;
}