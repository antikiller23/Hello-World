<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $components = array(
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),
        'Session',
        'DebugKit.Toolbar'
    );
    public $helpers = array('Html', 'Form', 'Session');

    public function beforeFilter() {
        //Configure AuthComponent
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'posts', 'action' => 'add');
    }


    /*
    function beforeFilter() {
    
        //Configure AuthComponent
        $this->Auth->authorize = array(
            'Controller',
            'Actions' => array('actionPath' => 'controllers')
        );
        $this->Auth->authenticate = array('Form' => array('fields' => array('username' => 'login', 'password' => 'password')));
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false);
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false);
        $this->Auth->loginRedirect = array('controller' => 'products', 'action' => 'index', 'admin' => false, 'plugin' => false);
    
    }
    */
    function isAuthorized($user) {
        return false;
        //return $this->Auth->loggedIn();
    }

}
