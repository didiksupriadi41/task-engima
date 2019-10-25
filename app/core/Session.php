<?php namespace core;

class Session
{

    public function delete($key)
    {
        if ($this->exists($key)) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    public function destroy()
    {
        session_destroy();
    }

    public function exists($key)
    {
        return(isset($_SESSION[$key]));
    }

    public function get($key)
    {
        if ($this->exists($key)) {
            return($_SESSION[$key]);
        }
    }

    public function init()
    {

        if (session_id() == "") {
            session_start();
        }
    }

    public function put($key, $value)
    {
        return($_SESSION[$key] = $value);
    }
}
