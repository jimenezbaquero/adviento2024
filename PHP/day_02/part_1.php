<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$reports = [];
$total = 0;

foreach ($data as $line){
  $secure = true;
  $levels = explode(' ', $line);
  $levelsASC = explode(' ', $line);
  sort($levelsASC);
  $levelsDESC = explode(' ', $line);
  rsort($levelsDESC);

  if($levels !== $levelsASC && $levels !== $levelsDESC){
    $secure = false;
    continue;
  }

  if($levels[0] > $levels[1] && $levels[0] - $levels[1] < 4){
    $order = 'desc';
  }else if($levels[0] < $levels[1] && $levels[1] - $levels[0] < 4){
    $order = 'asc';
  }else{
    $secure = false;
    continue;
  }

  $prev = $levels[1];

  for($i=2; $i<count($levels); $i++){
    $act = $levels[$i];
    if($prev == $act){
      $secure = false;
      continue;
    }
    switch($order){
      case('asc'):
        if($prev > $act || $act - $prev > 3 ){
          $secure = false;
        }
        break;
      case('desc'):
        if($prev < $act || $prev - $act > 3){
          $secure = false;
        }
        break;
    }
    if(!$secure){
      break;
    }
    $prev = $act;
  }
  if($secure){
    $total ++;
  }
}

echo 'Solution: '.$total;
