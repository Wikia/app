 /**
  * Storyboard object.
  *
  * @file Storyboard.js
  * @ingroup Storyboard
  *
  * @author Jeroen De Dauw
  * @author Tha Devil (helpmij.nl)
  */

/**
 * Constructor for the Storyboard object.
 */
function Storyboard() {
	this.stories = [];

	this.pageNumber = 0;
	this.pageAmount = -1;

	this.isLoading = false;
}

/**
 * Scroll method.
 * Checks if new stories should be loaded, and calls loadAjax when this is the case.
 */
Storyboard.prototype.scroll = function(event) {
	var board = event.data[0];
	var documentHeight = jQuery(document).height();
	var top = jQuery("#storyboard").scrollTop();
	
	var resultsHeight = 0;
	jQuery("#storyboard .storyboard-result").each(function() {
		resultsHeight += $(this).height();
	});
	
	var threshold = ( ( top / 2 ) + ( 0.01 * Math.pow(documentHeight, 2) ) ) / resultsHeight;
	if (threshold > 0.6) threshold = 0.6;

	if( top / resultsHeight >= threshold && !board.isLoading && board.pageNumber < board.pageAmount )
	{
		board.loadAjax();
	}
};

/**
 * LoadAjax method.
 * Requests and loads new stories into the storyboard.
 */
Storyboard.prototype.loadAjax = function() {
	alert('load');
	var t = this;
	
	this.isLoading = true;
	
	jQuery("#storyboard").append(jQuery("<div />").attr("id","storyboard-loading"));
	
	jQuery.getJSON(storyboardPath + '/tags/Storyboard/Stories.php?&number=' + t.currentPage + '', function(json) {
		
		t.pageAmount = json.pageAmount;
		t.stories.push(json);
		t.isLoading = false;
		
		jQuery("#storyboard-loading").remove();
		
		t.display();
	});
};

/**
 * Display method.
 * Creates the storyboard layout.
 */
Storyboard.prototype.display = function() {
	alert('display');
};

/**
 * Reload method.
 * Removes all stories from the storyboard and loads a new batch of stories.
 */
Storyboard.prototype.reload = function() {
	jQuery("#storyboard").html("");
	this.stories = [];
	this.pageNumber = 0;
	this.loadAjax();
};