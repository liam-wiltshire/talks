<?php
require "vendor/autoload.php";

$samples = [
    [1, 3, 5, 1], [1, 4, 5, 2], [2, 4, 6, 2], [2, 3, 5, 1],
    [3, 1, 2, 2], [4, 1, 2, 2], [4, 2, 1, 3], [3, 2, 1, 3]
];
$labels = ['a', 'a', 'a', 'a', 'b', 'b', 'b', 'b'];

$classifier = new \Phpml\Classification\KNearestNeighbors(3);
$classifier->train($samples, $labels);

foreach ($samples as $sample) {
	echo "(".implode($sample, ",").") ";
}
echo "\n\n";

while (1) {
	$test = explode(" ", readline("Enter 4 test values:"));
	echo "Classification: " . $classifier->predict($test) . "\n\n";
}



