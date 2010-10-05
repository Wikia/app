<div id='profile-content'>
	<div id='profile-content-left-column' class="uppColumn">

	<?php include('recent-changes-panel.tmpl.php') ?>

		<div id="profile-image-feed" class="uppBox">
			<h1 class="color1"><?= wfMsg( 'userprofilepage-recent-images-title' ); ?></h1>
			<ul style="list-style: none"">
				<?php foreach ($imageFeed['images'] as $i): ?>
					<li style="display: inline">
						<a class="lightbox" rel="nofollow" ref="File:<?= $i['name'] ?>" title="File:<?= $i['name'] ?>">
							<!--[if lt IE 8]><span></span><![endif]-->
							<div style="float: left; position: relative; padding: 5px; width: 96px; height: 96px">
								<div style="position: absolute; clip: rect(<?= $i['clip'] ?>); top: <?= $i['topPad'] ?>; left: <?= $i['leftPad'] ?>">
								 <img alt="" src="<?= $i['thumbUrl'] ?>" width="<?= $i['width'] ?>" height="<?= $i['height'] ?>" border="0" />

								</div>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
			<div style="clear: both"></div>
		</div>

		<div id="profile-editable-area" class="uppBox">
			<h1 class="color1">
				<?= wfMsg( 'userprofilepage-users-notes-title', array( $userName ) )?>
				<span class="editsection"><a href="<?=$userPageUrl;?>?action=edit" class="wikia-button"><?= wfMsg( 'userprofilepage-edit-button' ); ?></a></span>
			</h1>
			<?=$pageBody;?>
		</div>

	</div>
	<div id='profile-content-right-column' class="uppColumn">

		<div id="profile-wiki-switch" class="uppBox">
			<h1 class="color1"><?= wfMsg( 'userprofilepage-wiki-switch-title' ); ?></h1>
			<?php foreach( $wikiSwitch['topWikis'] as $wikiId => $wikiData ): ?>
				<div class="uppWikiBox">
					<a href="<?=$wikiData['wikiUrl'];?><?=$userPageUrl;?>" title="<?=$wikiData['wikiName'];?>">
						<img alt="<?=$wikiData['wikiName'];?>" src="<?=$wikiData['wikiLogo'];?>" width="102" height="73" align="middle" />
					</a>
				</div>
			<?php endforeach; ?>
		</div>

		<div id="profile-about-section" class="uppBox">
			<h1 class="color1">
				<?= wfMsg( 'userprofilepage-about-section-title', array( $userName ) ); ?>
				<span class="editsection"><a href="<?= $aboutSection['articleEditUrl']; ?>" class="wikia-button"><?= wfMsg( 'userprofilepage-edit-button' ); ?></a></span>
			</h1>
			<?= $aboutSection['body']; ?>
			<br />
			<br />
		</div>

		<div id="profile-achievements-section" class="uppAchievementsBox">
		 <i>Achievements here</i>
		</div>

		<div id="profile-favourites-section" class="uppBox">
			<h1 class="color1">
				<?= wfMsg( 'userprofilepage-favourites-section-title', array( $userName, $wikiName ) ); ?>
			</h1>
			<br />
			<br />
			<i>most liked articles here</i>
			<br />
			<br />
		</div>

	</div>
</div>