<div class="cforms view">
<h2><?php  __('Cform');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cform['Cform']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cform['Cform']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Recipient'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cform['Cform']['recipient']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Next'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($cform['Next']['name'], array('controller' => 'cforms', 'action' => 'view', $cform['Next']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Cform', true), array('action' => 'edit', $cform['Cform']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Cform', true), array('action' => 'delete', $cform['Cform']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cform['Cform']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Cforms', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Cform', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Cforms', true), array('controller' => 'cforms', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Next', true), array('controller' => 'cforms', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Form Fields', true), array('controller' => 'form_fields', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Form Field', true), array('controller' => 'form_fields', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Form Fields');?></h3>
	<?php if (!empty($cform['FormField'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Label'); ?></th>
		<th><?php __('Type'); ?></th>
		<th><?php __('Length'); ?></th>
		<th><?php __('Null'); ?></th>
		<th><?php __('Default'); ?></th>
		<th><?php __('Cform Id'); ?></th>
		<th><?php __('Required'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($cform['FormField'] as $formField):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $formField['id'];?></td>
			<td><?php echo $formField['name'];?></td>
			<td><?php echo $formField['label'];?></td>
			<td><?php echo $formField['type'];?></td>
			<td><?php echo $formField['length'];?></td>
			<td><?php echo $formField['null'];?></td>
			<td><?php echo $formField['default'];?></td>
			<td><?php echo $formField['cform_id'];?></td>
			<td><?php echo $formField['required'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'form_fields', 'action' => 'view', $formField['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'form_fields', 'action' => 'edit', $formField['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'form_fields', 'action' => 'delete', $formField['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $formField['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Form Field', true), array('controller' => 'form_fields', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
