<?php namespace models;

class LoginModel
{
    private $cookie;
    private $db;
    private $flash;

    public function __construct()
    {
        $this->cookie = new \core\Cookie;
        $this->db = new \core\Database;
        $this->flash = new \core\Flash;
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $queryLogin = "SELECT * FROM User 
        WHERE email = :email AND password = :password";
        $this->db->query($queryLogin);
        $this->db->bind('email', $email);
        $this->db->bind('password', $password);

        try {
            $data = $this->db->resultSet();
            if (count($data) != 1) {
                $this->flash->danger("Email and/or Password don't match");
                return false;
            }
        } catch (Exception $e) {
            $this->flash->danger("Something Error occurred while login");
            return false;
        }

        $cookie = time() . "#" . rand(1000, 9999);
        $queryCookie = "INSERT INTO Cookie (value, idUser, expiredDate)
        VALUES (:cookie, :user, :expiredDate)";
        $this->db->query($queryCookie);
        $this->db->bind('cookie', $cookie);
        $this->db->bind('user', $data[0]["idUser"]);

        date_default_timezone_set('Asia/Jakarta');
        $expiredDate = date("Y-m-d H:i:s", strtotime("+1 day"));
        $this->db->bind('expiredDate', $expiredDate);
        
        try {
            $this->db->execute();
            $this->cookie->put('engima', $cookie, 100000000);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
