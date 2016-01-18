<?php

class NodeHeroImageSanitizerTest extends WikiaBaseTest {
	private $sanitizer;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../../PortableInfobox.setup.php';

		$this->sanitizer = SanitizerBuilder::createFromType('hero-mobile');
		parent::setUp();
	}

	/**
	 * @param $data
	 * @param $expected
	 * @dataProvider testSanitizeDataProvider
	 */
	function testSanitize( $data, $expected ) {
		$this->assertEquals(
			$expected,
			$this->sanitizer->sanitize( $data )
		);
	}

	function testSanitizeDataProvider() {
		return [
			[
				[ 'title' => [ 'value' => 'Test Title' ] ],
				[ 'title' => [ 'value' => 'Test Title' ] ]
			],
			[
				[ 'title' => [ 'value' => 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example' ] ] ,
				[ 'title' => [ 'value' => 'Real world title example' ] ]
			],
			[
				[ 'title' => [ 'value' => 'Test <a>Title with</a> <span><small>small</small></span> tag, span tag and <img src="sfefes"/>tag' ] ],
				[ 'title' => [ 'value' => 'Test <a>Title with</a> small tag, span tag and tag' ] ]
			],
			[
				[ 'title' => [ 'value' => '<a href="http://vignette-poz.wikia-dev.com//images/9/95/All_Stats_%2B2.png/revision/latest?cb=20151222111955" 	class="image image-thumbnail"><img src="abc" alt="All Stats +2" class="thumbimage" /></a>' ] ],
				[ 'title' => [ 'value' => '' ] ],
			],
			[
				[ 'title' => [ 'value' => '<figure class="article-thumb tright show-info-icon" style="width: 335px"> 	<a 	href="http://mediawiki119.marzjan.wikia-dev.com/wiki/File:AMERICA%27S_TEST_KITCHEN_SEASON_9" 	class="video video-thumbnail image lightbox medium " 	 	 itemprop=\'video\' itemscope itemtype="http://schema.org/VideoObject" 	><img src="http://vignette-poz.wikia-dev.com//images/6/6e/AMERICA%27S_TEST_KITCHEN_SEASON_9/revision/latest/scale-to-width-down/335?cb=20130904003328" 	 alt="AMERICA&#039;S TEST KITCHEN SEASON 9"  	class="thumbimage " 	 	data-video-key="AMERICA&#039;S_TEST_KITCHEN_SEASON_9" 	data-video-name="AMERICA&#039;S TEST KITCHEN SEASON 9" 	 	 width="335"  	 height="187"  	 itemprop="thumbnail"  	 	 	><span class="duration" itemprop="duration">01:00</span><span class="play-circle"></span><meta itemprop="duration" content="PT01M00S"></a>  	<figcaption> 		 			<a href="/wiki/File:AMERICA%27S_TEST_KITCHEN_SEASON_9" class="sprite info-icon"></a> 		 		 			<p class="title">AMERICA&#039;S TEST KITCHEN SEASON 9</p> 		 		 	</figcaption> </figure>' ] ],
				[ 'title' => [ 'value' => 'AMERICA&#039;S TEST KITCHEN SEASON 9' ] ]
			],
			[
				[ 'title' => [ 'value' => '<sup id="cite_ref-0" class="reference"><a href="#cite_note-0">[1]</a></sup>' ] ],
				[ 'title' => [ 'value' => '<sup id="cite_ref-0" class="reference"><a href="#cite_note-0">[1]</a></sup>' ] ]
			],
			[
				[ 'title' => [ 'value' => '<script>JSSnippetsStack.push({dependencies:[{"url":"http://i3.marzjan.wikia-dev.com/__am/1451462348/group/-/wikia_photo_gallery_js","type":"js"},{"url":"http://i2.marzjan.wikia-dev.com/__am/1451462348/sass/background-dynamic%3D1%26background-image%3D%26background-image-height%3D1185%26background-image-width%3D1600%26color-body%3D%2523bacdd8%26color-body-middle%3D%2523bacdd8%26color-buttons%3D%2523006cb0%26color-header%3D%25233a5766%26color-links%3D%2523006cb0%26color-page%3D%2523ffffff%26oasisTypography%3D1%26page-opacity%3D100%26widthType%3D0/extensions/wikia/WikiaPhotoGallery/css/gallery.scss","type":"css"}],callback:function(json){WikiaPhotoGalleryView.init(json)},id:"WikiaPhotoGalleryView.init"})</script>' ] ],
				[ 'title' => [ 'value' => '' ] ]
			],
			[
				[ 'title' => [ 'value' => '<ul><li>1
</li><li>2
</li><li>3
</li></ul>' ] ],
				[ 'title' => [ 'value' => '1 2 3' ] ]
			],
			[
				[ 'title' => [ 'value' => '<ol><li>1
</li><li>2
<ol><li>2.1
</li></ol>
</li></ol>' ] ],
				[ 'title' => [ 'value' => '1 2 2.1' ] ]
			],
			[
				[ 'title' => [ 'value' => 'Próxima' ] ],
				[ 'title' => [ 'value' => 'Próxima' ] ]
			],
			[
				[ 'title' => [ 'value' => 'Música de' ] ],
				[ 'title' => [ 'value' => 'Música de' ] ]
			],
			[
				[ 'title' => [ 'value' => 'A <b>Kuruma</b> in <i><a href="/wiki/Grand_Theft_Auto_Online" title="Grand Theft Auto Online">Grand Theft Auto Online</a></i>.' ] ],
				[ 'title' => [ 'value' => 'A Kuruma in <a href="/wiki/Grand_Theft_Auto_Online" title="Grand Theft Auto Online">Grand Theft Auto Online</a>.' ] ]
			],
			[
				[ 'title' => [ 'value' => '<a href="/wiki/User:Idradm" class="new" title="User:Idradm (page does not exist)">Idradm</a> (<a href="/wiki/User_talk:Idradm" title="User talk:Idradm (page does not exist)">talk</a>) 15:34, January 4, 2016 (UTC)' ] ],
				[ 'title' => [ 'value' => '<a href="/wiki/User:Idradm" class="new" title="User:Idradm (page does not exist)">Idradm</a> (<a href="/wiki/User_talk:Idradm" title="User talk:Idradm (page does not exist)">talk</a>) 15:34, January 4, 2016 (UTC)' ] ]
			],
			[
				[ 'image' => [ 'caption' => 'Test Title' ] ],
				[ 'image' => [ 'caption' => 'Test Title' ] ]
			],
			[
				[ 'image' => [ 'caption' => 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example' ] ] ,
				[ 'image' => [ 'caption' => 'Real world title example' ] ]
			],
			[
				[ 'image' => [ 'caption' => 'Test <a>Title with</a> <span><small>small</small></span> tag, span tag and <img src="sfefes"/>tag' ] ],
				[ 'image' => [ 'caption' => 'Test <a>Title with</a> small tag, span tag and tag' ] ]
			],
			[
				[ 'image' => [ 'caption' => '<a href="http://vignette-poz.wikia-dev.com//images/9/95/All_Stats_%2B2.png/revision/latest?cb=20151222111955" 	class="image image-thumbnail"><img src="abc" alt="All Stats +2" class="thumbimage" /></a>' ] ],
				[ 'image' => [ 'caption' => '' ] ],
			],
			[
				[ 'image' => [ 'caption' => '<figure class="article-thumb tright show-info-icon" style="width: 335px"> 	<a 	href="http://mediawiki119.marzjan.wikia-dev.com/wiki/File:AMERICA%27S_TEST_KITCHEN_SEASON_9" 	class="video video-thumbnail image lightbox medium " 	 	 itemprop=\'video\' itemscope itemtype="http://schema.org/VideoObject" 	><img src="http://vignette-poz.wikia-dev.com//images/6/6e/AMERICA%27S_TEST_KITCHEN_SEASON_9/revision/latest/scale-to-width-down/335?cb=20130904003328" 	 alt="AMERICA&#039;S TEST KITCHEN SEASON 9"  	class="thumbimage " 	 	data-video-key="AMERICA&#039;S_TEST_KITCHEN_SEASON_9" 	data-video-name="AMERICA&#039;S TEST KITCHEN SEASON 9" 	 	 width="335"  	 height="187"  	 itemprop="thumbnail"  	 	 	><span class="duration" itemprop="duration">01:00</span><span class="play-circle"></span><meta itemprop="duration" content="PT01M00S"></a>  	<figcaption> 		 			<a href="/wiki/File:AMERICA%27S_TEST_KITCHEN_SEASON_9" class="sprite info-icon"></a> 		 		 			<p class="title">AMERICA&#039;S TEST KITCHEN SEASON 9</p> 		 		 	</figcaption> </figure>' ] ],
				[ 'image' => [ 'caption' => 'AMERICA&#039;S TEST KITCHEN SEASON 9' ] ]
			],
			[
				[ 'image' => [ 'caption' => '<sup id="cite_ref-0" class="reference"><a href="#cite_note-0">[1]</a></sup>' ] ],
				[ 'image' => [ 'caption' => '<sup id="cite_ref-0" class="reference"><a href="#cite_note-0">[1]</a></sup>' ] ]
			],
			[
				[ 'image' => [ 'caption' => '<script>JSSnippetsStack.push({dependencies:[{"url":"http://i3.marzjan.wikia-dev.com/__am/1451462348/group/-/wikia_photo_gallery_js","type":"js"},{"url":"http://i2.marzjan.wikia-dev.com/__am/1451462348/sass/background-dynamic%3D1%26background-image%3D%26background-image-height%3D1185%26background-image-width%3D1600%26color-body%3D%2523bacdd8%26color-body-middle%3D%2523bacdd8%26color-buttons%3D%2523006cb0%26color-header%3D%25233a5766%26color-links%3D%2523006cb0%26color-page%3D%2523ffffff%26oasisTypography%3D1%26page-opacity%3D100%26widthType%3D0/extensions/wikia/WikiaPhotoGallery/css/gallery.scss","type":"css"}],callback:function(json){WikiaPhotoGalleryView.init(json)},id:"WikiaPhotoGalleryView.init"})</script>' ] ],
				[ 'image' => [ 'caption' => '' ] ]
			],
			[
				[ 'image' => [ 'caption' => '<ul><li>1</li><li>2</li><li>3</li></ul>' ] ],
				[ 'image' => [ 'caption' => '1 2 3' ] ]
			],
			[
				[ 'image' => [ 'caption' => '<ol><li>1</li><li>2<ol><li>2.1</li></ol></li></ol>' ] ],
				[ 'image' => [ 'caption' => '1 2 2.1' ] ]
			],
			[
				[ 'image' => [ 'caption' => 'Próxima' ] ],
				[ 'image' => [ 'caption' => 'Próxima' ] ]
			],
			[
				[ 'image' => [ 'caption' => 'Música de' ] ],
				[ 'image' => [ 'caption' => 'Música de' ] ]
			],
			[
				[ 'image' => [ 'caption' => 'A <b>Kuruma</b> in <i><a href="/wiki/Grand_Theft_Auto_Online" title="Grand Theft Auto Online">Grand Theft Auto Online</a></i>.' ] ],
				[ 'image' => [ 'caption' => 'A Kuruma in <a href="/wiki/Grand_Theft_Auto_Online" title="Grand Theft Auto Online">Grand Theft Auto Online</a>.' ] ]
			],
			[
				[ 'image' => [ 'caption' => '<a href="/wiki/User:Idradm" class="new" title="User:Idradm (page does not exist)">Idradm</a> (<a href="/wiki/User_talk:Idradm" title="User talk:Idradm (page does not exist)">talk</a>) 15:34, January 4, 2016 (UTC)' ] ],
				[ 'image' => [ 'caption' => '<a href="/wiki/User:Idradm" class="new" title="User:Idradm (page does not exist)">Idradm</a> (<a href="/wiki/User_talk:Idradm" title="User talk:Idradm (page does not exist)">talk</a>) 15:34, January 4, 2016 (UTC)' ] ]
			]
		];
		
	}
}

