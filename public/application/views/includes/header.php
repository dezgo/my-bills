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
	<meta name="author" content="">

   <!-- CSS
    ================================================== -->
   <link rel="stylesheet" href="<?php echo base_url();?>css/default.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/layout.css">  
	<link rel="stylesheet" href="<?php echo base_url();?>css/media-queries.css"> 

   <!-- Script
   ================================================== -->
   <script src="js/modernizr.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   <script type="text/javascript" src="js/home.js"></script>

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

		      <h1 id="logo-text"><a href="index.html" title="">my-bills</a></h1>
				<p id="intro">No more surprises!</p>

			</div>			

	   </div>

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
			      	<li<?php echo addCurrent($this->router->class, "home"); ?>><a href="<?php echo base_url();?>home">Home</a></li>
			      	<li<?php echo addCurrent($this->router->class, "site"); ?>><a href="<?php echo base_url();?>site/members_area">Accounts</a></li>
			      	<li<?php echo addCurrent($this->router->class, "contact"); ?>><a href="<?php echo base_url();?>contact">Contact Us</a></li>
			      	<li<?php echo addCurrent($this->router->class, "setup"); ?>><a href="<?php echo base_url();?>setup">Setup</a></li>
			      	
			      	<?php if (is_logged_in()) { ?>
				      	<li<?php echo addCurrent($this->router->class, "logout"); ?>><a href="<?php echo base_url();?>site/logout">Logout</a></li>
				    <?php } else { ?>
				      	<li<?php echo addCurrent($this->router->class, "login"); ?>><a href="<?php echo base_url();?>">Login</a></li>
				    <?php } ?>
			   	</ul> <!-- end #nav -->			   	 

	   	</div> 

	   </nav> <!-- end #nav-wrap --> 	     

   </header> <!-- Header End -->
   