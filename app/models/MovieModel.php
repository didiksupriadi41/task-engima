<?php namespace models;

class MovieModel
{
    private $db;

    public function __construct()
    {
        $this->db = new \core\Database;
    }

    public function getPlayingMovie()
    {
        $query = 'SELECT DISTINCT(idMovie), poster, title, rating
        FROM Movie NATURAL JOIN Schedule
        WHERE Schedule.dateTime BETWEEN :timeNow AND :timeThen';

        date_default_timezone_set('Asia/Jakarta');
        $timeNow = date('Y-m-d H:i:s');
        $timeLater = date("Y-m-d H:i:s", strtotime("tomorrow"));

        $this->db->query($query);
        $this->db->bind('timeNow', $timeNow);
        $this->db->bind('timeThen', $timeLater);

        $result = $this->db->resultSet();
        return $result;
    }

    public function getSingleMovie($idMovie)
    {
        $query = "SELECT * 
        FROM Movie 
        WHERE Movie.idMovie = :id";
        $this->db->query($query);
        $this->db->bind("id", $idMovie);
        $result = $this->db->resultSet();
        $data[0] = $result[0];

        return $data;
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
