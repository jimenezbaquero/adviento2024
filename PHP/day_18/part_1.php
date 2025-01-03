<?php

require_once('../functions.php');

$data = loadFile('input.txt');
$size = 70;
//$data = loadFile('test.txt');
//$size = 6;
$map = [];

for($i=0;$i<=$size;$i++){
  for($j=0;$j<=$size;$j++) {
    $map[$i][$j] = '.';
  }
}

foreach ($data as $i =>$coor) {
  if($i>1024){
    break;
  }
  $aux = explode(",", $coor);
  $map[$aux[1]][$aux[0]] = '#';
}

echo 'Solution '.findPath($map);

function findPath($map) {
  $size = count($map);
  $start = [0, 0];
  $end = [$size - 1, $size - 1];
  $queue = new SplPriorityQueue();
  $queue->insert($start, 0);
  $distances = [];
  $distances[0][0] = 0;
  $directions = [
    'N' => [-1, 0],
    'E' => [0, 1],
    'S' => [1, 0],
    'W' => [0, -1]];

  while (!$queue->isEmpty()) {
    list($i, $j) = $queue->extract();
    $current_distance = $distances[$i][$j];

    if ([$i, $j] == $end) {
      return $current_distance;
    }

    foreach ($directions as $direction) {
      $ni = $i + $direction[0];
      $nj = $j + $direction[1];

      if (isValid($ni, $nj, $map)) {
        $new_distance = $current_distance + 1;
        if (!isset($distances[$ni][$nj]) || $new_distance < $distances[$ni][$nj]) {
          $distances[$ni][$nj] = $new_distance;
          $priority = -$new_distance;
          $queue->insert([$ni, $nj], $priority);
        }
      }
    }
  }

  return -1;
}

function isValid($i,$j,$map){
  if(isset($map[$i][$j]) && $map[$i][$j] == '.') {
    return true;
  }
  return false;
}