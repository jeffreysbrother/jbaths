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
<?php
/* Its more effective to create template for Walk in page. But dont have wp-login so doing conditional check for this page. */
if(is_page( 'walk-in' ))
{
	?>
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
			//Session Logic
			if((jQuery.cookie('currentsession')) !== '1')
			{
				jQuery.cookie('currentsession', '1');
				setTimeout(function(){
					jQuery('.close_popup_link').on("click", function(e) {
					    jQuery.fancybox.close(true);
					});
					jQuery("#openwalkinpopup").trigger('click');
				}, 3000);
			}
		});
	</script>
	<div class="triggerlink" style="display:none !important"><a  href="#walkinpopup" id="openwalkinpopup"></a></div>
	<div id="walkinpopup" class="aPop" style="display: none;">
		<div class="wpb_row vc_row-fluid">
			<div class="vc_span12 wpb_column">
				<div class="close_popup"><a href="#" class="close_popup_link">CLOSE X</a></div>
			</div>
		</div>	
		<div class="wpb_row vc_row-fluid">
			<div class="vc_span6 wpb_column popup_content">
				<h2>The Jacuzzi<sup>®</sup> Walk-In Tub<br>
                  <small>Remodel &amp; Replacement</small><br>
                  <small>Walk-In Bathtub</small><br></h2>
				<p>Blends safety and hydromassage to keep you healthy and happy in your home. Designed to fit in place of a standard bathtub. Also comes in compact and large sizes. Lifetime warranty.</p>
				<a href="http://www.hydrotherapybathing.com/about-walk-in-tubs/" class="vc_btn vc_btn_grey vc_btn_md vc_btn_square_outlined vc_btn_blue">LEARN MORE</a>
				<p style="margin-top:13px;"><small>DIY or installing yourself? <a href="/baths/bathtubs/finestra-bath/">Click here</a>.</small></p>
			</div>
			<div class="vc_span6 wpb_column popup_img">
				<img src="<?php bloginfo('template_url'); ?>/images/walkin_img.jpg" class="popup_img" />
			</div>
		</div>	
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
