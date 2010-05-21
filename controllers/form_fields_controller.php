<?php
class FormFieldsController extends CformsAppController {

	var $name = 'FormFields';
	var $helpers = array('Html', 'Form');

	function admin_add($formId = null) {
		$response = false;
		
		if(!empty($this->data)){
			if(empty($this->data['FormField']['name'])){
				$this->data['FormField']['name'] = 'New Field';
			}
			
			$this->FormField->create();
			if ($this->FormField->save($this->data)) {
				$response = $this->FormField->id;
			}
			
			$this->set('response', $response);
			$this->render('../elements/ajax_reponse');
		
		} elseif($formId) {
			$this->data['FormField']['cform_id'] = $formId;
			$types = $this->FormField->types;
			$this->set('types', $types);
			$this->render('admin_add');
		}
	}

	function admin_get_row($id){
		$field = $this->FormField->findById($id);
		$field = $field['FormField'];
		$multiTypes = $this->FormField->multiTypes;
		$types = $this->FormField->types;
		$key = $this->FormField->find('count', array('conditions' => array('cform_id' => $field['cform_id'])));
		$this->set(compact('field', 'multiTypes', 'key', 'types'));
		$this->render('../elements/form_field_row');
	}

	function admin_edit($id = null) {
		if($this->RequestHandler->isAjax()){
			
			if (!$id && empty($this->data)) {
				$this->set('response', null);
				$this->render('../elements/ajax_reponse');
				
			} elseif(!empty($this->data)) {
				if ($this->FormField->save($this->data)) {
					$this->set('response', 'success');

				} else {
					$this->set('response', null);
				}
					$this->render('../elements/ajax_reponse');
			} else {
				$this->data = $this->FormField->read(null, $id);
				$validationRules = $this->FormField->ValidationRule->find('list');
				$this->set(compact('validationRules'));
			}
			return true;
		
		} else {
			$this->redirect('/');
		}
		
		//if (!$id && empty($this->data)) {
		//	$this->Session->setFlash(__('Invalid FormField', true));
		//	$this->redirect(array('controller' => 'cforms', 'action' => 'index'));
		//}
		//if (!empty($this->data)) {
		//	if ($this->FormField->save($this->data)) {
		//		$this->Session->setFlash(__('The FormField has been saved', true));
		//		$this->redirect(array('action' => 'edit', $id));
		//	} else {
		//		$this->Session->setFlash(__('The FormField could not be saved. Please, try again.', true));
		//	}
		//}
		//
		//if (empty($this->data)) {
		//	$this->data = $this->FormField->read(null, $id);
		//}
		//
		//$validationRules = $this->FormField->ValidationRule->find('list');
		//$this->set(compact('validationRules'));
	}

	function admin_delete($id = null) {

		if($this->RequestHandler->isAjax()){
			$response = 'failure';
			
			if($id){
				if ($this->FormField->del($id)) {
					$response = 'success';
				}
			}
			$this->set('response', $response);
			$this->render('../elements/ajax_reponse');
			return true;
		}
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for FormField', true));
			$this->redirect(array('controller' => 'cforms', 'action' => 'index'));
		}
		if ($this->FormField->del($id)) {
			$this->Session->setFlash(__('FormField deleted', true));
			$this->redirect(array('controller' => 'cforms', 'action' => 'index'));
		}
		$this->Session->setFlash(__('The FormField could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}
	
        function admin_sort(){
            if($this->RequestHandler->isAjax()){
		$order = 0;
                foreach($this->data['FormField'] as $field){
                    $this->FormField->create();
                    $this->FormField->id = $field['id'];
                    $this->FormField->saveField('order', $order);
		    $order++;
                }
		$this->set('response', 'success');
		$this->render('../elements/ajax_reponse');
                return true;
            }
        }	

}
?>