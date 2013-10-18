<? if(!empty($rawHtml)) { ?>
	<label><?= wfMessage('usersignup-page-captcha-label')->escaped() ?></label>
	<? if($isFancyCaptcha) { ?>
		<div class="fancy-captcha">
			<?= $rawHtml ?>
		</div>
	<? } else { ?>
		<?= $rawHtml ?>
	<? } ?>
<? } ?>