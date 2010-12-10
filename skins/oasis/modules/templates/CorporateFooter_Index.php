<footer class="CorporateFooter">
	<nav>
		<h1>Wikia Inc Navigation</h1>
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
