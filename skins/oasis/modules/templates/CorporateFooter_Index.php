<div class="CorporateFooter">
	<nav>
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
</div>
