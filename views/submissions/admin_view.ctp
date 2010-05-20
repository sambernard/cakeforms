<div class="submissions view">
<h2><?php  __('Submission');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $submission['Submission']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cform'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($submission['Cform']['name'], array('controller' => 'cforms', 'action' => 'view', $submission['Cform']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $submission['Submission']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ip'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $submission['Submission']['ip']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Submission', true), array('action' => 'edit', $submission['Submission']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Submission', true), array('action' => 'delete', $submission['Submission']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $submission['Submission']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Submissions', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Submission', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Cforms', true), array('controller' => 'cforms', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Cform', true), array('controller' => 'cforms', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Submission Fields', true), array('controller' => 'submission_fields', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Submission Field', true), array('controller' => 'submission_fields', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Submission Fields');?></h3>
	<?php if (!empty($submission['SubmissionField'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Submission Id'); ?></th>
		<th><?php __('Form Field'); ?></th>
		<th><?php __('Response'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($submission['SubmissionField'] as $submissionField):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $submissionField['id'];?></td>
			<td><?php echo $submissionField['submission_id'];?></td>
			<td><?php echo $submissionField['form_field'];?></td>
			<td><?php echo $submissionField['response'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller' => 'submission_fields', 'action' => 'view', $submissionField['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller' => 'submission_fields', 'action' => 'edit', $submissionField['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller' => 'submission_fields', 'action' => 'delete', $submissionField['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $submissionField['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Submission Field', true), array('controller' => 'submission_fields', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
