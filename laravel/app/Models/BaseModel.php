<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    // 表主键
    protected $primaryKey = 'id';

    // 不可被批量赋值的属性
    protected $guarded = ['id'];

    // 可以被批量赋值的属性。
    protected $fillable = [];

    // 时间自动维护, 时间格式改成时间戳的形式
    public $timestamps = true;

    protected $dateFormat = 'U';

    // 修改自动维护字段名称
    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    /**
     * 获取数据库连接名,
     */
    public function getDbConnection()
    {
        return $this->connection;
    }

    /**
     * @Describe:获取实例
     * @return static
     */
    public static function getInstance()
    {
        $model = new static();
        return $model;
    }

    /**
     * 基础添加
     * @param $data array 数据
     * @return mixed
     */
    public function baseAdd($data)
    {
        return $this->create($data);
    }

    /**
     * 基础编辑
     * @param $id  int 要编辑的id
     * @param $data  array  新数据
     * @return mixed
     */
    public function baseEdit($id, $data)
    {
        $data = array_only($data, $this->fillable);         //字段过滤

        return $this->where($this->primaryKey, '=', $id)->update($data);
    }

    /**
     * 删除
     * @param $id int 删除id
     */
    public function baseRemove($id)
    {
        return $this->where($this->primaryKey, '=', $id)->delete();
    }

    /**
     * 增加
     * @param $data
     * @Author: Faulk.yao
     * @Time: 2020/3/3 10:39
     * @return bool|mixed
     */
    public function add($data)
    {
        $dbResult = $this->create($data);
        if ($dbResult) {
            return $dbResult;
        }

        return false;
    }

    /**
     * 编辑
     * @param $id
     * @param $data
     * @Author: Faulk.yao
     * @Date: 2020/8/6 17:14
     * @return mixed
     */
    public function edit($id, $data)
    {
        $data = array_only($data, $this->fillable);         //字段过滤

        return $this->where($this->primaryKey, '=', $id)->update($data);
    }

    /**
     * 批量获取
     * @param $ids
     * @Author: Faulk.yao
     * @Date: 2020/7/5 15:58
     * @return array
     */
    public function getByIds($ids, $fields = [])
    {
        //定义查询字段
        if (!is_array($fields) || empty($fields)) {
            $fields = $this->fillable;
        }

        if (!is_array($ids)) {
            $ids = explode(",", $ids);
        }
        $res = $this->select($fields)->whereIn($this->primaryKey, $ids)->get()->toArray();

        return $res;
    }

    /**
     * 根据id获取
     * @param $id
     * @param array $fields
     * @Author: Faulk.yao
     * @Date: 2020/7/20 17:10
     * @return array
     */
    public function getById($id, $fields = [])
    {
        //定义查询字段
        if (!is_array($fields) || empty($fields)) {
            $fields = null;
        }
        $model = clone $this;
        if (!empty($fields)) {
            $model = $model->select($fields);
        }
        $res = $model->where($this->primaryKey, $id)->first();
        $res = empty($res) ? [] : $res->toArray();

        return $res;
    }

    /**
     * Notes : 批量更新
     * Author: John
     * Time  : 2020.11.27
     * @param  array  $multipleData
     * @param  string  $tableName
     * return bool|int
     * @return false|int
     */
    public function updateBatch($multipleData = array(), $tableName = "")
    {
        try {
            if (empty($multipleData)) {
                throw new \Exception("数据不能为空");
            }
            $firstRow = current($multipleData);
            $updateColumn = array_keys($firstRow);
            // 默认以id为条件更新，如果没有ID则以第一个字段为条件
            $referenceColumn = isset($firstRow['id']) ? 'id' : current($updateColumn);
            unset($updateColumn[0]);
            // 拼接sql语句
            $updateSql = "UPDATE ".$tableName." SET ";
            $sets = [];
            $bindings = [];
            foreach ($updateColumn as $uColumn) {
                $setSql = "`".$uColumn."` = CASE ";
                foreach ($multipleData as $data) {
                    $setSql .= "WHEN `".$referenceColumn."` = ? THEN ? ";
                    $bindings[] = $data[$referenceColumn];
                    $bindings[] = $data[$uColumn];
                }
                $setSql .= "ELSE `".$uColumn."` END ";
                $sets[] = $setSql;
            }
            $updateSql .= implode(', ', $sets);
            $whereIn = collect($multipleData)->pluck($referenceColumn)->values()->all();
            $bindings = array_merge($bindings, $whereIn);
            $whereIn = rtrim(str_repeat('?,', count($whereIn)), ',');
            $updateSql = rtrim($updateSql, ", ")." WHERE `".$referenceColumn."` IN (".$whereIn.")";

            // 传入预处理sql语句和对应绑定数据
            return DB::update($updateSql, $bindings);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 根据条件查询单条数据
     * @param        $conditions
     * @param array  $columns
     * @param string $mapKey
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function findBy($conditions, array $columns = ['*'], string $mapKey = 'id')
    {
        $conditions = is_array($conditions) ? $conditions : [$mapKey => $conditions];
        return self::query()->where($conditions)->first($columns);
    }

    /**
     * 根据条件查询是否存在
     * @param        $conditions
     * @param string $mapKey
     * @return bool
     */
    public static function existBy($conditions, string $mapKey = 'id'): bool
    {
        $conditions = is_array($conditions) ? $conditions : [$mapKey => $conditions];
        return self::query()->where($conditions)->exists();
    }

    /**
     * 根据条件查询总条数
     * @param        $conditions
     * @param string $column
     * @param string $mapKey
     * @return int
     */
    public static function countBy($conditions, string $column = '*', string $mapKey = 'id'): int
    {
        $conditions = is_array($conditions) ? $conditions : [$mapKey => $conditions];
        return self::query()->where($conditions)->count($column);
    }

    /**
     * 根据条件查询值
     * @param        $conditions
     * @param string $columns
     * @param string $mapKey
     * @return mixed
     */
    public static function valueBy($conditions, string $columns, string $mapKey = 'id')
    {
        $conditions = is_array($conditions) ? $conditions : [$mapKey => $conditions];
        return self::query()->where($conditions)->value($columns);
    }

    /**
     * 根据条件查询具有给定列的值的数组
     * @param             $conditions
     * @param             $column
     * @param string|null $key
     * @param string      $mapKey
     * @return \Illuminate\Support\Collection
     */
    public static function pluckBy($conditions, $column, string $key = null, string $mapKey = 'id')
    {
        $conditions = is_array($conditions) ? $conditions : [$mapKey => $conditions];
        return self::query()->where($conditions)->pluck($column, $key);
    }

    /**
     * 根据条件查询多条数据
     * @param array $conditions
     * @param array $columns
     * @param bool  $isToArray
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function allBy(array $conditions, array $columns = ['*'], bool $isToArray = false)
    {
        $all = self::query()->where($conditions)->get($columns);
        return !$isToArray ? $all : $all->toArray();
    }

    /**
     * 根据条件修改
     * @param        $conditions
     * @param array  $data
     * @param string $mapKey
     * @return int
     */
    public static function updateBy($conditions, array $data, string $mapKey = 'id'): int
    {
        $conditions = is_array($conditions) ? $conditions : [$mapKey => $conditions];
        return self::query()->where($conditions)->update($data);
    }
}
