(function($) {

	$(document).ready(function() 
	{	
		addUserUploadOnlyCheckbox();		
	});

	/**
	 * Add Checkbox
	 *
	 */
	function addUserUploadOnlyCheckbox()
	{
		if ( $('#media-upload').length == 0 )
			return false;
		
		var checked = '';
		if ( 'on' == cpem_useruploadsonly )
			checked = ' checked="on"';
		
		
		
		// add select
		$('#media-upload #filter .tablenav').append('<div class="useruploadsonly"><input type="checkbox" id="useruploadsonly" name="useruploadsonly"'+checked+'/><label for="useruploadsonly">'+cpem_L10n.my_uploads+'</label></div><br class="clear">');
		
		// submit on select
		$('#useruploadsonly').change(function(){
			$(this).closest('form').trigger('submit');         
		});

	}
	
})(jQuery);