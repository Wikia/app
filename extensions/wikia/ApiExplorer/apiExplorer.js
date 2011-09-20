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
			Mediawiki.paraminfo('paraminfo', '', function(result){
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

						// There are three very specific lists we care about. TODO: They seem all the same code structure, refactor to use a hash of approved names (not array so that we don't have to loop).
						if(param.name == 'modules'){
							$('#apEx div.modules>div.name').html( param.name );
							$('#apEx div.modules>div.description').html( param.description );
							for(var typeIndex in allTypes){
								var t = allTypes[typeIndex];
								$('#apEx div.modules>ul').append("<li>" + t + "</li>");
							}
						} else if(param.name == 'querymodules'){
							$('#apEx div.querymodules>div.name').html( param.name );
							$('#apEx div.querymodules>div.description').html( param.description );
							for(var typeIndex in allTypes){
								var t = allTypes[typeIndex];
								$('#apEx div.querymodules>ul').append("<li>" + t + "</li>");
							}
						} else if(param.name == 'formatmodules'){
							$('#apEx div.formatmodules>div.name').html( param.name );
							$('#apEx div.formatmodules>div.description').html( param.description );
							for(var typeIndex in allTypes){
								var t = allTypes[typeIndex];
								$('#apEx div.formatmodules>ul').append("<li>" + t + "</li>");
							}
						}
					}
				}

				// TODO: Make the divs collapsible.
				// TODO: Make the divs collapsible.

				// TODO: Make all of them collapsed except the first div?
				// TODO: Make all of them collapsed except the first div?

				// TODO: Add click-handlers to each li.
				// TODO: Add click-handlers to each li.

				$('#apEx_loading').hide();
				$('#apEx_main').show();
			}, function(err){
				$().log("ERROR GETTING LIST OF MODULES FROM THE API.\nMake sure this wiki is a Wikia wiki or running v1.18+ of MediaWiki.");
				$().log(err);
			});
		};
	};
}

$(document).ready(function(){
	var apEx = new ApiExplorer();
	apEx.run();
});
