<?php

namespace App\Weblitzer;
use App\App;
/**
 *
 */
class Model
{
    protected static $table;
    private $key;

    /**
     * @return $table
     */
    protected static function getTable()
    {
        return static::$table;
    }

    /**
     * @return array => all
     */
    public static function all()
    {
        return App::getDatabase()->query("SELECT * FROM ".self::getTable(),get_called_class());
    }

    public static function findById($id,$columId = 'id')
    {
        return App::getDatabase()->prepare("SELECT * FROM " . self::getTable() . " WHERE ".$columId." = ?",[$id],get_called_class(),true);
    }

    public static function findByColumn($column,$value)
    {
        return App::getDatabase()->prepare("SELECT * FROM " . self::getTable() . " WHERE ".$column." = ?",[$value],get_called_class(),true);
    }

    public static function count(){
        return App::getDatabase()->aggregation("SELECT COUNT(id) FROM " . self::getTable());
    }

    public static function delete($id,$columId = 'id')
    {
        return App::getDatabase()->prepareInsert("DELETE FROM " . self::getTable() . " WHERE ".$columId." = ?",[$id],get_called_class(),true);
    }

    public function __get($key)
    {
        $method = 'get'.ucfirst($key);
        $this->key = $this->$method();
        return $this->key;
    }


}
