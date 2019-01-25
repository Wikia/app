<input type="hidden" id="reloadUrl" value="<?= $reloadUrl; ?>">
<section id="UserProfileMasthead" class="UserProfileMasthead <?= $zeroStateCssClass ?>" itemscope itemtype="http://schema.org/Person">
	<div class="masthead-avatar">
		<img src="<?= Sanitizer::encodeAttribute( $user['avatar'] ); ?>" itemprop="image" class="avatar">

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
					<a id="UserAvatarRemove" data-name="<?= Sanitizer::encodeAttribute( $user['name'] ); ?>" href="#" data-confirm="<?= wfMessage( 'user-identity-remove-confirmation' )->escaped(); ?>">
						<?= wfMessage( 'user-identity-box-delete-avatar' )->escaped(); ?>
					</a>
				</span>
			<?php endif; ?>
		</div>
	</div>

	<div class="masthead-info">
		<hgroup>
			<h1 itemprop="name"><?= htmlspecialchars( $user['name'] ); ?></h1>
			<? if ( !empty( $user['realName'] ) ): ?>
				<h2><?= wfMessage( 'user-identity-box-aka-label' )->rawParams( htmlspecialchars( $user['realName'] ) )->parse(); ?></h2>
			<? endif; ?>
			<? if ( !empty( $user['tags'] ) ): ?>
				<?php foreach ( $user['tags'] as $tag ): ?>
					<span class="tag"><?= $tag; ?></span>
				<?php endforeach; ?>
			<? endif; ?>
		</hgroup>

		<? if ( $canEditProfile ): ?>
			<ul class="user-identity-box-edit">
				<li>
					<?= DesignSystemHelper::renderSvg( 'wds-icons-pencil', 'wds-icon-tiny' ); ?>
					<a id="userIdentityBoxEdit" href="#"><?= wfMessage( 'user-identity-box-edit' )->escaped(); ?></a>
				</li>
				<? if ( $canClearProfile && !$user[ 'showZeroStates' ] ): ?>
					<li>
						<?= DesignSystemHelper::renderSvg( 'wds-icons-trash', 'wds-icon-tiny' ); ?>
						<a
							id="userIdentityBoxClear"
							href="#"
							data-name="<?= Sanitizer::encodeAttribute( $user['name'] ); ?>"
							data-confirm="<?= wfMessage( 'user-identity-box-clear-confirmation' )->escaped(); ?>"
						>
							<?= wfMessage( 'user-identity-box-clear' )->escaped(); ?>
						</a>
					</li>
				<? endif; ?>
			</ul>
			<input type="hidden" id="user" value="<?= $user['id']; ?>"/>
		<? endif; ?>
		<div class="masthead-info-lower">
			<div class="contributions-details tally">
				<? if ( !empty( $user['registration'] ) ): ?>
					<a href="<?= Sanitizer::encodeAttribute( $user['contributionsURL'] ); ?>">
						<em><?= htmlspecialchars( $user['edits'] ); ?></em>
						<span>
							<?= wfMessage( 'user-identity-box-edits-since-joining', $user['registration'] )->parse(); ?>
						</span>
					</a>
				<? else: ?>
					<?php if ( $user['edits'] >= 0 ): ?>
						<a href="<?= Sanitizer::encodeAttribute( $user['contributionsURL'] ) ?>">
							<?= wfMessage( 'user-identity-box-edits' )->rawParams( htmlspecialchars( $user['edits'] ) )->parse(); ?>
						</a>
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
							<a href="http://twitter.com/<?= Sanitizer::encodeAttribute( $user['twitter'] ); ?>" rel="nofollow">
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
							<a href="<?= Sanitizer::encodeAttribute( $user['website'] ); ?>" rel="nofollow">
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
							<a href="<?= Sanitizer::encodeAttribute( $user['fbPage'] ); ?>" rel="nofollow">
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
							<li><a href="<?= Sanitizer::encodeAttribute( $wiki['wikiUrl'] ); ?>"><?= htmlspecialchars( $wiki['wikiName'] ); ?></a></li>
						<? endforeach; ?>
					</ul>
				</ul>
			<? endif; ?>
		</div>
		<div class="details">
			<ul>
				<? if ( !empty( $user['location'] ) ): ?>
					<li itemprop="address"><?= wfMessage( 'user-identity-box-location' )->rawParams( htmlspecialchars( $user['location'] ) )->parse(); ?></li>
				<? else: ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-location' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>

				<? if ( !empty( $user['birthday'] ) && intval( $user['birthday']['month'] ) > 0 && intval( $user['birthday']['month'] ) < 13 ): ?>
					<li><?= wfMessage( 'user-identity-box-was-born-on' )->params( $wg->Lang->getMonthName( intval( $user['birthday']['month'] ) ) )->numParams( intval( $user['birthday']['day'] ) )->parse(); ?></li>
				<? else: ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-birthday' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>

				<? if ( !empty( $user['occupation'] ) ): ?>
					<li><?= wfMessage( 'user-identity-box-occupation' )->rawParams( htmlspecialchars( $user['occupation'] ) )->parse(); ?></li>
				<? elseif ( !empty( $user['showZeroStates'] ) ): ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-occupation' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>

				<? if ( !empty( $user['gender'] ) ): ?>
					<li><?= wfMessage( 'user-identity-i-am' )->rawParams( htmlspecialchars( $user['gender'] ) )->parse(); ?></li>
				<? else: ?>
					<? if ( $user['showZeroStates'] && ( $isUserPageOwner || $canEditProfile ) ): ?>
						<li><?= wfMessage( 'user-identity-box-zero-state-gender' )->escaped(); ?></li>
					<? endif; ?>
				<? endif; ?>
				<? if ( !empty( $user['bio'] ) ): ?>
					<li class="bio" id="bio-content">
						<?= wfMessage( 'user-identity-bio' )
							->rawParams( preg_replace( "/(?:\r\n|\r|\n)/", "<br />", htmlspecialchars( $user['bio'] ) ) )
							->parse(); ?>
					</li>
					<div class="bio-toggle" id="bio-toggler" data-modal-title="<?= wfMessage( 'user-identity-bio-modal-title' )->escaped(); ?>">
						<span>
							[<?= wfMessage( 'user-identity-bio-show-more' )->escaped(); ?>]
						</span>
					</div>
				<? endif; ?>
			</ul>
		</div>
	</div>
</section>
