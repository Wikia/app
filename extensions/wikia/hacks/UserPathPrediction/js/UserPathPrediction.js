$(function() {
	UserPathPrediction.init();
})

var UserPathPrediction = {
	
	init: function() {

		// Bind click to button
		$('#selectWiki').change(function() {

		});
		
		$('#selectArticle').change(function() {
			//load graph or actually draw it
		});
		
		$("#articleTable").tablesorter(); 
	},
	
	drawGraph: function() {
		
	}
	
};