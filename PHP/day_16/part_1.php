<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$map = [];
$directions = [
  'E' => [0,1],
  'W' => [0,-1],
  'N' => [-1,0],
  'S' => [1,0],
];
$direction = $directions['E'];
$positionStart = [];
$positionEnd = [];

foreach ($data as $i=>$line) {
  foreach (str_split($line) as $j => $value) {
    $map[$i][$j] = $value;
    switch ($value){
      case 'S':
        $positionStart = [$i,$j];
        break;
      case 'E':
        $positionEnd = [$i,$j];
    }
  }
}

$total = dijkstra($map,$positionStart,$positionEnd);

echo 'Solution: '.$total;
function dijkstra($map, $start, $end){
  $directions = [
    'N' => [-1, 0], 
    'E' => [0, 1], 
    'S' => [1, 0], 
    'W' => [0, -1]];

  $queue = new SplPriorityQueue();
  $visits = [];

  $queue->insert(['data' => [$start[0], $start[1], 'E'], 'priority' => 0], 0);

  while (!$queue->isEmpty()) {
    $step = $queue->extract();

    [$r, $c, $d] = $step['data'];
    $priority = $step['priority'];

    $vkey = implode(",", $step['data']);

    if (isset($visits[$vkey]))  continue;

    $visits[$vkey] = $priority;

    if ($r === $end[0] && $c === $end[1]) return $priority;


    foreach ($directions as $next_d => $direction) {
      
      if (isset($directions[$d]) && ($directions[$d][0] + $direction[0] === 0 && $directions[$d][1] + $direction[1] === 0)) continue;

      $next_r = $r + $direction[0];
      $next_c = $c + $direction[1];
      
      if ($map[$next_r][$next_c] === "#") continue;

      $p = $priority + 1 + ($d === $next_d ? 0 : 1000);
      $next_priority = $p < PHP_INT_MAX ? $p : PHP_INT_MAX;
      $queue->insert(['data' => [$next_r, $next_c, $next_d], 'priority' => $next_priority], -$next_priority);
    }
  }

  return -1;
}



