<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package jbaths
 */
?>

	</div><!-- #content -->
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/jquery.fancybox.pack.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
	<script type="text/javascript">
		jQuery(document).ready(function() {
			
			var msLeft,
			    pagesLeft,
			    idleTimeoutID,
			    now,
			    page = jQuery('body');

			if( jQuery.cookie('idlePopped') == "true" ||
				page.is('.page-brochure-request') ||
				page.is('.page-information') ||
				page.is('.page-warranty-registration') ||
				page.is('.page-walk-in')
			  ) { return false } //early return skips everything below

			if( jQuery.cookie("idlePagesLeft") && jQuery.cookie("idleCountdown") && jQuery.cookie("idleStamp")) {
			    //ilding has been previously underway
				pagesLeft = jQuery.cookie("idlePagesLeft");
				msLeft = jQuery.cookie("idleCountdown");
				if(--pagesLeft < 1) idleTimeoutID = setTimeout(idlePopup, msLeft);
				jQuery.cookie("idlePagesLeft",pagesLeft, {path: '/' }) }
			else{
			    //initate idling. config vars here...
				msLeft = 180000; // total time in milliseconds before the popup will trigger
				pagesLeft = 3; // number of pages the visitor sees before the popup will trigger
				now = new Date().getTime();
				jQuery.cookie("idlePagesLeft",pagesLeft, {path: '/' });
				jQuery.cookie("idleCountdown",msLeft, {path: '/' });
				jQuery.cookie("idleStamp",now, {path: '/' }); }

			
			jQuery(window).unload(function() {
				var now = new Date().getTime(),
				    startStamp = jQuery.cookie("idleStamp"),
				    msDiff = now - startStamp,
				    msLeft = jQuery.cookie("idleCountdown");
				clearTimeout(idleTimeoutID);
				msLeft -= msDiff;
				jQuery.cookie("idleCountdown",msLeft, {path: '/' });
			});

			function idlePopup() {	
				jQuery.cookie("idlePagesLeft",null, {path: '/' });
				jQuery.cookie("idleCountdown",null, {path: '/' });
				jQuery.cookie("idleStamp",null, {path: '/' });
				jQuery.cookie("idlePopped",true, {expires: 14, path: '/' });
				jQuery("#openBroPop").fancybox({
					maxWidth	: 660,
					maxHeight	: 660,
					fitToView	: false,
					width		: '100%',
					height		: 'auto',
					autoSize	: false,
					closeClick	: false,
					openEffect	: 'none',
					closeEffect	: 'none',
					closeBtn : false,
					scrolling : 'no' });
				jQuery('#openBroPop').trigger('click');
				jQuery('.close_popup_link').on("click", function(e) {
				    jQuery.fancybox.close(true) });
				return false;
			}});
		
	</script>
	<div class="triggerlink" style="display:none !important"><a href="#broPop" id="openBroPop" accesskey="P"></a></div>
	<div id="broPop" class="aPop" style="display: none;">
		<div class="wpb_row vc_row-fluid">
			<div class="vc_span12 wpb_column">
				<div class="close_popup"><a href="#" class="close_popup_link">CLOSE X</a></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>		
		<div class="wpb_row vc_row-fluid">
			<div class="vc_span6 wpb_column popup_content">
				<h2>Discover why a Jacuzzi<sup>®</sup>&nbsp;Bathtub is the right choice</h2>
				<ul>
					<li>See inside the structure of a Jacuzzi<sup>®</sup>&nbsp;Bathtub</li>
					<li>Compare features across models</li>
					<li>Explore inspirational photos</li>
				</ul>
				<a href="http://www.jacuzzi.com/baths/support/brochure-request/" class="vc_btn vc_btn_grey vc_btn_md vc_btn_square_outlined vc_btn_blue">Get Your Brochure</a>
			</div>
			<div class="vc_span6 wpb_column popup_img">
				<img src="<?php bloginfo('template_url'); ?>/images/brochure-cover.jpg" class="popup_img" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>	
	</div>
	<?php
		/* Its more effective to create template for Walk in page. But dont have wp-login so doing conditional check for this page. */
		if(is_page( 'walk-in' ))
		{
			?>
				<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/jquery.fancybox.pack.js"></script>
				<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery("#openwalkinpopup").fancybox({
															maxWidth	: 900,
															maxHeight	: 800,
															fitToView	: false,
															width		: '100%',
															height		: 'auto',
															autoSize	: false,
															closeClick	: false,
															openEffect	: 'none',
															closeEffect	: 'none',
															closeBtn : false,
															scrolling : 'no'
														});
						
						//Cookie Logic
						var openpopuppv = false;
						var openpopupsess = false;
						
						//Session Logic
						if(jQuery.cookie('currentsession'))
						{
							openpopupsess = false;
						}
						else
						{
							openpopupsess = true;
							jQuery.cookie('currentsession', '1');
						}
						//Page Views Logic
						if(jQuery.cookie('totalwalkin'))
						{
							var totalviews = parseInt(jQuery.cookie('totalwalkin'));
							
							if(totalviews <= 5)
							{
								openpopuppv = true;
								totalviews += 1;
								jQuery.cookie('totalwalkin', totalviews, { expires: 365 });
							}
						}
						else
						{
							openpopuppv = true;
							jQuery.cookie('totalwalkin', '1', { expires: 365 });
						}
						
						if(openpopupsess && openpopuppv)
						{
							setTimeout(function(){
								jQuery("#openwalkinpopup").trigger('click');
							}, 3000);	
						}
						
						
						jQuery('.close_popup_link').on("click", function(e) {
						    jQuery.fancybox.close(true);
						});

					});
				</script>
				<div class="triggerlink" style="display:none !important"><a  href="#walkinpopup" id="openwalkinpopup"></a></div>
				<div id="walkinpopup" class="aPop" style="display: none;">
					<div class="wpb_row vc_row-fluid">
						<div class="vc_span12 wpb_column">
							<div class="close_popup"><a href="#" class="close_popup_link">CLOSE X</a></div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>		
					<div class="wpb_row vc_row-fluid">
						<div class="vc_span6 wpb_column popup_content">
							<h2>WALK-IN TUBS<br/>FOR EXISTING HOMES</h2>
							<p>The safer, more luxurious alternative to a traditional bath. Made to fit your existing bath space without any major remodeling required.</p>
							<p>Limited Lifetime Warranty</p>
							<a href="http://www.hydrotherapybathing.com/about-walk-in-tubs/" class="vc_btn vc_btn_grey vc_btn_md vc_btn_square_outlined vc_btn_blue">LEARN MORE</a>
						</div>
						<div class="vc_span6 wpb_column popup_img">
							<img src="<?php bloginfo('template_url'); ?>/images/walkin_img.jpg" class="popup_img" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>	
				</div>
				
			<?php 	
		}
	?>
	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php get_sidebar(); ?>
		</div><!-- .site-info? -->
	</footer><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
