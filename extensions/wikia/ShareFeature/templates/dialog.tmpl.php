<div id="shareFeatureRound" title="<?= wfMsg( 'sf-link' ) ?>" >
        <div>
		<div>
			<ul>
			<?php
				foreach( $sites as $site) {
			?>
				<li><a href="<?= $site[1] ?>"><?= $site[0] ?></a></li>
			<?php
				}
			?>
			</ul>
		</div>
        </div>
</div>

