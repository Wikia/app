<div id="phalanx-mainframe">
	<div id="phalanx-nav-area">
<?= $app->renderView('PhalanxSpecial', 'tabs', array('currentTab' => 'main')); ?>
	</div>

	<div id="phalanx-content-area">
		<div id="phalanx-filter-area">
			<fieldset id="phalanx-input-filter">
				<legend><?php echo wfMsg( 'phalanx-legend-input' ) ?></legend>
				<form id="phalanx-block" method="post" action="<?= $action ?>">
					<!-- Filter -->
					<div id="phalanx-block-texts">
						<?php if (!empty($editMode)): ?>
						<input type="hidden" name="id" value="<?= $data['id'] ?>"/>
						<strong>ID:</strong> <?= $data['id'] ?>
						<?php endif; ?>
						<div id="singlemode">
							<label for="wpPhalanxFilter" class="left"><?php echo wfMsg( 'phalanx-label-filter' ) ?></label>
							<input type="text" id="wpPhalanxFilter" name="wpPhalanxFilter" class="blue" size="40" value="<?= htmlspecialchars($data['text']) ?>" />
							<input type="button" id="validate" value="<?php echo wfMsg( 'phalanx-validate-regexp' ) ?>" />
							<?php if (empty($editMode)): ?>
							<input type="button" id="enterbulk" value="<?= wfMsg('phalanx-bulkmode') ?>">
						</div>
						<div id="bulkmode" style="display: none">
							<label for="wpPhalanxFilterBulk" class="left">Bulk<br/><?php echo wfMsg( 'phalanx-label-filter' ) ?></label>
							<textarea type="text" id="wpPhalanxFilterBulk" name="wpPhalanxFilterBulk" class="blue" rows="10" cols="40" value="" ></textarea>
							<input type="button" id="entersingle" value="<?= wfMsg('phalanx-singlemode') ?>">
						<?php endif; ?>
						</div>
						<div>
							<span id="validateMessage"></span>
						</div>
						<!-- Format -->
						<div class="clearfix">
							<div class="left-spacer">&nbsp;</div>
							<?= Xml::check( 'wpPhalanxFormatRegex', !empty( $data['regex'] ), array( 'id' => 'wpPhalanxFormatRegex' ) ) ?>
							<label for="wpPhalanxFormatRegex"><?php echo wfMsg( 'phalanx-format-regex' ) ?></label>

							<?= Xml::check( 'wpPhalanxFormatCase', !empty( $data['case'] ), array( 'id' => 'wpPhalanxFormatCase' ) ) ?>
							<label for="wpPhalanxFormatCase"><?php echo wfMsg( 'phalanx-format-case' ) ?></label>

							<?= Xml::check( 'wpPhalanxFormatExact', !empty( $data['exact'] ), array( 'id' => 'wpPhalanxFormatExact' ) ) ?>
							<label for="wpPhalanxFormatExact"><?php echo wfMsg( 'phalanx-format-exact' ) ?></label>
						</div>
						<!-- Expiry-->
						<div class="clearfix">
							<label>
								<strong><?= wfMsg( 'phalanx-label-expiry' ) ?></strong>
								<?php if (!empty($editMode)): ?>
								<span class="expires"><?php
									if ($data['expire'] === null) {
										echo wfMsg('phalanx-expires-infinite');
									}
									else if (is_numeric($data['expire'])) {
										echo wfMsg('phalanx-expires', $app->wg->Lang->timeanddate($data['expire']));
									}
								?></span>
								<?php endif; ?>
								<select name="wpPhalanxExpire" id="wpPhalanxExpire" class="blue" >
									<?php if ( !empty( $expiries ) ): ?>
									<?php foreach ($expiries as $k => $v): ?>
									<option value="<?=$k?>"><?=$v?></option>
									<?php endforeach; ?>
									<option value="custom" data-is-custom="true"><?= wfMessage('phalanx-expire-custom')->plain() ?></option>
									<?php endif; ?>
								</select>
							</label>
							<input type="text" id="wpPhalanxExpireCustom" name="wpPhalanxExpireCustom" size="20" placeholder="<?= wfMessage('phalanx-expire-custom-tooltip')->plain() ?>" style="display: none">
						</div>
					</div>
					<!-- Type -->
					<div class="clearfix">
						<div class="left-spacer"><?php echo wfMsg( 'phalanx-label-type' ) ?></div>
						<div class="phalanx-block-types">
<?php
						foreach($typeSections as $section => $types) {
?>
							<fieldset>
								<legend><?= wfMessage("phalanx-section-type-{$section}")->plain() ?></legend>
<?php
							foreach($types as $typeId) {
								$typeName = str_replace('_', '-', $blockTypes[$typeId]);
?>
								<label title="<?= wfMsg("phalanx-help-type-{$typeName}"); ?>">
									<?= Xml::check('wpPhalanxType[]', isset($data['type'][$typeId]), array('value' => $typeId)); ?>
									<?= wfMsg("phalanx-type-{$typeName}"); ?>

								</label>
<?php
							}
?>
							</fieldset>
<?php
						}
?>
					</div>
					<!-- Reason -->
					<div id="phalanx-block-optionals" class="clearfix">
						<div class="clearfix">
							<label for="wpPhalanxReason" class="left"><?php echo wfMsg( 'phalanx-label-reason' ) ?></label>
							<input type="text" id="wpPhalanxReason" name="wpPhalanxReason" class="blue" size="40" value="<?= htmlspecialchars($data['reason']) ?>" />
						</div>
						<div class="clearfix">
							<label for="wpPhalanxComment" class="left"><?php echo wfMsg( 'phalanx-label-comment' ) ?></label>
							<input type="text" id="wpPhalanxComment" name="wpPhalanxComment" size="40" value="<?= htmlspecialchars($data['comment']) ?>" />
						</div>
						<div class="clearfix">
							<label for="wpPhalanxLanguages" class="left"><?php echo wfMsg( 'phalanx-label-lang' ) ?></label>
							<select name="wpPhalanxLanguages" id="wpPhalanxLanguages" class="blue" >
								<? foreach ($languages as $k => $v) { ?>
									<option <?=($k == $data['lang']) ? "selected" : ""?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>
						</div>
						<div class="clearfix">
							<input type="submit" id="wpPhalanxSubmit" name="wpPhalanxSubmit" value="<?php echo wfMsg( 'phalanx-add-block' ) ?>" />
							<input type="reset" value="<?php echo wfMsg( 'phalanx-reset-form' ) ?>" />
						</div>
					</div>
				</form>
			</fieldset>

			<fieldset>
				<legend><?php echo wfMsg( 'phalanx-legend-listing' ) ?></legend>

				<?= wfMessage('phalanx-filters-intro', 'Special:Log/phalanx')->parse() ?>

				<form id="phalanx-filters" method="get" action="<?= $action ?>">
					<div id="phalanx-check-options">
						<label for="wpPhalanxCheckBlocker"><?php echo wfMsg( 'phalanx-view-blocker' ) ?></label>
						<input type="text" id="wpPhalanxCheckBlocker" name="wpPhalanxCheckBlocker" class="blue" size="30" value="<?= htmlspecialchars($data['checkBlocker']) ?>">
						<input type="submit" value="<?php echo wfMsg( 'phalanx-view-blocks' ) ?>"  />

						<label for="wpPhalanxCheckId"><?php echo wfMsg( 'phalanx-view-id' ) ?></label>
						<input type="text" id="wpPhalanxCheckId" name="id" class="blue" size="5" value="<?= $data['checkId'] ?>" />

						<input type="submit" value="<?php echo wfMsg( 'phalanx-view-id-submit' ) ?>"  />

						<div class="phalanx-block-types">
<?php
						foreach($blockTypes as $typeId => $typeName) {
							$typeName = str_replace('_', '-', $typeName);
?>
							<label title="<?= wfMsg("phalanx-help-type-{$typeName}"); ?>">
								<?= Xml::check('wpPhalanxTypeFilter[]', !empty($typeFilter[$typeId]), array('value' => $typeId)); ?>

								<?= wfMsg("phalanx-type-{$typeName}"); ?>

							</label>
<?php
						}
?>
						</div>
					</div>
				</form>

				<div id="phalanx-check-results">
					<?= $listing ?>
				</div>
			</fieldset>
		</div>
	</div>
</div>
