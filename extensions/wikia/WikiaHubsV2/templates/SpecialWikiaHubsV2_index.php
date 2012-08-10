<?php $app = F::app(); ?>
<div id="mw-content-text" lang="en" dir="ltr" class="mw-content-ltr">
	<script>var wgWikiaHubType = '<?= htmlspecialchars($wgWikiaHubType); ?>' || '';</script>

	<div class="WikiaGrid WikiaHubs" id="WikiaHubs">
		<section style="margin-bottom:20px" class="grid-3 alpha">
			<?= $app->renderView('SpecialWikiaHubsV2', 'slider', array()); ?>
			<?= $app->renderView('SpecialWikiaHubsV2', 'tabber', array()); ?>
		</section>

		<?= $app->renderView('SpecialWikiaHubsV2', 'pulse', array()); ?>

		<div class="grid-1 wikiahubs-explore plainlinks">
				<h2>
					<span class="mw-headline" id="Games_We.27re_Drooling_Over">Games We're Drooling Over</span>
				</h2>
				<div class="explore-content">
					<h4>
						<span class="mw-headline" id="Comic-Con_2012">Comic-Con 2012</span>
					</h4>
					<p><a  class="text" href="http://hitman.wikia.com/wiki/Main_Page">Hitman: Absolution</a><br /></p>
					<p><a  class="text" href="http://laracroft.wikia.com/wiki/Tomb_Raider_(2013)">Tomb Raider</a><br /></p>
					<p><a  class="text" href="http://fortnite.wikia.com/wiki/Fortnite_Wiki">Fortnite</a><br /></p>
					<p><a  class="text" href="http://injusticegodsamongus.wikia.com/wiki/Injustice:Gods_Among_Us_Wiki">Injustice</a><br /></p>
					<p><a  class="text" href="http://assassinscreed.wikia.com/wiki/Assassin%27s_Creed_Wiki">Assassin's Creed III</a><br /></p>
					<p><a  class="text" href="http://marvelheroes.wikia.com/wiki/Marvel_Heroes_Wiki">Marvel Heroes</a><br /></p>
					<h4>
						<span class="mw-headline" id="Nintendo">Nintendo</span>
					</h4>
					<p><a class="text" href="http://wiiu.wikia.com/wiki/Wii_U_Wiki">Wii U</a><br /></p>
					<p><a class="text" href="http://nintendo.wikia.com/wiki/New_Super_Mario_Bros._U">New Super Mario</a><br /></p>
					<p><a class="text" href="http://nintendo.wikia.com/wiki/Pikmin_3">Pikmin 3</a><br /></p>
					<p><a class="text" href="http://nintendo.wikia.com/wiki/Nintendo_Land">Nintendo Land</a><br /></p>
					<h4>
						<span class="mw-headline" id="Role-Playing_Games">Role-Playing Games</span>
					</h4>
					<p><a class="text" href="http://elderscrolls.wikia.com/wiki/The_Elder_Scrolls_V:_Dawnguard">Skyrim: Dawnguard</a><br /></p>
					<p><a class="text" href="http://southpark.wikia.com/wiki/South_Park:_The_Stick_of_Truth">South Park</a><br /></p>
					<p><a class="text" href="http://fable.wikia.com/wiki/Fable:_The_Journey">Fable: The Journey</a><br /></p>
					<p><a class="text" href="http://elderscrolls.wikia.com/wiki/The_Elder_Scrolls_Wiki/Portal/Online">Elder Scrolls Online</a><br /></p>
					<h4>
						<span class="mw-headline" id="FPS">FPS</span>
					</h4>
					<p><a class="text" href="http://halo.wikia.com/wiki/Halo_4">Halo 4</a><br /></p>
					<p>
						<a class="text" href="http://callofduty.wikia.com/wiki/Portal:Call_of_Duty:_Black_Ops_II">Black Ops II</a><br />
						<a class="text" href="http://borderlands.wikia.com/wiki/Borderlands_2">Borderlands 2</a><br />
					</p>
					<p><a class="text" href="http://medalofhonor.wikia.com/wiki/Medal_of_Honor:_Warfighter">MOH: Warfighter</a><br /></p>
					<p><a class="text" href="http://farcry.wikia.com/wiki/Far_Cry_3">Far Cry 3</a><br /></p>
					<p><a class="text" href="http://deadspace.wikia.com/wiki/Dead_Space_3">Dead Space 3</a><br /></p>
					<p><a class="text" href="http://gearsofwar.wikia.com/wiki/Gears_of_War%3A_Judgment">Gears of War</a><br /></p>
				</div>
		</div>
		<div class="grid-2 alpha" style="float:right">
			<?= $app->renderView('SpecialWikiaHubsV2', 'featuredvideo', array()); ?>
			<?= $app->renderView('SpecialWikiaHubsV2', 'wikitextmodule', array()); ?>
			<?= $app->renderView('SpecialWikiaHubsV2', 'topwikis', array()); ?>
		</div>
		<div class="grid-4 alpha wikiahubs-popular-videos">
			<?= $app->renderView('SpecialWikiaHubsV2', 'popularvideos', array()); ?>
		</div>
		<div class="grid-4 alpha wikiahubs-from-the-community">
			<?= $app->renderView('SpecialWikiaHubsV2', 'fromthecommunity', array()); ?>
		</div>
	</div>
</div>

<div class="RelatedVideos RelatedVideosHidden noprint" id="RelatedVideos" data-count="1">
	<div class="deleteConfirm messageHolder">Are you sure you want to remove this video?</div>
	<div class="removingProcess messageHolder">Please wait wile we are removing the video</div>
	<div class="addVideoTooltip messageHolder">Add a video to this page</div>
	<div class="embedCodeTooltip messageHolder">Paste this URL in the video embed tool</div>
	<div class="errorWhileLoading messageHolder">Error occurred while loading data. Please recheck your connection and refresh the page.</div>
	<div class="RVHeader">
		<div class="tally">
			<em>2</em>
			<span class="fixedwidth">Related Videos</span>
		</div>
		<a class="button addVideo">
			<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="sprite addRelatedVideo" /> Add a video
		</a>
		<a class="beta">beta</a>
		<a class="feedback" target="_blank" href="http://www.surveymonkey.com/s/RelatedVideosExperience">Leave feedback</a>
	</div>
	<div class="RVBody">
		<div class="button vertical secondary scrollleft" >
			<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="chevron" />
		</div>
		<div class="wrapper">
			<div class="container">
				<div class="item">
					<a class="video-thumbnail lightbox" style="height:90px" href="http://www.wikia.com/File:%22Showdown%22" data-ref="File:%22Showdown%22" data-external="0" data-video-name="&quot;Showdown&quot;" >
						<div class="timer">10:01</div>
						<div class="playButton"></div>
						<img class="Wikia-video-thumb" data-src="http://images2.wikia.nocookie.net/__cb20120410132536/video151/images/thumb/1/12/%22Showdown%22/160px-%22Showdown%22.jpg" src="http://images2.wikia.nocookie.net/__cb20120410132536/video151/images/thumb/1/12/%22Showdown%22/160px-%22Showdown%22.jpg" style="margin-top:0px; height:89px; width:160px;" />
					</a>
					<div class="description">"Showdown"</div>
					<div class="info">
						Added by <a class="added-by" data-owner="Hellatainer" href="http://www.wikia.com/User:Hellatainer">Hellatainer</a>
					</div>
					<div class="options">
						<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" />
						<a class="remove" href="#">Remove</a>
					</div>
				</div>
				<div class="item">
					<a class="video-thumbnail lightbox" style="height:90px" href="http://www.wikia.com/File:Dishonored_(VG)_()_-_Debut_trailer" data-ref="File:Dishonored_(VG)_()_-_Debut_trailer" data-external="0" data-video-name="Dishonored (VG) () - Debut trailer" >
						<div class="timer">4:27</div>
						<div class="playButton"></div>
						<img class="Wikia-video-thumb" data-src="http://images2.wikia.nocookie.net/__cb20120525031212/video151/images/thumb/7/7d/Dishonored_%28VG%29_%28%29_-_Debut_trailer/160px-Dishonored_%28VG%29_%28%29_-_Debut_trailer.jpg" src="http://images2.wikia.nocookie.net/__cb20120525031212/video151/images/thumb/7/7d/Dishonored_%28VG%29_%28%29_-_Debut_trailer/160px-Dishonored_%28VG%29_%28%29_-_Debut_trailer.jpg" style="margin-top:0px; height:90px; width:160px;" />
					</a>
					<div class="description">
						Dishonored (VG) () - Debut trailer
					</div>
					<div class="info"></div>
					<div class="options">
						<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" />
						<a class="remove" href="#">Remove</a>
					</div>
				</div>
				<div class="action">
					<a class="video-thumbnail" href="#" >
						<div class="addVideo"></div>
					</a>
				</div>
			</div>
		</div>
		<div class="button vertical secondary left scrollright">
			<img src="data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D" class="chevron" />
		</div>
	</div>
</div>
<script>JSSnippetsStack.push({dependencies:[],getLoaders:function(){return [$.loadFacebookAPI]},callback:function(json){window.onFBloaded(json)},id:"window.onFBloaded"})</script>
<div class="printfooter">
	Retrieved from "<a href="http://www.wikia.com/Video_Games?oldid=11018">http://www.wikia.com/Video_Games?oldid=11018</a>"
</div>