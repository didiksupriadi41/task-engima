<?php namespace controllers;

class Home extends \core\Controller
{
    private $redirect;
    private $auth;

    public function __construct()
    {
        $this->redirect = new \core\Redirect;
        $this->auth = new \core\Auth;
    }

    public function index()
    {
        error_log("home");
        $this->auth->checkAuthenticated();
        $page = 1;
        if (array_key_exists("page", $_GET)) {
            $page = $_GET['page'];
        }
        $movie = $this->model('MovieModel')->getPlayingMovie($page);
        if (sizeof($movie['movies'])) {
            $data = [
                "title" => 'Home / Engima',
                "username" => $this->model('HomeModel')->getUsername(),
                "movie" => $movie["movies"],
            "page" => $page,
            "pageCount" => $movie["pageCount"],
            "js" => "js/home.js",
            ];
            $this->view('partial/header', $data);
            $this->view('home/index', $data);
            $this->view('partial/footer', $data);
        } else {
            $this->redirect->to(BASEURL);
        }
    }
}
