<?php namespace controllers;

class Login extends \core\Controller
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('LoginModel')->login()) {
                $this->redirect->to(BASEURL);
            } else {
                $this->redirect->to(BASEURL. "login");
            }
        } else {
            $this->auth->checkUnauthenticated();
            $this->view('login/index');
        }
    }
}
