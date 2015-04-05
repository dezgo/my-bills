<?php 	$this->lang->load('standard'); ?>
<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<!--- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<title><?php echo $this->lang->line('title'); ?></title>
	<meta name="description" content="remember-my-bills is a simple web-based reminder system for your regular bills. Use it to ensure you never forget a bill again. Add a bill, enter when it's next due, and how many times per year it comes up Once entered, remember-my-bills will send a reminder email when the bill is next due. You then pay the bill, and the next bill will be automatically scheduled.">  
	<meta name="author" content="Derek Gillett">

	<!-- CSS
	================================================== -->
	<link rel="stylesheet" href="<?php echo base_url();?>css/default.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/layout.css">  
	<link rel="stylesheet" href="<?php echo base_url();?>css/media-queries.css"> 

	<!-- Script
	================================================== -->
	<script src="<?php echo base_url();?>js/modernizr.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/home.js"></script>

	<!-- Favicons
	================================================== -->
	<link rel="shortcut icon" href="favicon.png" >

</head>

<body>
   <!-- Header
   ================================================== -->
   <header id="top">

   	<div class="row">

   		<div class="header-content twelve columns">

		      <h1 id="logo-text"><a href="#" title=""><?php echo $this->lang->line('title'); ?></a></h1>
				<p id="intro"><?php echo $this->lang->line('subtitle'); ?></p>

			</div>			

	   </div>
<?php if (!isset($ignoreMenu)) { ?>
	   <nav id="nav-wrap"> 

	   	<a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show Menu</a>
		   <a class="mobile-btn" href="#" title="Hide navigation">Hide Menu</a>

	   	<div class="row">    		            
<?php 
function addCurrent($class, $pagename)
{
	if ($pagename == $class)
		return ' class="current"';
	else
		return '';
}
?>
			   	<ul id="nav" class="nav">
			      	<?php 
			      	echo "<li" . addCurrent($this->router->class, "home") .">". anchor('Home',$this->lang->line('menu_home')) . '</li>';
			      	echo "<li" . addCurrent($this->router->class, "contact") .">". anchor('Contact',$this->lang->line('menu_contact_us')) . '</li>';
			      	
			      	if (is_logged_in()) {
				      	echo '<li' . addCurrent($this->router->class, "site") .">". anchor('Site/members_area',$this->lang->line('menu_accounts')) . '</li>';
				      	echo '<li' . addCurrent($this->router->class, "payments") .">". anchor('Payments/show_list',$this->lang->line('menu_payments')) . '</li>';
			      		echo '<li' . addCurrent($this->router->class, "settings") .">". anchor('Settings',$this->lang->line('menu_settings')) . '</li>';
				      	echo '<li class="has-children"><a href="#">'.$_SESSION['email_address'].'</a>';
				      	echo '<ul>';
				      	echo '<li>'. anchor('Site/profile',$this->lang->line('menu_profile')) . '</li>';
				      	echo '<li>'. anchor('Site/logout',$this->lang->line('menu_logout')) . '</li>';
				      	echo "</ul></li>";
			      	} 
				    
				    if (is_admin()) { ?>
					<li class="has-children"><a href="#">Admin</a>
	                  <ul>
			      		 <li><?php echo anchor('Setup/create/true', 'Create DB with data'); ?></li>
						 <li><?php echo anchor('Setup/create', 'Create empty DB'); ?></li>
						 <li><?php echo anchor('Email', 'Send Email'); ?></li>
	                  </ul>
	               </li>
	               <?php } ?>
	               
			   	</ul> <!-- end #nav -->			   	 
	   	</div> 

	   </nav> <!-- end #nav-wrap --> 	     
<?php } ?>

   </header> <!-- Header End -->
