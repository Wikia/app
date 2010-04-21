$(function(){
	$('.ajax-unwatch').click(Follow.uwatch);
	$('.ajax-show-more').click(Follow.showMore);
	$('.ajax-show-more').show();
	$('#enotiffollowedminoredits,#enotiffollowedpages,#enotifminoredits,#enotifwatchlistpages').click(Follow.syncUserPrefs);
});


Follow = {};

Follow.uwatch = function(e) {
	var url = "";
	if (e.target.tagName == "IMG") {
		url = $(e.target.parentNode).attr("href");
		console.log(url);
	} else {
		url = $(e.target).attr("href");
	}	
	$.ajax({
		  url: url,
		  success: function() {
			window.location.reload();
		  }
		});	
	return false;
}


Follow.showMore = function(e) {
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