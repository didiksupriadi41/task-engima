<?php namespace core;

class Controller
{
    public function view($view, $data = [])
    {
        include_once '../app/views/' . $view . '.php';
    }

    public function model($modelName)
    {
        $model = '\models\\'.$modelName;
        include_once '../app/models/' . $modelName . '.php';
        return new $model;
    }
}
