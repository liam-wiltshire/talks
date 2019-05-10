<?php declare(strict_types=1);


namespace App\Models\Occurrence;


use App\Models\RepositoryAbstract;

class Repository extends RepositoryAbstract
{
    public function getByCategoryAndWord(string $category, string $word)
    {
        $class = $this->class;
        return $class::where('category', $category)->where('word', $word)->first();
    }
}