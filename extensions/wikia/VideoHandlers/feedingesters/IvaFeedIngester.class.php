<?php

/**
 * Class IvaFeedIngester
 */
class IvaFeedIngester extends RemoteAssetFeedIngester {
	protected static $API_WRAPPER = 'IvaApiWrapper';
	protected static $PROVIDER = 'iva';
	protected static $FEED_URL = 'http://api.internetvideoarchive.com/1.0/DataService/EntertainmentPrograms?$top=$1&$skip=$2&$filter=$3&$expand=$4&$format=json&developerid=$5';
	protected static $FEED_URL_ASSET = 'http://api.internetvideoarchive.com/1.0/DataService/VideoAssets()?$top=$1&$skip=$2&$filter=$3&$expand=$4&$format=json&developerid=$5';
	protected static $ASSET_URL = 'http://www.videodetective.net/video.mp4?cmd=6&fmt=4&customerid=$1&videokbrate=$4&publishedid=$2&e=$3';

	protected static $ASSET_BITRATE = 1500;
	protected static $ASSET_BITRATE_MOBILE = 750;

	private static $VIDEO_SETS = [
		'Wiggles' => [ 'Wiggles' ],
		'Futurama' => [ 'Futurama' ],
		'Winnie the Pooh' => [ 'Winnie the Pooh' ],
		'Huntik' => [ 'Huntik' ],
		'Rugrats' => [ 'Rugrats' ],
		'Digimon' => [ 'Digimon' ],
		'Power Rangers' => [ 'Power Rangers' ],
		'South Park' => [ 'South Park' ],
		'Alvin and the Chipmunks' => [ 'Alvin and the Chipmunks' ],
		'Animaniacs' => [ 'Animaniacs' ],
		'Kamen Rider' => [ 'Kamen Rider' ],
		'Bakugan' => [ 'Bakugan' ],
		'Lost' => [ 1307 ],
		'Full Metal Alchemist' => [ 'Full Metal Alchemist' ],
		'True Blood' => [ 'True Blood' ],
		'iCarly' => [ 'iCarly' ],
		'Dexter' => [ 'Dexter' ],
		'Arthur' => [ 266094, 60437, 664249, 495354, 15190, 490750, 897802, 897802, 866981 ],
		'X-Files' => [ 'X-Files' ],
		'Xiaolin' => [ 'Xiaolin' ],
		'Blues Clues' => [ 'Blues Clues' ],
		'Naruto' => [ 'Naruto' ],
		'Yu-Gi-Oh!' => [ 'Yu-Gi-Oh!' ],
		'Walking Dead' => [ 'Walking Dead' ],
		'Dragon Ball' => [ 'Dragon Ball' ],
		'Bleach' => [ 604483, 611394, 20912, 189824 ],
		'Glee' => [ 'Glee' ],
		'My Little Pony' => [ 'My Little Pony' ],
		'Vampire Diaries' => [ 'Vampire Diaries' ],
		'Game of Thrones' => [ 785881, 722311 ],
		'Doctor Who' => [ 'Doctor Who' ],
		'Gundam' => [ 'Gundam' ],
		'Degrassi' => [ 'Degrassi' ],
		'The Simpsons' => [ 'Simpsons' ],
		'Thomas the Tank Engine' => [ 'Thomas the Tank Engine' ],
		'Young Justice' => [ 'Young Justice' ],
		'Spongebob' => [ 'Spongebob' ],
		'Family Guy' => [ 'Family Guy' ],
		'How I Met Your Mother' => [ 'How I Met Your Mother' ],
		'Stargate' => [ 'Stargate' ],
		'Smallville' => [ 'Smallville' ],
		'Big Bang Theory' => [ 'Big Bang Theory' ],
		'Breaking Bad' => [ 'Breaking Bad' ],
		'Buffy' => [ 'Buffy' ],
		'Criminal Minds' => [ 'Criminal Minds' ],
		'Survivor' => [ 'Survivor' ],
		'American Dad' => [ 'American Dad' ],
		'Archer' => [ 457165 ],
		'Dance Moms' => [ 'Dance Moms' ],
		'Merlin' => [ 665766 ],
		'Grimm' => [ 'Grimm' ],
		'24' => [ 665302 ],
		'Saint Seiya' => [ 'Saint Seiya' ],
		'Bones' => [ 156185 ],
		'NCIS' => [ 'NCIS' ],
		'Being Human' => [ 'Being Human' ],
		'American Horror Story' => [ 'American Horror Story' ],
		'Sailor Moon' => [ 'Sailor Moon' ],
		'The Mentalist' => [ 172291 ],
		'Friends' => [ 55503 ],
		'YuYu Hakusho' => [ 185192 ],
		'House' => [ 422384 ],
		'Revenge' => [ 618690 ],
		'Justified' => [ 877316 ],
		'The Office' => [ 558636, 946809 ],
		'CSI' => [ 'CSI' ],
		'Prison Break' => [ 'Prison Break' ],
		'Suits' => [ 976703 ],
		'The Cleveland Show' => [ 'Cleveland Show' ],
		'H2O: Just Add Water' => [ 'H2O: Just Add Water' ],
		'Fringe' => [ 459388 ],
		'Misfits' => [ 828965 ],
		'Looney Tunes' => [ 'Looney Tunes' ],
		'Psych' => [ 839810 ],
		'SMASH' => [ 229948 ],
		'Avengers' => [ 7627, 225128, 102346 ],
		'Amazing Race' => [ 'Amazing Race' ],
		'Glee Project' => [ 'Glee Project' ],
		'Veggie Tales' => [ 'Veggie Tales' ],
		'The Following' => [ 828411 ],
		'Twilight' => [ 980633, 924807, 15097, 151421, 149755 ],
		'Hunger Games' => [ 'Hunger Games' ],
		'2 Broke Girls' => [ 690529 ],
		'21 Jump Street' => [ 171429 ],
		'30 Rock' => [ 761055 ],
		'3rd Rock from the Sun' => [ 621663 ],
		'90210' => [ 639717 ],
		'The A-Team' => [ 296204 ],
		'Adventures of Superman, Superman' => [ 318304 ],
		'All in the Family' => [ 317909 ],
		'All New Super Friends Hour' => [ 891256 ],
		'Ally McBeal' => [ 976069 ],
		'Almost Human' => [ 908760 ],
		"America's Got Talent" => [ 827888 ],
		"America's Test Kitchen" => [ 583529 ],
		'American Idol' => [ 59785 ],
		'American Ninja Warrior' => [ 401887 ],
		'American Pickers' => [ 529901 ],
		'Andromeda' => [ 900265 ],
		'The Andy Milonakis Show' => [ 687828 ],
		'Anger Management' => [ 298501 ],
		'The Apprentice' => [ 236378 ],
		'Aqua Teen Hunger Force' => [ 267991 ],
		'The Aquabats! Super Show!' => [ 394055 ],
		'Are you there, Chelsea?' => [ 189125 ],
		'Arrow' => [ 112768 ],
		'The Avengers' => [ 685421 ],
		'The Bad Girls Club' => [ 451526 ],
		'Battlestar Galactica' => [ 148022 ],
		'The Beast' => [ 334465 ],
		'Beastmaster' => [ 68821 ],
		'Beauty and the Beast' => [ 383663 ],
		'Beavis and Butt-Head' => [ 988775 ],
		'Ben and Kate' => [ 83477 ],
		'Bewitched' => [ 814168 ],
		'Big Brother' => [ 556870 ],
		'Big Valley' => [ 781495 ],
		'The Biggest Loser' => [ 566690 ],
		'Blue Bloods' => [ 715185 ],
		'Boardwalk Empire' => [ 843977, 765800 ],
		'The Boondocks' => [ 923306 ],
		'Boston Legal' => [ 700828 ],
		'Breaking In' => [ 593696 ],
		'Breakout Kings' => [ 740194 ],
		'Brothers' => [ 615653 ],
		'Burn Notice' => [ 551493 ],
		'Call the Midwife' => [ 187461 ],
		'Camelot' => [ 427115 ],
		'Caprica' => [ 450411 ],
		'Care Bears' => [ 324220 ],
		'Celebrity Apprentice' => [ 124746 ],
		'The Charlie Brown and Snoopy Show' => [ 845639 ],
		"Charlie's Angels" => [ 244686, 891871 ],
		'Charmed' => [ 90695 ],
		"Chefs A' Field" => [ 610940 ],
		'Chicago Code' => [ 701909 ],
		'Chuck' => [ 64277 ],
		'Code Monkeys' => [ 676905 ],
		'Cold Case' => [ 681495 ],
		'Community' => [ 893651 ],
		"Cook's Country from America's Test Kitchen, America's Test Kitchen" => [ 112096 ],
		'Cooking for Real' => [ 853187 ],
		'Cosby Show' => [ 554403 ],
		'Covert Affairs' => [ 268496 ],
		'Curb Your Enthusiasm' => [ 697260 ],
		"Da Vinci's Demons" => [ 250591 ],
		'Dallas' => [ 846295 ],
		'Damages' => [ 42294 ],
		"Daniel Tiger's Neighborhood" => [ 215333 ],
		'Daphne in the Brilliant Blue' => [ 959686 ],
		"Dawson's Creek" => [ 199230 ],
		'Deadwood' => [ 609128 ],
		'Desperate Housewives' => [ 649223 ],
		'Dog the Bounty Hunter' => [ 78834 ],
		'Dollhouse' => [ 281257 ],
		'Doogie Howser' => [ 973914 ],
		'Downton Abbey' => [ 926582 ],
		'Dr. Quinn' => [ 378319 ],
		'Dragons: Riders of Berk' => [ 321981 ],
		'Drew Carey Show' => [ 677044 ],
		'Drop Dead Diva' => [ 872503 ],
		'Dukes of Hazard' => [ 684593 ],
		'Easbound & Down' => [ 992237 ],
		'Entourage' => [ 210625 ],
		'ER' => [ 129940 ],
		'Eureka' => [ 30931 ],
		'Everwood' => [ 471874 ],
		'Facts of Life' => [ 652232 ],
		'Family Game Night' => [ 868947 ],
		'Fanboy & Chum Chum' => [ 19425 ],
		'Farscape' => [ 431683 ],
		'The Firm' => [ 486318 ],
		'Flashpoint' => [ 161583 ],
		'Flight of the Conchords' => [ 951106 ],
		'Flintstones' => [ 4184 ],
		'Fresh Prince of Bel Air' => [ 486337 ],
		'Friday Night Lights' => [ 480775 ],
		'Full House' => [ 474911 ],
		'G.I. Joe' => [ 468709, 466133 ],
		"Gene Roddenberry's Earth Final Conflict" => [ 12188 ],
		'George Lopez Show' => [ 310999 ],
		'Ghost in the Shell' => [ 303145 ],
		'Ghost Whisperer' => [ 897374 ],
		'Gimore Girls' => [ 425440 ],
		'Girls' => [ 998959 ],
		'Girls Bravo' => [ 495293 ],
		'Good Times' => [ 613415 ],
		'The Good Wife' => [ 635078 ],
		'Goodwin Games' => [ 268664 ],
		'Gossip Girl' => [ 718452 ],
		'Grounded for Life' => [ 648098 ],
		'The Guild' => [ 27062 ],
		"Harper's Island" => [ 437034 ],
		'Haven' => [ 670574 ],
		'Hawaii Five-0' => [ 106904 ],
		'Heartland' => [ 260996 ],
		'Hell on Wheels' => [ 101807 ],
		"Hell's Kitchen" => [ 39811 ],
		"Here's Lucy" => [ 637142 ],
		'Heroes' => [ 155693 ],
		'Hetalia Axis Powers' => [ 492321 ],
		'Highlander' => [ 348259 ],
		'Hit the Floor' => [ 961331 ],
		'Hollywood Game Night' => [ 902044 ],
		'Hot Wheels Battle Force Five' => [ 631390 ],
		'Hotel Babylon' => [ 895809 ],
		'Human Target' => [ 466447 ],
		'I Dream of Jasmine' => [ 541389 ],
		'I Love Lucy' => [ 3051 ],
		'In Plain Sight' => [ 807659 ],
		'In the Flow with Affion Crockett' => [ 486790 ],
		'Incredible Hulk' => [ 836039 ],
		'Inspector Lewis' => [ 986573 ],
		'Iron Man' => [ 716131 ],
		'The IT Crowd' => [ 314794 ],
		"It's Always Sunny in Philadelphia" => [ 667298 ],
		'J.A.G.' => [ 679137 ],
		'The Jeffersons' => [ 929194 ],
		'Jericho' => [ 481457 ],
		'The Jetsons' => [ 4203 ],
		'Johnny Bravo' => [ 811744 ],
		'Just Shoot Me' => [ 461510 ],
		'Justice League' => [ 623800 ],
		'Keeping up with the Kardashians' => [ 733181 ],
		'The Killing' => [ 936073 ],
		'King of Queens' => [ 767834 ],
		'The Kingdom' => [ 899036 ],
		'Kitchen Nightmares' => [ 960361 ],
		'Knight Rider' => [ 234005 ],
		'Knots Landing' => [ 190919 ],
		'Kourtney & Khloe Take Miami' => [ 621245 ],
		'The L Word' => [ 820156 ],
		'La Femme Nikita' => [ 727123 ],
		'Las Vegas' => [ 880729 ],
		'Late Late Show with Craig Ferguson' => [ 393750 ],
		'Law & Order' => [ 311822, 261135 ],
		'The League' => [ 158128 ],
		'Leverage' => [ 637031 ],
		"Liberty's Kids" => [ 615576 ],
		'Lie to Me' => [ 283149 ],
		'Life' => [ 144164 ],
		'Life (Part 2), Life' => [ 533723 ],
		'Life After People' => [ 469668 ],
		'Life Unexpected' => [ 408186 ],
		'Life with Derek' => [ 768599 ],
		'Lipstick Jungle' => [ 487280 ],
		'Little Britain' => [ 507455 ],
		'The Loop' => [ 769684 ],
		'Love in the Wild' => [ 356605 ],
		'Luther' => [ 137904 ],
		'MacGyver' => [ 999168 ],
		'Mad Love' => [ 590083 ],
		'Mad Men' => [ 359311 ],
		'MadTV' => [ 77396 ],
		'Magic City' => [ 688000 ],
		'Magnum, P.I.' => [ 480360 ],
		'Malcolm in the Middle' => [ 132402 ],
		"Mama's Family" => [ 390924 ],
		'Married with Children' => [ 833611 ],
		'Mash' => [ 556770 ],
		"McLeod's Daughters" => [ 711802 ],
		'Medium' => [ 954596 ],
		'Miami Vice' => [ 862739 ],
		'The Middle' => [ 942806 ],
		'Midsomer Murders' => [ 819047 ],
		'The Mighty Boosh' => [ 760449 ],
		'Mighty Morphin Power Rangers' => [ 5226 ],
		'Mike & Molly' => [ 574383 ],
		'The Mindy Project' => [ 628689 ],
		'Minute to Win It' => [ 143244 ],
		'Mob Wives' => [ 625433 ],
		'Mockingbird Lane' => [ 502447 ],
		'Monk' => [ 453223 ],
		'Monster Quest' => [ 77156 ],
		'Monsuno' => [ 578959 ],
		'Moonlight' => [ 364756 ],
		'My Boys' => [ 322486 ],
		'My Name is Earl' => [ 71377 ],
		'The Nanny' => [ 538382 ],
		'Napoleon Dynamite' => [ 785092 ],
		'Batman' => [ 897442 ],
		'New Adventures of Old Christine' => [ 169194 ],
		'New Adventures of Superman, Superman' => [ 797726 ],
		'New Avengers' => [ 661338 ],
		'New Girl' => [ 30499 ],
		'New Tricks' => [ 574063 ],
		'Newsradio' => [ 195272 ],
		'The Newsroom' => [ 434673 ],
		'Nip/Tuck' => [ 383193 ],
		'Northern Exposure' => [ 631850 ],
		'Numbers' => [ 786270 ],
		'Nurse Jackie' => [ 734434 ],
		'The O.C.' => [ 272717 ],
		'One Tree Hill' => [ 882174 ],
		'Orange is the New Black' => [ 998425 ],
		'Pac-Man' => [ 977577 ],
		'Pan Am' => [ 416581 ],
		'Parenthood' => [ 715049 ],
		'Party of Five' => [ 195111 ],
		'Pawn Stars' => [ 353353 ],
		'Person of Interest' => [ 835202 ],
		'Pokemon' => [ 190716 ],
		'Primeval' => [ 482349 ],
		'Project Runway' => [ 46063 ],
		'Pushing Daisies' => [ 208240 ],
		'Quantum Leap' => [ 886369 ],
		'Queer as Folk' => [ 962015 ],
		'Raising Hope' => [ 690347 ],
		'Real Housewives of Atlanta, Real Housewives' => [ 166755 ],
		'Real Housewives of New Jersey, Real Housewives' => [ 795188 ],
		'Rebus' => [ 95199 ],
		'Red Green Show' => [ 297817 ],
		'Rescue Me' => [ 107137 ],
		'Revolution' => [ 594182 ],
		'Robin Hood' => [ 35452 ],
		'Robot Chicken' => [ 945719 ],
		'Rockford Files' => [ 302548 ],
		'Rome' => [ 438562 ],
		'Rookie Blue' => [ 480648 ],
		'Roseanne' => [ 658525 ],
		'Royal Pains' => [ 747163 ],
		'Rules of Engagement' => [ 636324 ],
		'Running Wilde' => [ 217231 ],
		'Sanctuary' => [ 486106 ],
		'Sanford and Son' => [ 580358 ],
		'Saturday Night Live' => [ 90854 ],
		'Saving Hope' => [ 700248 ],
		'Scooby-Doo' => [ 853322, 837035, 277761 ],
		'Seaquest DSV' => [ 527230 ],
		'Seinfeld' => [ 322237 ],
		'Sex and the City' => [ 153203 ],
		'Sherlock' => [ 954987 ],
		'The Shield' => [ 497221 ],
		'Silverhawks' => [ 290306 ],
		'Sitting Ducks' => [ 547303 ],
		'Six Feet Under' => [ 568215 ],
		'Skins' => [ 552574 ],
		'Slacker Cats' => [ 340288 ],
		'Slugterra' => [ 632272 ],
		'Smurfs' => [ 397039 ],
		'So Little Time' => [ 770061 ],
		'So You Think You Can Dance' => [ 986978 ],
		'Sons of Anarchy' => [ 733059 ],
		'The Sopranos' => [ 492530 ],
		'Southland' => [ 326153 ],
		'Spider-Man, Spectacular Spiderman' => [ 689842 ],
		'Spin City' => [ 668757 ],
		'Star Trek' => [ 92386 ],
		'Star Trek, Star Trek: The Next Generation' => [ 3860 ],
		'Star Wars, Star Wars The Clone Wars' => [ 665563, 168621, 682720 ],
		'Storage Wars' => [ 845591 ],
		'Storage Wars, Storage Wars: Texas' => [ 121611 ],
		'Strikeforce' => [ 931820 ],
		'Studio 60 on the Sunset Strip' => [ 454811 ],
		'Super Friends' => [ 760922 ],
		'Superman' => [ 522314 ],
		'Supernatural' => [ 93788 ],
		'T.J. Hooker' => [ 418617 ],
		'Tales from the Crypt' => [ 3852 ],
		'Teen Titans' => [ 227821 ],
		'Teenage Mutant Ninja Turtles' => [ 3861 ],
		'Tenchi Muyo!' => [ 737174 ],
		'Tenchi Muyo!, Tenchi Muyo! GPX' => [ 163662 ],
		'Terminator Salvation: The Machinima Series, Terminator' => [ 731147 ],
		'Terminator: The Sarah Connor Chronicles, Terminator' => [ 128140 ],
		"That 70's Show" => [ 800259 ],
		'Third Watch' => [ 794399 ],
		'Three Stooges Show' => [ 556372 ],
		"Three's Company" => [ 200419 ],
		'Thundercats' => [ 357802 ],
		'Tiny Toon Adventures' => [ 88155 ],
		'Titanic' => [ 436349 ],
		'Top Chef' => [ 886253 ],
		'Top Gear' => [ 463512, 132424 ],
		'Top Shot' => [ 691564 ],
		'Transformers Prime, Transformers' => [ 610150 ],
		'Transformers' => [ 846371 ],
		'The Tudors' => [ 686289 ],
		'Two and a Half Men' => [ 357321 ],
		'Unforgettable' => [ 439754 ],
		'The Unit' => [ 344174 ],
		'Up All Night' => [ 833213 ],
		'Upstairs Downstairs' => [ 174747 ],
		'Urban Legends' => [ 661751 ],
		'Veronica Mars' => [ 57888 ],
		'The Voice' => [ 180413 ],
		'Voltron: Defender of the Universe' => [ 139900 ],
		'Wallace & Gromit' => [ 79904 ],
		'The Waltons' => [ 664759 ],
		'War at Home' => [ 57760 ],
		'Weeds' => [ 302192 ],
		'West Wing' => [ 263221 ],
		'What I Like About You' => [ 138500 ],
		"What's New Scooby-Doo, Scooby-Doo" => [ 777615 ],
		'White Collar' => [ 962833 ],
		"Whitest Kids U'Know" => [ 843849 ],
		'Whose Line is it Anyway?' => [ 646816, 729016 ],
		'Wildfire' => [ 401455 ],
		'Will & Grace' => [ 813758 ],
		'The Wire' => [ 277081 ],
		'Without a Trace' => [ 748167 ],
		'X Factor' => [ 628297 ],
		'Barney' => [ 3095, 357214, 632682, 305532, 411292, 703163, 722602, 321072, 817846, 828612, 271262, 99080, 8094, 7991 ],
		'Jimmy Neutron' => [ 688512 ],
		'Magic School Bus' => [ 817918 ],
		'Homeland' => [ 363720 ],
		'Duck Dynasty' => [ 517641 ],
		'Ben 10' => [ 949668 ],
		'Regular Show' => [ 856442 ],
		'Bates Motel' => [ 297650 ],
		"Bob's Burgers" => [ 933646 ],
		'Parks and Recreation' => [ 55981 ],
		'Chicago Fire' => [ 83410 ],
		'The Michael J Fox Show' => [ 771396 ],
		'Brooklyn Nine-Nine' => [ 535741 ],
		'The Blacklist' => [ 569424 ],
		'The Million Second Quiz' => [ 734825 ],
		'Puppy in my Pocket' => [ 784857 ],
		'Law and Order' => [ 311822 ],
		"Marvel's Agent of Shield" => [ 489034 ],
		'Spartacus' => [ 868477 ],
		'Todd & the Book of Pure Evil' => [ 62390 ],
		'The Vikings' => [ 402838 ],
		'Save Me' => [ 997994 ],
		'The Goodwin Games' => [ 268664 ],
		'Deception' => [ 730834 ],
		'The Americans' => [ 934933 ],
		'Gotham' => [ 14924 ],
		'Penny Dreadful' => [ 304089 ],
		'Orphan Black' => [ 731971 ],
		'Sleepy Hollow' => [ 326245 ],
		'Hannibal' => [ 575155 ],
		'Extant' => [ 941342 ],
		'Crossbones' => [ 348355 ],
		'Defiance' => [ 90566 ],
		'Constantine' => [ 228617 ],
		'Under the Dome' => [ 565426 ],
		'State of Affairs' => [ 83930 ],
		'Star Wars Rebels' => [ 402210 ],
		'Adventure Time' => [ 229351 ],
		'Star Wars Episode I: The Phantom Menace' => [ 481313 ],
		'Return of the Jedi' => [ 2701 ],
		'Lego Star Wars: The Empire Strikes Out' => [ 285876 ],
		'The Empire Strikes Back' => [ 2846 ],
		'Star Wars' => [ 3883 ],
		'Star Wars Episode II: Attack of the Clones' => [ 862846 ],
		'Galavant' => [ 280387 ],
		'The White Queen' => [ 153637 ],
		'iZombie' => [ 77189 ],
		'Wayard Pines' => [ 862586 ],
		'Black Sails' => [ 37712 ],
		'Scandal' => [ 615399 ],
		'How To Get Away With Murder' => [ 990626 ],
		'Outlander' => [ 527844 ],
		'True Detective' => [ 589103 ],
		'Helix' => [ 536734 ],
		'Reign' => [ 810025 ],
	];

	// exclude song and movie types
	protected static $EXCLUDE_MEDIA_IDS = [
		3, 12, 14, 15, 33, 36,
		0, 5, 6, 10, 20,
	];

	protected static $MEDIA_IDS_MOVIE = [ 0, 5, 6, 10, 20 ];

	// expand fields included in API [ [ fieldName => apiType ] ]
	protected static $API_EXPAND_FIELDS = [
		'Descriptions' => 'VideoAssets',
		'VideoAssetScreenCapture' => 'VideoAssets',
		'MediaType' => 'VideoAssets',
		'LanguageSpoken' => 'VideoAssets',
		'LanguageSubtitled' => 'VideoAssets',
		'CountryTarget' => 'VideoAssets',
		'MovieMpaa' => 'EntertainmentProgram',
		'TvRating' => 'EntertainmentProgram',
		'GameWarning' => 'EntertainmentProgram',
		'MovieCategory' => 'EntertainmentProgram',
		'TvCategory' => 'EntertainmentProgram',
		'ProgramToPerformerMaps/Performer' => 'EntertainmentProgram',
	];

	const API_PAGE_SIZE = 100;
	const MIN_RELEASE_YEAR = 2013;

	/**
	 * Import IVA content
	 * @param string $content
	 * @param array $params
	 * @return int
	 */
	public function import( $content = '', array $params = [] ) {
		$startDate = empty( $params['startDate'] ) ? '' : $params['startDate'];
		$endDate = empty( $params['endDate'] ) ? '' : $params['endDate'];

		$articlesCreated = 0;

		// Ingest any content from the defined video sets above
		$videoParams = [ 'apiType' => 'EntertainmentProgram' ];
		foreach( self::$VIDEO_SETS as $keyword => $videoSet ) {
			$videoParams['keyword'] = $keyword;

			foreach( $videoSet as $value ) {
				$videoParams['videoSet'] = $value;
				$videoParams['isPublishedId'] = ( is_numeric( $value ) );

				$result = $this->ingestVideos( $startDate, $endDate, $videoParams );
				if ( $result === false ) {
					return 0;
				}

				$articlesCreated += $result;
			}
		}

		// Ingest Movie Assets
		$videoParams = [ 'apiType' => 'VideoAssets' ];
		$result = $this->ingestVideosAsset( $startDate, $endDate, $videoParams );
		if ( $result === false ) {
			return 0;
		}

		$articlesCreated += $result;

		return $articlesCreated;
	}

	/**
	 * Ingest videos (for EntertainmentProgram)
	 * @param integer $startDate - Unixtime for beginning of modified-on date range
	 * @param integer $endDate - Unixtime for ending of modified-on date range
	 * @param array $videoParams
	 * @return integer|false $articlesCreated - number of articles created or false
	 */
	protected function ingestVideos( $startDate, $endDate, $videoParams ) {

		$page = 0;
		$articlesCreated = 0;

		do {
			// Get the URL that selects specific video sets based on title matches
			$url = $this->makeSetFeedURL( $videoParams, $startDate, $endDate, $page++ );

			// Retrieve the video data from IVA
			$programs = $this->requestData( $url );
			if ( $programs === false ) {
				return false;
			}

			$numPrograms = count( $programs );
			print( "Found $numPrograms Entertainment Programs...\n" );

			foreach( $programs as $program ) {
				$clipData = $this->getDataFromProgram( $videoParams, $program );
				if ( $clipData === false ) {
					continue;
				}

				$videoAssets = $program['VideoAssets']['results'];
				$numVideos = count( $videoAssets );
				$title =  $this->getTitleFromProgram( $program );
				print( "$title (Series:{$clipData['series']}): ");
				$this->logger->videoFound( $numVideos );

				// add video assets
				foreach ( $videoAssets as $videoAsset ) {
					$clipData = $this->getDataFromAsset( $videoParams, $videoAsset, $clipData );
					if ( $clipData === false ) {
						continue;
					}

					$articlesCreated += $this->createVideo( $clipData );
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

					$result = $this->ingestVideos( $startDate, $endDate, $params );
					if ( $result === false ) {
						return false;
					}

					$articlesCreated += $result;
				}
			}
		} while ( $numPrograms == self::API_PAGE_SIZE );


		return $articlesCreated;
	}


	/**
	 * Ingest videos (for assets)
	 * @param integer $startDate - Unixtime for beginning of modified-on date range
	 * @param integer $endDate - Unixtime for ending of modified-on date range
	 * @param array $videoParams
	 * @return integer|false $articlesCreated - number of articles created or false
	 */
	protected function ingestVideosAsset( $startDate, $endDate, $videoParams ) {

		$page = 0;
		$articlesCreated = 0;

		do {
			// Get the URL that selects specific video sets based on title matches
			$url = $this->makeSetFeedURL( $videoParams, $startDate, $endDate, $page++ );

			// Retrieve the video data from IVA
			$videoAssets = $this->requestData( $url );
			if ( $videoAssets === false ) {
				return false;
			}

			$numVideos = count( $videoAssets );
			$this->logger->videoFound( $numVideos );

			foreach( $videoAssets as $videoAsset ) {
				$clipData = $this->getDataFromProgram( $videoParams, $videoAsset['EntertainmentProgram'] );
				if ( $clipData === false ) {
					continue;
				}

				$videoParams['keyword'] = $clipData['series'];
				$clipData['series'] = '';

				$videoData = $this->getDataFromAsset( $videoParams, $videoAsset, $clipData );
				if ( $videoData === false ) {
					continue;
				}

				$msg = '';
				$articlesCreated += $this->createVideo( $videoData );
				if ( $msg ) {
					print "ERROR: $msg\n";
				}
			}
		} while ( $numVideos == self::API_PAGE_SIZE );


		return $articlesCreated;
	}

	/**
	 * Get clip data from program
	 * @param array $videoParams
	 * @param array $program - EntertainmentProgram data from API
	 * @return array|false $clipdata
	 */
	protected function getDataFromProgram( $videoParams, $program ) {

		$clipData = [];

		$program['title'] = $this->getTitleFromProgram( $program );

		// get series
		$clipData['series'] = empty( $videoParams['series'] ) ? $program['title'] : $videoParams['series'];

		if ( isset( $program['OkToEncodeAndServe'] ) && $program['OkToEncodeAndServe'] == false ) {
			$this->logger->videoSkipped( "Skip: {$clipData['series']} (Publishedid:{$program['Publishedid']}) has OkToEncodeAndServe set to false.\n" );
			return false;
		}

		// skip videos released before our minimum release date
		if ( !empty( $program['FirstReleasedYear'] ) && $program['FirstReleasedYear'] < self::MIN_RELEASE_YEAR ) {
			$msg = "Skip: {$clipData['series']} (Publishedid:{$program['Publishedid']}) release date ";
			$msg .= "{$program['FirstReleasedYear']} before ".self::MIN_RELEASE_YEAR."\n";
			$this->logger->videoSkipped( $msg );
			return false;
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

		$actors = [];
		if ( !empty( $program['ProgramToPerformerMaps']['results'] ) ) {
			foreach( $program['ProgramToPerformerMaps']['results'] as $performer ) {
				$actors[] = trim( $performer['Performer']['FullName'] );
			}
		}
		$clipData['actors'] = implode( ', ', $actors );

		return $clipData;
	}

	/**
	 * Get clip data from asset data
	 *
	 * @param array $videoParams
	 * @param array $videoAsset - asset data from API
	 * @param array|false $clipData
	 *
	 * @return array|bool|false
	 */
	protected function getDataFromAsset( $videoParams, $videoAsset, $clipData ) {

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
			$this->logger->videoSkipped( "Skip: {$clipData['titleName']} (Id:{$clipData['videoId']}) has expiration date.\n" );
			return false;
		}

		$clipData['thumbnail'] = empty( $videoAsset['VideoAssetScreenCapture']['URL'] ) ? '' : $videoAsset['VideoAssetScreenCapture']['URL'];
		$clipData['duration'] = $videoAsset['StreamLengthinseconds'];

		$clipData['published'] = '';
		if ( preg_match('/Date\((\d+)\)/', $videoAsset['DateCreated'], $matches) ) {
			$clipData['published'] = $matches[1]/1000;
		}

		$clipData['type'] = $this->getType( $videoAsset['MediaType']['Media'] );
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
		$keywords = empty( $clipData['name'] ) ? [] : [ $clipData['name'] ];
		if ( !empty( $clipData['series'] ) ) {
			$keywords[] = $clipData['series'];
		}
		if ( !empty( $clipData['category'] ) ) {
			$keywords[] = $clipData['category'];
		}
		if ( !empty( $clipData['tags'] ) ) {
			$keywords[] = $clipData['tags'];
		}
		$clipData['keywords'] = implode( ', ', wfGetUniqueArrayCI( $keywords ) );

		return $clipData;
	}

	/**
	 * Create the feed URL for a specific $videoSet
	 * @param array $videoParams
	 * @param integer $startDate - Unixtime for beginning of modified-on date range
	 * @param integer $endDate - Unixtime for ending of modified-on date range
	 * @param integer $page - The page of results to fetch
	 * @return string $url - A feed URL
	 */
	private function makeSetFeedURL( $videoParams, $startDate, $endDate, $page ) {

		$filter = "(DateModified gt datetime'$startDate') " .
			"and (DateModified le datetime'$endDate') ";

		if ( $videoParams['apiType'] == 'VideoAssets' ) {
			$feedUrl = static::$FEED_URL_ASSET;
			$filter .= "and (MediaId eq ".implode( ' or MediaId eq ', self::$MEDIA_IDS_MOVIE ).") ";
		} else {
			$feedUrl = static::$FEED_URL;

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

			// exclude song and movie
			foreach ( self::$EXCLUDE_MEDIA_IDS as $id ) {
				$filter .= "and (MediaId ne $id) ";
			}
		}

		$expand = $this->getApiExpandFields( $videoParams );

		$url = $this->initFeedUrl( $feedUrl, $filter, $expand, $page );

		return $url;
	}

	/**
	 * Get expand fields for API
	 * @param array $videoParams
	 * @return array $expand - The expand fields to include in the URL to expand the video metadata
	 */
	protected function getApiExpandFields( $videoParams ) {

		if ( $videoParams['apiType'] == 'VideoAssets' ) {
			$expand = [ 'EntertainmentProgram' ];
		} else {
			$expand = [ 'VideoAssets' ];
		}

		foreach ( self::$API_EXPAND_FIELDS as $key => $value ) {
			$expand[] = ( $videoParams['apiType'] == $value ) ? $key : "$value/$key";
		}

		return $expand;
	}

	/**
	 * Construct the URL given a start and end date and the result page to retrieve.
	 * @param string $feedUrl - template url
	 * @param string $filter - The filter to include in the URL to select the correct video metadata
	 * @param array $expand - The expand fields to include in the URL to expand the video metadata
	 * @param integer $page - The page of results to fetch
	 * @return string $url - A feed URL
	 */
	private function initFeedUrl( $feedUrl, $filter, $expand, $page ) {

		$url = str_replace( '$1', self::API_PAGE_SIZE, $feedUrl );
		$url = str_replace( '$2', self::API_PAGE_SIZE * $page, $url );
		$url = str_replace( '$3', urlencode( $filter ), $url );
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

		print( "Connecting to $url...\n" );

		$resp = ExternalHttp::get( $url );
		if ( $resp === false ) {
			$this->logger->videoErrors( "ERROR: problem downloading content.\n" );

			return false;
		}

		// parse response
		$response = json_decode( $resp, true );

		return ( empty($response['d']['results']) ) ? [] : $response['d']['results'];
	}

	/**
	 * Create a list of category names to add to the new file page
	 * @param array $addlCategories
	 * @return array $categories
	 */
	public function generateCategories( array $addlCategories ) {

		$addlCategories[] = $this->getVideoData('name');
		$addlCategories[] = $this->getVideoData('series');
		$addlCategories[] = $this->getVideoData('category');

		// VID-1736 Remove video title from categories
		$titleKey = array_search( $this->videoData['titleName'], $addlCategories );
		if ( $titleKey !== false ) {
			unset( $addlCategories[$titleKey] );
		}

		$addlCategories = array_merge( $addlCategories, $this->getAdditionalPageCategories( $addlCategories ) );

		// add language
		if ( !empty( $this->videoData['language'] ) && !preg_match( "/\benglish\b/i", $this->videoData['language'] ) ) {
			$addlCategories[] = 'International';
			$addlCategories[] = $this->videoData['language'];
		}

		// add subtitle
		if ( !empty( $this->videoData['subtitle'] ) && !preg_match( "/\benglish\b/i", $this->videoData['subtitle'] ) ) {
			$addlCategories[] = 'International';
			$addlCategories[] = $this->videoData['subtitle'];
		}

		$addlCategories[] = 'IVA';

		return preg_replace( '/\s*,\s*/', ' ', wfGetUniqueArrayCI( $addlCategories ) );
	}

	/**
	 * Massage some video metadata and generate URLs to this video's assets
	 * @param boolean $generateUrl
	 */
	protected function prepareMetaDataForOoyala( $generateUrl = true ) {
		$this->metaData['assetTitle'] = $this->metaData['destinationTitle'];
		$this->metaData['duration'] = $this->metaData['duration'] * 1000;
		$this->metaData['published'] = empty( $this->metaData['published'] ) ? '' : strftime( '%Y-%m-%d', $this->metaData['published'] );

		if ( $generateUrl ) {
			$this->metaData['url'] = $this->getRemoteAssetUrls();
		}
	}

	/**
	 * Get list of url for the remote asset
	 * @return array
	 */
	public function getRemoteAssetUrls() {
		$url = str_replace( '$1', F::app()->wg->IvaApiConfig['AppId'], static::$ASSET_URL );
		$url = str_replace( '$2', $this->videoData['videoId'], $url );

		$expired = 1609372800; // 2020-12-31
		$url = str_replace( '$3', $expired, $url );

		$urls = [
			'flash'  => $this->generateHash( $url, self::$ASSET_BITRATE ),
			'iphone' => $this->generateHash( $url, self::$ASSET_BITRATE_MOBILE ),
		];

		return $urls;
	}

	/**
	 * Generate an MD5 hash from the IVA App Key combined with the URL and append to the URL
	 *
	 * @param string $url - The URL to base the hash on
	 * @param $bitrate
	 *
	 * @return string $url - URL including hash value
	 */
	protected function generateHash( $url, $bitrate ) {
		$url = str_replace( '$4', $bitrate, $url );
		$hash = md5( strtolower( F::app()->wg->IvaApiConfig['AppKey'].$url ) );
		$url .= '&h='.$hash;

		return $url;
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

	/**
	 * Get the title of program - Entertainment Program data from API
	 * @param array $program
	 * @return string
	 */
	protected function getTitleFromProgram( array $program ) {
		$title = empty( $program['DisplayTitle'] ) ? $program['Title'] : $program['DisplayTitle'];
		return $this->updateTitle( trim( $title ) );
	}
}
