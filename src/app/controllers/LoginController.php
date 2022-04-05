<?php

   use Phalcon\Mvc\Controller;


class LoginController extends Controller
{
    public function indexAction()
    {
        if ($this->cookies->has('remember-me')) {
            // $loginCookie =  $this->cookies->get('remember-me');
            // $value = $loginCookie->getValue();
            // return $value ;
            $this->response->redirect('../dashboard');
        }
    }
    public function authAction()
    {
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $pass = $this->request->getPost('password');
            $users = Users::findFirstByemail($email);
            if($users){
             if($users->password==$pass){
             $this->session->set('username',$users->name);

                if($this->request->getPost('remember')){
                $this->cookies->set(
                    'remember-me',
                    'some value',
                     time() + 15 * 86400
                    );
                 $this->cookies->send();
                }
                $this->response->redirect('../dashboard');
             }
             else{
                return $this->response;
             }
            }
            else{
                
                return $this->response;
            }
        }
    }
    public function logoutAction(){
        $this->session->destroy();
        $rememberMeCookie = $this->cookies->get('remember-me');
        $rememberMeCookie->delete();
        $this->response->redirect('../login');

    }
}

?>