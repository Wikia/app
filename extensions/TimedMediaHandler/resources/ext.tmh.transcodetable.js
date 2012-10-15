/**
* Javascript to support transcode table on image page
*/
$(document).ready(function(){
	// Error link popup:
	$('.transcodestatus .errorlink').click(function(){
		// pop up dialog 
		mw.addDialog({
			'width' : '640',
			'height' : '480',
			'title' : $(this).attr('title'),
			'content' : $('<textarea />')
				.css({
					'width':'99%', 
					'height':'99%'
				})
				.text( $(this).attr('data-error') )			
		})
		.css('overflow', 'hidden');
		return false;
	})
	// Reset transcode action: 
	$j('.transcodereset a').click( function(){
		var tKey = $(this).attr('data-transcodekey');
		var buttons = {};
		buttons[ gM('mwe-ok') ] = function(){
			var _thisDialog = this;
			$(this).loadingSpinner();
			var apiUrl =  mw.config.get('wgServer') + mw.config.get( 'wgScriptPath' ) + '/api.php';
			// Do an api post action: 
			$.post( apiUrl, {
				'action' : 'transcodereset',
				'transcodekey' : tKey,
				'title' : mw.config.get('wgPageName'),
				'token' : mw.user.tokens.get('editToken'),
				'format' : 'json'
			}, function( data ){
				if( data && data['success'] ){
					// refresh the page
					window.location.reload();
				} else {
					if( data.error && data.error.info ){
						$( _thisDialog ).text( data.error.info );
					} else {
						$( _thisDialog ).text( gM( 'timedmedia-reset-error' ) );
					}
					var okBtn = {};
					okBtn[ gM('mwe-ok') ] = function() { $(this).dialog("close"); } 
					$( _thisDialog ).dialog( "option", "buttons", okBtn );
				}
			})
		};
		buttons[ gM('mwe-cancel') ] =function(){
			$(this).dialog('close');
		}
		// pop up dialog 
		mw.addDialog({
			'width' : '400',
			'height' : '200',
			'title' : gM('timedmedia-reset'),			
			'content' : gM('timedmedia-reset-confirm'),
			'buttons': buttons
		})
		.css('overflow', 'hidden');
		return false;
	})
})
