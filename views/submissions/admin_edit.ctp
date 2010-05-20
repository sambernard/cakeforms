<div class="submissions form">
<?php echo $form->create('Submission');?>
	<fieldset>
 		<legend><?php __('Edit Submission');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('cform_id');
		echo $form->input('ip');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Submission.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Submission.id'))); ?></li>
		<li><?php echo $html->link(__('List Submissions', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Cforms', true), array('controller' => 'cforms', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Cform', true), array('controller' => 'cforms', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Submission Fields', true), array('controller' => 'submission_fields', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Submission Field', true), array('controller' => 'submission_fields', 'action' => 'add')); ?> </li>
	</ul>
</div>
