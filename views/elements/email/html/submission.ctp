<h2>New "<?php echo $formData['name'];?>" Submission</h2>
<strong>Submitted On</strong> <?php echo date('m/d/y \a\t h:i A');?><br />
<strong>IP:</strong> <?php echo long2ip($response['Submission']['ip']);?><br />

=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
<table>
<?php foreach($response['Cform'] as $label => $data):?>
<?php
    $style = '';
    if(strstr($label, 'fs_')){
    $style = 'style="background:#ececec"';
    $label = $data;
    $data = null;
    }?>
<tr <?php echo $style;?>><td style="width:120px; padding-right: 10px; text-align: right"><strong><?php echo Inflector::humanize($label);?></strong></td><td style="width:450px"><?php echo $data;?></td></tr>
<?php endforeach;?>
</table>