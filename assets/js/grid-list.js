(function($) {

	$(document).ready(function() 
	{	
		gridList();		
	});

	/**
	 * Grid List
	 *
	 */
	function gridList()
	{
		if ( $('#media-upload').length == 0 )
			return false;
		
		var tablenav = $('#media-upload #filter .tablenav');
				
		// add navigation
		tablenav.append('<div class="grid-list"><a class="grid-icon" href="javascript:;"></a><a class="list-icon active" href="javascript:;"></a></div>');
		
		// click events
		$('.grid-icon', tablenav).click(function(e){			
			setGridView();
			e.preventDefault();
		});
		
		$('.list-icon', tablenav).click(function(e){
			setListView();
			e.preventDefault();
		});
		
		// cookie preset by User ID
		var view_type = getCookie('mediapicker-view-' + userSettings.uid);
		if ( view_type == 'grid' ) {
			setGridView();
		}
		
		function setGridView()
		{
			// states
			$('.grid-list a').removeClass('active');
			$('.grid-list a.grid-icon').addClass('active');
			$('#media-items').addClass('grid-view');
			
			// cookie
			setCookie('mediapicker-view-' + userSettings.uid, 'grid', 365);
		}
		
		function setListView()
		{
			// states
			$('.grid-list a').removeClass('active');
			$('.grid-list a.list-icon').addClass('active');
			$('#media-items').removeClass('grid-view');
			
			// cookie
			setCookie('mediapicker-view-' + userSettings.uid, 'list', 365);
		}		
	}
	
	/**
	 * Cookie Helper Functions
	 *
	 */
	function setCookie(c_name,value,exdays)
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
	}
	
	function getCookie(c_name)
	{
		var i,x,y,ARRcookies=document.cookie.split(";");
		for (i=0;i<ARRcookies.length;i++)
		{
			x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			x=x.replace(/^\s+|\s+$/g,"");
			if (x==c_name)
			{
				return unescape(y);
			}
		}
	}	

})(jQuery);