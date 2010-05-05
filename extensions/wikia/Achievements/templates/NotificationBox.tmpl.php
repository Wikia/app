<link href="<?= $css_url ?>" type="text/css" rel="stylesheet">

<div id="wikia-alert" class="accent" style="display: none;">
	<img src="<?= $badge_url ?>" alt="<?= htmlspecialchars($badge_name) ?>" width="90" height="90" />
	<div id="alert">
		<h1><?= $title ?></h1>
		<h2><?= $subtitle ?></h2>
		<p><?= $link ?></p>
	</div>
	<h3 class="<?= $level ?>">
		+<span id="points"><?= $points_no ?></span>
		<br />
		<span id="shift"><?= $points ?></span>
	</h3>
</div>

<script>
	wgAfterContentAndJS.push(
		function() {
			$(function() {
				$('#alert').find('a').click(function(e) {
					window.jQuery.tracker.byStr('Achievements/notification/yourprofile');
				});
				$('#wikia-alert').slideDown('slow');
				setTimeout(function() {$('#wikia-alert').slideUp('slow');}, 10000);
				window.jQuery.tracker.byStr('Achievements/notification/appears');
			});
		}
	);
</script>

