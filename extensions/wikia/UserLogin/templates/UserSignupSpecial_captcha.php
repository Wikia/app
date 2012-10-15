<? if(!empty($rawHtml)) { ?>
	<label><?= wfMsg('usersignup-page-captcha-label') ?></label>
	<? if($isFancyCaptcha) { ?>
		<div class="fancy-captcha">
			<?= $rawHtml ?>
		</div>
	<? } else { ?>
		<?= $rawHtml ?>
	<? } ?>
<? } ?>