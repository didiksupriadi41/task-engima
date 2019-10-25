<?php namespace models;

class BookModel
{
    private $db;
    private $auth;

    public function __construct()
    {
        $this->db = new \core\Database;
        $this->auth = new \core\Auth;
    }

    public function getAllBook()
    {
        $idUser = $this->auth->getUserId();
        $query = "SELECT idBook, poster, title, dateTime, isRate, Schedule.idMovie 
        FROM (Book NATURAL JOIN Schedule ) NATURAL JOIN Movie
        WHERE Book.idUser = :idUser
        ORDER BY dateTime DESC";
        $this->db->query($query);
        $this->db->bind('idUser', (int) $idUser);
        $data = $this->db->resultSet();
        return $data;
    }

    public function getBookById()
    {
        $id = $_GET["book-id"];
        $query = "SELECT idUser, idBook, Schedule.idMovie, poster, title, dateTime, isRate 
        FROM (Book NATURAL JOIN Schedule ) NATURAL JOIN Movie
        WHERE idBook = :id
        ORDER BY dateTime DESC";
        $this->db->query($query);
        $this->db->bind('id', (int) $id);
        $data = $this->db->resultSet();

        return $data[0];
    }

    public function getDisabledSeat()
    {

        $schedule_id = $_GET['schedule-id'];

        $query = "SELECT seat FROM Book
        WHERE idSchedule = :schedule_id";

        $this->db->query($query);
        $this->db->bind('schedule_id', $schedule_id);

        $data = $this->db->resultSet();

        return $data;
    }

    public function insertSeat()
    {
        $user_id = $this->auth->getUserId();
        $schedule_id = $_POST["schedule-id"];
        $seat_number = $_POST["seat-number"];
        $query = "SELECT * FROM Book 
        WHERE idSchedule = :schedule_id 
        AND seat = :seat";

        $this->db->query($query);
        $this->db->bind('schedule_id', $schedule_id);
        $this->db->bind('seat', $seat_number);

        $data = $this->db->resultSet();
        $seat = $this->reduceSeatLeft($schedule_id);
        if (count($data) == 0 && $seat) {
            $query = "INSERT INTO Book (idUser, idSchedule,seat)
            VALUE(:user_id,:schedule_id,:seat)";

            $this->db->query($query);
            $this->db->bind('user_id', $user_id);
            $this->db->bind('schedule_id', $schedule_id);
            $this->db->bind('seat', $seat_number);

            try {
                $this->db->execute();
                return true;
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return false;
        }
    }

    private function reduceSeatLeft($schedule_id)
    {
        $query = "UPDATE Schedule 
        SET seatsLeft = seatsLeft - 1 
        WHERE idSchedule = :schedule_id";

        $this->db->query($query);
        $this->db->bind('schedule_id', $schedule_id);

        try {
            $this->db->execute();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
