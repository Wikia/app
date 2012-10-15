// OWA Tracker Min file created 1286236498 

//// Start of json2 //// 

//// End of owa.tracker //// 

///hard-coded///
//<![CDATA[
//OWA.setSetting('debug', true);
// Set base URL
OWA.setSetting('baseUrl', 'https://owa.wikimedia.org/owa/');
//OWA.setApiEndpoint('http://analytics.tesla.usability.wikimedia.org/wiki/d/index.php?action=owa&owa_specialAction');
// Create a tracker
OWATracker = new OWA.tracker();
OWATracker.setEndpoint('https://owa.wikimedia.org/owa/');
OWATracker.setSiteId('d41d8cd98f00b204e9800998ecf8427e');
OWATracker.trackPageView();
OWATracker.trackClicks();
//just track pageviews and clicks for now
//OWATracker.trackDomStream();
//]]>
