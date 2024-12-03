<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$reports = [];
$total = 0;

$data2 = [];
foreach ($data as $key=>$line){
  $levels = explode(' ', $line);
  $newReports = [];
  for($i = 0; $i < count($levels); $i++){
    $aux ='';
    for($j = 0; $j < count($levels); $j++){
      if($i != $j)
      $aux.= $levels[$j].' ';
    }
    $newReports[] = trim($aux);
  }
  $data2[$key] = $newReports;
}

foreach ($data2 as $key=>$set){
  $found = false;
  foreach ($set as $key2=>$line) {
    $secure = true;
    $levels = explode(' ', $line);
    $levelsASC = explode(' ', $line);
    sort($levelsASC);
    $levelsDESC = explode(' ', $line);
    rsort($levelsDESC);

    if ($levels !== $levelsASC && $levels !== $levelsDESC) {
      $secure = false;
      continue;
    }

    if (abs($levels[0] - $levels[1]) >3) {
      $secure = false;
      continue;
    }

    if ($levels[0] == $levels[1]) {
      $secure = false;
      continue;
    }

    $prev = $levels[1];

    for ($i = 2; $i < count($levels); $i++) {
      $act = $levels[$i];
      if ($prev == $act) {
        $secure = false;
      }
      if (abs($prev - $act) > 3) {
        $secure = false;
      }
      if (!$secure) {
        break;
      }
      $prev = $act;
    }
    if ($secure) {
      $found = true;
      break;
    }
  }
  if($found){
    $total++;
  }
}

echo 'Solution: '.$total;
