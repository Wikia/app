<?= $header ?>
<script>
	window.androidUrl = "<?= $androidUrl ?>";
	window.iosUrl = "<?= $iosUrl ?>";
</script>
<style>
.background-image-gradient{display:none;}
.appPromo{
	background-color:#<?= $config->action_bar_color; ?>;
}
</style>
<?= $debug ?>


<?php

	foreach($trendingArticles as $topArticle){
		print "<img src='{$topArticle["imgUrl"]}' title='{$topArticle["title"]}' width='{$topArticle["width"]}' height='{$topArticle["height"]}'/>\n";
	}

?>






<!-- TODO: REMOVE EVERYTHING BELOW HERE!! -->
<style>
ul.tempList{
	list-style:disc;
	padding-left:50px;
}
.tempList li{
	color:#000;
	padding:10px;
}
.tempList li.done{
	text-decoration:line-through;
	color:#333;
}
</style>
<div style='clear:both'></div>
Sub-tasks:
<ul class='tempList'>
	<li class='done'>Get the Community_App URL to not be an article, instead to be commandeered by our extension</li>
	<li class='done'>Get the page to display with the Wikia-header only, and our standard other page infrastructure, in a clean way.</li>
	<li class='done'>Pull the configs from the app-config service & memcache them.</li>
	<li class='done'>Get a single wiki's app config from the big config.</li>
	<li class='done'>Build android & ios appstore links from the app's config</li>
	<li class='done'>Have the site automatically redirect android devices to the androidurl and iOS devices to the ios url</li>
	<li class='done'>Get background images from API e.g. http://www.fallout.wikia.com/api/v1/Articles/Top?expand=1&limit=30</li>
	<li class='done'>Set page BG color from $config->action_bar_color</li>
	<li>Create grid with background images from trending articles API</li>
	<li>Put a semi-transparent mask obscuring all images (they're BACKGROUND afterall).</li>
	<li>Integrate the screenshots from S3</li>
	<li>i18n'ed back button, linking to homepage</li>
	<li>i18n'ed description</li>
	<li>i18n'ed Call-To-Action with text color: $config->action_bar_color</li>
	<li>Branch.io widget:
		<ul>
			<li>Input field... typing a phone number into it causes "GET" button to appear</li>
			<li>Get it working: https://dev.branch.io/features/text-me-the-app/advanced/</li>
			<li>We can probably polish/customize the branch.io interaction a bunch.</li>
		</ul>
	</li>
	<li>Add store-badge images with links to $androidUrl and $iosUrl</li>
	<li>Put the screenshots behind a Fastly bucket.</li>
	<li>Translation config files & translation requests</li>
</ul>
