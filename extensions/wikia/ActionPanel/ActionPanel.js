//add action hover to all question links
hovers = new Array();
menu_is_open = false;
function applyActionsOnQuestions(){
	jQuery("[href*='/wiki/']").hover(function(){
		if( menu_is_open )return;
		questions = this.href.match(/\/wiki\/(.*)/i );
		
		if( questions[1] != wgPageName && questions[1].indexOf(":") == -1 ){
			
			var this_title = questions[1];
			var this_link = this
			var modes = new Array();
			
			//Hover Arrow Create
			var hover = document.createElement('div');
			jQuery( hover ).addClass("questionhover").css("opacity","0.0").css( "top", ( jQuery(this).offset().top ) ).css( "left", ( jQuery(this).offset().left + jQuery(this).width() + 5)  )  
			hover.innerHTML = "<img src='" + stylepath + "/answers/images/lightning.png' width='16'>";
		
			hovers[ this ] = hover
			
			jQuery("body").append(hover);
			jQuery(hover).animate( { opacity: 1.0 } );
			
			jQuery( hover ).hover( function(){
				
			jQuery( hover ).fadeIn("fast")
			
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
		
			jQuery( hover_menu ).addClass("questionhovermenu").css("display","none").css( "top", ( jQuery(this).offset().top + 5 ) ).css( "left", menu_left )
			edit_link = wgServer + wgScript + "?title=" + this_title + "&action=edit";
			delete_link = wgServer + wgScript + "?title=" + this_title + "&action=delete";
			
			menu_html = "<div class='questionhovertitle'>" + wgActionPanelTitleMsg + "</div>";
			menu_html += "<div class='questionhovername'>" + decodeURIComponent( this_title.replace(/_/g," ") ) + "</div>";
			menu_html += "<div class='questionhoverlinks'><a href='javascript:void(0);' class='hoveranswer questionhoverlinks-selected'>" + wgActionPanelEditMsg + "</a> <a href='javascript:void(0);' class='hovercategorize'>" + wgActionPanelCategorizeMsg + "</a> <a href='" + delete_link + "' xclass='hoverdelete'>" + wgActionPanelDeleteMsg + "</a> <a href='javascript:void(0);' class='hoverrename'>" + wgActionPanelRenameMsg + "</a> </div>"
			hover_menu.innerHTML = menu_html;
			
			//close button
			var close_button = document.createElement('span');
			close_button.innerHTML = "x";
			jQuery( close_button ).css("float",close_float).css("cursor","pointer").css("color","#FFFFFF").click( function(){
				jQuery(".categorize_help_container").remove();
				jQuery( hover_menu ).fadeOut("slow");
				jQuery( hover ).remove();
				menu_is_open = false;
			});
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
			/*
			jQuery( hover_menu ).hover(
				function(){
					jQuery(this).fadeIn("fast");
				},
				""
			);
			*/
			
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
				add_answer.value = existing_content;
				var save_button = document.createElement('input');
				save_button.setAttribute("type", "button");  
				save_button.setAttribute("value", wgSaveMsg.toUpperCase() ); 
				jQuery( save_button ).addClass("hoverbutton")
				jQuery( quick_answer ).append(save_button);
				jQuery( save_button ).click( function(){
					
					url = wgServer + "/api.php?format=json&action=query&prop=info&intoken=edit&titles=" + this_title;
					
					
					jQuery.getJSON( url, "", function( editPage ){	
						if( editPage.query.pages ){
							
							for( page in editPage.query.pages ){
								token = editPage.query.pages[page].edittoken ;	
							}
							//alert( "you would have saved (" + add_answer + ") to " + questions[1] + " with token " + token + " (disabled for testing)" )
							//return false;
				
							url = wgServer + "/api.php?format=json&token=" + encodeURIComponent(token) + "&action=edit&title=" + title + "&text=" + add_answer;
							jQuery.post( url, "", function( response ){	
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
			});
					

			
			//Quick Rename Form and Callback
			var save_button = document.createElement('input');
			save_button.setAttribute("type", "button");  
			save_button.setAttribute("value", wgSaveMsg.toUpperCase()  );  
			jQuery( save_button ).addClass("hoverbutton")
			jQuery( quick_rename ).append(save_button);
			jQuery( save_button ).click( function(){
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
							
							if( j.error ){
								alert( j.error.info )
								return false;
							}else{
								jQuery(this_link).html( document.getElementById("quickmove").value );
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
			jQuery( add_categories ).css("width",235);
			jQuery( quick_categorize ).append(add_categories);
			
			var save_button = document.createElement('input');
			save_button.setAttribute("type", "button");  
			save_button.setAttribute("value", wgSaveMsg.toUpperCase() );  
			jQuery( save_button ).addClass("hoverbutton")
			jQuery( quick_categorize ).append(save_button);
			
			jQuery( save_button ).click( function(){
				
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
							wiki_text = existing_content.replace(regex,"") + "\n" + categories_wiki_text;
							//alert( "would have saved wiki text:" + wiki_text )
							//return false;
							url = wgServer + "/api.php?format=json&token=" + encodeURIComponent(token) + "&action=edit&title=" + this_title + "&text=" + wiki_text + "&summary=Add Categories";
							jQuery.post( url, "", function( response ){	
								eval("j=" + response);
								
								if( j.error ){
									alert( j.error.info )
									return false;
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
					
					jQuery( categorize_help ).css( "top", jQuery(hover_menu).offset().top + jQuery(hover_menu).height() + 9 ).css( "left",  jQuery(hover_menu).offset().left )
					jQuery( categorize_help ).addClass("categorize_help_container").css("display","none")
					categorize_help.innerHTML = "<div class='categorize_help'>" + wgActionPanelCategorizeHelpMsg + "</div>";
					jQuery( categorize_help ).slideDown("slow")
					
				});
			
			},"");
			jQuery( ".hoveranswer" ).click( function(){ selectHoverLink( modes, "answer", this) });
			jQuery(hover_menu).show();
			});
			/*
			jQuery( hover ).hover(
				function(){
					jQuery(hover_menu).show();
				}, 
				""
			);
			*/
			
			
		}
	},function(){
		//jQuery( hovers[ this ] ).css("padding-right","0px");
		if( !menu_is_open && hovers[ this ] ) jQuery( hovers[ this ] ).fadeOut("slow");
	});
}

function selectHoverLink( modes, selected, link ){
	jQuery(".categorize_help_container").remove();
	jQuery("div.questionhoverlinks a").removeClass("questionhoverlinks-selected")
	jQuery("div.hoverform").hide()
	
	jQuery(link).addClass("questionhoverlinks-selected");
	jQuery( modes[ selected ].form ).show()
}
