<?php
declare(strict_types=1);

use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Http\Response\Cookies;
use Phalcon\Mvc\View;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Http\Response;
use Phalcon\Crypt;


$container->setShared('session', function () {
    $session = new SessionManager();
    $files = new SessionAdapter([
        'savePath' => sys_get_temp_dir(),
    ]);
    $session->setAdapter($files);
    $session->start();

    return $session;
});

$container->set(
    'cookies',
    function () {
        //$signKey  = "#1dj8$=dp?.ak//j1V$~%*0XaK\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\\\x5c";
        //$cookies  = new Cookies(true, $signKey);
        $cookies = new Cookies();
        $cookies->useEncryption(true);
        return $cookies;
    }
);


$container->set( 
    "crypt", function () { 
       $crypt = new Crypt(); 
       $crypt->setKey('AED@!sft56$'); // Use a unique Key!
       $key = "T4\xb1\x8d\xa9\x98\x054t7w!z%C*F-Jk\x98\x05\x5c";
       $crypt->setKey($key);  
       return $crypt; 
    } 
 ); 

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'response',
    function(){
        $response = new Response(
            "Sorry , Authentication Failed",
            403, 
            'Not Found'
        );
       return $response;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$container->set(
    'config',
    function(){

        $fileName= "../app/config/config.php";
        // $factory= new ConfigFactory();
        // return $factory->newInstance("php",$fileName);
        $config = new Config([]);
        $array = new \Phalcon\Config\Adapter\Php($fileName);
        $config->merge($array);
        return $config;
    }
);

$container->setShared('db', function () {
    $database = $this->getConfig();
    return new Mysql(
        [
            'host'     => $database->database->host,
            'username' =>  $database->database->username,
            'password' => $database->database->password,
            'dbname'   => $database->database->dbname,
        ]
    );
});


