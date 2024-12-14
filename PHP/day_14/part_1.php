<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');

$times = 100;
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

for($i = 1; $i<= $times; $i++){
  foreach($robots as $key=>$robot){
    $newPos = [teletransport($robot['position'][0]+$robot['velocity'][0],$width),teletransport($robot['position'][1]+$robot['velocity'][1],$height)];
    $robots[$key]['position'] = $newPos;
  }
}

$quadrants = [];

foreach ($robots as $key=>$robot){
  $averageWidth = floor($width/2);
  $averageHeight = floor($height/2);
  if($robot['position'][0] == $averageWidth || $robot['position'][1] == $averageHeight ){
    continue;
  }
  if($robot['position'][0] < $averageWidth){
    if($robot['position'][1] < $averageHeight) {
      if(!isset($quadrants[0])) {
        $quadrants[0] = 1;
      }else {
        $quadrants[0]++;
      }
    }else{
      if (!isset($quadrants[1])) {
        $quadrants[1] = 1;
      } else {
        $quadrants[1]++;
      }
    }
  }else  {
    if($robot['position'][1] < $averageHeight){
      if(!isset($quadrants[2])) {
        $quadrants[2] = 1;
      }else {
        $quadrants[2]++;
      }
    }else{
      if (!isset($quadrants[3])) {
        $quadrants[3] = 1;
      } else {
        $quadrants[3]++;
      }
    }
  }
}

echo 'Solution: '.array_product($quadrants);

function teletransport($position,$size){
  if($position < 0){
    return $position + $size;
  }
  if ($position >= $size) {
    return $position % $size;
  }
  return $position;
}