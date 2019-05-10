<?php declare(strict_types=1);


namespace App\Services;


use App\Models\Occurrence\Gateway;
use App\Models\Occurrence\Repository;

class Classifier
{

    /**
     * @var Repository
     */
    private $repo;
    /**
     * @var Gateway
     */
    private $gateway;

    public function __construct(Repository $repo, Gateway $gateway)
    {
        $this->repo = $repo;
        $this->gateway = $gateway;
    }

    public function train(string $data, string $category) :void
    {
        $words = explode(" ", $data);
        $words = $this->sanitise($words);

        foreach ($words as $word) {
            if (!$occurrence = $this->repo->getByCategoryAndWord($category, $word)) {
                $args = [
                    'category' => $category,
                    'word' => $word,
                    'count' => 0
                ];
                $occurrence = $this->gateway->createSingleFromArray($args);
            }

            $this->gateway->updateModelFromArray($occurrence, ['count' => $occurrence->count + 1]);
        }
    }

    public function classify(string $data): array
    {
        $words = explode(" ", $data);
        $words = $this->sanitise($words);


        $matches = [];

        //Loop thorugh each word
        foreach ($words as $word) {

            //Find any categories where it appears
            $occurrences = $this->repo->getByKey('word', $word);

            //Find the percentage of appearances for each category
            $totalOccurrences = $occurrences->sum('count');
            foreach ($occurrences as $occurrence) {
                $matches[$occurrence->category][$word] = $occurrence->count / $totalOccurrences;
            }
        }


        $scores = [];

        foreach ($matches as $category => $found) {
            $scores[$category] = array_sum($found) / count($words);
        }

        $prediction = "";
        $probability = 0;
        foreach (array_keys($scores) as $category) {
            if ($scores[$category] > $probability) {
                $probability = $scores[$category];
                $prediction = $category;
            }
        }

        return ['category' => $prediction, 'probability' => $probability];
    }

    private function sanitise(array $words): array
    {
        $words = array_map(function ($word) {
            return strtolower(preg_replace("/\W/u", "", $word));
        }, $words);

        $return = [];
        foreach ($words as $word) {
            if (strlen($word) > 2) {
                $return[] = $word;
            }
        }
        return $return;
    }

}