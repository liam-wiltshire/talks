<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use PhpParser\Node\Expr\AssignOp\Mod;

/**
 * Class RepositoryAbstract
 *
 * @package App\Models
 */
abstract class RepositoryAbstract
{

    public $class = false;
    public static $self;
    protected $opMap = [
        'eq'    => '=',
        'lt'    => '<',
        'lte'   => '<=',
        'gt'    => '>',
        'gte'   => '>=',
        'like'  => 'LIKE',
        'in'    => 'IN'
    ];

    protected $sortBy = 'created_at';
    protected $sortDir = 'DESC';

    /**
     * RepositoryAbstract constructor.
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        if (!$this->class) {
            $this->class = str_replace('\\Repository', '', get_class($this));
        }
    }

    public function setSort($column)
    {
        $this->sortBy = $column;
        return $this;
    }

    public function setSortDir($dir)
    {
        $this->sortDir = $dir;
        return $this;
    }


    public static function getInstance()
    {
        if (!static::$self) {
            $class = static::class;
            static::$self = new $class();
        }
        return static::$self;
    }


    /**
     * Return a single model instance by $id
     * @param $id
     *
     * @return Model
     */
    public function getById($id)
    {
        $class = $this->class;
        return $class::find($id);
    }

    /**
     * Return a single model instance by key and value
     * @param $key
     * @param $value
     *
     * @return Model
     */
    public function getOneByKey($key, $value)
    {
        $class = $this->class;

        if (is_null($value)) {
            return $class::whereNull($key)->orderBy($this->sortBy, $this->sortDir)->first();
        }

        return $class::where($key, $value)
            ->orderBy($this->sortBy, $this->sortDir)->first();
    }

    /**
     * Return an eloquent collection by key and value
     * @param $key
     * @param $value
     *
     * @return Collection
     */
    public function getByKey($key, $value, $perPage = false)
    {
        $class = $this->class;

        if (is_null($value)) {
            $collection = $class::whereNull($key)->orderBy($this->sortBy, $this->sortDir);
        } else {
            $collection = $class::where($key, $value)->orderBy($this->sortBy, $this->sortDir);
        }


        return $perPage ? $collection->paginate($perPage, ['*'], $this->getClassName())
            : $collection->get();
    }

    /**
     * Return an eloquent collection of related models
     *
     * @param Model $model
     * @param bool $perPage
     * @return Collection
     */
    public function getByModel(Model $model, $perPage = false)
    {
        return $this->getByKey($model->getForeignKey(), $model->id, $perPage);
    }

    /**
     * Return a single model instance from a relationship by key and value
     * @param $key
     * @param $value
     *
     * @return Model
     */
    public function getOneByModelKey(Model $model, $key, $value)
    {
        $class = $this->class;
        return $class::where($model->getForeignKey(), $model->id)->where($key, $value)->first();
    }

    /**
     * Return a model by ID from related models
     *
     * @param Model $model
     * @param $id
     * @return mixed
     */
    public function getByModelId(Model $model, $id)
    {
        $class = $this->class;
        return $class::where($model->getForeignKey(), $model->id)->find($id);
    }

    /**
     * Get all the things!
     *
     * @return Collection
     */
    public function getAll($perPage = false)
    {
        $class = $this->class;
        $collection = $class::orderBy($this->sortBy, $this->sortDir);
        return $perPage ? $collection->paginate($perPage, ['*'], $this->getClassName())
            : $class::get();
    }

    /**
     * Get all the pages!
     *
     * @return Collection
     */
    public function getAllPaginated()
    {
        return $this->getAll(15);
    }

    /**
     * Append queries to the Query Builder to filter the returned collection based on the provided argument
     * This should be a multi-dimensional array - each element is a filter consising of:
     * ~ field - field to filter
     * ~ op - eq (equals), lt (less than), lte (less than or equals), gt, gte, like, in
     * ~ value - the comparison value
     *
     * @param Builder|null $builder The query builder to work on - if null, one will be generated from current class
     * @param array        $filters The array of filters - see above
     *
     * @return Builder
     * @throws \Exception
     */
    public function filterByArray(Builder $builder = null, array $filters = [])
    {
        $class = $this->class;
        if (!$builder) {
            $builder = $class::query();
        }

        foreach ($filters as $filter) {
            if (!isset($filter['field']) || !isset($filter['value'])) {
                throw new \Exception("Field and Value are required");
            }

            if (!isset($class::$searchable[$filter['field']])) {
                throw new \Exception("{$filter['field']} isn't searchable!");
            }

            $filter['field'] = $class::$searchable[$filter['field']];

            if (!isset($filter['op'])) {
                $filter['op'] = 'eq';
            }

            if (!isset($this->opMap[$filter['op']])) {
                throw new \Exception("{$filter['op']} is not a valid operation!");
            }

            if ($filter['op'] == 'like') {
                $filter['value'] = '%' . $filter['value'] . '%';
            }

            if (false === strpos($filter['field'], ".")) {
                if ($filter['op'] == 'in') {
                    $builder = $builder->whereIn($filter['field'], explode(",", $filter['value']));
                } else {
                    $builder = $builder->where($filter['field'], $this->opMap[$filter['op']], $filter['value']);
                }
            } else {
                $field = explode(".", $filter['field']);
                if ($filter['op'] == 'in') {
                    $builder = $builder->whereHas(
                        $field[0],
                        function ($query) use ($field, $filter) {
                            $query->whereIn($field[1], explode(",", $filter['value']));
                        }
                    );
                } else {
                    $builder = $builder->whereHas(
                        $field[0],
                        function ($query) use ($field, $filter) {
                            $query->where($field[1], $this->opMap[$filter['op']], $filter['value']);
                        }
                    );
                }
            }
        }
        return $builder;
    }

    private function getClassName()
    {
        $parts = explode("\\", $this->class);
        return array_pop($parts);
    }
}
