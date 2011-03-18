<section class="module">
	<h1 ><?= wfMsg( 'tor-module-title' ) ;?></h1>
	<div id="ToRModuleTweetsList" class="tweet"></div>
</section>

<script type="text/javascript">/*<![CDATA[*/
	wgAfterContentAndJS.push(function() {
		$( function() {
			if(!window.TwitterOnRailsData) {
				window.TwitterOnRailsData = {};
				TwitterOnRailsData.keywords = "<?= $keywords; ?>";
				TwitterOnRailsData.limit = <?= $limit; ?>;
				TwitterOnRailsData.refreshInterval = <?= $refreshInterval; ?>;
				TwitterOnRailsData.userName = null;
			}
			$("#ToRModuleTweetsList").tweet({
				avatar_size: 32,
				count: TwitterOnRailsData.limit,
				query: TwitterOnRailsData.keywords,
				username: TwitterOnRailsData.userName,
				loading_text: "<?= wfMsg( 'tor-module-loading-text' ) ;?>",
				refresh_interval: TwitterOnRailsData.refreshInterval
			});
			//}
		});
	});
/*]]>*/</script>