<section class="control-center">
	<header>
		<h1>
			<? if(empty($wordmarkUrl)) { ?>
				<?= $wordmarkText ?>
			<? } else { ?>
				<img src="<?= $wordmarkUrl ?>" alt="<?= $wordmarkText ?>" height="48">
			<? } ?>
			<?= wfMsg("controlcenter-header") ?>
		</h1>
		<nav>
			<?= wfMsg("controlcenter-header-help", "") ?> | <?= wfMsg("controlcenter-header-exit", "") ?>
		</nav>
	</header>
	<section class="control-center-content">
		<section class="controls-wiki">
			<header>
				<h1>Wiki</h1>Create layouts that the community can use to create standardized page formats for pages with similar goals.
			</header>
			<div class="row">
				<div class="item">
					<div class="representation">
						<div class="icon"></div>
					</div>
					Theme Designer
				</div>
			</div>
		</section>
	</section>
	<aside>
	</aside>
</section>