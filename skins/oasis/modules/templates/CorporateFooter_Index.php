<footer class="CorporateFooter">
	<nav>
		<? if (!$wgSingleH1) { ?>
		<h1>Wikia Inc Navigation</h1>
		<? } ?>
		<ul>
<?php 
foreach ($footer_links as $link) {
		?>
			<li>
				<a href="<?= $link["href"]; ?>"><?= $link["text"]; ?></a>
			</li>
	<?php
}
		?>
		</ul>
	</nav>
</footer>
