$(document).ready(function(){
	MobileAppSkin.initTracking();
});

var MobileAppSkin = {
	uacct: "UA-2871474-1",
	trackingPrefix: '/1_wikiaapp/',
	username: (wgUserName == null) ? 'anon' : 'user',
	
	initTracking: function(){
		MobileAppSkin.trackEvent(MobileAppSkin.username + '/view');
	},
	
	trackEvent: function(eventName) {
		MobileAppSkin.track(MobileAppSkin.trackingPrefix + eventName);
		if(wgPrivateTracker) MobileAppSkin.track(MobileAppSkin.trackingPrefix + wgDB + '/' + eventName);
	},
	
	track: function(str) {
		if(typeof wgEnableGA != "undefined" && wgEnableGA == true) {
			_gaq.push(
				['_setAccount', MobileAppSkin.uacct],
				['_trackPageview', str]
			);
		} else if(typeof urchinTracker !== 'undefined') {
			_uff = 0;
			_uacct = MobileAppSkin.uacct;
			urchinTracker(str);
		}		
	}
};