<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RepositoryAbstract
 *
 * @package App\Models
 */
abstract class GatewayAbstract
{

    public $class = false;
    public static $self;


    /**
     * GatewayAbstract constructor.
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        if (!$this->class) {
            $this->class = str_replace('\\Gateway', '', get_class($this));
        }
    }

    /**
     * @codeCoverageIgnore
     * @return mixed
     */
    public static function getInstance()
    {
        if (!static::$self) {
            $class = static::class;
            static::$self = new $class();
        }
        return static::$self;
    }

    /**
     * Create a single object instance using the values provided.
     * @param array $values
     * @param bool  $doSave
     *
     * @return Model
     */
    public function createSingleFromArray(array $values, $doSave = true)
    {
        $model = new $this->class();
        //In theory we could use massassign, however if a model doesn't support it, we have issues
        foreach ($values as $k => $v) {
            $model->$k = $v;
        }

        if ($doSave) {
            $model->save();
        }

        return $model;
    }

    /**
     * Create multiple objects using the values provided.
     * @param array $valuesList
     * @param bool  $doSave
     *
     * @return Model[]
     */
    public function createManyFromArray(array $valuesList, $doSave = true)
    {
        $models = [];

        foreach ($valuesList as $values) {
            $models[] = $this->createSingleFromArray($values, $doSave);
        }

        return $models;
    }

    /**
     * Update an existing model from the given array
     *
     * @param Model $model
     * @param array $values
     * @param bool $doSave
     * @return Model
     */
    public function updateModelFromArray(Model $model, array $values, $doSave = true)
    {
        foreach ($values as $k => $v) {
            $model->$k = $v;
        }

        if ($doSave) {
            $model->save();
        }

        return $model;
    }

    /**
     * Delete the given model
     *
     * @param Model $model
     * @return bool|null
     */
    public function deleteModel(Model $model)
    {
        return $model->delete();
    }

    public function getClass()
    {
        $object = new $this->class;

        return $object;
    }
}
