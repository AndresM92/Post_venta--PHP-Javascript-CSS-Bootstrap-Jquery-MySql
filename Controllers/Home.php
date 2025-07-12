<?php

class Home extends Controller
{


    #public $views;

    public function __construct()
    {
        session_start();
        if (!empty($_SESSION["session_active"])) {
            header("location: " .base_url."Usuarios");
        }
        parent::__construct();
    }

    public function index()
    {
        $this->views->getView($this, "index");
    }
}
