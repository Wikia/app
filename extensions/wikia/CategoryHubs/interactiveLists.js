
var success_close_speed = 3000;

$(document).ready(function(){
	$("#tabs").tabs(); // active jQuery UI tab widget for answered/unanswered

	// TODO: Bind events.

	// Answer button.
	$(".cathub-button-answer").live('click', function(){
		createAnswerForm(this);
	});
	
	// Rephrase button.
	$(".cathub-button-rephrase").live('click', function(){
		createRephraseForm(this);
	});
});


function createAnswerForm(button){
	// Will handle 'cancel' differently based on whether it was answered or unsanswered originally.
	var wasAnswered = $(button).parents("li").hasClass('answered-questions');

	var formCode = '';

	var articlePathRegExp = wgArticlePath.replace(/\$1/, '(.*)').replace(/\\/, '\\\\').replace(/\?/g, '\\?');
	questions = $(button).parents("li").find('.cathub-article-link a').attr('href').match( new RegExp(articlePathRegExp, 'i') );
	if(!questions){
		console.error("The title of the link did not match the article regex in interactiveLists.js - could not find article title.");
	}
	var this_title = questions[1];

	// The code for the form (initially only the spinner is visible - the async load of the question content may take time).
	formCode += "<div class='cathub-actual-answer-wrapper'>";
		formCode += "<img src='"+wgAjaxImageSrc+"' class='cathub-spinner'/>";
	
		// The main div with the 'Answered' header - hidden until the content is loaded.
		formCode += "<div class='cathub-actual-answer' style='display:none'>";
		formCode += "<span class='cathub-answer-heading'>"+wgCatHubAnswerHeadingMsg+"</span><br/>\n";
			formCode += "<div>";
				// Add the textarea (content will be loaded via the API).
				formCode += "<textarea class='cathub-add-answer'></textarea>";
				
				// Add the save and cancel buttons.
				formCode += "<div class='cathub-button'>\n";
				formCode += "<a rel='nofollow' class='bigButton cathub-button-save' href='javascript:void(0)'><big>";
				formCode += wgCatHubSaveButtonMsg + "</big><small>&nbsp;</small></a>\n";
				formCode += "&nbsp;&nbsp;&nbsp;"; // TODO: FIXME: This doesn't space the buttons out.
				formCode += "<a rel='nofollow' class='bigButton cathub-button-save' href='javascript:void(0)'><big>";
				formCode += wgCatHubCancelButtonMsg + "</big><small>&nbsp;</small></a>\n";
				formCode += "</div>\n";
			formCode += "</div>\n";
		formCode += "</div>\n";
	formCode += "</div>\n";

	// If this answer is already answered, hide the answer so the form can be displayed.
	$(button).parents("li").find('.cathub-actual-answer').hide();
	$(button).parents("li").append(formCode);

	//Get original article content first
	url = wgServer + wgScriptPath + "/api.php?format=json&action=query&prop=revisions&rvprop=content&titles=" + this_title;
	jQuery.getJSON( url, "", function( j ){
		existing_content = "";
		if( j.query.pages ){
			for( page in j.query.pages ){
				existing_content = j.query.pages[page].revisions[0]["*"];
			}
		}
		existing_content = existing_content.replace( new RegExp("\\[\\[" + wgCategoryName  + ":" + wgAnsweredCategory  + "\]\]", "gi"), "");
		existing_content = existing_content.replace( new RegExp("\\[\\[" + wgCategoryName  + ":" + wgUnAnsweredCategory  + "\]\]", "gi"), "");
		add_answer = $(button).parents('li').find('.cathub-add-answer').get(0);
		add_answer.value = jQuery.trim(existing_content);

		// Hide spinner & show content.
		$(button).parents('li').find('.cathub-actual-answer-wrapper .cathub-spinner').hide();
		$(button).parents('li').find('.cathub-actual-answer-wrapper .cathub-actual-answer').show();
	});

	$(button).hide();
}

function createRephraseForm(button){

	// TODO: IMPLEMENT
	
	
	$(button).hide();
}
