<section class=mst>
	<div class=mstHhdr>
		<!-- <img src="<?= $wg->BlankImgURL ;?>" data-src="<?= $user['avatar']; ?>" itemprop=image class="lazy imgPlcHld"> --!>
		<!-- <noscript><img src="<?= $user['avatar']; ?>" itemprop=image></noscript> -->
		<div class=mstAva>
			<img class=mstAvaImg src="<?= $user['avatar']; ?>" itemprop=image>
		</div>
		<hgroup class=mstHgr>
			<? if( !empty($user['name']) ): ?>
				<h1 class=mstNm itemprop=name><?= $user['name']; ?></h1>
			<? endif; ?>
			<? if( !empty($user['group']) ): ?>
				<span class=mstGr><?= $user['group']; ?></span>
			<? endif; ?>
			<? if(!empty($user['chatBanned'])): ?>
				<span class=mstGr><?= wfMsg('user-identity-box-banned-from-chat'); ?></span>
			<? endif; ?>
			<? if( !empty($user['realName']) ): ?>
				<h2 class=mstRn><?= wfMsg('user-identity-box-aka-label', array('$1' => $user['realName']) ); ?></h2>
			<? endif; ?>
			<?php if( $user['edits'] >= 0 ): ?>
				<p class=mstEd><?= wfMsg('user-identity-box-edits', array( '$1' => $user['edits'] ) ); ?></p>
			<?php endif; ?>
		</hgroup>
	</div>

	<div class=mstInf>
		<ul class=mstUl>
			<? if( !empty($user['location']) ): ?>
				<li class=mstSectLi itemprop=address><?= wfMsg('user-identity-box-location', array( '$1' => $user['location'] )); ?></li>
			<? endif; ?>
			<? if( !empty($user['birthday']) && intval( $user['birthday']['month'] ) > 0 && intval( $user['birthday']['month'] ) < 13 ): ?>
				<li class=mstSectLi><?= wfMsg('user-identity-box-was-born-on', array( '$1' => F::app()->wg->Lang->getMonthName( intval($user['birthday']['month']) ), '$2' => $user['birthday']['day'] )); ?></li>
			<? endif; ?>
			<? if( !empty($user['occupation']) ): ?>
				<li class=mstSectLi><?= wfMsg('user-identity-box-occupation', array( '$1' => $user['occupation'] )); ?></li>
			<? endif; ?>
			<? if( !empty($user['gender']) ): ?>
				<li class=mstSectLi><?= wfMsg('user-identity-i-am', array( '$1' => $user['gender'] )); ?></li>
			<? endif; ?>
			<? if( (!array_key_exists('hideEditsWikis', $user) || !$user['hideEditsWikis']) && !empty($user['topWikis']) && is_array($user['topWikis']) ): ?>
				<li class=mstSectLi><span><?= wfMsg('user-identity-box-fav-wikis'); ?></span>
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
						<li class=mstLi><a href="<?= $wikiURL; ?>"><?= $wiki['wikiName']; ?></a></li>
						<? endforeach; ?>
					</ul>
				</li>
			<? endif; ?>
		</ul>
	</div>
</section>
