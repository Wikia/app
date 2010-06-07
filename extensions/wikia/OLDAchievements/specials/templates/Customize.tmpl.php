<div style="clear: both;"></div>

<script src="<?= $js_url ?>"></script>

<div style="clear: both;"></div>

<aside id="customize-sidebar">
	<h2 class="first"><?= wfMsg('achievements-about-title') ?></h2>
	<p><?= wfMsg('achievements-about-content') ?></p>
</aside>


<?php
global $wgScriptPath;
foreach(AchStatic::$mInTrackConfig as $inTrack => $inTrackBadges) {
?>

<div class="customize-section">

	<div class="save-title-button">
		<form method="POST">
			<input type="hidden" name="c-messages" class="c-messages" />
			<input type="submit" value="<?= wfMsg('achievements-save') ?>" onclick="Achievements.AchPrepareData();"/>
		</form>
	</div>

	<h2><?= wfMsg('achievements-track-name-'.AchStatic::$mBadgeNames[$inTrack]) ?></h2>

	<ul class="custom-badges">
<?php
	$inTrackBadgesCount = count($inTrackBadges);
	for($i = 0; $i < $inTrackBadgesCount; $i++) {
?>
		<li class="clearfix<?= ($i == $inTrackBadgesCount-1) ? ' last' : '' ?>">

			<div class="content-form">
				<p class="input">
					<input class="c-message" type="text" name="<?= htmlspecialchars(AchHelper::getBadgeMessageName($inTrack, $i)) ?>" value="<?= htmlspecialchars(AchHelper::getBadgeName($inTrack, $i)) ?>">
				</p>
				<p><?= AchStatic::$mLevelNames[$inTrackBadges[$i]['level']] ?> (<?= AchStatic::$mLevelsConfig[$inTrackBadges[$i]['level']] ?> points)</p>
				<p><?= AchHelper::getGivenFor($inTrack, $i) ?></p>
			</div>

			<div class="image-form">
				<p><img width="90" height="90" src="<?= AchHelper::getBadgeUrl($inTrack, $i, 90) ?>" /><br /><span class="custom-text"><?= wfMsg('achievements-customize') ?><br /><a href="#" onclick="Achievements.revert(this, <?= $inTrack ?>, <?= $i ?>);"><?= wfMsg('achievements-revert') ?></a></span></p>
				<form method="POST" enctype="multipart/form-data" class="customize-upload" action="<?= $wgScriptPath ?>/index.php?action=ajax&amp;rs=Ach&amp;method=uploadBadge&amp;file=<?= $inTrack ?>-<?= $i ?>">
					<p class="input">
						<input name="wpUploadFile" type="file"/>
						<button type="submit"><?= wfMsg('achievements-send') ?></button>
					</p>
				</form>
			</div>

		</li>
<?php
	}
?>
	</ul>
</div>

<?php
}

$notInTrack = array(
	'special' => array(BADGE_WELCOME, BADGE_INTRODUCTION, BADGE_SAYHI, BADGE_CREATOR),
	'secret' => array(BADGE_POUNCE, BADGE_CAFFEINATED, BADGE_LUCKYEDIT)
);

foreach($notInTrack as $section => $badges) {
?>

<div class="customize-section">

	<div class="save-title-button">
		<form method="POST">
			<input type="hidden" name="c-messages" class="c-messages" />
			<input type="submit" value="<?= wfMsg('achievements-save') ?>" onclick="Achievements.AchPrepareData();"/>
		</form>
	</div>

	<h2><?= wfMsg('achievements-'.$section) ?></h2>
	<ul class="custom-badges">
<?php
	$i = 0;
	foreach($badges as $badge_type) {
?>
		<li class="clearfix<?= ($i == count($badges)-1) ? ' last' : '' ?>">
			<div class="content-form">
				<p class="input">
					<input class="c-message" type="text" name="<?= htmlspecialchars(AchHelper::getBadgeMessageName($badge_type, null)) ?>" value="<?= htmlspecialchars(AchHelper::getBadgeName($badge_type, null)) ?>">
				</p>
				<p><?= AchStatic::$mLevelNames[AchStatic::$mNotInTrackConfig[$badge_type]] ?> (<?= AchStatic::$mLevelsConfig[AchStatic::$mNotInTrackConfig[$badge_type]] ?> points)</p>
				<p><?= AchHelper::getGivenFor($badge_type, null) ?></p>
			</div>

			<div class="image-form">
				<p><img width="90" height="90" src="<?= AchHelper::getBadgeUrl($badge_type, null, 90) ?>" /><br /><span class="custom-text"><?= wfMsg('achievements-customize') ?><br /><a href="#" onclick="Achievements.revert(<?= $inTrack ?>);"><?= wfMsg('achievements-revert') ?></a></span></p>
				<form method="POST" enctype="multipart/form-data" class="customize-upload" action="<?= $wgScriptPath ?>/index.php?action=ajax&amp;rs=Ach&amp;method=uploadBadge&amp;file=<?= $badge_type ?>">
					<p class="input">
						<input name="wpUploadFile" type="file"/>
						<button><?= wfMsg('achievements-send') ?></button>
					</p>
				</form>
			</div>
		</li>
<?php
		$i++;
	}
?>
	</ul>
</div>
<?php
}
?>
<script type="text/javascript">
/**
*
* AJAX IFRAME METHOD (AIM) rewritten for jQuery
* http://www.webtoolkit.info/
*
**/
jQuery.AIM = {
	// AIM entry point - used to handle submit event of upload forms
	submit : function(form, options) {
		var iframeName = jQuery.AIM.createIFrame(options);

		// upload "into" iframe
		$(form).
			attr('target', iframeName).
			log('AIM: uploading into "' + iframeName + '"');

		if (options && typeof(options.onStart) == 'function') {
			return options.onStart();
		} else {
			return true;
		}
	},

	// create iframe to handle uploads and return value of its "name" attribute
	createIFrame : function(options) {
		var name = 'aim' + Math.floor(Math.random() * 99999);
		var iframe = $('<iframe id="' + name + '" name="' + name + '" src="about:blank" style="display:none" />');

		// function to be fired when upload is done
		iframe.bind('load', function() {
			jQuery.AIM.loaded($(this).attr('name'));
		});

		// wrap iframe inside <div> and it to <body>
		$('<div>').
			append(iframe).
			appendTo('body');

		// add custom callback to be fired when upload is completed
		if (options && typeof(options.onComplete) == 'function') {
			iframe[0].onComplete = options.onComplete;
		}

		return name;
	},

	// handle upload completed event
	loaded : function(id) {
		$().log('AIM: upload into "' + id + '" completed');

		var i = document.getElementById(id);
		if (i.contentDocument) {
			var d = i.contentDocument;
		} else if (i.contentWindow) {
			var d = i.contentWindow.document;
		} else {
			var d = window.frames[id].document;
		}
		if (d.location.href == "about:blank") {
			return;
		}

		if (typeof(i.onComplete) == 'function') {
			i.onComplete(d.body.innerHTML);
		}
	}
}
</script>
