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
            // echo "cURL Error #:" . $err;
            return [];
        } else {
            $movie = [
                "idMovie" => $response["id"],
                "title" => $response["original_title"],
                "description" => $response["overview"],
                "duration" => $response["runtime"],
                "release" => $response["release_date"],
                "rating" => $response["vote_average"],
                "poster" => "https://image.tmdb.org/t/p/original" . $response["poster_path"],
                "category" => $response["genres"],
            ];
            return $movie;
        }
    }

    public function getPlayingMovie($page)
    {
        date_default_timezone_set('Asia/Jakarta');
        $timeNow = date('Y-m-d', strtotime("-7 day"));
        $timeLater = date('Y-m-d');

        $curl = curl_init();
        $url = "https://api.themoviedb.org/3/discover/movie?primary_release_date.lte="
            . "$timeLater&primary_release_date.gte="
            . "$timeNow&page=$page&include_video=false&include_adult=false&sort_by=popularity.desc"
            . "&language=en-US&region=US&vote_count.gte=1&api_key=".API_KEY;
            
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
            // echo "cURL Error #:" . $err;
            return [];
        } else {
            $results = $response["results"];
            $return = [];
            $movies = [];
            foreach ($results as $movie) {
                if (is_null($movie["poster_path"])) {
                    $poster_url = null;
                } else {
                    $poster_url = "https://image.tmdb.org/t/p/original" . $movie["poster_path"];
                }
                $detail = [
                    "idMovie" => $movie["id"],
                    "title" => $movie["original_title"],
                    "rating" => $movie["vote_average"],
                    "poster" => $poster_url,
                ];
                $movies[] = $detail;
            }
            $return[] = $movies;
            $return[] = $response["total_pages"];
            return $return;
        }
    }

    public function getMovieCategory($idMovie)
    {
        $query = "SELECT * 
        FROM (Movie NATURAL JOIN MovieCategory) NATURAL JOIN Category 
        WHERE Movie.idMovie = :id";
        $this->db->query($query);
        $this->db->bind("id", $idMovie);
        $data = $this->db->resultSet();

        return $data;
    }

    public function getMovieSchedule($idMovie)
    {
        $query = "SELECT * 
        FROM Movie NATURAL JOIN Schedule 
        WHERE Movie.idMovie = :id
        ORDER BY Schedule.dateTime";
        $this->db->query($query);
        $this->db->bind("id", $idMovie);
        $data = $this->db->resultSet();

        return $data;
    }

    public function getMovieReview($idMovie)
    {
        $queryReview = "SELECT * 
        FROM Movie NATURAL JOIN ((Review NATURAL JOIN Book) NATURAL JOIN User) 
        WHERE Movie.idMovie = :id";
        $this->db->query($queryReview);
        $this->db->bind("id", $idMovie);
        $data = $this->db->resultSet();

        return $data;
    }

    public function updateRating()
    {
        $idMovie = $_GET["movie-id"];

        $queryRating = "SELECT avg(value) AS 'rating'
        FROM Review
        WHERE idMovie = :idMovie";

        $this->db->query($queryRating);
        $this->db->bind('idMovie', $idMovie);
        $data = $this->db->resultSet();
        $rating = $data[0]["rating"];

        $queryUpdate = "UPDATE Movie
        SET rating = :rating
        WHERE idMovie = :idMovie";
        
        $this->db->query($queryUpdate);
        $this->db->bind('rating', $rating);
        $this->db->bind('idMovie', $idMovie);
        
        try {
            $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    
        return true;
    }

    public function searchMovie($keyword, $page)
    {
        $movie_limit = 3;
        $query = "SELECT * 
        FROM Movie 
        WHERE title LIKE :key 
        LIMIT :start, :limit";
        $this->db->query($query);
        $this->db->bind("key", "%$keyword%");
        $this->db->bind("limit", $movie_limit);
        $this->db->bind("start", $movie_limit * ((int) $page - 1));

        $data = $this->db->resultSet();

        return $data;
    }

    public function countSearchMovie($keyword)
    {
        $query = "SELECT COUNT(*) AS count 
        FROM Movie 
        WHERE title LIKE :key";
        $this->db->query($query);
        $this->db->bind("key", "%$keyword%");
        $data = $this->db->resultSet();

        return $data[0]["count"];
    }
}
