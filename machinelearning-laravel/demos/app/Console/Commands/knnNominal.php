<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Phpml\Classification\KNearestNeighbors;

class knnNominal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ml:knnNom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nominal implementation of KNN';

    /**
     * @var Application
     */
    private $app;


    private $shapes = [];
    private $colours = [];
    private $maxLength = 0;
    private $labels = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

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

        $classifier = $this->app->makeWith(KNearestNeighbors::class, ['k' => 3]);


        $this->buildDataLists($trainingData);
        $samples = $this->buildNormalisedData($trainingData);

        $classifier->train($samples, $this->labels);

        $this->info("Classifier Trained With:");
        $this->outputTrainingData($trainingData);

        while (1) {
            $test = explode(" ", $this->ask("Enter values (length color shape):"));
            $testData = ['length' => ($test[0] / $this->maxLength)];

            foreach ($this->shapes as $shape) {
                $testData['is_' . $shape] = (int) ($test[2] == $shape);
            }

            foreach ($this->colours as $color) {
                $testData['is_' . $color] = (int) ($test[1] == $color);
            }

            $this->table(array_keys($testData), [$testData]);

            $this->comment("Classification: " . $cat = $classifier->predict(array_values($testData)));
        }
    }

    private function buildDataLists(array $trainingData): void
    {
        foreach ($trainingData as $fruits) {
            foreach ($fruits as $fruit) {
                $this->shapes[$fruit['shape']] = $fruit['shape'];
                $this->colours[$fruit['color']] = $fruit['color'];
                if ($fruit['length'] > $this->maxLength) {
                    $this->maxLength = $fruit['length'];
                }
            }
        }
    }

    private function buildNormalisedData(array $trainingData): array
    {
        $samples = [];

        foreach ($trainingData as $label => $fruits) {
            foreach ($fruits as $fruit) {
                $data = [
                    'length' => $fruit['length'] / $this->maxLength
                ];
                foreach ($this->shapes as $shape) {
                    $data['is_' . $shape] = (int) ($fruit['shape'] == $shape);
                }
                foreach ($this->colours as $color) {
                    $data['is_' . $color] = (int) ($fruit['color'] == $color);
                }
                $samples[] = array_values($data);
                $this->labels[] = $label;
            }
        }

        return $samples;
    }

    private function outputTrainingData($trainingData): void
    {
        $table = [];

        foreach ($trainingData as $label => $fruits) {
            foreach ($fruits as $fruit) {
                array_unshift($fruit, $label);
                $table[] = $fruit;
            }
        }

        $headers = ['Label', 'Length', 'Color', 'Shape'];

        $this->table($headers, $table);
    }
}
