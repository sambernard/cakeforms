<?php
class Cform extends CformsAppModel {

	var $name = 'Cform';
	var $validate = array(
		'name' => array('notEmpty'),
		'recipient' => array('email')
	);
	
	var $dependsOn = array();
	
	function beforeValidate(){
		foreach($this->dependsOn as $field => $dependsOn){
			$this->dependsOn($field, $dependsOn['field'], $dependsOn['value']);
		}
	}

	function dependsOn($field, $dependsOn, $dependsValue){
		
		if($this->data[$this->name][$dependsOn] == $dependsValue){
			return true;
		} else {
			unset($this->validate[$field]);
			unset($this->data[$this->name][$field]);
			return true;
		}
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Next' => array(
			'className' => 'Cforms.Cform',
			'foreignKey' => 'next',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'FormField' => array(
			'className' => 'Cforms.FormField',
			'foreignKey' => 'cform_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'FormField.order',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Submission'
	);
	
	function beforeFind(){
		//debug($this);
	}
	
	function buildSchema($id){
		
		$notInput = array('fieldset', 'textonly');
		
		$cform = $this->find('first', array(
						    'conditions' => array('Cform.id' => $id),
						    'contain' => array('FormField', 'FormField.ValidationRule')
						    ));
		
		$schema = array();
		$validate = array();
		
		foreach($cform['FormField'] as &$field){
			if(!in_array($field['type'], $notInput)){
				$schema[$field['name']] = array(
					'type' => 'string',
					'length' => $field['length'],
					'null' => $field['null'],
					'default' => $field['default']
				);
				
				if(!empty($field['ValidationRule'])){
					if(!($field['type'] == 'checkbox' && !empty($field['options']))){
						foreach($field['ValidationRule'] as $rule){
							$validate[$field['name']][$rule['rule']] = array(
								'rule' => $rule['rule'],
								'message' => $rule['message'],
								'required' => $field['required']
								
							);
						}
					}
				} elseif($field['required'] && !($field['type'] == 'checkbox' && !empty($field['options']))){
					$validate[$field['name']] = 'notEmpty';
				}
				
				if(!empty($field['depends_on']) && !empty($field['depends_value'])){
					$dependsOn[$field['name']] = array('field' => $field['depends_on'], 'value' => $field['depends_value']);
				}
				
				$field['options'] = str_replace(', ', ',', $field['options']);
				$options = explode(',', $field['options']);
				$field['options'] = array_combine($options, $options);
			}
		}
		
		$this->validate = $validate;
		$this->_schema = $schema;
		$this->dependsOn = $dependsOn;

		return $cform;
	}

}
?>