<?php  namespace controllers;

class Logout extends \core\Controller
{
    private $auth;
    private $cookie;
    private $redirect;

    public function __construct()
    {
        $this->auth = new \core\Auth;
        $this->cookie = new \core\Cookie;
        $this->redirect = new \core\Redirect;
    }

    public function index()
    {
        $this->cookie->delete('engima');
        $this->redirect->to(BASEURL. 'login');
    }
}
