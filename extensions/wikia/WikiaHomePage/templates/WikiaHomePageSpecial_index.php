<section class="WikiaHomePageStaffTool" id="WikiaHomePageStaffTool">
    <h2 class="heading">
        <?= wfMsg('wikia-home-page-special-wikis-in-slots-heading') ?>
    </h2>

    <?php if( !empty($errorMsg) ): ?>
    <p class="error">
        <?= $errorMsg; ?>
    </p>
    <?php endif; ?>

    <?php if( !empty($infoMsg) ): ?>
    <p class="success">
        <?= $infoMsg; ?>
    </p>
    <?php endif; ?>

    <p>
        <?= wfMsg('wikia-home-page-special-wikis-in-slots-total'); ?>
        <?= $slotsInTotal; ?>
    </p>

	<div class="slot-forms">
		<form id="wikis-in-slots-verticals" class="wikis-in-slots" name="wikis-in-slots" method="post">
			<h3><?= wfMsg('wikia-home-page-special-verticals-proportions'); ?></h3>
			<p><label for="video-games-amount"><?= wfMsg('hub-Video_Games'); ?></label><input type="text" id="video-games-amount" name="video-games-amount" value="<?= $videoGamesAmount; ?>" /></p>
			<p><label for="entertainment-amount"><?= wfMsg('hub-Entertainment'); ?></label><input type="text" id="entertainment-amount" name="entertainment-amount" value="<?= $entertainmentAmount; ?>" /></p>
			<p><label for="lifestyle-amount"><?= wfMsg('hub-Lifestyle'); ?></label><input type="text" id="lifestyle-amount" name="lifestyle-amount" value="<?= $lifestyleAmount; ?>" /></p>
			<p><input type="hidden" name="change-type" value="vertical-slots"></p>
			<span class="status-msg"></span>
			<p><input type="submit" value="<?= wfMsg('wikia-home-page-special-change-button'); ?>"></p>
		</form>
		<form id="wikis-in-slots-flags	" class="wikis-in-slots" name="wikis-in-slots" method="post">
			<h3><?= wfMsg('wikia-home-page-special-hot-new-numbers'); ?></h3>
			<p><label for="hot-wikis-amount"><?= wfMsg('wikia-home-page-special-slot-type-hot-wikis'); ?></label><input type="text" id="hot-wikis-amount" name="hot-wikis-amount" value="<?= $hotWikisAmount; ?>" /></p>
			<p><label for="new-wikis-amount"><?= wfMsg('wikia-home-page-special-slot-type-new-wikis'); ?></label><input type="text" id="new-wikis-amount" name="new-wikis-amount" value="<?= $newWikisAmount; ?>" /></p>
			<p><input type="hidden" name="change-type" value="hot-new-slots"></p>
			<span class="status-msg"></span>
			<p><input type="submit" value="<?= wfMsg('wikia-home-page-special-change-button'); ?>"></p>
		</form>
	</div>
</section>