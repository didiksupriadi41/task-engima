<?php namespace models;

class RatingModel
{
    private $db;
    private $auth;
  
    public function __construct()
    {
        $this->db = new \core\Database;
        $this->auth = new \core\Auth;
    }

    public function getRatingByIdBook($idBook)
    {
        $query = "SELECT idReview, value, text 
        FROM Review
        WHERE idBook = :idBook";

        $this->db->query($query);
        $this->db->bind('idBook', $idBook);

        $data = $this->db->resultSet();
        return $data[0];
    }

    public function getRatingByIdMovie($idMovie)
    {
        
        $query = "SELECT avg(value) as rating FROM Review WHERE idMovie = :idMovie GROUP BY idMovie";

        $this->db->query($query);
        $this->db->bind('idMovie', $idMovie);

        $data = $this->db->resultSet();
        return empty($data) ? 0 : round($data[0]["rating"], 2);
    }

    private function updateIsRate($idTransaksi, $isRate)
    {
        $url = 'http://34.227.112.253:3000/rate';
        $data = array('idTransaksi' => $idTransaksi, 'val' => $isRate);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            error_log(print_r($result, true));
        }
    }

    public function insert()
    {
        $idBook = $_GET["book-id"];
        $idMovie = $_GET["movie-id"];
        $idUser = $this->auth->getUserId();
        $query = "SELECT *
        FROM Review
        WHERE idUser = :idUser AND idBook = :idBook
        AND idMovie = :idMovie";

        $this->db->query($query);
        $this->db->bind('idUser', (int) $idUser);
        $this->db->bind('idBook', (int) $idBook);
        $this->db->bind('idMovie', (int) $idMovie);
        $data = $this->db->resultSet();

        if (count($data)!=0) {
            return false;
        }

        $query = "INSERT INTO Review
        (idMovie, idBook, idUser, value, text)
        VALUES (:idMovie, :idBook, :idUser, :value, :text)";

        $this->db->query($query);
        $this->db->bind('idMovie', $idMovie);
        $this->db->bind('idBook', $idBook);
        $this->db->bind('idUser', (int) $idUser);
        $this->db->bind('value', $_POST["value"]);
        $this->db->bind('text', $_POST["review"]);
        $data = $this->db->execute();

        $this->updateIsRate($idBook, 1);

        return true;
    }

    public function update()
    {
        $idReview = $_GET["review-id"];
        $idUser = $this->auth->getUserId();
        $query = "SELECT *
        FROM Review
        WHERE idReview = :idReview 
        AND idUser = :idUser";

        $this->db->query($query);
        $this->db->bind('idReview', (int) $idReview);
        $this->db->bind('idUser', (int) $idUser);
        $data = $this->db->resultSet();

        if (count($data) != 1) {
            return false;
        }

        $query = "UPDATE Review
        SET value = :value, text = :text 
        WHERE idReview = :idReview";

        $this->db->query($query);
        $this->db->bind('value', $_POST["value"]);
        $this->db->bind('text', $_POST["review"]);
        $this->db->bind('idReview', $idReview);
        try {
            $data = $this->db->execute();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function delete()
    {
    
        $idBook = (int) $_GET["book-id"];
        $idUser = (int) $this->auth->getUserId();

        $query = "SELECT idReview
        FROM Review
        WHERE idUser = :idUser
        AND idBook = :idBook";

        $this->db->query($query);
        $this->db->bind('idBook', $idBook);
        $this->db->bind('idUser', $idUser);

        try {
            $data = $this->db->resultSet();
            if (count($data) == 0) {
                return false;
            } else {
                $idReview = $data[0]["idReview"];
            }
        } catch (Exception $e) {
            return false;
        }

        $query = "DELETE FROM Review
            WHERE idReview = :idReview";

        $this->db->query($query);
        $this->db->bind('idReview', $idReview);

        try {
            $this->db->execute();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
