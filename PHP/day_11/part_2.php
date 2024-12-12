<?php
require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;

$data = explode(' ',$data[0]);
$times = 75;

foreach ($data as $value) {
  $total += calculateStones($value, $times);
}

echo 'Solution '.$total;

function calculateStones($stone, $level){
  static $processed = [];
  if(isset($processed[$stone.'-'.$level])){
    return $processed[$stone.'-'.$level];
  }
  if($level == 0){
    return 1;
  }
  if($stone == 0){
    return calculateStones(1, $level - 1);
  }
  $length = strlen($stone);
  if(strlen($stone)%2 == 0){
    $part1 = substr($stone, 0, $length / 2);
    $part2 = ltrim(substr($stone, -$length / 2), '0');
    $part2 = $part2 == '' ? '0' : $part2;
    $result = calculateStones( $part1,$level-1) + calculateStones( $part2,$level - 1);
  }else{
    $result = calculateStones($stone*2024, $level - 1);
  }

  $processed[$stone.'-'.$level] = $result;
  return $result;
}