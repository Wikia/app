<div id="phalanx-mainframe">
	<div id="phalanx-nav-area">
<?= $app->renderPartial( 'PhalanxSpecial', 'tabs', [ 'currentTab' => 'main' ] ); ?>
	</div>

	<div id="phalanx-content-area">
		<div id="phalanx-filter-area">
			<fieldset id="phalanx-input-filter">
				<legend><?= wfMessage( 'phalanx-legend-input' )->escaped() ?></legend>
				<form id="phalanx-block" method="post" action="<?= $action ?>">
					<!-- Filter -->
					<div id="phalanx-block-texts">
						<?php if (!empty($editMode)): ?>
						<input type="hidden" name="id" value="<?= $data['id'] ?>"/>
						<strong>ID:</strong> <?= $data['id'] ?>
						<?php endif; ?>
						<div id="singlemode">
							<label for="wpPhalanxFilter" class="left"><?= wfMessage( 'phalanx-label-filter' )->escaped() ?></label>
							<input type="text" id="wpPhalanxFilter" name="wpPhalanxFilter" class="blue" size="40" value="<?= Sanitizer::encodeAttribute( $data['text'] ); ?>" />
							<input type="button" id="validate" value="<?= wfMessage( 'phalanx-validate-regexp' )->escaped() ?>" />
							<?php if (empty($editMode)): ?>
							<input type="button" id="enterbulk" value="<?= wfMessage( 'phalanx-bulkmode' )->escaped(); ?>">
						</div>
						<div id="bulkmode" style="display: none">
							<label for="wpPhalanxFilterBulk" class="left">Bulk<br/><?= wfMessage( 'phalanx-label-filter' )->escaped() ?></label>
							<textarea type="text" id="wpPhalanxFilterBulk" name="wpPhalanxFilterBulk" class="blue" rows="10" cols="40" value="" ></textarea>
							<input type="button" id="entersingle" value="<?= wfMessage( 'phalanx-singlemode' )->escaped(); ?>">
						<?php endif; ?>
						</div>
						<div>
							<span id="validateMessage"></span>
						</div>
						<!-- Format -->
						<div class="clearfix">
							<div class="left-spacer">&nbsp;</div>
							<label for="wpPhalanxFormatRegex">
								<input type="checkbox" name="wpPhalanxFormatRegex" value="1" <? if ( !empty( $data['regex'] ) ): ?>checked="checked" <? endif; ?>/>
								<?= wfMessage( 'phalanx-format-regex' )->escaped() ?>
							</label>

							<label for="wpPhalanxFormatCase">
								<input type="checkbox" name="wpPhalanxFormatCase" value="1" <? if ( !empty( $data['case'] ) ): ?>checked="checked" <? endif; ?>/>
								<?= wfMessage( 'phalanx-format-case' )->escaped() ?>
							</label>

							<label for="wpPhalanxFormatExact">
								<input type="checkbox" name="wpPhalanxFormatExact" value="1" <? if ( !empty( $data['exact'] ) ): ?>checked="checked" <? endif; ?>/>
								<?= wfMessage( 'phalanx-format-exact' )->escaped() ?>
							</label>
						</div>
						<!-- Expiry-->
						<div class="clearfix">
							<label>
								<strong><?= wfMessage( 'phalanx-label-expiry' )->escaped(); ?></strong>
								<?php if (!empty($editMode)): ?>
								<span class="expires"><?php
									if ($data['expire'] === null) {
										echo wfMessage( 'phalanx-expires-infinite' )->escaped();
									}
									else if (is_numeric($data['expire'])) {
										echo wfMessage( 'phalanx-expires', $wg->Lang->timeanddate($data['expire']) )->escaped();
									}
								?></span>
								<?php endif; ?>
								<select name="wpPhalanxExpire" id="wpPhalanxExpire" class="blue" >
									<?php if ( !empty( $expiries ) ): ?>
									<?php foreach ($expiries as $k => $v): ?>
									<option value="<?=$k?>"><?=$v?></option>
									<?php endforeach; ?>
									<option value="custom" data-is-custom="true"><?= wfMessage( 'phalanx-expire-custom' )->escaped(); ?></option>
									<?php endif; ?>
								</select>
							</label>
							<input type="text" id="wpPhalanxExpireCustom" name="wpPhalanxExpireCustom" size="20" placeholder="<?= wfMessage( 'phalanx-expire-custom-tooltip' )->escaped(); ?>" style="display: none">
						</div>
					</div>
					<!-- Type -->
					<div class="clearfix">
						<div class="left-spacer"><?= wfMessage( 'phalanx-label-type' )->escaped() ?></div>
						<div class="phalanx-block-types">
<?php
						foreach($typeSections as $section => $types) {
?>
							<fieldset>
								<legend><?= wfMessage("phalanx-section-type-{$section}")->escaped(); ?></legend>
<?php
							foreach($types as $typeId) {
								$typeName = str_replace('_', '-', $blockTypes[$typeId]);
?>
								<label title="<?= wfMessage( "phalanx-help-type-{$typeName}" )->escaped(); ?>">
									<input type="checkbox" name="wpPhalanxType[]"
										   value="<?= Sanitizer::encodeAttribute( $typeId ); ?>"
										   <? if ( isset( $data['type'][$typeId] ) ): ?>checked="checked" <? endif; ?>
									/>
									<?= wfMessage( "phalanx-type-{$typeName}" )->escaped(); ?>
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
							<label for="wpPhalanxReason" class="left"><?= wfMessage( 'phalanx-label-reason' )->escaped() ?></label>
							<input type="text" id="wpPhalanxReason" name="wpPhalanxReason" class="blue" size="40" value="<?= Sanitizer::encodeAttribute( $data['reason'] ); ?>" />
						</div>
						<div class="clearfix">
							<label for="wpPhalanxComment" class="left"><?= wfMessage( 'phalanx-label-comment' )->escaped() ?></label>
							<input type="text" id="wpPhalanxComment" name="wpPhalanxComment" size="40" value="<?= Sanitizer::encodeAttribute( $data['comment'] ); ?>" />
						</div>
						<div class="clearfix">
							<label for="wpPhalanxLanguages" class="left"><?= wfMessage( 'phalanx-label-lang' )->escaped() ?></label>
							<select name="wpPhalanxLanguages" id="wpPhalanxLanguages" class="blue" >
								<? foreach ($languages as $k => $v) { ?>
									<option <?=($k == $data['lang']) ? "selected" : ""?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>
						</div>
						<div class="clearfix">
							<input type="submit" id="wpPhalanxSubmit" name="wpPhalanxSubmit" value="<?= wfMessage( empty( $editMode ) ? 'phalanx-add-block' : 'phalanx-modify-block' )->escaped() ?>" />
							<input type="reset" value="<?= wfMessage( 'phalanx-reset-form' )->escaped() ?>" />
						</div>
					</div>
				</form>
			</fieldset>

			<fieldset>
				<legend><?= wfMessage( 'phalanx-legend-listing' )->escaped() ?></legend>

				<?= wfMessage('phalanx-filters-intro', 'Special:Log/phalanx')->parse() ?>

				<form id="phalanx-filters" method="get" action="<?= $action ?>">
					<div id="phalanx-check-options">
						<label for="wpPhalanxCheckBlocker"><?= wfMessage( 'phalanx-view-blocker' )->escaped() ?></label>
						<input type="text" id="wpPhalanxCheckBlocker" name="wpPhalanxCheckBlocker" class="blue" size="30" value="<?= Sanitizer::encodeAttribute( $checkBlocker ); ?>">
						<input type="submit" value="<?= wfMessage( 'phalanx-view-blocks' )->escaped() ?>"  />

						<label for="wpPhalanxCheckId"><?= wfMessage( 'phalanx-view-id' )->escaped() ?></label>
						<input type="text" id="wpPhalanxCheckId" name="id" class="blue" size="5" value="<?= $data['checkId'] ?>" />

						<input type="submit" value="<?= wfMessage( 'phalanx-view-id-submit' )->escaped() ?>"  />

						<div class="phalanx-block-types">
<?php
						foreach ( $blockTypes as $typeId => $typeName ) {
							$typeName = str_replace('_', '-', $typeName);
?>
							<label title="<?= wfMessage( "phalanx-help-type-{$typeName}" )->escaped(); ?>">
								<input type="checkbox" name="wpPhalanxTypeFilter[]"
									   value="<?= Sanitizer::encodeAttribute( $typeId ); ?>"
										<? if ( !empty( $typeFilter[$typeId] ) ): ?> checked="checked" <? endif; ?>
								/>
								<?= wfMessage( "phalanx-type-{$typeName}" )->escaped(); ?>
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
