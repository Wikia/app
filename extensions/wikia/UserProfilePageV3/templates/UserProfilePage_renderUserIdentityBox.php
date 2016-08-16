<input type="hidden" id="reloadUrl" value="<?= $reloadUrl; ?>">
<section id="UserProfileMasthead" class="UserProfileMasthead <?= $zeroStateCssClass ?>" itemscope itemtype="http://schema.org/Person">
	<div class="masthead-avatar">
		<img src="<?= $user['avatar']; ?>" itemprop="image" class="avatar">

		<div class="avatar-controls">
			<? if ( $canEditProfile ): ?>
				<span>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil">
					<a href="#" id="userAvatarEdit"><?= wfMessage( 'user-identity-box-edit-avatar' )->escaped(); ?></a>
				</span>
			<? endif; ?>
			<?php if ( $canRemoveAvatar ): ?>
				<span>
					<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
					<a id="UserAvatarRemove" data-name="<?= $user['name']; ?>" href="#" data-confirm="<?= wfMessage( 'user-identity-remove-confirmation' )->escaped(); ?>">
						<?= wfMessage( 'user-identity-box-delete-avatar' )->escaped(); ?>
					</a>
				</span>
			<?php endif; ?>
		</div>
	</div>

	<div class="masthead-info">
		<hgroup>
			<h1 itemprop="name"><?= $user['name']; ?></h1>
			<? if ( !empty( $user['realName'] ) ): ?>
				<h2><?= wfMessage( 'user-identity-box-aka-label', $user['realName'] )->plain(); ?></h2>
			<? endif; ?>
			<? if ( !empty( $user['tags'] ) ): ?>
				<?php foreach ( $user['tags'] as $tag ): ?>
					<span class="tag"><?= $tag; ?></span>
				<?php endforeach; ?>
			<? endif; ?>
		</hgroup>

		<? if ( $canEditProfile ): ?>
			<span id="userIdentityBoxEdit">
				<img src="<?= $wgBlankImgUrl ?>" class="sprite edit-pencil">
				<a href="#"><?= wfMessage( 'user-identity-box-edit' )->escaped(); ?></a>
			</span>
			<input type="hidden" id="user" value="<?= $user['id']; ?>"/>
		<? endif; ?>
		<div class="masthead-info-lower">
			<div class="tally">
				<? if ( !empty( $user['registration'] ) ): ?>
					<? if ( !empty( $user['edits'] ) || ( empty( $user['edits'] ) && !empty( $user['registration'] ) ) ): ?>
						<em><?= $user['edits'] ?></em>
						<span>
							<?= wfMessage( 'user-identity-box-edits-since-joining', $user['registration'] )->plain() ?>
						</span>
					<? else: ?>
						<?php if ( $user['edits'] >= 0 ): ?>
							<?= wfMessage( 'user-identity-box-edits', $user['edits'] )->plain(); ?>
						<?php else: ?>
							<br/>
						<?php endif; ?>
					<?php endif; ?>
				<? else: ?>
					<?php if ( $user['edits'] >= 0 ): ?>
						<?= wfMessage( 'user-identity-box-edits', $user['edits'] )->plain(); ?>
					<?php else: ?>
						<br/>
					<?php endif; ?>
				<? endif; ?>
			</div>

			<? if ( $discussionPostsCountInUserIdentityBoxEnabled && $discussionActive ): ?>
				<div class="discussion-details tally">
					<? if (intval( $discussionPostsCount ) != 0 ): ?>
						<a id="discussionAllPostsByUser" href="<?= $discussionAllPostsByUserLink ?>">
					<? endif; ?>
							<em><?= $discussionPostsCount ?></em>
							<span class="discussion-label"><?= wfMessage( 'user-identity-box-discussion-posts' )->escaped(); ?></span>
					<? if (intval( $discussionPostsCount ) != 0 ): ?>
						</a>
					<? endif; ?>
				</div>
			<? endif; ?>

			<? if ( !$isBlocked ): ?>
				<ul class="links">
					<? if ( !empty( $user['twitter'] ) ): ?>
						<li class="twitter">
							<a href="http://twitter.com/<?= $user['twitter'] ?>" rel="nofollow">
								<img src="<?= $wgBlankImgUrl ?>" class="twitter icon">
								<?= wfMessage( 'user-identity-box-my-twitter' )->escaped(); ?>
							</a>
						</li>
					<? else: ?>
						<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
							<li class="zero">
								<img src="<?= $wgBlankImgUrl ?>" class="twitter icon">
								<?= wfMessage( 'user-identity-box-zero-state-twitter' )->escaped(); ?>
							</li>
						<? endif; ?>
					<? endif; ?>

					<? if ( !empty( $user['website'] ) ): ?>
						<li class="website">
							<a href="<?= $user['website'] ?>" rel="nofollow">
								<img src="<?= $wgBlankImgUrl ?>" class="website icon">
								<?= wfMessage( 'user-identity-box-my-website' )->escaped(); ?>
							</a>
						</li>
					<? else: ?>
						<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
							<li class="zero">
								<img src="<?= $wgBlankImgUrl ?>" class="website icon">
								<?= wfMessage( 'user-identity-box-zero-state-website' )->escaped(); ?>
							</li>
						<? endif; ?>
					<? endif; ?>

					<? if ( !empty( $user['fbPage'] ) ): ?>
						<li class="facebook">
							<a href="<?= $user['fbPage'] ?>" rel="nofollow">
								<img src="<?= $wgBlankImgUrl ?>" class="facebook icon">
								<?= wfMessage( 'user-identity-box-my-fb-page' )->escaped(); ?>
							</a>
						</li>
					<? else: ?>
						<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
							<li class="zero">
								<img src="<?= $wgBlankImgUrl ?>" class="facebook icon">
								<?= wfMessage( 'user-identity-box-zero-state-fb-page' )->escaped(); ?>
							</li>
						<? endif; ?>
					<? endif; ?>
				</ul>
			<? endif; ?>

			<? if ( ( !array_key_exists( 'hideEditsWikis', $user ) || !$user['hideEditsWikis'] ) && !empty( $user['topWikis'] ) && is_array( $user['topWikis'] ) ): ?>
				<ul class="wikis">
					<span><?= wfMessage( 'user-identity-box-fav-wikis' )->escaped(); ?></span>
					<ul>
						<? foreach ( $user['topWikis'] as $wiki ): ?>
							<li><a href="<?= $wiki['wikiUrl']; ?>"><?= $wiki['wikiName']; ?></a></li>
						<? endforeach; ?>
					</ul>
				</ul>
			<? endif; ?>
		</div>
		<div>
			<ul class="details">
				<? if ( !empty( $user['location'] ) ): ?>
					<li itemprop="address"><?= wfMessage( 'user-identity-box-location', $user['location'] )->plain(); ?></li>
				<? else: ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-location' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>

				<? if ( !empty( $user['birthday'] ) && intval( $user['birthday']['month'] ) > 0 && intval( $user['birthday']['month'] ) < 13 ): ?>
					<li><?= wfMessage( 'user-identity-box-was-born-on', F::app()->wg->Lang->getMonthName( intval( $user['birthday']['month'] ) ), $user['birthday']['day'] )->plain(); ?></li>
				<? else: ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-birthday' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>

				<? if ( !empty( $user['occupation'] ) ): ?>
					<li><?= wfMessage( 'user-identity-box-occupation', $user['occupation'] )->plain(); ?></li>
				<? elseif ( !empty( $user['showZeroStates'] ) ): ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-occupation' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>

				<? if ( !empty( $user['gender'] ) ): ?>
					<li><?= wfMessage( 'user-identity-i-am', $user['gender'] )->plain(); ?></li>
				<? else: ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-gender' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>
			</ul>
		</div>
	</div>
</section>
