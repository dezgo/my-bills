<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

   <!--- Basic Page Needs
   ================================================== -->
   <meta charset="utf-8">
	<title>my-bills</title>
	<meta name="description" content="">  
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

		      <h1 id="logo-text"><a href="#" title="">my-bills</a></h1>
				<p id="intro">No more surprises!</p>

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
			      	echo "<li" . addCurrent($this->router->class, "home") .">". anchor('home','Home') . '</li>';
			      	echo "<li" . addCurrent($this->router->class, "contact") .">". anchor('contact','Contact Us') . '</li>';
			      	
			      	if (is_logged_in()) {
				      	echo "<li" . addCurrent($this->router->class, "site") .">". anchor('site/members_area','Accounts') . '</li>';
				      	echo "<li" . addCurrent($this->router->class, "payments") .">". anchor('payments/show_list','Payments') . '</li>';
			      		echo "<li" . addCurrent($this->router->class, "settings") .">". anchor('settings','Settings') . '</li>';
				      	echo "<li" . addCurrent($this->router->class, "logout") .">". anchor('site/logout','Logout') . '</li>';
				    } 
				    
				    if (is_admin()) { ?>
					<li class="has-children"><a href="#">Admin</a>
	                  <ul>
			      		 <li><?php echo anchor('setup/create/true', 'Create DB with data'); ?></li>
						 <li><?php echo anchor('setup/create', 'Create empty DB'); ?></li>
						 <li><?php echo anchor('email', 'Send Email'); ?></li>
	                  </ul>
	               </li>
	               <?php } ?>
	               
			   	</ul> <!-- end #nav -->			   	 
	   	</div> 

	   </nav> <!-- end #nav-wrap --> 	     
<?php } ?>

   </header> <!-- Header End -->
   
