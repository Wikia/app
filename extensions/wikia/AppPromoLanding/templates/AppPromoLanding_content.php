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
$SCALE_FOR_TABLET_IMAGE_GRID = "0.8";

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
.branchIo_alternate{
	display:none; /* designed to only show on narrow screens */
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
	height:42px;
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
/* Responsive Design customizations */
@media only screen and (max-width: 768px) {
	.entireAppPromo{
		margin-left:-861px;
	}
	.thumbsWrapper{
		transform: scale(0.80, 0.80);
		margin-top:-55px;
	}
	.phoneWrapper{
		transform: scale(0.94444, 0.94444);
	}
	.iosPhone{
		top:158px;
		left:620px;
	}
	.androidPhone{
		top:140px;
		left:720px;
	}
	
	.pitchOuter{
		left:353px;
	}
	.pitchInner{
		width:257px;
		height:148px;
		line-height:36px;
		margin:24px 10px 0 9px;
		font-size:22px;
	}
	.branchIoInner{
		margin:25px 26px 0 40px;
		width:240px;
		line-height:30px;
		font-size:18px;
	}

	.backLink{
		position:absolute;
		top:-32px;
		left:220px;
	}
	.branchIoOuter .branchIo, .branchIoOuter .storeButtons{
		display:none;
	}
	.branchIo_alternate{
		display:block;
		width:320px;
		margin:148px 0 0 415px;
	}
	.branchIo_alternate #branchIoForm input[type=text]{
		width:232px;
	}
	.branchIo_alternate .storeButtons{
		margin-top:22px;
	}
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
					print "<img src='{$topArticle["imgUrl"]}' title=\"".htmlentities($topArticle["title"])."\" width='{$topArticle["width"]}' height='{$topArticle["height"]}'/>";
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
					<?= wfMessage( 'apppromolanding-pitch' )->escaped() ?>
				</div>
			</div>
			<div class='branchIoOuter'>
				<div class='branchIoInner'>
					<p><?= wfMessage( 'apppromolanding-custompitch', "<wbr><span>{$config->name}</span>" )->rawParams()->escaped() ?></p>
					<div class='branchIo'>
						<div class='callToAction'><?= wfMessage( 'apppromolanding-call-to-action' )->escaped() ?></div>
						<form id='branchIoForm' method='post' onsubmit='return sendSMS();'>
							<input type='text' name='phoneNumber' placeholder='<?= wfMessage( 'apppromolanding-phone-num-placeholder' )->escaped() ?>'/><button
								data-send="<?= wfMessage( 'apppromolanding-button-get' )->escaped() ?>"
								data-sending="<?= wfMessage( 'apppromolanding-button-sending' )->escaped() ?>"
								data-sent="<?= wfMessage( 'apppromolanding-button-sent' )->escaped() ?>"
								type='submit'><?= wfMessage( 'apppromolanding-button-get' )->escaped() ?></button>
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
			<?= $larrSvgCode ?><?= wfMessage( 'apppromolanding-back' )->escaped() ?>
		</a>
		<div class='branchIo_alternate'>
			<div class='branchIo'>
				<div class='callToAction'><?= wfMessage( 'apppromolanding-call-to-action' )->escaped() ?></div>
				<form id='branchIoForm' method='post' onsubmit='return sendSMS();'>
					<input type='text' name='phoneNumber' placeholder='<?= wfMessage( 'apppromolanding-phone-num-placeholder' )->escaped() ?>'/><button
						data-send="<?= wfMessage( 'apppromolanding-button-get' )->escaped() ?>"
						data-sending="<?= wfMessage( 'apppromolanding-button-sending' )->escaped() ?>"
						data-sent="<?= wfMessage( 'apppromolanding-button-sent' )->escaped() ?>"
						type='submit'><?= wfMessage( 'apppromolanding-button-get' )->escaped() ?></button>
				</form>
			</div>
			<div class='storeButtons'>
				<?php
				// The store buttons are in the opposite order on tablet. This was in the design spec & there's probably a reason for it (lots of android tablets?)
				?>
				<a href='<?= $androidUrl ?>'>
					<img src='<?= $androidStoreSrc ?>'/>
				</a>
				<a href='<?= $iosUrl ?>'>
					<img src='<?= $iosStoreSrc ?>'/>
				</a>
			</div>
		</div>
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
					alert("<?= wfMessage( 'apppromolanding-invalid-phone-num' )->escaped() ?>");
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
<div style='clear:both;margin-top:775px;'></div>
