<?php

class CformsAppController extends AppController {
    public $components = array('RequestHandler', 'Cforms.Cakeform');
    
    
    
    function beforeFilter(){
        parent::beforeFilter();
        if($this->RequestHandler->isAjax()){
            Configure::write('debug', 0);
        }
        
        if(isset($this->Auth)){
            if(empty($this->Auth->loginAction['plugin'])){
                $this->Auth->loginAction['plugin'] = null;
            }
        }
    }
}

?>