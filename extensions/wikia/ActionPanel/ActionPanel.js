//add action hover to all main namespace links

var menu_is_open = false;
var success_close_speed = 3000;

jQuery(document).ready(function() {
	//create one hidden hover image for use on mouseovers
	jQuery(document.body).append('<div id="ActionPanelTrigger"></div>');
	
	applyActionsOnQuestions();
	//jQuery(document.body).click(ActionPanelClose);
}).click(ActionPanelClose)

function ActionPanelClose() {
	if (menu_is_open) {
		jQuery(".categorize_help_container").remove();
		jQuery('.questionhovermenu').remove();
		jQuery("#ActionPanelTrigger").hide();
		menu_is_open = false;
	}
}

function applyActionsOnQuestions(){
	jQuery("[href*='/wiki/']").live("mouseover", function(){
		if( menu_is_open )return;
		questions = this.href.match(/\/wiki\/(.*)/i );
		jQuery("#ActionPanelTrigger").unbind('mouseenter mouseleave'); 
		
		//TODO
		//for wikianswers we are currently limiting this to only the main namespace
		//ideally, there should be some sort of setting to have you configure which links get the action panel
		if( questions[1] != wgPageName && questions[1].indexOf(":") == -1 ){
			
			var this_title = questions[1];
			var this_link = this
			var modes = new Array();
			
			//Trigger Reposition
			jQuery("#ActionPanelTrigger").stop(true, true).css( "top", ( jQuery(this).offset().top ) ).css( "left", ( jQuery(this).offset().left + jQuery(this).width() + 5) ).show();
			jQuery("#ActionPanelTrigger").hover(
				
				
			function(){
	
			if (menu_is_open == false){
				jQuery("#ActionPanelTrigger").stop(true, true).show();
				
				//Hover Menu Create
		
				menu_is_open = true;
				var hover_menu = document.createElement('div');
				menu_left = ( jQuery(this).offset().left + jQuery(this).width() ) - 260;
				if( menu_left < 0 ){
					menu_left = ( jQuery(this).offset().left + jQuery(this).width() ) - 20;
					close_float = "right";
				}else{
					close_float = "left";
				}
				
				jQuery( hover_menu ).addClass("questionhovermenu").css({
						display: "none",
						top: jQuery(this).offset().top + 5,
						left: menu_left 
					}).click(function(e) {
						e.stopPropagation();
					});
				edit_link = wgServer + wgScript + "?title=" + this_title + "&action=edit";
				delete_link = wgServer + wgScript + "?title=" + this_title + "&action=delete";
				
				menu_html = "<div class='questionhovertitle'>" + wgActionPanelTitleMsg + "</div>";
				menu_html += "<div class='questionhovername'>" + decodeURIComponent( this_title.replace(/_/g," ") ) + "</div>";
				menu_html += "<div class='questionhoverlinks'><a href='javascript:void(0);' class='hoveranswer questionhoverlinks-selected'>" + wgActionPanelEditMsg + "</a> <a href='javascript:void(0);' class='hovercategorize'>" + wgActionPanelCategorizeMsg + "</a> <a href='" + delete_link + "' xclass='hoverdelete'>" + wgActionPanelDeleteMsg + "</a> <a href='javascript:void(0);' class='hoverrename'>" + wgActionPanelRenameMsg + "</a> </div>"
				hover_menu.innerHTML = menu_html;
				
				function selectHoverLink( modes, selected, link ){
					jQuery(".categorize_help_container").remove();
					jQuery("div.questionhoverlinks a").removeClass("questionhoverlinks-selected")
					jQuery("div.hoverform").hide()
					
					jQuery(link).addClass("questionhoverlinks-selected");
					jQuery( modes[ selected ].form ).show()
				}
				
				//close button
				function actionSuccess( time ){
					if(!time)time="slow";
					jQuery(".categorize_help_container").remove();
					jQuery( hover_menu ).fadeOut( time );
					jQuery("#ActionPanelTrigger").hide();
					menu_is_open = false;
				}
				function actionWait(){
					jQuery( ".actionPanelError" ).remove();
					var spinner = document.createElement( "img" );
					spinner.src = stylepath + "/common/images/spinner.gif";
					spinner.id = "action-panel-spinner";
					jQuery( ".questionhovermenu" ).append(spinner);
				}
				
				function errorMessage( error ){
					jQuery("#action-panel-spinner").remove();
					var error_container = document.createElement( "div" );
					jQuery( error_container ).addClass("actionPanelError").css("color","red")
					jQuery( error_container ).html (error );
					jQuery( ".questionhovermenu" ).append(error_container);
				}
				
				var close_button = document.createElement('span');
				close_button.innerHTML = "x";
				jQuery( close_button ).css("float",close_float).css("cursor","pointer").css("color","#FFFFFF").click( ActionPanelClose );
				jQuery( hover_menu ).prepend(close_button);
				
				//Quick Answer Box is Default
				var quick_answer = document.createElement('div');
				jQuery( quick_answer ).addClass("hoverform");
				modes["answer"] = {form: quick_answer, is_selected: true };
				
				//Quick Answer Box is Default
				var quick_rename = document.createElement('div');
				quick_rename.innerHTML = "<div class='quickrename'><input id='quickmove' type='text' style='width:240px' value='" + this_title.replace(/_/g," ") + "'></div>";
				jQuery( quick_rename ).css("display","none").addClass("hoverform");
				modes["rename"] = { form: quick_rename, is_selected: false };
				
				//Categorize Box
				var quick_categorize = document.createElement('div');
				quick_categorize.innerHTML = "<div class='quickcategorize'></div>";
				jQuery( quick_categorize ).css("display","none").addClass("hoverform");
				modes["categorize"] = { form: quick_categorize, is_selected: false };
				
				jQuery("body").append(hover_menu);
				jQuery( hover_menu ).append(quick_answer);
				jQuery( hover_menu ).append(quick_rename);
				jQuery( hover_menu ).append(quick_categorize);
				
				//Quick Answer Form and Callback
				var add_answer = document.createElement('textarea');
				jQuery( add_answer ).css("width",235);
				jQuery( quick_answer ).append(add_answer);
				
				//get page content first
				url = wgServer + "/api.php?format=json&action=query&prop=revisions&rvprop=content&titles=" + this_title;
				jQuery.getJSON( url, "", function( j ){	
					
					existing_content = "";
					if( j.query.pages ){
						for( page in j.query.pages ){
							existing_content = j.query.pages[page].revisions[0]["*"];
						}	
					}
					existing_content = existing_content.replace( new RegExp("\\[\\[" + wgCategoryName  + ":" + wgAnsweredCategory  + "\]\]", "gi"), "");
					existing_content = existing_content.replace( new RegExp("\\[\\[" + wgCategoryName  + ":" + wgUnAnsweredCategory  + "\]\]", "gi"), "");
					add_answer.value = jQuery.trim(existing_content);
					var save_button = document.createElement('input');
					save_button.setAttribute("type", "button");  
					save_button.setAttribute("value", wgSaveMsg.toUpperCase() ); 
					jQuery( save_button ).addClass("hoverbutton")
					jQuery( quick_answer ).append(save_button);
					jQuery( save_button ).click( function(){
						actionWait()
						url = wgServer + "/api.php?format=json&action=query&prop=info&intoken=edit&titles=" + this_title;
						
						
						jQuery.getJSON( url, "", function( editPage ){	
							if( editPage.query.pages ){
								
								for( page in editPage.query.pages ){
									token = editPage.query.pages[page].edittoken ;	
								}
								//alert( "you would have saved (" + add_answer + ") to " + questions[1] + " with token " + token + " (disabled for testing)" )
								//return false;
					
								url = wgServer + "/api.php?format=json&token=" + encodeURIComponent(token) + "&action=edit&title=" + this_title + "&text=" + add_answer.value;
								jQuery.post( url, "", function( response ){	
									eval("j=" + response);
									
									if( j.error ){
										errorMessage( j.error.info )
										return false;
									}else{
										jQuery( hover_menu ).html( wgActionPanelEditSuccessMsg );
										actionSuccess( success_close_speed );
										
									}
								});
							}
						});			
					});
				});
	
				
				//Quick Rename Form and Callback
				var save_button = document.createElement('input');
				save_button.setAttribute("type", "button");  
				save_button.setAttribute("value", wgSaveMsg.toUpperCase()  );  
				jQuery( save_button ).addClass("hoverbutton")
				jQuery( quick_rename ).append(save_button);
				jQuery( save_button ).click( function(){
					
					actionWait()
					//alert( "you would have renamed  " + this_title + " (disabled for testing)" )
					//return false;
					//Need to first get an edit token
					url = wgServer + "/api.php?format=json&action=query&prop=info&intoken=move&titles=" + this_title;
					
					jQuery.getJSON( url, "", function( movePage ){	
						
						if( movePage.query.pages ){
							
							for( page in movePage.query.pages ){
								token = movePage.query.pages[page].movetoken ;	
							}
							url = wgServer + "/api.php?format=json&token=" + encodeURIComponent(token) + "&action=move&from=" + this_title + "&to=" + document.getElementById("quickmove").value;
							jQuery.post( url, "", function( response ){	
								eval("j=" + response);
								removeSpinner("do_action")
								if( j.error ){
									errorMessage( j.error.info )
									return false;
								}else{
									jQuery(this_link).html( document.getElementById("quickmove").value );
									jQuery( hover_menu ).html( wgActionPanelRenameSuccessMsg );
									actionSuccess( success_close_speed );
								}
							});
						}
						
					});			
				});
	
				//Quick Delete Form and Callback
				
				jQuery( ".hoverdelete").click( function(){
					//alert( "you would have renamed  " + this_title + " (disabled for testing)" )
					//return false;
					//Need to first get an edit token
					url = wgServer + "/api.php?format=json&action=query&prop=info&intoken=delete&titles=" + this_title;
				
					jQuery.getJSON( url, "", function( deletePage ){	
						
						if( deletePage.query.pages ){
							for( page in deletePage.query.pages ){
								token = deletePage.query.pages[page].deletetoken ;	
							}
							url = wgServer + "/api.php?action=delete";
							
							jQuery.post( url, { token: encodeURIComponent(token), title: this_title.replace(/_/g," ") } , function( response ){
								
								eval("j=" + response);
								
								if( j.error ){
									alert( j.error.info )
									return false;
								}else{
									jQuery(this_link).fadeOut("slow");
								}
							});
						}
						
					});			
				});
				
				//Quick Categorize Form and Callback
				var add_categories = document.createElement('textarea');
				add_categories.id = "categories_text";
				jQuery( add_categories ).css("width",235);
				jQuery( quick_categorize ).append(add_categories);
				
				var save_button = document.createElement('input');
				save_button.setAttribute("type", "button");  
				save_button.setAttribute("value", wgSaveMsg.toUpperCase() );  
				jQuery( save_button ).addClass("hoverbutton")
				jQuery( quick_categorize ).append(save_button);
				
				jQuery( save_button ).click( function(){
					jQuery(".categorize_help_container").remove();
					actionWait()
					//get page content first
					url = wgServer + "/api.php?format=json&action=query&prop=revisions&rvprop=content&titles=" + this_title;
					jQuery.getJSON( url, "", function( j ){	
						
						existing_content = "";
						if( j.query.pages ){
							for( page in j.query.pages ){
								existing_content = j.query.pages[page].revisions[0]["*"];
							}	
						}
						
						url = wgServer + "/api.php?format=json&action=query&prop=info&intoken=edit&titles=" + this_title;
		
						
						jQuery.getJSON( url, "", function( editPage ){	
							if( editPage.query.pages ){
								
								for( page in editPage.query.pages ){
									token = editPage.query.pages[page].edittoken ;	
								}
								
								//parse categories from user into wikitext
								categories_wiki_text = ""
								categories_array = add_categories.value.split("\n");
								
								for( x = 0; x <= categories_array.length-1; x++ ){
									category = categories_array[x].replace(/^\s+|\s+$/g, '')
									if( category )categories_wiki_text += "[[" + wgCategoryName + ":" + category + "]]\n";
									
								}
								regex = new RegExp("\\[\\[" + wgCategoryName + ":([^\\]]*?)].*?\\]", "gi");
								wiki_text = existing_content.replace(regex,"") + "\n\n" + categories_wiki_text;
								//alert( "would have saved wiki text:" + wiki_text )
								//return false;
								url = wgServer + "/api.php?format=json&token=" + encodeURIComponent(token) + "&action=edit&title=" + this_title + "&text=" + wiki_text + "&summary=" + wgActionPanelAddCategoriesSummary;
								jQuery.post( url, "", function( response ){	
									eval("j=" + response);
									
									if( j.error ){
										errorMessage( j.error.info )
										return false;
									}else{
										
										jQuery( hover_menu ).html( wgActionPanelCategorizeSuccessMsg );
										actionSuccess( success_close_speed );
										//ActionPanelClose();	
											
									}
								});
							}
						});	
					});
				});
				
				//Answer / Rename Toggle
				jQuery( ".hoverrename" ).click( function(){ selectHoverLink( modes, "rename",this) });
				jQuery( ".hovercategorize" ).click( function(){ 
					current_link = this
					url = wgServer + "/api.php?format=json&action=query&prop=categories&titles=" + this_title;
					
					jQuery.getJSON( url, "", function( j ){	
						
						
						if( j.query.pages ){
							for( page in j.query.pages ){
								for(x = 0; x <= j.query.pages[page].categories.length-1;x++){
									category = j.query.pages[page].categories[x].title.replace(wgCategoryName+":","");
									if( category.toUpperCase() != wgUnAnsweredCategory.toUpperCase() && category.toUpperCase() != wgAnsweredCategory.toUpperCase() ){
										add_categories.value += j.query.pages[page].categories[x].title.replace(wgCategoryName+":","") + "\n";
									}
								}
							}	
						}
						selectHoverLink( modes, "categorize", current_link) 
						var categorize_help = document.createElement('div');
						jQuery("body").append(categorize_help);
						
						var categorize_auto = document.createElement('div');
						
						
						categorize_auto.id = "categories_autocomplete";
						jQuery( categorize_auto ).addClass("yui-skin-sam").css({
								background:"#FFFFFF",
								position:"absolute",
								left:jQuery(hover_menu).offset().left + 10,
								top:jQuery(hover_menu).offset().top + jQuery(hover_menu).height() - 15,
								width:235,
								"z-index":2001
							});
						jQuery("body").append(categorize_auto);
						jQuery( categorize_auto ).click(function(e) {
								e.stopPropagation();
						});
						
						jQuery( categorize_help ).css( "top", jQuery(hover_menu).offset().top + jQuery(hover_menu).height() + 9 ).css( "left",  jQuery(hover_menu).offset().left )
						jQuery( categorize_help ).addClass("categorize_help_container").css("display","none")
						categorize_help.innerHTML = "<div class='categorize_help'>" + wgActionPanelCategorizeHelpMsg + "</div>";
						jQuery( categorize_help ).slideDown("slow")
						
						function getCaretPosition( field ){
							if (document.selection  && document.selection.createRange) {
								
							}else if (field.selectionStart || field.selectionStart == '0') { 
								return field.selectionStart
							}
						}
						
						var oDS = new YAHOO.util.XHRDataSource(''); 
						
						// Set the responseType 
						oDS.responseType = YAHOO.util.XHRDataSource.TYPE_JSON; 
						// Define the schema of the JSON results 
						oDS.responseSchema = { 
							resultsList : "ResultSet.Result", 
							fields : ["category", "count"] 
						}; 
						var myAutoComp = new YAHOO.widget.AutoComplete("categories_text","categories_autocomplete", oDS); 
						myAutoComp.maxResultsDisplayed = 5;  
						myAutoComp.minQueryLength = 3; 
						myAutoComp.queryQuestionMark  = false; 
						
						var sQuery = "";
						var completeCategories = "";	
						var current_caret = 0;
						
						//we only want to send the current line of the textarea
						myAutoComp.generateRequest = function() { 
							
							if (document.selection  && document.selection.createRange) { //IE
								add_categories.focus();
								var range = document.selection.createRange();
							   	rangeCopy = range.duplicate();	
								rangeCopy.moveToElementText(add_categories);
								rangeCopy.setEndPoint( 'EndToEnd', range );
								current_caret = rangeCopy.text.length - range.text.length;
							}else if (add_categories.selectionStart || add_categories.selectionStart == '0') { //Moz
								current_caret = add_categories.selectionStart;
							}
							
							current_line_position = 0;
							lines = add_categories.value.split("\n");
							
							for( x = 0; x<=lines.length-1;x++ ){
								
								if( current_line_position < current_caret && current_caret <= ( current_line_position + (lines[x].length) ) ){
									sQuery = lines[x];
									break;
								}
								current_line_position += lines[x].length+1
							}
							//we need to store these for use after someone clicks an autocomplete value
							completeCategories = add_categories.value
							
							return "/index.php?action=ajax&rs=wfGetCategorySuggest&rsargs[]=" + sQuery + "&rsargs[]=5" 
						}; 
						
						
						myAutoComp.autoHighlight = true; 
						myAutoComp.resultTypeList = false; 
						myAutoComp.formatResult = function(oResultData, sQuery, sResultMatch) { 
							return ('<b>' + sResultMatch + '</b> - <span style="color:green">' +  oResultData.count + ' page(s)</span> '); 
						}; 	
						
						//custom function for when user selects autocomplete value
						var itemSelectHandler = function(sType, aArgs) { 
							
							selected_data = aArgs[2].category;
							lines = completeCategories.split("\n");
							
							//reset the textarea because we will rebuild it
							add_categories.value = "";
							
							current_line_position = 0;
							for( x = 0; x<=lines.length-1;x++ ){
								
								the_line = lines[x]
								//we need to overwrite the line with the autocomplete value
								if( current_line_position < current_caret && current_caret <= ( current_line_position + (lines[x].length) ) ){
									the_line = selected_data
									
								}
								current_line_position += lines[x].length+1
								
								//rebuild the textarea
								add_categories.value += the_line + "\n";
							}
							
						}; 
						myAutoComp.itemSelectEvent.subscribe(itemSelectHandler);
	
						
					});
				
				},"");
				jQuery( ".hoveranswer" ).click( function(){ selectHoverLink( modes, "answer", this) });
				jQuery(hover_menu).show();
			}
			});
			
		}
	}).live("mouseout", function(){
	
		if( !menu_is_open ) {
			jQuery("#ActionPanelTrigger").fadeOut("slow");
		}
	});
}

