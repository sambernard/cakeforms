<?php

class CformsAppController extends AppController {
    public $components = array('RequestHandler');
    
    
    
    function beforeFilter(){
        if($this->RequestHandler->isAjax()){
            Configure::write('debug', 0);
        }
    }
}

?>