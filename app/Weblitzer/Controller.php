<?php

namespace App\Weblitzer;


/**
 *
 */
class Controller
{
    private $viewPath;

    private $layout = 'layout';

    protected function render($viewer,$variable = []){
        $view = new View();
        ob_start();
        extract($variable);
        require $this->getViewPath().str_replace('.','/',$viewer).'.php';
        $content = ob_get_clean();
        require $this->getViewPath().'layout/'.$this->layout.'.php';
        die();
    }

    private function getViewPath()
    {
        $config = new Config();
        return $_SERVER['DOCUMENT_ROOT'] . $config->get('directory') . 'view/';
    }

    protected function Abort403()
    {
        header('HTTP/1.0 403 Forbidden');
        $this->redirect('index.php?page=403');
    }

    protected function Abort404()
    {
        header('HTTP/1.0 404 Not Found');
        $this->redirect('index.php?page=404');
    }

    /**
     * print_r coké
     * @param  mixed $var La variable a déboger
     */
    protected function debug($var)
    {
        echo '<pre style="height:100px;overflow-y: scroll;font-size:.8em;padding: 10px; font-family: Consolas, Monospace; background-color: #000; color: #fff;">';
        print_r($var);
        echo '</pre>';
    }

    /**
     * Retourne une réponse JSON au client
     * @param mixed $data Les données à retourner
     * @return les données au format json
     */
    protected function showJson($data)
    {
        header('Content-type: application/json');
        $json = json_encode($data, JSON_PRETTY_PRINT);
        if($json){
            die($json);
        }
        else {
            die('Error in json encoding');
        }
    }

    protected function cleanXss($post){
        foreach($post as $k=>$v) {
            $post[$k]=trim(strip_tags($v)); //protection 1 XSS
        }
        return $post;
    }

    protected function redirect($url)
    {
        header('Location: '.$url);
        die();
    }

}
