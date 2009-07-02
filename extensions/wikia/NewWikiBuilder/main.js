var NewWikiBuilder = {

};	      

NewWikiBuilder.handleError = function(e){
	// TODO: More graceful handling
	alert(Mediawiki.print_r(e));
};

NewWikiBuilder.updateStatus = Mediawiki.updateStatus;
