<?php
class SubmissionsController extends CformsAppController {

	var $name = 'Submissions';
	var $helpers = array('Html', 'Form', 'Cforms.Csv');
	var $components = array('RequestHandler');


	function admin_export($formId = null){
		if (!$formId) {
			$this->Session->setFlash(__('Invalid Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		
		Configure::write('debug', 0);
		
		$submissions = $this->Submission->getSubmissions($formId);
		$fields = array_keys($submissions[0]);
		
		$this->set(compact('submissions', 'fields'));
		
	}

/**
 * Generates form, validates and submits.
 *
 * @param $id 
 * 
 *
 *
 * @todo Add multipage form support
 */

	function submit($id = null) {
		if(!empty($this->data['Cform']['id'])){
			$id = $this->data['Cform']['id'];
			
		} elseif (!$id) {
			$this->Session->setFlash(__('Invalid Submission', true));
			$this->redirect(array('action' => 'index'));
			
		}

		$cform = $this->Submission->Cform->buildSchema($id);

		if(!empty($this->data)){
			$this->Submission->Cform->set($this->data);
			if($this->Submission->Cform->validates()){
				if(!empty($cform['Cform']['next'])){
					$this->Session->write('Cform.form.' .  $id, $this->data['Cform']);
				} else {
					$this->data['Submission']['cform_id'] = $id;
					$this->data['Submission']['ip'] = ip2long($this->RequestHandler->getClientIP());
					unset($this->data['Cform']['id']);
					$this->Submission->submit($this->data);
					
					if(!empty($cform['Cform']['redirect'])){
						$this->redirect($cform['Cform']['redirect']);
					}
				}
			}
		}
		$multiTypes = $this->Submission->Cform->FormField->multiTypes;
		$this->set(compact('id', 'cform', 'multiTypes'));
	}

	function index($formId = null) {
		$this->Submission->recursive = 0;
		$this->set('submissions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('submission', $this->Submission->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Submission->create();
			if ($this->Submission->save($this->data)) {
				$this->Session->setFlash(__('The Submission has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Submission could not be saved. Please, try again.', true));
			}
		}
		$cforms = $this->Submission->Cform->find('list');
		$this->set(compact('cforms'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Submission->save($this->data)) {
				$this->Session->setFlash(__('The Submission has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Submission could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Submission->read(null, $id);
		}
		$cforms = $this->Submission->Cform->find('list');
		$this->set(compact('cforms'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Submission->del($id)) {
			$this->Session->setFlash(__('Submission deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Submission could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	function admin_index() {
		$this->Submission->recursive = 0;
		$this->set('submissions', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('submission', $this->Submission->read(null, $id));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Submission->save($this->data)) {
				$this->Session->setFlash(__('The Submission has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Submission could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Submission->read(null, $id);
		}
		$cforms = $this->Submission->Cform->find('list');
		$this->set(compact('cforms'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Submission->del($id)) {
			$this->Session->setFlash(__('Submission deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Submission could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>