/*
@test-framework QUnit
*/
module('AdConfig');

test('isHighValueCountry', function() {
  window.wgHighValueCountries = [];
  window.wgHighValueCountries['CA'] = 3;
  window.wgHighValueCountries['DE'] = 3;
  window.wgHighValueCountries['DK'] = 3;
  window.wgHighValueCountries['ES'] = 3;
  window.wgHighValueCountries['FI'] = 3;
  window.wgHighValueCountries['FR'] = 3;
  window.wgHighValueCountries['GB'] = 3;
  window.wgHighValueCountries['IT'] = 3;
  window.wgHighValueCountries['NL'] = 3;
  window.wgHighValueCountries['NO'] = 6;
  window.wgHighValueCountries['SE'] = 3;
  window.wgHighValueCountries['UK'] = 3;
  window.wgHighValueCountries['US'] = 3;
  
	// commented-out tests may pass in production, but not dev
//  ok( AdConfig.isHighValueCountry('AT'), 'AT' );
//  ok( AdConfig.isHighValueCountry('BE'), 'BE' );
  ok( AdConfig.isHighValueCountry('CA'), 'CA' );
//  ok( AdConfig.isHighValueCountry('CH'), 'CH' );
  ok( AdConfig.isHighValueCountry('DE'), 'DE' );
  ok( AdConfig.isHighValueCountry('DK'), 'DK' );
  ok( AdConfig.isHighValueCountry('ES'), 'ES' );
  ok( AdConfig.isHighValueCountry('FI'), 'FI' );
  ok( AdConfig.isHighValueCountry('FR'), 'FR' );
  ok( AdConfig.isHighValueCountry('GB'), 'GB' );
//  ok( AdConfig.isHighValueCountry('GR'), 'GR' );
//  ok( AdConfig.isHighValueCountry('HU'), 'HU' );
  ok( AdConfig.isHighValueCountry('IT'), 'IT' );
  ok( AdConfig.isHighValueCountry('NL'), 'NL' );
  ok( AdConfig.isHighValueCountry('NO'), 'NO' );
//  ok( AdConfig.isHighValueCountry('RU'), 'RU' );
  ok( AdConfig.isHighValueCountry('SE'), 'SE' );
  ok( AdConfig.isHighValueCountry('UK'), 'UK' );
  ok( AdConfig.isHighValueCountry('US'), 'US' );

  ok( !AdConfig.isHighValueCountry('AU'), 'AU' );
  ok( !AdConfig.isHighValueCountry('BR'), 'BR' );
  ok( !AdConfig.isHighValueCountry('JP'), 'JP' );
  ok( !AdConfig.isHighValueCountry('KR'), 'KR' );
  ok( !AdConfig.isHighValueCountry('MX'), 'MX' );
  ok( !AdConfig.isHighValueCountry(''), 'empty string' );
});

test('isHighValueSlot', function() {
  ok( AdConfig.isHighValueSlot('CORP_TOP_LEADERBOARD'), 'CORP_TOP_LEADERBOARD' );
  ok( AdConfig.isHighValueSlot('CORP_TOP_RIGHT_BOXAD'), 'CORP_TOP_RIGHT_BOXAD' );
  ok( AdConfig.isHighValueSlot('EXIT_STITIAL_BOXAD_1'), 'EXIT_STITIAL_BOXAD_1' );
  ok( AdConfig.isHighValueSlot('HOME_TOP_LEADERBOARD'), 'HOME_TOP_LEADERBOARD' );
  ok( AdConfig.isHighValueSlot('HOME_TOP_RIGHT_BOXAD'), 'HOME_TOP_RIGHT_BOXAD' );
  ok( AdConfig.isHighValueSlot('INVISIBLE_MODAL'), 'INVISIBLE_MODAL' );
  ok( AdConfig.isHighValueSlot('MIDDLE_RIGHT_BOXAD'), 'MIDDLE_RIGHT_BOXAD' );
  ok( AdConfig.isHighValueSlot('MODAL_VERTICAL_BANNER'), 'MODAL_VERTICAL_BANNER' );
  ok( AdConfig.isHighValueSlot('TOP_LEADERBOARD'), 'TOP_LEADERBOARD' );
  ok( AdConfig.isHighValueSlot('TOP_RIGHT_BOXAD'), 'TOP_RIGHT_BOXAD' );
  ok( AdConfig.isHighValueSlot('LEFT_SKYSCRAPER_2'), 'LEFT_SKYSCRAPER_2' );
  ok( !AdConfig.isHighValueSlot('PREFOOTER_LEFT_BOXAD'), 'PREFOOTER_LEFT_BOXAD' );
  ok( !AdConfig.isHighValueSlot('PREFOOTER_RIGHT_BOXAD'), 'PREFOOTER_RIGHT_BOXAD' );
  ok( !AdConfig.isHighValueSlot('INVISIBLE_2'), 'INVISIBLE_2' );
});

test('cookie', function() {
  var testCookieName = 'foobar';
  var testCookieValue = 'baz';
  AdConfig.cookie(testCookieName, testCookieValue);
  equal( AdConfig.cookie(testCookieName), testCookieValue, 'cookie has string' );
  AdConfig.cookie(testCookieName, null);
  ok( !AdConfig.cookie(testCookieName), 'cookie not set' );
});

test('pullGeo', function() {
  AdConfig.geo = null;

  AdConfig.cookie('Geo', '{"city":"San Francisco","country":"US","continent":"NA"}');
  AdConfig.pullGeo();
  equal( AdConfig.geo.continent, 'NA', 'continent: NA' );
  equal( AdConfig.geo.country, 'US', 'country: US' );

  AdConfig.geo = null;
  AdConfig.cookie('Geo', '{"city":"Brisbane","country":"AU","continent":"OC"}');
  AdConfig.pullGeo();
  equal( AdConfig.geo.continent, 'OC', 'continent: OC' );
  equal( AdConfig.geo.country, 'AU', 'country: AU' );

  AdConfig.geo = null;
  AdConfig.cookie('Geo', null); 
});

module('AdConfig.DART');

test('getSubdomain', function() {
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"DE","continent":"EU"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'DE' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"ZA","continent":"AF"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'ZA' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"AE","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'AE' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"CY","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'CY' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"BH","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'BH' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"IL","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'IL' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"IQ","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'IQ' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"IR","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'IR' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"JO","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'JO' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"KW","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'KW' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"LB","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'LB' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"OM","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'OM' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"PS","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'PS' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"QA","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'QA' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"SA","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'SA' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"SY","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'SY' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"TR","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'TR' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"YE","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-emea', 'YE' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"IN","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-apac', 'IN' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"JP","continent":"AS"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-apac', 'JP' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"AU","continent":"OC"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad-apac', 'AU' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"US","continent":"NA"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad', 'US' );
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"AR","continent":"SA"}'); AdConfig.pullGeo();
  equal( AdConfig.DART.getSubdomain(), 'ad', 'AR' );
  
  AdConfig.geo = null;
  AdConfig.cookie('Geo', null); 
});

test('getAdType', function() {
  equal( AdConfig.DART.getAdType(true), 'adi', 'iframe' );
  equal( AdConfig.DART.getAdType(false), 'adj', 'Javascript' );
});

test('initSiteAndZones', function() {
  AdConfig.DART.site = AdConfig.DART.zone1 = AdConfig.DART.zone2 = null;
  window.cityShort = 'ent';
  window.wgDB = 'muppet';
  window.adLogicPageType = 'home';
  AdConfig.DART.initSiteAndZones();
  equal( AdConfig.DART.site, 'wka.ent', 'Muppet:home, site' );
  equal( AdConfig.DART.zone1, '_muppet', 'Muppet:home, zone1' );
  equal( AdConfig.DART.zone2, 'home', 'Muppet:home, zone2' );
  AdConfig.DART.site = AdConfig.DART.zone1 = AdConfig.DART.zone2 = null;
  window.cityShort = 'gaming';
  window.wgDB = 'fallout';
  window.adLogicPageType = 'article';
  AdConfig.DART.initSiteAndZones();
  equal( AdConfig.DART.site, 'wka.gaming', 'Fallout:article, site' );
  equal( AdConfig.DART.zone1, '_fallout', 'Fallout:article, zone1' );
  equal( AdConfig.DART.zone2, 'article', 'Fallout:article, zone2' );
  AdConfig.DART.site = AdConfig.DART.zone1 = AdConfig.DART.zone2 = null;
  window.cityShort = 'wikia';
  window.wgDB = 'wikiaglobal';
  window.adLogicPageType = 'article';
  window.wgPageName = 'PC_games';
  window.wgHubsPages = {"fanfiction": {"name": "fanfic", "site": "ent"}, "handheld_games": {"name": "handheld", "site": "gaming"}, "pc_games": {"name": "pc", "site": "gaming"}, "xbox_360_games": {"name": "xbox360", "site": "gaming"}, "ps3_games": {"name": "ps3", "site": "gaming"}, "recipes": {"name": "recipes", "site": "life"}, "mobile_games": {"name": "mobile", "site": "gaming"}, "movie": {"name": "movie", "site": "ent"}, "tv": {"name": "tv", "site": "ent"}, "entertainment": {"name": "entertainment", "site": "ent"}, "music": {"name": "music", "site": "ent"}, "animation": {"name": "anime", "site": "ent"}, "anime": {"name": "anime", "site": "ent"}, "sci-fi": {"name": "sci_fi", "site": "ent"}, "horror": {"name": "horror", "site": "ent"}, "gaming": {"name": "gaming", "site": "gaming"}, "casual_games": {"name": "casual", "site": "gaming"}, "casual": {"name": "casual", "site": "gaming"}, "lifestyle": {"name": "lifestyle", "site": "life"}, "wii_games": {"name": "wii", "site": "gaming"}, "e3": {"name": "e3", "site": "gaming"}, "oscar": {"name": "oscar", "site": "ent"}, "square_enix_games": {"name": "squareenix", "site": "gaming"}, "pl": {"name": "pl", "langcode": "pl"}};
  AdConfig.DART.initSiteAndZones();
  equal( AdConfig.DART.site, 'wka.gaming', 'Hub:PC Games', 'site' );
  equal( AdConfig.DART.zone1, '_pc', 'Hub:PC Games', 'zone1' );
  equal( AdConfig.DART.zone2, 'hub', 'Hub:PC Games', 'zone2' );
  AdConfig.DART.site = AdConfig.DART.zone1 = AdConfig.DART.zone2 = null;
});

test('isHub', function() {
  window.wgDB = 'wikiaglobal';
  window.wgHubsPages = {"fanfiction": {"name": "fanfic", "site": "ent"}, "handheld_games": {"name": "handheld", "site": "gaming"}, "pc_games": {"name": "pc", "site": "gaming"}, "xbox_360_games": {"name": "xbox360", "site": "gaming"}, "ps3_games": {"name": "ps3", "site": "gaming"}, "recipes": {"name": "recipes", "site": "life"}, "mobile_games": {"name": "mobile", "site": "gaming"}, "movie": {"name": "movie", "site": "ent"}, "tv": {"name": "tv", "site": "ent"}, "entertainment": {"name": "entertainment", "site": "ent"}, "music": {"name": "music", "site": "ent"}, "animation": {"name": "anime", "site": "ent"}, "anime": {"name": "anime", "site": "ent"}, "sci-fi": {"name": "sci_fi", "site": "ent"}, "horror": {"name": "horror", "site": "ent"}, "gaming": {"name": "gaming", "site": "gaming"}, "casual_games": {"name": "casual", "site": "gaming"}, "casual": {"name": "casual", "site": "gaming"}, "lifestyle": {"name": "lifestyle", "site": "life"}, "wii_games": {"name": "wii", "site": "gaming"}, "e3": {"name": "e3", "site": "gaming"}, "oscar": {"name": "oscar", "site": "ent"}, "square_enix_games": {"name": "squareenix", "site": "gaming"}, "pl": {"name": "pl", "langcode": "pl"}};
  window.wgPageName = 'Fanfiction';
  ok( AdConfig.DART.isHub(), 'Fan Fiction' );
  window.wgPageName = 'Handheld_games';
  ok( AdConfig.DART.isHub(), 'Handheld Games' );
  window.wgPageName = 'PC_games';
  ok( AdConfig.DART.isHub(), 'PC Games' );
  window.wgPageName = 'Xbox_360_games';
  ok( AdConfig.DART.isHub(), 'Xbox 360 Games' );
  window.wgPageName = 'PS3_games';
  ok( AdConfig.DART.isHub(), 'PS3 Games' );
  window.wgPageName = 'Recipes';
  ok( AdConfig.DART.isHub(), 'Recipes' );
  window.wgPageName = 'Mobile_games';
  ok( AdConfig.DART.isHub(), 'Mobile Games' );
  window.wgPageName = 'Movie';
  ok( AdConfig.DART.isHub(), 'Movie' );
  window.wgPageName = 'TV';
  ok( AdConfig.DART.isHub(), 'TV' );
  window.wgPageName = 'Entertainment';
  ok( AdConfig.DART.isHub(), 'Entertainment' );
  window.wgPageName = 'Music';
  ok( AdConfig.DART.isHub(), 'Music' );
  window.wgPageName = 'Animation';
  ok( AdConfig.DART.isHub(), 'Animation' );
  window.wgPageName = 'Anime';
  ok( AdConfig.DART.isHub(), 'Anime' );
  window.wgPageName = 'Sci-Fi';
  ok( AdConfig.DART.isHub(), 'Sci-Fi' );
  window.wgPageName = 'Horror';
  ok( AdConfig.DART.isHub(), 'Horror' );
  window.wgPageName = 'Gaming';
  ok( AdConfig.DART.isHub(), 'Gaming' );
  window.wgPageName = 'Casual_games';
  ok( AdConfig.DART.isHub(), 'Casual Games' );
  window.wgPageName = 'Casual';
  ok( AdConfig.DART.isHub(), 'Casual' );
  window.wgPageName = 'Lifestyle';
  ok( AdConfig.DART.isHub(), 'Lifestyle' );
  window.wgPageName = 'Wii_games';
  ok( AdConfig.DART.isHub(), 'Wii Games' );
  window.wgPageName = 'E3';
  ok( AdConfig.DART.isHub(), 'E3' );
  window.wgPageName = 'Oscar';
  ok( AdConfig.DART.isHub(), 'Oscar' );
  window.wgPageName = 'Square_enix_games';
  ok( AdConfig.DART.isHub(), 'Square Enix Games' );
  window.wgPageName = 'Foobar'
  ok( !AdConfig.DART.isHub(), 'Page: Foobar' );
  window.wgPageName = 'Movie';
  window.wgHubsPages = null;
  ok (!AdConfig.DART.isHub(), 'no wgHubsPages' );
  window.wgDB = 'muppet';
  ok( !AdConfig.DART.isHub(), 'Wiki: Muppet' );
  window.wgDB = null;
  window.wgPageName = null;
});

test('getSite', function() {
  equal( AdConfig.DART.getSite('gaming'), 'wka.gaming', 'gaming' );
  equal( AdConfig.DART.getSite('life'), 'wka.life', 'life' );
});

test('getZone1', function() {
  equal( AdConfig.DART.getZone1('fallout'), '_fallout', 'fallout' );
  equal( AdConfig.DART.getZone1('wikiaglobal'), '_wikiaglobal', 'wikiaglobal' );
  equal( AdConfig.DART.getZone1(''), '_wikia', 'no DB' );
});

test('getZone2', function() {
  equal( AdConfig.DART.getZone2('article'), 'article', 'article' );
  equal( AdConfig.DART.getZone2('home'), 'home', 'home' );
  equal( AdConfig.DART.getZone2('search'), 'search', 'search' );
  equal( AdConfig.DART.getZone2(null), 'article', 'null' );
});

test('getCustomKeyValues', function() {
  window.wgDartCustomKeyValues = "age=adult;age=yadult;egnre=comedy;egnre=comic;egnre=family;media=movie;media=tv;mom=mom;women=women-mom";
  equal( AdConfig.DART.getCustomKeyValues(), window.wgDartCustomKeyValues+';', 'custom key-values set' );
  window.wgDartCustomKeyValues = null;
  equal( AdConfig.DART.getCustomKeyValues(), '', 'custom key-values not set');
});

test('getArticleKV', function() {
  window.wgArticleId = '1002';
  equal( AdConfig.DART.getArticleKV(), 'artid='+window.wgArticleId+';', 'article id set' );
  window.wgArticleId = null;
  equal( AdConfig.DART.getArticleKV(), '', 'article id not set' );
});

test('getDomainKV', function() {
  equal( AdConfig.DART.getDomainKV('fallout.wikia.com'), 'dmn=wikiacom;', 'fallout.wikia.com' );
  equal( AdConfig.DART.getDomainKV('www.wikia.com'), 'dmn=wikiacom;', 'www.wikia.com' );
  equal( AdConfig.DART.getDomainKV('www.wowwiki.com'), 'dmn=wowwikicom;', 'www.wowwiki.com' );
  equal( AdConfig.DART.getDomainKV('wowwiki.com'), 'dmn=wowwikicom;', 'wowwiki.com' );
  equal( AdConfig.DART.getDomainKV('www.bbc.co.uk'), 'dmn=bbccouk;', 'www.bbc.co.uk' );
});

test('getHostnamePrefix', function() {
  equal( AdConfig.DART.getHostnamePrefix('fallout.wikia.com'), 'hostpre=fallout;', 'fallout.wikia.com' );
  equal( AdConfig.DART.getHostnamePrefix('externaltest.fallout.wikia.com'), 'hostpre=externaltest;', 'externaltest.fallout.wikia.com' );
});

test('getTitle', function() {
  window.wgPageName = 'Muppet_Wiki';
  equal( AdConfig.DART.getTitle(), 'wpage='+encodeURIComponent(window.wgPageName)+';', window.wgPageName );
  window.wgPageName = "Assassin's_Creed_Wiki";
  equal( AdConfig.DART.getTitle(), 'wpage='+encodeURIComponent(window.wgPageName)+';', window.wgPageName );
  window.wgPageName = 'Военная_база_Марипоза';
  equal( AdConfig.DART.getTitle(), 'wpage='+encodeURIComponent(window.wgPageName)+';', window.wgPageName );
  window.wgPageName = null;
  equal( AdConfig.DART.getTitle(), '', 'null' );
});

test('getLanguage', function() {
  window.wgContentLanguage = 'en';
  equal( AdConfig.DART.getLanguage(), 'lang=en;', window.wgContentLanguage );
  window.wgContentLanguage = 'ru';
  equal( AdConfig.DART.getLanguage(), 'lang=ru;', window.wgContentLanguage );
  window.wgContentLanguage = null;
  equal( AdConfig.DART.getLanguage(), 'lang=unknown;', window.wgContentLanguage );
});

// TODO: getResolution

// TODO: getPrefooterStatus

// TODO: getImpressionCount

test('getPartnerKeywords', function() {
  window.partnerKeywords = 'Hot Wheels Dodge Concept Car';
  equal( AdConfig.DART.getPartnerKeywords(), 'pkw='+encodeURIComponent(window.partnerKeywords)+';', window.partnerKeywords );
  window.partnerKeywords = null;
  equal( AdConfig.DART.getPartnerKeywords(), '', 'null' );
});

test('getCategories', function() {
  window.wgCategories = ['All Businesses', 'Businesses in GTA III', 'Businesses in GTA Liberty City Stories', 'Food'];
  AdConfig.DART.initCategories();
  var expectedResult = '';
  for (var i=0; i < window.wgCategories.length; i++) {
  	expectedResult += 'cat='+encodeURIComponent(window.wgCategories[i].toLowerCase().replace(/ /g, '_'))+';';
  }
  equal( AdConfig.DART.getCategories(), expectedResult, window.wgCategories);

  window.wgCategories = ['All Businesses', 'Businesses in GTA III', 'Businesses in GTA Liberty City Stories', 'Food', 'blahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblablahblahblahblahblahblahblahblahhhhhhhhhhhhhhhhhhhhhhhhhhhh'];
  AdConfig.DART.initCategories();
  var actualResult = AdConfig.DART.getCategories();
  window.wgCategories = ['All Businesses', 'Businesses in GTA III', 'Businesses in GTA Liberty City Stories', 'Food'];
  var expectedResult = '';
  for (var i=0; i < window.wgCategories.length; i++) {
  	expectedResult += 'cat='+encodeURIComponent(window.wgCategories[i].toLowerCase().replace(/ /g, '_'))+';';
  }
  equal( actualResult, expectedResult, 'over character limit');

  window.wgCategories = null;
  AdConfig.DART.initCategories();
  equal( AdConfig.DART.getCategories(), '', 'null' );
});

test('getLocKV', function() {
  equal( AdConfig.DART.getLocKV('CORP_TOP_LEADERBOARD'), 'loc=top;', 'CORP_TOP_LEADERBOARD' );
  equal( AdConfig.DART.getLocKV('CORP_TOP_RIGHT_BOXAD'), 'loc=top;', 'CORP_TOP_RIGHT_BOXAD' );
  equal( AdConfig.DART.getLocKV('EXIT_STITIAL_BOXAD_1'), 'loc=exit;', 'EXIT_STITIAL_BOXAD_1' );
  equal( AdConfig.DART.getLocKV('HOME_INVISIBLE_TOP'), 'loc=invisible;', 'HOME_INVISIBLE_TOP' );
  equal( AdConfig.DART.getLocKV('HOME_TOP_LEADERBOARD'), 'loc=top;', 'HOME_TOP_LEADERBOARD' );
  equal( AdConfig.DART.getLocKV('HOME_TOP_RIGHT_BOXAD'), 'loc=top;', 'HOME_TOP_RIGHT_BOXAD' );
  equal( AdConfig.DART.getLocKV('INVISIBLE_1'), 'loc=invisible;', 'INVISIBLE_1' );
  equal( AdConfig.DART.getLocKV('INVISIBLE_2'), 'loc=invisible;', 'INVISIBLE_2' );
  equal( AdConfig.DART.getLocKV('INVISIBLE_MODAL'), 'loc=modal;', 'INVISIBLE_MODAL' );
  equal( AdConfig.DART.getLocKV('LEFT_SKYSCRAPER_2'), 'loc=middle;', 'LEFT_SKYSCRAPER_2' );
  equal( AdConfig.DART.getLocKV('LEFT_SKYSCRAPER_3'), 'loc=footer;', 'LEFT_SKYSCRAPER_3' );
  equal( AdConfig.DART.getLocKV('MIDDLE_RIGHT_BOXAD'), 'loc=middle;', 'MIDDLE_RIGHT_BOXAD' );
  equal( AdConfig.DART.getLocKV('MODAL_VERTICAL_BANNER'), 'loc=modal;', 'MODAL_VERTICAL_BANNER' );
  equal( AdConfig.DART.getLocKV('PREFOOTER_LEFT_BOXAD'), 'loc=footer;', 'PREFOOTER_LEFT_BOXAD' );
  equal( AdConfig.DART.getLocKV('PREFOOTER_RIGHT_BOXAD'), 'loc=footer;', 'PREFOOTER_RIGHT_BOXAD' );
  equal( AdConfig.DART.getLocKV('TOP_LEADERBOARD'), 'loc=top;', 'TOP_LEADERBOARD' );
  equal( AdConfig.DART.getLocKV('TOP_RIGHT_BOXAD'), 'loc=top;', 'TOP_RIGHT_BOXAD' );
  equal( AdConfig.DART.getLocKV('FOOBAR'), '', 'non-existent slot' );
});

test('getDcoptKV', function() {
  window.wgUserName = null;
  equal( AdConfig.DART.getDcoptKV('CORP_TOP_LEADERBOARD'), 'dcopt=ist;', 'CORP_TOP_LEADERBOARD' );
  equal( AdConfig.DART.getDcoptKV('CORP_TOP_RIGHT_BOXAD'), '', 'CORP_TOP_RIGHT_BOXAD' );
  equal( AdConfig.DART.getDcoptKV('EXIT_STITIAL_BOXAD_1'), '', 'EXIT_STITIAL_BOXAD_1' );
  equal( AdConfig.DART.getDcoptKV('HOME_INVISIBLE_TOP'), '', 'HOME_INVISIBLE_TOP' );
  equal( AdConfig.DART.getDcoptKV('HOME_TOP_LEADERBOARD'), 'dcopt=ist;', 'HOME_TOP_LEADERBOARD' );
  equal( AdConfig.DART.getDcoptKV('HOME_TOP_RIGHT_BOXAD'), '', 'HOME_TOP_RIGHT_BOXAD' );
  equal( AdConfig.DART.getDcoptKV('INVISIBLE_1'), '', 'INVISIBLE_1' );
  equal( AdConfig.DART.getDcoptKV('INVISIBLE_2'), '', 'INVISIBLE_2' );
  equal( AdConfig.DART.getDcoptKV('INVISIBLE_MODAL'), '', 'INVISIBLE_MODAL' );
  equal( AdConfig.DART.getDcoptKV('LEFT_SKYSCRAPER_2'), '', 'LEFT_SKYSCRAPER_2' );
  equal( AdConfig.DART.getDcoptKV('LEFT_SKYSCRAPER_3'), '', 'LEFT_SKYSCRAPER_3' );
  equal( AdConfig.DART.getDcoptKV('MIDDLE_RIGHT_BOXAD'), '', 'MIDDLE_RIGHT_BOXAD' );
  equal( AdConfig.DART.getDcoptKV('MODAL_VERTICAL_BANNER'), '', 'MODAL_VERTICAL_BANNER' );
  equal( AdConfig.DART.getDcoptKV('PREFOOTER_LEFT_BOXAD'), '', 'PREFOOTER_LEFT_BOXAD' );
  equal( AdConfig.DART.getDcoptKV('PREFOOTER_RIGHT_BOXAD'), '', 'PREFOOTER_RIGHT_BOXAD' );
  equal( AdConfig.DART.getDcoptKV('TOP_LEADERBOARD'), 'dcopt=ist;', 'TOP_LEADERBOARD' );
  equal( AdConfig.DART.getDcoptKV('TOP_RIGHT_BOXAD'), '', 'TOP_RIGHT_BOXAD' );
  equal( AdConfig.DART.getDcoptKV('FOOBAR'), '', 'non-existent slot' );
  window.wgUserName = 'foobar';
  window.wgUserShowAds = false;
  equal( AdConfig.DART.getDcoptKV('TOP_LEADERBOARD'), '', 'user logged in, no ads' );
  window.wgUserShowAds = true;
  equal( AdConfig.DART.getDcoptKV('TOP_LEADERBOARD'), 'dcopt=ist;', 'user logged in, show ads' );
  window.wgUserName = null;
  window.wgUserShowAds = null;
});

test('getTileKV', function() {
  AdConfig.DART.tile = 1;
  var adProvider = 'AdDriver';
  equal( AdConfig.DART.getTileKV('TOP_LEADERBOARD', adProvider), 'tile=1;', 'AdDriver, tile 1');
  equal( AdConfig.DART.getTileKV('PREFOOTER_LEFT_BOXAD', adProvider), 'tile=2;', 'AdDriver, tile 2');
  equal( AdConfig.DART.getTileKV('PREFOOTER_RIGHT_BOXAD', adProvider), 'tile=3;', 'AdDriver, tile 3');
  equal( AdConfig.DART.getTileKV('TOP_RIGHT_BOXAD', adProvider), 'tile=4;', 'AdDriver, tile 4');
  equal( AdConfig.DART.getTileKV('LEFT_SKYSCRAPER_2', adProvider), 'tile=5;', 'AdDriver, tile 5');
  equal( AdConfig.DART.getTileKV('EXIT_STITIAL_BOXAD_1', adProvider), 'tile=6;', 'AdDriver, tile 6');
  var adProvider = 'Liftium';
  equal( AdConfig.DART.getTileKV('HOME_TOP_LEADERBOARD', adProvider), 'tile=2;', 'Liftium, HOME_TOP_LEADERBOARD');
  equal( AdConfig.DART.getTileKV('HOME_TOP_RIGHT_BOXAD', adProvider), 'tile=1;', 'Liftium, HOME_TOP_RIGHT_BOXAD');
});

test('getUrl', function() {
  window.wgAdDriverCookieLifetime=1;
  window.wgNow = new Date();

  AdConfig.DART.tile = 1;
  AdConfig.DART.site = AdConfig.DART.zone1 = AdConfig.DART.zone2 = null;
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"US","continent":"NA"}'); AdConfig.pullGeo();
  window.cityShort = 'ent';
  window.wgDB = 'muppet';
  window.adLogicPageType = 'article';
  window.wgArticleId = 37414;
  window.wgPageName = 'Adriana_Karembeu';
  window.wgTitle = 'Adriana Karembeu';
  window.wgContentLanguage = 'en';
  window.wgDartCustomKeyValues="age=adult;age=yadult;egnre=comedy;egnre=comic;egnre=family;media=movie;media=tv;mom=mom;women=women-mom";
  window.partnerKeywords = null;
  window.wgCategories = ['All Businesses', 'Businesses in GTA III', 'Businesses in GTA Liberty City Stories', 'Food'];
  window.wgUserName = null;
  var expectedResult = 'http://ad.doubleclick.net/adj/wka.ent/_muppet/article;s0=ent;s1=_muppet;s2=article;'
  + window.wgDartCustomKeyValues
  + ';artid=37414;'
  + AdConfig.DART.getDomainKV(window.location.hostname)
  + AdConfig.DART.getHostnamePrefix(window.location.hostname)
  + 'pos=TOP_LEADERBOARD;wpage='
  + encodeURIComponent(window.wgPageName)
  + ';lang=en;'
  + AdConfig.DART.getResolution() + AdConfig.DART.getPrefooterStatus()
  + AdConfig.DART.getImpressionCount('TOP_LEADERBOARD') + AdConfig.DART.getCategories()
  + 'loc=top;dcopt=ist;src=driver;sz=728x90,468x60,980x130,980x65;mtfInline=true;tile=1;endtag=$;ord='+AdConfig.DART.ord+'?';
  equal( AdConfig.DART.getUrl('TOP_LEADERBOARD', '728x90', false, 'AdDriver'), expectedResult, 'AdDriver, TOP_LEADERBOARD' );

  AdConfig.DART.tile = 1;
  AdConfig.DART.site = AdConfig.DART.zone1 = AdConfig.DART.zone2 = null;
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"LB","continent":"AS"}'); AdConfig.pullGeo();
  window.cityShort = 'life';
  window.wgDB = 'healthyrecipes';
  window.adLogicPageType = 'home';
  window.wgArticleId = 1461;
  window.wgPageName = 'Healthy_Recipes_Wiki';
  window.wgTitle = 'Healthy Recipes Wiki';
  window.wgContentLanguage = 'en';
  window.wgDartCustomKeyValues = null;
  window.partnerKeywords = null;
  window.wgCategories = null;
  AdConfig.DART.initCategories();
  window.wgUserName = null;
  var expectedResult = 'http://ad-emea.doubleclick.net/adi/wka.life/_healthyrecipes/home;s0=life;s1=_healthyrecipes;s2=home;'
  + 'artid=1461;'
  + AdConfig.DART.getDomainKV(window.location.hostname)
  + AdConfig.DART.getHostnamePrefix(window.location.hostname)
  + 'pos=HOME_TOP_RIGHT_BOXAD;wpage='
  + encodeURIComponent(window.wgPageName)
  + ';lang=en;'
  + AdConfig.DART.getResolution() + AdConfig.DART.getPrefooterStatus()
  + AdConfig.DART.getImpressionCount('HOME_TOP_RIGHT_BOXAD')
  + 'loc=top;mtfIFPath=/extensions/wikia/AdEngine/;src=liftium;sz=300x250,300x600;mtfInline=true;tile=1;endtag=$;ord='+AdConfig.DART.ord+'?';
  equal( AdConfig.DART.getUrl('HOME_TOP_RIGHT_BOXAD', '300x250', true, 'Liftium'), expectedResult, 'Liftium, HOME_TOP_RIGHT_BOXAD' );

  AdConfig.DART.tile = 1;
  AdConfig.DART.site = AdConfig.DART.zone1 = AdConfig.DART.zone2 = null;
  AdConfig.geo = null; AdConfig.cookie('Geo', '{"country":"AU","continent":"OC"}'); AdConfig.pullGeo();
  window.cityShort = 'gaming';
  window.wgDB = 'wowwiki';
  window.adLogicPageType = 'article';
  window.wgArticleId = 119514;
  window.wgPageName = 'Drenna_Riverwind';
  window.wgTitle = 'Drenna Riverwind';
  window.wgContentLanguage = 'en';
  window.wgDartCustomKeyValues = "age=13-17;age=18-34;eth=cauc;kids=0-2;hhi=0-30;hhi=30-60;edu=college;age=teen;age=yadult;esrb=teen;gnre=mmo;gnre=rpg;pform=pc;sex=m;volum=l;pub=blizzard;dev=blizzard;sub=wizards;sub=orcs;sub=elves;egnre=fantasy;aff=tech;aff=hardware";
  window.partnerKeywords = null;
  window.wgCategories = null;
  AdConfig.DART.initCategories();
  window.wgUserName = null;
  var expectedResult = 'http://ad-apac.doubleclick.net/adi/wka.gaming/_wowwiki/article;s0=gaming;s1=_wowwiki;s2=article;'
  + window.wgDartCustomKeyValues
  + ';artid=119514;'
  + AdConfig.DART.getDomainKV(window.location.hostname)
  + AdConfig.DART.getHostnamePrefix(window.location.hostname)
  + 'pos=LEFT_SKYSCRAPER_2;wpage='
  + encodeURIComponent(window.wgPageName)
  + ';lang=en;'
  + AdConfig.DART.getResolution() + AdConfig.DART.getPrefooterStatus()
  + AdConfig.DART.getImpressionCount('LEFT_SKYSCRAPER_2')
  + 'loc=middle;mtfIFPath=/extensions/wikia/AdEngine/;src=direct;sz=160x600,120x600;mtfInline=true;tile=3;endtag=$;ord='+AdConfig.DART.ord+'?';
  equal( AdConfig.DART.getUrl('LEFT_SKYSCRAPER_2', '160x600', true, 'DART'), expectedResult, 'DART, LEFT_SKYSCRAPER_2' );
});
