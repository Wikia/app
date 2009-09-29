<body>
	<link rel="stylesheet" href="<?= $css ?>" />
	<div id="MagCloudCoverWrapper" class="MagCloudCoverLayout<?= $cover['layout'] ?>" style="background-color: #<?= $colors[1] ?>">
		<div id="MagCloudCoverTitle" style="background-color: #<?= $colors[2] ?>; color: #<?= $colors[1] ?>">
			<big><?= htmlspecialchars($cover['title']) ?></big>
			<small><?= htmlspecialchars($cover['subtitle']) ?></small>
		</div>
		<div id="MagCloudCoverBar" style="background-color: #<?= $colors[0] ?>">&nbsp;</div>
<?php if(!empty($image)): ?>
		<div id="MagCloudCoverImage" style="margin-left: -<?= round($image['width'] / 2) ?>px; margin-top: -<?= round($image['height'] / 2) ?>px"><?= $image['html'] ?></div>
<?php endif; ?>
	</div>
</body>
