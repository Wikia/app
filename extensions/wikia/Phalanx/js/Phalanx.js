$(function(){
	$('#phalanx-block').bind('submit', Phalanx.postForm);
	var placeholder = $( '#phalanx-check-results' );
	placeholder.delegate( 'a.modify', "click", Phalanx.getSingleBlockData );
	placeholder.delegate( 'a.unblock', "click", Phalanx.removeSingleBlock );

	var testArea = $('#phalanx-block-test-result');
	testArea.delegate( 'a.modify', 'click', Phalanx.getSingleBlockData );
	testArea.delegate( 'a.unblock', 'click', Phalanx.removeSingleBlock );

	//add bindings to tabs
	$('#phalanx-nav-area').find('a').bind('click', function(e) {
		e.preventDefault();
		Phalanx.selectTab($(this).blur().parent().attr('id'));
	});

	$('#phalanx-block-test').bind('submit', Phalanx.postTestForm);

	// help tooltips
	$('#phalanx-block-types').find('label').hover(Phalanx.displayInfo, Phalanx.hideInfo);

	//select proper tab if id is passed via hash
	if (window.location.hash != '') {
		var id = 'phalanx-' + window.location.hash.substr(1) + '-tab';
		var hash = $('#' + id);
		if (hash.length) {
			Phalanx.selectTab(id);
		}
	}
});

var Phalanx = {};
Phalanx.mode = 'add';
Phalanx.addMsg = $( '#wpPhalanxSubmit' ).attr( 'value' );
Phalanx.editMsg = '';
Phalanx.blockId = 0;

Phalanx.ajax = function(method, data, callback) {
	$.postJSON(wgServer + wgScript + '?action=ajax&rs=PhalanxAjax&method=' + method, data, callback);
}

Phalanx.getSingleBlockData = function( e ) {
	if( e ) {
		e.preventDefault();
	}

	// go to primary tab, just in case
	Phalanx.selectTab( 'phalanx-main-tab' );

	// scroll to form
	window.scrollTo(0, 0);

	var placeholder = $( '#phalanx-check-results' );
	var id = $(e.target).attr( 'href' ).split('id=').pop();

	Phalanx.ajax('getOneBlock', {id: id}, function(response) {
		if ( !response.error ) {
			Phalanx.loadBlockData( response );
		} else {
			placeholder.html( 'error' );
		}
	});
	return false;
}

Phalanx.removeSingleBlock = function( e ) {
	if( e ) {
		e.preventDefault();
	}

	// go to primary tab, just in case
	Phalanx.selectTab( 'phalanx-main-tab' );

	var placeholder = $( '#phalanx-feedback-msg' );
	var id = $(e.target).attr( 'href' ).split('id=').pop();

	Phalanx.ajax('removeSingleBlock', {id: id}, function(response) {
		if ( !response.error ) {
			placeholder.html( response.text );
			window.location.reload();
		} else {
			placeholder.html( 'error' );
		}
	});
	return false;
}

Phalanx.loadBlockData = function( response ) {
	var mesg = $( '#phalanx-feedback-msg' );
	$( '#phalanx-block' )[0].reset();
	mesg.html( response.text );

	Phalanx.blockId = response.data['id'];
	// fill form
	$( '#wpPhalanxFilter' ).attr( 'value', response.data['text'] );
	if( 1 == response.data['regex'] ) {
		$( '#wpPhalanxFormatRegex' ).attr( 'checked', 'checked' );
	}
	if( 1 == response.data['case'] ) {
		$( '#wpPhalanxFormatCase' ).attr( 'checked', 'checked' );
	}
	if( 1 == response.data['exact'] ) {
		$( '#wpPhalanxFormatExact' ).attr( 'checked', 'checked' );
	}
	// todo for timestamp - show current, give option for 'don't change', then all normal ones
	var type = response.data['type'];

	$( '#phalanx-expire-old' ).html( response.time );


	if( type & 1  ) {
		$( '#wpPhalanxTypeContent' ).attr( 'checked', 'checked' );
	}
	if( type & 2  ) {
		$( '#wpPhalanxTypeSummary' ).attr( 'checked', 'checked' );
	}
	if( type & 4  ) {
		$( '#wpPhalanxTypeTitle' ).attr( 'checked', 'checked' );
	}
	if( type & 8  ) {
		$( '#wpPhalanxTypeUrl' ).attr( 'checked', 'checked' );
	}
	if( type & 16  ) {
		$( '#wpPhalanxTypeUser' ).attr( 'checked', 'checked' );
	}
	if( type & 32  ) {
		$( '#wpPhalanxTypeCreation' ).attr( 'checked', 'checked' );
	}
	if( type & 64  ) {
		$( '#wpPhalanxTypeQuestion' ).attr( 'checked', 'checked' );
	}
	if( type & 128  ) {
		$( '#wpPhalanxTypeFilterWords' ).attr( 'checked', 'checked' );
	}

	if( 'add'  == Phalanx.mode ) {
		Phalanx.mode = 'edit';
		if( '' == Phalanx.editMsg ) {
			Phalanx.editMsg = response.button;
		}
		$( '#wpPhalanxSubmit' ).attr( 'value', Phalanx.editMsg );
	}

	if( '' != response.data['reason'] ) {
		$( '#wpPhalanxReason' ).attr( 'value', response.data['reason'] );
	}
}

Phalanx.postForm = function( e ) {
	if ( e ) {
		e.preventDefault();
	}

	var oForm = $( '#phalanx-block' );
	var postfix = '';
	if (oForm.exists()) {
		if( 'edit' == Phalanx.mode ) {
			postfix = '&id=' + Phalanx.blockId;
		}

		Phalanx.ajax('setBlock', oForm.serialize() + postfix, function(response) {
			Phalanx.postFormCallback(response);

			// reload the page when block is added
			document.location.reload();
		});
	}
}

Phalanx.postFormCallback = function( response ) {
	var mesg = $( '#phalanx-feedback-msg' );

	mesg.html( response.text );
	if ( response.error ) {
		mesg.addClass( 'error' );
	} else {
		mesg.removeClass( 'error' );
	}
}

Phalanx.postTestForm = function(e) {
	e.preventDefault();

	var blockText = $.trim($('#phalanx-block-text').val());
	if (blockText != '') {
		Phalanx.ajax('testBlock', {text: blockText}, Phalanx.postTestFormCallback);
	} else {
		//TODO: add i18n
		$.showModal('Phalanx', 'Provide some text!');
	}
}

Phalanx.postTestFormCallback = function(response) {
	//TODO: add displaying results
	$('#phalanx-block-test-result').html(response);
}

Phalanx.selectTab = function(tab) {
	$('#phalanx-nav-area').find('li').removeClass('selected');
	var tabId = $('#' + tab).addClass('selected').attr('id');
	$('#phalanx-content-area').children().hide();
	$('#' + tabId + '-content').show();
}

Phalanx.displayInfo = function(e) {
	var helpId = '#phalanx-help-' + $(this).prev('input').attr('value');
	$(helpId).show();
}

Phalanx.hideInfo = function(e) {
	var helpId = '#phalanx-help-' + $(this).prev('input').attr('value');
	$(helpId).hide();
}
