<?php
namespace Wikia\Search\Test\Services;

use Wikia\Search\Services\WikiSeriesEntitySearchService;

class WikiSeriesEntitySearchServiceTest extends SearchServiceBaseTest {

	/**
	 * @test
	 * @dataProvider testsProvider
	 */
	public function shouldReturnCorrectFormat(
		callable $paramsFunction,
		$expectedOutput,
		$request = null,
		$response = null
	) {
		$service = new WikiSeriesEntitySearchService( $this->useSolariumMock( $request, $response ) );
		$res = $paramsFunction( $service );
		$this->assertEquals( $expectedOutput, $res );
	}

	public function testsProvider() {
		return [
			[ function ( WikiSeriesEntitySearchService &$svc ) {
				return $svc->setLang( 'en' )->query( 'Big Bang Theory' );
			},
				[ [ 'id' => 4828 ] ], $this->getBaseRequest(), $this->getMockResponse() ],
		];
	}

	/**
	 * Sets solr response body
	 * @return string Solr response body
	 */
	protected function getMockResponse() {
		return '{"responseHeader":{"status":0,"QTime":3,"params":{"pf":"series_mv_tm^15 sitename_txt^2 all_domains_mv_wd^5","fl":"*,score","start":"0","q":"+(\"big bang theory\") AND +(lang_s:en)","bf":"wam_i^4","qf":"series_mv_tm^15 description_txt categories_txt top_categories_txt top_articles_txt sitename_txt^2 all_domains_mv_wd^5","qs":"1","wt":"json","fq":["-(hostname_s:*fanon.wikia.com) AND -(hostname_s:*answers.wikia.com)","articles_i:[20 TO *]"],"ps":"1","defType":"edismax","rows":"1"}},"response":{"numFound":12,"start":0,"maxScore":7.870552,"docs":[{"promoted_b":false,"hub_s":"Entertainment","articles_i":769,"description_txt":["The Big Bang Theory Wiki is a site for fans of the popular CBS television series The Big Bang Theory. Here you will find plenty of information on the episodes, characters, cast, crew, and much more."],"hot_b":false,"wam_i":96,"hostname_s":"bigbangtheory.wikia.com","categories_mv_en":["The Big Bang Theory","Fair use images","Articles With Photos","Pictures of Jim Parsons","Pictures of Johnny Galecki","Episodes","Videos","Characters","Pictures of Kaley Cuoco","Reference Materials","Pictures of Kunal Nayyar","Trivial","Pictures of Simon Helberg","Pictures of Mayim Bialik","Vanity cards","Male Characters","Blog posts","Site Images","Female Characters","Cast","Pictures of Melissa Rauch","Minor Characters","Leonard-Penny Together","Future episodes","Wiki Subjects","Reference Pictures","Stub","Sheldon","Actor","Candidates for deletion","Guest Appearances","Articles Without Photos","Utility templates","Articles With Videos","Watercooler","Featured Article","Leonard","Season 3","Featured Images","User Images","Mentioned-only Characters","Public domain images","Season 4","Games","Howard","Recurring Characters","Season 7","Season 2","Main Characters","The Cheesecake Factory"],"id":"4828","admins_i":5,"top_categories_mv_en":["The Big Bang Theory","Fair use images","Articles With Photos","Pictures of Jim Parsons","Pictures of Johnny Galecki","Episodes","Videos","Characters","Pictures of Kaley Cuoco","Reference Materials","Pictures of Kunal Nayyar","Trivial","Pictures of Simon Helberg","Pictures of Mayim Bialik","Vanity cards","Male Characters","Blog posts","Site Images","Female Characters","Cast"],"pages_i":42582,"images_i":6119,"top_categories_txt":["The Big Bang Theory","Fair use images","Articles With Photos","Pictures of Jim Parsons","Pictures of Johnny Galecki","Episodes","Videos","Characters","Pictures of Kaley Cuoco","Reference Materials","Pictures of Kunal Nayyar","Trivial","Pictures of Simon Helberg","Pictures of Mayim Bialik","Vanity cards","Male Characters","Blog posts","Site Images","Female Characters","Cast"],"created_dt":"2007-12-14T06:05:16Z","categories_txt":["The Big Bang Theory","Fair use images","Articles With Photos","Pictures of Jim Parsons","Pictures of Johnny Galecki","Episodes","Videos","Characters","Pictures of Kaley Cuoco","Reference Materials","Pictures of Kunal Nayyar","Trivial","Pictures of Simon Helberg","Pictures of Mayim Bialik","Vanity cards","Male Characters","Blog posts","Site Images","Female Characters","Cast","Pictures of Melissa Rauch","Minor Characters","Leonard-Penny Together","Future episodes","Wiki Subjects","Reference Pictures","Stub","Sheldon","Actor","Candidates for deletion","Guest Appearances","Articles Without Photos","Utility templates","Articles With Videos","Watercooler","Featured Article","Leonard","Season 3","Featured Images","User Images","Mentioned-only Characters","Public domain images","Season 4","Games","Howard","Recurring Characters","Season 7","Season 2","Main Characters","The Cheesecake Factory"],"videos_i":201,"edits_i":122456,"touched_dt":"2014-08-18T13:05:29Z","tasks_i":16884,"official_b":false,"activeusers_i":73,"description_en":"The Big Bang Theory Wiki is a site for fans of the popular CBS television series The Big Bang Theory. Here you will find plenty of information on the episodes, characters, cast, crew, and much more.","headline_txt":["The Big Bang Theory Wiki"],"dbname_s":"bigbangtheory","hostname_txt":["bigbangtheory.wikia.com"],"views_monthly_i":1973088,"image_s":"Wikia-Visualization-Main,bigbangtheory.png","views_weekly_i":0,"sitename_txt":["The Big Bang Theory Wiki"],"url":"http://bigbangtheory.wikia.com/","lang_s":"en","jobs_i":0,"users_i":23526112,"new_b":false,"domains_txt":["big-bang.wikia.com","bigbang.wikia.com","bigbangtheory.wikia.com","tbbt.wikia.com","thebigbangtheory.wikia.com","www.bigbangtheory.wikia.com","www.tbbt.wikia.com","www.thebigbangtheory.wikia.com"],"indexed":"2014-08-19T04:26:28.422Z","commercial_use_allowed_b":true,"series_mv_en":["The Big Bang Theory"],"series_txt":["The Big Bang Theory"],"wiki_pagetitle_txt":["The Big Bang Theory Wiki"],"top_articles_mv_en":["Season 8","Sheldon Cooper","The Locomotion Interruption","Bernadette Rostenkowski-Wolowitz","Penny","Mrs. Debbie Wolowitz","Soft Kitty","Amy Farrah Fowler","Season 7","Episode 8.02","Professor Proton","Rajesh Koothrappali","Sheldon and Amy","Leonard Hofstadter","Emily (season 7)","Howard Wolowitz","Kaley Cuoco-Sweeting","List of The Big Bang Theory episodes","Leonard and Penny","Melissa Rauch","Howard\'s Father","The Status Quo Combustion","Carol Ann Susi","Barry Kripke","Alex Jensen","Priya Koothrappali","Lucy","Missy Cooper","The Tenure Turbulence","Apartment 4A","Zack Johnson","Mary Cooper","Mayim Bialik","Unaired Pilot","Bazinga","Wil Wheaton","The apartment building","The Roommate Agreement","Stephen Hawking","Stuart Bloom","Guest Appearances","Characters","Cast & Crew","Leslie Winkle","73","Beverly Hofstadter","Season 6","Stephanie Barnett","The Love Spell Potential","Ramona Nowitzki","Mystic Warlords of Ka\'a","Courtney Henggeler","List of The Big Bang Theory characters","The Big Bang Theory","The History of Everything","Howard and Bernadette","The Closet Reconfiguration","Jim Parsons","The Staircase Implementation","Laurie Metcalf","If I Didn\'t Have You","Kate Micucci","The Cooper Extraction","Laura Spencer","The Cooper-Nowitzki Theorem","Emily (season 5)","The Closure Alternative","Riki Lindhome","Margo Harshman","California Institute of Technology","Johnny Galecki","The Gorilla Dissolution","The 21-Second Excitation","Pilot","The Einstein Approximation","Main Characters","Games","The Justice League Recombination","Cinnamon","The Contractual Obligation Implementation","Kurt","The Raiders Minimization","The Indecision Amalgamation","The Comic Center of Pasadena","The Cheesecake Factory","The Relationship Diremption","Simon Helberg","Season 9","List of Season 1 episodes","List of The Big Bang Theory episodes (season 4)","The Bozeman Reaction","Joyce Kim","Kunal Nayyar","List of The Big Bang Theory episodes (season 5)","Sheldon\'s Knock","The Adhesive Duck Deficiency","The Locomotive Manipulation","Sara Gilbert","The Creepy Candy Coating Corollary","The Lunar Excitation","The 43 Peculiarity","Wyatt","The Relationship Agreement","Janine Davis","The Bat Jar Conjecture","The Proton Transmogrification","The Scavenger Vortex","Elizabeth Plimpton","The Hofstadter Insufficiency","Meemaw","The Anything Can Happen Recurrence","List of The Big Bang Theory episodes (season 2)","The Recombination Hypothesis","George Cooper Jr.","The Bon Voyage Reaction","Penny/Gallery","Christine Baranski","The Mommy Observation","List of The Big Bang Theory episodes (season 3)","The Friendship Turbulence","Schedule","The Proton Resurgence","The Barbarian Sublimation","Alice","Rock Paper Scissors Lizard Spock","The Romance Resonance","The Middle-Earth Paradigm","The Werewolf Transformation","Sheldon\'s Bedroom","Brooke D\'Orsay","Season 4","Sheldon Cooper Presents: Fun with Flags","Apartment 4B","Aarti Mann","The Precious Fragmentation","Season 5","The Grasshopper Experiment","The Good Guy Fluctuation","Siri","George Cooper Sr.","Katee Sackhoff","The Alien Parasite Hypothesis","Appeared As Themselves","The Social Group","The Countdown Reflection","The Deception Verification","The Thanksgiving Decoupling","The Dumpling Paradox","Chuck Lorre Productions","Danica McKellar","Episode 8.03","Season 3","The Pants Alternative","Amy/Gallery","The Maternal Capacitance","Summer Glau","The Transporter Malfunction","Sheldon\'s Spot","The Weekend Vortex","The Tangible Affection Proof","The Ornithophobia Diffusion","The Hawking Excitation","Season 10","The Zazzy Substitution","The Occupation Recalibration","The Big Bran Hypothesis","The Boyfriend Complexity","Brian Smith","Mike Rostenkowski","The Convention Conundrum","The Bad Fish Paradigm","The Wheaton Recurrence","The Flaming Spittoon Acquisition","The Shiny Trinket Maneuver","Courtney Ford","The Plimpton Stimulation","Christy Vanderbel","Season 2","The Friendship Algorithm","The Spoiler Alert Segmentation","The Bath Item Gift Hypothesis","The Itchy Brain Simulation","The Table Polarization","Staff","The Vengeance Formulation","The Zarnecki Incursion","The Agreement Dissection","Chuck Lorre","Michael Hofstadter","The Excelsior Acquisition","Amanda Walsh","The Date Night Variable","The Wiggly Finger Catalyst","The Holographic Excitation","Pasadena","Judy Greer","The Beta Test Initiation","The Panty Piñata Polarization","The Skank Reflex Analysis","Kevin Sussman","Becky O\'Donohue","The Habitation Configuration","The Porkchop Indeterminacy","Mike Massimino","Valerie Azlynn","Penny\'s Boyfriends","Katie Leclerc","Bill Nye","Sweet Bernadette","Leonard Nimoy","The Hesitation Ramification","Yvette","Alicia","The Launch Acceleration","Cast","Dungeons and Dragons","Star Trek","Brian Patrick Wade","The Russian Rocket Reaction","The Parking Spot Escalation","Sara Rue","The Roommate Transmogrification","The Monster Isolation","The Fuzzy Boots Corollary","The Psychic Vortex","The Thespian Catalyst","Neil deGrasse Tyson","Schrödinger\'s Cat","The Bakersfield Expedition","The Work Song Nanocluster","The Financial Permeability","Lalita Gupta","The Fish Guts Displacement","The Griffin Equivalency","The Cooper-Hofstadter Polarization","The Hot Troll Deviation","Peter Chakos","Sheldon\'s Cats","The Discovery Dissipation","Index","The Luminous Fish Effect","The Electric Can Opener Fluctuation","David Underhill","The Herb Garden Germination"],"top_articles_txt":["Season 8","Sheldon Cooper","The Locomotion Interruption","Bernadette Rostenkowski-Wolowitz","Penny","Mrs. Debbie Wolowitz","Soft Kitty","Amy Farrah Fowler","Season 7","Episode 8.02","Professor Proton","Rajesh Koothrappali","Sheldon and Amy","Leonard Hofstadter","Emily (season 7)","Howard Wolowitz","Kaley Cuoco-Sweeting","List of The Big Bang Theory episodes","Leonard and Penny","Melissa Rauch","Howard\'s Father","The Status Quo Combustion","Carol Ann Susi","Barry Kripke","Alex Jensen","Priya Koothrappali","Lucy","Missy Cooper","The Tenure Turbulence","Apartment 4A","Zack Johnson","Mary Cooper","Mayim Bialik","Unaired Pilot","Bazinga","Wil Wheaton","The apartment building","The Roommate Agreement","Stephen Hawking","Stuart Bloom","Guest Appearances","Characters","Cast & Crew","Leslie Winkle","73","Beverly Hofstadter","Season 6","Stephanie Barnett","The Love Spell Potential","Ramona Nowitzki","Mystic Warlords of Ka\'a","Courtney Henggeler","List of The Big Bang Theory characters","The Big Bang Theory","The History of Everything","Howard and Bernadette","The Closet Reconfiguration","Jim Parsons","The Staircase Implementation","Laurie Metcalf","If I Didn\'t Have You","Kate Micucci","The Cooper Extraction","Laura Spencer","The Cooper-Nowitzki Theorem","Emily (season 5)","The Closure Alternative","Riki Lindhome","Margo Harshman","California Institute of Technology","Johnny Galecki","The Gorilla Dissolution","The 21-Second Excitation","Pilot","The Einstein Approximation","Main Characters","Games","The Justice League Recombination","Cinnamon","The Contractual Obligation Implementation","Kurt","The Raiders Minimization","The Indecision Amalgamation","The Comic Center of Pasadena","The Cheesecake Factory","The Relationship Diremption","Simon Helberg","Season 9","List of Season 1 episodes","List of The Big Bang Theory episodes (season 4)","The Bozeman Reaction","Joyce Kim","Kunal Nayyar","List of The Big Bang Theory episodes (season 5)","Sheldon\'s Knock","The Adhesive Duck Deficiency","The Locomotive Manipulation","Sara Gilbert","The Creepy Candy Coating Corollary","The Lunar Excitation","The 43 Peculiarity","Wyatt","The Relationship Agreement","Janine Davis","The Bat Jar Conjecture","The Proton Transmogrification","The Scavenger Vortex","Elizabeth Plimpton","The Hofstadter Insufficiency","Meemaw","The Anything Can Happen Recurrence","List of The Big Bang Theory episodes (season 2)","The Recombination Hypothesis","George Cooper Jr.","The Bon Voyage Reaction","Penny/Gallery","Christine Baranski","The Mommy Observation","List of The Big Bang Theory episodes (season 3)","The Friendship Turbulence","Schedule","The Proton Resurgence","The Barbarian Sublimation","Alice","Rock Paper Scissors Lizard Spock","The Romance Resonance","The Middle-Earth Paradigm","The Werewolf Transformation","Sheldon\'s Bedroom","Brooke D\'Orsay","Season 4","Sheldon Cooper Presents: Fun with Flags","Apartment 4B","Aarti Mann","The Precious Fragmentation","Season 5","The Grasshopper Experiment","The Good Guy Fluctuation","Siri","George Cooper Sr.","Katee Sackhoff","The Alien Parasite Hypothesis","Appeared As Themselves","The Social Group","The Countdown Reflection","The Deception Verification","The Thanksgiving Decoupling","The Dumpling Paradox","Chuck Lorre Productions","Danica McKellar","Episode 8.03","Season 3","The Pants Alternative","Amy/Gallery","The Maternal Capacitance","Summer Glau","The Transporter Malfunction","Sheldon\'s Spot","The Weekend Vortex","The Tangible Affection Proof","The Ornithophobia Diffusion","The Hawking Excitation","Season 10","The Zazzy Substitution","The Occupation Recalibration","The Big Bran Hypothesis","The Boyfriend Complexity","Brian Smith","Mike Rostenkowski","The Convention Conundrum","The Bad Fish Paradigm","The Wheaton Recurrence","The Flaming Spittoon Acquisition","The Shiny Trinket Maneuver","Courtney Ford","The Plimpton Stimulation","Christy Vanderbel","Season 2","The Friendship Algorithm","The Spoiler Alert Segmentation","The Bath Item Gift Hypothesis","The Itchy Brain Simulation","The Table Polarization","Staff","The Vengeance Formulation","The Zarnecki Incursion","The Agreement Dissection","Chuck Lorre","Michael Hofstadter","The Excelsior Acquisition","Amanda Walsh","The Date Night Variable","The Wiggly Finger Catalyst","The Holographic Excitation","Pasadena","Judy Greer","The Beta Test Initiation","The Panty Piñata Polarization","The Skank Reflex Analysis","Kevin Sussman","Becky O\'Donohue","The Habitation Configuration","The Porkchop Indeterminacy","Mike Massimino","Valerie Azlynn","Penny\'s Boyfriends","Katie Leclerc","Bill Nye","Sweet Bernadette","Leonard Nimoy","The Hesitation Ramification","Yvette","Alicia","The Launch Acceleration","Cast","Dungeons and Dragons","Star Trek","Brian Patrick Wade","The Russian Rocket Reaction","The Parking Spot Escalation","Sara Rue","The Roommate Transmogrification","The Monster Isolation","The Fuzzy Boots Corollary","The Psychic Vortex","The Thespian Catalyst","Neil deGrasse Tyson","Schrödinger\'s Cat","The Bakersfield Expedition","The Work Song Nanocluster","The Financial Permeability","Lalita Gupta","The Fish Guts Displacement","The Griffin Equivalency","The Cooper-Hofstadter Polarization","The Hot Troll Deviation","Peter Chakos","Sheldon\'s Cats","The Discovery Dissipation","Index","The Luminous Fish Effect","The Electric Can Opener Fluctuation","David Underhill","The Herb Garden Germination"],"all_domains_mv_wd":["big-bang.wikia.com","bigbang.wikia.com","bigbangtheory.wikia.com","tbbt.wikia.com","thebigbangtheory.wikia.com","www.bigbangtheory.wikia.com","www.tbbt.wikia.com","www.thebigbangtheory.wikia.com"],"series_mv_tm":["The Big Bang Theory"],"_version_":1476837914367229952,"score":7.870552}]}}';
	}

	protected function getBaseRequest() {
		$mockQuery = new \Solarium_Query_Select();

		$mockQuery->setQuery( '+("Big Bang Theory") AND +(lang_s:en)' );
		$mockQuery->setRows( 1 );

		$mockQuery->createFilterQuery( 'A&F' )->setQuery( '-(hostname_s:*fanon.wikia.com) AND -(hostname_s:*answers.wikia.com)' );
		$mockQuery->createFilterQuery( 'articles' )->setQuery( 'articles_i:[20 TO *]' );

		$dismax = $mockQuery->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$dismax->setQueryFields( 'series_mv_tm^15 description_txt categories_txt top_categories_txt top_articles_txt ' .
			'sitename_txt^2 all_domains_mv_wd^5' );
		$dismax->setPhraseFields( 'series_mv_tm^15 sitename_txt^2 all_domains_mv_wd^5' );

		$dismax->setBoostFunctions( 'wam_i^4' );
		$dismax->setQueryPhraseSlop( 1 );
		$dismax->setPhraseSlop( 1 );

		return $mockQuery;
	}
}