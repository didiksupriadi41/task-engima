<?php namespace controllers;

class Movie extends \core\Controller
{
    private $auth;
    private $redirect;
    private $data;

    public function __construct()
    {
        $this->auth = new \core\Auth;
        $this->redirect = new \core\Redirect;
    }

    public function detail()
    {
        $this->auth->checkAuthenticated();

        $id = $_GET["id"];
        $movie = $this->model('MovieModel')->getSingleMovie($id);
        $rating = $this->model('RatingModel')->getRatingByIdMovie($id);
        // $schedule = $this->model('MovieModel')->getMovieSchedule($id);
        $schedule = [];
        $review = $this->model('MovieModel')->getMovieReview($id);
        // $videoKey = $this->model('VideoModel')->getTrailerByID($id);

        if (empty($movie)) {
            $this->redirect->to(BASEURL);
        } else {
            $movie["ratingUSER"] = $rating;
            $this->data = [
                "title" => "Film Detail / Engima",
                "movie" => $movie,
                "schedule" => $schedule,
                "review" => $review,
                // "key" => $videoKey,
            ];
            
            $this->view('partial/header', $this->data);
            $this->view('detail/index', $this->data);
            $this->view('partial/footer');
        }
    }

    public function buy()
    {
        $this->auth->checkAuthenticated();
        if ($this->model('ScheduleModel')->isScheduleExist()) {
            $schedule = $this->model('ScheduleModel')->getScheduleByID();

            date_default_timezone_set('Asia/Jakarta');
            if ($schedule["seatsLeft"] == 0 || strtotime($schedule["dateTime"]) < time()) {
                $this->redirect->to(BASEURL);
            } else {
                $booked_seat = $this->model('BookModel')->getDisabledSeat();
                $disabled_seat = [];
                foreach ($booked_seat as $seat) {
                    array_push($disabled_seat, $seat["seat"]);
                }
                $idUser = $this->auth->getUserId();
                $data["schedule"] = $schedule;
                $data["disabled_seat"] = $disabled_seat;
                $data['title'] = 'Buy ' . $schedule["title"] . ' Ticket / Engima';
                $data['idUser'] = $idUser;
                $data['js'] = 'js/buy.js';
                $this->view('partial/header', $data);
                $this->view('buy/index', $data);
                $this->view('partial/footer', $data);
            }
        } else {
            $this->redirect->to(BASEURL);
        }
    }

    public function search()
    {
        $this->auth->checkAuthenticated();
        $keyword = $_GET['q'];
        $page = 1;
        if (array_key_exists("page", $_GET)) {
            $page = $_GET['page'];
        }
        $movie_limit = 3;
        $search = $this->model('MovieModel')->searchMovie($keyword, $page);
        // $count = $this->model('MovieModel')->countSearchMovie($keyword);
        // $pageCount = ceil((int) $count / $movie_limit);

        $this->data = [
            "title" => "Search / Engima",
            "keyword" => $keyword,
            "movie" => $search["movies"],
            "count" => $search["count"],
            "page" => $page,
            "pageCount" => $search["pageCount"],
            "js" => "js/search.js"
        ];
        // var_dump($search);
        $this->view('partial/header', $this->data);
        $this->view('search/index', $this->data);
        $this->view('partial/footer', $this->data);
    }
}
