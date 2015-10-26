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
			    now;

			if( (jQuery.cookie('idlePopped') == "true" ) || ( jQuery('body').is('.page-brochure-request') ) ) return false;

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
	<div id="broPop" class="broPop" style="display: none;">
		<div class="wpb_row vc_row-fluid">
			<div class="vc_span12 wpb_column">
				<div class="close_popup"><a href="#" class="close_popup_link">CLOSE X</a></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>		
		<div class="wpb_row vc_row-fluid">
			<div class="vc_span6 wpb_column popup_content">
				<h2>Discover why a Jacuzzi<sup>®</sup> Bathtub is the right choice</h2>
				<ul>
					<li>See inside the structure of a Jacuzzi<sup>®</sup>&npbsp;Bathtub</li>
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

	<footer id="footer" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php get_sidebar(); ?>
		</div><!-- .site-info? -->
	</footer><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
