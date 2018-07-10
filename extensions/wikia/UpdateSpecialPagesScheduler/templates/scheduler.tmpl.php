<?php
/**
 * @var $editToken string
 * @var $title Title
 */
?>
<h2><?= wfMessage('update-special-pages-scheduler-header')->escaped() ?></h2>
<form action="<?= $title->getLocalURL() ?>" method="post">
	<input type="hidden" name="editToken" value="<?= $editToken ?>" />
	<input type="hidden" name="updateSpecialPagesScheduler" value="1" />
	<table class="mw-statistics-table">
		<tr>
			<td style="border-right: 0;">
				<?= wfMessage('update-special-pages-scheduler-info')->parse() ?>
			</td>
			<td style="border-left: 0;padding 1em;">
				<input type="submit" value="<?= wfMessage('update-special-pages-scheduler-submit')->text() ?>" />
			</td>
		</tr>
	</table>
</form>
