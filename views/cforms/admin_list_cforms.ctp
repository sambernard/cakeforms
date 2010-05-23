<li class="insert_cform_sidebar">
    <h4>Insert a Form</h4>
    <p>To edit/create a form click <?php echo $html->link('here', array('controller' => 'cforms', 'action' => 'index', 'plugin' => 'cforms'));?>.</p>

    <?php echo
        $form->create(),
        $form->input('cforms', array('empty' => 'Select a Form')),
        $form->end('Insert Form');?>
</li>
