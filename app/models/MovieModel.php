<?php namespace models;

class MovieModel
{
    private $db;

    public function __construct()
    {
        $this->db = new \core\Database;
    }

    public function getSingleMovie($id)
    {
        $curl = curl_init();
        $url = "https://api.themoviedb.org/3/movie/$id?language=en-US&api_key=".API_KEY;
            
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            error_log("cURL Error #:" . $err);
            return [];
        } elseif (isset($response["status_code"])) {
            return [];
        } else {
            if (is_null($response["poster_path"])) {
                $poster_url = null;
            } else {
                $poster_url = "https://image.tmdb.org/t/p/w300_and_h450_bestv2" . $response["poster_path"];
            }
            $movie = [
                "idMovie" => $response["id"],
                "title" => $response["original_title"],
                "description" => $response["overview"],
                "duration" => $response["runtime"],
                "release" => $response["release_date"],
                "ratingDB" => $response["vote_average"],
                "ratingUSER" => 0,
                "poster" => $poster_url,
                "category" => $response["genres"],
            ];
            return $movie;
        }
    }

    public function getPlayingMovie($page)
    {
        date_default_timezone_set('Asia/Jakarta');
        $timeNow = date('Y-m-d', strtotime("-7 day midnight"));
        $timeLater = date('Y-m-d');

        $curl = curl_init();
        $url = "https://api.themoviedb.org/3/discover/movie?primary_release_date.lte="
            . "$timeLater&primary_release_date.gte="
            . "$timeNow&page=$page&include_video=false&include_adult=false&sort_by=popularity.desc"
            . "&vote_count.gte=1&api_key=".API_KEY;
            
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        $movies = [];
        $return = [];

        if (!$err) {
            $results = $response["results"];
            foreach ($results as $movie) {
                if (is_null($movie["poster_path"])) {
                    $poster_url = null;
                } else {
                    $poster_url = "https://image.tmdb.org/t/p/w300_and_h450_bestv2" . $movie["poster_path"];
                }
                $detail = [
                    "idMovie" => $movie["id"],
                    "title" => $movie["original_title"],
                    "rating" => $movie["vote_average"],
                    "poster" => $poster_url,
                ];
                $movies[] = $detail;
            }
        }
        $return["movies"] = $movies;
        $return["pageCount"] = $response["total_pages"];
        return $return;
    }

    public function addMoviewSchedule($movie, $offset, $time)
    {
        $query = "
        INSERT INTO Schedule (idMovie, dateTime, seatsLeft) 
        SELECT * FROM (select :idMovie as idMovie, :dateTime,
            30 as seatsLeft) AS tmp
        WHERE NOT EXISTS (
            SELECT idSchedule FROM Schedule 
            WHERE idMovie = :idMovie AND dateTime like :likeDate
        ) limit 1";

        $likeDate = date('Y-m-d', strtotime($movie["release"] . "+$offset day"));
        $dateTime = date('Y-m-d H:i:s', strtotime($movie["release"] . $time . "+$offset day"));

        $this->db->query($query);
        $this->db->bind("idMovie", $movie["idMovie"]);
        $this->db->bind("dateTime", $dateTime);
        $this->db->bind("likeDate", "$likeDate%");

        try {
            $this->db->execute();
        } catch (Exception $e) {
            error_log(e);
            return false;
        }
    
        return true;
    }

    public function getMovieSchedule($movie)
    {
        $max_movie_number = 7;
        for ($day=1; $day <= $max_movie_number; $day++) {
                $time = mt_rand(0, 23) . ":" . mt_rand(0, 59) . ":" . mt_rand(0, 59) ;
            if (!$this->addMoviewSchedule($movie, $day, $time)) {
                break;
            }
        }

        $query = "SELECT *
        FROM Schedule
        WHERE idMovie = :idMovie
        ORDER BY dateTime";
        $this->db->query($query);
        $this->db->bind("idMovie", $movie["idMovie"]);
        $data = $this->db->resultSet();

        return $data;
    }

    public function getMovieReview($idMovie)
    {
        $queryReview = "SELECT * 
        FROM Review NATURAL JOIN User 
        WHERE idMovie = :id";
        $this->db->query($queryReview);
        $this->db->bind("id", $idMovie);
        $data = $this->db->resultSet();

        return $data;
    }

    // public function updateRating()
    // {
    //     $idMovie = $_GET["movie-id"];

    //     $queryRating = "SELECT avg(value) AS 'rating'
    //     FROM Review
    //     WHERE idMovie = :idMovie";

    //     $this->db->query($queryRating);
    //     $this->db->bind('idMovie', $idMovie);
    //     $data = $this->db->resultSet();
    //     $rating = $data[0]["rating"];

    //     $queryUpdate = "UPDATE Movie
    //     SET rating = :rating
    //     WHERE idMovie = :idMovie";
        
    //     $this->db->query($queryUpdate);
    //     $this->db->bind('rating', $rating);
    //     $this->db->bind('idMovie', $idMovie);
        
    //     try {
    //         $this->db->execute();
    //     } catch (Exception $e) {
    //         return false;
    //     }
    
    //     return true;
    // }

    public function searchMovie($keyword, $page)
    {
        $curl = curl_init();
        $url = "https://api.themoviedb.org/3/search/movie?page=$page"
            . "&include_adult=false&query=$keyword"
            . "&language=en-US&api_key=".API_KEY;
            
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        $return = [];
        $movies = [];
        $return["count"] = 0;
        $return["pageCount"] = 0;

        if (!$err && !isset($response["errors"])) {
            $return["count"] = $response["total_results"];
            $return["pageCount"] = $response["total_pages"];
            $results = $response["results"];
            foreach ($results as $movie) {
                if (is_null($movie["poster_path"])) {
                    $poster_url = null;
                } else {
                    $poster_url = "https://image.tmdb.org/t/p/w300_and_h450_bestv2" . $movie["poster_path"];
                }
                $detail = [
                    "idMovie" => $movie["id"],
                    "title" => $movie["original_title"],
                    "description" => $movie["overview"],
                    "rating" => $movie["vote_average"],
                    "poster" => $poster_url,
                ];
                $movies[] = $detail;
            }
        }
        $return["movies"] = $movies;
        return $return;
    }
}
