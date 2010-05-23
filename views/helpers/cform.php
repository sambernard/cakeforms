<?php  
class CformHelper extends AppHelper { 
    public $helpers = array('Html', 'Form', 'Javascript');
    
    public function beforeRender() {
        $this->Javascript->link(array('/cforms/js/jquery-1.4.2.min.js', '/cforms/js/jquery-ui-1.8.1.custom.min.js'), false);
        $view =& ClassRegistry::getObject('view');
        $view->addScript($this->Html->css(array('/cforms/css/fancy_white', '/cforms/css/ui-lightness/jquery-ui-1.8.1.custom')));
    }
    
/**
 * used in generating form fieldsets
 *
 * @access public
 */       
    public $openFieldset = false;

/**
 * Javascript for form functionality
 *
 * @todo move to external file
 * @access public
 */   
    function js(){
        $js =
        "
    $(function() {
    $('.dependent').each(function(){
        var dependsName = $(this).attr('dependson');
        var dependsValue = $(this).attr('dependsvalue');

        var dependsOn = $('[name*=\"'+ dependsName + '\"]');
        var div = $(this).closest('div');

        if(dependsOn.val() != dependsValue){
            div.hide();
        }

        dependsOn.live('change', function(){
                    if(dependsValue == $(this).val()){
                         div.show();
                } else {
                        div.hide();
                }});
            });
        });
        ";
        
        $this->Javascript->codeBlock($js, array('inline' => false));
    }

/**
 * Generates form HTMl
 *
 * @param array $formData
 *
 * @return string Form Html
 * @access public
 */      
    function insert($formData){
        $this->js();
        $out = '';

        if(!empty($formData['Cform'])){
            if(!empty($formData['Cform']['action'])){
                $action = $formData['Cform']['action'];
            } else {
                $action = '/' . $this->params['url']['url'];
            }
            
            $out .= $this->Form->create('Form', array('url' => $action, 'class' => 'cform'));
            $out .= $this->Form->hidden('Cform.id', array('value' => $formData['Cform']['id']));
            $out .= $this->Form->hidden('Cform.submitHere', array('value' => true));
            
            $out .= '<span class="reqtxt">Indicates a required field.</span>';
            
            if(isset($formData['FormField'])){
                foreach($formData['FormField'] as $field){
                    $out .= $this->field($field);
                }
            }
        
        
        if($this->openFieldset == true){
                $out .= "</fieldset>";
        }
        
        $out .= $this->Form->end('Submit');        
        }
        
        return $this->output($out);
    }

/**
 * Generates appropriate html per field
 *
 * @param array $field Field to process
 * @parram array $custom_options Custom $form->input options for field
 *
 * @return string field html
 * @access public
 */       
    function field($field, $custom_options = array()){
        $options = array();
        $out = '';
        
        if(!empty($field['type'])){
                switch($field['type']){
                    case 'fieldset':
                        if($this->openFieldset == true){
                                $out .= "</fieldset>";
                        }
                        
                        $out .=  "<fieldset>";
                        $this->openFieldset = true;
                        
                        if(!empty($field['name'])){
                                $out .= "<legend>".Inflector::humanize($field['name'])."</legend>";
                                $out .= $this->Form->hidden('fs_' . $field['name'], array('value' => $field['name']));
                        }
                    break;  
                
                    case 'textonly':
                        $out = $this->Html->para('textonly', $field['label']);
                    break;
                
                    default:
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
                                    $options['empty'] = 'select one';
                                }

                        }
                        
                        if(!empty($field['depends_on']) && !empty($field['depends_value'])){
                            $options['class'] = 'dependent';
                            $options['dependsOn'] = $field['depends_on'];
                            $options['dependsValue'] = $field['depends_value'];
                        }
                        
                        if(!empty($field['label'])){
                                $options['label'] = $field['label'];
                        }
                        
                        if(!empty($field['default']) && empty($this->data['Form'][$field['name']])){
                                $options['value'] = $field['default'];
                        }
                        
                        $options = Set::merge($custom_options, $options);
                        $out .= $this->Form->input($field['name'], $options);
                        break;
                }
        }
        return $out;
    }
} 

?>