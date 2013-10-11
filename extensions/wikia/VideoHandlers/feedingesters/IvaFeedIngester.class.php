<?php

/**
 * Class IvaFeedIngester
 */
class IvaFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'IvaApiWrapper';
	protected static $PROVIDER = 'iva';
	protected static $FEED_URL = 'http://api.internetvideoarchive.com/1.0/DataService/EntertainmentPrograms?$top=$1&$skip=$2&$filter=$3&$expand=$4&$format=json&developerid=$5';
	protected static $ASSET_URL = 'http://www.videodetective.net/video.mp4?cmd=6&fmt=4&customerid=$1&videokbrate=750&publishedid=$2&e=$3';

	private static $VIDEO_SETS = array(
		'Wiggles' => array( 'Wiggles' ),
		'Futurama' => array( 'Futurama' ),
		'Winnie the Pooh' => array( 'Winnie the Pooh' ),
		'Huntik' => array( 'Huntik' ),
		'Rugrats' => array( 'Rugrats' ),
		'Digimon' => array( 'Digimon' ),
		'Power Rangers' => array( 'Power Rangers' ),
		'South Park' => array( 'South Park' ),
		'Alvin and the Chipmunks' => array( 'Alvin and the Chipmunks' ),
		'Animaniacs' => array( 'Animaniacs' ),
		'Kamen Rider' => array( 'Kamen Rider' ),
		'Bakugan' => array( 'Bakugan' ),
		'Lost' => array ( 1307 ),
		'Full Metal Alchemist' => array( 'Full Metal Alchemist' ),
		'True Blood' => array( 'True Blood' ),
		'iCarly' => array( 'iCarly' ),
		'Dexter' => array( 'Dexter' ),
		'Arthur' => array ( 266094, 60437, 664249, 495354, 15190, 490750, 897802, 897802, 866981 ),
		'X-Files' => array( 'X-Files' ),
		'Xiaolin' => array( 'Xiaolin' ),
		'Blues Clues' => array( 'Blues Clues' ),
		'Naruto' => array( 'Naruto' ),
		'Yu-Gi-Oh!' => array( 'Yu-Gi-Oh!' ),
		'Walking Dead' => array( 'Walking Dead' ),
		'Dragon Ball' => array( 'Dragon Ball' ),
		'Bleach' => array( 604483, 611394, 20912, 189824 ),
		'Glee' => array( 'Glee' ),
		'My Little Pony' => array( 'My Little Pony' ),
		'Vampire Diaries' => array( 'Vampire Diaries' ),
		'Game of Thrones' => array( 'Game of Thrones', 785881, 722311 ),
		'Doctor Who' => array( 'Doctor Who' ),
		'Gundam' => array( 'Gundam' ),
		'Degrassi' => array( 'Degrassi' ),
		'The Simpsons' => array( 'Simpsons' ),
		'Thomas the Tank Engine' => array( 'Thomas the Tank Engine' ),
		'Young Justice' => array( 'Young Justice' ),
		'Spongebob' => array( 'Spongebob' ),
		'Family Guy' => array( 'Family Guy' ),
		'How I Met Your Mother' => array( 'How I Met Your Mother' ),
		'Stargate' => array( 'Stargate' ),
		'Smallville' => array( 'Smallville' ),
		'Big Bang Theory' => array( 'Big Bang Theory' ),
		'Breaking Bad' => array( 'Breaking Bad' ),
		'Buffy' => array( 'Buffy' ),
		'Criminal Minds' => array( 'Criminal Minds' ),
		'Survivor' => array( 'Survivor' ),
		'American Dad' => array( 'American Dad' ),
		'Archer' => array( 457165 ),
		'Dance Moms' => array( 'Dance Moms' ),
		'Merlin' => array( 665766 ),
		'Grimm' => array( 'Grimm' ),
		'24' => array( 665302 ),
		'Saint Seiya' => array( 'Saint Seiya' ),
		'Bones' => array( 156185 ),
		'NCIS' => array( 'NCIS' ),
		'Being Human' => array( 'Being Human' ),
		'American Horror Story' => array( 'American Horror Story' ),
		'Sailor Moon' => array( 'Sailor Moon' ),
		'The Mentalist' => array( 172291 ),
		'Friends' => array( 55503 ),
		'YuYu Hakusho' => array( 185192 ),
		'House' => array( 422384 ),
		'Revenge' => array( 618690 ),
		'Justified' => array( 877316 ),
		'The Office' => array( 558636, 946809 ),
		'CSI' => array( 'CSI' ),
		'Prison Break' => array( 'Prison Break' ),
		'Suits' => array( 976703 ),
		'The Cleveland Show' => array( 'Cleveland Show' ),
		'H2O: Just Add Water' => array( 'H2O: Just Add Water' ),
		'Fringe' => array( 459388 ),
		'Misfits' => array( 828965 ),
		'Looney Tunes' => array( 'Looney Tunes' ),
		'Psych' => array( 839810 ),
		'SMASH' => array( 229948 ),
		'Avengers' => array( 7627, 225128, 102346 ),
		'Amazing Race' => array( 'Amazing Race' ),
		'Glee Project' => array( 'Glee Project' ),
		'Veggie Tales' => array( 'Veggie Tales' ),
		'The Following' => array( 828411 ),
		'Twilight' => array( 980633, 924807, 15097, 151421, 149755 ),
		'Hunger Games' => array( 'Hunger Games' ),
		'2 Broke Girls' => array( 690529 ),
		'21 Jump Street' => array( 171429 ),
		'30 Rock' => array( 761055 ),
		'3rd Rock from the Sun' => array( 621663 ),
		'90210' => array( 639717 ),
		'The A-Team' => array( 296204 ),
		'Adventures of Superman, Superman' => array( 318304 ),
		'All in the Family' => array( 317909 ),
		'All New Super Friends Hour' => array( 891256 ),
		'Ally McBeal' => array( 976069 ),
		'Almost Human' => array( 908760 ),
		"America's Got Talent" => array( 827888 ),
		"America's Test Kitchen" => array( 583529 ),
		'American Idol' => array( 59785 ),
		'American Ninja Warrior' => array( 401887 ),
		'American Pickers' => array( 529901 ),
		'Andromeda' => array( 900265 ),
		'The Andy Milonakis Show' => array( 687828 ),
		'Anger Management' => array( 298501 ),
		'The Apprentice' => array( 236378 ),
		'Aqua Teen Hunger Force' => array( 267991 ),
		'The Aquabats! Super Show!' => array( 394055 ),
		'Are you there, Chelsea?' => array( 189125 ),
		'Arrow' => array( 112768 ),
		'The Avengers' => array( 685421 ),
		'The Bad Girls Club' => array( 451526 ),
		'Battlestar Galactica' => array( 148022 ),
		'The Beast' => array( 334465 ),
		'Beastmaster' => array( 68821 ),
		'Beauty and the Beast' => array( 383663 ),
		'Beavis and Butt-Head' => array( 988775 ),
		'Ben and Kate' => array( 83477 ),
		'Bewitched' => array( 814168 ),
		'Big Brother' => array( 556870 ),
		'Big Valley' => array( 781495 ),
		'The Biggest Loser' => array( 566690 ),
		'Blue Bloods' => array( 715185 ),
		'Boardwalk Empire' => array( 843977, 765800 ),
		'The Boondocks' => array( 923306 ),
		'Boston Legal' => array( 700828 ),
		'Breaking In' => array( 593696 ),
		'Breakout Kings' => array( 740194 ),
		'Brothers' => array( 615653 ),
		'Burn Notice' => array( 551493 ),
		'Call the Midwife' => array( 187461 ),
		'Camelot' => array( 427115 ),
		'Caprica' => array( 450411 ),
		'Care Bears' => array( 324220 ),
		'Celebrity Apprentice' => array( 124746 ),
		'The Charlie Brown and Snoopy Show' => array( 845639 ),
		"Charlie's Angels" => array( 244686, 891871 ),
		'Charmed' => array( 90695 ),
		"Chefs A' Field" => array( 610940 ),
		'Chicago Code' => array( 701909 ),
		'Chuck' => array( 64277 ),
		'Code Monkeys' => array( 676905 ),
		'Cold Case' => array( 681495 ),
		'Community' => array( 893651 ),
		"Cook's Country from America's Test Kitchen, America's Test Kitchen" => array( 112096 ),
		'Cooking for Real' => array( 853187 ),
		'Cosby Show' => array( 554403 ),
		'Covert Affairs' => array( 268496 ),
		'Curb Your Enthusiasm' => array( 697260 ),
		"Da Vinci's Demons" => array( 250591 ),
		'Dallas' => array( 846295 ),
		'Damages' => array( 42294 ),
		"Daniel Tiger's Neighborhood" => array( 215333 ),
		'Daphne in the Brilliant Blue' => array( 959686 ),
		"Dawson's Creek" => array( 199230 ),
		'Deadwood' => array( 609128 ),
		'Desperate Housewives' => array( 649223 ),
		'Dog the Bounty Hunter' => array( 78834 ),
		'Dollhouse' => array( 281257 ),
		'Doogie Howser' => array( 973914 ),
		'Downton Abbey' => array( 926582 ),
		'Dr. Quinn' => array( 378319 ),
		'Dragons: Riders of Berk' => array( 321981 ),
		'Drew Carey Show' => array( 677044 ),
		'Drop Dead Diva' => array( 872503 ),
		'Dukes of Hazard' => array( 684593 ),
		'Easbound & Down' => array( 992237 ),
		'Entourage' => array( 210625 ),
		'ER' => array( 129940 ),
		'Eureka' => array( 30931 ),
		'Everwood' => array( 471874 ),
		'Facts of Life' => array( 652232 ),
		'Family Game Night' => array( 868947 ),
		'Fanboy & Chum Chum' => array( 19425 ),
		'Farscape' => array( 431683 ),
		'The Firm' => array( 486318 ),
		'Flashpoint' => array( 161583 ),
		'Flight of the Conchords' => array( 951106 ),
		'Flintstones' => array( 4184 ),
		'Fresh Prince of Bel Air' => array( 486337 ),
		'Friday Night Lights' => array( 480775 ),
		'Full House' => array( 474911 ),
		'G.I. Joe' => array( 468709, 466133 ),
		"Gene Roddenberry's Earth Final Conflict" => array( 12188 ),
		'George Lopez Show' => array( 310999 ),
		'Ghost in the Shell' => array( 303145 ),
		'Ghost Whisperer' => array( 897374 ),
		'Gimore Girls' => array( 425440 ),
		'Girls' => array( 998959 ),
		'Girls Bravo' => array( 495293 ),
		'Good Times' => array( 613415 ),
		'The Good Wife' => array( 635078 ),
		'Goodwin Games' => array( 268664 ),
		'Gossip Girl' => array( 718452 ),
		'Grounded for Life' => array( 648098 ),
		'The Guild' => array( 27062 ),
		"Harper's Island" => array( 437034 ),
		'Haven' => array( 670574 ),
		'Hawaii Five-0' => array( 106904 ),
		'Heartland' => array( 260996 ),
		'Hell on Wheels' => array( 101807 ),
		"Hell's Kitchen" => array( 39811 ),
		"Here's Lucy" => array( 637142 ),
		'Heroes' => array( 155693 ),
		'Hetalia Axis Powers' => array( 492321 ),
		'Highlander' => array( 348259 ),
		'Hit the Floor' => array( 961331 ),
		'Hollywood Game Night' => array( 902044 ),
		'Hot Wheels Battle Force Five' => array( 631390 ),
		'Hotel Babylon' => array( 895809 ),
		'Human Target' => array( 466447 ),
		'I Dream of Jasmine' => array( 541389 ),
		'I Love Lucy' => array( 3051 ),
		'In Plain Sight' => array( 807659 ),
		'In the Flow with Affion Crockett' => array( 486790 ),
		'Incredible Hulk' => array( 836039 ),
		'Inspector Lewis' => array( 986573 ),
		'Iron Man' => array( 716131 ),
		'The IT Crowd' => array( 314794 ),
		"It's Always Sunny in Philadelphia" => array( 667298 ),
		'J.A.G.' => array( 679137 ),
		'The Jeffersons' => array( 929194 ),
		'Jericho' => array( 481457 ),
		'The Jetsons' => array( 4203 ),
		'Johnny Bravo' => array( 811744 ),
		'Just Shoot Me' => array( 461510 ),
		'Justice League' => array( 623800 ),
		'Keeping up with the Kardashians' => array( 733181 ),
		'The Killing' => array( 936073 ),
		'King of Queens' => array( 767834 ),
		'The Kingdom' => array( 899036 ),
		'Kitchen Nightmares' => array( 960361 ),
		'Knight Rider' => array( 234005 ),
		'Knots Landing' => array( 190919 ),
		'Kourtney & Khloe Take Miami' => array( 621245 ),
		'The L Word' => array( 820156 ),
		'La Femme Nikita' => array( 727123 ),
		'Las Vegas' => array( 880729 ),
		'Late Late Show with Craig Ferguson' => array( 393750 ),
		'Law & Order' => array( 311822, 261135 ),
		'The League' => array( 158128 ),
		'Leverage' => array( 637031 ),
		"Liberty's Kids" => array( 615576 ),
		'Lie to Me' => array( 283149 ),
		'Life' => array( 144164 ),
		'Life (Part 2), Life' => array( 533723 ),
		'Life After People' => array( 469668 ),
		'Life Unexpected' => array( 408186 ),
		'Life with Derek' => array( 768599 ),
		'Lipstick Jungle' => array( 487280 ),
		'Little Britain' => array( 507455 ),
		'The Loop' => array( 769684 ),
		'Love in the Wild' => array( 356605 ),
		'Luther' => array( 137904 ),
		'MacGyver' => array( 999168 ),
		'Mad Love' => array( 590083 ),
		'Mad Men' => array( 359311 ),
		'MadTV' => array( 77396 ),
		'Magic City' => array( 688000 ),
		'Magnum, P.I.' => array( 480360 ),
		'Malcolm in the Middle' => array( 132402 ),
		"Mama's Family" => array( 390924 ),
		'Married with Children' => array( 833611 ),
		'Mash' => array( 556770 ),
		"McLeod's Daughters" => array( 711802 ),
		'Medium' => array( 954596 ),
		'Miami Vice' => array( 862739 ),
		'The Middle' => array( 942806 ),
		'Midsomer Murders' => array( 819047 ),
		'The Mighty Boosh' => array( 760449 ),
		'Mighty Morphin Power Rangers' => array( 5226 ),
		'Mike & Molly' => array( 574383 ),
		'The Mindy Project' => array( 628689 ),
		'Minute to Win It' => array( 143244 ),
		'Mob Wives' => array( 625433 ),
		'Mockingbird Lane' => array( 502447 ),
		'Monk' => array( 453223 ),
		'Monster Quest' => array( 77156 ),
		'Monsuno' => array( 578959 ),
		'Moonlight' => array( 364756 ),
		'My Boys' => array( 322486 ),
		'My Name is Earl' => array( 71377 ),
		'The Nanny' => array( 538382 ),
		'Napoleon Dynamite' => array( 785092 ),
		'Batman' => array( 897442 ),
		'New Adventures of Old Christine' => array( 169194 ),
		'New Adventures of Superman, Superman' => array( 797726 ),
		'New Avengers' => array( 661338 ),
		'New Girl' => array( 30499 ),
		'New Tricks' => array( 574063 ),
		'Newsradio' => array( 195272 ),
		'The Newsroom' => array( 434673 ),
		'Nip/Tuck' => array( 383193 ),
		'Northern Exposure' => array( 631850 ),
		'Numbers' => array( 786270 ),
		'Nurse Jackie' => array( 734434 ),
		'The O.C.' => array( 272717 ),
		'One Tree Hill' => array( 882174 ),
		'Orange is the New Black' => array( 998425 ),
		'Pac-Man' => array( 977577 ),
		'Pan Am' => array( 416581 ),
		'Parenthood' => array( 715049 ),
		'Party of Five' => array( 195111 ),
		'Pawn Stars' => array( 353353 ),
		'Person of Interest' => array( 835202 ),
		'Pokemon' => array( 190716 ),
		'Primeval' => array( 482349 ),
		'Project Runway' => array( 46063 ),
		'Pushing Daisies' => array( 208240 ),
		'Quantum Leap' => array( 886369 ),
		'Queer as Folk' => array( 962015 ),
		'Raising Hope' => array( 690347 ),
		'Real Housewives of Atlanta, Real Housewives' => array( 166755 ),
		'Real Housewives of New Jersey, Real Housewives' => array( 795188 ),
		'Rebus' => array( 95199 ),
		'Red Green Show' => array( 297817 ),
		'Rescue Me' => array( 107137 ),
		'Revolution' => array( 594182 ),
		'Robin Hood' => array( 35452 ),
		'Robot Chicken' => array( 945719 ),
		'Rockford Files' => array( 302548 ),
		'Rome' => array( 438562 ),
		'Rookie Blue' => array( 480648 ),
		'Roseanne' => array( 658525 ),
		'Royal Pains' => array( 747163 ),
		'Rules of Engagement' => array( 636324 ),
		'Running Wilde' => array( 217231 ),
		'Sanctuary' => array( 486106 ),
		'Sanford and Son' => array( 580358 ),
		'Saturday Night Live' => array( 90854 ),
		'Saving Hope' => array( 700248 ),
		'Scooby-Doo' => array( 853322, 837035, 277761 ),
		'Seaquest DSV' => array( 527230 ),
		'Seinfeld' => array( 322237 ),
		'Sex and the City' => array( 153203 ),
		'Sherlock' => array( 954987 ),
		'The Shield' => array( 497221 ),
		'Silverhawks' => array( 290306 ),
		'Sitting Ducks' => array( 547303 ),
		'Six Feet Under' => array( 568215 ),
		'Skins' => array( 552574 ),
		'Slacker Cats' => array( 340288 ),
		'Slugterra' => array( 632272 ),
		'Smurfs' => array( 397039 ),
		'So Little Time' => array( 770061 ),
		'So You Think You Can Dance' => array( 986978 ),
		'Sons of Anarchy' => array( 733059 ),
		'The Sopranos' => array( 492530 ),
		'Southland' => array( 326153 ),
		'Spider-Man, Spectacular Spiderman' => array( 689842 ),
		'Spin City' => array( 668757 ),
		'Star Trek' => array( 92386 ),
		'Star Trek, Star Trek: The Next Generation' => array( 3860 ),
		'Star Wars, Star Wars The Clone Wars' => array( 665563, 168621 ),
		'Storage Wars' => array( 845591 ),
		'Storage Wars, Storage Wars: Texas' => array( 121611 ),
		'Strikeforce' => array( 931820 ),
		'Studio 60 on the Sunset Strip' => array( 454811 ),
		'Super Friends' => array( 760922 ),
		'Superman' => array( 522314 ),
		'Supernatural' => array( 93788 ),
		'T.J. Hooker' => array( 418617 ),
		'Tales from the Crypt' => array( 3852 ),
		'Teen Titans' => array( 227821 ),
		'Teenage Mutant Ninja Turtles' => array( 3861 ),
		'Tenchi Muyo!' => array( 737174 ),
		'Tenchi Muyo!, Tenchi Muyo! GPX' => array( 163662 ),
		'Terminator Salvation: The Machinima Series, Terminator' => array( 731147 ),
		'Terminator: The Sarah Connor Chronicles, Terminator' => array( 128140 ),
		"That 70's Show" => array( 800259 ),
		'Third Watch' => array( 794399 ),
		'Three Stooges Show' => array( 556372 ),
		"Three's Company" => array( 200419 ),
		'Thundercats' => array( 357802 ),
		'Tiny Toon Adventures' => array( 88155 ),
		'Titanic' => array( 436349 ),
		'Top Chef' => array( 886253 ),
		'Top Gear' => array( 463512, 132424 ),
		'Top Shot' => array( 691564 ),
		'Transformers Prime, Transformers' => array( 610150 ),
		'Transformers' => array( 846371 ),
		'The Tudors' => array( 686289 ),
		'Two and a Half Men' => array( 357321 ),
		'Unforgettable' => array( 439754 ),
		'The Unit' => array( 344174 ),
		'Up All Night' => array( 833213 ),
		'Upstairs Downstairs' => array( 174747 ),
		'Urban Legends' => array( 661751 ),
		'Veronica Mars' => array( 57888 ),
		'The Voice' => array( 180413 ),
		'Voltron: Defender of the Universe' => array( 139900 ),
		'Wallace & Gromit' => array( 79904 ),
		'The Waltons' => array( 664759 ),
		'War at Home' => array( 57760 ),
		'Weeds' => array( 302192 ),
		'West Wing' => array( 263221 ),
		'What I Like About You' => array( 138500 ),
		"What's New Scooby-Doo, Scooby-Doo" => array( 777615 ),
		'White Collar' => array( 962833 ),
		"Whitest Kids U'Know" => array( 843849 ),
		'Whose Line is it Anyway?' => array( 646816, 729016 ),
		'Wildfire' => array( 401455 ),
		'Will & Grace' => array( 813758 ),
		'The Wire' => array( 277081 ),
		'Without a Trace' => array( 748167 ),
		'X Factor' => array( 628297 ),
		'Barney' => array( 3095, 357214, 632682, 305532, 411292, 703163, 722602, 321072, 817846, 828612, 271262, 99080, 8094, 7991 ),
		'Jimmy Neutron' => array( 688512 ),
		'Magic School Bus' => array( 817918 ),
		'Homeland' => array( 363720 ),
		'Duck Dynasty' => array( 517641 ),
		'Ben 10' => array( 949668 ),
		'Regular Show' => array( 856442 ),
		'Bates Motel' => array( 297650 ),
		"Bob's Burgers" => array( 933646 ),
		'Parks and Recreation' => array( 55981 ),
		'Chicago Fire' => array( 83410 ),
		'The Michael J Fox Show' => array( 771396 ),
		'Brooklyn Nine-Nine' => array( 535741 ),
		'The Blacklist' => array( 569424 ),
		'The Million Second Quiz' => array( 734825 ),
		'Puppy in my Pocket' => array( 784857 ),
		'Law and Order' => array( 311822 ),
		"Marvel's Agent of Shield" => array( 489034 ),
		'Spartacus' => array( 868477 ),
		'Todd & the Book of Pure Evil' => array( 62390 ),
		'The Vikings' => array( 402838 ),
		'Save Me' => array( 997994 ),
		'The Goodwin Games' => array( 268664 ),
		'Deception' => array( 730834 ),
		'The Americans' => array( 934933 ),
	);

	private static $EXCLUDE_MEDIA_IDS = array( 3, 12, 14, 15, 33, 36 );	// exclude song types

	const API_PAGE_SIZE = 100;

	/**
	 * Import IVA content
	 * @param string $content
	 * @param array $params
	 * @return int
	 */
	public function import( $content = '', $params = array() ) {
		wfProfileIn( __METHOD__ );

		$debug = !empty( $params['debug'] );
		$remoteAsset = !empty( $params['remoteAsset'] );
		$startDate = empty( $params['startDate'] ) ? '' : $params['startDate'];
		$endDate = empty( $params['endDate'] ) ? '' : $params['endDate'];
		$addlCategories = empty( $params['addlCategories'] ) ? array() : $params['addlCategories'];
		$createParams = array(
			'addlCategories' => $addlCategories,
			'debug' => $debug,
			'remoteAsset' => $remoteAsset
		);

		$articlesCreated = 0;

		// Ingest any content from the defined video sets above
		foreach( self::$VIDEO_SETS as $keyword => $videoSet ) {
			$videoParams['keyword'] = $keyword;

			foreach( $videoSet as $value ) {
				$videoParams['videoSet'] = $value;
				$videoParams['isPublishedId'] = ( is_numeric( $value ) );

				$result = $this->ingestVideos( $createParams, $startDate, $endDate, $videoParams );
				if ( $result === false ) {
					wfProfileOut( __METHOD__ );
					return 0;
				}

				$articlesCreated += $result;
			}
		}

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * ingest videos
	 * @param array $createParams
	 * @param integer $startDate - Unixtime for beginning of modified-on date range
	 * @param integer $endDate - Unixtime for ending of modified-on date range
	 * @param array $videoParams
	 * @return integer|false $articlesCreated - number of articles created or false
	 */
	private function ingestVideos( $createParams, $startDate, $endDate, $videoParams ) {
		wfProfileIn( __METHOD__ );

		$page = 0;
		$articlesCreated = 0;

		do {
			// Get the URL that selects specific video sets based on title matches
			$url = $this->makeSetFeedURL( $videoParams, $startDate, $endDate, $page++ );

			// Retrieve the video data from IVA
			$programs = $this->requestData( $url );
			if ( $programs === false ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$numPrograms = count( $programs );
			print( "Found $numPrograms Entertainment Programs...\n" );

			foreach( $programs as $program ) {
				$clipData = array();

				$program['title'] = empty( $program['DisplayTitle'] ) ? trim( $program['Title'] ) : trim( $program['DisplayTitle'] );
				$program['title'] = $this->updateTitle( $program['title'] );

				// get series
				$clipData['series'] = empty( $videoParams['series'] ) ? $program['title'] : $videoParams['series'];

				if ( isset( $program['OkToEncodeAndServe'] ) && $program['OkToEncodeAndServe'] == false ) {
					print "Skip: {$clipData['series']} (Publishedid:{$program['Publishedid']}) has OkToEncodeAndServe set to false.\n";
					continue;
				}

				// get season
				$clipData['season'] = empty( $videoParams['season'] ) ? '' : $videoParams['season'];
				if ( empty( $clipData['season'] ) && $program['MediaId'] == 26 ) {	// media type = season (26)
					 $clipData['season'] = $program['title'];
				}

				// get episode
				$clipData['episode'] = empty( $videoParams['episode'] ) ? '' : $videoParams['episode'];
				if ( empty( $clipData['episode'] ) && $program['MediaId'] == 27 ) {	// media type = episode (27)
					 $clipData['episode'] = $program['title'];
				}

				$clipData['tags'] = trim( $program['Tagline'] );

				$clipData['industryRating'] = '';
				if ( !empty( $program['MovieMpaa']['Rating'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $program['MovieMpaa']['Rating'] );
				} else if ( !empty( $program['TvRating']['Rating'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $program['TvRating']['Rating'] );
				} else if ( !empty( $program['GameWarning']['Warning'] ) ) {
					$clipData['industryRating'] = $this->getIndustryRating( $program['GameWarning']['Warning'] );
				}

				$clipData['ageRequired'] = $this->getAgeRequired( $clipData['industryRating'] );
				$clipData['ageGate'] = empty( $clipData['ageRequired'] ) ? 0 : 1;

				$clipData['genres'] = '';
				if ( !empty( $program['MovieCategory']['Category'] ) ) {
					$clipData['genres'] = $program['MovieCategory']['Category'];
				} else if ( !empty( $program['TvCategory']['Category'] ) ) {
					$clipData['genres'] = $program['TvCategory']['Category'];
				} else if ( !empty( $program['GameCategory']['Category'] ) ) {
					$clipData['genres'] = $program['GameCategory']['Category'];
				}

				$actors = array();
				if ( !empty( $program['ProgramToPerformerMaps']['results'] ) ) {
					foreach( $program['ProgramToPerformerMaps']['results'] as $performer ) {
						$actors[] = trim( $performer['Performer']['FullName'] );
					}
				}
				$clipData['actors'] = implode( ', ', $actors );

				$videoAssets = $program['VideoAssets']['results'];
				$numVideos = count( $videoAssets );
				print( "{$program['title']} (Series:{$clipData['series']}): Found $numVideos videos...\n" );

				// add video assets
				foreach ( $videoAssets as $videoAsset ) {
					$clipData['titleName'] = empty( $videoAsset['DisplayTitle'] ) ? trim( $videoAsset['Title'] ) : trim( $videoAsset['DisplayTitle'] );
					$clipData['titleName'] = $this->updateTitle( $clipData['titleName'] );

					// add episode name to title if the title contains 'clip' and number
					// example:
					// $clipData['episode'] = 'THE OFFICE: GARDEN PARTY'
					// $clipData['titleName'] = 'THE OFFICE: CLIP 1'
					// The new title will be 'THE OFFICE: GARDEN PARTY - CLIP 1'
					if ( !empty( $clipData['episode'] ) && preg_match( '/^([^:]*:)(.* clip \d+.*)/i', $clipData['titleName'], $matches ) ) {
						$titleName = $clipData['titleName'];

						// if episode and title start with the same words (i.e. <series_name>:), remove the matched word from the title
						if ( !empty( $matches[1] ) && !empty( $matches[2] ) && preg_match( '/^'.$matches[1].'.*/i', $clipData['episode'] ) ) {
							$titleName = trim( $matches[2] );
						}

						$clipData['titleName'] = $clipData['episode'].' - '.$titleName;
					}

					$clipData['videoId'] = $videoAsset['Publishedid'];

					if ( !empty( $videoAsset['ExpirationDate'] ) ) {
						print "Skip: {$clipData['titleName']} (Id:{$clipData['videoId']}) has expiration date.\n";
						continue;
					}

					$clipData['thumbnail'] = $videoAsset['VideoAssetScreenCapture']['URL'];
					$clipData['duration'] = $videoAsset['StreamLengthinseconds'];

					$clipData['published'] = '';
					if ( preg_match('/Date\((\d+)\)/', $videoAsset['DateCreated'], $matches) ) {
						$clipData['published'] = $matches[1]/1000;
					}

					$clipData['type'] = $this->getStdType( $videoAsset['MediaType']['Media'] );
					$clipData['category'] = $this->getCategory( $clipData['type'] );
					$clipData['description'] = trim( $videoAsset['Descriptions']['ItemDescription'] );
					$clipData['hd'] = ( $videoAsset['HdSource'] == 'true' ) ? 1 : 0;
					$clipData['provider'] = 'iva';

					// get resolution
					$clipData['resolution'] = '';
					if ( !empty( $videoAsset['SourceWidth'] ) && $videoAsset['SourceWidth'] > 0
						&& !empty( $videoAsset['SourceHeight'] ) && $videoAsset['SourceHeight'] > 0 ) {
						$clipData['resolution'] = $videoAsset['SourceWidth'].'x'.$videoAsset['SourceHeight'];
					}

					// get language
					if ( empty( $videoAsset['LanguageSpoken']['LanguageName'] ) ) {
						$clipData['language'] = '';
					} else {
						$clipData['language'] = $videoAsset['LanguageSpoken']['LanguageName'];
					}

					// get subtitle
					if ( empty( $videoAsset['LanguageSubtitled']['LanguageName'] ) ) {
						$clipData['subtitle'] = '';
					} else {
						$clipData['subtitle'] = $videoAsset['LanguageSubtitled']['LanguageName'];
					}

					// get target country
					if ( empty( $videoAsset['CountryTarget']['CountryName'] ) ) {
						$clipData['targetCountry'] = '';
					} else {
						$clipData['targetCountry'] = $videoAsset['CountryTarget']['CountryName'];
					}

					$clipData['name'] = empty( $videoParams['keyword'] ) ? '' : $videoParams['keyword'];

					// get keywords
					$keywords = empty( $clipData['name'] ) ? array() : array( $clipData['name'] );
					if ( !empty( $clipData['series'] ) ) {
						$keywords[] = $clipData['series'];
					}
					if ( !empty( $clipData['category'] ) ) {
						$keywords[] = $clipData['category'];
					}
					if ( !empty( $clipData['tags'] ) ) {
						$keywords[] = $clipData['tags'];
					}
					$clipData['keywords'] = implode( ', ', $this->getUniqueArray( $keywords ) );

					$msg = '';
					$articlesCreated += $this->createVideo( $clipData, $msg, $createParams );
					if ( $msg ) {
						print "ERROR: $msg\n";
					}
				}

				// get videos for series (24), season (26)
				if ( !empty( $videoParams['isPublishedId'] )
					&& ( $program['MediaId'] == 24 || $program['MediaId'] == 26 ) ) {
					$params = $videoParams;
					$params['series'] = $clipData['series'];
					$params['season'] = $clipData['season'];
					$params['episode'] = $clipData['episode'];
					$params['videoSet'] = $program['Publishedid'];
					$params['isPromotesPublishedId'] = true;

					$result = $this->ingestVideos( $createParams, $startDate, $endDate, $params );
					if ( $result === false ) {
						wfProfileOut( __METHOD__ );
						return false;
					}

					$articlesCreated += $result;
				}
			}
		} while ( $numPrograms == self::API_PAGE_SIZE );

		wfProfileOut( __METHOD__ );

		return $articlesCreated;
	}

	/**
	 * Create the feed URL for a specific $videoSet
	 * @param array $videoParams
	 * @param integer $startDate - Unixtime for beginning of modified-on date range
	 * @param integer $endDate - Unixtime for ending of modified-on date range
	 * @param integer $page - The page of results to fetch
	 * @return string - A feed URL
	 */
	private function makeSetFeedURL( $videoParams, $startDate, $endDate, $page ) {
		$filter = "(DateModified gt datetime'$startDate') " .
			"and (DateModified le datetime'$endDate') ";

		$videoSet = $videoParams['videoSet'];
		// check if it is PromotesPublishedId
		if ( empty( $videoParams['isPromotesPublishedId'] ) ) {
			// check if $videoSet is publish id or keyword
			if ( empty( $videoParams['isPublishedId'] ) ) {
				$filter .= "and (substringof('$videoSet', Title) eq true) ";
			} else {
				$filter .= "and (Publishedid eq $videoSet) ";
			}
		} else {
			$filter .= "and (PromotesPublishedId eq $videoSet) ";
		}

		// exclude song
		foreach ( self::$EXCLUDE_MEDIA_IDS as $id ) {
			$filter .= "and (MediaId ne $id) ";
		}

		return $this->initFeedUrl( $filter, $page );
	}

	/**
	 * Construct the URL given a start and end date and the result page to retrieve.
	 * @param $filter - The filter to include in the URL to select the correct video metadata
	 * @param $page - The page of results to fetch
	 * @return string - A feed URL
	 */
	private function initFeedUrl( $filter, $page ) {
		$url = str_replace( '$1', self::API_PAGE_SIZE, static::$FEED_URL );
		$url = str_replace( '$2', self::API_PAGE_SIZE * $page, $url );
		$url = str_replace( '$3', urlencode( $filter ), $url );

		$expand = array(
			'VideoAssets',
			'VideoAssets/Descriptions',
			'VideoAssets/VideoAssetScreenCapture',
			'VideoAssets/MediaType',
			'MovieMpaa',
			'TvRating',
			'GameWarning',
			'MovieCategory',
			'TvCategory',
			'ProgramToPerformerMaps/Performer',
			'VideoAssets/LanguageSpoken',
			'VideoAssets/LanguageSubtitled',
			'VideoAssets/CountryTarget',
		);

		$url = str_replace( '$4', implode( ',', $expand ), $url );
		$url = str_replace( '$5', F::app()->wg->IvaApiConfig['DeveloperId'], $url );

		return $url;
	}

	/**
	 * Call out to IVA for the video metadata from the URL passed as $url
	 * @param $url - The IVA URL to pull video metadata from
	 * @return array|bool
	 */
	private function requestData( $url ) {
		wfProfileIn( __METHOD__ );

		print( "Connecting to $url...\n" );

		$req = MWHttpRequest::factory( $url );
		$status = $req->execute();
		if ( $status->isOK() ) {
			$response = $req->getContent();
		} else {
			print( "ERROR: problem downloading content.\n" );
			wfProfileOut( __METHOD__ );

			return false;
		}

		// parse response
		$response = json_decode( $response, true );

		wfProfileOut( __METHOD__ );
		return ( empty($response['d']['results']) ) ? array() : $response['d']['results'];
	}

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $data
	 * @param array $categories
	 * @return array $categories
	 */
	public function generateCategories( $data, $categories ) {
		wfProfileIn( __METHOD__ );

		$categories[] = 'IVA';
		$categories[] = $data['name'];
		$categories[] = $data['series'];
		$categories[] = $data['category'];

		// add language
		if ( !empty( $data['language'] ) && strtolower( $data['language'] ) != 'english' ) {
			$categories[] = 'International';
			$categories[] = $data['language'];
		}

		// add subtitle
		if ( !empty( $data['subtitle'] ) && strtolower( $data['subtitle'] ) != 'english' ) {
			$categories[] = 'International';
			$categories[] = $data['subtitle'];
		}

		wfProfileOut( __METHOD__ );

		return $this->getUniqueArray( $categories );
	}

	/**
	 * Massage some video metadata and generate URLs to this video's assets
	 * @param string $name
	 * @param array $data
	 * @return array $data
	 */
	protected function generateRemoteAssetData( $name, $data ) {
		$data['name'] = $name;
		$data['duration'] = $data['duration'] * 1000;
		$data['published'] = empty( $data['published'] ) ? '' : strftime( '%Y-%m-%d', $data['published'] );

		$url = str_replace( '$1', F::app()->wg->IvaApiConfig['AppId'], static::$ASSET_URL );
		$url = str_replace( '$2', $data['videoId'], $url );

		$expired = 1609372800; // 2020-12-31
		$url = str_replace( '$3', $expired, $url );

		$hash = $this->generateHash( $url );
		$url .= '&h='.$hash;

		$data['url'] = array(
			'flash' => $url,
			'iphone' => $url,
		);

		return $data;
	}

	/**
	 * Generate an MD5 hash from the IVA App Key combined with the URL
	 * @param string $url - The URL to base the hash on
	 * @return string $hash - The MD5 hash
	 */
	protected function generateHash( $url ) {
		$hash = md5( strtolower( F::app()->wg->IvaApiConfig['AppKey'].$url ) );

		return $hash;
	}

	/**
	 * update title by moving 'the' from the end of the title to the beginning of the title
	 * @param string $title
	 * @return string $title
	 */
	protected function updateTitle( $title ) {
		if ( preg_match( '/^(.+), *(the)$/i', $title, $matches ) ) {
			$title = trim( $matches[2] ).' '.trim( $matches[1] );
		}

		return $title;
	}

}
