<?php
class CformComponent extends Object{
    
        public $components = array('RequestHandler');
        public $formData;
        
        function initialize(){
                if(empty($this->controller->Submission)){
                    App::import('Model', 'Cforms.Submission');
                    $this->Submission = new Submission;
                } else {
                    $this->Submission = $this->controller->Submission;
                }
        }
        
        function startup(&$controller){          
            $this->controller = &$controller; 
            $this->controller->helpers[] = "Cform";
            
            
            if(!empty($this->controller->data['Cform']['submitHere']) && $this->controller->data['Cform']['id']){
                   $this->submit();
            }
        }     
        
        function loadForm($id){
            if(empty($this->formData)){
                $this->formData = $this->Submission->Cform->buildSchema($id);
            }
            $this->controller->set('formData', $this->formData);
            
            return $this->formData;
        }
        
        function submit(){
            $id = $this->controller->data['Cform']['id'];
    
            $formData = $this->loadForm($id);
    
            $this->Submission->Cform->set($this->controller->data);
            if($this->Submission->Cform->validates()){
                    if(!empty($formData['Cform']['next'])){
                            $this->Session->write('Cform.form.' .  $id, $this->controller->data['Cform']);
                    } else {
                            if(!empty($this->controller->data['Cform']['email'])){
                                    $this->controller->data['Submission']['email'] = $this->controller->data['Cform']['email'];
                            }
                            $this->controller->data['Submission']['cform_id'] = $id;
                            $this->controller->data['Submission']['ip'] = ip2long($this->RequestHandler->getClientIP());
                            unset($this->controller->data['Cform']['id']);
                            $this->Submission->submit($this->controller->data);
                            
                            if(!empty($formData['Cform']['redirect'])){
                                    $this->redirect($formData['Cform']['redirect']);
                            }
                    }
            }
        }
        
    }
    ?>