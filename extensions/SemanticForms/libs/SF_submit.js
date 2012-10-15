/**
* Javascript handler for the save-and-continue button
 */

( function( $ ) {

	var sacButtons;
	var form;

	if ( mw.config.get( 'wgAction' ) === "formedit" || mw.config.get( 'wgCanonicalSpecialPageName' ) === "FormEdit" ) {

		form = $('#sfForm');

		sacButtons = $('.sf-save_and_continue', form);
		sacButtons.click( handleSaveAndContinue);

		$('input,select,textarea', form)
		.live( "keyup", function ( event ) {
			if ( event.which < 32 ) return true;
			return setChanged( event );
		})
		.live( "change", setChanged );

		$('.multipleTemplateAdder,.remover,.rearrangerImage', form)
		.live( "click", setChanged );

		$('.rearrangerImage', form)
		.live( "mousedown", setChanged );

	}

	function setChanged( event ) {
		sacButtons
			.removeAttr("disabled")
			.addClass("sf-save_and_continue-changed");

		return true;
	}

	function handleSaveAndContinue( event ) {

		event.stopImmediatePropagation();

		// remove old error messages
		var el = document.getElementById("form_error_header");

		if (el) el.parentNode.removeChild(el);

		if (validateAll()) {

			// disable save and continue button
			sacButtons.attr("disabled", "disabled");

			sacButtons
			.addClass("sf-save_and_continue-wait")
			.removeClass("sf-save_and_continue-changed");

			sajax_request_type = 'POST';
			var form = $('#sfForm');

			sajax_do_call( 'SFAutoeditAPI::handleAutoEdit', new Array(collectData( form ), false), function( ajaxHeader ){

				if ( ajaxHeader.status == 200 ) {

					// Store the target name
					var target = form.find('input[name="target"]');

					if ( target.length == 0 ) {
						target = jQuery('<input type="hidden" name="target">');
						form.append (target);
					}

					target.attr( 'value', ajaxHeader.getResponseHeader("X-Target") );

					// Store the form name
					var target = form.find('input[name="form"]');

					if ( target.length == 0 ) {
						target = jQuery('<input type="hidden" name="form">');
						form.append (target);
					}

					target.attr( 'value', ajaxHeader.getResponseHeader("X-Form") );

					sacButtons
					.addClass("sf-save_and_continue-ok")
					.removeClass("sf-save_and_continue-wait")
					.removeClass("sf-save_and_continue-error");

				} else {

					sacButtons
					.addClass("sf-save_and_continue-error")
					.removeClass("sf-save_and_continue-wait");

					// Remove all old error messages and set new one
					jQuery(".errorMessage").remove();
					jQuery("#contentSub").append('<div id="form_error_header" class="warningMessage" style="font-size: medium">' + ajaxHeader.responseText + '</div>');
					scroll(0, 0);

				}

			} );
		}

		return false;
	}

	function collectData( form ) {

		var summaryfield = jQuery("#wpSummary", form);
		if ( summaryfield.length > 0 ) {

			var oldsummary = summaryfield.attr("value");

			if ( oldsummary != "" ) {
				summaryfield.attr("value", oldsummary + " (" + sfgSaveAndContinueSummary + ")");
			} else {
				summaryfield.attr("value", sfgSaveAndContinueSummary);
			}

			var params = form.serialize();

			summaryfield.attr("value", oldsummary );

		} else {

			var params = form.serialize();
			params += "&wpSummary=" + sfgSaveAndContinueSummary;

		}

		if  ( mw.config.get( 'wgAction' ) == "formedit") {
			params += "&target=" + encodeURIComponent( mw.config.get( 'wgPageName' ) );
		} else if ( mw.config.get( 'wgCanonicalSpecialPageName' ) == "FormEdit") {

			var url = String(window.location);

			var stop = url.indexOf("?");
			if ( stop > 0 ) url = url.substring(0, stop);

			var start = url.indexOf( mw.config.get( 'wgPageName' ) ); // find start of page name
			start = url.indexOf("/", start) + 1; // find start of subpage

			if ( start >= 0 ) {
				stop = url.indexOf("/", start); // find end of first subpage
			} else {
				stop = -1;
			}

			if (stop >= 0) {
				params += "&form=" + encodeURIComponent( url.substring(start, stop) );

				start = stop + 1;
				params += "&target=" + encodeURIComponent( url.substr(start) );

			} else {
				params += "&form=" + encodeURIComponent( url.substr(start) );
			}

		}

		params += "&wpMinoredit=1";

		return params;
	}

})(jQuery);
