<?php

require_once('../functions.php');

$data = loadFile('input.txt');
//$data = loadFile('test.txt');
$total = 0;
$patterns = [];
$designs = [];

$change = false;

foreach ($data as $row) {
  if($row == ''){
    $change = true;
    continue;
  }
  if(!$change){
    $patterns = explode(', ',$row);
  }else{
    $designs[] = $row;
  }
}

foreach ($designs as $design) {
  $processed = [];
  if (canFormDesign($design, $patterns, $processed)) {
    $total++;
  }
}

echo "solution $total\n";

function canFormDesign($design, $patterns, &$memo) {
  if (isset($memo[$design])) {
    return $memo[$design];
  }

  if ($design === '') {
    return true;
  }

  foreach ($patterns as $pattern) {
    if (strpos($design, $pattern) === 0) {
      if (canFormDesign(substr($design, strlen($pattern)), $patterns, $memo)) {
        $memo[$design] = true;
        return true;
      }
    }
  }

  $memo[$design] = false;
  return false;
}

