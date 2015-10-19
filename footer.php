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
			jQuery("#openBroPop").fancybox({
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
				scrolling : 'no' });
			
			var bPageView = false,
			    bSession = false,
			    pageViews;
			
			//Session initiates if not already
			if( !jQuery.cookie('currentSession') ){
				bSession = true;
				jQuery.cookie('currentSession', '1');
				jQuery.cookie('pageViews', '0', { expires:365 })}
			
			pageViews = parseInt(jQuery.cookie('pageViews'));					
			if( ++pageViews > 4 && bSession == true){
				doPop() }
			else{
				jQuery.cookie('pageViews', pageViews, { expires: 365 })}

			function doPop(){
				bPageView = true;
				bSession = false; //while the corresponding cookie exists this will remain so
				setTimeout(function(){
					jQuery("#openBroPop").trigger('click') }, 3000) }
			
			jQuery('.close_popup_link').on("click", function(e) {
			    jQuery.fancybox.close(true) }) });
		
	</script>
	<div class="triggerlink" style="display:none !important"><a  href="#broPop" id="openBroPop"></a></div>
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
				<h2>The Best of Baths</h2>
				<p>If you've never experienced Jacuzzi<sup>®</sup> that's unforntunate. A tragedy truly. As a condolence we offer you a download of our brochure. You can print it out and put it next to your bath. So the next time you bath you may peruse the pages while visualizing your impending overwhelming fulfillment in owning the ultimate bath.</p>
				<!-- <p>Bathing as never imagined starts with your personal vessel of warm, enveloping water. For you, every possibility has been imagined … Shape … Setting … Experience … All for your personal, rapturous delight. Be enchanted … Only with the Jacuzzi<sup>®</sup> brand.</p> -->
				<a href="/support/brochure-request/" class="vc_btn vc_btn_grey vc_btn_md vc_btn_square_outlined vc_btn_blue">Get Your Brochure</a>
			</div>
			<div class="vc_span6 wpb_column popup_img">
				<img src="<?php bloginfo('template_url'); ?>/images/walkin_img.jpg" class="popup_img" />
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
