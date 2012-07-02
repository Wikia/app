/**
 * @author Sean Colombo
 * @date 20110917
 *
 * Javascript app that uses the API on the current wiki to dynamically generate browsable documentation
 * for the same API.
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
							$('#apEx div.'+name+' h2.name').prepend( param.name ).data('module-name', param.name);
							$('#apEx div.'+name+' div.description').html( param.description );
							for(var typeIndex in allTypes){
								var t = allTypes[typeIndex];
								$('#apEx div.'+name+' dl').append("<dt class='collapsible collapsed'><h3 data-param-name='"+t+"'>" + t + "<span class='toggleIcon'></span></h3></dt>");
							}

							// Add click-handlers to each dt to get more info on that function.
							$('#apEx div.'+name+' dt.collapsible').click( function(e){
								// If already expanded, just collapse.
								if(!$( e.currentTarget ).hasClass('collapsed')){
									$( e.currentTarget ).addClass('collapsed');
								} else {
									// Toggle dt (yes, T) state to be expanded
									$( e.currentTarget ).removeClass('collapsed');

									var paramName = $(e.currentTarget).parents('div.paramName').data('param-name');

									// Make call to API to get info for that dt... ONLY if the dd is still empty.
									var ddContent = $(e.currentTarget).find('dd').html();
									if(ddContent == "" || ddContent == null){
										// The dd (definition) for this dt (term) is not loaded yet.  Use the API to load it.

										// TODO: Put a loading-indicator in the h3 and then remove when finished loading?
										// TODO: Put a loading-indicator in the h3 and then remove when finished loading?

										var dtName = $(e.currentTarget).find('h3').data('param-name');
										$().log("Content is empty, loading info from API for " + paramName + '=' + dtName);

										Mediawiki.paraminfo(paramName, dtName, function(result){
											$().log("Got info for "+ paramName + '=' + dtName);
											var modulesArray = result.paraminfo[paramName];

											var module = modulesArray[0];
											//var rawData = JSON.stringify( module );
											var html = self.objToHtml( module );
											$(e.currentTarget).append("<dd class='paramContent'>" + html + "</dd>");
										});
									}
								}
							});
						}
					}
				}

				// Make the top-level divs (modules, querymodules, formatmodules) collapsible.
				$('#apEx div.collapsible h2').click(function( e ){
					$( e.currentTarget ).parent('div').toggleClass('collapsed');
				});

				$('#apEx_loading').hide();
				$('#apEx').show();
			}, function(err){
				$().log("ERROR GETTING LIST OF MODULES FROM THE API.\nMake sure this wiki is a Wikia wiki or running v1.18+ of MediaWiki.");
				$().log(err);
			});
		};

		/**
		 * Converts a JS object to HTML (mostly nested lists), but tweaked for the specific use-case of
		 * the API Explorer's results from the API... so it will make the result more readable, but this function
		 * isn't as simple/portable as it would be otherwise.
		 */
		this.objToHtml = function( obj ){
			var html = "";
			var html = "<ul>";

			// TODO: Customize this for better display of parameters, errors, etc. (they're too nested right now).

			for(var key in obj){
				var value = obj[key];
				if(typeof value == 'object'){
					value = self.objToHtml( value );
				}
				html += "<li><strong>"+key+"</strong>: " + value + "</li>";
			}
			html += "</ul>";
			return html;
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
