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
				<table id="sendModeTable">
					<tr>
						<td width="25">
							<input name="mSendMode" id="mSendModeA" type="radio" value="ALL"<?= $formData['sendMode'] == 'ALL' ? ' checked="checked"' : ''?>/>
						</td>
						<td width="180">
							<label for="mSendModeA"><?= wfMsg('swm-label-mode-all') ?></label>
						</td>
					</tr>

					<tr>
						<td>
							<input name="mSendMode" id="mSendModeU" type="radio" value="USER"<?= $formData['sendMode'] == 'USER' ? ' checked="checked"' : ''?>/>
						</td>
						<td>
							<label for="mSendModeU"><?= wfMsg('swm-label-mode-user') ?></label>
						</td>
						<td>
							<input name="mUserName" id="mUserName" type="text" size="48" value="<?= $formData['userName'] ?>"/>
						</td>
					</tr>

					<tr>
						<td>
							<input name="mSendMode" id="mSendModeW" type="radio" value="WIKI"<?= $formData['sendMode'] == 'WIKI' ? ' checked="checked"' : ''?>/>
						</td>
						<td>
							<label for="mSendModeW"><?= wfMsg('swm-label-mode-wiki') ?></label>
						</td>
						<td>
							<input name="mWikiName" id="mWikiName" type="text" size="48" value="<?= $formData['wikiName'] ?>"/>
						</td>
					</tr>

					<tr>
						<td>
							<input name="mSendMode" id="mSendModeH" type="radio" value="HUB"<?= $formData['sendMode'] == 'HUB' ? ' checked="checked"' : ''?>/>
						</td>
						<td>
							<label for="mSendModeH"><?= wfMsg('swm-label-mode-hub') ?></label>
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
						<td>
							<?= wfMsg('swm-label-mode-hub-hint') ?>
						</td>
					</tr>

					<tr>
						<td>
							<input name="mSendMode" id="mSendModeG" type="radio" value="GROUP"<?= $formData['sendMode'] == 'GROUP' ? ' checked="checked"' : ''?>/>
						</td>
						<td>
							<label for="mSendModeG"><?= wfMsg('swm-label-mode-group') ?></label>
						</td>
						<td>
							<select name="mGroupNameS" id="mGroupNameS" style="width:116px">
							<?php
							foreach ($formData['groupNames'] as $groupName) {
								$groupName = htmlspecialchars($groupName);
								$selected = $groupName == $formData['groupNameS'] ? ' selected="selected"' : '';
								echo "\t\t\t\t\t\t\t\t<option value=\"$groupName\"$selected>$groupName</option>\n";
							}
							?>
							</select>
							<input name="mGroupName" id="mGroupName" type="text" size="28" value="<?= $formData['groupName'] ?>"/>
						</td>
						<td>
							<?= wfMsg('swm-label-mode-group-hint') ?>
						</td>
					</tr>
				</table>
				<div style="padding-left:30px">
					<table>
						<tr>
							<td>
								<input name="mGroupMode" id="mGroupModeA" type="radio" value="ALL"<?= $formData['groupMode'] == 'ALL' ? ' checked="checked"' : ''?>/>
							</td>
							<td>
								<label for="mGroupModeA"><?= wfMsg('swm-label-mode-all') ?></label>
							</td>
						</tr>

						<tr>
							<td width="25">
								<input name="mGroupMode" id="mGroupModeW" type="radio" value="WIKI"<?= $formData['groupMode'] == 'WIKI' ? ' checked="checked"' : ''?>/>
							</td>
							<td width="150">
								<label for="mGroupModeW"><?= wfMsg('swm-label-mode-wiki') ?></label>
							</td>
							<td>
								<input name="mGroupWikiName" id="mGroupWikiName" type="text" size="48" value="<?= $formData['groupWikiName'] ?>"/>
							</td>
						</tr>
					</table>
				</div>
			</fieldset>

			<fieldset>
				<legend><?= wfMsg('swm-label-expiration') ?></legend>
				<select name="mExpireTime" id="mExpireTime">
				<?php
				$days = explode(',', wfMsg('swm-days'));
				$expireOptions = explode(',', wfMsg('swm-expire-options'));
				foreach ($expireOptions as $expireOption) {
					if (ctype_digit($expireOption)) {
						if ($expireOption === '0') {
							$expireText = $days[0];
						} else {
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
			</fieldset>
			<?php } //do not show this info when editing ?>

			<fieldset>
				<legend><?= wfMsg('swm-label-content') ?></legend>
				<textarea name="mContent" id="mContent" cols="30" rows="10"><?= empty($formData['messageContent']) ? '' : $formData['messageContent'] ?></textarea>
			</fieldset>

			<div id="PaneButtons">
				<input name="mAction" type="submit" value="<?= wfMsg('swm-button-preview') ?>" id="fPreview"/>
				<input name="mAction" type="submit" value="<?= $editMsgId ? wfMsg('swm-button-save') : wfMsg('swm-button-send') ?>" id="fSend"/>
				<input name="mAction" type="reset" value="<?= wfMsg('swm-button-new') ?>" id="fNew"/>
			</div>
		</form>
	</fieldset>
</div>
<!-- e:<?= __FILE__ ?> -->