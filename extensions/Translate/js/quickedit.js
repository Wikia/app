/**
 * JavaScript that implements the Ajax translation interface, which was at the
 * time of writing this probably the biggest usability problem in the extension.
 * Most importantly, it speeds up translating and keeps the list of translatable
 * messages open. It also allows multiple translation dialogs, for doing quick
 * updates to other messages or documentation, or translating multiple languages
 * simultaneously together with the "In other languages" display included in
 * translation helpers and implemented by utils/TranslationhHelpers.php.
 * The form itself is implemented by utils/TranslationEditPage.php, which is
 * called from Special:Translate/editpage?page=Namespace:pagename.
 *
 * TODO list:
 * * On succesful save, update the MessageTable display too.
 * * I18n for the messages
 * * Integrate the (new) edittoolbar
 * * Autoload ui classes
 * * Instead of hc'd onscript, give them a class and use necessary triggers
 * * Live-update the checks assistant
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2009 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

function trlOpenJsEdit( page ) {
	var url = wgScript + "?title=Special:Translate/editpage&page=" + page + "&uselang=" + wgUserLanguage;
	var id = "jsedit" +  page.replace( /[^a-zA-Z0-9_]/g, '_' );

	var dialog = jQuery("#"+id);
	if ( dialog.size() > 0 ) {
		dialog.dialog("option", "position", "top" );
		dialog.dialog("open");
		return false;
	}

	jQuery('<div></div>').attr('id', id).appendTo(jQuery('body'));

	var dialog = jQuery("#"+id);

	dialog = dialog.load(url, false, function() {
		var form = jQuery("#"+ id + " form");

		var fb = form.find( ".mw-translate-fb" );
		fb.click( function() {
			var queryString = form.formSerialize();
			// FIXME: forward contents of the text area
			var newWindow = window.open( wgScript + "?title=" + page + "&action=edit&from=xjs" );
			dialog.dialog("close");
			return false;
		} );

		var textarea = form.find( ".mw-translate-edit-area" );
		textarea.width(textarea.width()-4);
		//textarea.wikiEditor();
		textarea.focus();

		form.ajaxForm({
			datatype: "json",
			success: function(json) {
				json = JSON.parse(json);
				if ( json.error ) {
					alert( json.error.info + " (" + json.error.code +")" );
				} else if ( json.edit.result == "Failure" ) {
					alert( "Extension error. Copy your text and try normal edit." );
				} else if ( json.edit.result == "Success" ) {
					//alert( "Saved!" );
					dialog.dialog("close");
				} else {
					alert( "Unknown error." );
				}
			}
		});
	});

    dialog.dialog({
		bgiframe: true,
		width: parseInt(trlVpWidth()*0.8),
		title: page,
		position: "top"
	});

	return false;
}

function trlVpWidth() {
	return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
}

/*
mw.load([
	[ '$j.ui'
	],[
		'$j.ui.resizable',
		'$j.ui.draggable',
		'$j.ui.dialog',
	]
], function(){
	$j('link_target').dialog( dialogConfig)
});
*/