<?php namespace core;

class Auth
{
    private $cookie;
    private $db;
    private $redirect;

    public function __construct()
    {
        $this->cookie = new \core\Cookie;
        $this->db = new \core\Database;
        $this->redirect = new \core\Redirect;
    }

    public function checkAuthenticated($redirect = "login")
    {
        if ($this->cookie->exists('engima')) {
            $value = $this->cookie->get('engima');
            $query = "SELECT * 
            FROM Cookie NATURAL JOIN User 
            WHERE Cookie.value = :value
            AND expiredDate >= :timeNow";
            
            date_default_timezone_set('Asia/Jakarta');
            $timeNow = date('Y-m-d H:i:s');
            $this->db->query($query);
            $this->db->bind('value', $value);
            $this->db->bind('timeNow', $timeNow);
            $data = $this->db->resultSet();

            if (count($data) == 0) {
                $this->redirect->to(BASEURL. "logout");
            } else {
                $query = "UPDATE Cookie 
                SET expiredDate = :expiredDate 
                WHERE value = :value";

                date_default_timezone_set('Asia/Jakarta');
                $expiredDate = date("Y-m-d H:i:s", strtotime("+1 day"));
                $this->db->query($query);
                $this->db->bind('expiredDate', $expiredDate);
                $this->db->bind('value', $value);
                $this->db->execute();
            }
        } else {
            $this->redirect->to(BASEURL. $redirect);
        }
    }

    public function getUserId()
    {
        if ($this->cookie->exists('engima')) {
            $value = $this->cookie->get('engima');
            $query = "SELECT idUser 
            FROM Cookie NATURAL JOIN User 
            WHERE Cookie.value = :value";
            $this->db->query($query);
            $this->db->bind('value', $value);
            $data = $this->db->resultSet();
            return ($data[0]['idUser']);
        } else {
            $this->redirect->to(BASEURL. 'logout');
        }
    }

    public function checkUnauthenticated($redirect = "")
    {
        if ($this->cookie->exists('engima')) {
            $this->redirect->to(BASEURL);
        }
    }
}
