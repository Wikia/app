<div id="UPPLightbox" class="UPPLightbox">
	<div id="errorBox">
		<div id="wpError"></div>
	</div>

	<ul class="tabs">
		<?
		foreach ($tabs as $tab) {
				$tabclass = ($selectedTab === $tab['id']) ? 'selected' : '';
		?>
				<li data-tab="<?= $tab['id']; ?>" class="<?= $tabclass ?>">
					<a href="#"><?= $tab[ 'name' ]; ?></a>
				</li>
		<? } ?>
	</ul>

	<ul class="tab-content">
		<li class="avatar">
			<form id="usersAvatar" class="WikiaForm" name="usersAvatar" method="post" enctype="multipart/form-data"
			action="/wikia.php?controller=UserProfilePage&method=onSubmitUsersAvatar&format=json&userId=<?= $userId; ?>">

				<?= $avatar; ?>

				<fieldset class="avatar-options">
					<? if($isUploadsPossible): ?>
						<div class="input-group">
							<label for="UPPLightboxAvatar"><?= wfMsg('user-identity-box-avatar-upload-avatar'); ?></label>
							<input type="file" name="UPPLightboxAvatar" id="UPPLightboxAvatar">
							<input type="hidden" name="UPPLightboxDefaultAvatar" id="UPPLightboxDefaultAvatar" value="" >
							<input type="hidden" name="UPPLightboxFbAvatar" id="UPPLightboxFbAvatar" value="" >
							<input type="hidden" name="MAX_FILE_SIZE" value="<?= $avatarMaxSize; ?>">
						</div>
					<? endif; ?>

					<? if( $isUserPageOwner ): ?>
						<div class ="input-group" id="facebookConnectAvatar">
							<label><?= wfMsg('user-identity-box-avatar-fb-import-avatar'); ?></label>
							<?= $fbAvatarConnectButton; ?>
						</div>
					<? endif; ?>

					<? if( !empty($defaultAvatars) ): ?>
						<div class ="input-group">
							<label><?= wfMsg('user-identity-box-avatar-choose-avatar'); ?></label>
							<ul class="sample-avatars">
								<? foreach($defaultAvatars as $avatar): ?>
									<li><img width="40" height="40" src="<?= $avatar['url']; ?>" class="<?= $avatar['name']; ?>"></li>
								<? endforeach; ?>
							</ul>
						</div>
					<? endif; ?>
				</fieldset>

			</form>
		</li>

		<li class="about">
			<form id="userData" class="WikiaForm" name="userData">
				<div class="input-group">
					<label for="name" ><?= wfMsg('user-identity-box-about-name'); ?></label>
					<input type="text" name="name" value="<?= $user['realName']; ?>" maxlength="<?= $charLimits['name']; ?>" />
				</div>
				<div class="input-group">
					<label for="location"><?= wfMsg('user-identity-box-about-location'); ?></label>
					<input type="text" name="location" value="<?= $user['location']; ?>" maxlength="<?= $charLimits['location']; ?>" />
				</div>
				<div class="input-group">
					<label for="month"><?= wfMsg('user-identity-box-about-birthday'); ?></label>
					<select id="userBDayMonth" name="month">
						<option value="0">--</option>
						<?php
						$selectedMonth = isset($user['birthday']['month']) ? intval($user['birthday']['month']) : 0;
						for( $i = 1; $i < 13; $i++ ) {
							echo Xml::option( F::app()->wg->Lang->getMonthName($i), $i, $selectedMonth === $i );
						}
						?>
					</select>
					<select id="userBDayDay" name="day">
						<option value="0">--</option>
						<?php
						if( !empty($days) ) {
							$selectedDay = isset($user['birthday']['day']) ? intval($user['birthday']['day']) : 0;
							for($i = 1; $i <= $days; $i++) {
								echo Xml::option( $i, $i, $selectedDay === $i );
							}
						}
						?>
					</select>
				</div>
				<div class="input-group">
					<label for="occupation"><?= wfMsg('user-identity-box-about-occupation'); ?></label>
					<input type="text" name="occupation" value="<?= $user['occupation']; ?>" maxlength="<?= $charLimits['occupation']; ?>" />
				</div>
				<div class="input-group">
					<label for="gender"><?= wfMsg('user-identity-box-about-gender'); ?></label>
					<input type="text" name="gender" value="<?= $user['gender']; ?>" maxlength="<?= $charLimits['gender']; ?>" />
				</div>
				<? if( $isUserPageOwner ): ?>
					<div class="input-group" id="facebookConnect"  <? if( !empty($user['fbPage']) ): ?>style="display: none;"<? endif; ?> >
						<label><?= wfMsg('user-identity-box-import-from-fb'); ?></label>
							<?= $fbConnectButton; ?>
					</div>
					<div class="input-group" id="facebookPage" <? if( empty($user['fbPage']) ): ?>style="display: none;"<? endif;
					?>>
						<label for="fbPage"><?= wfMsg('user-identity-box-fb-page'); ?></label>
						<input type="text" name="fbPage" value="<?= $user['fbPage']; ?>"><br>
						<a href="<?= $facebookPrefsLink ?>#mw-prefsection-fbconnect-prefstext"><?= wfMsg('user-identity-box-fb-prefs'); ?></a>
					</div>
				<? endif; ?>
				<div class="input-group">
					<label for="website"><?= wfMsg('user-identity-box-about-website'); ?></label>
					<input type="text" name="website" value="<?= $user['website']; ?>">
				</div>
				<div class="input-group">
					<label for="twitter"><?= wfMsg('user-identity-box-about-tweet'); ?></label>
					<span class="tweet-at">@</span>
					<input type="text" name="twitter" value="<?= $user['twitter']; ?>">
				</div>
				<div class="input-group">
					<label><?= wfMsg('user-identity-box-about-fav-wikis'); ?></label>
					<a class="favorite-wikis-refresh wikia-chiclet-button" href="#"><img src="<?= $wgBlankImgUrl ?>"></a>
					<ul class="favorite-wikis">
					<? foreach($user['topWikis'] as $key => $wiki): ?>
						<li data-wiki-id="<?= $wiki['id']; ?>">
							<span><?= $wiki['wikiName']; ?></span> <img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete">
							</li>
					<? endforeach; ?>
						<li class="join-more-wikis"><span><?= wfMsg('user-identity-box-join-more-wikis'); ?></span></li>
					</ul>
					<label for="hideEditsWikis">
						<input type="checkbox" name="hideEditsWikis" id="hideEditsWikis" value="1" <?php if (array_key_exists
						('hideEditsWikis', $user) && $user['hideEditsWikis']):?>checked="checked"<?php endif;?>/><?= wfMsg('user-identity-box-hide-edits-wikis'); ?>
					</label>
				</div>
			</form>
		</li>
	</ul>
</div>
