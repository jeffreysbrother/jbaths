<?php
/**
 * jbaths functions and definitions
 *
 * @package jbaths
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'jbaths_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jbaths_setup() {

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'jbaths' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list'
	) );
}
endif; // jbaths_setup
add_action( 'after_setup_theme', 'jbaths_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function jbaths_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar', 'jbaths' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'jbaths_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function jbaths_scripts() {
	$theme = wp_get_theme();
	// wtf
	wp_enqueue_style( 'wtf-forms', get_template_directory_uri() . '/css/wtf-forms.css', array(), '2.2.0' );
	// and then
	wp_enqueue_style( 'jbaths', get_stylesheet_uri(), array(), $theme->Version.'.1' );

	// store locator plus - specialty css
	if ( is_page('find-a-showroom') ) {
		wp_enqueue_style( 'jbaths-slp', get_template_directory_uri() . '/css/slp-baths.css', array(), $theme->Version ); // store locator plus
	}


	if ( !is_admin() ) {
		wp_register_script( 'jbaths.modernizr', get_stylesheet_directory_uri() .'/js/modernizr.min.js', array(), '2.8.3', true );
		wp_register_script( 'jquery.cookie', get_stylesheet_directory_uri() .'/js/jquery.cookie.js', array('jquery'), $theme->Version );
		wp_register_script( 'scrollupforwhat', get_stylesheet_directory_uri() .'/js/jquery.scrollupforwhat.min.js', array('jquery'), '1.2', true );
		wp_register_script( 'matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', array('jquery'), '0.5.2', true );
		
		$jbaths_deps = array( 'jquery', 'jbaths.modernizr', 'jquery.cookie', 'scrollupforwhat', 'matchHeight' );
		if ( is_singular( 'bathtubs' ) || is_singular( 'faucets' ) ) {
			if(get_option('ultimate_row') == "enable"){
				$jbaths_deps[] = 'ultimate-row-bg';
			}
		}
		wp_enqueue_script( 'jbaths', get_template_directory_uri() . '/js/baths.js', $jbaths_deps, '20140718', true );
	}
	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// Omniture SiteCatalyst
	wp_enqueue_script( 'sitecatalyst', get_template_directory_uri() . '/js/s_code.js', array(), $theme->Version, true );

	if ( is_singular('post') && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'jbaths_scripts', 90 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

function jbaths_post_orderer( $query ) {
	if ( !empty($query->query['post_type']) && $query->query['post_type'] == 'bathtubs' ) {
		if ( '' == get_query_var( 'orderby' ) ) {
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'asc' );
			//wp_die('<pre>'. print_r($query,true) .'</pre>');
		}
		if ( '' == get_query_var( 'posts_per_page' ) ) {
			$query->set( 'posts_per_page', -1 );
		}
		if ( !is_admin() ) {
			if ( is_post_type_archive( 'bathtubs' ) ) {
				// hide Finestra?
				$query->set( 'post__not_in', array( 309 ) );
			}
		}
	}
}
add_action( 'pre_get_posts', 'jbaths_post_orderer' );

// [bathinfo exp="pa" part="features"]
function jbaths_shortcode_bathinfo( $atts ) {
	// only render shortcode on the frontend
	if ( is_admin() ) return;

	$a = shortcode_atts( array(
		'exp' => '',
		'part' => '',
		'title' => '',
	), $atts );
	$oot = '';

	if ( in_array( $a['exp'], array( 'ss', 'w', 'pa', 's' ) ) ) {
		switch ( $a['part'] ) {
			case 'features':
				// features bullets
				$oot = '<h4>FEATURES</h4>';
				$oot .= '<ul>';
				switch ( $a['exp'] ) {
					case 'ss':
						$oot .= '<li>Combination of Whirlpool and Pure Air<sup>&reg;</sup> bath</li>';
						$oot .= '<li>Personalized massage options</li>';
						$oot .= '<li>Maximized jet count and placement</li>';
						break;
					case 'w':
						$oot .= '<li>Original Jacuzzi invented optimal air and water therapy</li>';
						$oot .= '<li>Customizable intensity and directionality</li>';
						$oot .= '<li>Industry-leading jet performance and design</li>';
						break;
					case 'pa':
						$oot .= '<li>Small air bubbles provide soothing massage</li>';
						$oot .= '<li>360&deg; air inlets ensure a whole body experience</li>';
						$oot .= '<li>Heated air blower keeps water pleasurably warm</li>';
						break;
					case 's':
						$oot .= '<li>Proven hydrotherapy in its fundamental form</li>';
						$oot .= '<li>Warm water promotes circulation and relaxation</li>';
						$oot .= '<li>Ergonomic designs cradle the bather</li>';
						break;
				}
				$oot .= '</ul>';
				break;
			case 'image':
				// left image
				$oot = '<img width="148" height="147" src="'. get_stylesheet_directory_uri() .'/images/exp/';
				switch ( $a['exp'] ) {
					case 'ss':
						$oot .= 'salon-spa.jpg" alt="Salon Spa" />';
						break;
					case 'pa':
						$oot .= 'pure-air.jpg" alt="Pure Air" />';
						break;
					case 's':
						$oot .= 'soaking.jpg" alt="Soaking" />';
						break;
					case 'w':
						$oot .= 'whirlpool.jpg" alt="Whirlpool" />';
						break;
				}
				break;
			default:
				// main copy paragraph
				switch ( $a['exp'] ) {
					case 'ss':
						if ( $a['title'] != 'false' ) {
							$oot = '<h3>SALON<sup>&reg;</sup> SPA</h3>';
						}
						$oot .= '<p>The ultimate combination: powerful jets and soothing air bubbles.<br /><br /> Salon Spa gives you the ultimate experience of both the Whirlpool and Pure Air<sup>&reg;</sup> bath... with no limits. If you&lsquo;ve just run a marathon  (or feel like it), choose the invigoration of a whirlpool massage. If you&lsquo;ve had a day that races past at a million miles an hour, choose the tranquil caress of a thousand bubbles. And if your day was taxing in every way, Salon Spa provides everything you need to feel renewed and refreshed.</p>';
						break;
					case 'w':
						if ( $a['title'] != 'false' ) {
							$oot = '<h3>WHIRLPOOL</h3>';
						}
						$oot .= '<p>Legendary Jacuzzi<sup>&reg;</sup> jets for optimal hydrotherapy.<br /><br />The whirlpool bath, powered by the legendary Jacuzzi<sup>&reg;</sup> jetting system, gives bathers a therapeutic, invigorating massage. The benefits of hydrotherapy are proven: if you work hard and play hard, a whirlpool bath is one of the best things you can do for your body.</p>';
						break;
					case 'pa':
						if ( $a['title'] != 'false' ) {
							$oot = '<h3>PURE AIR<sup>&reg;</sup> BATH</h3>';
						}
						$oot .= '<p>The gentle, embracing massage of warm air bubbles.<br /><br />When you choose a Pure Air<sup>&reg;</sup> bath, you give yourself the caressing sensation of warmed air inside thousands of bubbles. It&lsquo;s a gentle, full-body experience &mdash; and a pure pleasure.</p>';
						break;
					case 's':
						if ( $a['title'] != 'false' ) {
							$oot = '<h3>SOAKING</h3>';
						}
						$oot .= '<p>A quiet, calm soak: the foundation of hydrotherapy.<br /><br />For sitting, stretching, reading and relaxing, a soaking bath is a simple, tranquil pleasure.</p>';
						break;
				}
			break;
		}
	}
	return $oot;
}
add_shortcode( 'bathinfo', 'jbaths_shortcode_bathinfo' );
/*
 * shortcode to provide all Downloads (Media attachments)
 * in given Media Category ("cat")
 * either attached to the current post (by default),
 * or from all Media (att="false")
 *
 * [bathdls cat="specifications"] 
 * [bathdls cat="manuals" att="false"]
 */
function jbaths_shortcode_bathdls( $atts ) {
	global $post;
	// only render shortcode on the frontend
	if ( is_admin() ) return;

	$a = shortcode_atts( array(
		'cat' => '',
		'att' => 'true',
		'style' => 'p',
		'bathscat' => '',
	), $atts );
	$oot = '';
	
	if ( $a['cat'] == '' ) {
		$oot .= '<!-- "Media Category" missing? -->';
	} else {
		if ( in_array( $a['cat'], array( 'all-specifications', 'all-manuals' ) ) ) {
			$mcat = substr( $a['cat'], 4 );
			/*
			 * this will be a recursive call, used on ALL BATH MANUALS
			 * & SPECIFICATION SHEETS pages, to loop through all Tubs
			 * in a particular "bathscat" & then list all specs/manuals for each...
			 * with hardcoded term_id match to save another query or 2
			 */
			$term_id = false;
			switch ( $a['bathscat'] ) {
				case 'comfort':
					$term_id = 6;
					break;
				case 'luxury':
					$term_id = 5;
					break;
				case 'primo':
					$term_id = 7;
					break;
				case 'signature':
					$term_id = 8;
					break;
			}
			if ( $term_id == false ) {
				$oot .= '<!-- "bathscat" missing? -->';
			} else {
				$oot .= '<!-- bathscat = '. $a['bathscat'] .' : '. $term_id .' -->';
				$args = array(
					'post_type' => 'bathtubs',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'orderby' => 'title',
					'order' => 'DESC',
					'tax_query' => array( array(
						'taxonomy' => 'collection',
						'field' => 'term_id',
						'terms' => $term_id,
					)),
				);
				$baths = get_posts( $args );
				$n = count( $baths );
				$oot .= '<!-- '. $n .' tubs? -->';
				$b = '';
				while ( $n-- ) {
					// loop through all baths in given bathscat
					$b = '<p><strong>'. $baths[$n]->post_title .'</strong></p>';
					$b .= do_shortcode( '[bathdls cat="'. $mcat .'" att='. $baths[$n]->ID .' style="li"]' );
					$oot = $b . $oot;
				}
			}
		} elseif ( in_array( $a['cat'], array( 'specifications', 'manuals' ) ) ) {
			// assuming here we want PDFs for a given Bathtub...
			// $cat = get_term_by( 'slug', $a['cat'], 'mediacategory' );
			// instead, just hardcoded term_id match to save a query or 2
			$cat = 0;
			$catname = '';
			if ( $a['cat'] == 'specifications' ) {
				$cat = 31;
				$catname = 'Specifications';
			} else {
				// manuals?
				$cat = 32;
				$catname = 'Manuals';
				$mans = types_render_field('manuals');
				$mansraw = $mans;
				$mans = explode( ', ', $mans);
				krsort($mans);
				//$oot .= '<pre style="display:none">'. print_r($mansraw,true) .'</pre>';
				//$oot .= '<pre style="display:none">'. print_r($mans,true) .'</pre>';
			}
			if ( $cat > 0 ) {
				if ( $a['style'] == 'p' ) {
					$oot .= '<p>'. esc_attr( $catname ) .'<br />';
				} else {
					$oot .= '<ul>';
				}
				$args = array(
					'post_type' => 'attachment',
					'posts_per_page' => -1,
					'post_status' => 'any',
					'orderby' => 'menu_order',
					'order' => 'DESC',
					'tax_query' => array( array(
						'taxonomy' => 'mediacategory',
						'field' => 'term_id',
						'terms' => $cat,
					)),
				);
				if ( $a['att'] == 'true' ) {
				if ( $cat == 31 ) {
					$args['post_parent'] = $post->ID;
} else {
// instead do manuals this way
$args= array('post__in'=>$mans,
					'post_type' => 'attachment',
					'posts_per_page' => -1,
					'post_status' => 'any',
					'orderby' => 'post__in',
					'order' => 'ASC',
);
}
				} elseif( $a['att'] != 'false' ) {
					$args['post_parent'] = absint( $a['att'] );
				}
				$dls = get_posts( $args );
				//$oot .= '<pre style="display:none">'. print_r($args,true) .'</pre>';
				//$oot .= '<pre style="display:none">'. print_r($dls,true) .'</pre>';
				$n = count( $dls );
				if ( $n > 0 ) {
					while( $n-- ) {
						if ( $a['style'] == 'li' ) {
							$oot .= '<li>';
						}
						$oot .= '<a href="'. esc_url( $dls[$n]->guid ) .'" target="_blank">'. esc_attr( $dls[$n]->post_title ) .'</a>';
						if ( $a['style'] == 'p' ) {
							$oot .= '<br />';
						} else {
							$oot .= '</li>';
						}
					}
				} else {
					/*
					 * this is a legit download category,
					 * but none found for this shortcode call
					 */
					if ( $a['style'] == 'li' ) {
						$oot .= '<li>';
					}
					$oot .= 'Check back soon.';
					if ( $a['style'] == 'li' ) {
						$oot .= '</li>';
					}
				}
				if ( $a['style'] == 'p' ) {
				$oot .= '</p>';
				} else {
					$oot .= '</ul>';
				}
			}
		}
	}
	return $oot;
}
add_shortcode( 'bathdls', 'jbaths_shortcode_bathdls' );

/**
 * Add classes to <body>
 */

//Page Slug Body Class
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/*
 * admin bar tweaks
 */
function jbaths_adminbar_tweak() {
	global $wp_admin_bar;
	if ( is_post_type_archive( 'bathtubs' ) ) {
		$bp = get_page_by_title('Bathtubs');
		if ( $bp ) {
			$editbathspage = get_edit_post_link( $bp->ID );
			$wp_admin_bar->add_menu( array(
				'id' => 'edit',
				'title' => 'Edit Page',
				'href' => $editbathspage,
			));
		}
	}
}
add_action( 'wp_before_admin_bar_render', 'jbaths_adminbar_tweak' );

/**
 * Menu Bar search
 */
add_filter('wp_nav_menu_items','add_wheretobuy_to_menu', 10, 2);
function add_wheretobuy_to_menu( $items, $args ) {
    if( $args->theme_location == 'primary' ) {
    	$items .= '<li class="menu-item menu-item-search last">';
		$items .= '<a id="show-search-form" href="#search">Search</a>';
		$items .= '</li>';
		$items .= '<li id="menu-item-where-to-buy" class="where-to-buy menu-item"><a href="'.get_bloginfo('url').'/find-a-showroom/">Where To Buy</a></li>';
		return $items;
	}
    return $items;
}
add_shortcode('do_search_form', 'custom_search_form'); 
function custom_search_form() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active('relevanssi/relevanssi.php') ) {
	    $url = get_site_url(); 
	    $form = '<form role="search" method="get" id="searchform" class="search-form" action="'.$url.'"> 
					<input type="search" value="" name="s" id="s" class="search-field" autocomplete="on" placeholder="Search..." /> 
					<input type="submit" id="search-submit" class="search-submit" value="Search" /> 
				</form>';
	}
	else {
		$form = get_search_form();
	}
    return $form;
}


// [slp_search_widget name='widgets__advanced_slpWidget' title=null map_url_vars=null search_label='Enter Zipcode' button_label='Find a Showroom' use_placeholder=true radius=50]
if( ! function_exists('slp_search_bar_widget') ) {
	function slp_search_bar_widget( $atts ) {
	    
	    global $wp_widget_factory;
	    
	    extract(shortcode_atts(array(
			'name' => 'widgets__advanced_slpWidget',
			'title' => '<strong>Find a Showroom</strong> Near You',
			'map_url_vars' => null,
			'search_label' => 'Enter Zipcode',
			'button_label' => '►',
			'use_placeholder' => true,
			'radius' => 50,
			'class' => null
	    ), $atts));
	    
	    $name = wp_specialchars($name);
	    
	    if (!is_a($wp_widget_factory->widgets[$name], 'WP_Widget')):
	        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
	        
	        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
	            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
	        else:
	            $class = $wp_class;
	        endif;
	    endif;
	    
	    ob_start();
	    if ( !isset( $id ) ) {
		$id = 0;
		}
	    the_widget(
	    	$name, 
	    	array(
	    		'title' => $title,
	    		'map_url' => get_bloginfo('url').'/find-a-showroom/',
	    		'map_url_vars' => $map_url_vars,
	    		'search_label' => $search_label,
	    		'button_label' => $button_label,
	    		'use_placeholder' => $use_placeholder,
	    		'radius' => $radius
    		), 
	    	array('widget_id'=>'arbitrary-instance-'.$id,
	        	'before_widget' => '<div class="slp_search_widget '.$class.'"><img src="'.get_template_directory_uri().'/images/map-marker-white.png" />',
	        	'after_widget' => '</div>',
	        	'before_title' => '<span class="slp_search_widget_title">',
	        	'after_title' => '</span>'
	    	)
    	);
	    $output = ob_get_contents();
	    ob_end_clean();
	    return $output;
	}
	add_shortcode( 'slp_search_widget', 'slp_search_bar_widget' );
}


/**
 * GOOGLE TAG MANAGER SUPPORT / DATA LAYER SUPPORT
 *
 */

// Custom data layer
add_action('do_custom_data_layer', 'custom_data_layer_container');
if(!function_exists('custom_data_layer_container')) {
	function custom_data_layer_container() {
		global $post;

		$str = '<script>dataLayer = [{';
		$str .= '\'customerId\': \'' . get_current_user_id() . '\',';

		// add custom data layer vars here...
		
		$str .= '}];</script>';

		echo $str;
	}
}
if(!function_exists('custom_data_layer')) {
	function custom_data_layer() {
		do_action('do_custom_data_layer');
	}
}

// Google Tag Manager Main
add_action('do_google_tag_manager', 'google_tag_manager_container');
if(!function_exists('google_tag_manager_container')) {
	function google_tag_manager_container() {
		$str = <<<GTM
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PWPB3S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PWPB3S');</script>
<!-- End Google Tag Manager -->
GTM;
		echo $str;
	}
}
if(!function_exists('google_tag_manager')) {
	function google_tag_manager() {
		do_action('do_google_tag_manager');
	}
}
/** END GTM */



/* = = = = THIS DOESN"T WORK = = = = =
 * = = = = Too many JS conflicts with other rewrites and bind events = = = = =
 */
/*
if (!function_exists('site_reg_fixer_js')) {
function site_reg_fixer_js() {
	if(!is_front_page()){
		?>
		<script type="text/javascript">
		jQuery(function($){
			$("body").html(
				$("body").html().replace(/<sup>&reg;<\/sup>/gi, '&reg;').
					replace(/&reg;/gi, '<sup>&reg;</sup>').
					replace(/®/gi, '<sup>&reg;</sup>').
					replace("\u00AE", '<sup>&reg;</sup>')
			);
		});
		</script>
	<?php }
}
}
add_action('wp_footer', 'site_reg_fixer_js', 100);
*/


function jbaths_qvars($aVars) {
	$aVars[] = 't';
	return $aVars;
}
add_filter( 'query_vars', 'jbaths_qvars' );



add_filter('post_limits', 'jbaths_postsperpage');
function jbaths_postsperpage($limits) {
	if (is_search()) {
		global $wp_query;
		$wp_query->query_vars['posts_per_page'] = 16;
	}
	return $limits;
}

function my_searchwp_query_orderby() {
	global $wpdb;
	return "ORDER BY {$wpdb->prefix}posts.post_type DESC, {$wpdb->prefix}posts.post_date DESC";
}

add_filter( 'searchwp_query_orderby', 'my_searchwp_query_orderby' );


