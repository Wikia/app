<section style="margin-bottom: 25px;" class="grid-3 alpha wikiahubs-pulse">
	<span class="social">
		<a href="<?= $socialmedia['facebook'] ?>" id="facebook"></a>
		<a href="<?= $socialmedia['twitter'] ?>" id="twitter"></a>
		<a href="<?= $socialmedia['googleplus'] ?>" id="google"></a>
	</span>
	<h2>
		<span class="mw-headline" id="The_Pulse_on_Mass_Effect_Wiki">
			The Pulse on <a  class="text" href="<?= $title['href'] ?>"><?= $title['anchor'] ?></a>
		</span>
	</h2>
	<div class="pulse-content">
		<div class="boxes">
			<? if (is_array($boxes)): ?>
				<? foreach($boxes as $box): ?>
					<div class="box">
						<h5>
							<span class="mw-headline" id="Page_Views">
								<b><a href="<?= $box['headline']['href'] ?>">
									<?= $box['headline']['anchor'] ?>
								</a></b>
							</span>
						</h5>
						<b><?= $box['number'] ?></b>
						<br />
						<a href="<?= $box['link']['href'] ?>">
							<?= $box['link']['anchor'] ?>
						</a>
					</div>
				<? endforeach; ?>
			<? endif; ?>
		</div>
		<div class="search">
			<div class="buttons">
				<label for="HubSearch">What's your game?</label>
				<?= F::app()->renderView('Search','index') ?>
			</div>
		</div>
	</div>
</section>