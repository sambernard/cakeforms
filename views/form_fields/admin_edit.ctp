<script type='text/javascript'>
	$('select[id="FormFieldType"]').live('change', function(){
		var value = $(this).val();
		var select = <?php echo json_encode($multiTypes);?>;

		if(jQuery.inArray(value, select) > -1){
			$('.options').show();
		} else{
			$('.options').hide();
		}
		});	
</script>

<div class="formFields form">
<?php echo $html->link('Back to form...', array('controller' => 'cforms', 'action' => 'edit', $this->data['FormField']['cform_id']));?>
<?php echo $form->create('FormField');?>
	<fieldset>
 		<legend><?php __('Edit Field');?></legend>
	<?php
		if(!in_array($this->data['FormField']['type'], $multiTypes)){
			$typeOptions = array('type' => 'text','div' => array('style' => 'display:none', 'class' => 'options'));
		} else {
			$typeOptions = array('type' => 'text', 'div' => array('class' => 'options'));
		}
		
		echo $form->input('name');
		echo $form->input('label');
		echo $form->input('type');
		echo $form->input('options', $typeOptions);
		echo $form->input('default');
		echo $form->input('required');
		echo $form->input('ValidationRule');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<?php echo $html->link('Back to form...', array('controller' => 'cforms', 'action' => 'edit', $this->data['FormField']['cform_id']));?>