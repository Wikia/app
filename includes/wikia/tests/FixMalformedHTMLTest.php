<?php

class FixMalformedHTMLTest extends WikiaBaseTest {

	/**
	 * @dataProvider validWikiaHTMLDataProvider
	 */
	function testValidHTMLIsNotChanged($testCaseName, $text) {
		$this->assertEquals( $text, str_replace( "\n", "", wfFixMalformedHTML( $text ) ), $testCaseName );
	}

	function validWikiaHTMLDataProvider() {
		return [
			[
				'simplest text',
				'<p>simplest</p>'
			],
			[
				'paragraph with some formatting',
				'<p><b>some formatting</b> and a <a class="external text" href="http://www.wikia.com">Wikia</a> link</p>'
			],
			[
				'sevaral paragraphs',
				'<p>several</p><p>paragraphs</p><p><br></p><p>test</p>'
			],
			[
				'image markup',
				'<figure class="thumb tright thumbinner" style="width:182px;"><a href="http://static.mech.wikia-dev.com/800wi.gif" class="image"><img alt="800wi" src="http://static.mech.wikia-dev.com/800wi.gif" width="180" height="176" class="thumbimage"></a><a href="/wiki/File:800wi.gif" class="internal sprite details magnify" title="Enlarge"></a><figcaption class="thumbcaption"><div class="picture-attribution"><img src="http://static.mech.wikia-dev.com/20px-4807210.png" width="16" class="avatar">Added by <a href="/wiki/User:QATest">QATest</a></div></figcaption></figure>'
			],
			[
				'video makrup',
				'<div class="floatright"><a href="/wiki/File:Surprise_BJJ_attack_-_submission_from_underneath_side_control-0" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject" class="video image lightbox"><div class="Wikia-video-play-button" style="line-height:218px;width:335px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"></div><img alt="" src="http://static.mech.wikia-dev.com/Surprise_BJJ_attack.jpg" width="335" height="188" itemprop="thumbnail" class="Wikia-video-thumb" style="border-top: 15px solid black; border-bottom: 15px solid black;"><span class="info-overlay" style="width: 335px;"><span class="info-overlay-title" style="max-width:275px;" itemprop="name">Surprise BJJ attack - submission from underneath side control-0</span><meta itemprop="duration" content="PT02M40S"><span class="info-overlay-duration" itemprop="duration">(02:40)</span><br><span class="info-overlay-views">0 views</span><meta itemprop="interactionCount" content="UserPlays:0"></span></a></div>'
			],
		];
	}

	/**
	 * @dataProvider malformedHTMLDataProvider
	 */
	function testMalformedHTML($testCaseName, $text, $expected) {
		$this->assertEquals( $expected, str_replace( "\n", "", wfFixMalformedHTML( $text ) ), $testCaseName );

	}

	function malformedHTMLDataProvider() {
		return [
			[
				'html snippet shouldn\'t close tags it did not open',
				'<table><tr><td></td></tr></table></div>',
				'<table><tr><td></td></tr></table>'
			],
			[
				'html snippet should close wrapping tags it opened',
				'<div><table><tr><td></td></tr></table>',
				'<div><table><tr><td></td></tr></table></div>'
			],
			[
				'auto-closing nested tags',
				'<table><tr><td><div>Test</td></tr></table>',
				'<table><tr><td><div>Test</div></td></tr></table>'
			]
		];
	}

}
