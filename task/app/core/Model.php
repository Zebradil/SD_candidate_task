<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 22:43
 * To change this template use File | Settings | File Templates.
 */

class Model{
    protected static $_table = NULL;
    protected static $_attrs = array();
    protected static $_public_attrs = array();

    protected $id = NULL;

    public static function getPrepareParams($params){
        $prepare = array_reduce(array_keys($params), function ($result, $item){
            $result[] = "`$item`=:$item";
            return $result;
        }, array());
        return implode(',', $prepare);
    }

    public function save($params = []){
        if(empty(static::$_table))
            return FALSE;
        else
            $table = static::$_table;
        if(is_array($params))
            $this->applyParams($params);
        $attrs   = get_object_vars($this);
        $id      = $attrs['id'];
        $params  = static::filterPublicParams($attrs);
        $prepare = static::getPrepareParams($params);
        return (bool)DB::getInstance()
            ->prepare("update $table set $prepare where `id`='$id'")
            ->execute($params);
    }

    public static function filterPublicParams($params){
        return array_intersect_key($params, array_flip(static::$_public_attrs));
    }

    public static function filterAllParams($params){
        return array_intersect_key($params, array_flip(static::$_attrs));
    }

    public function applyParams($params){
        $params = static::filterPublicParams($params);
        foreach($params as $k => $p)
            $this->{$k} = $p;
        return $this;
    }

    /**
     * @param $params
     *
     * @return static
     */
    public static function create($params){
        if(empty(static::$_table))
            return NULL;
        else
            $table = static::$_table;
        $params  = static::filterAllParams($params);
        $prepare = static::getPrepareParams($params);
        $dbi     = DB::getInstance();
        $dbi->prepare("insert into `$table` set $prepare")
            ->execute($params);
        return static::find($dbi->lastInsertId());
    }

    /**
     * @param array $conditions
     *
     * @return static[]
     */
    public static function all($conditions = []){
        if(empty(static::$_table))
            return NULL;
        else
            $table = static::$_table;
        if(count($conditions))
            $prepare = static::getPrepareParams($conditions);
        else
            $prepare = '1';
        $sti = DB::getInstance()
            ->prepare("SELECT * FROM `$table` WHERE $prepare");
        $sti->execute($conditions);
        return $sti->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    /**
     * @param array $conditions
     *
     * @return static|null
     */
    public static function first($conditions = []){
        return static::all($conditions)[0];
    }

    /**
     * @param $id
     *
     * @return static|null
     */
    public static function find($id){
        return static::first(array('id' => $id));
    }

    public function remove(){
        if(empty(static::$_table) || empty($this->id))
            return FALSE;
        else
            $table = static::$_table;
        return (bool)DB::getInstance()->exec("delete from `$table` where `id`='{$this->id}'");
    }

    public static function delete($id){
        /** @var $obj self */
        $obj = static::find($id);
        if($obj)
            return $obj->remove();
        return FALSE;
    }

    public function asJson(){
        return get_object_vars($this);
    }
}