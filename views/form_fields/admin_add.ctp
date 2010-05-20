<div class="formFields form">
<?php echo $form->create('FormField');?>
	<fieldset>
 		<legend><?php __('Add FormField');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('label');
		echo $form->input('type');
		echo $form->input('length');
		echo $form->input('null');
		echo $form->input('default');
		echo $form->input('cform_id');
		echo $form->input('required');
		echo $form->input('ValidationRule');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List FormFields', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Cforms', true), array('controller' => 'cforms', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Cform', true), array('controller' => 'cforms', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Validation Rules', true), array('controller' => 'validation_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Validation Rule', true), array('controller' => 'validation_rules', 'action' => 'add')); ?> </li>
	</ul>
</div>
