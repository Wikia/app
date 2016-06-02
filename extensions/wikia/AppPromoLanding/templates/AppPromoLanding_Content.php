<?= $header ?>
<script>
	window.androidUrl = "<?= $androidUrl ?>";
	window.iosUrl = "<?= $iosUrl ?>";
	window.branchKey = "<?= $branchKey ?>";
</script>
<style>
.background-image-gradient{display:none;}
.appPromo, body.appPromo{
	background-color:#fff !important; /* lower specificity than skin-specific coloring, so we have to make it important */
	font-family: "Helvetica Neue",Arial,sans-serif !important;
}
body.appPromo, body.appPromo::before, body.appPromo::after{
	background-image:none !important;
}
.entireAppPromo{/* Gets the whole page to center-align even when it is wider than the browser */
	position: absolute;
    left: 50%;
    margin-left: -<?php
	// Half the width (971.5px to start)
	//print ((($numThumbsPerRow * ($thumbWidth+$imgSpacing)) - ($thumbWidth/2))/2);
	
	// Peter Galletta wanted 925px instead (because the content is at a specific width of 2 blocks in, which doesn't leave the good bits centered in the 11 thumbs per row)
	print "925";
	?>px;
}
.thumbsWrapper{
	position:relative;
}
.thumbRow{
	overflow:hidden;
	white-space:nowrap;
	height: <?= $thumbHeight ?>px;
	margin-left:-<?= round($thumbWidth / 2) ?>px;
	margin-bottom:1px;
}
.thumbRow .imageWrapper{
	display:inline-block;
	position:relative;
	margin-right:1px;
	height: <?= $thumbHeight ?>px;
	background-color:#404040;
}
.thumbRow .imageWrapper img{
	position:absolute;
	top:0;
	left:0;
}
<?php
// This is the overlay which makes the image grid slightly faded out ?>
.thumbRow .imageWrapper::before{
  content:'';
  z-index: 2;
  display: inline-block;
  position: relative;
  height: <?= $thumbHeight ?>px;
  width: <?= $thumbHeight ?>px;
  top: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.5);
}
.topContent{
	z-index: 3;
}
.topContent *{
	z-index: 3;
}
.pitchOuter{
	width: 374.2px;
	height: <?= $thumbWidth ?>px;
	background-color: #<?= $config->action_bar_color ?>;/*#275ba3;*/
	position:absolute;
	top: <?= $thumbHeight + $imgSpacing ?>px;
	left: <?= ($thumbWidth * 1.5) + ($imgSpacing * 2); ?>px;
}
.pitchInner{
	width: 299px;
	height: 140.6px;
	margin:24px 0 0 12px;
	text-align:right;
	font-family: "HelveticaNeue-Thin", "Helvetica Neue", Arial,sans-serif;
	font-size: 30px;
	line-height: 1.5;
	color: #ffffff;
}
.branchIoOuter{
	position:absolute;
	width:<?= (($thumbWidth + $imgSpacing) * 2) ?>px;
	height:<?= (($thumbHeight + $imgSpacing) * 2) ?>px;
	top: <?= (($thumbHeight + $imgSpacing) * 2) ?>px;
	left: <?= (($thumbWidth * 5.5) + ($imgSpacing * 6)); ?>px;
	background-color:#fff;
	color:#333;
}
.branchIoInner{
	margin: 25px 26px 0 65px;
	line-height:1.4em;
	font-size: 22px;
}
.branchIoInner p{
	font-family: "HelveticaNeue-Light",helvetica, Arial,sans-serif;
}
.branchIoInner p span{
	white-space:nowrap;
}
.callToAction{
	margin-top:29px;
	color:#<?= $config->action_bar_color; ?>;
	font-size:18px;
}
.iosPhone{
	position:absolute;
	top: <?= $thumbHeight * 0.55 ?>px;
	left: <?= ($thumbWidth * 3.25) + ($imgSpacing * 3); ?>px;
}
.androidPhone{
	position:absolute;
	top: <?= $thumbHeight * 0.33 ?>px;
	left: <?= ($thumbWidth * 4) + ($imgSpacing * 4); ?>px;
}
.storeButtons{
	margin-top:30px;
}
.storeButtons a:last-child{
	float:right;
}
.storeButtons img{
	width:131px;
	height:44px;
}
.phoneFrame .screenshot{
	position:absolute;
	top:0px;
	left:0px;
}
.androidPhone .screenshot{
	left:15px;
	top:58px;
	width:300px;
	height:533px;
}
.iosPhone .screenshot{
	left:24px;
	top:69px;
	width:241px;
	height:430px;
}
#branchIoForm{
	display:inline-block;
}
#branchIoForm input[type=text]{
	display:inline-block;
	padding: 0 65px 0 18px;
	line-height:41px;
	font-size:16px;
}
#branchIoForm button{
	display:inline-block;
	border-radius:3px;
	width:75px;
	height:35px;
	margin-left: -80px;
	vertical-align:middle;
	visibility:hidden;
	
	background-image:none;
	background-color:#5ca300;
	border:0px;
}
.belowThumbs{
	position:relative;
	left: <?= ($thumbWidth * 1.5) + ($imgSpacing * 2); ?>px;
	padding:15px;
}
.backLink{
	z-index:3;
	color:#<?= $config->action_bar_color; ?>;
	font-size:1.5em;
}
.backLink svg{
	vertical-align:middle;
	margin-right:10px;
}
svg path{
	fill: currentColor;
}
</style>
<?= $debug ?>

<div class='entireAppPromo'>
	<div class='thumbsWrapper'>
		<div class='thumbRow'>
		<?php
			$numThumbs = 0;
			foreach($trendingArticles as $topArticle){
				print "<div class='imageWrapper'>";
					print "<img src='{$topArticle["imgUrl"]}' title='{$topArticle["title"]}' width='{$topArticle["width"]}' height='{$topArticle["height"]}'/>";
				print "</div>";

				$numThumbs++;
				if(($numThumbsPerRow * $thumbRows) == $numThumbs){
					break; // both rows are filled now... stop printing thumbnails
				} else if(($numThumbs % $numThumbsPerRow) == 0){
					print "</div><div class='thumbRow'>";
				}
			}
		?>
		</div>
		<div class='topContent'>
			<div class='pitchOuter'>
				<div class='pitchInner'>
					<?= wfMsg( 'apppromolanding-pitch' ) ?>
				</div>
			</div>
			<div class='branchIoOuter'>
				<div class='branchIoInner'>
					<p><?= wfMsg('apppromolanding-custompitch', "<wbr><span>{$config->name}</span>") ?></p>
					<div class='branchIo'>
						<div class='callToAction'><?= wfMsg( 'apppromolanding-call-to-action' ) ?></div>
						<form id='branchIoForm' method='post' onsubmit='return sendSMS();'>
							<input type='text' name='phoneNumber' placeholder='<?= wfMsg('apppromolanding-phone-num-placeholder') ?>'/><button
								data-send="<?= htmlspecialchars(wfMsg( 'apppromolanding-button-get' )) ?>"
								data-sending="<?= htmlspecialchars(wfMsg( 'apppromolanding-button-sending' )) ?>"
								data-sent="<?= htmlspecialchars(wfMsg( 'apppromolanding-button-sent' )) ?>"
								type='submit'><?= wfMsg( 'apppromolanding-button-get' ) ?></button>
						</form>
					</div>
					<div class='storeButtons'>
						<a href='<?= $iosUrl ?>'>
							<img src='<?= $iosStoreSrc ?>'/>
						</a>
						<a href='<?= $androidUrl ?>'>
							<img src='<?= $androidStoreSrc ?>'/>
						</a>
					</div>
				</div>
			</div>
			<div class='phoneWrapper iosPhone'>
				<div class='phoneFrame'>
					<img src='<?= $iosPhoneSrc ?>'/>
					<div class='screenshot'>
						<img src='<?= $iosScreenShot ?>' width='241' height='430'/>
					</div>
				</div>
			</div>
			<div class='phoneWrapper androidPhone'>
				<div class='phoneFrame'>
					<img src='<?= $androidPhoneSrc ?>'/>
					<div class='screenshot'>
						<img src='<?= $androidScreenShot ?>' width='300' height='533'/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='belowThumbs'>
		<a class='backLink' href='<?= $mainPageUrl ?>'>
			<?= $larrSvgCode ?><?= wfMsg( 'apppromolanding-back' ) ?>
		</a>
	</div>
</div>
<script>
//	(function(b,r,a,n,c,h,_,s,d,k){if(!b[n]||!b[n]._q){for(;s<_.length;)c(h,_[s++]);d=r.createElement(a);d.async=1;d.src="https://cdn.branch.io/branch-latest.min.js";k=r.getElementsByTagName(a)[0];k.parentNode.insertBefore(d,k);b[n]=h}})(window,document,"script","branch",function(b,r){b[r]=function(){b._q.push([r,arguments])}},{_q:[],_v:1},"addListener applyCode banner closeBanner creditHistory credits data deepview deepviewCta first getCode init link logout redeem referrals removeListener sendSMS setIdentity track validateCode".split(" "), 0);
//	branch.init('<?= $branchKey ?>');

	function sendSMS() {
		$('#branchIoForm button').text( $('#branchIoForm button').data('sending') );
		$('#branchIoForm button').attr('disabled', 'disabled');
		branch.sendSMS(
			$('form#branchIoForm input').val(),
			{
				channel: 'Wikia',
				feature: 'Text-Me-The-App',
				campaign: 'apppromolanding'
			}, { make_new_link: false }, // Default: false. If set to true, sendSMS will generate a new link even if one already exists.
			function(err) {
				if(err){
					// Usually, this is an invalid phone number.
					$('#branchIoForm button').text( $('#branchIoForm button').data('send') );
					$('#branchIoForm button').attr('disabled', ''); // re-enable
					alert("<?= wfMsg('apppromolanding-invalid-phone-num') ?>");
					console.log(err);
				} else {
					$('#branchIoForm button').text( $('#branchIoForm button').data('sent') );
					$('#branchIoForm button').attr('disabled', ''); // re-enable
				}
			}
		);
		return false;
	}
</script>


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
<div style='clear:both;margin-top:800px;'></div>
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
	<li class='done'>Create grid with background images from trending articles API</li>
	<li class='done'>Put a semi-transparent mask obscuring all images (they're BACKGROUND afterall).</li>
	<li class='done'>i18n'ed pitch on the left</li>
	<li class='done'>Find someone in eng (or some docs) and ask why i18n strings can't be used automatically like in normal MediaWiki... I think I vaguely recall there being some cache we have to regenerate to push them through? Answer: ?rebuildmessages=1&lang=en&mcache=writeonly</li>
	<li class='done'>i18n'ed back button, linking to homepage</li>
	<li class='done'>Phone images, positioned & overlapping</li>
	<li class='done'>i18n'ed Call-To-Action with text color: $config->action_bar_color</li>
	<li class='done'>Add store-badge images with links to $androidUrl and $iosUrl</li>
	<li class='done'>Figure out Helvetica Neue situation. It's also used in Mercury. (Figured it out: some browsers have it, others will slide to the fallbacks & that's okay).</li>
	<li class='done'>Branch.io widget:
		<ul>
			<li class='done'>Get the branch_key for the app, from the Branch API</li>
			<li class='done'>We can probably polish/customize the branch.io interaction a bunch. (Ended up mainly being URL params... after submit, there is no interaction)</li>
			<li class='done'>Get it working: https://dev.branch.io/features/text-me-the-app/advanced/</li>
			<li class='done'>Input field... typing a phone number into it causes "GET" button to appear (as if inside the textarea, via padding & negative margins)</li>
		</ul>
	</li>
	<li class='done'>Integrate the screenshots from S3</li>
	<li class='done'>Ensure that this works on a bunch of wikis & looks correct on all of them</li>
	<li class='done'>Make sure the interaction is correct on wikis without an app http://trueblood.sean.wikia-dev.com/wiki/Community_App</li>
	<li class='done'>Change the app-store links to be branch.io link so that we get metrics in there</li>
	<li class='done'>Get VCL to send even mobile users to the Oasis version of the page. Done here: https://github.com/Wikia/wikia-vcl/blob/master/wikia.com/control-skin.vcl#L37</li>
	<li class='done'>Update the image URL when the images are changed to internal domain.</li>
	<li>Design review:
		<ul>
			<li class='done'>tagline font (in blue box) - change the order of the font stack so "thin" is first, - font-family: "HelveticaNeue-Thin", "Helvetica Neue", Arial,sans-serif;</li>
			<li class='done'>Add Helvetica Neue Light to the font stack for the subtitle above branch ("the destination...") and the input field copy, font-family: "HelveticaNeue-Light",helvetica, Arial,sans-serif</li>
			<li class='done'>It looks like you are using iphone4 screenshots and its distorting the aspect ratio, we need to use the iphone 6/6s screens</li>
			<li class='done'>the "get app" btn look to be inheriting some default wikia styling, take out the gradient and border and use the green (#5ca300).</li>
			<li class='done'>ideally we provide a status update from Branch that the SMS has been sent (similar to the default implementation). I think the simpliest would be to mirror the default behavior and change the submit button to "sent" after submission. Let me know if thats doable or if we need to work on another solution.<br/>
				Text that they use is -> "Sending SMS" -> "SMS Sent". We should be able to do this.</li>
			<li class='done'>Sometimes there are placeholder images from the ImageServing. Is there any way we can check instead of outputting those? :( I don't think so. It gives us a URL and that URL just 404s. I'd consider it a bug in ImageServing</li>
			<li class='done'>The grid line should be white with a thickness of 1px</li>
			<li class='done'>nice-to-have: If it's easy, a bg-color on the images grid of #404040 so that there is good contrast during the load.</li>
			<li class='done'>in terms of responsive layout, the screenshots, cta etc should be centered regardless of the size of the browser window (for that breakpoint). Keep content fixed to bg grid.</li>
			<li class='done'>Make sure the title of the Wiki stays as one word</li>
		</ul>
	</li>
	<li class='done'>Swap the Android & iOS images (will get new art from Peter shortly)</li>
	<li class='done'>Change the font &larr; to be the SVG from zeplin</li>
	<li>Translation config files & translation requests</li>
</ul>
