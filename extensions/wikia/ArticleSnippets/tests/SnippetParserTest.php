<?php

use PHPUnit\Framework\TestCase;

class SnippetParserTest extends TestCase {

	/** @var SnippetParser $parser */
	private $parser;

	protected function setUp() {
		parent::setUp();

		require_once  __DIR__ . '/../ArticleSnippets.php';

		$language = $this->createMock( Language::class );
		$language->expects( $this->any() )
			->method( 'getNsText' )
			->with( NS_TEMPLATE )
			->willReturn( 'Template' );

		$this->parser = new SnippetParser( $language );
	}


	public function testEmptyHtml() {
		$this->assertEquals( "", $this->parser->getSnippet( "" ) );
	}


	public function testOneParagraph() {
		$html = "<p>One paragraph only</p>";
		$this->assertEquals( "One paragraph only", $this->parser->getSnippet( $html ) );
	}


	public function testMultipleParagraphs() {
		$html = "<p>One</p><p>Two</p><p>Three</p>";
		$this->assertEquals( "One Two", $this->parser->getSnippet( $html ) );
	}


	public function testParagraphsInSection() {
		$html = "<h2>Section title</h2><p>One</p><p>Two</p>";
		$this->assertEquals( "One Two", $this->parser->getSnippet( $html ) );
	}


	public function testMultipleSection() {
		$html = "<p>no section p</p><h2>1</h2><p>one</p><h2>2</h2><p>two</p>";
		$this->assertEquals( "no section p one", $this->parser->getSnippet( $html ) );
	}


	public function testListAfterP() {
		$html = "<h2>section name</h2><p>Featured:</p><ul><li>1</li></ul><h2>section two</h2><p>cool text</p>";
		$this->assertEquals( "cool text Featured: 1", $this->parser->getSnippet( $html ) );
	}


	public function testPListOnly() {
		$html = "<p>Featured:</p><ul><li>Me</li><li>Myself</li><li>I</li></ul>";
		$this->assertEquals( "Featured: Me, Myself, I", $this->parser->getSnippet( $html ) );
	}


	public function testListOnly() {
		$html = "<ul><li>Me</li><li>Myself</li><li>I</li></ul>";
		$this->assertEquals( "Me, Myself, I", $this->parser->getSnippet( $html ) );
	}

	public function testInvalidHtmlStripped() {
		$html = "<div>aaa</div>&lt;/div&gt;";
		$this->assertEquals( "aaa", $this->parser->getSnippet( $html ) );
	}

	public function testFullArticle() {
		$this->assertEquals(
			"Sue Richards is in her Hollywood dressing room trying to telephone her husband, from whom she" .
					  " has not heard in many days. She wonders whether something might be wrong, but she dismisses the " .
					  "thought when she hears a knock on the door. She is wanted at the main office, says Tyde, the " .
					  "publicity man for Imperial Studios. When Sue reaches for the doorknob to let Tyde in, it suddenly" .
					  " changes into the Impossible Man, startling her. He is supposed to be out touring the city with" .
					  " Agatha Harkness and Franklin, says Sue angrily. The Impossible Man replies that he got bored," .
					  " and she shouts that she is fed up with him turning up everywhere she looks. Miffed, he turns into " .
					  "a bee and buzzes away. As Tyde enters, Sue calms down, and than they both depart. Reed, meanwhile," .
					  " is at the upstate New York Cynthian Associates research facility trying to telephone Sue. He" .
					  " wonders why he has not heard from her and whether she is partying all over Hollywood. When he " .
					  "receives no answer, he hangs up and returns to the laboratory. One of his co-workers on the " .
					  "\"mystery project,\" Dr. Kaminski, is delighted to be working with \"one of America's most " .
					  "brilliant scientists.\" None of the scientists knows the nature of the project, because they are all" .
					  " working on only one section of it. Other scientists elsewhere are said to be working on different" .
					  " sections. Reed declares that some of the microcircuitry that he has seen has only a limited number" .
					  " of functions, so he has been able to deduce what the project might be. He adds that he does not" .
					  " like it. In another room, the project administrator watches Reed on a monitor, impressed with" .
					  " Reed's deductive faculties. When one of his underlings suggests that Reed is becoming too " .
					  "suspicious, he replies that Reed's scientific curiosity is just what they need to perfect the" .
					  " device that will make him master of the world. Sue is admitted to the Sub-Mariner's office. When " .
					  "she saw him earlier, she thought he was just an actor in makeup, and she is astonished that he is" .
					  " actually the head of the studio. After exchanging pleasantries, Namor confides that he has always" .
					  " thought of her as his friend—he was even in love with her once—but he has left her alone in recent" .
					  " years after she married Reed. Sue says she has never seen him so depressed and lonely, and he " .
					  "replies that, much to his chagrin, all of Atlantis wants to worship and deify him. Ever since his" .
					  " people were liberated from suspended animation and Atlantis was rebuilt, they have hailed him as" .
					  " some kind of god. Cripples have even begged for him to heal them with his touch, he says. He soon" .
					  " came to despise the role that his people unwittingly thrust upon him, and he commanded Lord Vashti" .
					  " to send the crowds away until they regained their senses. Vashti asked him to be more " .
					  "understanding, but Namor replied that they should worship Neptune as their god. Enraged, Namor then" .
					  " hurled his trident, the Scepter of Neptune, through a marble pillar. Then the crowds burst into" .
					  " his chamber, beseeching him to cure their maladies, and he thrust his people away from him and " .
					  "fled. Soon he arrived in New York, where he tried to find Sue. A \"meek postman\" told him she had" .
					  " gone to Hollywood, and when he flew to California, he learned that she was working for the movie " .
					  "studio that he once bought and never sold. When Namor finishes, Sue promises to help him in any way" .
					  " she can. The Human Torch overflies the NASA Space-Command Center looking for Ben and Alicia. " .
					  "He decided to part company with Wyatt Wingfoot and Rebecca Rainbow after beginning to feel like a" .
					  " \"third wheel.\" Suddenly the soldiers, not knowing who he is, open fire, and as Johnny dodges " .
					  "flak, Ben, on the ground below, starts to wreck their artillery. Stanley R. Stanley, the soldier " .
					  "in charge, exhorts his men to keep shooting, saying that this will show Colonel Williams that he " .
					  "can be trusted with power. It does not take long for Ben to deal with the guns and greet his " .
					  "teammate, and he tells Johnny that Alicia had to return east to work on her art. Ben and Johnny " .
					  "walk away, leaving Stanley R. Stanley sputtering about the forms Johnny has to fill out. Sometime" .
					  " later, in Hollywood, Namor supervises Sue as she dons a medieval costume for a role in a " .
					  "swashbuckler movie. Much to the consternation of the film crew, they are suddenly interrupted " .
					  "by a group of six huge androids that burst onto the set looking for Namor. He recognizes them " .
					  "as the Retrievers of Atlantis, and the leader-android declares that Namor's people need him. If" .
					  " he does not return to Atlantis, continues the creature, then they will be forced to take him " .
					  "there themselves, in any manner possible. Namor warns Sue to stand behind him, and she hastily " .
					  "shoves the crew to safety with her force field. Then the closest android attacks Namor with its " .
					  "prehensile arms. Namor states that he will not return to Atlantis as a god, only as the prince " .
					  "of his people. Then he breaks free of the android, and Sue sheds the medieval clothes from over " .
					  "her Fantastic Four uniform and surrounds herself with a protective force field. The leader-android " .
					  "orders Thermatron and Electron, two of the other Retrievers, to dehydrate Namor with heat and " .
					  "shock him with electricity. Invisible, Sue watches them bring Namor down and erects a field around" .
					  " Electron that temporarily short•circuits it. The master Retriever commands Thermatron to " .
					  "incinerate her, but she uses her field to bring a catwalk down on the robot's back. A green " .
					  "Retriever surrounds her with a jelly-like substance, but she expands her force field until the" .
					  " android splatters apart. Recovering quickly from the strain, Sue turns a wall invisible and " .
					  "lures the robot with the prehensile arms into striking it. When the wall shatters, the room " .
					  "floods with water from one of Namor's giant office fishtanks, and Namor's strength returns as " .
					  "the liquid touches him. Using a prop catapult, the invigorated Namur beats back the androids. " .
					  "Then he punches the flying Retriever out of the air, dodging heat and electric blasts from " .
					  "Thermatron and Electron. Sue keeps the others at bay with force-spheres as Namor grapples " .
					  "with the leader. Finally, when the leader calls upon the other androids for assistance, Sue" .
					  " turns Namor invisible. He twists out of the leader's grasp just as Thermatron and Electron " .
					  "open fire. This blows the leader's chest apart, and when it falls, the others suddenly" .
					  " collapse as well, deactivated. Sue explains that she deduced from what Namor told her that the " .
					  "leader-android supplied most of the group's power, since it never battled her or him directly. " .
					  "Lacking energy and the master Retriever's commands, the other Retrievers were rendered inert. " .
					  "Namor commends Sue for her ability, and she offers him a place to stay with Reed and herself if he" .
					  " needs it. But Namor declines, saying that he must, after all, return to his people as their ruler." .
					  " He can no more forsake them than renounce his heritage as a prince of the blood, he says, and he " .
					  "has at last accepted that even a monarch must sometimes be a prisoner. Then Namor flies away, and" .
					  " Sue's eyes fill with tears. She hopes that he eventually finds the peace that he so rightly " .
					  "deserves. Featured Characters: Fantastic Four Mister Fantastic (Reed Richards) Thing (Ben Grimm) " .
					  "Invisible Girl (Susan Richards) Human Torch (Johnny Storm), Mister Fantastic (Reed Richards), " .
					  "Thing (Ben Grimm), Invisible Girl (Susan Richards), Human Torch (Johnny Storm)",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/RegularFullArticle.html" ) )
		);
	}


	public function testFullArticleListsOnly() {
		$this->assertEquals(
			"Featured Characters: Spider-Man (Peter Parker) (Appears in flashback and main story) " .
					  "Supporting Characters: Matt Murdock, Carlie Cooper, Vin Gonzales, Lily Hollister",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/ListsOnlyFullArticle.html" ) )
		);
	}


	public function testInfoboxDataOnly() {
		$this->assertEquals(
			"Panacea The crew finds another treasure but it is guarded by a creature that can only be " .
					  "defeated by feeding it a Lorac Flower (the best cure on Mer for most illnesses). Ren " .
					  "sets off into the swamp guided by creature with a mysterious past given to them by a " .
					  "shady Bio-transmuter. Episode no. 9 Written By Sean Roche Transcript • Other episodes",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/InfoboxOnlyFullArticle.html" ) )
		);
	}


	public function testFigureFirstFullArticle() {
		$this->assertEquals(
			"Capcom Fighting Evolution (Capcom Fighting Jam in Japan and Europe) is a 2004 fighting game " .
					  "featuring groups of characters from five specific Capcom series: Street Fighter II, Street Fighter" .
					  " III, Street Fighter Alpha 3, Darkstalkers, and Red Earth. Four characters from each series are " .
					  "included in addition to a special new fighter, Ingrid. The fights are 2 on 2 (team endurance style)," .
					  " and each character uses his or her super meter bar from the game that they are originally from. " .
					  "The game was first developed as Capcom Fighting All-Stars, but was cancelled.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/FigureFirstFullArticle.html" ) )
		);
	}


	public function testDisplayNoneFullArticle() {
		$this->assertEquals(
			"Bądź szczęśliwa (1974) Miłość niekochana, Nikt nie wie po co ścigasz sen, Panna anna w moich " .
					  "snach, Panny świętojańskie, Kochaj mnie dziewczyno, Bądź szczęśliwa, Dwadzieścia lat, a może mniej, " .
					  "Warszawa jest smutna bez ciebie, Idzie na deszcz, Puste dłonie, Już za krótki dla nas dzień, Dzisiaj " .
					  "w nocy będę z tobą Latawce porwał wiatr (1977) Raz po raz, Latawce porwał wiatr, Kwiaty które ci " .
					  "przyniosłem, Po drugiej stronie mego snu, Pierwszy wiersz, Obrazek z tamtych lat, Na otarcie łez, " .
					  "Babie lato wspomnienie nie na dziś, Taka jaką byłaś ty, Gdzie jest tamta miłość obiecana, Coś o niej",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/DisplayNoneFullArticle.html" ) )
		);
	}


	public function testMainPageArticle() {
		$this->assertEquals(
			"Villains Understanding the concept of villains, Monster Clowns Terrifying your childhood, " .
					  "Big Bads The baddest of the bad guys, Elder Beings Survivors from ancient times",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/MainPageArticle.html" ) )
		);
	}


	public function testFontTagFullArticle() {
		$this->assertEquals(
			"Ingrid was the main antagonist of the first half of the fourth season of ABC's " .
					  "\"Once Upon a Time\". She was the aunt of the hero Elsa and is The Snow Queen. " .
					  "She was portrayed by Elizabeth Mitchell. In Storybrooke, while the power was out, " .
					  "the Snow Queen used her powers to freeze her ice cream without power from a freezer. " .
					  "After giving Robin Hood and Marion ice cream, Marion ended up being cursed by her. " .
					  "In a forest, she was pursued by Emma, Hook, David, and Elsa. She attempted to kill " .
					  "Hook with icicles, but was saved by David.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/FontTagFullArticle.html" ) )
		);
	}


	public function testImageFullArticle() {
		$this->assertEquals(
			"The Constitution-class USS Enterprise. (ENT episode: \"These Are the Voyages...\")",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/ImageFullArticle.html" ) )
		);
	}


	public function testNonObjectFullArticle() {
		$this->assertEquals(
			"Welcome to the History of Magic Classroom Weeks 1-9. All Years. 5th-7th Years are taught here. " .
					  "Years 1-4 are taught by Professor LeClerc. Please contact him here with questions, comments," .
					  " or concerns. OOC: This is a required class to years 1-5.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/NonObjectFullArticle.html" ) )
		);
	}


	public function testDDFirstFullArticle() {
		$this->assertEquals( "Grimm is a television show inspired by Grimm's Fairy Tales that airs on NBC. It is filmed" .
					  " and set in Portland, Oregon. The show was created by Stephen Carpenter, David Greenwalt," .
					  " and Jim Kouf. Greenwalt and Kouf are 2 of the 5 executive producers along with Sean Hayes, " .
					  "Todd Milliner, and Norberto Barba. The show premiered on October 28, 2011 on NBC. Each episode" .
					  " begins with an imposed excerpt usually referencing the theme of the episode. Season 1 began " .
					  "filming with the \"Pilot\" in March 2011, while the rest of the season continued filming in " .
					  "July 2011. Season 1 aired from October 28, 2011 until May 18, 2012 and the season 1 DVD and " .
					  "Blu-ray sets were released on August 7, 2012.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/DDFirstFullArticle.html" ) )
		);
	}


	public function testNotSupportedMarkupOnlyFullArticle() {
		$this->assertEquals(
			"Hai Hai Hai Desho Color Code Ne Ne Ne Dou Suru?",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/NotSupportedMarkupOnlyFullArticle.html" ) )
		);
	}


	public function testTextInFontTagsFullArticle() {
		$this->assertEquals( "Nocte Aqua (tłum. Nocte- Noc; Aqua - Woda) - Nieco humorzasta i nieśmiała smoczyca, należąca " .
					  "do Snowell. Aktualnie zajmuje 7 miejsce w najdłuższych stronach.",
			$this->parser->getSnippet( file_get_contents( __DIR__ .
														  "/resources/TextInFontTagsFullArticle.html" ) ) );
	}


	public function testEmptyListAfterPTagFullArticle() {
		$this->assertEquals(
			"Here is the list of brands on the forum. Some are from other animes and some are self-made " .
					  "(using pictures from other animes) by the characters.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/EmptyListAfterPTagFullArticle.html" ) )
		);
	}


	public function testTablesOnlyFullArticle() {
		$this->assertEquals(
			"VORGESTELLTER ARTIKEL Ariadne Ariadne beobachtet wie Jason den weißen Stein zieht. Sie " .
					  "sitzt zusammen mit ihren Eltern König Minos und Königin Pasiphaë bei Tisch, will jedoch " .
					  "nichts essen. Als ihre Mutter fragt, warum sie nichts essen wolle, meint sie, es wäre" .
					  " grausam, 7 Menschen dem Minotaurus auszuliefern. Sie meint, ihr Vater hätte es mehr " .
					  "verdient. Daraufhin erbost ihre Mutter und ohrfeigt ihre Tochter. Ariadne verschwindet" .
					  " darauf aus dem Raum. Mehr >>",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/TablesOnlyFullArticle.html" ) )
		);
	}


	public function testBracketsFullArticle() {
		$this->assertEquals(
			"Cordelia is a fairly large town on Acualis and is part of [null] We currently have 20 members" .
					  " and is always expanding. The ugly wool tower abomination is going to be torn down and " .
					  "redesigned. Sheep Farm: Has almost all of the sheep colors and is off limits to breed as " .
					  "it causes too much lag in town",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/BracketsFullArticle.html" ) )
		);
	}


	public function testCorrectFontFullArticle() {
		$this->assertEquals(
			"black crystal no Kagayaki (black crystalの輝き) is a soundtrack of the Uta no☆Prince-sama♪ " .
					  "games. Trivia The song BELIEVE☆MY VOICE, by Ichinose Tokiya, is incorporated into " .
					  "the arrangement of this track.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/CorrectFontFullArticle.html" ) )
		);
	}


	public function testArticleWithPortableInfobox() {
		$this->assertEquals( "The Hollow Boy is the title of the third book of the Lockwood& Co. series. It was published " .
					  "on the 15th of September 2015 in the UK and the US. As a supernatural outbreak baffles " .
					  "Scotland Yard and causes protests against the psychic agencies throughout London, " .
					  "Lockwood and Co. continue to demonstrate their effectiveness in exterminating spirits. " .
					  "Anthony is dashing, George insightful, and Lucy dynamic, while the skull in the jar " .
					  "utters sardonic advice from the sidelines.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/ArticleWithPortableInfobox.html" ) ) );
	}


	public function testRedLinkToTemplateArticle() {
		$this->assertEquals(
			"The Hollow Boy is the title of the third book of the Lockwood& Co. series. It was published " .
					  "on the 15th of September 2015 in the UK and the US. As a supernatural outbreak baffles " .
					  "Scotland Yard and causes protests against the psychic agencies throughout London, " .
					  "Lockwood and Co. continue to demonstrate their effectiveness in exterminating spirits. " .
					  "Anthony is dashing, George insightful, and Lucy dynamic, while the skull in the jar " .
					  "utters sardonic advice from the sidelines.",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/RedlinkToTemplateArticle.html" ) )
		);
	}


	public function testPortableInfoboxOnly() {
		$this->assertEquals( "The Hollow Boy - Author: Jonathan Stroud, Date: September 15, 2015, Publisher(s): Random House (UK) " .
					  "Disney-Hyperion (US)", $this->parser->getSnippet( file_get_contents( __DIR__ .
																					  "/resources/PortableInfoboxOnly.html" ) ) );
	}


	public function testPortableInfoboxWithoutTitleOnly() {
		$this->assertEquals( 
			"Author: Jonathan Stroud, Date: September 15, 2015, Publisher(s): Random House (UK) " . "Disney-Hyperion (US)",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/PortableInfoboxWithoutTitleOnly.html" ) )
		);
	}


	public function testManyPortableInfoboxesOnly() {
		$this->assertEquals( 
			"The Hollow Boy - Author: Jonathan Stroud, Date: September 15, 2015, Publisher(s): Random House (UK) " . "Disney-Hyperion (US)",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/PortableInfoboxOnly.html" ) )
		);
	}


	public function testPortableInfoboxSmartGroupsAreSupported() {
		$this->assertEquals( 
			"Die Zeit läuft ab - Originaltitel: Hush, Hush, Sweet Liars, Erstausstrahlung (US): Di 15.03.2016, Erstausstrahlung (DE): Di 24.05.2016, Drehbuch: I. Marlene King, Regie: Ron Lagomarsino, Vorherige: Hast du mich vermisst?, Nächste: Ticktack, ihr Schlampen",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/PortableInfoboxWithSmartGroups.html" ) )
		);
	}


	public function testPortableInfoboxStackedlayout() {
		$this->assertEquals( 
			"Paul Dooley",
			$this->parser->getSnippet( file_get_contents( __DIR__ . "/resources/OnlyPortableInfoboxStackedLayout.html" ) )
		);
	}
}
