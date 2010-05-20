<?php

class CformsAppController extends AppController {
    public $components = array('RequestHandler');
    
    
    
    function beforeFilter(){
        if($this->RequestHandler->isAjax()){
            Configure::write('debug', 0);
        }
        
        if(isset($this->Auth)){
            $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => null);
        }
    }
}

?>