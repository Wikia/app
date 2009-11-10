_uacct = "UA-2871474-1";
username = wgUserName == null ? 'anon' : 'user';
urchinTracker('/1_wikiaphone/' + username + '/view');
if(wgPrivateTracker) {
	urchinTracker('/1_wikiaphone/' + wgDB + '/' + username + '/view');
}