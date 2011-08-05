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
					<img src="/skins/common/images/ajax.gif" class="avatar-loader" style="display: none;">
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
					<input type="text" name="name" value="<?= htmlentities($user['realName'], ENT_COMPAT, 'UTF-8'); ?>">

					<label><?= wfMsg('user-identity-box-about-location'); ?></label>
					<input type="text" name="location" value="<?= htmlentities($user['location'], ENT_COMPAT, 'UTF-8'); ?>">

					<label><?= wfMsg('user-identity-box-about-birthday'); ?></label>
					<select id="userBDayMonth" name="month">
						<option value="0">--</option>
						<? foreach($months as $month): ?>
							<option value="<?= $month['no']; ?>" <? if( isset($user['birthday']['month']) && $user['birthday']['month'] === $month['no'] ):?>selected="selected"<? endif; ?>><?= $month['month']; ?></option>
						<? endforeach; ?>
					</select>
					<select id="userBDayDay" name="day">
						<option value="0">--</option>
						<? if( !empty($days) ): ?>
							<? for($i = 1; $i <= $days; $i++): ?>
								<option value="<?= $i; ?>" <? if( isset($user['birthday']['day']) && intval($user['birthday']['day']) === $i):?>selected="selected"<? endif; ?>><?= $i; ?></option>
							<? endfor; ?>
						<? endif; ?>
					</select>
					
					<label><?= wfMsg('user-identity-box-about-occupation'); ?></label>
					<input type="text" name="occupation" value="<?= htmlentities($user['occupation'], ENT_COMPAT, 'UTF-8'); ?>">
					
					<label><?= wfMsg('user-identity-box-about-gender'); ?></label>
					<input type="text" name="gender" value="<?= htmlentities($user['gender'], ENT_COMPAT, 'UTF-8'); ?>">
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
							<a href="<?= $facebookPrefsLink ?>#prefsection-8"><?= wfMsg('user-identity-box-fb-prefs'); ?></a>
						</p>
					<? endif; ?>
					
					<label><?= wfMsg('user-identity-box-about-website'); ?></label>
					<input type="text" name="website" value="<?= htmlentities($user['website'], ENT_COMPAT, 'UTF-8'); ?>">
					
					<label><?= wfMsg('user-identity-box-about-tweet'); ?></label>
					<span class="tweet-at">@</span>
					<input type="text" name="twitter" value="<?= htmlentities($user['twitter'], ENT_COMPAT, 'UTF-8'); ?>">
					
					<label><?= wfMsg('user-identity-box-about-fav-wikis'); ?></label>
					<a class="favorite-wikis-refresh wikia-chiclet-button" href="#"><img src="<?= $wgBlankImgUrl ?>"></a>
					<ul class="favorite-wikis">
					<? foreach($user['topWikis'] as $favWikiId => $wiki): ?>
						<li data-wiki-id="<?= $favWikiId; ?>">
							<span><?= $wiki['wikiName']; ?></span> <img src="<?= $wgBlankImgUrl ?>" class="sprite-small delete">
							</li>
					<? endforeach; ?>
						<li class="join-more-wikis"><span><?= wfMsg('user-identity-box-join-more-wikis'); ?></span></li>
					</ul>
					
				</div>
			</form>
			
			<input type="hidden" id="startDateMonth" value="<?= $startMonth; ?>">
			<input type="hidden" id="startDateDay" value="<?= $startDay; ?>">
		</li>
	</ul>
	
	<div class="modalToolbar">
		<button class="cancel secondary">Cancel</button>
		<button class="save">Save, I'm Done</button>
	</div>
</div>