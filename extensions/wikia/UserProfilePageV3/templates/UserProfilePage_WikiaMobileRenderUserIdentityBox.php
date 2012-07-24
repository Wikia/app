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
				<li class=mstLi itemprop=address><?= wfMsg('user-identity-box-location', array( '$1' => $user['location'] )); ?></li>
			<? endif; ?>
			<? if( !empty($user['birthday']) ): ?>
				<li class=mstLi><?= wfMsg('user-identity-box-was-born-on', array( '$1' => F::app()->wg->Lang->getMonthName( intval($user['birthday']['month']) ), '$2' => $user['birthday']['day'] )); ?></li>
			<? endif; ?>
			<? if( !empty($user['occupation']) ): ?>
				<li class=mstLi><?= wfMsg('user-identity-box-occupation', array( '$1' => $user['occupation'] )); ?></li>
			<? endif; ?>
			<? if( !empty($user['gender']) ): ?>
				<li class=mstLi><?= wfMsg('user-identity-i-am', array( '$1' => $user['gender'] )); ?></li>
			<? endif; ?>
			<? if( (!array_key_exists('hideEditsWikis', $user) || !$user['hideEditsWikis']) && !empty($user['topWikis']) && is_array($user['topWikis']) ): ?>
				<li class=mstLi><span><?= wfMsg('user-identity-box-fav-wikis'); ?></span>
					<ul class=mstUl>
						<? foreach($user['topWikis'] as $wiki): ?>
						<li class=mstLi><a href="<?= $wiki['wikiUrl']; ?>"><?= $wiki['wikiName']; ?></a></li>
						<? endforeach; ?>
					</ul>
				</li>
			<? endif; ?>
		</ul>
	</div>
</section>
