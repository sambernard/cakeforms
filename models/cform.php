<?php
class Cform extends CformsAppModel {

	var $name = 'Cform';
	var $validate = array(
		'name' => array('notempty'),
		'recipient' => array('email')
	);

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
		)
	);
	
	function beforeFind(){
		//debug($this);
	}
	
	function buildSchema($id){
		
		$cform = $this->find('first', array(
						    'conditions' => array('Cform.id' => $id),
						    'contain' => array('FormField', 'FormField.ValidationRule')
						    ));
		
		$schema = array();
		$validate = array();
		
		foreach($cform['FormField'] as &$field){
			$schema[$field['name']] = array(
				//'type' => $field['type'],
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
			
			$field['options'] = str_replace(', ', ',', $field['options']);
			$options = explode(',', $field['options']);
			$field['options'] = array_combine($options, $options);
		}
		
		$this->validate = $validate;
		$this->_schema = $schema;
		return $cform;
	}

}
?>