<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Professor
 */
class Controller {

    protected $config;
    private $query;
    protected $view;
    protected $model;
    protected $login; 
    protected $exceptionHandler = null;
    

    public function __construct() {
        include 'config.php';
        $this->config = $config;
        $this->view = new View();
        $this->login = new Login();
        $this->doLogin();
    }

    function doLogin(){
        if($this->filter("login")){
            $username = $this->filter("username");
            $password = $this->filter("password");
            $cookie = ($this->filter("keepMeLogged")) ? true : false;
            $user = new dataObject(['username'  =>$username,
                                    'password'  =>$password, 
                                    'cookie'    =>$cookie
                                   ]);
            
            $exception = $this->login->doLogin($user);
            if($exception instanceof Exception){
                $this->exceptionHandler = $exception;
            }
        }
    }
    
    public function route($query = null) {
        $class = null;
        $this->query = $query;
        if ($this->query) {
            $this->query = explode('/', $this->query);
            $class_name = $this->query[0];
            if (count($this->query) > 1) {
                $method = $this->query[1];
            } else {
                $method = null;
            }
            $param = (count($this->query) > 2) ? $this->query[2] : null;
            if (class_exists($class_name)) {
                $class = new $class_name;
                if ($class instanceof Controller) {
                    if (method_exists($class, $method)) {
                        if ($param) {
                            $class->$method($param);
                        } else {
                            $class->$method();
                        }
                    } else {
                        if (method_exists($class, 'index')) {
                            $class->index();
                        } else {
                            $this->view->index();
                        }
                    }
                }
            }
        }

        if (!$class) {
            $class = new $this->config->defaultClass;
            $class->index();			
        }
    }
    
    protected function filter($item){
        return filter_input(INPUT_POST,$item,FILTER_SANITIZE_STRING);
    }
    
    public function reload(){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}