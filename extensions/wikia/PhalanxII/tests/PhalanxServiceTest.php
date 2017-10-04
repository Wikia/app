<?php

use Wikia\DependencyInjection\Injector;

/**
 * @category Wikia
 * @group Integration
 */
class PhalanxServiceTest extends WikiaBaseTest {

	/* @var PhalanxService */
	private $service;

	public function setUp() {
		$this->setupFile =  __DIR__ . '/../Phalanx_setup.php';
		parent::setUp();

		$this->service = Injector::getInjector()->get( PhalanxService::class );
		if ( !$this->service->status() ) {
			// Skip test if phalanx service is not available
			$this->markTestSkipped( "Can't connect to phalanx service" );
		}
	}

	public function testPhalanxServiceCheck() {
		$ret = $this->service->check( "content", "hello world" );
		$this->assertEquals( $ret, 1 );

		$ret = $this->service->check( "invalid type", "hello world" );
		$this->assertEquals( $ret, false );

		$ret = $this->service->check( "content", "pornhub.com" );
		$this->assertEquals( $ret, 0 );
	}


	public function testPhalanxServiceMatch() {
		$ret = $this->service->match( "content", "hello" );
		$this->assertEquals( 0, $ret );


		$ret = $this->service->match( "content", "pornhub.com" );
		$val = is_integer( $ret->id ) && $ret->id > 1;
		$this->assertEquals( true, $val, "pornhub.com should be matched as spam content" );

		$ok_content = "{{Unofficial name|Croatian|German|Greek|Portuguese}}

{{CardTable2
|dename = Visionsheld Increase
|crname = Vizijski HEROJ Uspon
|grname = Ήρωας Όραμα Αύξηση
|ptname = Herói da Visão Aumentar
|ja_name = {{Ruby|Ｖ・ＨＥＲＯ|ヴィジョンヒーロー}} インクリース
|phon = Vijon Hīrō Inkurīsu
|image = VisionHEROIncrease-JP-Manga-GX.jpg
|attribute = ???
|type = ???
|type2 = Effect
|level = 3
|atk = 900
|effect = Trigger, Ignition
|def = 1100
|mangalore = When you've taken [[damage]], you may move this card from your [[Graveyard]] to your [[Spell & Trap Card Zone|Trap Zone]]. By [[Tribute|sacrificing]] one \"[[Vision HERO]]\", you can [[Special Summon]] this card from your Trap Zone and Special Summon one \"[[HERO]]\" from your [[Main Deck|deck]].
|jpmangalore = 自分がダメージを受けた時墓地から{{Ruby|罠|トラップ}}ゾーンにおける<br />[[Vision HERO|{{Ruby|Ｖ・ＨＥＲＯ|ヴィジョン・ヒーロー}}]]１体を生贄で{{Ruby|罠|トラップ}}ゾーンから特殊召喚できデッキから{{Ruby|ＨＥＲＯ|ヒーロー}}１体を特殊召喚する
|manga_gx = 051, 052, 053, 058
|action1 = Goes to S/T Zone
|action2 = Tributes for cost
|archetype1 = Vision HERO
|archetype2 = HERO
|archetype3 = V (anime)
|archsupport1 = Vision HERO
|archsupport2 = HERO
|mst1 = Treated as Continuous Spell Card
|summon1 = Special Summons itself from your Spell & Trap Card Zone
|summon2 = Special Summons from your Deck
}}
";

		$ret = $this->service->match( "content", $ok_content );
		$this->assertEquals( 0, $ret, "nothing should match $ok_content" );
	}

	public function testPhalanxServiceValidate() {
		$ret = $this->service->validate( '^alamakota$' );
		$this->assertEquals( 1, $ret, "Valid regex" );

		$ret = $this->service->validate( '^alama(((kota$' );
		$this->assertEquals( 0, $ret, "Invalid regex" );

	}
}
