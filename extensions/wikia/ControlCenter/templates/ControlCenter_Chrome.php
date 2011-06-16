<section class="ControlCenterHeader" id="ControlCenterHeader">
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
	<aside>
		<?= $founderProgressBar ?>
	</aside>
	<nav class="tabs">
		<ul>
			<li class="tab" data-section="advanced">
				Advanced
			</li>
			<li class="tab active" data-section="general">
				General
			</li>
		</ul>
	</nav>
</section>	