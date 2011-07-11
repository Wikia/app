<div id="UPPLightbox" class="UPPLightbox">
	<h2><?php echo wfMsg('userprofilepage-edit-modal-header'); ?></h2>
	
	<div>
		<?php foreach( $tabs as $tab ): ?>
			<?php if( $selectedTab === $tab['id']): ?>
				<a href="#" class="tab current" id="<?= $tab['id']; ?>"><?= $tab[ 'name' ]; ?></a>
			<?php else: ?>
				<a href="#" class="tab" id="<?= $tab['id']; ?>"><?= $tab[ 'name' ]; ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<br />
		
	<div id='errorBox' >
		<div id="wpError"></div>
	</div>
	
	<div id="interview" class="tabContent" <?php if( $selectedTab == 'interview' ) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>
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
		<br />
		<button id="UPPLightboxInterviewCancelBtn"><?= wfMsg('userprofilepage-lightbox-interview-cancel'); ?></button>
		<button id="UPPLightboxInterviewSaveBtn"><?= wfMsg('userprofilepage-lightbox-interview-save'); ?></button>
	</div>
	
	<div id="avatar" class="tabContent" <?php if( $selectedTab == 'avatar' ) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>
		<form id="usersAvatar" name="usersAvatar" method="post" enctype="multipart/form-data" action="/wikia.php?controller=UserProfilePage&method=onSubmitUsersAvatar&format=json&userId=<?php echo $userId; ?>">
			<?php echo $avatar; ?>
			<img src="/skins/common/images/ajax.gif" class="avatar-loader" style="display: none;" />
			<?php if($isUploadsPossible): ?>
				<p><?php echo wfMsg('user-identity-box-avatar-upload-avatar'); ?></p>
				<input type="hidden" name="UPPLightboxDefaultAvatar" id="UPPLightboxDefaultAvatar" value="" >
				<input type="hidden" name="UPPLightboxFbAvatar" id="UPPLightboxFbAvatar" value="" >
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $avatarMaxSize; ?>">
				<input type="file" name="UPPLightboxAvatar" id="UPPLightboxAvatar" />
			<?php endif; ?>
			
			<?php if( $isUserPageOwner ): ?>
				<p id="facebookConnectAvatar">
					<?php echo wfMsg('user-identity-box-avatar-fb-import-avatar'); ?>
					<?php echo $fbAvatarConnectButton; ?>
				</p>
			<?php endif; ?>
			
			<?php if( !empty($defaultAvatars) ): ?>
				<p><?php echo wfMsg('user-identity-box-avatar-choose-avatar'); ?></p>
				<ul id="UPPLightboxSampleAvatarsDiv">
					<?php foreach($defaultAvatars as $avatar): ?>
						<?php if( $avatarName === $avatar['name'] ): ?>
							<li><img width="40" height="40" style="border: 3px solid #008000" src="<?php echo $avatar['url']; ?>" class="<?php echo $avatar['name']; ?>" /></li>
						<?php else: ?>
							<li><img width="40" height="40" src="<?php echo $avatar['url']; ?>" class="<?php echo $avatar['name']; ?>" /></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			
			<br />
			<button id="UPPLightboxAvatarCancelBtn"><?= wfMsg('user-identity-box-avatar-cancel'); ?></button>
			<button id="UPPLightboxAvatarSaveBtn"><?= wfMsg('user-identity-box-avatar-save'); ?></button>
		</form>
	</div>
	
	<div id="about" class="tabContent" <?php if( $selectedTab == 'about' ) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>
		<form id="userData" name="userData">
			<p>
				<label><?php echo wfMsg('user-identity-box-about-name'); ?></label>
				<input type="text" name="name" value="<?php echo $user['realName']; ?>" />
			</p>
			<p>
				<label><?php echo wfMsg('user-identity-box-about-location'); ?></label>
				<input type="text" name="location" value="<?php echo $user['location']; ?>" />
			</p>
			<p>
				<label><?php echo wfMsg('user-identity-box-about-birthday'); ?></label>
				<select id="userBDayMonth" name="month">
					<option value="0">--</option>
					<?php foreach($months as $month): ?>
						<option value="<?php echo $month['no']; ?>" <?php if( isset($user['birthday']['month']) && $user['birthday']['month'] === $month['no'] ):?>selected="selected"<?php endif; ?>><?php echo $month['month']; ?></option>
					<?php endforeach; ?>
				</select>
				<select id="userBDayDay" name="day">
					<option value="0">--</option>
					<?php if( !empty($days) ): ?>
						<?php for($i = 1; $i <= $days; $i++): ?>
							<option value="<?php echo $i; ?>" <?php if( isset($user['birthday']['day']) && intval($user['birthday']['day']) === $i):?>selected="selected"<?php endif; ?>><?php echo $i; ?></option>
						<?php endfor; ?>
					<?php endif; ?>
				</select>
			</p>
			<p>
				<label><?php echo wfMsg('user-identity-box-about-occupation'); ?></label>
				<input type="text" name="occupation" value="<?php echo $user['occupation']; ?>" />
			</p>
			<p>
				<label><?php echo wfMsg('user-identity-box-about-gender'); ?></label>
				<input type="text" name="gender" value="<?php echo $user['gender']; ?>" />
			</p>
			<p>
				<label><?php echo wfMsg('user-identity-box-about-website'); ?></label>
				<input type="text" name="website" value="<?php echo $user['website']; ?>" />
			</p>
			<p>
				<label><?php echo wfMsg('user-identity-box-about-tweet'); ?></label>
				<input type="text" name="twitter" value="<?php echo $user['twitter']; ?>" />
			</p>
			<?php if( $isUserPageOwner ): ?>
				<p id="facebookConnect" <?php if( !empty($user['fbPage']) ): ?>style="display: none;"<?php endif; ?>>
					<label><?php echo wfMsg('user-identity-box-import-from-fb'); ?></label>
					<?php echo $fbConnectButton; ?>
				</p>
				<p id="facebookPage" <?php if( empty($user['fbPage']) ): ?>style="display: none;"<?php endif; ?>>
					<label><?php echo wfMsg('user-identity-box-fb-page'); ?></label>
					<input type="text" name="fbPage" value="<?php echo $user['fbPage']; ?>" />
				</p>
			<?php endif; ?>
				<?php if( !empty($user['topWikis']) && is_array($user['topWikis']) ): ?>
				<span><?php echo wfMsg('user-identity-box-about-fav-wikis'); ?></span>
				<ul class="favWikis">
				<?php foreach($user['topWikis'] as $favWikiId => $wiki): ?>
					<li><?php echo $wiki['wikiName']; ?><a class="favwiki favWikiId-<?php echo $favWikiId; ?>" href="#">[x]</a></li>
				<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<a class="favwiki-refresh" href="#"><?php echo wfMsg('user-identity-box-about-fav-wikis-refresh'); ?></a>
				<ul class="favWikis">
				</ul>
			<?php endif; ?>
		</form>
		<br />
		<button id="UPPLightboxAboutMeCancelBtn"><?= wfMsg('userprofilepage-lightbox-about-me-cancel'); ?></button>
		<button id="UPPLightboxAboutMeSaveBtn"><?= wfMsg('userprofilepage-lightbox-about-me-save'); ?></button>
		<input type="hidden" id="startDateYear" value="<?php echo $startYear; ?>" />
		<input type="hidden" id="startDateMonth" value="<?php echo $startMonth; ?>" />
		<input type="hidden" id="startDateDay" value="<?php echo $startDay; ?>" />
	</div>
</div>