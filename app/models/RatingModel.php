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

    public function insert()
    {
        $idBook = $_GET["book-id"];
        $idMovie = $_GET["movie-id"];
        $idUser = $this->auth->getUserId();
        $query = "SELECT *
        FROM (Book NATURAL JOIN Schedule ) NATURAL JOIN Movie
        WHERE Book.idUser = :idUser AND idBook = :idBook
        AND Schedule.idMovie = :idMovie";

        $this->db->query($query);
        $this->db->bind('idUser', (int) $idUser);
        $this->db->bind('idBook', (int) $idBook);
        $this->db->bind('idMovie', (int) $idMovie);
        $data = $this->db->resultSet();

        if (count($data) != 1) {
            return false;
        }

        $query = "INSERT INTO Review
        (idMovie, idBook, value, text)
        VALUES (:idMovie, :idBook, :value, :text)";

        $this->db->query($query);
        $this->db->bind('idMovie', $idMovie);
        $this->db->bind('idBook', $idBook);
        $this->db->bind('value', $_POST["value"]);
        $this->db->bind('text', $_POST["review"]);
        $data = $this->db->execute();

        $query = "UPDATE Book 
        SET isRate = 1 
        WHERE idBook = :idBook 
        AND idUser = :idUser";

        $this->db->query($query);
        $this->db->bind('idBook', $idBook);
        $this->db->bind('idUser', $idUser);

        try {
            $this->db->execute();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function update()
    {
        $idReview = $_GET["review-id"];
        $idUser = $this->auth->getUserId();
        $query = "SELECT *
        FROM Review NATURAL JOIN Book
        WHERE idReview = :idReview 
        AND Book.idUser = :idUser";

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
        FROM Review NATURAL JOIN Book
        WHERE Book.idUser = :idUser
        AND Book.idBook = :idBook";

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

        $query = "UPDATE Book SET isRate = 0 
        WHERE idBook = :idBook";

        $this->db->query($query);
        $this->db->bind('idBook', $idBook);
        
        try {
            $this->db->execute();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
