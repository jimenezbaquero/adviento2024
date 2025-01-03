<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$originalA = 0;
$originalB = 0;
$originalC = 0;
$instructions = '';
$toInstructions = false;
$total = 0;

foreach ($data as $i=>$line) {
  if($line == ''){
    $toInstructions = true;
    continue;
  }

  $aux = explode(': ', $line);

  if(!$toInstructions){
    switch($aux[0]){
      case('Register A'):
        $originalA = $aux[1];
        break;
      case('Register B'):
        $originalB = $aux[1];
        break;
      case('Register C'):
        $originalC = $aux[1];
        break;
    }
  }else{
    $instructions = explode(',', $aux[1]);
  }
}
$newA = 0;
$findSolution = false;
$candidates = [];

while(!$findSolution && $newA <= 1024){
  $outputs = 0;
  $a = $newA;
  $b = $originalB;
  $c = $originalC;
  $position = 0;
  $solution = [];
  while ($position < count($instructions)) {
    $instruction = $instructions[$position];
    $operand = $instructions[$position + 1];
    $combo = searchValue($operand, $a, $b, $c);
    switch ($instruction) {
      case '0':
        $a = floor($a / (2 ** $combo));
        $position += 2;
        break;
      case '1':
        $b = ($b ^ $operand);
        $position += 2;
        break;
      case '2':
        $b = $combo % 8;
        $position += 2;
        break;
      case '3':
        if ($a == 0) {
          $position += 2;
        } else {
          $position = $operand;
        }
        break;
      case '4':
        $b = ($b ^ $c);
        $position += 2;
        break;
      case '5':
        $solution[$outputs] = ($combo % 8);
        if($solution[$outputs] != $instructions[$outputs]){
          $position = count($instructions) + 1;
        }else{
          $candidates[] = $newA;
        }
        $outputs++;
        $position += 2;
        break;
      case '6':
        $b = floor($a / (2 ** $combo));
        $position += 2;
        break;
      case '7':
        $c = floor($a / (2 ** $combo));
        $position += 2;
        break;
    }
  }
  $newA++;
}

for ($i = 1; $i <= count($instructions); $i++) {
  $new_candidates = [];
  foreach ($candidates as $candidate) {
    for ($bit = 0; $bit < 8; $bit++) {
      $possible_candidate = ($bit << (7 + 3 * $i)) | $candidate;
      $position = 0;
      $a = $possible_candidate;
      $b = $originalB;
      $c = $originalC;
      $output = [];

      while ($position < count($instructions)) {
        $instruction = $instructions[$position];
        $operand = $instructions[$position + 1];
        $combo = searchValue($operand, $a, $b, $c);
        switch ($instruction) {
          case '0':
            $a = floor($a / (2 ** $combo));
            $position += 2;
            break;
          case '1':
            $b = ($b ^ $operand);
            $position += 2;
            break;
          case '2':
            $b = $combo % 8;
            $position += 2;
            break;
          case '3':
            if ($a == 0) {
              $position += 2;
            } else {
              $position = $operand;
            }
            break;
          case '4':
            $b = ($b ^ $c);
            $position += 2;
            break;
          case '5':
            $output[] = ($combo % 8);
            $position += 2;
            break;
          case '6':
            $b = floor($a / (2 ** $combo));
            $position += 2;
            break;
          case '7':
            $c = floor($a / (2 ** $combo));
            $position += 2;
            break;
        }
      }

      if(isset($output[$i-1]) && $output[$i-1] == $instructions[$i-1]){
        $new_candidates[] = $possible_candidate;
      }
    }
  }
  $candidates = $new_candidates;
}
echo 'Solution '.min($candidates) ;

function searchValue($operand,$a,$b,$c){
  $aux = 0;
  switch($operand){
    case '0':
    case '1':
    case '2':
    case '3':
      $aux = $operand;
      break;
    case '4':
      $aux = $a;
      break;
    case '5':
      $aux = $b;
      break;
    case '6':
      $aux = $c;
      break;
    case '7':
      break;
  }
  return $aux;
}




