<h3>Classification of [<a href="<?=$domain_name?>"><?=$domain_name?></a>]</h3>

<p>Common prefix: <b><?=$commonPrefix?></b> | Search phrases: <b><?=$phrases?></b></p>

<table border="1" cellpadding="5">
	<tr>
		<th>Wiki Topics by top pages</th>
		<th>Wiki Topics by links</th>
		<th>Wiki Topics by redirects</th>
		<th>Wiki Topics by domains</th>
		<th>Wiki Topics merged</th>
	</tr>
		<td valign="top">
			<ul>
			<?php 	foreach ( $importantByTopPages as $imp ) {
						echo '<li>'	. $imp['name']	.'<br/>[score: '.$imp['score']. ']</li>';
					}
			?>
			</ul>
		</td>
		<td valign="top">
			<ul>
				<?php 	foreach ( $importantByLinks as $imp ) {
					echo '<li>'	. $imp['name']	.'<br/>[score: '.$imp['score']. ']</li>';
				}
				?>
			</ul>
		</td>
		<td valign="top">
			<ul>
				<?php 	foreach ( $importantByRedirects as $imp ) {
					echo '<li>'	. $imp['name']	.'<br/>[score: '.$imp['score']. ']</li>';
				}
				?>
			</ul>
		</td>

		<td valign="top">
			<ul>
				<?php 	foreach ( $importantByDomainNames as $imp ) {
					echo '<li>'	. $imp['name']	.'<br/>[score: '.$imp['score']. ']</li>';
				}
				?>
			</ul>
		</td>
		<td valign="top">
			<ul>
				<?php 	foreach ( $merged as $imp ) {
					echo '<li>'	. $imp['name']	.'<br/>[score: '.$imp['score']. ']</li>';
				}
				?>
			</ul>
		</td>
	</tr>
</table>
<hr>
<table border="1" cellpadding="5">
	<tr>
		<th>Classified pages</th>
	</tr>
	<tr>
		<td valign="top">
			<ul>
				<?php	foreach ( $wikiTopics as $topic ) {
					foreach ( $topic->entities as $entity ) {
						//if ( in_array( $entity->type, array('movie', 'game', 'book') ) ) {
						if ( !empty( $entity->name ) ) {
							echo  '<li>' . $entity->name .': [' . $entity->type . '] </li>';
						}
						//}
					}
				}
				?>
			</ul>
		</td>
</table>
