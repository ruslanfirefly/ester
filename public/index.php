<?php
header('Content-Type: text/html; charset=utf-8');
try {

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            '../app/controllers/',
            '../app/models/',
        )
    )->register();


    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    //Set the database service
    $di->set('db', function(){
        $db = new Db();
        return $db->getInstance();
       /* return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "12345678",
            "dbname" => "ester"
        ));*/
    });

    //Setting up the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        $view->registerEngines(array(
            ".volt" => 'Phalcon\Mvc\View\Engine\Volt'));
        return $view;
    });

    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });
    //Handle the request
    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}
