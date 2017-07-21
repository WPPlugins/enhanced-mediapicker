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
		
		// set preview image attributes
		$('#media-items .media-item').each(function(){
			var thumb = $('img.thumbnail', this);
			thumb.attr('data-preview-url', $('.preview-full-src', this).text());
			thumb.attr('data-preview-width', $('.preview-full-width', this).text());
			thumb.attr('data-preview-height', $('.preview-full-height', this).text());			
		});
		
		// apply magnifier
		SmartImageMagnifier.magnify("img.pinkynail");
	}
	
	
	/**
	 * Magnifier
	 *
	 */
	var Magnifier = {
		price_prefix: "<sup>$</sup>",
		positionMagnifierNextTo: function (a) {
			var b, c;
			b = this.magnifierDiv();
			c = $(a).offset().top + $(a).outerHeight() - b.outerHeight();
			c < $(window).scrollTop() && (c = $(window).scrollTop());
			a = $(a).offset().left + $(a).outerWidth() / 2 >= $(window).width() / 2 ? $(a).offset().left - b.outerWidth() : $(a).offset().left + $(a).outerWidth();
			b.css({
				top: c,
				left: a
			})
		},
		showMagnifier: function (a) {
			void 0 === $(a).attr("data-tooltip") && ($(a).attr("data-tooltip", $(a).attr("title")), $(a).attr("title", ""),
			$("img", a).attr("title", ""));
			this.populateMagnifierFrom(a);
			this.positionMagnifierNextTo(a);
			this.magnifierDiv().css({
				display: "inline"
			})
		},
		hideMagnifier: function () {
			this.magnifierDiv().hide()
		},
		magnify: function (a) {
			var b = this;
			
			// we need to bind hoverIntent to live
			$(a).live('mouseover', function() {  
				if (!$(this).data('init')) {  
					$(this).data('init', true);  
					$(this).hoverIntent(function(){ 
						b.showMagnifier(this)
					}, 
					function(){
						b.hideMagnifier(this)
					});  
					$(this).trigger('mouseover');  
				}  
			});	
		}
	},
	ImageMagnifier = objectWithPrototype(Magnifier, {
		populateMagnifierFrom: function (a) {
			var b, c = this.magnifierDiv().find("div.size-limiter"),
				d = $(a);
			d.attr("data-preview-url") ? (b = new Image, $(b).attr("src", d.attr("data-preview-url")), d.attr("data-preview-height") && ($(b).attr("height", 350), $(b).attr("width", 350 / d.attr("data-preview-height") * d.attr("data-preview-width"))), c.empty(), c.append(b), c.show()) : c.hide();			
		}
	}),
	SmartImageMagnifier = objectWithPrototype(ImageMagnifier, {
		magnifierDiv: function () {
			return $("div#smart-image-magnifier")
		},
		populateMagnifierFrom: function (a) {
			var b, c, d, e, f, h = this.magnifierDiv(),
				k = h.find("div.size-limiter").empty(),
				m = h.find("strong");
			b = new Image;
			$(b).attr("src", $(a).attr("data-preview-url"));
			c = parseInt($(a).attr("data-preview-height"), 10);
			d = parseInt($(a).attr("data-preview-width"), 10);
			$(k).empty();
			$(k).css("height", "");
			$(k).css("width", "");
			$(h).removeClass("previewable");
			0 < c * d ? (c > d ? (e = 350, f = 350 / c * d) : (f = 350, e = 350 / d * c), $(b).attr("height", e), $(b).attr("width", f), m.css("width", f), h.css("width", f), $(k).css("height", e), $(k).css("width", f), $(a).hasClass("no_preview") || ($(h).addClass("previewable"), c = $(a).clone(), c.addClass("thumbnail_preview").attr("width", f).attr("height", e), $(k).append(c)), $(k).show()) : $(b).attr("height", 225);
			$(k).append(b);			
		}
	});	
	
	function objectWithPrototype(a, b) {function c() {}
		var d, e;
		c.prototype = a;
		d = new c;
		d.prototype = a;
		if ("undefined" !== typeof b) for (e in b) b.hasOwnProperty(e) && (d[e] = b[e]);
		return d
	}
	
})(jQuery);