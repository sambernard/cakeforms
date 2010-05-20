<script type="text/javascript">
$(function() {
	$("#sortable tbody").sortable({});
	$("#accordion").accordion();
	
	$("#sortable tbody").bind('sortupdate', function(event, ui) {
	
		var data = $('input[name*="data[FormField]"][name*="[id]"]').serialize();
		
		$.post(
		'<?php echo $this->base;?>/admin/cforms/form_fields/sort/',
		data,
		function(response){
			if(response == 'success'){
				//$('input[name*="data[FormField]"][name*="[form_id]"]').remove();
			}
		}
		);		
	});
	
	$('select[id*="FormField"][id*="Type"]').live('change', function(){
		var value = $(this).val();
		var select = <?php echo json_encode($multiTypes);?>;

		if(jQuery.inArray(value, select) > -1){
			$(this).closest('td').children('div.text').show();
		} else{
			$(this).closest('td').children('div.text').hide();
		}
		});
	
	$('.delete').live('click', function(){
		
		var fieldId = $(this).closest('tr').find('input[name*="data[FormField]"][name*="[id]"]').val();
		clicked = $(this);
		if(fieldId){
			$.post(
			'<?php echo $html->url(array('controller' => 'form_fields','action' => 'delete', 'admin' => true));?>/' + fieldId,
			function(response){
				if(response == 'success'){
					clicked.closest('tr').remove();	
				}
			}
			);
			
		} else {
			$(this).closest('tr').remove();	
		}
		});
	
	$("#addField").click(function(){
		var index = $('.ui-state-default').size();
		var formId = $('#CformId').val();
		var html = '<tr class="ui-state-default"><td><span class="ui-icon ui-icon-arrowthick-2-n-s">'+index+'</span></td> <td><input type="hidden" id="FormField'+index+'FormId" value="'+formId+'" name="data[FormField]['+index+'][form_id]"><input type="hidden" id="FormField'+index+'Order" value="'+index+'" name="data[FormField]['+index+'][order]"><div class="input text required"><input type="text" id="FormField'+index+'Name" maxlength="255" name="data[FormField]['+index+'][name]"></div></td> <td><div class="input text"><input type="text" id="FormField'+index+'Label" value="" maxlength="255" name="data[FormField]['+index+'][label]"></div></td> <td><div class="input select"><select id="FormField'+index+'Type" name="data[FormField]['+index+'][type]"><?php foreach($types as $key => $type){ echo "<option value=\"$key\">$type</option>";}?></select></div><div class="input text" style="display:none"><label for="FormField'+index+'Options">Options</label><input type="text" id="FormField'+index+'Options" name="data[FormField]['+index+'][options]"></div></td> <td><div class="input checkbox"><input type="hidden" value="0" id="FormField'+index+'Required_" name="data[FormField]['+index+'][required]"><input type="checkbox" id="FormField'+index+'Required" value="1" name="data[FormField]['+index+'][required]"></div></td><td><span class="ui-icon ui-icon-circle-close delete">Remove</span></td></tr>';
		
		$("#sortable tbody").append(html);
		
		return false;
		});
	
	//$("#sortable input, #sortable textarea").change(function(){
	//	var data = $(this).closest('#PhotoAddForm').serialize();
	//	$.post(
	//	'<?php echo $this->base;?>/admin/photos/edit/',
	//	data
	//	);
	//});
});
</script>
<div class="cforms form">
<?php echo $form->create('Cform');?>
	<fieldset>
 		<legend><?php __('Editing Form: '); echo $this->data['Cform']['name']; ?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('recipient');
//		echo $form->input('next');
	?>
	</fieldset>
	<div id="accordion">
		<h3><a href="#">Form Fields</a></h3>
		<div id="fields">
			<table id="sortable">
			<thead>
			<?php echo $html->tableHeaders(array('', 'Field Name', 'Label(Question)', 'Type', 'Required','actions'));?>
			</thead>
			<tbody>
			<?php
			if(!empty($this->data['FormField'])){
				$i=1;
				foreach($this->data['FormField'] as $key => $field){
					if(!in_array($field['type'], $multiTypes)){
						$typeOptions = array('type' => 'text','div' => array('style' => 'display:none'));
					} else {
						$typeOptions = array('type' => 'text');
					}
					
					$rows[] = array(
					'<span class="ui-icon ui-icon-arrowthick-2-n-s">' . $i . '</span>',
					$form->hidden('FormField.' . $key . '.id') .
					$form->input('FormField.' . $key . '.name', array('label' => false)),
					$form->input('FormField.' . $key . '.label', array('label' => false)),
					$form->input('FormField.' . $key . '.type', array('label' => false)) .
					$form->input('FormField.' . $key . '.options', $typeOptions),
					$form->input('FormField.' . $key . '.required', array('label' => false)),
					'<span class="ui-icon ui-icon-circle-close delete">Remove</span>' . $html->link('Add Validation', array('controller' => 'form_fields', 'action' => 'edit', $field['id']))
					);
					$i++;
					
				}
				echo $html->tableCells($rows, array('class' => 'ui-state-default'),array('class' => 'ui-state-default'));
			}
			?>
			</tbody>
			</table>
			<a id="addField" href="#">Add Field</a>
		</div>
		<h3><a href="#">Accordian2</a></h3>
		<div> Accordian 2 content!
		</div>		
	</div>
<?php echo $form->end('Submit');?>
</div>