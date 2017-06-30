<?php

class SunsetProviderTest extends WikiaBaseTest {
	/** @var User $originalWgUser */
	protected $originalWgUser;

	public function setUp() {
		global $wgUser;

		$this->setupFile = __DIR__ . '/../VideoHandlers/SunsetProvider.php';
		parent::setUp();

		// preserve original $wgUser (script overwrites it)
		$this->originalWgUser = clone $wgUser;
	}

	/**
	 * Restore original $wgUser
	 */
	public function tearDown() {
		global $wgUser;

		parent::tearDown();

		$wgUser = $this->originalWgUser;
	}

	/**
	 * Main unit test for SunsetProvider maintenance script
	 * @dataProvider sunsetProviderDataProvider
	 *
	 * @param bool $isDryRun
	 * @param string $providerName
	 * @param array $providerVideos
	 * @param array $articleData
	 */
	public function testSunsetProvider( bool $isDryRun, string $providerName, array $providerVideos, array $articleData ) {
		$this->setupMocks( $isDryRun, $providerName, $providerVideos, $articleData );

		$sunsetProvider = new SunsetProvider();
		$sunsetProvider->loadParamsAndArgs( SunsetProvider::class, [
			'provider' => $providerName,
			'dry-run' => $isDryRun,
			'quiet' => true,
		] );

		$sunsetProvider->execute();
	}

	/**
	 * @param bool $isDryRun
	 * @param string $providerName
	 * @param array $providerVideoData
	 * @param array $articleData
	 */
	private function setupMocks( bool $isDryRun, string $providerName, array &$providerVideoData, array &$articleData ) {
		$dbMock = $this->getDatabaseMock( [ 'select' ] );
		$wikiPageMock = $this->getMockBuilder( WikiPage::class )
			->disableOriginalConstructor()
			->setMethods( [ 'getText', 'doEdit', 'doDeleteArticleReal' ] )
			->getMock();
		$fileMock = $this->getMockBuilder( File::class )
			->disableOriginalConstructor()
			->setMethods( [ 'isLocal', 'delete' ] )
			->getMock();
		$languageMock = $this->getMock( Language::class, [ 'getNsText', 'getCode' ] );

		// expect script to fetch list of videos from DB
		$dbMock->expects( $this->at( 0 ) )
			->method( 'select' )
			->with( 'video_info', 'video_title', [ 'provider' => $providerName ], 'SunsetProvider::getProviderVideos' )
			->willReturn( new FakeResultWrapper( $providerVideoData ) );

		// expect script to fetch list of articles where videos from provider are embedded from DB
		$dbMock->expects( $this->at( 1 ) )
			->method( 'select' )
			->with(
				[ 'page', 'imagelinks', 'video_info' ],
				[ 'page_title', 'page_namespace', 'GROUP_CONCAT(video_title SEPARATOR "#") as embedded_videos' ],
				[ 'provider' => $providerName, 'page_is_redirect' => 0 ],
				'SunsetProvider::getProviderVideoEmbeds',
				[ 'DISTINCT', 'GROUP BY' => 'page_id' ],
				[
					'imagelinks' => [ 'INNER JOIN', 'page_id = il_from' ],
					'video_info' => [ 'INNER JOIN', 'il_to = video_title' ]
				]
			)
			->willReturn( new FakeResultWrapper( $articleData ) );

		if ( !$isDryRun ) {
			$pagePointer = $filePointer = 0;
			$goodStatus = Status::newGood();

			// expect script to delete all video pages and associated files
			foreach ( $providerVideoData as $video ) {
				$fileMock->expects( $this->at( $filePointer++ ) )
					->method( 'isLocal' )
					->willReturn( true );

				$fileMock->expects( $this->at( $filePointer++ ) )
					->method( 'delete' )
					->with( SunsetProvider::VIDEO_REMOVE_EDIT_SUMMARY )
					->willReturn( $goodStatus );

				$wikiPageMock->expects( $this->at( $pagePointer++ ) )
					->method( 'doDeleteArticleReal' )
					->with( SunsetProvider::VIDEO_REMOVE_EDIT_SUMMARY )
					->willReturn( WikiPage::DELETE_SUCCESS );
			}

			// expect script to get translated and English name of File NS for use in regex
			$languageMock->expects( $this->at( 0 ) )
				->method( 'getNsText' )
				->with( NS_FILE )
				->willReturn( 'File' );

			// expect script to edit all articles embedding video and remove embed code
			foreach ( $articleData as $article ) {
				$wikiPageMock->expects( $this->at( $pagePointer++ ) )
					->method( 'getText' )
					->willReturn( $article->text );

				$wikiPageMock->expects( $this->at( $pagePointer++ ) )
					->method( 'doEdit' )
					->with( $article->expectedText, SunsetProvider::VIDEO_REMOVE_EDIT_SUMMARY, EDIT_MINOR | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT )
					->willReturn( $goodStatus );
			}
		} else {
			// in dry-run mode, script is not expected to make any changes
			$fileMock->expects( $this->never() )
				->method( $this->anything() );

			$wikiPageMock->expects( $this->never() )
				->method( $this->anything() );
		}


		$this->mockGlobalFunction( 'wfGetDB', $dbMock );
		$this->mockGlobalFunction( 'wfFindFile', $fileMock );
		$this->mockClass( WikiPage::class, $wikiPageMock, 'factory' );
		$this->mockClass( Language::class, $languageMock, 'factory' );

		// Wiki content language is Polish
		$this->mockGlobalVariable( 'wgContLang', $this->createConfiguredMock( Language::class, [
			'getCode' => 'pl',
			'getNsText' => 'Plik',
		] ) );

		$this->mockStaticMethod( Hooks::class, 'run', true );
	}

	public function sunsetProviderDataProvider(): array {
		return [
			'dry run' => [
				true,
				'gamestar',
				$this->videoList( [
					'Stachu Jones Mistrz Ciętej Riposty',
					'Hity Polskiego Internetu',
					'STAR WARS Najnowsza część Gwiezdnych Wojen'
				] ),
				[
					$this->article( '[[File:Stachu Jones Mistrz Ciętej Riposty]]', [ 'Stachu Jones Mistrz Ciętej Riposty' ], '' )
				]
			],
			'real run' => [
				false,
				'gamestar',
				$this->videoList( [
					'Stachu Jones Mistrz Ciętej Riposty',
					'Hity Polskiego Internetu',
					'STAR WARS Najnowsza część Gwiezdnych Wojen',
					'STRACHY NA LACHY - Dzień dobry, kocham Cię',
					'Star Citizen - Vorschau-Video Constellation, Freelancer & 300i im Detail',
					'X Rebirth - Fest oder Bugfest? - Das Weltraumspiel in der Analyse - Teil 1'
				] ),
				[
					$this->article( '[[File:Stachu Jones Mistrz Ciętej Riposty]]', [ 'Stachu Jones Mistrz Ciętej Riposty' ], '' ),
					$this->article(
						'Vixi et quem dederat cursum fortuna peregi / Et nunc magna mei sub terras ibit imago [[File:Stachu Jones Mistrz Ciętej Riposty]] / Urbem praeclaram statui, mea moenia vidi',
						[ 'Stachu Jones Mistrz Ciętej Riposty' ],
						'Vixi et quem dederat cursum fortuna peregi / Et nunc magna mei sub terras ibit imago  / Urbem praeclaram statui, mea moenia vidi'
					),
					$this->article(
						'Stachu Jones Mistrz Ciętej Riposty / Et nunc magna mei sub terras ibit imago [[File:Stachu Jones Mistrz Ciętej Riposty]] / Urbem praeclaram statui, mea moenia vidi',
						[ 'Stachu Jones Mistrz Ciętej Riposty' ],
						'Stachu Jones Mistrz Ciętej Riposty / Et nunc magna mei sub terras ibit imago  / Urbem praeclaram statui, mea moenia vidi'
					),
					$this->article(
						'[[File:Stachu Jones Mistrz Ciętej Riposty]] To jest Stachu i [[Plik:Hity Polskiego Internetu|250px|left]] Polska',
						[ 'Stachu Jones Mistrz Ciętej Riposty', 'Hity Polskiego Internetu' ],
						' To jest Stachu i  Polska'
					),
					$this->article(
						'Intro [[File:STAR WARS Najnowsza część Gwiezdnych Wojen|250px|A long time ago, in a galaxy far, far away...]] Content',
						[ 'STAR WARS Najnowsza część Gwiezdnych Wojen' ],
						'Intro  Content'
					),
					$this->article(
						'Intro [[File:STAR WARS Najnowsza część Gwiezdnych Wojen]] Content',
						[ 'STAR WARS Najnowsza część Gwiezdnych Wojen' ],
						'Intro  Content'
					),
					$this->article(
						"Dawaj dawaj\n<gallery>File:Something.png|Text\nHity Polskiego Internetu</gallery>More text[[File:Hity Polskiego Internetu.png|250px]]",
						[ 'Hity Polskiego Internetu' ],
						"Dawaj dawaj\n<gallery>File:Something.png|Text\n</gallery>More text[[File:Hity Polskiego Internetu.png|250px]]"
					),
					$this->article(
						"Test\n<gallery>File:Test.png|Text\nSTRACHY NA LACHY - Dzień dobry kocham Cię\nOther</gallery> [[File:Stachu Jones Mistrz Ciętej Riposty|500px|right]]",
						[ 'Stachu Jones Mistrz Ciętej Riposty', 'STRACHY NA LACHY - Dzień dobry kocham Cię' ],
						"Test\n<gallery>File:Test.png|Text\n\nOther</gallery> "
					),
					$this->article(
						"foo [[File:Star Citizen - Vorschau-Video Constellation, Freelancer & 300i im Detail|thumb|center|335 px]] bar",
						[ 'Star Citizen - Vorschau-Video Constellation, Freelancer & 300i im Detail' ],
						"foo  bar"
					),
					$this->article(
						"foo [[Plik:X Rebirth - Fest oder Bugfest? - Das Weltraumspiel in der Analyse - Teil 1]] bar",
						[ 'X Rebirth - Fest oder Bugfest? - Das Weltraumspiel in der Analyse - Teil 1' ],
						"foo  bar"
					),
				]
			]
		];
	}

	/**
	 * Return a properly formatted list of videos for use in data provider
	 * @param string[] $videos
	 * @return object[]
	 */
	private function videoList( array $videos ): array {
		$res = [];
		foreach ( $videos as $videoTitle ) {
			$res[] = (object)[ 'video_title' => strtr( $videoTitle, ' ', '_' ) ];
		}

		return $res;
	}

	/**
	 * Return a properly formatted article mock data for use in data provider
	 * @param string $text
	 * @param array $videos
	 * @param string $expectedText
	 * @return object
	 */
	private function article( string $text, array $videos, string $expectedText ): stdClass {
		return (object)[
			// mock fields for Title::newFromRow
			'page_title' => 'test',
			'page_namespace' => NS_MAIN,

			'embedded_videos' => strtr( implode( '#', $videos ), ' ', '_' ),
			'text' => $text,
			'expectedText' => $expectedText
		];
	}
}
