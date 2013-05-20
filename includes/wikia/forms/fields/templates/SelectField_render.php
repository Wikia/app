<select name="<?= $name ?>" id="<?= $id ?>">
	<? foreach ($choices as $choice): ?>
		<option value="<?= $choice['value'] ?>"<? if(isset($choice['selected'])): ?>selected<? endif ?>><?= $choice['option'] ?></option>
	<? endforeach ?>
</select>