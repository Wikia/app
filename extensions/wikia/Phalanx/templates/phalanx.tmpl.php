<div id="phalanx-mainframe">
	<div class="wikia-tabs" id="phalanx-nav-area">
		<ul>
			<li class="accent selected" id="phalanx-main-tab"><a href="#main" ><?= wfMsg( 'phalanx-tab-main' ) ?></a></li>
			<li class="accent" id="phalanx-test-tab"><a href="#test"><?= wfMsg( 'phalanx-tab-secondary' ) ?></a></li>
		</ul>
	</div>

	<div id="phalanx-content-area">
		<div id="phalanx-main-tab-content">
			<div id="phalanx-filter-area">
				<fieldset id="phalanx-input-filter">
					<legend><?= wfMsg( 'phalanx-legend-input' ) ?></legend>
					<form id="phalanx-block" method="post" action="">
						<!-- Filter -->
						<div id="phalanx-block-texts">
							<div id="phalanx-feedback-msg" class="clearfix"></div>
							<div class="clearfix">
								<label for="wpPhalanxFilter" class="left"><?= wfMsg( 'phalanx-label-filter' ) ?></label>
								<input type="text" id="wpPhalanxFilter" name="wpPhalanxFilter" class="blue" size="40" />
							</div>
							<div class="clearfix">
								<div class="left-spacer">&nbsp;</div>
								<input type="checkbox" id="wpPhalanxFormatRegex" name="wpPhalanxFormat" value="1" /><label for="wpPhalanxFormatRegex"><?= wfMsg( 'phalanx-format-regex' ) ?></label>
								<input type="checkbox" id="wpPhalanxFormatCase" name="wpPhalanxFormatCase" value="1" /><label for="wpPhalanxFormatCase"><?= wfMsg( 'phalanx-format-case' ) ?></label>
								<input type="checkbox" id="wpPhalanxFormatExact" name="wpPhalanxFormatExact" value="1" /><label for="wpPhalanxFormatExact"><?= wfMsg( 'phalanx-format-exact' ) ?></label>
							</div>
							<div class="clearfix">
								<label for="wpPhalanxExpire" class="left"><?= wfMsg( 'phalanx-label-expiry' ) ?></label>
								<select name="wpPhalanxExpire" id="wpPhalanxExpire" class="blue" >
									<? foreach ($expiries as $k => $v) { ?>
										<option <?=($k == $default_expire) ? "selected" : ""?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>
								<span id="phalanx-expire-old"></span>
							</div>
						</div>
						<!-- Type -->
						<div class="clearfix">
							<div class="left-spacer"><?= wfMsg( 'phalanx-label-type' ) ?></div>
							<div id="phalanx-block-types">
								<div>
									<input type="checkbox" id="wpPhalanxTypeContent" name="wpPhalanxType[]" value="1" /><label for="wpPhalanxTypeContent"><?= wfMsg( 'phalanx-type-content' ) ?></label>
									<input type="checkbox" id="wpPhalanxTypeSummary" name="wpPhalanxType[]" value="2" /><label for="wpPhalanxTypeSummary"><?= wfMsg( 'phalanx-type-summary' ) ?></label>
								</div>
								<div>
									<input type="checkbox" id="wpPhalanxTypeTitle" name="wpPhalanxType[]" value="4" /><label for="wpPhalanxTypeTitle"><?= wfMsg( 'phalanx-type-title' ) ?></label>
								</div>
								<div>
									<input type="checkbox" id="wpPhalanxTypeUser" name="wpPhalanxType[]" value="8" /><label for="wpPhalanxTypeUser"><?= wfMsg( 'phalanx-type-user' ) ?></label>
									<input type="checkbox" id="wpPhalanxTypeCreation" name="wpPhalanxType[]" value="64" /><label for="wpPhalanxTypeCreation"><?= wfMsg( 'phalanx-type-wiki-creation' ) ?></label>
								</div>
								<div>
									<input type="checkbox" id="wpPhalanxTypeQuestion" name="wpPhalanxType[]" value="16" /><label for="wpPhalanxTypeQuestion"><?= wfMsg( 'phalanx-type-answers-question' ) ?></label>
									<input type="checkbox" id="wpPhalanxTypeFilterWords" name="wpPhalanxType[]" value="32" /><label for="wpPhalanxTypeFilterWords"><?= wfMsg( 'phalanx-type-answers-words' ) ?></label>
								</div>
							</div>
							<div id="phalanx-help">
								<div id="phalanx-help-1" class="accent"><?= wfMsg( 'phalanx-help-type-content' ) ?></div>
								<div id="phalanx-help-2" class="accent"><?= wfMsg( 'phalanx-help-type-summary' ) ?></div>
								<div id="phalanx-help-4" class="accent"><?= wfMsg( 'phalanx-help-type-title' ) ?></div>
								<div id="phalanx-help-8" class="accent"><?= wfMsg( 'phalanx-help-type-user' ) ?></div>
								<div id="phalanx-help-64" class="accent"><?= wfMsg( 'phalanx-help-type-wiki-creation' )  ?></div>
								<div id="phalanx-help-16" class="accent"><?= wfMsg( 'phalanx-help-type-answers-question' ) ?></div>
								<div id="phalanx-help-32" class="accent"><?= wfMsg( 'phalanx-help-type-answers-words' ) ?></div>
							</div>
						</div>
						<!-- Reason -->
						<div id="phalanx-block-optionals" class="clearfix">
							<div class="clearfix">
								<label for="wpPhalanxReason" class="left"><?= wfMsg( 'phalanx-label-reason' ) ?></label>
								<input type="text" id="wpPhalanxReason" name="wpPhalanxReason" class="blue" size="40" />
							</div>
							<div class="clearfix">
								<label for="wpPhalanxLanguages" class="left"><?= wfMsg( 'phalanx-label-lang' ) ?></label>
                                                                <select name="wpPhalanxLanguages" id="wpPhalanxLanguages" class="blue" >
                                                                        <? foreach ($languages as $k => $v) { ?>
                                                                                <option <?=($k == 'all') ? "selected" : ""?> value="<?=$k?>"><?=$v?></option>
                                                                        <? } ?>
                                                                </select>
							</div>
							<div class="clearfix">
								<input type="submit" id="wpPhalanxSubmit" name="wpPhalanxSubmit" value="<?= wfMsg( 'phalanx-add-block' ) ?>" />
								<input type="reset" value="<?= wfMsg( 'phalanx-reset-form' ) ?>" />
							</div>
						</div>


					</form>
				</fieldset>
			</div>

			<div id="phalanx-check-area">
				<fieldset>
				<legend><?= wfMsg( 'phalanx-legend-listing' ) ?></legend>
				<form id="phalanx-filters" method="get" action="/wiki/Special:Phalanx">
					<div id="phalanx-check-options">
						<label for="wpPhalanxCheckBlocker"><?= wfMsg( 'phalanx-view-blocker' ) ?></label>
						<input type="text" id="wpPhalanxCheckBlocker" name="wpPhalanxCheckBlocker" class="blue" size="40" value="" />
						<input type="submit" value="<?= wfMsg( 'phalanx-view-blocks' ) ?>"  />
					</div>

					<div id="phalanx-check-results">
						<?= $listing ?>
					</div>
				</form>
				</fieldset>
			</div>
		</div>

		<div id="phalanx-test-tab-content">
			<fieldset>
				<form id="phalanx-block-test" action="#test">
					<label for="phalanx-block-text"><?= wfMsg( 'phalanx-test-description' ) ?></label>
					<input type="textarea" id="phalanx-block-text" /><br />
					<input type="submit" value="<?= wfMsg( 'phalanx-test-submit' ) ?>" />
				</form>
			</fieldset>
			<fieldset>
				<legend>Test results</legend>
				<div id="phalanx-block-test-result"></div>
			</fieldset>
		</div>
	</div>
</div>
