<form method="post" class="scavenger-form" id="scavenger-form">
<?php if (!empty($errors)) { ?>
	<div class="form-errorbox" >
		<div class="error-head">
			<img class="sprite error" width="16" height="16" src="<?= wfBlankImgUrl(); ?>" alt=""><div><?php
			echo wfMsg('scavengerhunt-form-error');
			?></div>
		</div>
		<ul>
			<?php
			$counter = 0;
			foreach ( $errors as $value ) {
				if ( ( $counter % 2 ) == 0 ) { ?>
				<li><?= $value ?></li>
				<? }
				$counter++;?>
			<?php } ?>
		</ul>
		<ul>
			<?php
			$counter = 0;
			foreach ( $errors as $value ) {
				if ( $counter % 2 ) { ?>
				<li><?= $value ?></li>
				<? }
				$counter++;?>
			<?php } ?>
		</ul>
	</div>
<?php }
?>
	<div class="scavenger-formfield-simple scavenger-general">
		<h2><?= wfMsg('scavengerhunt-label-general')?></h2>
		<div>
			<div class="scavengerhunt-editor-tips">
				<?= wfMsg('scavengerhunt-editor-tip-name')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-name') ?>
				<br>
				<input type="text" id="gameName" name="name" class="<?= in_array('name', $highlight) ? 'sh-error' : '' ?>"  value="<?= htmlspecialchars($name); ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
				<?= wfMsg('scavengerhunt-editor-tip-landing-title')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-landing-title') ?>
				<br>
				<input type="text" name="landingTitle" class="<?= in_array('landingTitle', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($landingTitle) ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
				<?= wfMsg('scavengerhunt-editor-tip-landing-button-text')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-landing-button-text') ?>
				<br>
				<input type="text" name="landingButtonText" class="<?= in_array('landingButtonText', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($landingButtonText) ?>">
			</label>
		</div>
		<div class="short scavenger-formfield-simple scavenger-general">
			<label>
				<?= wfMsg('scavengerhunt-label-landing-button-x') ?>
				<input type="text" name="landingButtonX" class="scavenger-image-offset <?= in_array('landingButtonX', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($landingButtonX) ?>">
			</label>
			<label>
				<?= wfMsg('scavengerhunt-label-landing-button-y') ?>
				<input type="text" name="landingButtonY" class="scavenger-image-offset <?= in_array('landingButtonY', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($landingButtonY) ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
				<?= wfMsg('scavengerhunt-editor-tip-sprite-img')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-sprite-img') ?>
				<a href="#" class="scavenger-progress-check"><?= wfMsg('scavengerhunt-label-dialog-check') ?></a>
				<br>
				<input type="text" name="spriteImg" class="<?= in_array('spriteImg', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($spriteImg) ?>">
			</label>
		</div>
	</div>
	<div class="scavenger-formfield-simple scavenger-general">
		<h2><?= wfMsg('scavengerhunt-label-progress-bar')?></h2>
		<?= F::app()->sendRequest(
			'ScavengerHuntForm',
			'getSpriteElement',
			array(
			    'sprites' => array( 'progressBarBackgroundSprite', 'progressBarExitSprite', 'progressBarHintLabel' ),
			    'article' => $this->mVars,
			    'highlight' => $highlight
			)
		); ?>
	</div>
	<div class="short scavenger-formfield-simple scavenger-general">
		<div class="scavengerhunt-editor-tips" style="margin-top:0px">
			<?= wfMsg('scavengerhunt-editor-tip-clue-color')?>
		</div>
		<label>
			<?= wfMsg('scavengerhunt-label-clue-color') ?>
			<input type="text" name="clueColor" class="scavenger-image-offset <?= in_array('clueColor', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($clueColor) ?>">
		</label>
		<label>
			<?= wfMsg('scavengerhunt-label-clue-size') ?>
			<select name="clueSize" class="<?= in_array('clueSize', $highlight) ? 'sh-error' : '' ?>">
				<? for ( $fSize = 8; $fSize <= 16; $fSize++ ){
					?><option value="<?=$fSize;?>px" <?=( $fSize.'px' == $clueSize) ? 'selected="selected"':''; ?>><?=htmlspecialchars($fSize)?> px</option><?
				} ?>
			</select>
		</label>
		<label>
			<?= wfMsg('scavengerhunt-label-clue-font') ?>
			<select name="clueFont" class="<?= in_array('clueFont', $highlight) ? 'sh-error' : '' ?>">
				<? foreach ( array( 'normal', 'bold' ) as $style ){
					?><option value="<?=$style;?>" <?=($style == $clueFont) ? 'selected="selected"' : '' ; ?>><?=htmlspecialchars($style)?></option><?
				} ?>
			</select>
		</label>
	</div>
	<div class="scavenger-formfield-simple scavenger-starting">
		<h2><?= wfMsg('scavengerhunt-label-starting-clue')?></h2>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-starting-clue-title')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-title') ?>
				<br>
				<input type="text" name="startingClueTitle" class="<?= in_array('startingClueTitle', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($startingClueTitle) ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-starting-clue-text')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-text') ?>
				<br>
				<textarea name="startingClueText" class="<?= in_array('startingClueText', $highlight) ? 'sh-error' : '' ?>" ><?= htmlspecialchars($startingClueText) ?></textarea>
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-starting-clue-button-text')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-button-text') ?>
				<br>
				<input type="text" name="startingClueButtonText" class="<?= in_array('startingClueButtonText', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($startingClueButtonText) ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-starting-clue-button-target')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-starting-clue-button-target') ?>
				<br>
				<input type="text" name="startingClueButtonTarget" class="<?= in_array('startingClueButtonTarget', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($startingClueButtonTarget) ?>">
			</label>
		</div>
		<?= F::app()->sendRequest(
			'ScavengerHuntForm',
			'getSpriteElement',
			array(
			    'sprites' => array( 'startPopupSprite' ),
			    'article' => $this->mVars,
			    'highlight' => $highlight
			)
		); ?>
	</div>
<?php foreach ( $articles as $number => $article ) { ?>
	<div class="scavenger-formfield scavenger-ingame" data-index="<?= $number ?>">
		<h2><?= wfMsg('scavengerhunt-label-article') ?></h2>
		<a class="wikia-button removeSection"><?= wfMsg('scavengerhunt-button-remove-section') ?></a>
		<input type="hidden" name="articleMarker[<?= $number ?>]" value="<?= $number ?>" />
		<div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-title') ?>
				<br>
				<input type="text" name="articleTitle[<?= $number ?>]" class="<?= in_array("articleTitle[$number]", $highlight) ? 'sh-error ' : '' ?>scavenger-page-title" value="<?= htmlspecialchars($article['title']) ?>">
			</label>
			<div class="scavengerhunt-editor-tips" style="margin-top: -20px;">
			<?= wfMsg('scavengerhunt-editor-tip-article-title')?>
			</div>
		</div>
		<?= F::app()->sendRequest(
			'ScavengerHuntForm',
			'getSpriteElement',
			array(
			    'sprites' => array( 'spriteNotFound', 'spriteInProgressBar', 'spriteInProgressBarHover', 'spriteInProgressBarNotFound' ),
			    'article' => $article,
			    'sufix' => "[$number]",
			    'highlight' => $highlight
			)
		);?>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-article-clue-text')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-clue-text') ?>
				<br>
				<input type="text" name="clueText[<?= $number ?>]" class="<?= in_array("clueText[$number]", $highlight) ? 'sh-error ' : '' ?>scavenger-page-title" value="<?= htmlspecialchars($article['clueText']) ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-article-congrats')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-article-congrats') ?>
				<br>
				<input type="text" name="congrats[<?= $number ?>]" class="<?= in_array("congrats[$number]", $highlight) ? 'sh-error ' : '' ?>scavenger-page-title" value="<?= $article['congrats'] ?>">
			</label>
		</div>
	</div>
<?php } ?>
	<div>
		<input type="button" id="addSection" value="<?= wfMsg('scavengerhunt-button-add-section') ?>">
	</div>
	<div class="scavenger-formfield-simple scavenger-entry">
		<h2><?= wfMsg('scavengerhunt-label-entry-form') ?></h2>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-entry-form-title')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-title') ?>
				<br>
				<input type="text" name="entryFormTitle" class="<?= in_array('entryFormTitle', $highlight) ? 'sh-error' : '' ?>" value="<?= htmlspecialchars($entryFormTitle) ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-entry-form-text')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-text') ?>
				<br>
				<textarea name="entryFormText" class="<?= in_array('entryFormText', $highlight) ? 'sh-error' : '' ?>" ><?= $entryFormText ?></textarea>
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-entry-form-button-text')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-button-text') ?>
				<br>
				<input type="text" name="entryFormButtonText" class="<?= in_array('entryFormButtonText', $highlight) ? 'sh-error' : '' ?>" value="<?= isset( $entryFormButtonText ) ? htmlspecialchars($entryFormButtonText) : '' ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-entry-form-question')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-question') ?>
				<br>
				<textarea name="entryFormQuestion" class="<?= in_array('entryFormQuestion', $highlight) ? 'sh-error' : '' ?>"><?= htmlspecialchars($entryFormQuestion) ?></textarea>
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-entry-form-email')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-email') ?>
				<br>
				<textarea name="entryFormEmail" class="<?= in_array('entryFormEmail', $highlight) ? 'sh-error' : '' ?>"><?= isset( $entryFormEmail ) ? htmlspecialchars($entryFormEmail) : '' ?></textarea>
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-entry-form-username')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-entry-form-username') ?>
				<br>
				<textarea name="entryFormUsername" class="<?= in_array('entryFormUsername', $highlight) ? 'sh-error' : '' ?>"><?= isset( $entryFormUsername ) ? htmlspecialchars($entryFormUsername) : '' ?></textarea>
			</label>
		</div>
	</div>
	<div class="scavenger-formfield-simple scavenger-goodbye">
		<h2><?= wfMsg('scavengerhunt-label-goodbye') ?></h2>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-goodbye-title')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-goodbye-title') ?>
				<br>
				<input type="text" name="goodbyeTitle" value="<?= $goodbyeTitle ?>" class="<?= in_array('goodbyeTitle', $highlight) ? 'sh-error' : '' ?>" >
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
			<?= wfMsg('scavengerhunt-editor-tip-goodbye-text')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-label-goodbye-text') ?>
				<br>
				<textarea name="goodbyeText" class="<?= in_array('goodbyeText', $highlight) ? 'sh-error' : '' ?>" ><?= htmlspecialchars($goodbyeText) ?></textarea>
			</label>
		</div>
		<?= F::app()->sendRequest(
			'ScavengerHuntForm',
			'getSpriteElement',
			array(
			    'sprites' => array( 'finishPopupSprite' ),
			    'article' => $this->mVars,
			    'highlight' => $highlight
			)
		); ?>
	</div>
	<div class="short scavenger-formfield-simple scavenger-general">
		<h2><?= wfMsg('scavengerhunt-label-facebook')?></h2>
		<div>
			<div class="scavengerhunt-editor-tips">
				<?= wfMsg('scavengerhunt-editor-tip-facebook-image')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-facebook-image') ?>
				<br>
				<input type="text" id="facebookImg" name="facebookImg" class="<?= in_array('facebookImg', $highlight) ? 'sh-error' : '' ?>"  value="<?= isset( $facebookImg ) ? htmlspecialchars( $facebookImg ) : '' ?>">
			</label>
		</div>
		<div>
			<div class="scavengerhunt-editor-tips">
				<?= wfMsg('scavengerhunt-editor-tip-facebook-description')?>
			</div>
			<label>
				<?= wfMsg('scavengerhunt-facebook-description') ?>
				<br>
				<textarea name="facebookDescription" class="<?= in_array('facebookDescription', $highlight) ? 'sh-error' : '' ?>" ><?= isset( $facebookDescription ) ? htmlspecialchars( $facebookDescription ) : '' ?></textarea>
			</label>
		</div>
	</div>
	<div class="buttons">
		<input type="submit" name="save" value="<?= wfMsg('scavengerhunt-button-save') ?>">
		<?php
		if ($gameId) {
		?>
		<input type="submit" name="enable" value="<?= $enabled ? wfMsg('scavengerhunt-button-disable') : wfMsg('scavengerhunt-button-enable') ?>">
		<input type="submit" name="delete" value="<?= wfMsg('scavengerhunt-button-delete') ?>">
		<input type="hidden" name="prevEnabled" value="<?= (int)$enabled ?>">
		<?php
		}
		?>
		<input type="hidden" name="gameId" value="<?= $gameId ?>">
		<input type="hidden" name="wpEditToken" value="<?= $editToken ?>">
	</div>
</form>