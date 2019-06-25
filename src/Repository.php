<?php
namespace jiangjun\repository;


use think\App;
use think\Model;

class Repository
{
    protected $model;
    protected $app;
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();

    }
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException("Class {$this->model()} must be an instance of think\Model");
        }

        return $this->model = $model;
    }

    abstract public function model();

    public function pack($column, $key)
    {
        return $this->model->pluck($column, $key);
    }

    public function all($columns = ['*'])
    {
        return $this->model->all($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {

    }
    public function create(array $data)
    {

    }
    public function update(array $data, $id)
    {

    }
    public function delete($id)
    {

    }
    public function find($id, $columns = array('*'))
    {

    }
    public function findBy($field, $value, $columns = array('*'))
    {

    }
}