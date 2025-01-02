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

function dijkstra($grid, $start, $end)
{
  $directions = [
    'N' => [-1, 0],
    'E' => [0, 1],
    'S' => [1, 0],
    'W' => [0, -1]];
  
  $queue = new \SplPriorityQueue();
  $visits = [];
  $best_priority = PHP_INT_MAX;
  $backtrack = [];
  $goals = [];

  $queue->insert(['data' => ['current' => [$start[0], $start[1], 'E'], 'parent' => null], 'priority' => 0], 0);

  while (!$queue->isEmpty()) {

    $step = $queue->extract();

    [$r, $c, $d] = $step['data']['current'];
    $priority = $step['priority'];

    $vkey = implode(",", $step['data']['current']);
    $pkey = isset($step['data']['parent']) ? implode(",", $step['data']['parent']) : null;

    if ($priority > ($visits[$vkey] ?? PHP_INT_MAX)) continue;

    $visits[$vkey] = $priority;

    if ($r === $end[0] && $c === $end[1]) {
      if ($priority > $best_priority) break;
      $best_priority = $priority;
      $goals[$vkey] = true; // goal added multiple times as it can be approached form different directions
    }

    if (isset($pkey)) $backtrack[$vkey][$pkey] = true;

    foreach ($directions as $next_d => $direction) {
      
      if (isset($directions[$d]) && ($directions[$d][0] + $direction[0] === 0 && $directions[$d][1] + $direction[1] === 0)){
        continue;
      }

      $next_r = $r + $direction[0];
      $next_c = $c + $direction[1];
      $next_vkey = implode(",", [$next_r, $next_c, $next_d]);
      
      if ($grid[$next_r][$next_c] === "#"){
        continue;
      }

      $p = $priority + 1 + ($d === $next_d ? 0 : 1000);
      $next_priority = $p < PHP_INT_MAX ? $p : PHP_INT_MAX;

      if ($next_priority > ($visits[$next_vkey] ?? PHP_INT_MAX)){
        continue;
      }

      $queue->insert(['data' => ['current' => [$next_r, $next_c, $next_d], 'parent' => [$r, $c, $d]], 'priority' => $next_priority], -$next_priority);
    }
  }
  return bfs($backtrack, $goals);
}
function bfs($backtrack, $goals)
{
  $queue = new \SplQueue();
  foreach (array_keys($goals) as $goal) {
    $queue->enqueue($goal);
  }

  $visits = $goals;

  while (!$queue->isEmpty()) {

    $tile = $queue->dequeue();

    foreach (array_keys($backtrack[$tile] ?? []) as $parent) {
      if (isset($visits[$parent])) continue;
      $visits[$parent] = true;
      $queue->enqueue($parent);
    }
  }

  return count(array_unique(array_map(fn($n) => implode(",", array_slice(explode(",", $n), 0, 2)), array_keys($visits))));
}


