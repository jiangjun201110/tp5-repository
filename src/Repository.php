<?php
namespace jiangjun\repository;


use think\App;
use think\Model;

abstract class Repository
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
        $model = $this->model();
        if ($model instanceof Model) {
            return $this->model = $model;
        }
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of think\Model");
        }

        return $this->model = $model;
    }

    abstract public function model();

    /**
     *功能描述（查询）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:11
     * @param $column
     * @param $key
     * @return mixed
     */
    public function pack($column, $key)
    {
        return $this->model->pluck($column, $key);
    }

    /**
     *功能描述（查询所有记录）
     * @author:jiangjun
     * @Date: 2019/5/24
     * @Time: 15:10
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        $columns = $this->dealColumns($columns);
        return $this->model->field($columns)->all();
    }

    /**
     *功能描述（分页）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:10
     * @param int $perPage
     * @param int $page
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15,$page = 1, $columns = array('*'))
    {
        $columns = $this->dealColumns($columns);
        return $this->model->page($page,$perPage)->field($columns)->select();
    }

    /**
     *功能描述（新建一条记录）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:10
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->save($data);
    }

    /**
     *功能描述（通过id,修改一条记录）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:09
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        return $this->model->save($data, ['id'=>$id]);
    }

    /**
     *功能描述（通过删除一条记录）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:09
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     *功能描述（通过id查询一条记录）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:08
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        $columns = $this->dealColumns($columns);
        return $this->model->field($columns)->find($id);
    }

    /**
     *功能描述（根据一个条件查询数据）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:08
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, $columns = array('*'))
    {
        $columns = $this->dealColumns($columns);
        return $this->model->field($columns)->where($field,'=',$value)->find();
    }

    /**
     *功能描述（将没有的方法交给model处理）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:07
     * @param $method
     * @param $params
     * @return mixed
     */
    public function __call($method, $params)
    {
        return  $this->model->$method($params);
    }

    /**
     *功能描述（组装查询字段）
     * @author: jiangjun
     * @Date: 2019/5/24
     * @Time: 15:05
     * @param $columns
     * @return string
     */
    protected function dealColumns($columns)
    {
        if(is_array($columns)){
            return implode(',', $columns);
        }
        return $columns;
    }
}
