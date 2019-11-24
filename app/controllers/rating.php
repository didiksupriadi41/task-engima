<?php namespace controllers;

class Rating extends \core\Controller
{
    private $auth;
    private $redirect;
    private $data;

    public function __construct()
    {
        $this->auth = new \core\Auth;
        $this->redirect = new \core\Redirect;
    }

    public function new()
    {
        $this->auth->checkAuthenticated();
        $idBook = $_GET["book-id"];
        $idMovie = $_GET['movie-id'];
        $book = $this->model('BookModel')->getBookById();
        $movie = $this->model('MovieModel')->getSingleMovie($idMovie);
        if (count($book)!=0) {
            $this->redirect->to(BASEURL."transaction");
        }
        $this->data = [
            "title" => "Add Rating / Engima",
            "js" => 'js/rating.js',
            // "book" => $book,
            "idBook" => $idBook,
            "movie" => $movie
        ];
        
        $this->view('partial/header', $this->data);
        $this->view('rating/new', $this->data);
        $this->view('partial/footer', $this->data);
    }

    public function edit()
    {
        $this->auth->checkAuthenticated();
        $idUser = $this->auth->getUserId();
        // $idBook = $_GET["book-id"];
        $review = $this->model('BookModel')->getBookById();
        $movie = $this->model('MovieModel')->getSingleMovie($review["idMovie"]);
        if (count($review) != 0) {
            if ($review["idUser"] != $idUser) {
                $this->redirect->to(BASEURL. "transaction");
            }
        } else {
            $this->redirect->to(BASEURL. "transaction");
        }
        
        // $rating = $this->model('RatingModel')->getRatingByIdBook($idBook);
        $this->data = [
            "title" => "Edit Rating / Engima",
            "js" => 'js/rating.js',
            "review" => $review,
            "movie" => $movie
            // "rating" => $rating
        ];
        $this->view('partial/header', $this->data);
        $this->view('rating/edit', $this->data);
        $this->view('partial/footer', $this->data);
    }

    public function insert()
    {
        $this->auth->checkAuthenticated();
        if ($this->model('RatingModel')->insert()) {
            // $this->model('MovieModel')->updateRating();
            $this->redirect->to(BASEURL. "transaction");
        } else {
            $this->redirect->to(BASEURL. "transaction");
        }
    }

    public function update()
    {
        $this->auth->checkAuthenticated();
        if ($this->model('RatingModel')->update()) {
            // $this->model('MovieModel')->updateRating();
            $this->redirect->to(BASEURL. "transaction");
        } else {
            $this->redirect->to(BASEURL. "transaction");
        }
    }
}
