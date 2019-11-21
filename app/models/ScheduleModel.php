<?php namespace models;

class ScheduleModel
{
    private $db;

    public function __construct()
    {
        $this->db = new \core\Database;
    }
    public function getScheduleByID()
    {

        $movie_id = $_GET["movie-id"];
        $schedule_id = $_GET["schedule-id"];
        $query = "SELECT * FROM Schedule 
        WHERE idSchedule = :schedule_id AND idMovie = :movie_id";

        $this->db->query($query);
        $this->db->bind('schedule_id', $schedule_id);
        $this->db->bind('movie_id', $movie_id);

        $data = $this->db->resultSet();

        return $data[0];
    }

    public function isScheduleExist()
    {

        $movie_id = $_GET["movie-id"];
        $schedule_id = $_GET["schedule-id"];
        $query = "SELECT * FROM Schedule 
        WHERE idSchedule = :schedule_id AND idMovie = :movie_id";

        $this->db->query($query);
        $this->db->bind('schedule_id', $schedule_id);
        $this->db->bind('movie_id', $movie_id);

        $data = $this->db->resultSet();

        return $data;
    }
}
