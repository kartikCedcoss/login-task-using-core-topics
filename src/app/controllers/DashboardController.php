<?php

   use Phalcon\Mvc\Controller;
   use Phalcon\Paginator\Adapter\Model as PaginatorModel;


class DashboardController extends Controller
{
    public function indexAction()
    {
        if(!$this->session->has('username') && !$this->cookies->has('remember-me')){
            $this->response->redirect('../login');
          }
        $config = $this->di->get("config");
        $this->view->date = $config->get("app")->get("timezone");
        $this->view->timezone = $config->get("app")->get("time");
         
        $currentPage = (int) $_GET['page'];
        $this->view->users = Users::find(); 
       
    }
}