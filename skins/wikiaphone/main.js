_uacct = "UA-2871474-1";
username = wgUserName == null ? 'anon' : 'user';
urchinTracker('/1_wikiaphone/' + username + '/view');
if(wgPrivateTracker) {
	urchinTracker('/1_wikiaphone/' + wgDB + '/' + username + '/view');
}

document.onclick = function(event){
	//IE doesn't pass in the event object
	event = event || window.event;

	//IE uses srcElement as the target
	var target = event.target || event.srcElement;
	
	switch(target.id){
		case 'searchGoButton':
		case 'mw-searchButton':
			urchinTracker('/1_wikiaphone/anon/click/search');
			break;
		default:
			if(target.nodeName === 'A'){
				if(target.href.indexOf(CategoryNamespaceMessage) !== -1) urchinTracker('/1_wikiaphone/anon/click/categorylink');
				else if(target.href.indexOf(SpecialNamespaceMessage) === -1) urchinTracker('/1_wikiaphone/anon/click/contentlink');
			}
			
			if(target.parentNode){
				switch(target.parentNode.id){
					case 'ca-edit':
						urchinTracker('/1_wikiaphone/anon/click/edit');
						break;
					case 'n-randompage':
						urchinTracker('/1_wikiaphone/anon/click/randompage');
						break;
				}
			}
	}
	
	return false;
};