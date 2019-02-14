<?php

class Classifier {
	private $dataset;


	public function train($data, $category) {
		$this->dataset = unserialize(file_get_contents("dataset"));
		$data = $this->sanitise(explode(" ", $data));

		if (!isset($this->dataset[$category])) {
			$this->dataset[$category] = [];
		}

		foreach($data as $d) {
			$this->dataset[$category][$d] = isset($this->dataset[$category][$d]) ? $this->dataset[$category][$d] + 1 : 1;			
		}
		file_put_contents("dataset", serialize($this->dataset));
	}

	public function classify($data) : array {
		$this->dataset = unserialize(file_get_contents("dataset"));
		$data = $this->sanitise(explode(" ", $data));

		$results = [];

		foreach($data as $word) {
			$matches = 0;
			foreach($this->dataset as $category => $dataSet) {
				if (isset($dataSet[$word])) {
					$matches += $dataSet[$word];
					$results[$category][$word] = $dataSet[$word];
				}
			}

			foreach(array_keys($this->dataset) as $category) {
				$results[$category][$word] = isset($results[$category][$word]) && $matches > 0 ? $results[$category][$word] / $matches : 0;
			}
		}

$scores = [];
		foreach(array_keys($this->dataset) as $category) {
			$total = 0;
			$count = 0;
			foreach($data as $word) {
				$total += $results[$category][$word];
				$count++;
			}
			$scores[$category] = $total/$count;
		}

		$prediction = "";
		$probability = 0;
		foreach(array_keys($this->dataset) as $category) {
			if ($scores[$category] > $probability) {
				$probability = $scores[$category];
				$prediction = $category;
			}
		}

		return ['category' => $prediction, 'probability' => $probability];
	}

	private function sanitise(array $words) : array {
		$words = array_map(function($word) {
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

?>
