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
        $movie = $this->model('MovieModel')->getPlayingMovie();
        
        $data['title'] = 'Home / Engima';
        $data['username'] = $this->model('HomeModel')->getUsername();
        $data['movie'] = $movie;
        $this->view('partial/header', $data);
        $this->view('home/index', $data);
        $this->view('partial/footer');
    }
}
