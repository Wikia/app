<div id="shareFeatureInside" title="<?= wfMsg( 'sf-link-popup' ) ?>" >
        <div>
		<div>
			<ul id="sf_providers">
			<?php
				global $wgExtensionsPath;
				foreach( $sites as $site) {
			?>			
				<li id="sf_provider_<?= strtolower( $site['name'] ) ?>"><a href="<?= $site['url'] ?>" target="_blank" onmousedown="ShareFeature.mouseDown( <?= $site['id'] ?>, '<?= $footer ?>' )"><div>&nbsp;</div></a><a href="<?= $site['url'] ?>" target="_blank" onmousedown="ShareFeature.mouseDown( <?= $site['id'] ?>, '<?= $footer ?>' )"><?= $site['name'] ?></a></li>
			<?php
				}
			?>
			</ul>
		</div>
        </div>
</div>

