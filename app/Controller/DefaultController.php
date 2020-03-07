<?php

namespace App\Controller;

use App\Weblitzer\Controller;

/**
 *
 */
class DefaultController extends Controller
{

    public function index()
    {
        $message = 'Bienvenue sur le framework MVC';

        $this->render('app.default.frontpage',array(
            'message' => $message,
        ));
    }

    /**
     *
     */
    public function Page404()
    {
        $this->render('app.default.404');
    }

}
