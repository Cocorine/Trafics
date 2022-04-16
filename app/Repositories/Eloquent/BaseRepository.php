<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Abstract class BaseRepository
 * @package App\Repositories\Eloquent
 */
class BaseRepository implements EloquentRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change variable $model or $this->model
     * @property Model|mixed $model;
     */
    protected $model;

     /**
      * BaseRepository constructor.
      *
      * @param Model $model
      */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     *
     *  @return Model
    */
    public function newInstance() : Model
    {
        return $this->model->newInstance();
    }

    /**
     *
     *  @return string
    */
    public function getModelName() : string
    {
        $class = explode("\\", get_class($this->newInstance())); // save each word of string as an item on array

        return strtolower(end($class));
    }

    /**
     * List of model.
     *
     * @return Collection
     */
    public function all() : Collection
    {
        return $this->model->latest('id')->get();
    }

    /**
     * Return all items even to soft delete items.
     *
     * @return Collection
     */
    public function allWithTrashed() : Collection
    {
        return $this->model->withTrashed()->latest('id')->get();
    }

    /**
     * count all occurence of Model
     *
     * @return int
    */
    public function getCount() : int
    {
        return $this->model->count();
    }

    /**
     * Create an model.
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes) : Model
    {
        return $this->model->create($attributes);
    }


     /**
      * Find an model.
      *
      * @param int|Model $id
      * @return Model|null
      */
    public function find($id): ?Model
    {
        return $this->model->findOrfail($id);
    }

     /**
      * Custom query on model.
      *
      * @param mixed $query
      * @param array $attribute
      * @param array $value
      * @return mixed
      */
    public function query($query, array $attribute, array $value)
    {
        return [];
    }

     /**
      * Update an model.
      *
      * @param array $attributes
      * @param int|Model $id
      * @return boolean
      */
    public function update(array $attributes, $id): bool
    {
        if (!($this->model = $this->find($id))) return false;
        return $this->model->update($attributes);
    }

     /**
      * Delete (hide) an occurence from listing of model.
      *
      * @param int|Model $id
      * @return boolean
      */
    public function delete($id): bool
    {

        if ($this->find($id)->delete()) 
            return true;
        return false;
    }

    /**
     * Delete definitely an occurence of model from database.
     *
     * @param array $ids
     * @return boolean
     */
    public function destroy($id): bool
    {
        if( !( $this->model = $this->allWithTrashed()->find($id)) ) throw new ModelNotFoundException("No query results for model ". $id, 1);
        
        if($this->model->forceDelete())
            return true;
        return false;
    }


}
