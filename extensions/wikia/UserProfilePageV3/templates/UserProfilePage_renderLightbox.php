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
							<label for="UPPLightboxAvatar">
								<button id="UPPLightboxAvatarUpload"><?= wfMessage( 'user-identity-box-avatar-upload-avatar' )->escaped(); ?></button>
							</label>
							<input type="file" name="UPPLightboxAvatar" id="UPPLightboxAvatar">
							<input type="hidden" name="UPPLightboxDefaultAvatar" id="UPPLightboxDefaultAvatar" value="" >
							<input type="hidden" name="UPPLightboxFbAvatar" id="UPPLightboxFbAvatar" value="" >
							<input type="hidden" name="MAX_FILE_SIZE" value="<?= $avatarMaxSize; ?>">
						</div>
					<? endif; ?>

					<? if( !empty($defaultAvatars) ): ?>
						<div class ="input-group">
							<label><?= wfMessage( 'user-identity-box-avatar-choose-avatar' )->escaped(); ?></label>
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
					<label for="name" ><?= wfMessage( 'user-identity-box-about-name' )->escaped(); ?></label>
					<input type="text" name="name" value="<?= $user['realName']; ?>" maxlength="<?= $charLimits['name']; ?>" />
				</div>
				<div class="input-group">
					<label for="location"><?= wfMessage( 'user-identity-box-about-location' )->escaped(); ?></label>
					<input type="text" name="location" value="<?= $user['location']; ?>" maxlength="<?= $charLimits['location']; ?>" />
				</div>
				<div class="input-group">
					<label for="month"><?= wfMessage( 'user-identity-box-about-birthday' )->escaped(); ?></label>
					<select id="userBDayMonth" name="month">
						<option value="0">--</option>
						<?php
						$selectedMonth = isset($user['birthday']['month']) ? intval($user['birthday']['month']) : 0;
						for( $i = 1; $i < 13; $i++ ) {
							echo Xml::option( $app->wg->Lang->getMonthName($i), $i, $selectedMonth === $i );
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
					<label for="occupation"><?= wfMessage( 'user-identity-box-about-occupation' )->escaped(); ?></label>
					<input type="text" name="occupation" value="<?= $user['occupation']; ?>" maxlength="<?= $charLimits['occupation']; ?>" />
				</div>
				<div class="input-group">
					<label for="gender"><?= wfMessage( 'user-identity-box-about-gender' )->escaped(); ?></label>
					<input type="text" name="gender" value="<?= $user['gender']; ?>" maxlength="<?= $charLimits['gender']; ?>" />
				</div>
				<div class="input-group">
					<label for="website"><?= wfMessage( 'user-identity-box-about-website' )->escaped(); ?></label>
					<input type="text" name="website" value="<?= $user['website']; ?>">
				</div>
				<div class="input-group">
					<label for="twitter"><?= wfMessage( 'user-identity-box-about-tweet' )->escaped(); ?></label>
					<span class="tweet-at">@</span>
					<input type="text" name="twitter" value="<?= $user['twitter']; ?>">
				</div>
				<div class="input-group">
					<label><?= wfMessage( 'user-identity-box-about-fav-wikis' )->escaped(); ?></label>
					<a class="favorite-wikis-refresh wikia-chiclet-button" href="#"><img src="<?= $wgBlankImgUrl ?>"></a>
					<ul class="favorite-wikis">
					<? foreach($user['topWikis'] as $key => $wiki): ?>
						<li data-wiki-id="<?= $wiki['id']; ?>">
							<span><?= $wiki['wikiName']; ?></span> <img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete">
							</li>
					<? endforeach; ?>
						<li class="join-more-wikis"><span><?= wfMessage( 'user-identity-box-join-more-wikis' )->escaped(); ?></span></li>
					</ul>
					<label for="hideEditsWikis">
						<input type="checkbox" name="hideEditsWikis" id="hideEditsWikis" value="1" <?php if (array_key_exists
						('hideEditsWikis', $user) && $user['hideEditsWikis']):?>checked="checked"<?php endif;?>/><?= wfMessage( 'user-identity-box-hide-edits-wikis' )->escaped(); ?>
					</label>
				</div>
			</form>
		</li>
	</ul>
</div>
