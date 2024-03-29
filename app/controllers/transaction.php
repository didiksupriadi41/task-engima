<?php namespace controllers;

class Transaction extends \core\Controller
{
    private $auth;
    private $data;

    public function __construct()
    {
        $this->auth = new \core\Auth;
    }

    public function index()
    {
        $this->auth->checkAuthenticated();
        $idUser = $this->auth->getUserId();
        // $books = $this->model('BookModel')->getAllBook();
        $this->data = [
            "title" => "Transaction / Engima",
            // "books" => $books,
            "userId" => $idUser,
            "js" => "js/transaction.js"
        ];
        $this->view('partial/header', $this->data);
        $this->view('transaction/index', $this->data);
        $this->view('partial/footer', $this->data);
    }
}
