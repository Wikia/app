			<tr>
				<td>
					<?= htmlspecialchars($game->getName()) ?>
				</td>
				<td>
					<?= wfMsg( $game->isEnabled() ? 'scavengerhunt-list-enabled' : 'scavengerhunt-list-disabled' ) ?>
				</td>
				<td>
					<a href="<?= $editUrl ?>" ><?= wfMsg('scavengerhunt-list-edit') ?></a>
				</td>
			</tr>