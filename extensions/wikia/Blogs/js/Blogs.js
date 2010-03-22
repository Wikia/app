var Blogs = {};

var clicked = false;
Blogs.callback = function( data ) {
	Blogs.submit.clicked = false;
	document.body.style.cursor = "default";
	
	if (!( stopAjax == 'undefined' )) { //hack
		stopAjax();
	}
	
	if ( (data['commentId']) && (data['commentId'] != 0) ) {
		Blogs.callback.replace( data );
	} else {
		Blogs.callback.add( data );
	}
};

Blogs.callback.toggle = function( data ) {
	
	if (!( stopAjax == 'undefined' )) {
		stopAjax();
	}
	
	if( ! data[ "error" ] ) {
		$( "#comm-" + data["id"]).html( data["text"] );

		/**
		 * connect signals
		 */
		Blogs.actions = $( data[ "id" ] );
		
		document.body.style.cursor = "default";
		
		$("a .blog-comm-edit").click("click", Blogs.edit);
		Blogs.render();
	}
};

Blogs.callback.add = function( data ) {
	if( ! data[ "error" ] ) {
		// remove zero comments div
		$("#blog-comments-zero").val("");
		
		var li = $( "<li></li>" );
		li.html( data["text"] );
		li.attr("id", "comm-" + data['id']);
		
		var order = $("#blog-comm-order");
		if( order.val() == "asc") {				
			li.insertAfter($( "#blog-comments-ul" ).children().last());
		} else {
			li.insertBefore($( "#blog-comments-ul" ).children().first());
		}
		
		$("#blog-comm-bottom-info").html( "&nbsp;" );
	}
	else {
		$("#blog-comm-bottom-info").html([ "msg" ]);
	}

	document.body.style.cursor = "default";
	
	$("#blog-comm-bottom").attr('readonly', false).val("").css('cursor', 'default')
	$("#blog-comm-top").attr('readonly', false).val("").css('cursor', 'default')
	
	Blogs.render();
};

Blogs.callback.replace = function( data ) {
	
	if( ! data[ "error" ] ) {
		var commentId = data['commentId'];		
		var li = $( "#comm-" + commentId );
		li.html( data["text"] );
		$( "#blog-comm-bottom-info" ).html("&nbsp;");
	}
	else {
		$( "#blog-comm-text" ).html(data[ "msg" ]);
	}
	
	document.body.style.cursor = "default";
	Blogs.render();
};

Blogs.callback.edit = function( data ) {
	if( ! data[ "error" ] ) {
		$( "#comm-text-" + data["id"]).html( data["text"] );
		
		/**
		 * connect signals
		 */
		
		$("#blog-comm-submit-" + data[ "id" ]).bind("click", {id: data[ "id" ]}, Blogs.save)
		
		document.body.style.cursor = "default";
	}
};

/**
 * so far simply submit of form
 */
Blogs.submit = function( event ) {	
	
	if ( Blogs.submit.clicked == true ) {
		return false;
	}
	Blogs.submit.clicked = true;
	var oForm = $( event.target.parentNode  ); 
	if( oForm.attr( "id" ) == "blog-comm-form-select" ) {
		oForm.submit();
	} else {
		oForm = $( event.target.parentNode.parentNode  ); 
		WET.byStr('articleAction/postComment');
		postData = oForm.serialize() + "&action=ajax&rs=BlogComment::axPost&article=" + wgArticleId ;
		$.getJSON(wgServer + wgScript, postData , Blogs.callback);
		return false;
	}
};


Blogs.save = function( event ) {
	var id = event.data.id;
	
	var oForm = $( "#blog-comm-form-" + id );

	if (oForm.length > 0) {
		WET.byStr('articleAction/postComment');
		document.body.style.cursor = "wait";
		var textfield = $( "#blog-comm-textfield-" + id );
		$.postJSON(wgServer + wgScript + "?action=ajax&rs=BlogComment::axSave&article=" + wgArticleId + "&id=" + id , oForm.serialize(), Blogs.callback);
		return false;
	}
	return true;
};

Blogs.toggle = function( event ) {
	var commentID =$(event.target).attr('id'); 
	document.body.style.cursor = "wait";
	$.getJSON( wgServer + wgScript + "?action=ajax&rs=BlogComment::axToggle&id=" + commentID + "&article=" + wgArticleId, Blogs.callback.toggle );
	return false;
};

Blogs.edit = function( event ) {
	var commentID = $(event.target).attr('id');
	document.body.style.cursor = "wait";
	$.getJSON( wgServer + wgScript + "?action=ajax&rs=BlogComment::axEdit&id=" + commentID + "&article=" + wgArticleId, Blogs.callback.edit );
	return false;
};


$(document).ready(function() {
	$("#blog-comm-submit-top").click(Blogs.submit);
	$("#blog-comm-submit-bottom").click(Blogs.submit);
	$("#blog-comm-form-select").change(Blogs.submit);
	Blogs.render();
});

Blogs.render = function() {
	setTimeout(function() {
	$( ".blog-comm-hide" ).unbind().click( Blogs.toggle );
	$( ".blog-comm-edit" ).unbind().click( Blogs.edit ); }, 1000 );
}
