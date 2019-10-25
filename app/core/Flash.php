<?php namespace core;

class Flash
{
    private $session;

    public function __construct()
    {
        $this->session = new \core\Session;
        $this->session->init();
    }

    public function session($key, $value = "")
    {
        if ($this->session->exists($key)) {
            $session = $this->session->get($key);
            $this->session->delete($key);
            return $session;
        } elseif (!empty($value)) {
            return($this->session->put($key, $value));
        }
        return null;
    }

    public function danger($value = "")
    {
        return($this->session("danger", $value));
    }

    public function success($value = "")
    {
        return($this->session("sucess", $value));
    }

    public function warning($value = "")
    {
        return($this->session("warning", $value));
    }
}
