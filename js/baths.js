/**
 * baths frontend items
 * sorry for the tab madness?
 * will clean up some time
 */
jQuery(function($){
	// wp-admin bar fix
	if( $('div#wpadminbar').is(":visible") && $(window).width() >= 1000 ){
		$('header.site-header').css('top', 32);
	}
	$( window ).resize(function() {
		if( $('div#wpadminbar').is(":visible") && $(window).width() >= 1000 ){
			$('header.site-header').css('top', 32);
		} else {
			$('header.site-header').css('top', 0);
		}
	});
	
	// extra js here?
	$('.jicn_find, .jicn_buy').prepend('<i />');

	if( $('.baths-results').size() ) {
		var bathrottle;
		var prevwhash = '';
		$(window).bind({
			'hashchange': function() {
				var whash = '' + window.location.hash;
				var showbpagecontent = true;
				var findex = whash.indexOf('#filter');
				if ( findex >= 0 ) {
					showbpagecontent = false;
					$('.baths-filters,.baths-results').show();
					$('.baths-content').hide();
					// uncheck all filters
					$('.baths-filters input:checkbox').prop('checked',false);

					if ( whash.length > 8 ) {
						/*
						 * maybe like #filter=rectangle
						 * or #filter=oval,luxury,free-standing
						 */
						var chex = whash.substr(8);
						//console.log('check : '+ chex);
						chex = chex.split(',');
						var c = chex.length;
						while ( c-- ) {
							// todo : SIZE too..
							var filt = chex[c];
							var fstart = filt.substr(0,5);
							//console.log(' chex['+ c + '] = ' + fstart + ' . ' + chex[c].substr(5) );
							if ( fstart == 'width' ) {
								filt = filt.substr(5);
								$('#filter-width').val(filt);
							} else if ( fstart == 'lngth' ) {
								filt = filt.substr(5);
								$('#filter-length').val(filt);
							} else {
								$('.baths-filters input:checkbox[name*="'+chex[c]+'"]').prop('checked',true);
							}
						}
						// and then
						$(this).trigger('bathash');
						$(this).trigger('bathfilter');
					} else {
						$(this).trigger('bathreset');
					}
				}

				if ( showbpagecontent ) {
					$(this).trigger('bathcontent');
					$(this).scrollTop(0);
				} else {
					if ( prevwhash.indexOf('#filter') < 0 ) {
						/*
						 * coming from the Baths landing content,
						 * so reset back to top
						 */
						$(this).scrollTop(0);
					}
				}
				prevwhash = whash; // for next time
			},
			'bathcontent': function() {
				$('.baths-filters,.baths-results').hide();
				$('.baths-content').show();
			},
			'bathfilter': function() {
				clearTimeout(bathrottle);
				var cgroups = [];
				// size dropdowns
				$('.baths-filters select').each(function() {
					cgroups.push( $(this).val() );
				});
				// other filter checkboxes
								$('.baths-filters .chx').each(function() {
					var chx = [];
					$(this).find('input:checked').each(function() {
						chx.push($(this).val());
				});
					if ( chx.length > 0 ) {
						cgroups.push(chx);
					}
				});
				//console.log(cgroups);
				var baths = $('.baths-results .bathtub');
				var empt = false;
				if ( cgroups.length > 0 ) {
					baths.hide();
					$(cgroups).each(function(i,v) {
						/*
						console.log('filter : '+ i + ' : ');
						console.log(v);
						*/
						if ( i < 2 ) {
							// size
							if ( v != '' ) {
								v = parseInt(v);
								var atr = 'min-' + ( i ? 'width' : 'length' );
								//console.log('filter '+ atr);
								baths = baths.filter( function( index ) {
									var sz = $(this).data(atr);
									var ok = 0;
									if ( sz != '' ) {
										sz = parseInt(sz);
										ok = sz <= v;
										//console.log(index + ' : '+ sz + ' <= ' + v + ' ? ' + ok );
									}
									return ok;
								});
							}
						} else {
							// chx
							var cl = '.'+ v.join(', .');
							baths = baths.filter(cl);
						}
					});
					if ( baths.size() > 0 ) {
						baths.show();
					} else {
						empt = true;
					}
				}
				
				$('.baths-results').each(function() {
					$(this).children('.empty').remove();
					if ( empt ) {
						$(this).prepend('<div class="empty"><h2>Sorry, but there aren\'t any baths that meet your search criteria. Please change one or more of your selections to search again.</h2></div>');
					}
				});
			},
			'bathreset': function() {
				$('.baths-results .bathtub').show();
			},
			'bathrottle': function() {
				clearTimeout(bathrottle);
				bathrottle = setTimeout( function() {
					jQuery(window).trigger('bathfilter');
				}, 100 );
			},
			'bathash': function() {
				var whash = 'filter';
				var car = [];
				var chx = $('.baths-filters').find('select, input:checked');
				chx.each(function(i) {
					var v = $(this).val();
					if ( i < 2 ) {
						if ( v != '' ) {
							car.push( ( i ? 'width' : 'lngth' ) + v );
						}
					} else {
						car.push(v);
					}
				});
				if ( car.length ) {
					car = car.join(',');
					whash += '='+ car;
				} else {
					car = null;
				}
				$.cookie("bathsFilter", car, {path: '/' });
				window.location.hash = whash;
			}
		}).trigger('hashchange');
		$('.baths-filters').each(function() {
		$(this).find('input:checkbox').bind('click', function() {
			$(window).trigger('bathash');
		});
		$(this).find('select').bind('change', function() {
			$(window).trigger('bathash');
		});
		$(this).find('a.vc_btn').bind('click', function() {
				$.cookie("bathsFilter", null, {path: '/' });
		});
		});
 		// fix for matchheight on Baths landing Experiences
 		$('.wpb_row.exp > .wpb_column').matchHeight();
	}
	if ( $('.wpb_row.lifestyle').size() > 0 ) {
		var lhrow = $('.wpb_row.lifestyle');
		lhrow.css('overflow','hidden');
		$(window).bind('resize', function() {
			var wh = $(window).height();
			var hh = $('#masthead').height();
			var wah = $('#wpadminbar').height();
			var lh = Math.floor(0.8 * ( wh - hh - wah ) );
			lhrow.height(lh);
			//console.log('resize : wh '+ wh + ' - hh '+ hh + ' - ah ' + wah + ' = '+ lh );
		}).trigger('resize');
	}
	if ( $('body').hasClass('single-bathtubs') ) {
		// no way in Visual Composer to add Classes to Tabs otherwise?
		$('.experiences .wpb_tabs_nav a').each(function() {
			var h = $(this).html().toLowerCase().replace(/\s+/g,'');
			// hax for PURE<SUP>&REG;</SUP> AIR
			c = h.substr(0,4);
			switch ( c ) {
				case 'salo': 
					h = 'salonspa';
					break;
				case 'whir': 
					h = 'whirlpool';
					break;
				case 'pure': 
					h = 'pureair';
					break;
				case 'soaking': 
					h = 'soaking';
					break;
			}
			$(this).parent().addClass(h);
			var tar = $(this).attr('href');
			$(tar).addClass(h);
		});
		// ult-bg height fx?
		var ultbg = $('.upb_row_bg');
		if ( ultbg.size() > 0 ) {
			$(window).bind('resize.bathsult', function() {
				var wh = $(this).height();
				var bgh = wh - 90;
				var bh = jQuery('.site-header');
				if ( bh.size() ) {
					bgh -= bh.height();
				}
				var ba = jQuery('#wpadminbar');
				if ( ba.size() ) {
					bgh -= ba.height();
				}
				ultbg.parent().css('min-height', bgh);
			}).trigger('resize.bathsult');
		}
	}
	if ( $('body').hasClass('single-faucets') ) {
		// ult-bg height fx?
		var ultbg = $('.upb_row_bg');
		if ( ultbg.size() > 0 ) {
			$(window).bind('resize.faucetsult', function() {
				var wh = $(this).height();
				var bgh = wh - 90;
				var bh = jQuery('.site-header');
				var eh = jQuery('.entry-header');
				if ( bh.size() ) {
					bgh -= bh.height();
				}
				if ( eh.size() ) {
					bgh -= eh.height();
				}
				var ba = jQuery('#wpadminbar');
				if ( ba.size() ) {
					bgh -= ba.height();
				}
				ultbg.parent().css('min-height', bgh);
			}).trigger('resize.faucetsult');
		}
	}
	// if .tobaths then set href with previous filter
	$('a.tobaths').attr( 'href', function( i, val ) {
		var ck = $.cookie('bathsFilter');
		return val + '#filter' + ( ck ? '='+ ck : '' );
	});
	// reset bathsFilter cookie whenever we load a page that isnt /bathtubs/...
	var wloc = '' + window.location.href;
	if ( wloc.indexOf('/bathtubs/') < 0 ) {
		$.cookie("bathsFilter", null, {path: '/' });
	}
	
	/**
	 *	Counter fix for markers
	 */
	$('#location_id').each(function(i){
		$(this).find('span').text(i+1);
	});
	
	/**
	 *	matchHeight call for better responsiveness and alignment
	 */
	$('.hmatch').matchHeight(false);
    
});

/**
 * _s : navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
	var container, button, menu;

	container = document.getElementById( 'site-navigation' );
	if ( ! container )
		return;

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button )
		return;

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( -1 === menu.className.indexOf( 'nav-menu' ) )
		menu.className += ' nav-menu';

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) )
			container.className = container.className.replace( ' toggled', '' );
		else
			container.className += ' toggled';
	};
} )();


/**
 * Top Menu Stuff - Search Bar control, etc.
 */
jQuery(function($){

	// Menu width fix for IE/Safari
	function baths_menu_width_fix() {
		var hw = $('#masthead').width(), // header width
			lw = Math.max( $('div.site-branding').width(), 160); // logo width with padding
		return ( hw - lw );
	}
	// set width on page load
	if ( !$('button.menu-toggle').is(":visible") ) {
		$('#site-navigation').css( 'width', baths_menu_width_fix() );
	}
	$(window).resize(function(){
		// on resize...
		if ( !$('button.menu-toggle').is(":visible") ) {
			// if desktop, re-set width
			$('#site-navigation').css( 'width', baths_menu_width_fix() );
		}
		else {
			// if mobile, set width 100%
			$('#site-navigation').css( 'width', '100%' );
		}
	});



	// top menu search stuff...
	var searchshow = $('.main-navigation a#show-search-form');
	var searchform = $('.main-navigation form.search-form');
	var searchsubmit = $('input[type="submit"].search-submit');
	var searchfield = $('input[type="search"].search-field');
	
	// show search form (desktop)
	searchshow.click(function(e){
		e.preventDefault;
		searchform.animate({
			width: "100%"
		}, 350);
		searchfield.focus();
	});
	
	// search submit versus display show/hide etc.
	searchsubmit.click(function(e){
		// if search is empty...
		if( !searchfield.val() && searchfield.is(":visible") ) {
			// do not submit
			e.preventDefault();
			// if desktop...
			if( !$('nav.main-navigation').hasClass('toggled') ) {
				searchform.animate({
					width: 0
				}, 350); // hide search form (desktop)
				//searchfield.val(''); // remove form value
				searchsubmit.removeClass('do-search'); // remove search icon for X
				return;
			}
			searchfield.focus(); // if mobile, field focus
			return;
		}
		// otherwise search
		searchform.submit();
	});

	// show search icon if content, otherwise close X
	searchfield.bind('blur keyup', function(){
		var v = $(this).val();
		if( v ) {
			searchsubmit.addClass('do-search');
		}
		else {
			searchsubmit.removeClass('do-search');
		}
	});

	// search form fix for mobile - always show on mobile menu
	$('button.menu-toggle').click(function(){
		searchform.animate({
			width: "100%"
		}, 0);
	});

	// click outside search field (desktop) closes search
	$(document).click(function() {
    	if( searchfield.is(":visible") && !$('nav.main-navigation').hasClass('toggled') ) {
    		searchform.animate({
				width: 0
			}, 350); // hide search form (desktop)
			searchfield.val(''); // remove form value
			searchsubmit.removeClass('do-search'); // remove search icon for X
    	}
	});
	$('nav#site-navigation').click(function(event){
		event.stopPropagation();
		return;
	});

	// disable autocomplete for search field (to prevent Chrome 'yellowing')
	if ($.browser.webkit) {
		$('input[name="password"], input[type="search"]').attr('autocomplete', 'off');
	}

	/* Disabled per task: https://ninthlink.teamworkpm.net/tasks/3119882
	// fun menu animator...
	if(!$('.menu-toggle').is(":visible")) {
		var lastScrollTop = $(window).scrollTop();
		//console.log(lastScrollTop);
		$(window).scroll(function(event){
			var st = $(this).scrollTop();
			if (st > lastScrollTop){
				// downscroll code
				if($('.site-header').is(":visible")) {
					$('.site-header').stop().animate({
						height: 0,
						'padding-top': 0,
						'padding-bottom': 0,
					}, 150, function(){$(this).hide();});
				}
			} else {
				// upscroll code
				if(!$('.site-header').is(":visible")) {
					$('.site-header').stop().show().animate({
						height: 84,
						'padding-top': 12,
						'padding-bottom': 18
					}, 250);
				}
			}
			lastScrollTop = st;
			//console.log(lastScrollTop);

			clearTimeout($.data(this, 'scrollTimer'));
			$.data(this, 'scrollTimer', setTimeout(function() {
				// on scroll stop
				if(!$('.site-header').is(":visible")) {
					$('.site-header').stop().show().animate({
						height: 84,
						'padding-top': 12,
						'padding-bottom': 18
					}, 250);
				}
				//console.log('Scroll Stopped...')
			}, 750));
		});
	}
	*/

	//home page style fix
	if($('.slp_search_widget').width() < 360){
		$('.slp_search_widget').addClass('skinny');
	}
	$(window).resize(function(){
		if($('.slp_search_widget').width() < 360){
			$('.slp_search_widget').addClass('skinny');
		} else {
			$('.slp_search_widget').removeClass('skinny');
		}
	});
	
	if ( Modernizr.touch ) {
		$('#menu-main-menu ul.sub-menu').each(function() {
			$(this).prev().click(function(e) {
				e.preventDefault();
				$(this).parent().toggleClass('open').siblings('.open').removeClass('open');
			});
		});
	}
});


(function($){
	$('ol#map_sidebar li.results_wrapper').each(function(){
		var imgUrl = $(this).find('.dealer-image span').attr('rel');
		$(this).find('.results_entry').tooltip({ content: '<img src="' + imgUrl + '" />' });
	});
})(jQuery);

/**
 * Gravity Form styling fixes...
 * ...this mainly now needs CSS styling to complete
 */
/*
jQuery(function($){
	var i= 0,
		cats = {},
		cats_l = {},
		cats_r = {};
	$('div.gform_wrapper form.two_col_form ul.gform_fields').append('<div class="left_half"/>');
	$('div.gform_wrapper form.two_col_form ul.gform_fields').append('<div class="right_half"/>');
	$('div.gform_wrapper form.two_col_form ul.gform_fields').append('<div class="no_half"/>');
	$('div.gform_wrapper form.two_col_form ul.gform_fields > li').each(function(){
		if( $(this).hasClass('gf_left_half') ){
			$(this).clone().appendTo('.gform_fields div.left_half');
		}
		else if ( $(this).hasClass('gf_right_half') ) {
			$(this).clone().appendTo('.gform_fields div.right_half');
		}
		else {
			$(this).clone().appendTo('.gform_fields div.no_half');
		}
	});
	$('div.gform_wrapper form.two_col_form ul.gform_fields').children('li').remove();
});
*/
