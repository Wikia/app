<select name="<?= $name ?>" id="<?= $id ?>">
	<? foreach ($choices as $choice): ?>
		<option value="<?= $choice['value'] ?>"<? if($choice['value']==$value): ?>selected<? endif ?>><?= $choice['option'] ?></option>
	<? endforeach ?>
</select>