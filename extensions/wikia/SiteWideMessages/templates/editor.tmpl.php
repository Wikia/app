<!-- s:<?= __FILE__ ?> -->
<div id="PaneNav">
	<a href="<?= $title->getLocalUrl('action=list') ?>"><?= wfMsg('swm-page-title-list') ?></a>
</div>

<div id="PanePreview"<?= empty($formData['messagePreview']) ? ' style="display:none"' : '' ?>>
	<fieldset>
	<legend><?= wfMsg('swm-label-preview') ?></legend>
		<div id="WikiTextPreview">
			<?= empty($formData['messagePreview']) ? '' : $formData['messagePreview'] ?>
		</div>
	</fieldset>
</div>

<div id="PaneCompose">
	<fieldset>
		<legend><?= wfMsg('swm-label-edit') ?></legend>
		<div id="PaneError"><?= isset($formData['errMsg']) ? Wikia::errormsg($formData['errMsg']) : '' ?></div>
		<form method="post" id="msgForm" action="<?= $title->getLocalUrl() ?>">
			<input type="hidden" name="editMsgId" value="<?= $editMsgId ?>" />
			<?php if (!$editMsgId) { ?>
			<fieldset>
				<legend><?= wfMsg('swm-label-recipient') ?></legend>
				<fieldset>
					<legend><?= wfMsg('swm-label-recipient-wikis') ?></legend>
					<table id="sendModeWikisTable">
						<tr>
							<td width="25">
								<input name="mSendModeWikis" id="mSendModeWikisA" type="radio" value="ALL"<?= $formData['sendModeWikis'] == 'ALL' ? ' checked="checked"' : ''?>/>
							</td>
							<td width="180">
								<label for="mSendModeWikisA"><?= wfMsg('swm-label-mode-wikis-all') ?></label>
							</td>
						</tr>

						<tr>
							<td>
								<input name="mSendModeWikis" id="mSendModeWikisH" type="radio" value="HUB"<?= $formData['sendModeWikis'] == 'HUB' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeWikisH"><?= wfMsg('swm-label-mode-wikis-hub') ?></label>
							</td>
							<td>
								<select name="mHubId" id="mHubId" style="width:314px">
								<?php
								foreach ($formData['hubNames'] as $hubId => $hubName) {
									$selected = $hubId == $formData['hubId'] ? ' selected="selected"' : '';
									echo "\t\t\t\t\t\t\t\t<option value=\"$hubId\"$selected>$hubName</option>\n";
								}
								?>
								</select>
							</td>
						</tr>

						<tr>
							<td>
								<input name="mSendModeWikis" id="mSendModeWikisC" type="radio" value="CLUSTER"<?= $formData['sendModeWikis'] == 'CLUSTER' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeWikisC"><?= wfMsg('swm-label-mode-wikis-cluster') ?></label>
							</td>
							<td>
								<select name="mClusterId" id="mClusterId" style="width:314px">
								<?php
								foreach ($formData['clusterNames'] as $clusterId => $clusterName) {
									$selected = $clusterId == $formData['clusterId'] ? ' selected="selected"' : '';
									echo "\t\t\t\t\t\t\t\t<option value=\"$clusterId\"$selected>$clusterName</option>\n";
								}
								?>
								</select>
							</td>
						</tr>

						<tr>
							<td>
								<input name="mSendModeWikis" id="mSendModeWikisW" type="radio" value="WIKI"<?= $formData['sendModeWikis'] == 'WIKI' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeWikisW"><?= wfMsg('swm-label-mode-wikis-wiki') ?></label>
							</td>
							<td>
								<input name="mWikiName" id="mWikiName" type="text" size="48" value="<?= $formData['wikiName'] ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								<input name="mSendModeWikis" id="mSendModeWikisM" type="radio" value="WIKIS"<?= $formData['sendModeWikis'] == 'WIKIS' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeWikisM"><?= wfMsg( 'swm-label-mode-wikis-wiki-multi' ) ?></label>
							</td>
							<td>
								<textarea name="mWikiNames" id="mWikiNames" type="text" rows="10" cols="40" value="<?= $formData['listWikiNames'] ?>"></textarea>
							</td>
							<td>
								<?= wfMsg( 'swm-label-mode-wikis-wiki-multi-hint' ) ?>
							</td>
						</tr>
						<tr>
							<td>
								<input name="mSendModeWikis" id="mSendModeWikisD" type="radio" value="CREATED"<?= $formData['sendModeWikis'] == 'CREATED' ? ' checked="checked"' : ''; ?>/>
							</td>
							<td>
								<label for="mSendModeWikisD"><?= wfMsg( 'swm-label-mode-wikis-created' ) ?></label>
							</td>
							<td>
								<select name="mWikiCreationS" id="mWikiCreationS">
									<option value="after"<?= $formData['wikiCreationDateOption'] == 'after' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-wikis-created-after' ) ?></option>
									<option value="before"<?= $formData['wikiCreationDateOption'] == 'before' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-wikis-created-before' ) ?></option>
									<option value="between"<?= $formData['wikiCreationDateOption'] == 'between' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-wikis-created-between' ) ?></option>
								</select>
								<input name="mWikiCreationDateOne" id="mWikiCreationDateOne" type="text" size="20" value="<?= $formData['wikiCreationDateOne'] ?>" />
								<input name="mWikiCreationDateTwo" id="mWikiCreationDateTwo" type="text" size="20" value="<?= $formData['wikiCreationDateTwo'] ?>" style="display: <?= $formData['wikiCreationDateOption'] == 'between' ? 'inline' : 'none' ?>" />
							</td>
							<td>
								<?= wfMsg( 'swm-label-mode-wikis-created-hint' ) ?>
							</td>
						</tr>
					</table>
				</fieldset>

				<fieldset>
					<legend><?= wfMsg('swm-label-recipient-users') ?></legend>
					<table id="sendModeUsersTable">
						<tr>
							<td width="25">
								<input name="mSendModeUsers" id="mSendModeUsersA" type="radio" value="ALL"<?= $formData['sendModeUsers'] == 'ALL' ? ' checked="checked"' : ''?>/>
							</td>
							<td width="180">
								<label for="mSendModeUsersA"><?= wfMsg('swm-label-mode-users-all') ?></label>
							</td>
						</tr>

						<tr>
							<td width="25">
								<input name="mSendModeUsers" id="mSendModeUsersC" type="radio" value="ACTIVE"<?= $formData['sendModeUsers'] == 'ACTIVE' ? ' checked="checked"' : ''?>/>
							</td>
							<td width="180">
								<label for="mSendModeUsersC"><?= wfMsg('swm-label-mode-users-active') ?></label>
							</td>
						</tr>

						<tr>
							<td>
								<input name="mSendModeUsers" id="mSendModeUsersG" type="radio" value="GROUP"<?= $formData['sendModeUsers'] == 'GROUP' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeUsersG"><?= wfMsg('swm-label-mode-users-group') ?></label>
							</td>
							<td>
								<select name="mGroupNameS" id="mGroupNameS" style="width:116px">
								<?php
								foreach ( $formData['groupNames'] as $groupName ) {
									$groupName = htmlspecialchars( $groupName );
									$selected = $groupName == $formData['groupNameS'] ? ' selected="selected"' : '';
									echo "\t\t\t\t\t\t\t\t<option value=\"$groupName\"$selected>$groupName</option>\n";
								}
								?>
								</select>
								<input name="mGroupName" id="mGroupName" type="text" size="28" value="<?= $formData['groupName'] ?>"/>
							</td>
							<td>
								<?= wfMsg('swm-label-mode-users-group-hint') ?>
							</td>
						</tr>
						<tr>
							<td>
								<input name="mSendModeUsers" id="mSendModeUsersPU" type="radio" value="POWERUSER"<?= $formData['sendModeUsers'] == 'POWERUSER' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeUsersPU"><?= wfMessage( 'swm-label-mode-users-poweruser' )->escaped() ?></label>
							</td>
							<td>
								<?php
									foreach	( $formData[ 'powerUserTypes' ] as $powerUserType ) {
										$html = '<label for="mPowerUserType_' . Sanitizer::encodeAttribute( $powerUserType ) . '">';
											$html .= '<input type="checkbox" name="mPowerUserType[]"';
												$html .= 'id="mPowerUserType_' . Sanitizer::encodeAttribute( $powerUserType ) . '"';
												$html .= 'value="' . Sanitizer::encodeAttribute( $powerUserType ) . '"';
											if ( isset( $formData['mPowerUserType'] ) && in_array( $powerUserType, $formData['mPowerUserType'] ) ) {
												$html .= ' checked="checked"';
											}
											$html .= '>';
										$html .= Sanitizer::escapeHtmlAllowEntities( $powerUserType ) . '</label><br>';
										echo $html;
									}
								?>
							</td>
							<td class="swm-hint">
								<?= wfMessage( 'swm-label-mode-users-poweruser-hint' )->parse() ?>
							</td>
						</tr>

						<tr>
							<td>
								<input name="mSendModeUsers" id="mSendModeUsersU" type="radio" value="USER"<?= $formData['sendModeUsers'] == 'USER' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeUsersU"><?= wfMsg('swm-label-mode-users-user') ?></label>
							</td>
							<td>
								<input name="mUserName" id="mUserName" type="text" size="48" value="<?= $formData['userName'] ?>"/>
							</td>
							<td>
								<?= wfMsg('swm-label-mode-users-user-hint') ?>
							</td>
						</tr>
						<tr>
							<td>
								<input name="mSendModeUsers" id="mSendModeUsersM" type="radio" value="USERS"<?= $formData['sendModeUsers'] == 'USERS' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeUsersM"><?= wfMsg( 'swm-label-mode-users-user-multi' ) ?></label>
							</td>
							<td>
								<textarea name="mUserNames" id="mUserNames" type="text" rows="10" cols="40" value="<?= $formData['listUserNames'] ?>"></textarea>
							</td>
							<td>
								<?= wfMsg( 'swm-label-mode-users-user-multi-hint' ) ?>
							</td>
						</tr>
						<tr>
							<td>
								<input name="mSendModeUsers" id="mSendModeUsersIP" type="radio" value="ANONS"<?= $formData['sendModeUsers'] == 'ANONS' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mSendModeUsersIP"><?= wfMsg( 'swm-label-mode-users-anon' ) ?></label>
							</td>
							<td colspan="2">
								<?= wfMsg( 'swm-label-mode-users-anon-hint' ) ?>
							</td>
						</tr>
						<tr>
							<td>
								<input name="mSendModeUsers" id="mSendModeUsersReg" type="radio" value="REGISTRATION"<?= $formData['sendModeUsers'] == 'REGISTRATION' ? ' checked="checked"' : ''; ?>/>
							</td>
							<td>
								<label for="mSendModeUsersReg"><?= wfMsg( 'swm-label-mode-users-registration' ) ?></label>
							</td>
							<td>
								<select name="mRegistrationS" id="mRegistrationS">
									<option value="after"<?= $formData['registrationDateOption'] == 'after' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-users-registration-after' ) ?></option>
									<option value="before"<?= $formData['registrationDateOption'] == 'before' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-users-registration-before' ) ?></option>
									<option value="between"<?= $formData['registrationDateOption'] == 'between' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-users-registration-between' ) ?></option>
								</select>
								<input name="mRegistrationDateOne" id="mRegistrationDateOne" type="text" size="20" value="<?= $formData['registrationDateOne'] ?>" />
								<input name="mRegistrationDateTwo" id="mRegistrationDateTwo" type="text" size="20" value="<?= $formData['registrationDateTwo'] ?>" style="display: <?= $formData['registrationDateOption'] == 'between' ? 'inline' : 'none' ?>" />
							</td>
							<td>
								<?= wfMsg( 'swm-label-mode-users-registration-hint' ) ?>
							</td>
						</tr>
						<tr>
							<td>
								<input name="mSendModeUsers" id="mSendModeUsersEC" type="radio" value="EDITCOUNT"<?= $formData['sendModeUsers'] == 'EDITCOUNT' ? ' checked="checked"' : ''; ?>/>
							</td>
							<td>
								<label for="mSendModeUsersEC"><?= wfMsg( 'swm-label-mode-users-editcount' ) ?></label>
							</td>
							<td colspan="2">
								<select name="mEditCountS" id="mEditCountS">
									<option value="more"<?= $formData['editCountOption'] == 'more' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-users-editcount-more' ) ?></option>
									<option value="less"<?= $formData['editCountOption'] == 'less' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-users-editcount-less' ) ?></option>
									<option value="between"<?= $formData['editCountOption'] == 'between' ? ' selected="selected"' : ''; ?>><?= wfMsg( 'swm-mode-users-editcount-between' ) ?></option>
								</select>
								<input name="mEditCountOne" id="mEditCountOne" type="text" size="20" value="<?= $formData['editCountOne'] ?>" />
								<input name="mEditCountTwo" id="mEditCountTwo" type="text" size="20" value="<?= $formData['editCountTwo'] ?>" style="display: <?= $formData['editCountOption'] == 'between' ? 'inline' : 'none' ?>" />
							</td>
						</tr>
					</table>
				</fieldset>
			</fieldset>
			<?php } //do not show this info when editing ?>

			<fieldset>
				<legend><?= wfMsg('swm-label-expiration') ?></legend>
				<?php if (!$editMsgId) { ?>
				<select name="mExpireTime" id="mExpireTime">
				<?php
				$days = explode(',', wfMsg('swm-days'));
				$expireOptions = explode(',', wfMsg('swm-expire-options'));
				foreach ($expireOptions as $expireOption) {
					if (ctype_digit($expireOption)) {
						if ($expireOption === '0') {
							$expireText = $days[0];
						} else {
							// FIXME: Bad i18n. Only works if 1 is singular and all others are exactly one and the same plural.
							//        Have a look at phase3/languages/classes on how things really work.
							$expireText = "$expireOption " . ($days[min($expireOption, 2)+2]);
						}
					} elseif (preg_match('/^\d+h$/', $expireOption)) {
						$expireValue = substr($expireOption, 0, -1);
						$expireText = "$expireValue " . ($days[min($expireValue, 2)]);
					} else {
						//wrong entry - go to the next one
						continue;
					}
					$selected = $expireOption == $formData['expireTime'] ? ' selected="selected"' : '';
					echo "\t\t\t\t\t<option value=\"$expireOption\"$selected>$expireText</option>\n";
				}
				?>
				</select>
				<?php } //do not show this info when editing ?>
				<input name="mExpireTimeS" id="mExpireTimeS" type="text" size="20" value="<?= $formData['expireTimeS'] ?>"/>
				<span><?= wfMsg( 'swm-label-expiration-hint' ) ?></span>
			</fieldset>

			<?php if (!$editMsgId) { ?>
			<fieldset>
				<legend><?= wfMsg('swm-label-language') ?></legend>
				<?php
					if ( !empty( $supportedLanguages ) ) {
						foreach ($supportedLanguages as $lang) {
#							$selectedLang = false;
#							if ( !empty( $formData[$lang] ) ) {
#								$selectedLang = true;
#							}

							echo "<input type='checkbox' name='mLang[]' id='swm-lang-$lang' class='swm-lang-checkbox' value='$lang'";
							if (isset($formData['mLang']) && in_array( $lang, $formData['mLang'] ) ) {
								echo " checked='checked'";
							}
#							if ( $selectedLang ) {
#								echo " checked='checked'";
#							}
							echo " />";
							echo "<label for='swm-lang-$lang'>$lang</label><br />";
						}
						echo "<input type='checkbox' name='mLang[]' id='swm-lang-other' class='swm-lang-checkbox' value='other'";
						if (isset($formData['mLang']) && in_array( "other", $formData['mLang'] ) ) {
							echo " checked='checked'";
						}
						echo " />";
						echo "<label for='swm-lang-other'>" . wfMsg( 'swm-lang-other' ) . "</label>&nbsp;";
					}
				?>
				<br />
				<input type="button" onclick="jQuery('input.swm-lang-checkbox').attr('checked', 'checked');" value="<?= wfMsg('swm-button-lang-checkall'); ?>" />
				<input type="button" onclick="jQuery('input.swm-lang-checkbox').attr('checked', '');" value="<?= wfMsg('swm-button-lang-checknone'); ?>" />
			</fieldset>
			<?php } //do not show this info when editing ?>

			<fieldset>
				<legend><?= wfMsg('swm-label-content') ?></legend>
				<textarea name="mContent" id="mContent" cols="112" rows="10"><?= empty($formData['messageContent']) ? '' : $formData['messageContent'] ?></textarea>
			</fieldset>

			<div id="PaneButtons">
				<input name="mAction" type="submit" value="<?= wfMsg('swm-button-preview') ?>" id="fPreview"/>
				<input name="mAction" type="submit" value="<?= $editMsgId ? wfMsg('swm-button-save') : wfMsg('swm-button-send') ?>" id="fSend"/>
				<input name="mAction" type="reset" value="<?= wfMsg('swm-button-new') ?>" id="fNew"/>
				<?= wfMsg('swm-taskmanager-hint') ?>
			</div>
		</form>
	</fieldset>
</div>

<script type="text/javascript">
jQuery( document ).ready( function ( $ ) {
	function grayOut( e ) {
		switch ( e.target.id ) {
			case 'mSendModeWikisC':
				$( '#mSendModeUsersA' ).prop( 'disabled', true );
				$( '#mSendModeUsersReg' ).prop( 'disabled', true );
				$( '#mSendModeUsersIP' ).prop( 'disabled', true );
				if ( $( '#mSendModeUsersA' ).prop( 'checked' ) ||
					$( '#mSendModeUsersReg' ).prop( 'checked' ) ||
					$( '#mSendModeUsersIP' ).prop( 'checked' )
				) {
					$( '#mSendModeUsersC' ).prop( 'checked', true );
				}
				break;
			case 'mSendModeWikisH':
			case 'mSendModeWikisW':
			case 'mSendModeWikisM':
			case 'mSendModeWikisD':
				$( '#mSendModeUsersA' ).prop( 'disabled', true );
				$( '#mSendModeUsersReg' ).prop( 'disabled', true );
				$( '#mSendModeUsersIP' ).prop( 'disabled', false );
				if ( $( '#mSendModeUsersA' ).prop( 'checked' ) ||
					$( '#mSendModeUsersReg' ).prop( 'checked' )
				) {
					$( '#mSendModeUsersC' ).prop( 'checked', true );
				}
				break;
			case 'mSendModeUsersPU':
				$( '#mSendModeWikisA' ).prop( 'disabled', true );
				$( '#mSendModeWikisC' ).prop( 'disabled', true );
				$( '#mSendModeWikisH' ).prop( 'disabled', true );
				$( '#mSendModeWikisW' ).prop( 'disabled', true );
				$( '#mSendModeWikisM' ).prop( 'disabled', true );
				$( '#mSendModeWikisD' ).prop( 'disabled', true );
				break;
			case 'mSendModeUsersU':
			case 'mSendModeUsersM':
				$( '#mSendModeWikisA' ).prop( 'disabled', true );
				$( '#mSendModeWikisC' ).prop( 'disabled', true );
				$( '#mSendModeWikisH' ).prop( 'disabled', true );
				$( '#mSendModeWikisW' ).prop( 'disabled', true );
				$( '#mSendModeWikisM' ).prop( 'disabled', true );
				$( '#mSendModeWikisD' ).prop( 'disabled', true );
				$( 'input.swm-lang-checkbox' ).prop( 'disabled', true );
				break;
			case 'mSendModeUsersIP':
				$( '#mSendModeWikisA' ).prop( 'disabled', false );
				$( '#mSendModeWikisC' ).prop( 'disabled', true );
				$( '#mSendModeWikisH' ).prop( 'disabled', false );
				$( '#mSendModeWikisW' ).prop( 'disabled', false );
				$( '#mSendModeWikisM' ).prop( 'disabled', false );
				$( '#mSendModeWikisD' ).prop( 'disabled', false );
				$( 'input.swm-lang-checkbox' ).prop( 'disabled', false );
				break;
			case 'mSendModeUsersReg':
				$( '#mSendModeWikisA' ).prop( 'disabled', false );
				$( '#mSendModeWikisC' ).prop( 'disabled', true );
				$( '#mSendModeWikisH' ).prop( 'disabled', true );
				$( '#mSendModeWikisW' ).prop( 'disabled', true );
				$( '#mSendModeWikisM' ).prop( 'disabled', true );
				$( '#mSendModeWikisD' ).prop( 'disabled', true );
				$( 'input.swm-lang-checkbox' ).prop( 'disabled', false );
				break;
			case 'mSendModeUsersEC':
				$( '#mSendModeWikisA' ).prop( 'disabled', false );
				$( '#mSendModeWikisC' ).prop( 'disabled', true );
				$( '#mSendModeWikisH' ).prop( 'disabled', true );
				$( '#mSendModeWikisW' ).prop( 'disabled', false );
				$( '#mSendModeWikisM' ).prop( 'disabled', false );
				$( '#mSendModeWikisD' ).prop( 'disabled', false );
				$( 'input.swm-lang-checkbox' ).prop( 'disabled', false );
				break;
			default:
				if ( $( '#mSendModeWikisA' ).prop( 'checked' ) ) {
					$( '#mSendModeUsersA' ).prop( 'disabled', false );
					$( '#mSendModeUsersReg' ).prop( 'disabled', false );
					$( '#mSendModeUsersIP' ).prop( 'disabled', false );
				}
				$( '#mSendModeWikisA' ).prop( 'disabled', false );
				$( '#mSendModeWikisH' ).prop( 'disabled', false );
				$( '#mSendModeWikisW' ).prop( 'disabled', false );
				$( '#mSendModeWikisM' ).prop( 'disabled', false );
				$( '#mSendModeWikisD' ).prop( 'disabled', false );
				$( 'input.swm-lang-checkbox' ).prop( 'disabled', false );
		}
	}
	$( '#mSendModeWikisA' ).add( '#mSendModeWikisH' ).add( '#mSendModeWikisC' )
		.add( '#mSendModeWikisW' ).add( '#mSendModeWikisM' ).add( '#mSendModeWikisD' )
		.add( '#mSendModeUsersA' ).add( '#mSendModeUsersC' ).add( '#mSendModeUsersG' )
		.add( '#mSendModeUsersPU' ).add( '#mSendModeUsersU' ).add( '#mSendModeUsersM' )
		.add( '#mSendModeUsersIP' ).add( '#mSendModeUsersReg' ).add( '#mSendModeUsersEC' )
		.on( 'click', grayOut );

	$( '#mRegistrationS' ).change( function () {
		if ( $( this ).val() === 'between' ) {
			$( '#mRegistrationDateTwo' ).show();
		} else {
			$( '#mRegistrationDateTwo' ).hide();
		}
	} );
	$( '#mEditCountS' ).change( function () {
		if ( $( this ).val() === 'between' ) {
			$( '#mEditCountTwo' ).show();
		} else {
			$( '#mEditCountTwo' ).hide();
		}
	} );
	$( '#mWikiCreationS' ).change( function () {
		if ( $( this ).val() === 'between' ) {
			$( '#mWikiCreationDateTwo' ).show();
		} else {
			$( '#mWikiCreationDateTwo' ).hide();
		}
	} );
} );
</script>
<!-- e:<?= __FILE__ ?> -->
