<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$data = $data[0];
$total = 0;
$patron = "/mul\(\d+,\d+\)/";

preg_match_all($patron, $data,$instructions);

foreach ($instructions[0] as $instruction) {
  $instruction = trim($instruction,'mul()');
  $numbers = explode(',',$instruction);
  $total += array_product($numbers);
}

echo 'Solution: '.$total;
