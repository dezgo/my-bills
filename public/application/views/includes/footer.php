<!-- Footer
   ================================================== -->
   <footer>

      <div class="row"> 

      	<div class="twelve columns">	
			<ul class="social-links">
				<li><a target="_blank" href="http://www.facebook.com/share.php?u=<?php echo base_url()?>"><i class="fa fa-facebook"></i></a></li>
				<li><a target="_blank" href="https://twitter.com/home?status=<?php echo base_url()?>"><i class="fa fa-twitter"></i></a></li>
				<li><a target="_blank" href="https://plus.google.com/share?url=<?php echo base_url()?>"><i class="fa fa-google-plus"></i></a></li>               
				<li><a target="_blank" href="http://digg.com/submit?phase=2&amp;url=<?php echo base_url()?>"><i class="fa fa-digg"></i></a></li>
				<li><a target="_blank" href="http://del.icio.us/post?url=<?php echo base_url()?>"><i class="fa fa-delicious"></i></a></li>                                             
				</ul>			
      	</div>
      	
         <div class="eight columns info">

            <h3>About my-bills</h3> 

            <p>remember-my-bills is a simple web-based reminder system for your regular bills. Use it to 
            ensure you never forget a bill again. Add a bill, enter when it's next due, and how many times per year it comes up
            Once entered, remember-my-bills will send a reminder
            email when the bill is next due. You then pay the bill, and the next bill will be automatically scheduled.</p>
            <?php echo $_SESSION['count_members']?>&nbsp;bill payers are already being reminded. Get started now!
            <p>
         </div>

         <div class="four columns">
            <h3 class="social">Navigate</h3>

            <ul class="navigate group">
            <?php 
               echo "<li>".anchor('Site','Home','')."</li>";
               echo "<li>".anchor('Contact','Contact Us')."</li>";

				if (is_logged_in()) {
			      	echo "<li>". anchor('Site/members_area','Accounts') . '</li>';
			      	echo "<li>". anchor('Payments/show_list','Payments') . '</li>';
		      		echo "<li>". anchor('Settings','Settings') . '</li>';
			      	echo "<li>". anchor('Site/logout','Logout') . '</li>';
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
            </ul>
         </div>

         <p class="copyright">&copy; Copyright 2015 remember-my-bills. &nbsp; Design by <a title="Styleshout" href="http://www.styleshout.com/">Styleshout</a>.
         
<a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=remembermybills.com','SiteLock','width=600,height=600,left=160,top=170');" ><img alt="website security" title="SiteLock" src="//shield.sitelock.com/shield/remembermybills.com"/></a>
         
         </p>
        
      </div> <!-- End row -->

      <div id="go-top"><a class="smoothscroll" title="Back to Top" href="#top"><i class="fa fa-chevron-up"></i></a></div>

   </footer> <!-- End Footer-->


   <!-- Java Script
   ================================================== -->
   <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
   <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>  
   <script src="js/main.js"></script>

</body>

</html>
