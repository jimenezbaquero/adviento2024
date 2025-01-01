<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');

$total = 0;
$map = [];
$movements = '';
$toMovements = false;

$directions = [
  '>' => [0,1],
  '<' => [0,-1],
  '^' => [-1,0],
  'v' => [1,0],
];

$position = [];

foreach ($data as $i=>$line) {
  if($line == ''){
    $toMovements = true;
    continue;
  }
  if(!$toMovements) {
    foreach (str_split($line) as $j => $value) {
      if($value == 'O'){
        $map[$i][2*$j] = '[';
        $map[$i][2*$j+1] = ']';
      }else if ($value == '#'){
        $map[$i][2*$j] = '#';
        $map[$i][2*$j+1] = '#';
      }else if ($value == '@'){
        $map[$i][2*$j] = '@';
        $map[$i][2*$j+1] = '.';
        $position = [$i, 2*$j];
      }else{
        $map[$i][2*$j] = '.';
        $map[$i][2*$j+1] = '.';
      }
    }
  }else{
    $movements .= $line;
  }
}



foreach (str_split($movements) as $value) {
  $direction = $directions[$value];

// TO SEE THE MOVEMENTS
//  echo "\033[H\033[J";
//  paintFull($map);
//  usleep(100000);

  $newPosition = [$position[0] + $direction[0], $position[1] + $direction[1]];

  if($map[$newPosition[0]][$newPosition[1]] == '#'){
    continue;
  }

  if($map[$newPosition[0]][$newPosition[1]] == '.'){
    $map[$position[0]][$position[1]] = '.';
    $map[$newPosition[0]][$newPosition[1]] = '@';
    $position = $newPosition;
    continue;
  }

  if($direction[0] == 0){
    $findDot = false;
    $dotPosition = [];
    $auxPosition = $newPosition;
    while(!$findDot){
      $auxPosition = [$auxPosition[0],$auxPosition[1] + $direction[1]];
      if($map[$auxPosition[0]][$auxPosition[1]] == '.'){
        $findDot = true;
        $dotPosition = [$auxPosition[0],$auxPosition[1]];
      }
      if($map[$auxPosition[0]][$auxPosition[1]] == '#'){
        break;
      }
    }

    if($findDot){
      $auxPosition = $dotPosition;
      while($auxPosition != $position){
        $map[$auxPosition[0]][$auxPosition[1]] = $map[$auxPosition[0]][$auxPosition[1] - $direction[1]];
        $auxPosition = [$auxPosition[0],$auxPosition[1] - $direction[1]];
      }
      $map[$position[0]][$position[1]] = '.';

      $map[$newPosition[0]][$newPosition[1]] = '@';

      $position = $newPosition;
    }
  }else{
    $boxes = findBoxes($position,$map,$direction);
    if(canMove($boxes,$map,$direction)){
      $map = moveBoxes($boxes,$map,$direction);
      $map[$position[0]][$position[1]] = '.';
      $cell = $map[$newPosition[0]][$newPosition[1]];
      $map[$newPosition[0]][$newPosition[1]] = '@';
      $position = $newPosition;
    }
  }


}

foreach ($map as $i=>$line) {
  foreach ($line as $j=>$value) {
    if($value == '['){
      $total += 100*$i + $j;
    }
  }
}

echo 'Solution: '.$total;

function findBoxes($position,$map,$direction){
  if(!isset($map[$position[0] + $direction[0]][$position[1] + $direction[1]])){
    return [];
  }
  $newPosition = [$position[0] + $direction[0],$position[1] + $direction[1]];
  switch ($map[$newPosition[0]][$newPosition[1]]){
    case '#':
    case '.':
      return [];
      break;
    case ']':
      $box = [[$newPosition[0],$newPosition[1]-1],[$newPosition[0],$newPosition[1]]];
      return array_merge([$box],findBoxes($box[0],$map,$direction),findBoxes($box[1],$map,$direction));
      break;
    case '[':
      $box = [[$newPosition[0],$newPosition[1]],[$newPosition[0],$newPosition[1]+1]];
      return array_merge([$box],findBoxes($box[0],$map,$direction),findBoxes($box[1],$map,$direction));
      break;
  }

}

function canMove($boxes,$map,$direction){
  foreach ($boxes as $box){
    $left = $box[0];
    $right = $box[1];
    if($map[$left[0]+$direction[0]][$left[1]+$direction[1]] == '#' || $map[$right[0]+$direction[0]][$right[1]+$direction[1]] == '#') {
      return false;
    }
  }
  return true;
}

function moveBoxes($boxes,$map,$direction){
  $aux = $map;
  $originals = [];
  $copies = [];
  foreach ($boxes as $box){
    $left = $box[0];
    $right = $box[1];
    $aux[$left[0]+$direction[0]][$left[1]+$direction[1]] = $map[$left[0]][$left[1]];
    $aux[$right[0]+$direction[0]][$right[1]+$direction[1]] = $map[$right[0]][$right[1]];
    $originals[] = $left;
    $originals[] = $right;
    $copies[] = [$left[0]+$direction[0],$left[1]+$direction[1]];
    $copies[] = [$right[0]+$direction[0],$right[1]+$direction[1]];
  }
  foreach ($originals as $original){
    if(!in_array($original, $copies)){
      $aux[$original[0]][$original[1]] = '.';
    }
  }

  return $aux;
}