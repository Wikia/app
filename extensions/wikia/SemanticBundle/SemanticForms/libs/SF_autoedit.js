/**
 * Javascript handler for the autoedit parser function
 *
 * @author Stephan Gambke
 */

jQuery(function($){

	$('.autoedit-trigger').click(function(){

		if ( wgUserName == null ) {
			if ( confirm( sfgAnonEditWarning ) ) {
				handleAutoEdit( this );
			}
		} else {
			handleAutoEdit( this );
		}

		return false;
	});

	function handleAutoEdit( trigger ){
		var jtrigger = jQuery( trigger );
		var jautoedit = jtrigger.closest( '.autoedit' );
		var jresult = jautoedit.find('.autoedit-result');

		var reload = jtrigger.hasClass( 'reload' );

		var data = new Array();
		data.push( jautoedit.find('form.autoedit-data').serialize() );

		jtrigger.attr('class', 'autoedit-trigger autoedit-trigger-wait');
		jresult.attr('class', 'autoedit-result autoedit-result-wait');

		jresult[0].innerHTML="Wait..."; // TODO: replace by localized message

		sajax_request_type = 'POST';

		sajax_do_call( 'SFAutoeditAPI::handleAutoEdit', data, function( ajaxHeader ){
			jresult.empty().append( ajaxHeader.responseText );

			if ( ajaxHeader.status == 200 ) {

				if ( reload ) window.location.reload();

				jresult.removeClass('autoedit-result-wait').addClass('autoedit-result-ok');
				jtrigger.removeClass('autoedit-trigger-wait').addClass('autoedit-trigger-ok');
			} else {
				jresult.removeClass('autoedit-result-wait').addClass('autoedit-result-error');
				jtrigger.removeClass('autoedit-trigger-wait').addClass('autoedit-trigger-error');
			}
		} );
	}

})
