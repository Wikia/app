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

			// TODO: MAKE THE REQUEST TO THE API FOR THE LIST OF FUNCTIONS.
			// TODO: MAKE THE REQUEST TO THE API FOR THE LIST OF FUNCTIONS.
		
			// TODO: Add the list of functions to the DOM.
			// TODO: Add the list of functions to the DOM.
			//$('#apEx_loading').hide();
		
		};
	};
}

$(document).ready(function(){
	var apEx = new ApiExplorer();
	apEx.run();
});
