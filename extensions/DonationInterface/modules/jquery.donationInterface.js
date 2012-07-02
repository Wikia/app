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
		//$("form")
	}

	/**
	 * Turns the first parent form from the passing object, to an object we can
	 * pass to the API.
	 * Takes the button ID in string form.
	 */
	$.prepareXML = function(buttonID){
		buttonID = "#" + buttonID;
		var form = $(buttonID).parents("form:first");
		var xmlnode = $("#xml_structure");
		var xml = $("#xml_structure").html();
		
		delete form.attr( 'action' );
		delete form.attr( 'method' );
		

		//window.alert(xml);

		//xmlnode.find("merchantid").html("NEW VALUE");
		//window.alert( xmlnode.find("merchantid").html() );

		var serializedForm = form.serializeArray();
		var sendData = $.stageData(serializedForm);

		//TODO: Yeah, this works, but... grow up.
//		for (key in sendData){
//			if(xml.indexOf("@" + key) > 0){
//				xml = xml.replace("@" + key, sendData[key]);
//				//finalObj[serializedForm[key]['name']] = serializedForm[key]['value'];
//			}
//		}

		//Wow. The next business works. Crizzy.
		
		$.each(xmlnode.find("order").children() , function (index) {
			var keyname = $(this).text().replace("@", "");
			if (sendData[keyname]){
				$(this).html(sendData[keyname]);
			} else {
				$(this).remove();
			}
		});
		$.each(xmlnode.find("payment").children() , function (index) {
			var keyname = $(this).text().replace("@", "");
			if (sendData[keyname]){
				$(this).html(sendData[keyname]);
			} else {
				$(this).remove();
			}
		});


		//xml = $("#xml_structure").find("request").html();
		xml = $("#xml_structure").html();
		window.alert(xml);
		return xml;
	}
	
	$.stageData = function(serializedForm) {
		var finalObj = {};

		for (key in serializedForm){
			if(serializedForm[key]['value'] != ""){
				finalObj[serializedForm[key]['name']] = serializedForm[key]['value'];
			}
		}
		
		if (finalObj['emailAdd']){
			finalObj['email'] = finalObj['emailAdd'];
			delete finalObj['emailAdd'];
		}
		
		finalObj['amount'] = finalObj['amount'] * 100;
		//do the rest of the staging here. 
		
		$.debugPostObjectWithAlert(finalObj);
		
		return finalObj;
	}
	
	$(document).ajaxError(function(event, request, settings, thrown){
		var display = '';
		for (key in event){
			display += "event " + key + " : " + event[key] + "\r\n";
		}		
		for (key in event['data']){
			display += "event data " + key + " : " + event[key] + "\r\n";
		}
		for (key in request){
			display += "request " + key + " : " + event[key] + "\r\n";
		}
		for (key in settings){
			display += "settings " + key + " : " + event[key] + "\r\n";
		}
		for (key in thrown){
			display += "thrown " + key + " : " + event[key] + "\r\n";
		}
		window.alert("Ajax Error!\r\n" + display);
	});
	
	$.makeAndPostForm = function (postData){
		if ($('#hideyform').length){
			$('#hideyform').empty(); //just in case something is already hiding in the hideyform.
		} else {
			$('<div id="hideyform"></div>').appendTo('body');
		}
		$('<form id="immediate_repost" action="https://ps.gcsip.nl/wdl/wdl" method="POST"></form>').appendTo('#hideyform');
		$('<input type="hidden" id="xml" name="xml" value="' + postData +'">').appendTo('#immediate_repost');
		$('#immediate_repost').submit();
		window.alert("Form Submitted! Go look...");
	}
	

	/**
	 * Sends the formatted ajax request to the API, turns the result into a
	 * hidden form, and immediately posts that form on return.
	 * Takes the button ID in string form.
	 */
	$.goAjax = function(buttonID) {

		var postData = $.prepareXML(buttonID);
		//postData.action = "contributiontracking";
		$.makeAndPostForm(postData);
		return false;
		

		var processAjaxReturn = function(data, status){
			//TODO: Improve the language of the success and error dialogs.
			
			window.alert("Return! " + data);

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

//		$.post(
//			//mw.config.get('wgScriptPath') + '/api.php',
//			'https://ps.gcsip.nl/wdl/wdl',
//			//'http://ps.gcsip.nl/wdl/wdl',
//			//'http://www.katiehorn.com/nonsense/',
//			postData,
//			processAjaxReturn,
//			'xml');
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