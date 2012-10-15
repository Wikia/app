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
				<img src="<?= $wgBlankImgUrl ?>" class="sprite trash"> <a id="UserAvatarRemove" data-name="<?= $user['name']; ?>"  href="#" data-confirm="<?= htmlspecialchars(wfMsg('user-identity-remove-confirmation')); ?>"><?= wfMsg('user-identity-box-delete-avatar'); ?></a>
			</span>
		<?php endif; ?>
	</div>
	
	<div class="masthead-info">
		<hgroup>
			<? if( !empty($user['realName']) ): ?>
				<h1 itemprop="name"><?= $user['name']; ?></h1>
				<h2><?= wfMsg('user-identity-box-aka-label', array('$1' => $user['realName']) ); ?></h2>
			<? else: ?>
				<h1 itemprop="name"><?= $user['name']; ?></h1>
			<? endif; ?>
			<? if( !empty($user['tags']) ): ?>
				<?php foreach($user['tags'] as $tag): ?>
					<span class="tag"><?= $tag; ?></span>
				<?php endforeach; ?>
			<? endif; ?>
		</hgroup>

		<? if( $canEditProfile ): ?>
			<span id="userIdentityBoxEdit">
				<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil"><a href="#"><?= wfMsg('user-identity-box-edit'); ?></a>
			</span>
			<input type="hidden" id="user" value="<?= $user['id']; ?>" />
		<? endif; ?>
		<div class="masthead-info-lower">
			<div class="tally">
				<? if( !empty($user['registration']) ): ?>
					<? if( !empty($user['edits']) || (empty($user['edits']) && !empty($user['registration'])) ): ?>
						<em><?= $user['edits'] ?></em>
						<span>
							<?= wfMsg('user-identity-box-edits-since-joining', array( $user['registration'] ) ) ?>
						</span>
					<? else: ?>
						<?php if( $user['edits'] >= 0 ): ?>
							<?= wfMsg('user-identity-box-edits', array( '$1' => $user['edits'] ) ); ?>
						<?php else: ?>
							<br />
						<?php endif; ?>
					<?php endif; ?>
				<? else: ?>
					<?php if( $user['edits'] >= 0 ): ?>
						<?= wfMsg('user-identity-box-edits', array( '$1' => $user['edits'] ) ); ?>
					<?php else: ?>
						<br />
					<?php endif; ?>
				<? endif; ?>
			</div>

			<ul class="links">
				<? if( !empty($user['twitter']) ): ?>
					<li class="twitter">
						<a href="http://twitter.com/<?= $user['twitter'] ?>" rel="nofollow">
							<img src="<?= $wgBlankImgUrl ?>" class="twitter icon">
							<?= wfMsg('user-identity-box-my-twitter' ); ?>
						</a>
					</li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $canEditProfile) ): ?>
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
							<?= wfMsg('user-identity-box-my-website' ); ?>
						</a>
					</li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $canEditProfile) ): ?>
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
							<?= wfMsg('user-identity-box-my-fb-page' ); ?>
						</a>
					</li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $canEditProfile) ): ?>
					<li class="zero">
						<img src="<?= $wgBlankImgUrl ?>" class="facebook icon">
						<?= wfMsg('user-identity-box-zero-state-fb-page'); ?>
					</li>
					<? endif; ?>
				<? endif; ?>
			</ul>

			<? if( (!array_key_exists('hideEditsWikis', $user) || !$user['hideEditsWikis']) && !empty($user['topWikis']) && is_array($user['topWikis']) ): ?>
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
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $canEditProfile) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-location'); ?></li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['birthday']) && intval( $user['birthday']['month'] ) > 0 && intval( $user['birthday']['month'] ) < 13 ): ?>
					<li><?= wfMsg('user-identity-box-was-born-on', array( '$1' => F::app()->wg->Lang->getMonthName( intval($user['birthday']['month']) ), '$2' => $user['birthday']['day'] )); ?></li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $canEditProfile) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-birthday'); ?></li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['occupation']) ): ?>
					<li><?= wfMsg('user-identity-box-occupation', array( '$1' => $user['occupation'] )); ?></li>
				<? elseif( !empty($user['showZeroStates']) ): ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $canEditProfile) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-occupation'); ?></li>
					<? endif; ?>
				<? endif; ?>
				
				<? if( !empty($user['gender']) ): ?>
					<li><?= wfMsg('user-identity-i-am', array( '$1' => $user['gender'] )); ?></li>
				<? else: ?>
					<? if( $user['showZeroStates'] && ($isUserPageOwner || $canEditProfile) ): ?>
					<li><?= wfMsg('user-identity-box-zero-state-gender'); ?></li>
					<? endif; ?>
				<? endif; ?>
			</ul>
		</div>
		
	</div>
</section>
