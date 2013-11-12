<p>LVS Debug Page</p>

<ol class="lvs-debug-list">
	<? foreach ( $debugInfo as $title => $info ): ?>
		<li>
			<b><a href="/wiki/File:<?= $title ?>"><?= $title ?></a></b><br />
			<img src="<?= $info['detail']['thumbUrl'] ?>" />
			<ul>
				<li><b>Provider:</b> <?= $info['provider'] ?></li>
				<li><b>Status Info:</b> <?= isset($info['props']['Status Info']) ? print_r($info['props']['Status Info']) : '' ?></li>
				<li>
					<? $f = isset($info['props']['Status Flags']) ? $info['props']['Status Flags'] : 0 ?>
					<b>Status Flags:</b> [<?= $f&1 ? '<b>X</b>' : ' ' ?>] KEEP -
										 [<?= $f&32 ? '<b>X</b>' : ' ' ?>] KEEP FOREVER -
										 [<?= $f&2 ? '<b>X</b>' : ' ' ?>] SWAP -
										 [<?= $f&4 ? '<b>X</b>' : ' ' ?>] EXACT SWAP -
										 [<?= $f&8 ? '<b>X</b>' : ' ' ?>] SWAPPABLE -
										 [<?= $f&16 ? '<b>X</b>' : ' ' ?>] NEW
				</li>
				<li><b>Suggestions Updated:</b> <?= isset($info['props']['Suggestions Updated']) ? date("D M j G:i:s T Y", $info['props']['Suggestions Updated']) : '' ?></li>
				<li><b>Suggestions:</b>
					<? if ( isset($info['props']['Suggestions']) ): ?>
					<ol>
						<? foreach ($info['props']['Suggestions'] as $vid): ?>
						<li>
							<a href="<?= $vid['fileUrl'] ?>">
								<img width="200" src="<?= $vid['thumbUrl'] ?>" />
								<?= $vid['title'] ?>
							</a>
						</li>
						<? endforeach; ?>
					</ol>
					<? endif; ?>
			</ul>
		</li>
	<? endforeach; ?>
</ol>

<!--
const STATUS_KEEP = 1;            // set bit to 1 = kept video
const STATUS_SWAP = 2;            // set bit to 1 = swapped video
const STATUS_EXACT = 4;           // set bit to 0 = normal swap, 1 = swap with an exact match
const STATUS_SWAPPABLE = 8;       // set bit to 1 = video with suggestions
const STATUS_NEW = 16;            // set bit to 1 = video with new suggestions
const STATUS_FOREVER = 32;        // set bit to 1 = no more matches
!>