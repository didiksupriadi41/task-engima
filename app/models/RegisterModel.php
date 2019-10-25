<?php namespace models;

class RegisterModel
{
    private $cookie;
    private $db;

    public function __construct()
    {
        $this->cookie = new \core\Cookie;
        $this->db = new \core\Database;
    }

    public function validate()
    {
        $value = $_GET['value'];
        $type = $_GET['type'];
        
        switch ($type) {
            case 'username':
                $query = "SELECT * FROM User WHERE username = :value";
                break;
            case 'phone':
                $query = "SELECT * FROM User WHERE phonenumber = :value";
                break;
            case 'email':
                $query = "SELECT * FROM User WHERE email = :value";
                break;
            default:
                return false;
        }

        $this->db->query($query);
        $this->db->bind('value', $value);
        
        $data = $this->db->resultSet();
        return (count($data) == 1);
    }

    public function register()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $file = $_FILES['file'];
        if ($file["name"] != "") {
            $filename = time()."-".rand(1000, 9999)."-".$file['name'];
            $path = 'upload/'.$filename;
            move_uploaded_file($_FILES['file']['tmp_name'], $path);
        } else {
            $path = 'img/avatar.jpg';
        }

        
        $query = "INSERT INTO User (username, email, phonenumber, password, picture)
        VALUES (:username, :email, :phone, :password, :file)";
        $this->db->query($query);
        $this->db->bind('username', $username);
        $this->db->bind('email', $email);
        $this->db->bind('phone', $phone);
        $this->db->bind('password', $password);
        $this->db->bind('file', $path);
        try {
            $this->db->execute();
            $userId = $this->db->lastInsert();
        } catch (Exception $e) {
            return false;
        }

        $cookie = time() . "#" . rand(1000, 9999);
        $queryCookie = "INSERT INTO Cookie (value, idUser, expiredDate)
        VALUES (:cookie, :user, :expiredDate)";
        $this->db->query($queryCookie);
        $this->db->bind('cookie', $cookie);
        $this->db->bind('user', $userId);

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
