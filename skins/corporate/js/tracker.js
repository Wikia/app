var initTracker = function()
{
	String.prototype.replaceForTrac = function(){
		return this.replace(/ /g, "_").replace(/\./g, "").replace(/Q&amp;A/, "answers");
	}

	var addTrack = function(name,url){
		 $(name).click(function(){
			 WET.byStr(url);
		 });
	 }

	 var addFooterTrack = function(id,name){
		 $('#' + id + ' a').click(function(e){
			 target = $(e.target);
			 if (target.hasClass('last4')){
				 data = target.attr('id').split('_');
				 WET.byStr('footer/link_' + data[2]);
			 } else {
				 WET.byStr('footer/' + name + '/' + target.html().replaceForTrac());	 
			 }
		 });
	 }
	 
	var addPageOrHub = function(str){
		 if (wgIsMainpage) {
			 return "main_page/" + str;
		 } else {
			 return "hub/" + str;
		 }
	}

	 addTrack('#wikia-search-submit', 'find_a_wiki');
	 addTrack('#wikia-login-link', 'log-in');
	 addTrack('#wikia-create-account-link', 'sign-up');
	 addTrack('#wikia-global-hot-spots .wikia-page-link', addPageOrHub('hotspots/article'));
	 addTrack('#wikia-global-hot-spots .wikia-wiki-link', addPageOrHub('hotspots/wiki_name'));
	 addTrack('.create-wiki-container .wikia-button','main_page/create_a_wiki');
	 addTrack('#spotlight-slider .nav', addPageOrHub('slider/thumb'));
	 addTrack('.create-wiki-container .wikia-button','main_page/create_a_wiki');
	 addTrack('#wikia-create-wiki .wikia-button','bottom/create_a_wiki')
	 addTrack('#wikia-whats-up a', 'Special_coverage');
	 
	 addFooterTrack('wikia-international', 'left_column');
	 addFooterTrack('wikia-in-the-know', 'middle_column');
	 addFooterTrack('wikia-more-links', 'right_column');
	 addFooterTrack('SupplementalNav', 'bottom');
	 
	 $('.spotlight-slider, #spotlight-slider .wikia-button').click(function(e){
		 switch(e.target.nodeName){
		 	case 'SPAN': element = e.target.parentNode.parentNode.parentNode ; break;
		 	case 'A': element = e.target.parentNode.parentNode; break;
		 	case 'IMG': element = e.target.parentNode.parentNode; break;
		 }
		 out = element.id.split('-');
		 WET.byStr(addPageOrHub('slider/featured/' + (parseInt(out[2]) + 1) ));

		if (!wgIsMainpage) {
			 WET.byStr('hub/sf/' + wgPageName + '/' + (parseInt(out[2]) + 1) );
		}
	 });
	 
	 $("#GlobalNav ul:first > li").hover(function(e){
		 if (e.target.nodeName == "A"){
			 WET.byStr('nav-bar/' + $.trim($(e.target).html()).replaceForTrac()+ '/hoover');
		 }
	 },function(){});

	 $(".nav-link").click(function(e){
		 WET.byStr('nav-bar/' + $(e.target).html().replaceForTrac() + '/heading');
	 });
	 
	 $(".nav-sub-link").click(function(e) {
		 parent = $(e.target.parentNode.parentNode.parentNode).find("a").html().replaceForTrac();
		 targetId = e.target.id.split("_");
		 WET.byStr('nav-bar/' + parent + '/menu' + targetId[4]);
	 });
	 
}


jQuery.tracker.track = function(fakeurl) {     
    fakeurlArray = fakeurl.split('/');
    if(typeof urchinTracker != 'undefined') {
        _uacct = "UA-2871474-1";
        var username = wgUserName == null ? 'anon' : 'user';
        var fake = '/1_home/' + username + '/' + fakeurl;
        $().log('tracker: ' + fake);
        urchinTracker(fake);
        if(wgPrivateTracker) {
            fake = '/1_home/' + wgDB + '/' + username + '/' + fakeurl;
            $().log('tracker: ' + fake);
            urchinTracker(fake);
        }
    }
};
