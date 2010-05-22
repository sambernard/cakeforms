<?php
class SubmissionsController extends CformsAppController {

	var $name = 'Submissions';
	var $helpers = array('Html', 'Form', 'Cforms.Csv');
	var $components = array('Cform');

	function admin_export($formId = null){
		if (!$formId) {
			$this->Session->setFlash(__('Invalid Submission', true));
			$this->redirect(array('action' => 'index'));
		}
		
		Configure::write('debug', 0);
		
		$submissions = $this->Submission->getSubmissions($formId);
		$fields = array_keys($submissions[0]);
		
		$this->set(compact('submissions', 'fields'));
		$this->layout = 'csv/default';
		$this->render('csv/admin_export');
		
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