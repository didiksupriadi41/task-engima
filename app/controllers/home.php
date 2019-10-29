<?php namespace controllers;

class Home extends \core\Controller
{
    private $auth;

    public function __construct()
    {
        $this->auth = new \core\Auth;
    }

    public function index()
    {
        $this->auth->checkAuthenticated();
        $movie = $this->model('MovieModel')->getPlayingMovie(1);
        $data = [
            "title" => 'Home / Engima',
            "username" => $this->model('HomeModel')->getUsername(),
            "movie" => $movie[0],
            "page" => 1,
            "pageCount" => $movie[1],
            "js" => "js/home.js",
        ];
        $this->view('partial/header', $data);
        $this->view('home/index', $data);
        $this->view('partial/footer', $data);
    }
}
