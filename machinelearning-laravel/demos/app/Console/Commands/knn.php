<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Phpml\Classification\KNearestNeighbors;

class knn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ml:knn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demo of KNN';

    /**
     * @var Application
     */
    private $app;

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
        $classifier = $this->app->makeWith(KNearestNeighbors::class, ['k' => 3]);

        $samples = [
            [1, 3, 5, 1], [1, 4, 5, 2], [2, 4, 6, 2], [2, 3, 5, 1],
            [3, 1, 2, 2], [4, 1, 2, 2], [4, 2, 1, 3], [3, 2, 1, 3]
        ];
        $labels = ['a', 'a', 'a', 'a', 'b', 'b', 'b', 'b'];

        $classifier->train($samples, $labels);

        $this->outputTrainingData($samples, $labels);

        while (1) {
            $test = explode(" ", $this->ask("Provide 4 values to classify"));
            $this->comment("Classification: " . $classifier->predict($test));
        }
    }

    private function outputTrainingData($samples, $labels): void
    {
        $table = $samples;

        foreach ($table as $idx => &$sample) {
            array_unshift($sample, $labels[$idx]);
        }

        $this->info("Classifier Trained With:");
        $this->table(['Label', 'Value 1', 'Value 2', 'Value 3', 'Value 4'], $table);
    }
}
