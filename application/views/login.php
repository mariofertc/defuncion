<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1"/>
<title>Hospital <?php echo $this->lang->line('login_login'); ?></title>

<link href="<?php echo base_url(); ?>js/jquery-mobile/jquery.mobile.theme-1.3.2.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>js/jquery-mobile/jquery.mobile.structure-1.3.2.min.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo base_url(); ?>js/jquery/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery/jquery.mobile-1.3.2.min.js"></script>



<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>

<style>
body{ 


 }
	
</style>

</head>
<body>
<div data-role="page" data-theme="none" style="font-family:verdana;font-size:0.8em">
<?php echo form_open('login', array("target"=>"_self")) ?>
<div data-role ="header">
<h1>Hospital 0.1</h1>
</div>
<div data-role ="content">
<?php echo validation_errors(); ?>
	<div id="top">
	<?php echo $this->lang->line('login_login'); ?>
	</div>
	<div id="login_form">
		<div id="welcome_message">
		<?php echo $this->lang->line('login_welcome_message'); ?>
		</div>
		
		<div class="form_field_label"><?php echo $this->lang->line('login_username'); ?>: </div>
		<div class="form_field">
		<?php echo form_input(array(
		'name'=>'username', 
		'value'=>set_value('username'),
		'size'=>'20')); ?>
		</div>

		<div class="form_field_label"><?php echo $this->lang->line('login_password'); ?>: </div>
		<div class="form_field">
		<?php echo form_password(array(
		'name'=>'password', 
		'value'=>set_value('password'),
		'size'=>'20')); ?>
		
		</div>
		
		<div id="submit_button">
		<?php echo form_submit('loginButton','Entrar'); ?>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
	<div data-role ="footer">
	<h1>CopyRight 2014</h1>
	</div>
</div>
</body>
</html>
