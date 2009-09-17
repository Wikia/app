<div id="shareFeatureRound" title="<?= wfMsg( 'sf-link' ) ?>" >
        <div>
		<div>
			<ul>
			<?php
				foreach( $sites as $site) {
			?>
				<li><a href="<?= $site['url'] ?> target="_blank">" onclick="ShareFeature.ajax( <?= $site['id'] ?>  )"><?= $site['name'] ?></a></li>
			<?php
				}
			?>
			</ul>
		</div>
        </div>
</div>

