<?php
	echo
	$form->create('FormField'),
		$form->hidden('id'),
		$form->input('depends_on', array('label' => 'If this field is only required based on the value of another field, enter the name of that field here')),
		$form->input('depends_value', array('label' => 'If this field is only required based on the value of another field, enter the value of that field here')),
		$form->input('ValidationRule'),
	$form->end('Update');
?>
	