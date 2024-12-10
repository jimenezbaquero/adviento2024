<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$nodes = [];
$rows = count($data) - 1;
$columns = count(str_split($data[0])) -1;

for($i = 0; $i < count($data); $i++) {
  $aux = str_split($data[$i]);
  for($j = 0; $j < count($aux); $j++) {
    if($aux[$j] != ".") {
      $nodes[$aux[$j]][] = [$i,$j];
    }
  }
}

$antinodes = [];

foreach ($nodes as $identify) {
  foreach ($identify as $key1 => $value1) {
    foreach ($identify as $key2 => $value2) {
      if ($key1 == $key2) {
        continue;
      }

      $distance = [$value1[0] - $value2[0], $value1[1] - $value2[1]];
      $inside = true;
      $i = 0;
      while ($inside) {
        $newPos = [$value1[0] + $i * $distance[0], $value1[1] + $i * $distance[1]];

        if ($newPos[0] < 0 || $newPos[1] < 0 || $newPos[0] > $rows || $newPos[1] > $columns) {
          $inside = false;
        } else{
          if (!in_array($newPos, $antinodes)) {
            $antinodes[] = $newPos;
          }
          $i++;
        }
      }
    }
  }
}

$total = count($antinodes);

echo 'Solution: '.$total;

