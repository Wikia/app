<div id="shareFeatureRound" title="<?= wfMsg( 'sf-link' ) ?>" >
        <div>
		<div>
			<ul>
			<?php
				foreach( $sites as $name => $url ) {
			?>
				<li><a><?= $name ?></a></li>
			<?php
				}
			?>
			</ul>
		</div>
        </div>
</div>

