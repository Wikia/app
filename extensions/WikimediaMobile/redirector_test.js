/* 
  WikimediaMobile Redirect Tests

  This is a nearly complete test set. As you hit issues, please add UA strings and other combinations that
  may be problematic.

  Written by Hampton Catlin
*/

var navigator;
var document;
var wgAction;
var wgNamespaceNumber;
var wgMainPageTitle;
var wgTitle;
var wgPageTitle;
var wgWikimediaMobileUrl;

var runTests = function() {
  shouldRedirect({});
  testUserAgents();
  testCookies();
  testNamespaces();
  testMainPages();
}


var runTest = function(options, shouldRedirect) {
  wgAction = options.action || "view";
  wgNamespaceNumber = options.namespace_number || 0;
  
  wgMainPageTitle = options.main_page_title || "Wikipédia:Accueil principal"
  wgTitle = options.title || "Tokyo Bay"
  wgPageName = options.page_name || "Tokyo_Bay"
  wgWikimediaMobileUrl = options.mobile_site_url || "http://en.m.wikipedia.org/wiki"

  // Mock a browser
  navigator = {};
  document = {location: {search: "?title=" + wgPageName}};
    
  // Set in browser variables
  navigator.userAgent = options.user_agent || "Mozilla/5.0 (iPhone; U; CPU iPhone OS 2_2 like Mac OS X; en-us) AppleWebKit/525.18.1 (KHTML, like Gecko) Version/3.1.1 Mobile/5G77 Safari/525.20";
  document.cookie = options.cookie || "random=true"

  load("MobileRedirect.js")
  // Run against old redirect
  //load("OriginalMobileRedirect.js");

  if(((document.location != null) && (document.location.length > 0)) == shouldRedirect) {
    if(options.should_redirect_to && (document.location != options.should_redirect_to)) {
      print("Should have been redirected to " + options.should_redirect_to)
      print("Instead was sent to " + document.location)
      for(key in options)
      {
         print("  " + key + ": " + options[key]);
      }
    } else {
      print("OK")
    }
  } else {
    if(shouldRedirect) {
      print("FAILED: SHOULD REDIRECT WITH:");
    } else {
      print("FAILED: SHOULD IGNORE WITH:");
    }
    
    for(key in options)
    {
       print("  " + key + ": " + options[key]);
    }
  }

}

var shouldRedirect = function(options) {
  runTest(options, true)
}

var shouldIgnore = function(options) {
  runTest(options, false)
}

/* ========== ACTUAL TEST CASES ================== */

var testCookies = function() {
  shouldRedirect({cookie: "StewardVoteEligible_r7=0"});
  shouldIgnore({cookie: "stopMobileRedirect=true"})
}

var testNamespaces = function() {
  shouldRedirect({namespace_number: 2})
  shouldRedirect({namespace_number: 0})
  shouldIgnore({namespace_number: -1})
}

var testMainPages = function() {
  shouldRedirect({main_page_title: "", title: "", page_name: ""});
  
  // EN
  shouldRedirect({should_redirect_to: 'http://en.m.wikipedia.org/wiki', main_page_title: 'Main Page', title: 'Main Page', page_name: 'Main_Page'})
  shouldRedirect({should_redirect_to: 'http://en.m.wikipedia.org/wiki/Main_(river)', main_page_title: 'Main Page', title: 'Main (river)', page_name: 'Main_(river)'});

  // FR
  shouldRedirect({should_redirect_to: 'http://fr.m.wikipedia.org/wiki', main_page_title: 'Wikipédia:Accueil principal', title: 'Accueil principal', page_name: 'Wikipédia:Accueil_principal', mobile_site_url: "http://fr.m.wikipedia.org/wiki"});
  shouldRedirect({should_redirect_to: 'http://fr.m.wikipedia.org/wiki/Ralph_Waldo_Emerson', main_page_title: 'Wikipédia:Accueil principal', title: 'Ralph Waldo Emerson', page_name: 'Ralph_Waldo_Emerson', mobile_site_url: "http://fr.m.wikipedia.org/wiki"});

  // DE
  shouldRedirect({should_redirect_to: 'http://de.m.wikipedia.org/wiki', main_page_title: 'Wikipedia:Hauptseite', title: 'Hauptseite', page_name: 'Wikipedia:Hauptseite', mobile_site_url: "http://de.m.wikipedia.org/wiki"});
  shouldRedirect({should_redirect_to: 'http://de.m.wikipedia.org/wiki/Ralph_Waldo_Emerson', main_page_title: 'Wikipedia:Hauptseite', title: 'Ralph Waldo Emerson', page_name: 'Ralph_Waldo_Emerson', mobile_site_url: "http://de.m.wikipedia.org/wiki"});
}

var testUserAgents = function() {
  // iPhone
  shouldRedirect({user_agent: "Mozilla/5.0 (iPhone; U; CPU iPhone OS 2_2 like Mac OS X; en-us) AppleWebKit/525.18.1 (KHTML, like Gecko) Version/3.1.1 Mobile/5G77 Safari/525.20"});
  shouldRedirect({user_agent: "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5"})
  // Android on HTC Desire
  shouldRedirect({user_agent: "Mozilla/5.0 (Linux; U; Android 2.1-update1; de-de; HTC Desire 1.19.161.5 Build/ERE27) AppleWebKit/530.17 (KHTML, like Gecko) Version/4.0 Mobile Safari/530.17"});
  // Nintendo Wii
  shouldRedirect({user_agent: "Opera/9.30 (Nintendo Wii; U; ; 2047-7;pt-br)"});
  // Netfront PDA
  shouldRedirect({user_agent: "Mozilla/5.0 (PDA; NF35WMPRO/1.0; like Gecko) NetFront/3.5"});
  // Palm Pre
  shouldRedirect({user_agent: "Mozilla/5.0 (webOS/1.0; U; en-US) AppleWebKit/525.27.1 (KHTML, like Gecko) Version/1.0 Safari/525.27.1 Pre/1.0"});
  // Safari on Mac OS X
  shouldIgnore({user_agent: "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-us) AppleWebKit/533.19.4 (KHTML, like Gecko) Version/5.0.3 Safari/533.19.4"});
  // Chrome on OS X
  shouldIgnore({user_agent: "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.237 Safari/534.10"});
  // iPad
  shouldIgnore({user_agent: "Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.10"});
  shouldIgnore({user_agent: "Mozilla/5.0 (iPad; U; CPU OS 4_2 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C5101c Safari/6533.18.5"});
  // iPhone 4
  shouldRedirect({user_agent: "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_0 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.05 Mobile/8A293 Safari/6531.22.7"});
  // Firefox
  shouldIgnore({user_agent: "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:2.0b9pre) Gecko/20101228 Firefox/4.0b9pre"});

  // Android Nexus One Phone
  shouldRedirect({user_agent: "Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; Nexus One Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"});
  // Android Tablet
  shouldIgnore({user_agent: "Mozilla/5.0 (Linux; U; Android 2.2.1; en-us; device Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Safari/533.1"});

  shouldIgnore({user_agent: "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; Media Center PC 6.0; InfoPath.3; MS-RTC LM 8; Zune 4.7"});
  shouldIgnore({user_agent: "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0"})

  // Fake test strings

  // Android, but only with Mobile
  shouldIgnore({user_agent: "Android"});
  shouldRedirect({user_agent: "Mozilla/5.0 (Android; Mobile/5G77 Safari/525.20"});
}

runTests();