<?php

class FixMalformedHTMLTest extends WikiaBaseTest {

	/**
	 * Testing if wfFixMalformedHTML does not modify valid HTML snippet
	 * we use at Wikia.
	 *
	 * @param string $testCaseName description of the testcase data
	 * @param string $html valid html snippet
	 * @dataProvider validWikiaHTMLDataProvider
	 */
	function testValidHTMLIsNotChanged($testCaseName, $html) {
		$this->assertEquals( $html, str_replace( "\n", "", wfFixMalformedHTML( $html ) ), $testCaseName );
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
				'video markup',
				'<div class="floatright"><a href="/wiki/File:Surprise_BJJ_attack_-_submission_from_underneath_side_control-0" itemprop="video" itemscope="" itemtype="http://schema.org/VideoObject" class="video image lightbox"><div class="Wikia-video-play-button" style="line-height:218px;width:335px;"><img class="sprite play " src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D"></div><img alt="" src="http://static.mech.wikia-dev.com/Surprise_BJJ_attack.jpg" width="335" height="188" itemprop="thumbnail" class="Wikia-video-thumb" style="border-top: 15px solid black; border-bottom: 15px solid black;"><span class="info-overlay" style="width: 335px;"><span class="info-overlay-title" style="max-width:275px;" itemprop="name">Surprise BJJ attack - submission from underneath side control-0</span><meta itemprop="duration" content="PT02M40S"><span class="info-overlay-duration" itemprop="duration">(02:40)</span><br><span class="info-overlay-views">0 views</span><meta itemprop="interactionCount" content="UserPlays:0"></span></a></div>'
			],
		];
	}

	/**
	 * Checking if wfFixMalformedHTML can deal with unclosed tags, so we don't break
	 * the whole page inserting an HTML snippet (like an article comment)
	 *
	 * @param string $testCaseName description of the testcase data
	 * @param string $html HTML snippet with some unmatched tags
	 * @param string $expected fixed HTML markup we're expecting to get
	 * @dataProvider malformedHTMLDataProvider
	 */
	function testMalformedHTML($testCaseName, $html, $expected) {
		$this->assertEquals( $expected, str_replace( "\n", "", wfFixMalformedHTML( $html ) ), $testCaseName );

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
			],
			[
				'html5 fugure, figurecaption tags',
				'<figure><img src="http://example.com/1.jpg"><figcaption>Added</figcaption></figure> asdasd',
				'<figure><img src="http://example.com/1.jpg"><figcaption>Added</figcaption></figure> asdasd'
			]
		];
	}

	/**
	 * Checking if wfFixMalformedHTML can deal with Russian Text
	 *
	 * @param string $testCaseName description of the testcase data
	 * @param string $html HTML snippet with some Russian text, or Russian text with unmatched tags
	 * @param string $expected fixed HTML markup we're expecting to get
	 * @dataProvider russianTextDataProvider
	 */
	function testRussianText($testCaseName, $html, $expected) {
		$this->assertEquals( $expected, str_replace( "\n", "", wfFixMalformedHTML( $html ) ), $testCaseName );

	}

	function russianTextDataProvider() {
		return [
			[
				'Russian text should be handled properly (ie, not returned as garbage)',
				'Ед дуо малйж факилиз. Йн лорэм видырэр жкрибэнтур ыюм. Мэль альяквюам пырикюлёз ан, аугюэ аккюсам номинави ед жят. Вэл эи унюм емпэтюсъ инзтруктеор, эи модо конгуы дикырыт дуо',
                '<p>Ед дуо малйж факилиз. Йн лорэм видырэр жкрибэнтур ыюм. Мэль альяквюам пырикюлёз ан, аугюэ аккюсам номинави ед жят. Вэл эи унюм емпэтюсъ инзтруктеор, эи модо конгуы дикырыт дуо</p>'
			],
			[
				'html snippet should close wrapping tags it opened, even with Russian text',
				'<div><table><tr><td>Йн векж дэтракто эррорибуз продыжщэт, дуо ут мёнём дэфянятйоныс. Квюандо луптатум чадипжкёнг но вяш, путынт вэрыар зэнтынтиаэ эю вяш, ючю ат дольорэ апэриам. Экз еюж ельлюд ёудёкабет форынчйбюж, прё тальэ квюандо апэриам эю, ат квуй лаудым аюдирэ жкряпшэрит. Эрюдитя льаборэж ку дуо. Эю пэр путынт фиэрэнт оффекйяж, ыт конжюль омниюм долорюм квуй. Шэа квуым выльёт майыжтатйж эи, ут партйэндо лаборамюз квюо.</td><td>Црял аликвюип дежпютатионй еюж йн, эи видишчы констятюам мэль. Аюдирэ промпта льабятюр вим ад, мовэт вэрыар дыфяниэбаж эа кюм. Нам эюрйпйдяч хонэзтатёз ку, мацим плььатонэм ыкжпэтэндяз экз квуй, прима дэчырюёжжэ мэя йн. Ёудико хомэро экз мэль, ку вяш нонюмэш фачтидёе.</td></tr></table>',
                '<div><table><tr><td>Йн векж дэтракто эррорибуз продыжщэт, дуо ут мёнём дэфянятйоныс. Квюандо луптатум чадипжкёнг но вяш, путынт вэрыар зэнтынтиаэ эю вяш, ючю ат дольорэ апэриам. Экз еюж ельлюд ёудёкабет форынчйбюж, прё тальэ квюандо апэриам эю, ат квуй лаудым аюдирэ жкряпшэрит. Эрюдитя льаборэж ку дуо. Эю пэр путынт фиэрэнт оффекйяж, ыт конжюль омниюм долорюм квуй. Шэа квуым выльёт майыжтатйж эи, ут партйэндо лаборамюз квюо.</td><td>Црял аликвюип дежпютатионй еюж йн, эи видишчы констятюам мэль. Аюдирэ промпта льабятюр вим ад, мовэт вэрыар дыфяниэбаж эа кюм. Нам эюрйпйдяч хонэзтатёз ку, мацим плььатонэм ыкжпэтэндяз экз квуй, прима дэчырюёжжэ мэя йн. Ёудико хомэро экз мэль, ку вяш нонюмэш фачтидёе.</td></tr></table></div>'
			]

		];
	}

}
