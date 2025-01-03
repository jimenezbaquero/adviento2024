<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$a = 0;
$b = 0;
$c = 0;
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
        $a = $aux[1];
        break;
      case('Register B'):
        $b = $aux[1];
        break;
      case('Register C'):
        $c = $aux[1];
        break;
    }
  }else{
    $instructions = explode(',', $aux[1]);
  }
}
var_dump($instructions);

$position = 0;
$solution = [];
while($position < count($instructions)){
  echo 'ejecutando intruccion '.$position.PHP_EOL;
  $instruction = $instructions[$position];
  $operand = $instructions[$position + 1];
  $combo = searchValue($operand,$a,$b,$c);
  switch($instruction){
    case '0':
      $a = floor($a/(2**$combo));
      $position += 2;
      break;
    case '1':
      $b = ($b^$operand);
      $position += 2;
      break;
    case '2':
      $b = $combo%8;
      $position += 2;
      break;
    case '3':
      echo 'valor de a '.$a.PHP_EOL;
      if($a == 0){
        $position += 2;
      }else{
        $position = $operand;
      }
      break;
    case '4':
      $b = ($b^$c);
      $position += 2;
      break;
    case '5':
      echo 'valor de combo '.$combo.PHP_EOL;
      $solution[] = ($combo%8);
      $position += 2;
      break;
    case '6':
      $b = floor($a/(2**$combo));
      $position += 2;
      break;
    case '7':
      $c = floor($a/(2**$combo));
      $position += 2;
      break;
  }
}
echo 'Solution '.implode(',', $solution).PHP_EOL;

function searchValue($operand,$a,$b,$c){
  var_dump($operand,$a,$b,$c);
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
  echo 'valor encontrado '.$aux.PHP_EOL;
  return $aux;
}




