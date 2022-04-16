<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface RoleRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface RoleRepositoryInterface
{

    /**
     * Instanciate Model
     *
     * @return Model
     */
    public function newInstance(): Model;

    /**
     * Get Model
     *
     * @return string
     */
    public function getModelName() : string;

    /**
     * count all occurence of Model
     *
     * @return int
     */
    public function getCount(): int;

     /**
      * Return all items.
      *
      * @return Collection
      */
    public function all(): Collection;

    /**
     * Return all items even to delete items.
     *
     * @return Collection
     */
    public function allWithTrashed(): Collection;

     /**
      * Return query builder instance to perform more manouvers.
      *
      * @param mixed $query
      * @param array $attribute
      * @param array $value
      * @return mixed
      */
    public function query($query,array $attribute, array $value);

     /**
      * Create an item
      *
      * @param array $attributes
      * @return Model
      */
    public function create(array $attributes): Model;

     /**
      * Find an item by id
      *
      * @param int|Model $id
      * @return Model|null
      */
    public function find($id): ?Model;

     /**
      * Update an item by id
      *
      * @param array $attributes
      * @param int|Model $id
      * @return boolean
      */
    public function update(array $attributes, $id): bool;

     /**
      * Delete an item by id
      *
      * @param int|Model $id
      * @return boolean
      */
    public function delete($id): bool;

    /**
     * Delete definitely an item of model from database.
     *
     * @param int|Model $id
     * @return boolean
     */
   public function destroy($id): bool;

}
