function WikiaPhoneOldTracker(str) {
	//_gaq.push(['_setAccount', 'UA-2871474-1']);
	//_gaq.push(['_trackPageview', str]);
}

username = wgUserName == null ? 'anon' : 'user';
WikiaPhoneOldTracker('/1_wikiaphone/' + username + '/view');
if(wgPrivateTracker) {
	WikiaPhoneOldTracker('/1_wikiaphone/' + wgDBname + '/' + username + '/view');
}

document.onclick = function(event){
	//IE doesn't pass in the event object
	event = event || window.event;

	//IE uses srcElement as the target
	var target = event.target || event.srcElement;
	var baseEvent = '1_wikiaphone/anon/click/';
	var eventToTrack = baseEvent;
	
	switch(target.id){
		case 'searchGoButton':
		case 'mw-searchButton':
			eventToTrack += 'search';
			WikiaPhoneOldTracker(eventToTrack);
			break;
		default:
			if(target.nodeName === 'A'){
				if(target.href.indexOf(CategoryNamespaceMessage) !== -1){
					eventToTrack += 'categorylink';
					WikiaPhoneOldTracker(eventToTrack);
				}else if(target.href.indexOf(SpecialNamespaceMessage) === -1){
					eventToTrack += 'contentlink';
					WikiaPhoneOldTracker(eventToTrack);
				}
			}
			
			if(target.parentNode){
				switch(target.parentNode.id){
					case 'ca-edit':
						eventToTrack += 'edit';
						WikiaPhoneOldTracker(eventToTrack);
						break;
					case 'n-randompage':
						eventToTrack += 'randompage';
						WikiaPhoneOldTracker(eventToTrack);
						break;
				}
			}
	}
	
	if(typeof console !== 'undefined' && typeof console.log !== 'undefined' && eventToTrack !== baseEvent) console.log('urchinTracker', eventToTrack);
	
};
