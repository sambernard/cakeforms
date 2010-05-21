<script type="text/javascript">
$(function() {
	$("#sortable tbody").sortable({});
	$("#accordion").accordion({autoHeight: false});
	
	$("#addField").dialog({
		modal: true,
		autoOpen: false,
	});
	
	$("#addField form").live('submit', function(){
		var data = $(this).serialize();
		var url = $(this).attr('action');
		
		$.post(
		url,
		data,
		function(response){
			if(response){
				$.get('<?php echo $html->url(array('controller' => 'form_fields', 'action' => 'get_row'))?>/' + response,
				      function(data){
					$("#sortable tbody").append(data);
				      });
				$("#addField").dialog('close');
				}
			}
		);
		return false;
	});
	
	$("#addFieldLink").click(function(){
		var url = $(this).attr('href');
		
		$.get(url,
			function(data){
			  $("#addField").html(data);
			  $("#addField").dialog('open');
			});
		return false;
		});	

	
	$("#addValidation").dialog({
		modal: true,
		autoOpen: false,
	});
	
	$(".validationLink").live('click', function(){
		var url = $(this).attr('href');
		$.get(url,
			function(data){
			  $("#addValidation").html(data);
			  $("#addValidation").dialog('open');
			});
		return false;
		});
	
	$('#addValidation form').live('submit', function(){
		var data = $(this).serialize();
		var url = $(this).attr('action');
		
		$.post(
		url,
		data,
		function(response){
			if(response == 'success'){
				$("#addValidation").dialog('close');
				}
			}
		);
		return false;
		})
	
	$("button, input:submit, a.jsbutton").button();
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
});
</script>
<div class="cforms form">
<?php echo $form->create('Cform');?>
	<?php
		echo $form->input('id');
		echo $form->input('name', array('label' => 'Form Name'));
	?>
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
					echo $this->element('form_field_row', array('key' => $key, 'field' => $field, 'multiTypes' => $multiTypes));
				}
			}
			?>
			</tbody>
			</table>
			<?php echo $html->link('Add Field', array('plugin' => 'cforms', 'admin' => true, 'controller' => 'form_fields', 'action' => 'add', $this->data['Cform']['id']), array('class' => 'jsbutton', 'id' => 'addFieldLink'));?>
		</div>
		<h3><a href="#">Miscellaneous Options</a></h3>
		<div>
		<?php
			echo $form->input('action', array('label' => 'Alternative Form Action'));
			echo $form->input('redirect', array('label' => 'Alternative Success Page/Redirect'));
		?>			
		</div>
		<h3><a href="#">Email Options/Autoconfirmation</a></h3>		
		<div>
		<?php
			echo $form->input('recipient', array('label' => 'Admin email address'));
			echo $form->input('from', array('label' => 'FROM: email address'));
			echo $form->input('auto_confirmation', array('label' => 'Send a copy of this email to the visitor:'));
		?>						
		</div>			
	</div>
<?php echo $form->end('Submit');?>
</div>

<div id="addField" title="Add Field">
</div>

<div id="addValidation" title="Edit Validation">
</div>