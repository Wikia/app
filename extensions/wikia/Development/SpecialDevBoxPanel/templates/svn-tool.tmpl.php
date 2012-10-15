<?php foreach ($errors as $e): ?>
<div class="error" style="background: #FF8888; border: 2px #AAAAAA solid"><?= $e ?></div>
<?php endforeach; ?>
<form name="svn_tool" action="<?= $action ?>">
<table>
	<tr>
		<td>Branch</td>
		<td>Current: <a href="<?= $svnUrl ?>"><?= $svnUrl ?></a></td>
		<td>Switch Branch:
			<select name="branch">
				<?php foreach ($branches as $b): ?>
				<option value="<?= $b ?>"><?= $b ?></option>
				<?php endforeach; ?>
			</select>
			<input type="submit" name="switch" value="Switch">
		</td>
	</tr>
	<tr>
		<td>Updated</td>
		<td>Last update: <?= $svnUpdated ?></td>
		<td><input type="submit" name="update" value="Update Now"></td>
	</tr>
</table>
</form>
