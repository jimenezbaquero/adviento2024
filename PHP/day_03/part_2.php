<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$data = implode('',$data);
$copyData = $data;
$doTexts= [];
$total = 0;
$patron = "/mul\(\d+,\d+\)/";
$includeDo = true;

while($copyData != '') {
  if($includeDo){
    $posDont = strpos($copyData, "don't()");
    if(!$posDont){
      $doTexts[] = $copyData;
      break;
    }
    $includeDo = false;
    $doTexts[] = substr($copyData, 0, $posDont);
    $copyData = substr($copyData, $posDont+7);
  }else{
    $posDo = strpos($copyData, "do()");
    if(!$posDo){
      break;
    }
    $includeDo = true;
    $copyData = substr($copyData, $posDo+4);
  }
}

$data = implode('',$doTexts);

preg_match_all($patron, $data,$instructions);

foreach ($instructions[0] as $instruction) {
  $instruction = trim($instruction,'mul()');
  $numbers = explode(',',$instruction);
  $total += array_product($numbers);
}

echo 'Solution: '.$total;
