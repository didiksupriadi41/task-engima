<?php namespace controllers;

class Api extends \core\Controller
{

    public function validate()
    {
        $data = new \stdClass();
        $data->status = 200;
        if ($this->model('RegisterModel')->validate()) {
            $data->result = true;
        } else {
            $data->result = false;
        }
        $response = json_encode($data);
        echo $response;
    }

    // public function book()
    // {
    //     $data = new \stdClass();
    //     $data->status = 200;

    //     $data->result = $this->model('BookModel')->insertSeat();
    //     $response = json_encode($data);
    //     echo $response;
    // }
    public function reduceSeat()
    {
        $data = new \stdClass();
        $data->status = 200;
        $data->result = $this->model('BookModel')->reduceSeatLeft($_POST['schedule-id']);
        echo json_encode($data);
    }

    public function search()
    {
        $keyword = $_GET['q'];
        $page = 1;
        if (array_key_exists("page", $_GET)) {
            $page = $_GET['page'];
        }
        $arrMovie = $this->model('MovieModel')->searchMovie($keyword, $page);

        echo json_encode($arrMovie["movies"]);
    }

    // public function chairCheck()
    // {
    //     $data = new \stdClass();
    //     $data->status = 200;

    //     $data->data = $this->model('BookModel')->getDisabledSeat();
    //     $response = json_encode($data);
    //     echo $response;
    // }

    public function deleteReview()
    {
        $auth = new \core\Auth;
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $auth->checkAuthenticated();
            $data = new \stdClass();
            $data->status = 200;
            if ($this->model('RatingModel')->delete()) {
                $this->model('MovieModel')->updateRating();
                $data->result = true;
            } else {
                $data->result = false;
            }
        }
        
        $response = json_encode($data);
        echo $response;
    }

    public function home()
    {
        $page = 1;
        if (array_key_exists("page", $_GET)) {
            $page = $_GET['page'];
        }

        $arrMovie = $this->model('MovieModel')->getPlayingMovie($page);

        echo json_encode($arrMovie["movies"]);
    }
}
