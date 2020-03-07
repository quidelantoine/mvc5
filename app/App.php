<?php

namespace App;

use App\Weblitzer\Database;
use App\Weblitzer\Config;

/**
 *
 */
class App
{

    private static $_instance;
    private static $database;

    private static $dbName;
    private static $bdUser;
    private static $bdPass;
    private static $bdHost;


    public function __construct()
    {
        $config = new Config();
        self::$dbName = $config->get('db_name');
        self::$bdUser = $config->get('db_user');
        self::$bdPass = $config->get('db_pass');
        self::$bdHost = $config->get('db_host');

    }

    public static function getInstance()
    {
        if(is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * @param $name
     * il faut tjrs nommé votre Model comme votre table => UsersModel si nom de la table est "users"
     * @return mixed
     */
    public static function getTable($name)
    {
        $className = '\\App\\Model\\'.ucfirst($name).'Model';
        return new $className();
    }

    /**
     * @return Database
     */
    public static function getDatabase()
    {
        if(self::$database === null) {
            self::$database = new Database(self::$dbName,self::$bdUser,self::$bdPass,self::$bdHost);
        }
        return self::$database;
    }

}
