<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
/*]]>*/
</style>
<form id="tm-form" action="<?= $title->getLocalURL() ?>" method="post">
	<fieldset>
		<legend>
			Current filters:
			[status:
			<strong>
			<?php
			if (!isset($current["task_status"]) || is_null($current["task_status"])) {
				echo "not set";
			}
			else {
				echo $statuses[$current["task_status"]];
			}
			echo "</strong>]";
			?>
		</legend>
		<label>Status</label>
		<select name="wpStatus">
			<option value="-1">Not set</option>
			<?php foreach ( $statuses as $id => $status ):?>
			<option
				value="<?= $id ?>"
				<?php
				if ( isset($current["task_status"]) &&
					$current["task_status"] == $id &&
					!is_null($current["task_status"])
				){
					echo "selected=\"selected\"";
				}
				?>
			><?= $status ?></option>
			<?php endforeach ?>
		</select>
		&nbsp;
		<input type="submit" value="Set filter" name="wpSubmit" />
		<label>Type:</label>
		<?php foreach ( $types as $id => $type ):
			$selected = isset($current['task_type']) ? (in_array($id, $current['task_type']) ? ' checked="checked"' : '') : ' checked="checked"';
		?>
		<label><input type="checkbox" name="wpType[]" value="<?= $id ?>"<?= $selected ?>/><?= $id ?></label>
		<?php endforeach ?>
	</fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
