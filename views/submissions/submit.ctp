<div class="submissions form">
<?php echo $form->create('Submission', array('url' => array('controller' => 'submissions', 'action' => 'submit', $id)));?>
		<?php echo $form->hidden('Cform.id', array('value' => $id));?>
	<?php
	
	$openFieldset = false;
	
	foreach($cform['FormField'] as $field){
		$options = array();
		
		if(!empty($field['type'])){
			if($field['type'] == 'fieldset'){
				if($openFieldset == true){
					echo "</fieldset>";
				}
				
				echo "<fieldset>";
				$openFieldset = true;
				
				if(!empty($field['name'])){
					echo "<legend>".Inflector::humanize($field['name'])."</legend>";
					echo $form->hidden('Cform.fs_' . $field['name'], array('value' => $field['name']));
				}
				
			} else {
				$options['type'] = $field['type'];
				if(in_array($field['type'], $multiTypes)){
					if($field['type'] == 'checkbox' && !empty($field['options'])){
						$options['type'] = 'select';
						$options['multiple'] = 'checkbox';
					}
					
					$options['options'] = $field['options'];
				}
				
				if(!empty($field['label'])){
					$options['label'] = $field['label'];
				}
				
				if(!empty($field['default']) && empty($this->data['Cform'][$field['name']])){
					$options['value'] = $field['default'];
				}
				
				echo $form->input('Cform.' . $field['name'], $options);
			
			}
		}
	}
	?>
<?php
if($openFieldset == true){
	echo "</fieldset>";
}
echo $form->end('Submit');?>
</div>