var localize_data = localize_data||{};

(function($){

	$(document).ready(function(){

		$('.index-list .item').each(function(index, element){
			$(element).attr( 'data-index', index + 1 );
		});

		/* WOW */
		if ($('html').hasClass('desktop')) {

			/**
			* Add custom class like "wow-apply-delays_fadeInUp-.6" to shortcode, to apply delays from 0s to 0.6s on output elements.
			* Note that, to be collected, output elements must have the "item" class. 
			*/
			
			var _wow_groups = $('[class*="wow-apply-delays"]');
			_wow_groups.each(function(index, element){

				var _group = $(this),
					_wow_class_match = _group.attr('class').match(/wow-apply-delays_(\w+)(-([0-9.]{1,2}))*/);
					_wow_class_value = _wow_class_match ? _wow_class_match[0] : '',
					_wow_class = _wow_class_match ? _wow_class_match[1] : 'fadeIn',
					_delay_total = _wow_class_match[3] ? parseFloat(_wow_class_match[3]) : 1.0,
					_items = _group.find('[class*="item"]'),
					_classes = $(this).attr('class');


				function _apply_wow( _element, _animation_class, _delay ){

					$(_element)
						.addClass( 'wow' )
						.addClass( _animation_class )
						.attr( 'data-wow-delay', _delay + 's' );

				};

				_group.removeClass(_wow_class_value);

				_items.each(function(index, element){
					var _item = $(this),
						_window_width = $(window).width(),
						_col_xs = _item.attr('class').match(/ col-xs-(\d{1,2})/),
						_col_sm = _item.attr('class').match(/ col-sm-(\d{1,2})/),
						_col_md = _item.attr('class').match(/ col-md-(\d{1,2})/),
						_col_lg = _item.attr('class').match(/ col-lg-(\d{1,2})/),
						_cols_total = 12,
						_items_per_row,
						_item_delay,
						_mult;

					if( (_window_width > 992) && (_window_width < 1200) && _col_md ){

						_items_per_row = Math.floor( _cols_total / parseInt( _col_md[1] ) );
						_mult = index - Math.floor( index / _items_per_row ) * _items_per_row;
						_item_delay = _mult * _delay_total / _items_per_row;

						_apply_wow( _item, _wow_class, _item_delay );
						
						return;
					}

					if( (_window_width > 1199) && _col_lg ){

						_items_per_row = Math.floor( _cols_total / parseInt(_col_lg[1]) );
						_mult = index - Math.floor( index / _items_per_row ) * _items_per_row;
						_item_delay = _mult * _delay_total / _items_per_row;

						_apply_wow( _item, _wow_class, _item_delay );

						return;
					}

					_item_delay = (1 + index) * _delay_total / _items.length;

					_apply_wow( _item, _wow_class, _item_delay );

					return;

				});

			});

		    new WOW().init();
		}

		/* STICKUP */

		if ( $('html').hasClass('desktop') && ('yes' === localize_data["sticky_header"]) ) {
		    $( '#stuck_container' ).TMStickUp({});
		}

		/* SFMENU & MOBILEMENU */
		$(function(){
			var _menu = $('.sf-menu').superfish();
			
			RDMobilemenu_autoinit('#primary.sf-menu');

			$(window).on( 'load resize', function(e){
				var _mobile_menu = $('.rd-mobilemenu, .rd-mobilepanel'),
				    _ww = $(window).width(),
					_switch_point = parseInt( localize_data['mobile_switch_point']||768 );

				if( _ww > _switch_point ){

					_menu.removeClass('hidden');
					_mobile_menu.addClass('hidden');
				}else{

					_menu.addClass('hidden');
					_mobile_menu.removeClass('hidden');
				}
			}).resize();
		});

		/* EQUAL HEIGHTS */
		/* parsed HTML */
		$(function () {
		    $(".maxheight").each(function () {
		        $(this).contents().wrapAll("<div class='box_inner'></div>");
		    })
		    $(".maxheight1").each(function () {
		        $(this).contents().wrapAll("<div class='box_inner'></div>");
		    })
		    $(".maxheight2").each(function () {
		        $(this).contents().wrapAll("<div class='box_inner'></div>");
		    })
		    $(".maxheight3").each(function () {
		        $(this).contents().wrapAll("<div class='box_inner'></div>");
		    })
		})

		/* SMOOTHSCROLL */
		if ($('html').hasClass('desktop')) {
		    $.srSmoothscroll({
		        step: 150,
		        speed: 800
		    });
		}

		/* LAZY-LOAD */
		$(".lazy-img").find('img').unveil(200, function () {
		    $(this).load(function () {
		        $(this).addClass("lazy-loaded");
		    });
		});

		/* MAGNIFIC POPUP */
		if($.fn.magnificPopup)
			$('a[class*="magnific-popup"]').magnificPopup({
				type: 'image',
			});

	});
	
	$(window).load(function(){
		$().UItoTop({ easingType: 'easeOutQuart' });
	});

})(jQuery);
