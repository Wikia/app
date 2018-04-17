<section class=mst>
	<div class=mstHhdr>
		<div class=mstAva>
			<img class=mstAvaImg src="<?= Sanitizer::encodeAttribute( $user['avatar'] ); ?>" itemprop=image>
		</div>
		<hgroup class=mstHgr>
			<? if( !empty($user['name']) ): ?>
				<h1 class=mstNm itemprop=name><?= htmlspecialchars( $user['name'] ); ?></h1>
			<? endif; ?>
			<? if( !empty($user['tags']) ): ?>
				<?php foreach($user['tags'] as $tag): ?>
					<span class=mstGr><?= $tag; ?></span>
				<?php endforeach; ?>
			<? endif; ?>
			<? if(!empty($user['chatBanned'])): ?>
				<span class=mstGr><?= wfMessage( 'user-identity-box-banned-from-chat' )->escaped(); ?></span>
			<? endif; ?>
			<? if( !empty($user['realName']) ): ?>
				<h2 class=mstRn><?= wfMessage( 'user-identity-box-aka-label' )->rawParams( htmlspecialchars( $user['realName'] ) )->parse(); ?></h2>
			<? endif; ?>
			<?php if( $user['edits'] >= 0 ): ?>
				<p class=mstEd><?= wfMessage( 'user-identity-box-edits' )->rawParams( htmlspecialchars( $user['edits'] ) )->parse(); ?></p>
			<?php endif; ?>
		</hgroup>
	</div>

	<div class=mstInf>
		<ul class=mstUl>
			<? if( !empty($user['location']) ): ?>
				<li class=mstSectLi itemprop=address><?= wfMessage( 'user-identity-box-location' )->rawParams( htmlspecialchars( $user['location'] ) )->parse(); ?></li>
			<? endif; ?>
			<? if( !empty($user['birthday']) && intval( $user['birthday']['month'] ) > 0 && intval( $user['birthday']['month'] ) < 13 ): ?>
				<li class=mstSectLi><?= wfMessage( 'user-identity-box-was-born-on' )->params( $wg->Lang->getMonthName( intval( $user['birthday']['month'] ) ) )->numParams( htmlspecialchars( $user['birthday']['day'] ) )->parse();
				?></li>
			<? endif; ?>
			<? if( !empty($user['occupation']) ): ?>
				<li class=mstSectLi><?= wfMessage( 'user-identity-box-occupation' )->rawParams( htmlspecialchars( $user['occupation'] ) )->parse(); ?></li>
			<? endif; ?>
			<? if( !empty($user['gender']) ): ?>
				<li class=mstSectLi><?= wfMessage( 'user-identity-i-am' )->rawParams( htmlspecialchars( $user['gender'] ) )->parse(); ?></li>
			<? endif; ?>
			<? if( (!array_key_exists('hideEditsWikis', $user) || !$user['hideEditsWikis']) && !empty($user['topWikis']) && is_array($user['topWikis']) ): ?>
				<li class=mstSectLi><span><?= wfMessage( 'user-identity-box-fav-wikis' )->escaped(); ?></span>
					<ul class=mstUl>
						<? foreach($user['topWikis'] as $wiki) :?>
						<?
							//the data produced by the controller contains the link to the User page on a wiki
							//but what we need is the URL of the wiki only, since the data is there no need to
							//make it bigger, just extract the useful bits
							$tokens = explode( '/', $wiki['wikiUrl'], 4 );//get [http,,www.wikia.com,all_the_rest]
							array_pop( $tokens );//drop all_the_rest from the tokens
							$wikiURL = implode( '/', $tokens );//stick it back together
						?>
						<li class=mstLi><a href="<?= Sanitizer::encodeAttribute( $wikiURL ); ?>"><?= htmlspecialchars( $wiki['wikiName'] ); ?></a></li>
						<? endforeach; ?>
					</ul>
				</li>
			<? endif; ?>
		</ul>
	</div>
</section>
