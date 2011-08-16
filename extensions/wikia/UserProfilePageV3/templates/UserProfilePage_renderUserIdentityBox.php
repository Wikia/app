<div id="UserProfileMastheadSearch" class="UserProfileMastheadSearch">
	<?php echo F::app()->renderView( 'Search', 'Index'); ?> 
</div>

<input type="hidden" id="reloadUrl" value="<?= $reloadUrl; ?>">
<section id="UserProfileMasthead" class="UserProfileMasthead <?= $zeroStateCssClass ?>" itemscope itemtype="http://schema.org/Person">
	<div class="masthead-avatar">
		<img src="<?= $user['avatar']; ?>" itemprop="image" class="avatar">
		
		<? if( $canEditProfile ): ?>
			<span>
				<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"> <a href="#" id="userAvatarEdit"><?= wfMsg('user-identity-box-edit-avatar'); ?></a>
			</span>
		<? endif; ?>
		<?php if( $canRemoveAvatar ): ?>
			<span>
				<img src="<?= $wgBlankImgUrl ?>" class="sprite trash"> <a href="<?= $deleteAvatarLink ?>"><?= wfMsg('user-identity-box-delete-avatar'); ?></a>
			</span>
		<?php endif; ?>
	</div>
	
	<div class="masthead-info">
		<hgroup>
			<h1 itemprop="name"><?= $user['name']; ?></h1>
			<? if( !empty($user['group']) ): ?>
				<span class="group"><?= $user['group']; ?></span>
			<? endif; ?>
			<? if( !empty($user['realName']) ): ?>
				<h2><?= wfMsg('user-identity-box-aka-label', array('$1' => $user['realName']) ); ?></h2>
			<? endif; ?>
		</hgroup>

		<? if( $canEditProfile ): ?>
			<span id="userIdentityBoxEdit">
				<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#"><?= wfMsg('user-identity-box-edit'); ?></a>
			</span>
			<input type="hidden" id="user" value="<?= $user['id']; ?>" />
		<? endif; ?>
		
		<div>
			<div class="tally">
				<? if( !empty($user['registration']) ): ?>
					<? if( !empty($user['edits']) || (empty($user['edits']) && !empty($user['registration'])) ): ?>
						<em><?= $user['edits'] ?></em>
						<span>
							<?= wfMsg('user-identity-box-edits-since-joining') ?><br>
							<?= $user['registration'] ?>
						</span>
					<? else: ?>
						<?= wfMsg('user-identity-box-edits', array( '$1' => $user['edits'] ) ); ?>
					<? endif; ?>
				<? else: ?>
					<?= wfMsg('user-identity-box-edits', array( '$1' => $user['edits'] ) ); ?>
				<? endif; ?>
			</div>

			<ul class="links">
				<? if( !empty($user['twitter']) ): ?>
					<li class="twitter">
						<a href="<?= $user['twitter'] ?>" rel="nofollow">
							<img src="<?= $wgBlankImgUrl ?>" class="twitter icon">
						</a>
						<?= wfMsg('user-identity-box-my-twitter', array( '$1' => $user['twitter'] )); ?>
					</li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $isWikiStaff) ): ?>
					<li class="zero">
						<img src="<?= $wgBlankImgUrl ?>" class="twitter icon">
						<?= wfMsg('user-identity-box-zero-state-twitter'); ?>
					</li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['website']) ): ?>
					<li class="website">
						<a href="<?= $user['website'] ?>" rel="nofollow">
							<img src="<?= $wgBlankImgUrl ?>" class="website icon">
						</a>
						<?= wfMsg('user-identity-box-my-website', array( '$1' => $user['website'] )); ?>
					</li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $isWikiStaff) ): ?>
					<li class="zero">
						<img src="<?= $wgBlankImgUrl ?>" class="website icon">
						<?= wfMsg('user-identity-box-zero-state-website'); ?>
					</li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['fbPage']) ): ?>
					<li class="facebook">
						<a href="<?= $user['fbPage'] ?>" rel="nofollow">
							<img src="<?= $wgBlankImgUrl ?>" class="facebook icon">
						</a>
						<?= wfMsg('user-identity-box-my-fb-page', array( '$1' => $user['fbPage'] )); ?>
					</li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $isWikiStaff) ): ?>
					<li class="zero">
						<img src="<?= $wgBlankImgUrl ?>" class="facebook icon">
						<?= wfMsg('user-identity-box-zero-state-fb-page'); ?>
					</li>
					<? endif; ?>
				<? endif; ?>
			</ul>
			
			<? if( !empty($user['topWikis']) && is_array($user['topWikis']) ): ?>
			<ul class="wikis">
				<span><?= wfMsg('user-identity-box-fav-wikis'); ?></span>
				<ul>
				<? foreach($user['topWikis'] as $wiki): ?>
					<li><a href="<?= $wiki['wikiUrl']; ?>"><?= $wiki['wikiName']; ?></a></li>
				<? endforeach; ?>
				</ul>
			</ul>
			<? endif; ?>
		</div>
		<div>
			<ul class="details">
				<? if( !empty($user['location']) ): ?>
					<li itemprop="address"><?= wfMsg('user-identity-box-location', array( '$1' => $user['location'] )); ?></li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $isWikiStaff) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-location'); ?></li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['birthday']) ): ?>
					<li><?= wfMsg('user-identity-box-was-born-on', array( '$1' => wfMsg('user-identity-box-about-date-'.$user['birthday']['month']), '$2' => $user['birthday']['day'] )); ?></li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $isWikiStaff) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-birthday'); ?></li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['occupation']) ): ?>
					<li><?= wfMsg('user-identity-box-occupation', array( '$1' => $user['occupation'] )); ?></li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $isWikiStaff) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-occupation'); ?></li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['gender']) ): ?>
					<li><?= wfMsg('user-identity-i-am', array( '$1' => $user['gender'] )); ?></li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $isWikiStaff) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-gender'); ?></li>
					<? endif; ?>
				<? endif; ?>
			</ul>
		</div>
		
	</div>
</section>