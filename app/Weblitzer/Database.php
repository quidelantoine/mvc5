<?php
namespace App\Weblitzer;
use \PDO;

/**
 * Class Autoloader
 * @package Tutoriel
 */
class Database {


    private $bd_name;
    private $bd_user;
    private $bd_pass;
    private $bd_host;

    private $pdo;


    public function __construct($bd_name,$bd_user = 'root',$bd_pass = 'root',$bd_host="localhost")
    {
        if(!empty($bd_name)) {
            $this->bd_name = $bd_name;
        } else {
            $config = new Config();
            $this->bd_name = $config->get('db_name');
        }

        $this->bd_user = $bd_user;
        $this->bd_pass = $bd_pass;
        $this->bd_host = $bd_host;
    }

    private function getPdo()
    {
        if($this->pdo === null) {
            try {
                $pdo = new PDO('mysql:host='.$this->bd_host.';dbname='.$this->bd_name, $this->bd_user, $this->bd_pass, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                ));
            }
            catch (PDOException $e) {
                echo 'Erreur de connexion : ' . $e->getMessage();
            }
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query($sql,$className)
    {
        $query = $this->getPdo()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_CLASS,$className);
    }

    public function aggregation($sql)
    {
        $query = $this->getPdo()->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

    public function prepare($sql,$bind,$className,$one = false)
    {
        $query = $this->getPdo()->prepare($sql);

        $query->execute($bind);

        $query->setFetchMode(PDO::FETCH_CLASS,$className);
        if($one) {
            return $query->fetch();
        } else {
            return $query->fetchAll();
        }
    }

    public function prepareInsert($sql,$bind)
    {
        $query = $this->getPdo()->prepare($sql);
        $query->execute($bind);
    }


}
