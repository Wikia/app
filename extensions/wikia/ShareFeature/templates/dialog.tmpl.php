<div id="shareFeatureInside" title="<?= wfMsg( 'sf-link-popup' ) ?>" >
        <div>
		<div>
			<ul>
			<?php
				global $wgExtensionsPath;
				foreach( $sites as $site) {
			?>
				<li><a href="<?= $site['url'] ?>" target="_blank" onclick="ShareFeature.ajax( <?= $site['id'] ?>  )"><img src="<?= $wgExtensionsPath ?>/wikia/ShareFeature/images/<?= strtolower( $site['name'] ) ?>.png" alt="<?= $site['name'] ?>"/></a><a href="<?= $site['url'] ?>" target="_blank" onclick="ShareFeature.ajax( <?= $site['id'] ?>  )"><?= $site['name'] ?></a></li>
			<?php
				}
			?>
			</ul>
		</div>
        </div>
</div>

