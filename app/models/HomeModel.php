<?php namespace models;

class HomeModel
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

    public function getUsername()
    {
        if ($this->cookie->exists('engima')) {
            $value = $this->cookie->get('engima');

            $query = "SELECT username 
                FROM Cookie NATURAL JOIN User 
                WHERE Cookie.value = :value ";

            $this->db->query($query);
            $this->db->bind('value', $value);
            $data = $this->db->resultSet();
            return ($data[0]['username']);
        } else {
            $this->redirect->to(BASEURL. 'login');
        }
    }
}
