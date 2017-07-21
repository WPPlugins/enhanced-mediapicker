(function($) {

	$(document).ready(function() 
	{
		imagePreview();
	});
		
	/**
	 * Image Preview
	 *
	 */
	function imagePreview()
	{
		if ( $('#media-items').length == 0 )
			return false;
			
		// set preview container
		$('body').append("<div id='smart-image-magnifier' class='magnifier'><div class='size-limiter'></div></div>");
		
		// init magnifier
		var magnifier = $('#smart-image-magnifier');
		
		// hoverintent doesnt support live methods, so we need to trigger this after the mouseover event
		$('img.pinkynail').live('mouseover', function() {

			if (!$(this).data('init')) {
				$(this).data('init', true); 
				$(this).hoverIntent(function(){
					showMagnifier(this);
				}, 
				function(){
					magnifier.hide();
				});  
				$(this).trigger('mouseover');  
			}  
		});	
		
		function showMagnifier( pinkynail )
		{			
			var media_item  = $(pinkynail).closest('div.media-item');
			
			// get preview attributes
			var preview_src = $('.preview-full-src', media_item).text();
			var preview_w 	= $('.preview-full-width', media_item).text();
			var preview_h 	= $('.preview-full-height', media_item).text();
			
			// add properties to pinkynail, because preview is removed from the DOM by WP
			$(pinkynail).attr('data-preview-src', preview_src);
			$(pinkynail).attr('data-preview-width', preview_w);
			$(pinkynail).attr('data-preview-height', preview_h);
			
			// build new preview image
			var image = new Image;
			
			// set new sizes
			$(image).attr('src', $(pinkynail).attr('data-preview-src'));
			$(image).attr('height', $(pinkynail).attr('data-preview-width'));
			$(image).attr('width', $(pinkynail).attr('data-preview-height'));
			
			// add image to magnifier box
			$('.size-limiter', magnifier).empty().append(image);
			
			// position
			var pos_top = $(pinkynail).offset().top + $(pinkynail).outerHeight() - magnifier.outerHeight();
			pos_top < $(window).scrollTop() && (pos_top = $(window).scrollTop());
			var pos_left = $(pinkynail).offset().left + $(pinkynail).outerWidth() / 2 >= $(window).width() / 2 ? $(pinkynail).offset().left - magnifier.outerWidth() : $(pinkynail).offset().left + $(pinkynail).outerWidth();
			
			// set position and display
			magnifier.css({
				top		: pos_top,
				left	: pos_left,
				display : 'inline'
			});
		}	
	}	

})(jQuery);