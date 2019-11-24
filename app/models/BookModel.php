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

    public function getBookById()
    {
        $idBooking = $_GET["book-id"];
        $query = "SELECT * 
        FROM Review 
        WHERE idBook = :idBook";
        $this->db->query($query);
        $this->db->bind('idBook', $idBooking);
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

    public function getSeatLeft($schedule_id_arr)
    {
        $url = 'http://34.227.112.253:3000/seat?idSchedule=' . $schedule_id_arr;
        // for ($i=0; $i < count($schedule_id_arr); $i++) {
        //     $url += "idSchedule=" . $schedule_id_arr[$i];
        // }
        // $data = array('idTransaksi' => $idTransaksi, 'val' => $isRate);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                // 'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
                // 'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            error_log(print_r($result, true));
        }

        $response = json_decode($result, true);

        $seats = $response["seats"];

        $arr = array_filter($seats, function ($var) {
            return ($var > 0 && $var <=30);
        });
        $usedSeat = count($arr);

        return (30-$usedSeat);

        // $query = "UPDATE Schedule 
        // SET seatsLeft = :seatLeft 
        // WHERE idSchedule = :schedule_id";
        
        // $this->db->query($query);
        // $this->db->bind('seatLeft', 30 - $usedSeat);
        // $this->db->bind('schedule_id', $schedule_id);
        
        // try {
        //     $this->db->execute();
        //     return true;
        // } catch (\Throwable $th) {
        //         return false;
        // }
    }
}
