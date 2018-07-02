<<<<<<< HEAD
<?php
class Comics extends Controller{

    public function __construct() {
        parent::__construct();
        $this->model = new ComicModel();
    }

    public function search($text = null){
        $data = [];
        $text = (!$text && null!==filter_input(INPUT_POST,"t")) ? filter_input(INPUT_POST,"t") : $text;
        if($text){
            $data['text']=$text; 
            $data['comics']=$this->model->searchComics($text);
        }
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('pesquisacomics',$data);
        $this->view->load('footer');
    }
    
    public function view($id){
       
        $data[]="";//por enquanto
        
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('vercomic',$data);
        $this->view->load('footer');
    }
    
    public function read($id){
       
        $data[]="";//por enquanto
        
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('readComic',$data);
        $this->view->load('footer');
    }
    

=======
<?php
class Comics extends Controller{

    public function __construct() {
        parent::__construct();
        $this->model = new ComicModel();
    }

    public function search($text = null){
        $data = [];
        //$text = (!$text && isset(filter_input(INPUT_GET,"t"))) ? filter_input(INPUT_GET,"t") : $text;
        //if($text){
        //    $data['text']=$text; 
        //    $data['comics']=$this->model->searchComics($text);
        //}
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('pesquisacomics',$data);
        $this->view->load('footer');
    }
    
    public function insertComic(){
       
        $data=[];//por enquanto
        
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('inserircomic',$data);
        $this->view->load('footer');
    }
    
    public function view($id){
       
        $data[]="";//por enquanto
        
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('vercomic',$data);
        $this->view->load('footer');
    }
    
    public function read($id){
       
        $data[]="";//por enquanto
        
        $this->view->load('header');
        $this->view->load('nav');
        $this->view->load('readComic',$data);
        $this->view->load('footer');
    }
    

>>>>>>> 9c0d9fcd9c07cdd6dc48c89597c40aeb6f7ad456
}