<div class="cforms form">
<?php echo $form->create('Cform');?>
	<fieldset>
 		<legend><?php __('Add Cform');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('recipient');
		echo $form->input('next');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Cforms', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Cforms', true), array('controller' => 'cforms', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Next', true), array('controller' => 'cforms', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Form Fields', true), array('controller' => 'form_fields', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Form Field', true), array('controller' => 'form_fields', 'action' => 'add')); ?> </li>
	</ul>
</div>
