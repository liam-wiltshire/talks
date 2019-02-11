<?php
require "vendor/autoload.php";

$trainingData = [
   'apples' => [
      ['length' => 6.5, 'color' => 'red', 'shape' => 'round'],
      ['length' => 7, 'color' => 'green', 'shape' => 'round'],
      ['length' => 6.6, 'color' => 'yellow', 'shape' => 'round'],
      ['length' => 6.9, 'color' => 'yellow', 'shape' => 'round'],
      ['length' => 6.8, 'color' => 'red', 'shape' => 'round'],
   ],
   'bananas' => [
      ['length' => 12, 'color' => 'yellow', 'shape' => 'crescent'],
      ['length' => 12.5, 'color' => 'yellow', 'shape' => 'crescent'],
      ['length' => 12.3, 'color' => 'yellow', 'shape' => 'crescent'],
      ['length' => 11.8, 'color' => 'yellow', 'shape' => 'crescent'],
      ['length' => 11.5, 'color' => 'yellow', 'shape' => 'crescent'],      
   ],
   'oranges' => [
      ['length' => 7, 'color' => 'orange', 'shape' => 'round'],
      ['length' => 7.1, 'color' => 'orange', 'shape' => 'round'],
      ['length' => 7.2, 'color' => 'red', 'shape' => 'round'],
      ['length' => 6.9, 'color' => 'orange', 'shape' => 'round'],
      ['length' => 7.5, 'color' => 'red', 'shape' => 'round'],      
   ]
];


$shapes = [];
$colors = [];
$maxLength = 0;

foreach ($trainingData as $fruits) {
   foreach ($fruits as $fruit) {
      $shapes[$fruit['shape']] = $fruit['shape'];
      $colors[$fruit['color']] = $fruit['color'];
      if ($fruit['length'] > $maxLength) {
         $maxLength = $fruit['length'];
      }
   }
}

$samples = [];

foreach ($trainingData as $label => $fruits) {
   foreach ($fruits as $fruit) {
      $data = [
         'length' => $fruit['length'] / $maxLength
      ];
      foreach ($shapes as $shape) {
         $data['is_' . $shape] = (int) ($fruit['shape'] == $shape);
      }
      foreach ($colors as $color) {
         $data['is_' . $color] = (int) ($fruit['color'] == $color);
      }
      $samples[] = array_values($data);
      $labels[] = $label;
   }
}



$classifier = new \Phpml\Classification\KNearestNeighbors(5);
$classifier->train($samples, $labels);

foreach ($samples as $sample) {
   echo "(".implode($sample, ",").") ";
}
echo "\n\n";

while (1) {
   $test = explode(" ", readline("Enter values (length shape color):"));
   $testData = ['length' => ($test[0] / $maxLength)];
   foreach ($shapes as $shape) {
      $testData['is_' . $shape] = (int) ($test[1] == $shape);
   }
   foreach ($colors as $color) {
      $testData['is_' . $color] = (int) ($test[2] == $color);
   }

var_dump($testData);
   
   echo "Classification: " . $cat = $classifier->predict(array_values($testData)) . "\n\n";
}



