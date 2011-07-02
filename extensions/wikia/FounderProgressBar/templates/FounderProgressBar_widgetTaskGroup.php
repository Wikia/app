<? $itemsPerRow = floor(count($taskList) / 3); ?>
<? $extraItems = count($taskList) % 3; ?>
<? $index = 0; ?>
<? for ($j = 0; $j < 3; $j++) { ?>
	<ul class="activities">
		<? $itemsInThisRow = $extraItems > 0 ? ($itemsPerRow + 1) : $itemsPerRow; ?>
		<? $extraItems--; ?>
		<? for ($i = 0; $i < $itemsInThisRow; $i++) { ?>
			<li class="activity<?= empty($taskList[$index]['task_completed']) ? '' : ' completed' ?><?= isset($clickEvents[$taskList[$index]['task_id']]) ? ' clickevent' : '' ?><?= empty($taskList[$index]['task_locked']) ? '' : ' locked'?>" data-task-id="<?= $taskList[$index]['task_id'] ?>">
				<div class="activity-label"><?= $taskList[$index]['task_label'] ?></div>
				<div class="activity-description">
					<div class="description">
						<h4><?= $taskList[$index]['task_label'] ?></h4>
						<p><?= $taskList[$index]['task_description'] ?></p>
						<div class="actions">
							<? if(empty($taskList[$index]['task_locked']) && empty($taskList[$index]['task_completed'])) { ?>
								<a href="<?= $taskList[$index]['task_url'] ?>" class="wikia-button"><?= $taskList[$index]['task_action'] ?></a>
							<? } ?>
						</div>
						<canvas class="tail" height="15" width="25"></canvas>
					</div>
				</div>
			</li>
		<? $index++; } ?>
	</ul>
<? } ?>