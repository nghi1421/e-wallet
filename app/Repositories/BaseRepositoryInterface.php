<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface {
    public function paginate($itemOnPage);

    public function getAll();

    public function all($columns = ['*']);

    public function find($id, $columns = ['*']);

    public function findMany($ids,  $columns = ['*']);

    public function getById($id);

    public function destroy($value);

    public function delete($id);

    public function create(array $data);

    public function update(array $condition, array $data);

    public function updateById(array $data, $id);

    public function updateOrCreate(array $attributes, $value = []);

    public function whereColumn($column_name, $value);
}