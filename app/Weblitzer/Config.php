<?php
namespace App\Weblitzer;
/**
 * SINGLETON permet de recupere une instance sur l'ensemble de l'application est une seule fois
 * m'envoie tjrs la meme instance
 */
class Config
{
    private $settings = array();

    private static $_instance;

    public function __construct()
    {
        $this->settings = require dirname(__DIR__) . '/../config/config.php';
    }

    public static function getInstance()
    {
        // return new Config()
        if(is_null(self::$_instance)) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }

    public function get($key)
    {
        if(!isset($this->settings[$key])){
            return null;
        }
        return $this->settings[$key];
    }


}
