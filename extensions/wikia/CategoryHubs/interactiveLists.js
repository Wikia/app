
var success_close_speed = 3000;

$(document).ready(function(){
	if (typeof $().tabs == 'function') {
		$("#tabs").tabs(); // active jQuery UI tab widget for answered/unanswered
		
		// Select the appropriate tab (for instance for using pagination on the non-default tab).
		var tabIndex = $("#cathub-tab-index-to-select").html();
		if(tabIndex && (tabIndex != 0)){
			$("#tabs").tabs('option', 'selected', parseInt(tabIndex));
		}
	}

	// Answer button.
	$(".cathub-button-answer").live('click', function(){
		createAnswerForm(this);
	});
	
	// Rephrase button.
	$(".cathub-button-rephrase").live('click', function(){
		createRephraseForm(this);
		});

	// add paging in case of tags, cannot be done other way  really
	if( $( '#answers_tags_next' ).exists() ) {
		$( '#answers_tags_next' ).live( 'click', goOnePageAway );
		
	} else if( $( '#answers_tags_prev' ).exists() ) {
		$( '#answers_tags_prev' ).live( 'click', goOnePageAway );
	}	

});

function goOnePageAway( e ) {		
	if( e ) {
		e.preventDefault();
	}
	var target = $(e.target);
	var href = target.attr( 'href' );
	var pre_offset = href.split( '&' )[1];
	var offset = pre_offset.split( '=' )[1];
	var pre_type = pre_offset.split( '=' )[0];
	var type = pre_type.split( '_' )[1];
	var url = wgServer + wgScriptPath +  "?action=ajax&rs=wfAnswersTagsAjaxGetArticles&type=" + type + "&offset" + offset;

	jQuery.getJSON( url, "", function( response ){
		if( 'a' == type ) {
			var placeholder = $( '#cathub-tab-answered' );
		} else {
			var placeholder = $( '#cathub-tab-unanswered' );
		}
		if( !response.error ) {
			placeholder.html( response.text );	
		} else {
			placeholder.html( 'error' );
		}

	});
}

function createAnswerForm(button){
	$(button).hide(); // do this first to prevent confusion

	// Will handle 'cancel' differently based on whether it was answered or unsanswered originally.
	//var wasAnswered = $(button).parents("li").hasClass('answered-questions');

	var formCode = '';
	var spinnerImgHtml = "<img src='"+wgAjaxImageSrc+"' class='cathub-spinner'/>";

	var articlePathRegExp = wgArticlePath.replace(/\$1/, '(.*)').replace(/\\/, '\\\\').replace(/\?/g, '\\?');
	var questions = $(button).parents("li").find('.cathub-article-link a').attr('href').match( new RegExp(articlePathRegExp, 'i') );
	if(!questions){
		console.error("The title of the link did not match the article regex in interactiveLists.js - could not find article title.");
	}
	var this_title = questions[1];

	// The code for the form (initially only the spinner is visible - the async load of the question content may take time).
	formCode += "<div class='cathub-actual-answer-wrapper'>";
		formCode += spinnerImgHtml;
	
		// The main div with the 'Answered' header - hidden until the content is loaded.
		formCode += "<div class='cathub-actual-answer' style='display:none'>";
		formCode += "<span class='cathub-answer-heading'>"+wgCatHubAnswerHeadingMsg+"</span><br/>\n";
			formCode += "<div>";
				// Add the textarea (content will be loaded via the API).
				formCode += '<div class="cathub-add-answer-wrapper"><textarea class="cathub-add-answer" rows="10" columns="80"></textarea></div>';
				var add_answer = $(button).parents('li').find('.cathub-add-answer').get(0);

				// Add the save and cancel buttons.
				formCode += "<div class='cathub-button' style='height:25px'>\n";
				formCode += "<a rel='nofollow' class='bigButton cathub-button-save' href='javascript:void(0)'><big>";
				formCode += wgCatHubSaveButtonMsg + "</big><small>&nbsp;</small></a>\n";
				formCode += "<a rel='nofollow' class='bigButton cathub-button-cancel' href='javascript:void(0)' style='margin-left:10px'><big>";
				formCode += wgCatHubCancelButtonMsg + "</big><small>&nbsp;</small></a>\n";
				formCode += "</div>\n";
			formCode += "</div>\n";
		formCode += "</div>\n";
	formCode += "</div>\n";

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
		//existing_content = existing_content.replace( new RegExp("\\[\\[.*?\]\]", "gi"), ""); // remove all 
		var add_answer = $(button).parents('li').find('.cathub-add-answer').get(0);
		add_answer.value = jQuery.trim(existing_content);

		// If this answer is already answered, hide the answer so the form can be displayed.
		$(button).parents("li").find('.cathub-actual-answer').hide();

		// Hide spinner & show content.
		$(button).parents('li').find('.cathub-actual-answer-wrapper .cathub-spinner').hide();
		$(button).parents('li').find('.cathub-actual-answer-wrapper .cathub-actual-answer').show();
	});

	// Handler for a click on the save button
	$(button).parents('li').find('.cathub-button-save').click( function(){
		$(this).parent().html(spinnerImgHtml);

		var url = wgServer + wgScriptPath + "/api.php?format=json&action=query&prop=info&intoken=edit&titles=" + this_title;

		jQuery.getJSON( url, "", function( editPage ){
			if( editPage.query.pages ){
			
				var add_answer = $(button).parents('li').find('.cathub-add-answer').get(0);

				for( page in editPage.query.pages ){
					token = editPage.query.pages[page].edittoken ;
				}
				//alert( "you would have saved (" + add_answer + ") to " + questions[1] + " with token " + token + " (disabled for testing)" )
				//return false;

				url = wgServer + wgScriptPath + "/api.php?format=json&token=" + encodeURIComponent(token) + "&action=edit&title=" + this_title + "&text=" + encodeURIComponent(add_answer.value);
				jQuery.postJSON( url, "", function( response ){
					if( response.error ){
						$(button).parents('li').find('.cathub-actual-answer-wrapper').prepend("<div>" + response.error.info + "</div>");
						return false;
					}else{
						// Add a spinner (for loading of new content) and display a success message for a bit.
						var successDiv = document.createElement( "div" );
						$(successDiv).html( wgCatHubEditSuccessMsg );
						$(successDiv).css('margin-top', '15px');
						$(button).parents('li').find('.cathub-actual-answer-wrapper')
							.html( '' ).prepend(successDiv)
							.append("<br/>" + spinnerImgHtml);
						//$(successDiv).fadeOut( success_close_speed );
						$(button).show();

						// Re-load the answer
						url = wgServer + wgScriptPath + "/api.php?format=json&action=query&prop=revisions&rvprop=content&titles=" + this_title;
						jQuery.getJSON( url, "", function( j ){
							existing_content = "";
							if( j.query.pages ){
								for( page in j.query.pages ){
									existing_content = j.query.pages[page].revisions[0]["*"];
								}
							}
							var rawWikiText = jQuery.trim(existing_content);
							url = wgServer + wgScriptPath + "/api.php?format=json&action=parse&prop=text&text=" + rawWikiText;
							jQuery.getJSON( url, "", function( j ){
								rendered_content = "";
								if( j.parse.text ){
									rendered_content = j.parse.text["*"];
								}
								
								var answerCode = '';
								answerCode += "<span class='cathub-answer-heading'>"+wgCatHubAnswerHeadingMsg+"</span><br/>\n";
								answerCode += rendered_content;

								$(button).parents('li').find('.cathub-actual-answer-wrapper').remove();
								
								// Show the rendered new answer.
								if($(button).parents("li").find('.cathub-actual-answer').size() > 0){
									$(button).parents("li").find('.cathub-actual-answer')
										.html(answerCode)
										.show();
								} else {
									// If this was originally in the unanswered list, then the div doesn't exist yet.
									answerCode = "<div class='cathub-actual-answer'>" + answerCode + "</div>\n";
									$(button).parents("li").append(answerCode);
									$(button).find('big').html(wgCatHubImproveAnswerButtonMsg);
									
									// To make the progress more visible, make the div bg green and purge the memcache for percent and for the lists.
									$.get(wgPurgeCategoryHubsCacheUrl, function(){
										$(button).parents("li").css('background-color', '#efe');
									});
								}
							});
						});
					}
				});
			}
		});
	});

	// Handler for a click on the cancel button.
	$(button).parents('li').find('.cathub-button-cancel').click( function(){
		$(button).parents("li").find('.cathub-actual-answer').show(); // if this was answered, will re-show the answer.
		$(button).parents('li').find('.cathub-actual-answer-wrapper').remove();
		$(button).show();
	});
}

function createRephraseForm(button){

	// TODO: IMPLEMENT
	
	
	$(button).hide();
}
