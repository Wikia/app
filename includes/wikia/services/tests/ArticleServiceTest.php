<?php

class ArticleServiceTest extends WikiaBaseTest {
	const TEST_CITY_ID = 79860;

	public function setUp() {
		parent::setUp();
	}

	/**
	 * @dataProvider getTextSnippetDataProvider
	 * @param $snippetLength maximum length of text snippet to be pulled
	 * @param $rawArticleText raw text of article to be snippeted
	 * @param $expSnippetText expected output text snippet
	 */
	public function testGetTextSnippetTest($snippetLength, $articleText, $expSnippetText) {
		$randId = (int) ( rand() * microtime() );
		$mockTitle = $this->getMock( 'Title' );
		$mockCache = $this->getMock( 'MemCachedClientforWiki', array( 'get', 'set' ), array( array() ) );
		$mockPage = $this->getMock( 'WikiPage', array( 'getParserOutput', 'makeParserOptions' ), array( $mockTitle ) );
		$mockOutput = $this->getMock( 'OutputPage', array( 'getText' ), array() );
		$mockArticle = $this->getMock( 'Article', array( 'getPage', 'getID' ), array( $mockTitle ) );

		$mockCache->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( null ) );

		$mockCache->expects( $this->any() )
			->method( 'set' )
			->will( $this->returnValue( null ) );

		$this->mockGlobalVariable( 'wgMemc', $mockCache );

		$mockOutput->expects( $this->any() )
			->method( 'getText' )
			->will( $this->returnValue( $articleText ) );

		$mockPage->expects( $this->any() )
			->method( 'getParserOutput' )
			->will( $this->returnValue( $mockOutput ) );

		$mockPage->expects( $this->any() )
			->method( 'makeParserOptions' )
			->will( $this->returnValue( new ParserOptions() ) );

		$mockArticle->expects( $this->any() )
			->method( 'getPage' )
			->will( $this->returnValue( $mockPage ) );

		$mockArticle->expects( $this->any() )
			->method( 'getText' )
			->will( $this->returnValue( $articleText ) );

		$mockArticle->expects( $this->any() )
			->method( 'getID' )
			->will( $this->returnValue( $randId ) );

		$this->mockApp();

		$service = new ArticleService( $mockArticle );
		$snippet = $service->getTextSnippet( $snippetLength );
		$this->assertEquals( $expSnippetText, $snippet );
	}

	public function getTextSnippetDataProvider() {
		/**
		 * @todo: add more test sets
		 */
		$article1 = <<<TEXT
<p>
</p>
<table class="infobox" style="width: 20em; text-align: left; font-size: 95%;">
<tr>
<td style="text-align: center; background: #9400D3;" colspan="2">
</td></tr>
<tr>
<td style="text-align: center; background: #9400D3; color: #ffffff; font-size: 110%;" colspan="2"> <b>Rachel Berry</b>
</td></tr>
<tr>
<td colspan="2" style="text-align:center;"> <a href="http://images.federico.wikia-dev.com/__cb20120607181661/glee/images/b/bc/Rachel_Berry.png" class="image" data-image-name="Rachel Berry.png"><img alt="Rachel Berry.png" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="250" height="366" data-src="http://images.federico.wikia-dev.com/__cb20120607181661/glee/images/thumb/b/bc/Rachel_Berry.png/250px-Rachel_Berry.png" class="lzy lzyPlcHld" onload="if(typeof ImgLzy==&quot;object&quot;){ImgLzy.load(this)}" /><noscript><img alt="Rachel Berry.png" src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" width="250" height="366" data-src="http://images.federico.wikia-dev.com/__cb20120607181661/glee/images/thumb/b/bc/Rachel_Berry.png/250px-Rachel_Berry.png" class="lzy lzyPlcHld" onload="if(typeof ImgLzy==&quot;object&quot;){ImgLzy.load(this)}" /><noscript><img alt="Rachel Berry.png" src="http://images.federico.wikia-dev.com/__cb20120607181661/glee/images/thumb/b/bc/Rachel_Berry.png/250px-Rachel_Berry.png" width="250" height="366" /></noscript></noscript></a>
</td></tr>
<tr>
<td style="text-align: center; background: #DEDDE2; font-size: 95%;" colspan="2"> <b>General Information</b>
</td></tr>
<tr valign="top">
<th> Gender:
</th><td> Female
</td></tr>
<tr valign="top">
<th> Age:
</th><td> 18
</td></tr>
<tr valign="top">
<th> Hair Color:
</th><td> Dark Brown
</td></tr>
<tr valign="top">
<th> Eye Color:
</th><td> Brown
</td></tr>
<tr valign="top">
<th> Birthday:
</th><td> December 18, 1994
</td></tr>
<tr valign="top">
<th> Height:
</th><td> 5'3"
</td></tr>
<tr valign="top">
<th> Address:
</th><td> 241 Birch Hill Road <br /> Lima, Ohio
</td></tr>
<tr valign="top">
<th> Occupation(s):
</th><td> Student at <a href="http://glee.federico.wikia-dev.com/wiki/New_York_Academy_of_the_Dramatic_Arts" title="New York Academy of the Dramatic Arts">New York Academy of the Dramatic Arts</a> <br /> Former Student at <a href="http://glee.federico.wikia-dev.com/wiki/William_McKinley_High_School" title="William McKinley High School">William McKinley High School</a> <br /> Former <a href="http://glee.federico.wikia-dev.com/wiki/New_Directions" title="New Directions">New Directions</a> Member
</td></tr>
<tr valign="top">
<th> Aliases:
</th><td> A-Rach, Babe, Janet, Kim Kardashian, Beacon of Light, Big Gold Star, Miss Hudson-Berry, Needy Girl Drunk (<a href="http://glee.federico.wikia-dev.com/wiki/Finn_Hudson" title="Finn Hudson">Finn</a>)<br />Yentl (<a href="http://glee.federico.wikia-dev.com/wiki/Dakota_Stanley" title="Dakota Stanley">Dakota Stanley</a>, <a href="http://glee.federico.wikia-dev.com/wiki/Santana_Lopez" title="Santana Lopez">Santana</a> and <br /><a href="http://glee.federico.wikia-dev.com/wiki/Becky" title="Becky" class="mw-redirect">Becky</a>) <br />RuPaul, Man Hands, That Thing, Sweetie, Stubbles, Treasure Trail, Rachel what's-her-name,Tiny Jewish Teenager (<a href="http://glee.federico.wikia-dev.com/wiki/Quinn_Fabray" title="Quinn Fabray">Quinn</a>)<br />Britney, Eva Peron, Hot Mama, Miss Bossy Pants, Babe, That Skinny Garanimal-Wearing-Ass-Kisser (<a href="http://glee.federico.wikia-dev.com/wiki/Mercedes_Jones" title="Mercedes Jones">Mercedes</a>)<br />Benedict Arnold, Princess, Juliet, Doll (<a href="http://glee.federico.wikia-dev.com/wiki/Kurt_Hummel" title="Kurt Hummel">Kurt</a>)<br />Barbra Streisand (<a href="http://glee.federico.wikia-dev.com/wiki/Suzy_Pepper" title="Suzy Pepper">Suzy Pepper</a>)<br />That Brunette (<a href="http://glee.federico.wikia-dev.com/wiki/Josh_Groban" title="Josh Groban">Josh Groban</a>) <br />Dwarf, Diane Warren, Midget, Hobbit, Gayberry, Selfish-Self-centered-Lame-ass Wannabe Diva From Hell (<a href="http://glee.federico.wikia-dev.com/wiki/Santana_Lopez" title="Santana Lopez">Santana</a>)<br />Michele, Young Lady, Mrs. Focker (<a href="http://glee.federico.wikia-dev.com/wiki/Sue_Sylvester" title="Sue Sylvester">Sue Sylvester</a>)<br />Miss Sally Bowles (<a href="http://glee.federico.wikia-dev.com/wiki/Sandy_Ryerson" title="Sandy Ryerson">Sandy Ryerson</a>)<br />Cookie, Sister (<a href="http://glee.federico.wikia-dev.com/wiki/April_Rhodes" title="April Rhodes">April Rhodes</a>)<br />My Best Singer (<a href="http://glee.federico.wikia-dev.com/wiki/Mr._Schue" title="Mr. Schue" class="mw-redirect">Mr. Schue</a>)<br />Sweetie (<a href="http://glee.federico.wikia-dev.com/wiki/Terri_Schuester" title="Terri Schuester">Terri</a>)<br />Total Trout Mouth (<a href="http://glee.federico.wikia-dev.com/wiki/Artie_Abrams" title="Artie Abrams">Artie</a>)<br /> Boy Hips (<a href="http://glee.federico.wikia-dev.com/wiki/Lauren_Zizes" title="Lauren Zizes">Lauren</a>)<br />Hot Stuff (<a href="http://glee.federico.wikia-dev.com/wiki/Holly_Holliday" title="Holly Holliday">Holly Holliday</a>)<br />A Cat Getting Its Temperature Taken (<a href="http://glee.federico.wikia-dev.com/wiki/Brittany_Pierce" title="Brittany Pierce">Brittany</a>)<br />My Hot Little Jewish American Princess (<a href="http://glee.federico.wikia-dev.com/wiki/Noah_Puckerman" title="Noah Puckerman">Puck</a>)<br />Rachelah, Baby Girl
<p>(<a href="http://glee.federico.wikia-dev.com/wiki/Hiram_Berry" title="Hiram Berry">Hiram Berry</a>)<br />Young Barbra Streisand (<a href="http://glee.federico.wikia-dev.com/wiki/Sebastian_Smythe" title="Sebastian Smythe">Sebastian</a>)
</p>
</td></tr>
<tr>
<td style="text-align: center; background: #DEDDE2; font-size: 95%;" colspan="2"> <b>Family &amp; Friends</b>
</td></tr>
<tr valign="top">
<th> Family:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/Shelby_Corcoran" title="Shelby Corcoran">Shelby Corcoran</a> (mother)<br /><a href="http://glee.federico.wikia-dev.com/wiki/Hiram_Berry" title="Hiram Berry">Hiram Berry</a> (father)<br /><a href="http://glee.federico.wikia-dev.com/wiki/LeRoy_Berry" title="LeRoy Berry">LeRoy Berry</a> (father)<br /><a href="http://glee.federico.wikia-dev.com/wiki/Beth_Corcoran" title="Beth Corcoran">Beth Corcoran</a> (adoptive sister)<br />Leon (cousin)
</td></tr>
<tr valign="top">
<th> Relationships:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/Finn_Hudson" title="Finn Hudson">Finn Hudson</a> (ex-fiancee, in love with, on hold)<br /><a href="http://glee.federico.wikia-dev.com/wiki/Noah_Puckerman" title="Noah Puckerman">Noah Puckerman</a> (ex-boyfriend, make-out sessions)<br /><a href="http://glee.federico.wikia-dev.com/wiki/Jesse_St._James" title="Jesse St. James">Jesse St. James</a> (ex-boyfriend)<br /><a href="http://glee.federico.wikia-dev.com/wiki/Blaine_Anderson" title="Blaine Anderson">Blaine Anderson</a> (kissed; one date, ended)<br /><a href="http://glee.federico.wikia-dev.com/wiki/Jacob_Ben_Israel" title="Jacob Ben Israel">Jacob Ben Israel</a> (former crusher)
</td></tr>
<tr valign="top">
<th> Friends:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/Quinn_Fabray" title="Quinn Fabray">Quinn Fabray</a> <br /><a href="http://glee.federico.wikia-dev.com/wiki/Finn_Hudson" title="Finn Hudson">Finn Hudson</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Kurt_Hummel" title="Kurt Hummel">Kurt Hummel</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Blaine_Anderson" title="Blaine Anderson">Blaine Anderson</a> <br /><a href="http://glee.federico.wikia-dev.com/wiki/Noah_Puckerman" title="Noah Puckerman">Noah Puckerman</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Mercedes_Jones" title="Mercedes Jones">Mercedes Jones</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Rory_Flanagan" title="Rory Flanagan">Rory Flanagan</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Matt_Rutherford" title="Matt Rutherford">Matt Rutherford</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Brittany_Pierce" title="Brittany Pierce">Brittany Pierce</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Tina_Cohen-Chang" title="Tina Cohen-Chang">Tina Cohen-Chang</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Artie_Abrams" title="Artie Abrams">Artie Abrams</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Mike_Chang" title="Mike Chang">Mike Chang</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Sam_Evans" title="Sam Evans">Sam Evans</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Santana_Lopez" title="Santana Lopez">Santana Lopez</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Sunshine_Corazon" title="Sunshine Corazon">Sunshine Corazon</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Sugar_Motta" title="Sugar Motta">Sugar Motta</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Joe_Hart" title="Joe Hart">Joe Hart</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Lauren_Zizes" title="Lauren Zizes">Lauren Zizes</a>
</td></tr>
<tr valign="top">
<th> Enemies:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/Vocal_Adrenaline" title="Vocal Adrenaline">Vocal Adrenaline</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Harmony" title="Harmony">Harmony</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Sandy_Ryerson" title="Sandy Ryerson">Sandy Ryerson</a><br /><a href="http://glee.federico.wikia-dev.com/wiki/Jacob_Ben_Israel" title="Jacob Ben Israel">Jacob Ben Israel</a><br /> <a href="http://glee.federico.wikia-dev.com/wiki/Sebastian_Smythe" title="Sebastian Smythe">Sebastian Smythe</a> (possibly former)
<p><a href="http://glee.federico.wikia-dev.com/wiki/Suzy_Pepper" title="Suzy Pepper">Suzy Pepper</a>
</p>
</td></tr>
<tr>
<td style="text-align: center; background: #DEDDE2; font-size: 95%;" colspan="2"> <b>Other Information</b>
</td></tr>
<tr valign="top">
<th> Interests:
</th><td> Broadway<br />Performing Arts<br />Singing, Solos
</td></tr>
<tr valign="top">
<th> Clique:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/New_Directions" title="New Directions">New Directions</a>
</td></tr>
<tr valign="top">
<th> Education:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/William_McKinley_High_School" title="William McKinley High School">William McKinley High School</a>, <a href="http://glee.federico.wikia-dev.com/wiki/NYADA" title="NYADA" class="mw-redirect">NYADA</a> (New York Academy of Dramatic Arts)
</td></tr>
<tr valign="top">
<th> Talent:
</th><td> Singing<br />Ballet<br />Acting<br />Performing Arts
</td></tr>
<tr valign="top">
<th> Vulnerabilities:
</th><td> Criticism, Not Getting Solos, Choking Auditions
</td></tr>
<tr valign="top">
<th> Strengths:
</th><td> Her voice<br />Vocal range<br />Leadership<br />Solos<br />Dancing<br />Powerful ballads<br />Ballads<br />Broadway performances<br />Comforting others
</td></tr>
<tr valign="top">
<th> Weaknesses:
</th><td> Jealousy towards people with talent that intimidate her<br />Breakups<br />Self-esteem<br />Giving up solos<br />Not having her dreams come true
</td></tr>
<tr valign="top">
<th> Awards:
</th><td> MVP<br />(Regionals, Season 2)<br />2012 WMHS Prom Queen
</td></tr>
<tr>
<td style="text-align: center; background: #DEDDE2; font-size: 95%;" colspan="2"> <b>Series Information</b>
</td></tr>
<tr valign="top">
<th> First appearance:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/Pilot" title="Pilot">Pilot</a>
</td></tr>
<tr valign="top">
<th> Portrayer:
</th><td> <a href="http://glee.federico.wikia-dev.com/wiki/Lea_Michele" title="Lea Michele">Lea Michele</a><br />Lauren Boles (Toddler Rachel)<br /><a href="http://glee.federico.wikia-dev.com/wiki/Tina_Cohen-Chang" title="Tina Cohen-Chang">Tina Cohen-Chang</a> (<a href="http://glee.federico.wikia-dev.com/wiki/Tina%27s_Dream" title="Tina's Dream">Tina's Dream</a>)
</td></tr></table>
<p><b>Rachel Barbra Berry</b> is a main character of <i><a href="http://glee.federico.wikia-dev.com/wiki/Glee" title="Glee" class="mw-redirect">Glee</a></i>. She is currently a student at <a href="http://glee.federico.wikia-dev.com/wiki/NYADA" title="NYADA" class="mw-redirect">NYADA</a>, run by dean <a href="http://glee.federico.wikia-dev.com/wiki/Carmen_Tibideaux" title="Carmen Tibideaux">Carmen Tibideaux</a>. She is an alumni of <a href="http://glee.federico.wikia-dev.com/wiki/William_McKinley_High_School" title="William McKinley High School">William McKinley High School</a> as of the <a href="http://glee.federico.wikia-dev.com/wiki/Season_3" title="Season 3" class="mw-redirect">Season Three</a> graduation episode, <a href="http://glee.federico.wikia-dev.com/wiki/Goodbye" title="Goodbye">Goodbye</a>. She had been the co-captain of <a href="http://glee.federico.wikia-dev.com/wiki/New_Directions" title="New Directions">New Directions</a> along with <a href="http://glee.federico.wikia-dev.com/wiki/Finn_Hudson" title="Finn Hudson">Finn Hudson</a> ever since <a href="http://glee.federico.wikia-dev.com/wiki/Mattress" title="Mattress">Mattress</a>. She was one of the three major self-proclaimed divas of the club: the others being two of her best friends; <a href="http://glee.federico.wikia-dev.com/wiki/Mercedes_Jones" title="Mercedes Jones">Mercedes Jones</a> and <a href="http://glee.federico.wikia-dev.com/wiki/Kurt_Hummel" title="Kurt Hummel">Kurt Hummel</a>.
TEXT;

$article2 = <<<TEXT
<center><a href="http://images.federico.wikia-dev.com/__cb20120303182953/glee/images/d/de/Group.png" class="image" data-image-name="Group.png"><img alt="Group.png" src="http://images.federico.wikia-dev.com/__cb20120303182953/glee/images/d/de/Group.png" width="662" height="219" /></a></center>
<div class="main-page-tag-lcs grid-4 alpha main-page-tag-lcs-exploded" ><div>
<div class="WikiaPhotoGalleryPreview">
	<div class="wikiaPhotoGallery-slider-body" id="wikiaPhotoGallery-slider-body-0" style="display: none">
		<div class="horizontal" >
			<ul>
			<li class="wikiaPhotoGallery-slider-0" id="wikiaPhotoGallery-slider-0-0"><a href='http://glee.wikia.com/wiki/Season_Four'>					<img width='660' height='360'  src='http://images.federico.wikia-dev.com/__cb247/glee/images/thumb/5/56/Glee-title-card.png/660px-0%2C676%2C0%2C369-Glee-title-card.png' class='wikiaPhotoGallery-slider'>
					</a>					<div class="description-background"></div>
					<div class="description">
					<h2>Next On Glee:</h2>
					<p>Learn about Next Season:<br>Season Four</p>
<p>												<a href='http://glee.wikia.com/wiki/Season_Four' class='wikia-button secondary'>
								<span> Read more ></span>
							</a>
</p>
											</div>
					<p class='nav'>
						<img width='90' height='70' src='http://images.federico.wikia-dev.com/__cb484/glee/images/thumb/5/56/Glee-title-card.png/90px-95%2C585%2C0%2C380-Glee-title-card.png'>
					</p>
				</li>
			<li class="wikiaPhotoGallery-slider-1" id="wikiaPhotoGallery-slider-0-1"><a href='http://glee.wikia.com/wiki/Goodbye'>					<img width='660' height='360'  src='http://images.federico.wikia-dev.com/__cb308/glee/images/thumb/a/a6/GoodbyeSlider.png/660px-0%2C661%2C0%2C360-GoodbyeSlider.png' class='wikiaPhotoGallery-slider'>
					</a>					<div class="description-background"></div>
					<div class="description">
					<h2>Recently On Glee:</h2>
					<p>Learn about Last Ep:<br>Goodbye</p>
<p>												<a href='http://glee.wikia.com/wiki/Goodbye' class='wikia-button secondary'>
								<span> Read more ></span>
							</a>
</p>
											</div>
					<p class='nav'>
						<img width='90' height='70' src='http://images.federico.wikia-dev.com/__cb471/glee/images/thumb/a/a6/GoodbyeSlider.png/90px-100%2C564%2C0%2C360-GoodbyeSlider.png'>
					</p>
				</li>
			<li class="wikiaPhotoGallery-slider-2" id="wikiaPhotoGallery-slider-0-2"><a href='http://glee.wikia.com/wiki/Tina-Mike_Relationship'>					<img width='660' height='360'  src='http://images.federico.wikia-dev.com/__cb323/glee/images/thumb/f/fc/Love3.png/660px-0%2C661%2C0%2C360-Love3.png' class='wikiaPhotoGallery-slider'>
					</a>					<div class="description-background"></div>
					<div class="description">
					<h2>Featured Relationship</h2>
					<p>Learn about the featured relationship:<br>Tike!</p>
<p>												<a href='http://glee.wikia.com/wiki/Tina-Mike_Relationship' class='wikia-button secondary'>
								<span> Read more ></span>
							</a>
</p>
											</div>
					<p class='nav'>
						<img width='90' height='70' src='http://images.federico.wikia-dev.com/__cb528/glee/images/thumb/f/fc/Love3.png/90px-87%2C541%2C0%2C352-Love3.png'>
					</p>
				</li>
						</ul>
		</div>
	</div>
</div><script>JSSnippetsStack.push({dependencies:["/extensions/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.slidertag.css","/extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.slider.js"],callback:function(json){WikiaPhotoGallerySlider.init(json)},id:"WikiaPhotoGallerySlider.init",options:[0]})</script><script>JSSnippetsStack.push({dependencies:["/extensions/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.view.js"],callback:function(json){WikiaPhotoGalleryView.init(json)},id:"WikiaPhotoGalleryView.init"})</script>
<p><br />
</p>
<center><a href="http://images.federico.wikia-dev.com/__cb20120303165161/glee/images/1/18/Wttgw.png" class="image" data-image-name="Wttgw.png"><img alt="Wttgw.png" src="http://images.federico.wikia-dev.com/__cb20120303165161/glee/images/1/18/Wttgw.png" width="660" height="82" /></a><br />2,021,323 edits | 1,192 articles | 1,248 active users</center>
<p><br /><br />
TEXT;
		return array(
			array( // article is empty
				100,
				'',
				''
			),
			array( // article is plain text
				100,
				'This is the test line',
				'This is the test line',
			),
			array( // article is very long
				10,
				'This is the test line that is very long and should be cut off at some point to avoid generating too long snippets',
				'This is...',
			),
			array(//length is too short
				2,
				'abc def ghi',
				''
			),
			array( // example real article 1 - Rachel_Berry (glee)
				100,
				$article1,
				'Rachel Barbra Berry is a main character of Glee. She is currently a student at NYADA, run by dean...',
			),
			array( // example real article 2 - Glee_TV_Show_Wiki (glee)
				100,
				$article2,
				'Learn about Next Season:Season Four Read more > Learn about Last Ep:Goodbye Read more > Learn...',
			)
		);
	}


}
