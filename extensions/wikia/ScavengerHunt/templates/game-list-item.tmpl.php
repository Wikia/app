			<tr>
				<td>
					<?= htmlspecialchars($game->getName()) ?>
				</td>
				<td>
					<a href="<?= $toggleUrl ?>"><?= wfMsg( $game->isEnabled() ? 'scavengerhunt-list-enabled' : 'scavengerhunt-list-disabled' ) ?></a>
				</td>
				<td>
					<a href="<?= $editUrl ?>"><?= wfMsg('scavengerhunt-list-edit') ?></a>
				</td>
			</tr>