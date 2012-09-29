<div id="UPPLightbox" class="UPPLightbox">
	<h1><?= wfMsg('userprofilepage-edit-modal-header'); ?></h1>
	
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
		<li class="interview">
			<div>
				<button id="UPPLightboxPrevQuestionBtn">&lt;</button>
				<span id="UPPLightboxCurrQuestionCaption"></span>
				<button id="UPPLightboxNextQuestionBtn">&gt;</button>
			</div>
			<div>
				<em><span id="UPPLightboxCurrQuestionBody"></span></em>
			</div>
			<div>
				<textarea id="UPPLightboxCurrQuestionAnswerBody"></textarea>
			</div>
			<br>
			<button id="UPPLightboxInterviewCancelBtn"><?= wfMsg('userprofilepage-lightbox-interview-cancel'); ?></button>
			<button id="UPPLightboxInterviewSaveBtn"><?= wfMsg('userprofilepage-lightbox-interview-save'); ?></button>
		</li>
		
		<li class="avatar">
			<form id="usersAvatar" name="usersAvatar" method="post" enctype="multipart/form-data" action="/wikia.php?controller=UserProfilePage&method=onSubmitUsersAvatar&format=json&userId=<?= $userId; ?>">
				<div class="column avatar">
					<?= $avatar; ?>
				</div>
				<div class="column avatar-options">
					<? if($isUploadsPossible): ?>
						<label><?= wfMsg('user-identity-box-avatar-upload-avatar'); ?></label>
						<input type="hidden" name="UPPLightboxDefaultAvatar" id="UPPLightboxDefaultAvatar" value="" >
						<input type="hidden" name="UPPLightboxFbAvatar" id="UPPLightboxFbAvatar" value="" >
						<input type="hidden" name="MAX_FILE_SIZE" value="<?= $avatarMaxSize; ?>">
						<input type="file" name="UPPLightboxAvatar" id="UPPLightboxAvatar">
					<? endif; ?>
					
					<? if( $isUserPageOwner ): ?>
						<p id="facebookConnectAvatar">
							<label><?= wfMsg('user-identity-box-avatar-fb-import-avatar'); ?></label>
							<?= $fbAvatarConnectButton; ?>
						</p>
					<? endif; ?>
					
					<? if( !empty($defaultAvatars) ): ?>
						<label><?= wfMsg('user-identity-box-avatar-choose-avatar'); ?></label>
						<ul class="sample-avatars">
							<? foreach($defaultAvatars as $avatar): ?>
								<li><img width="40" height="40" src="<?= $avatar['url']; ?>" class="<?= $avatar['name']; ?>"></li>
							<? endforeach; ?>
						</ul>
					<? endif; ?>
				</div>
			</form>
		</li>
		
		<li class="about">
			<form id="userData" name="userData">
				<div class="column">
					<label><?= wfMsg('user-identity-box-about-name'); ?></label>
					<input type="text" name="name" value="<?= strip_tags($user['realName']); ?>" maxlength="<?= $charLimits['name']; ?>" />
					
					<label><?= wfMsg('user-identity-box-about-location'); ?></label>
					<input type="text" name="location" value="<?= strip_tags($user['location']); ?>" maxlength="<?= $charLimits['location']; ?>" />
					
					<label><?= wfMsg('user-identity-box-about-birthday'); ?></label>
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
					
					<label><?= wfMsg('user-identity-box-about-occupation'); ?></label>
					<input type="text" name="occupation" value="<?= strip_tags($user['occupation']); ?>" maxlength="<?= $charLimits['occupation']; ?>" />
					
					<label><?= wfMsg('user-identity-box-about-gender'); ?></label>
					<input type="text" name="gender" value="<?= strip_tags($user['gender']); ?>" maxlength="<?= $charLimits['gender']; ?>" />
				</div>
				
				<div class="column">
					<? if( $isUserPageOwner ): ?>
						<p id="facebookConnect" <? if( !empty($user['fbPage']) ): ?>style="display: none;"<? endif; ?>>
							<label><?= wfMsg('user-identity-box-import-from-fb'); ?></label>
							<?= $fbConnectButton; ?>
						</p>
						<p id="facebookPage" <? if( empty($user['fbPage']) ): ?>style="display: none;"<? endif; ?>>
							<label><?= wfMsg('user-identity-box-fb-page'); ?></label>
							<input type="text" name="fbPage" value="<?= $user['fbPage']; ?>"><br>
							<a href="<?= $facebookPrefsLink ?>#mw-prefsection-fbconnect-prefstext"><?= wfMsg('user-identity-box-fb-prefs'); ?></a>
						</p>
					<? endif; ?>
					
					<label><?= wfMsg('user-identity-box-about-website'); ?></label>
					<input type="text" name="website" value="<?= strip_tags($user['website']); ?>">
					
					<label><?= wfMsg('user-identity-box-about-tweet'); ?></label>
					<span class="tweet-at">@</span>
					<input type="text" name="twitter" value="<?= strip_tags($user['twitter']); ?>">
					
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
					<p id="hideEditsWikis">
						<input type="checkbox" name="hideEditsWikis" value="1" <?php if (array_key_exists('hideEditsWikis', $user) && $user['hideEditsWikis']):?>checked="checked"<?php endif;?>/><?= wfMsg('user-identity-box-hide-edits-wikis'); ?>
					</p>
					
				</div>
			</form>
		</li>
	</ul>
	
	<div class="modalToolbar">
		<button class="cancel secondary"><?= wfMsg('user-identity-box-avatar-cancel'); ?></button>
		<button class="save"><?= wfMsg('user-identity-box-avatar-save'); ?></button>
	</div>
</div>
