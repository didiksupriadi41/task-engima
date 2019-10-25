<?php namespace controllers;

class Register extends \core\Controller
{
    private $auth;
    private $redirect;

    public function __construct()
    {
        $this->auth = new \core\Auth;
        $this->redirect = new \core\Redirect;
    }

    public function index()
    {
        $this->auth->checkUnauthenticated();
        $this->view('register/index');
    }


    public function insert()
    {
        if ($this->model('RegisterModel')->register()) {
            $this->redirect->to(BASEURL);
        }
        $this->redirect->to(BASEURL. "register");
    }
}
