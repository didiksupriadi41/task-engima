<?php namespace core;

class Cookie
{
    public function delete($key)
    {
        $this->put($key, "", time() - 1);
    }

    public function exists($key)
    {
        return(isset($_COOKIE[$key]));
    }

    public function get($key)
    {
        return($_COOKIE[$key]);
    }

    public function put($key, $value, $expiry)
    {
        return(setcookie($key, $value, time() + $expiry, "/"));
    }
}
