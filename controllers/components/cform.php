<?php
class CformComponent extends Object{
    
        public $components = array('RequestHandler', 'Email');
        public $formData;
        
        
        function initialize(&$controller, $settings = array()) {
                $this->controller =& $controller;
                if(empty($this->controller->Form)){
                    App::import('Model', 'Cforms.Form');
                    $this->Form = new Form;
                
                } else {
                    $this->Form = &$this->controller->Form;
                }
                
                if(!empty($settings['email'])){
                        foreach($settings['email'] as $key => $setting){
                                $this->Email->{$key} = $setting;
                        }
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
                $this->formData = $this->Form->buildSchema($id);
            }
            $this->controller->set('formData', $this->formData);
            
            return $this->formData;
        }
        
        function submit(){
            $id = $this->controller->data['Cform']['id'];
    
            $this->loadForm($id);
                
            $validate = $this->controller->data;
            foreach($validate['Form'] as &$field){
                if(is_array($field)){
                        $field = implode("\n", $field);
                }
            }

            $this->Form->set($validate);
            if($this->Form->validates()){
                    if(!empty($this->formData['Cform']['next'])){
                            $this->Session->write('Cform.form.' .  $id, $this->controller->data['Cform']);
                    } else {
                            if(!empty($this->controller->data['Form']['email'])){
                                    $this->controller->data['Submission']['email'] = $this->controller->data['Cform']['email'];
                            }
                            $this->controller->data['Submission']['cform_id'] = $id;
                            $this->controller->data['Submission']['ip'] = ip2long($this->RequestHandler->getClientIP());
                            unset($this->controller->data['Cform']['id']);
                            unset($this->controller->data['Cform']['submitHere']);
                            
                            
                            App::import('Model', 'Cforms.Submission');
                            $this->Submission = new Submission;
                            if($this->Submission->submit($this->controller->data)){
                                $this->send($this->formData['Cform'], $this->controller->data);
                                
                                if(!empty($this->formData['Cform']['redirect'])){
                                        $this->redirect($this->formData['Cform']['redirect']);
                                }
                                return true;
                            }
                    }
            }
        }
        
	function send($formData, $response){
                if(!empty($formData['recipient'])){
                        $this->Email->to = $formData['recipient'];
                }
                
                if(empty($this->Email->from)){
                        $this->Email->from = $this->Email->to;
                }
                
		$this->Email->subject = "New '{$formData['name']}' Submission";
                $this->Email->delivery = 'debug';
		$this->Email->sendAs = 'both';
		$this->Email->template = 'submission';
                
                $this->controller->set(compact('formData', 'response'));
		return $this->Email->send();
	}
        
    }
    ?>