<?php
class Home extends Controller{

    public function __construct() {
        parent::__construct();
      
    }

    public function index(){
        /*o objeto do tipo exception é passado no array 
        data com o index "exception" */
        $data = array();
       
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('loginModal',$this->exceptionHandler);
        $this->view->load('home',$data);
        $this->view->load('footer');
    }

}