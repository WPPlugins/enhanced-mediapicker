(function($) {

	$(document).ready(function() 
	{	
		addSelectForm();		
	});

	/**
	 * Form Select
	 *
	 */
	function addSelectForm()
	{
		if ( $('#media-upload').length == 0 )
			return false;
				
		var values = { 
			10		: 10, 
			20		: 20,
			30		: 30,
			40		: 40,
			50		: 50,
			100		: 100,
			200		: 200,
			500		: 500,
			1000	: 1000,
			0		: cpem_L10n.all
		}; 
		var options = '';
		$.each(values, function(key, value) {
			
			// only display values that are smaller then the total nr of attachments
			if ( key < parseInt(cpem_attachment_count) ) {
			
				// selected state
				var selected = '';
				if ( cpem_rowlimit == key )
					selected = ' selected="selected"';
				
				// add option
				options += '<option value="'+key+'"'+selected+'>'+value+'</option>';
			}
		});
				
		// add select
		$('#media-upload #filter .tablenav').append('<div class="rowlimit"><select id="rowlimit" name="rowlimit">' + options + '</select><label for="rowlimit">' + cpem_L10n.items + '</label></div>');
		
		// submit on select
		$('#rowlimit').change(function(){
			$(this).closest('form').trigger('submit');         
		});

	}
	
})(jQuery);