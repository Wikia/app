$(function(){
	$('.ajax-unwatch').click(Follow.uwatch);
	$('.ajax-show-more').click(Follow.showMore);
	$('.ajax-show-more').show();
	$('#enotiffollowedminoredits,#enotiffollowedpages,#enotifminoredits,#enotifwatchlistpages').click(Follow.syncUserPrefs);
	
	$('.watched-list li').hover(
		function(e) {
		    $(e.target).find(".otherNs,.ajax-unwatch").css('visibility', 'visible');
		},
		function(e) {
		    $(".otherNs,.ajax-unwatch").css('visibility', 'hidden');
		} 
	);
	
	$('.title-link').click(
		function(e) {
			var index = 0;
			var ul = null;
			var msg = "";
			ul = $( $(e.target).parent().parent().parent() );
			index = $(e.target).parent().parent().index() + 1;
		    msg = ul.attr("id").split("-"); 
		    WET.byStr( 'WikiaFollowedPages/specialpage/links/' + msg[3] + '/' + index );    
		}
	);

});


Follow = {};

Follow.uwatch = function(e) {
	var url = "";
	var index = 0;
	var ul = null;
	var msg = "";
	if (e.target.tagName == "IMG") {
		url = $(e.target.parentNode).attr("href");
		ul = $( $(e.target).parent().parent().parent() );
		index = $(e.target).parent().parent().index() + 1;
	} else {
		url = $(e.target).attr("href");
		index = $(e.target).parent().index() + 1;
		ul = $( $(e.target).parent().parent() );
	}	
	
    msg = ul.attr("id").split("-"); 
    WET.byStr( 'WikiaFollowedPages/specialpage/delete/' + msg[3] + '/' + index);    
    
	$.ajax({
		  url: url,
		  success: function() {
			window.location.reload();
		  }
		});	
	return false;
}


Follow.showMore = function(e) {
	
    msg = $(e.target).attr("id").split("-"); 
    WET.byStr( 'WikiaFollowedPages/specialpage/viewall/' + msg[4] );   
    
	var url = $(e.target).attr("href");
	$(e.target).hide();
	var head = Follow.getUrlParam( url, "head" );
	$.ajax({
		  url: url,
		  success: function(data) {
			$( "#" + head ).html(data);
		  }
		});	
	return false;
}


Follow.getUrlParam = function ( url,name ) {
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( url);
  if( results == null )
    return "";
  else
    return results[1];
}

Follow.syncUserPrefs = function(e) {
	var syncArray  = new Array();
	syncArray[ 'enotifminoredits' ] = 'enotiffollowedminoredits';
	syncArray[ 'enotifwatchlistpages' ] = 'enotiffollowedpages';
	syncArray[ 'enotiffollowedminoredits' ] = 'enotifminoredits';
	syncArray[ 'enotiffollowedpages' ] =  'enotifwatchlistpages';
	var target = $(e.target);
	var dst = $( '#' + syncArray[target.attr('id')] );
	dst.attr('checked', target.attr('checked'));
}