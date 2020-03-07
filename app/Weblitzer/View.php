<?php
namespace App\Weblitzer;
/**
 *  class View
 *  Helper pour les view
 */
class View
{
    /**
     * @param $link
     * @param $id null
     * @return $data
     */
    public function path($link,$tabs = array())
    {
        if(empty($tabs)) {
            $data = $this->urlBase().$link;
        } else {
            $linkarg = '';
            foreach($tabs as $tab){
                $linkarg .= $tab.'/';
            }
            $data = $this->urlBase().$link.'/'.$linkarg;
        }
        return $data;
    }

    public function urlBase()
    {
        $config = new Config();
        $directory = $config->get('directory').'public/';
        return 'http://'.$_SERVER['HTTP_HOST'] .$directory;
    }

    public function asset($file)
    {
        return $this->urlBase(). 'asset/'.$file;
    }

}
