New "<?php echo $formData['name'];?>" Submission
Submitted On <?php echo date('m/d/y \a\t h:i A'), "\n";?>
IP: <?php echo long2ip($response['Submission']['ip']);?>

=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

<?php foreach($response['Cform'] as $label => $data):?>
<?php
    $style = '';
    if(strstr($label, 'fs_')){
    $label = "\n" . $data;
    $data = null;
    }?>
<?php echo str_pad(Inflector::humanize($label), 25, '.');?><?php echo $data . "\n";?>
<?php endforeach;?>