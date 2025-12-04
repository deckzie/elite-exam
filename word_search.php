<?php 
function wordSearch($words, $target) {
    $indices = [];
    foreach ($words as $index => $word) {
        if ($word === $target) {   // strict comparison
            $indices[] = $index;
        }
    }
    echo "[" . implode(",", $indices) . "]";
}

// Test case
$words = ["I","TWO","FORTY","THREE","JEN","TWO","tWo","Two"];
$target = "TWO";

wordSearch($words, $target);



