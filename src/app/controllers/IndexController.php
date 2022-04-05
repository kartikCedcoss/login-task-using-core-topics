<?php


use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {

       if(!$this->session->has('new')){
           $this->view->message='not set';
       }  
       if  ($this->session->has('new')){
           $this->view->message='session set';
       }
    }
}

?>