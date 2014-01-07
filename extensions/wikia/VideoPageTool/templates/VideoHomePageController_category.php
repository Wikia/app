<? /* @var $assets array */ ?>

<br /><br />

<h2><?= wfMessage( 'videohomepage-latest-videos-header' ) ?></h2>

<div class="latest-videos-wrapper"></div>

<script type="text/template" id="carousel-wrapper">
	<h2>{{displayTitle}}</h2>
	<div class="category-carousel"></div>
</script>

<script type="text/template" id="thumb-wrapper">
	{{{videoThumb}}}
	<p>{{videoTitle}}</p>
</script>

<script type="text/javascript">





	var Wikia = Wikia || {};
	Wikia.videoHomePage = Wikia.videoHomePage || {};

	//Wikia.videoHomePage.categoryData = </*?= json_encode( $assets ) ?*/>;

	Wikia.videoHomePage.categoryData = [
		{
			displayTitle: 'Fun Videos',
			thumbnails: [
				{
					videoTitle: 'The Hobbit Peter Jackson and Philippa Boyens Interview - Comic-Con 2012',
					videoThumb: '<a href="/wiki/File:The_Hobbit_Peter_Jackson_and_Philippa_Boyens_Interview_-_Comic-Con_2012" class="video wikia-video-thumbnail xsmall video "itemprop=&#039;video&#039; itemscope=&#039;&#039; itemtype=&#039;http://schema.org/VideoObject&#039; ><span class="play-circle"></span><span class="play-arrow"></span><img src="http://images.liz.wikia-dev.com/__cb20131127233541/sktest123/images/thumb/e/e0/Garden_1080.png/180px-Garden_1080.png"	data-video-key="The_Hobbit_Peter_Jackson_and_Philippa_Boyens_Interview_-_Comic-Con_2012"data-video-name="The+Hobbit+Peter+Jackson+and+Philippa+Boyens+Interview+-+Comic-Con+2012" alt=&#039;&#039; itemprop=&#039;thumbnail&#039; ><span class="duration" itemprop=&#039;duration&#039; >02:31</span><meta itemprop="duration" content="PT02M31S"></a>'
				},
				{
					videoTitle: 'Mystery Men - crash mansion',
					videoThumb: '<a href="/wiki/File:Mystery_Men_-_crash_mansion" class="video wikia-video-thumbnail xsmall video " itemprop=&#039;video&#039; itemscope=&#039;&#039; itemtype=&#039;http://schema.org/VideoObject&#039; > <span class="play-circle"></span> <span class="play-arrow"></span> <img src="http://images.liz.wikia-dev.com/__cb20131221002743/sktest123/images/thumb/f/f7/Adminpage.jpeg/180px-Adminpage.jpeg" data-video-key="Mystery_Men_-_crash_mansion" data-video-name="Mystery+Men+-+crash+mansion" alt=&#039;&#039; itemprop=&#039;thumbnail&#039; > <span class="duration" itemprop=&#039;duration&#039; >00:49</span> <meta itemprop="duration" content="PT00M49S"></a>'
				}
			]
		},
		{
			displayTitle: 'More Fun Videos',
			thumbnails: [
				{
					videoTitle: 'The Hobbit Peter Jackson and Philippa Boyens Interview - Comic-Con 2012',
					videoThumb: '<a href="/wiki/File:The_Hobbit_Peter_Jackson_and_Philippa_Boyens_Interview_-_Comic-Con_2012" class="video wikia-video-thumbnail xsmall video "itemprop=&#039;video&#039; itemscope=&#039;&#039; itemtype=&#039;http://schema.org/VideoObject&#039; ><span class="play-circle"></span><span class="play-arrow"></span><img src="http://images.liz.wikia-dev.com/__cb20131127233541/sktest123/images/thumb/e/e0/Garden_1080.png/180px-Garden_1080.png"	data-video-key="The_Hobbit_Peter_Jackson_and_Philippa_Boyens_Interview_-_Comic-Con_2012"data-video-name="The+Hobbit+Peter+Jackson+and+Philippa+Boyens+Interview+-+Comic-Con+2012" alt=&#039;&#039; itemprop=&#039;thumbnail&#039; ><span class="duration" itemprop=&#039;duration&#039; >02:31</span><meta itemprop="duration" content="PT02M31S"></a>'
				},
				{
					videoTitle: 'Mystery Men - crash mansion',
					videoThumb: '<a href="/wiki/File:Mystery_Men_-_crash_mansion" class="video wikia-video-thumbnail xsmall video " itemprop=&#039;video&#039; itemscope=&#039;&#039; itemtype=&#039;http://schema.org/VideoObject&#039; > <span class="play-circle"></span> <span class="play-arrow"></span> <img src="http://images.liz.wikia-dev.com/__cb20131221002743/sktest123/images/thumb/f/f7/Adminpage.jpeg/180px-Adminpage.jpeg" data-video-key="Mystery_Men_-_crash_mansion" data-video-name="Mystery+Men+-+crash+mansion" alt=&#039;&#039; itemprop=&#039;thumbnail&#039; > <span class="duration" itemprop=&#039;duration&#039; >00:49</span> <meta itemprop="duration" content="PT00M49S"></a>'
				}
			]
		},
		{
			displayTitle: 'These videos are just okay',
			thumbnails: [
				{
					videoTitle: 'The Hobbit Peter Jackson and Philippa Boyens Interview - Comic-Con 2012',
					videoThumb: '<a href="/wiki/File:The_Hobbit_Peter_Jackson_and_Philippa_Boyens_Interview_-_Comic-Con_2012" class="video wikia-video-thumbnail xsmall video "itemprop=&#039;video&#039; itemscope=&#039;&#039; itemtype=&#039;http://schema.org/VideoObject&#039; ><span class="play-circle"></span><span class="play-arrow"></span><img src="http://images.liz.wikia-dev.com/__cb20131127233541/sktest123/images/thumb/e/e0/Garden_1080.png/180px-Garden_1080.png"	data-video-key="The_Hobbit_Peter_Jackson_and_Philippa_Boyens_Interview_-_Comic-Con_2012"data-video-name="The+Hobbit+Peter+Jackson+and+Philippa+Boyens+Interview+-+Comic-Con+2012" alt=&#039;&#039; itemprop=&#039;thumbnail&#039; ><span class="duration" itemprop=&#039;duration&#039; >02:31</span><meta itemprop="duration" content="PT02M31S"></a>'
				},
				{
					videoTitle: 'Mystery Men - crash mansion',
					videoThumb: '<a href="/wiki/File:Mystery_Men_-_crash_mansion" class="video wikia-video-thumbnail xsmall video " itemprop=&#039;video&#039; itemscope=&#039;&#039; itemtype=&#039;http://schema.org/VideoObject&#039; > <span class="play-circle"></span> <span class="play-arrow"></span> <img src="http://images.liz.wikia-dev.com/__cb20131221002743/sktest123/images/thumb/f/f7/Adminpage.jpeg/180px-Adminpage.jpeg" data-video-key="Mystery_Men_-_crash_mansion" data-video-name="Mystery+Men+-+crash+mansion" alt=&#039;&#039; itemprop=&#039;thumbnail&#039; > <span class="duration" itemprop=&#039;duration&#039; >00:49</span> <meta itemprop="duration" content="PT00M49S"></a>'
				}
			]
		}

	];




</script>

<? /*foreach ( $assets as $videoData ): ?>
	<?= $videoData[ 'videoThumb' ] ?>
<? endforeach;*/ ?>
