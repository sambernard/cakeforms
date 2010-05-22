<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php echo $html->charset(); ?>
	
	<title><?php echo $title_for_layout; ?></title>
	
	<meta name="description" content="" />
	
    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>favicon.ico" type="image/x-icon" />
	
	<?php 
        echo
        // Load your CSS files here
        $html->css(array(
	    '/cforms/css/cforms',
	    '/cforms/css/ui-lightness/jquery-ui-1.8.1.custom',
	    '/cforms/css/fancy_white',
        )),

        $javascript->link(array('/cforms/js/jquery-1.4.2.min.js', '/cforms/js/jquery-ui-1.8.1.custom.min.js'));
    ?>
     
    <!--[if lte IE 7]>
    <?php
        // CSS file for Microsoft Internet Explorer 7 and lower
        echo $html->css('/wildflower/css/wf.ie7');
    ?>
    <![endif]-->

    <?php echo $scripts_for_layout;?>    
</head>
<body>

    <div id="clean_box">
        <?php echo $content_for_layout; ?>
    </div>
    
</body>
</html>
