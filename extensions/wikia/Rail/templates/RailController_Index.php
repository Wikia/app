<? if ( $isAside ): ?>
<aside>
	<? endif; ?>
	<div
		id="WikiaRailWrapper"
		class="WikiaRail<?= !empty( $isGridLayoutEnabled ) ? ' grid-2' : '' ?>"
		<?= $isEditPage ? 'style="display: none;"' : '' ?>
	>
		<div id="WikiaRail">
			<?php if ( empty( $adMixPrototype ) ): ?>
				<?php
				// sort in reverse order (highest priority displays first)
				krsort( $railModuleList );

				// render all our rail modules here
				foreach ( $railModuleList as $priority => $callSpec ) {
					echo F::app()->renderView( $callSpec[0], // controller
						$callSpec[1], // method
						$callSpec[2]  // method's params
					);
				}
				?>
				<? if ( $loadLazyRail ): ?>
					<div class="loading"></div>
				<? endif ?>
			<?php endif; ?>

			<?php if ( $adMixPrototype === '1' ): ?>
				<img class="prototype1-ad1"
					 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/ad1.png">
				<img class="prototype1-rwa"
					 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/RWA.png">
				<div class="prototype1-recirc-placeholder">
					<img class="prototype1-recirc"
						 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/Recirc.png">
				</div>
				<div class="prototype1-ad2-placeholder">
					<img class="prototype1-ad2"
						 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/ad1.png">
				</div>
				<img class="prototype1-ad3"
					 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/ad2.png">
			<?php endif; ?>

			<?php if ( $adMixPrototype === '2' ): ?>
				<div class="prototype2-ad1-placeholder">
					<img class="prototype2-ad1"
						 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/ad1.png">
				</div>
				<img class="prototype2-rwa"
					 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/RWA.png">
				<div class="prototype2-recirc-placeholder">
					<img class="prototype2-recirc"
						 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/Recirc.png">
				</div>
			<?php endif; ?>

			<?php if ( $adMixPrototype === '3' ): ?>
				<img class="prototype3-ad1"
					 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/ad1.png">
				<img class="prototype3-rwa"
					 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/RWA.png">
				<div class="prototype3-recirc-placeholder">
					<img class="prototype3-recirc"
						 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/Recirc.png">
				</div>
				<img class="prototype3-ad2"
					 src="http://ktatala.wikia-dev.pl/skins/oasis/images/premium-ads-mix-prototype/ad2.png">
			<?php endif; ?>

		</div>
	</div>
	<? if ( $isAside ): ?>
</aside>
<? endif; ?>
