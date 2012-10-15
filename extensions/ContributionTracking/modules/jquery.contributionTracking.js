/**
 * Turns any form with the bare minimum "appropriate" fields into a form that
 * can get a donor to a gateway with no interstitial page.
 * To use:
 *		*) Install the ContributionTracking Extension.
 *		*) Include this module on a page.
 *		*) On that page, create a form that contains (at least) the fields
 *		required by ApiContributionTracking.
 *		*) Make sure that form's submit button has a unique ID.
 *		*) Assign that button the class of "ajax_me".
 *
 * @author Katie Horn <khorn@wikimedia.org>
 */

( function( $ ) {

	/**
	 * Binds the onclick function to everything with a class of "ajax_me".
	 */
	$.bindAjaxControls = function(){
		$(".ajax_me:disabled").removeAttr("disabled");
		$(".ajax_me").click(function() {
			this.disabled = true;
			$.goAjax(this.id);
			return false; //prevent regular form submission.
			//TODO: Think about the button disabling and enabling.
			//TODO: also think about a barber pole. That would go here.
		});
	}

	/**
	 * Turns the first parent form from the passing object, to an object we can
	 * pass to the API.
	 * Takes the button ID in string form.
	 */
	$.serializeForm = function(buttonID){
		buttonID = "#" + buttonID;
		var form = $(buttonID).parents("form:first");

		var serializedForm = form.serializeArray();
		var finalObj = {};

		for (key in serializedForm){
			if(serializedForm[key]['value'] != ""){
				finalObj[serializedForm[key]['name']] = serializedForm[key]['value'];
			}
		}
		return finalObj;
	}

	/**
	 * Sends the formatted ajax request to the API, turns the result into a
	 * hidden form, and immediately posts that form on return.
	 * Takes the button ID in string form.
	 */
	$.goAjax = function(buttonID) {

		var postData = $.serializeForm(buttonID);
		postData.action = "contributiontracking";
		postData.format = "json";
		//$.debugPostObjectWithAlert(postData);

		var processAjaxReturn = function(data, status){
			//TODO: Improve the language of the success and error dialogs.

			if(status != "success"){
				window.alert("Status: " + status);
				$(buttonID).removeAttr("disabled");
				$(".ajax_me:disabled").removeAttr("disabled");
				return;
			}

			if(data["error"]){
				//TODO: localization. And i18n. And stuff.
				window.alert("The following error has occurred:\r\n" + data["error"]["info"]);
				$(buttonID).removeAttr("disabled");
				$(".ajax_me:disabled").removeAttr("disabled");
				return;
			}

			if ($('#hideyform').length){
				$('#hideyform').empty(); //just in case something is already hiding in the hideyform.
			} else {
				$('<div id="hideyform"></div>').appendTo('body');
			}
			$('<form id="immediate_repost" action="' + data["returns"]["action"]["url"] + '"></form>').appendTo('#hideyform');
			for (key in data["returns"]["fields"]) {
				$('<input type="hidden" id="' + key +'" name="' + key +'" value="' + data["returns"]["fields"][key] +'">').appendTo('#immediate_repost');
			}
			$('#immediate_repost').submit();

		}

		$.post(
			mw.config.get('wgScriptPath') + '/api.php',
			postData,
			processAjaxReturn,
			'json');
	}

	/**
	 * Just for easy debugging. Should not actually be called anywhere.
	 * TODO: Take this out when we know we're done here.
	 */
	$.debugPostObjectWithAlert = function(object){
		var contents = "";
		for (key in object){
			contents += key + " = " + object[key] + "\r\n";
		}
		window.alert(contents);
	}

} )( jQuery );

$.bindAjaxControls();