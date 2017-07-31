/**
 * File site.js.
 *
 * Various javascript for the Chirs wordpress theme
 *
 */

var animationDuration = 800;
var screenTablet = 760;

( function( $ ) {

	$(document).ready(function() {
		
		
		/*
		 *	Page setup (as a function) so we can re-call it when loading the homepage again through smoothState.js
		 */
		
		function homepageSetup() {
		
			/*
			 *  Setup the "Meet Chris" slide-in content section
			 */
			$('#primary-menu a').click(function(e) {
				e.preventDefault();
				var height = $('.chris-image').offset().top + $('.chris-image').height() - 42; // 42 is the padding-top applied to #meet-chris
				$('#meet-chris').css('height', 'calc(100vh - ' + height + 'px)');
				$('#meet-chris-close').css('height', height + 'px');
				$('#meet-chris, #meet-chris-close, .chris-image img').toggleClass('active');
				
				// After the initial animation in, set no transitions (for window-resize)
				window.setTimeout(function(){
					$('#meet-chris').addClass('animation-complete');
				}, 800);
				
				// Let's re-calculate the size of the #meet-chris div when the window resizes (since the image) will get offset. Function below.
				$(window).resize(meet_chris_resizer);
			});
			
			$('#meet-chris-close').click(function(){
				$('#meet-chris, #meet-chris-close, .chris-image img').removeClass('active').removeClass('animation-complete');
				$(window).off("resize", meet_chris_resizer);
				$('#meet-chris').css('height', '0');
			});
			
			function meet_chris_resizer() {
				var height = $('.chris-image').offset().top + $('.chris-image').height() - 42; // 42 is the padding-top applied to #meet-chris
				$('#meet-chris').css('height', 'calc(100vh - ' + height + 'px)');
				$('#meet-chris-close').css('height', height + 'px');
			}
			
			
			
			/*
			 *  On mobile, setup the "Read more" and "Close" buttons
			 */
			 
			$('#read-more').click(function(){
				$('#read-more-content').slideDown();
				$('#read-more').slideUp();
			});
			
			$('#close').click(function(){
				$('#read-more-content').slideUp();
				$('#read-more').slideDown();
			});
			
			
			
			/*
			 *  Add class when all animations complete
			 */
			setTimeout(function(){
				$("body").addClass("animation-complete");
			}, 1500); // Remember to change this number if you change the animation length
			
			
			
			/*
			 *  Add a helper class when hovering over a link
			 */
			$(".homepage-link").unbind().hover(function() {
				if ( !isMobile() ) {
					$("body").addClass("homepage-link-hover");
				}
			}, function() {
				$("body").removeClass("homepage-link-hover");
			});
			$(".homepage-link a").unbind().hover(function() {
				if ( !isMobile() ) {
					$("body").addClass("homepage-link-hover");
				}
			}).click(function(e){
				if (!e.shiftKey && !e.ctrlKey && !e.metaKey && !isMobile() ) { // Prevent animation from triggering, if the page is opening in a new tab
				
					$(this).parent().addClass("homepage-link-clicked");
					
					// Remove one of the backgrounds on $(this)
					$(this).children('.homepage-link-background').attr('style', function(i, style) {
						return style.split(/\,\s?(?![^\(]*\))/)[0];
					});
					
					// Helper code to be able to animate from `100%` to `auto`
					var autoHeight = $(this).children('.homepage-link-background').css('height', 'auto').height();
					$(this).children('.homepage-link-background').css('height', '100%');
					var $this = $(this);
					setTimeout(function(){
						$this.children('.homepage-link-background').css('height', autoHeight + 'px');
					}, 1);
				}
			});
		
		} // end homepageSetup();
		
		homepageSetup();
		
		
		
		/*
		 *  smoothState setup
		 */ 
		var settings = { 
			anchors: '.homepage-link a',
			// blacklist: '.site-header a',
			prefetch: true,
			onStart: {
				duration: animationDuration, // ms, should be 800
				render: function ( $container ) {
					if( !isMobile() ) {
						$container.addClass( 'is-exiting' );
					}
					
					// Fade in the content
					$('body').addClass('smoothstate');
				}
			},
			onAfter: function( $container ) {	
				$container.removeClass( 'is-exiting' );
				
				// Remove the classes added to the body, for a fresh start
				$("body").removeClass("homepage-link-hover animation-complete");
				
				// Rerun the page setup
				$(document).ready(function() {
					homepageSetup();
				});
				
			}
		};
		
		
		
		/*
		 *  Helper functions
		 */
		 
		function isMobile() {
			if ($(window).width() < screenTablet) {
			   return true;
			} else {
			   return false;
			}
		}
		
		function smoothstateInit() {
			if (isMobile()) {
			   animationDuration = 0;
			   $( '#page' ).smoothState( settings );
			} else {
			   animationDuration = 800;
			   $( '#page' ).smoothState( settings );
			}
		}
		
		$(window).resize(function(){
			smoothstateInit();
		});
		smoothstateInit();
	
	
	
	}); // close document ready

})( jQuery );