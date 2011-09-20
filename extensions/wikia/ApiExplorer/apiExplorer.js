/**
 * @author Sean Colombo
 * @date 20110917
 *
 */

$().log("== API Explorer ==");

if(typeof ApiExplorer == "undefined"){
	ApiExplorer = function(){
		var self = this;

		/**
		 * Called on document ready to make the first call to the API to build the list of available functions.
		 */
		this.run = function(){
			$().log("Starting API Explorer...");
			
			// Show the loading indicator until the API request has returned & the new page-content is set-up.
			$('#apEx_loading').show();

			// Make a request to the API to get the list of available modules, querymodules, and formats.
			Mediawiki.paraminfo('modules', 'paraminfo', function(result){
				var params = result.paraminfo.modules[0].parameters;
				for(var index in params){
					var param = params[index];
					if(param.type){
						var allTypes = [];
						for(var typeIndex in param.type){
							var t = param.type[typeIndex];
							allTypes.push(t);
						}
						allTypes = allTypes.sort();

						// There are three specific top-level lists we care about.
						var names = {
							'modules': 'modules',
							'querymodules': 'querymodules',
							'formatmodules': 'formatmodules'
						};
						if(typeof names[param.name] != 'undefined'){
							var name = param.name;
							$('#apEx div.'+name+' h2.name').html( param.name );
							$('#apEx div.'+name+' div.description').html( param.description );
							for(var typeIndex in allTypes){
								var t = allTypes[typeIndex];
								$('#apEx div.'+name+' dl').append("<dt class='collapsible collapsed'><h3>" + t + "</h3></dt>");
							}

							// Add click-handlers to each dt to get more info on that function.
							$('#apEx div.'+name+' dt').click( function(e){
							
								// TODO: If already expanded, just collapse.
								// TODO: If already expanded, just collapse.
							
								var paramName = $(e.currentTarget).parents('div.paramName').data('param-name');

								// Make call to API to get info for that dt... ONLY if the dd is still empty.
								var ddContent = $(e.currentTarget).find('dd').html();
								if(ddContent == "" || ddContent == null){
									// The dd (definition) for this dt (term) is not loaded yet.  Use the API to load it.
									var dtName = $(e.currentTarget).find('h3').html();
									$().log("Content is empty, loading info from API for " + paramName + '=' + dtName);

									Mediawiki.paraminfo(paramName, dtName, function(result){

										$().log("Got info for "+ paramName + '=' + dtName);
										var modulesArray = result.paraminfo[paramName];
										
										$().log(modulesArray[0].parameters);

					// TEMPORARY UNTIL WE MAKE IT PRETTIER. TODO: FORMAT THIS DATA.
										var rawData = JSON.stringify( modulesArray[0] );
										$(e.currentTarget).append("<dd>" + rawData + "</dd>");
									});
								}

								// TODO: Toggle dT (yes, T) state to be expanded
								// TODO: Toggle dT (yes, T) state to be expanded


							});
						}
					}
				}

				// TODO: Make the divs collapsible.
				// TODO: Make the divs collapsible.

				// TODO: Make all of them collapsed (except the first div?)
				// TODO: Make all of them collapsed (except the first div?)

				$('#apEx_loading').hide();
				$('#apEx_main').show();
			}, function(err){
				$().log("ERROR GETTING LIST OF MODULES FROM THE API.\nMake sure this wiki is a Wikia wiki or running v1.18+ of MediaWiki.");
				$().log(err);
			});
		};
		
		this.clicked_modules = function(e){ return self.dtClicked( e, 'modules'); }
		this.clicked_querymodules = function(e){ return self.dtClicked( e, 'querymodules'); }
		this.clicked_formatmodules = function(e){ return self.dtClicked( e, 'formatmodules'); }
		this.dtClicked = function(e, paramName){
			$().log("Got a click on " + paramName);
			$().log(e);
		};
	};
}

$(document).ready(function(){
	var apEx = new ApiExplorer();
	apEx.run();
});
