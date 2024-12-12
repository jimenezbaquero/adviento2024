<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;

$data = explode(' ',$data[0]);

$times = 25;

for ($i = 0;$i<$times;$i++) {
  $newData = [];
  foreach ($data as $value) {;
    if ($value == '0') {
      $newData[] = '1';
    } else {
      $length = strlen($value);
      if ($length % 2 == 0) {
        $part1 = substr($value, 0,$length / 2);
        $part2 = ltrim(substr($value, -$length / 2),'0');
        $newData[] = $part1;
        $newData[] = $part2 == '' ? '0' : $part2;
      } else {
        $newData[] = $value * 2024;
      }
    }
  }
  $data=$newData;
}
echo 'Solution: '.count($data);





