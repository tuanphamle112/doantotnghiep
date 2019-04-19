<?php

namespace App\Constracts\Eloquent;

interface BaseRepository
{
    public function all($with = [], $select = null);

    public function paginate($paginate, $with = []);
    
    public function create($data = []);

    public function find($id);

    public function fill($id);

    public function destroy($id);
    
    public function findOrFail($id);
}
