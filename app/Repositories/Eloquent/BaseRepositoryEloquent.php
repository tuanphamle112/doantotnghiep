<?php

namespace App\Repositories\Eloquent;

use App\Constracts\Eloquent\BaseRepository;

class BaseRepositoryEloquent implements BaseRepository
{
    public function __construct($model)
    {
        $model = $this->model;
    }

    public function all($with = [], $select = ['*'])
    {
        return $this->model->with($with)->get($select);
    }

    public function paginate($paginate, $with = [])
    {
        return $this->model->with($with)->paginate($paginate);
    }

    public function create($data = [])
    {
        return $this->model->create($data);
    }

    public function fill($data = [])
    {
        return $this->model->fill($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}
