<?php
class FormFieldsController extends CformsAppController {

	var $name = 'FormFields';
	var $helpers = array('Html', 'Form');
	var $components = array('RequestHandler');

	function admin_add() {
		if (!empty($this->data)) {
			$this->FormField->create();
			if ($this->FormField->save($this->data)) {
				$this->Session->setFlash(__('The FormField has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The FormField could not be saved. Please, try again.', true));
			}
		}
		$validationRules = $this->FormField->ValidationRule->find('list');
		$cforms = $this->FormField->Cform->find('list');
		$this->set(compact('validationRules', 'cforms'));
	}

	function admin_edit($id = null) {

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid FormField', true));
			$this->redirect(array('controller' => 'cforms', 'action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->FormField->save($this->data)) {
				$this->Session->setFlash(__('The FormField has been saved', true));
				$this->redirect(array('action' => 'edit', $id));
			} else {
				$this->Session->setFlash(__('The FormField could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->FormField->read(null, $id);
		}
		$validationRules = $this->FormField->ValidationRule->find('list');
		$cforms = $this->FormField->Cform->find('list');
		$types = $this->FormField->types;
		$multiTypes = $this->FormField->multiTypes;
		$this->set(compact('validationRules','cforms', 'multiTypes', 'types'));
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
                return true;
            } else {
		$this->set('response', 'failure');
                return false;
            }
        }	

}
?>