<?php  
class CformHelper extends AppHelper { 
    public $helpers = array('Html', 'Form');
    public $openFieldset = false;
    
    function insert($formData){
        $out = '';

        if(!empty($formData['Cform'])){
            $out .= $this->Form->create('Submission', array('url' => '/' . $this->params['url']['url']));
            $out .= $this->Form->hidden('Cform.id', array('value' => $formData['Cform']['id']));
            $out .= $this->Form->hidden('Cform.submitHere', array('value' => true));
            
            if(isset($formData['FormField'])){
                foreach($formData['FormField'] as $field){
                    $out .= $this->field($field);
                }
            }
        }
        
        if($this->openFieldset == true){
                $out .= "</fieldset>";
        }
        
        $out .= $this->Form->end('Submit');        
        
        return $this->output($out);
    }
    
    function field($field, $custom_options = array()){
        $options = array();
        $out = '';
        
        if(!empty($field['type'])){
                if($field['type'] == 'fieldset'){
                        if($this->openFieldset == true){
                                $out .= "</fieldset>";
                        }
                        
                        $out .=  "<fieldset>";
                        $this->openFieldset = true;
                        
                        if(!empty($field['name'])){
                                $out .= "<legend>".Inflector::humanize($field['name'])."</legend>";
                                $out .= $this->Form->hidden('Cform.fs_' . $field['name'], array('value' => $field['name']));
                        }
                        
                } else {
                        $options['type'] = $field['type'];
                        if(in_array($field['type'], array('select', 'checkbox', 'radio'))){
                                
                                
                                if($field['type'] == 'checkbox'){
                                    if(count($field['options']) > 1){
                                            $options['type'] = 'select';
                                            $options['multiple'] = 'checkbox';
                                            $options['options'] = $field['options'];
                                    } else {
                                        $options['value'] = $field['name'];
                                    }
                                } else {
                                    $options['options'] = $field['options'];                                    
                                }

                        }
                        
                        if(!empty($field['label'])){
                                $options['label'] = $field['label'];
                        }
                        
                        if(!empty($field['default']) && empty($this->data['Cform'][$field['name']])){
                                $options['value'] = $field['default'];
                        }
                        
                        $options = Set::merge($custom_options, $options);
                        
                        $out .= $this->Form->input('Cform.' . $field['name'], $options);
                
                }
        }
        return $out;
    }
} 

?>