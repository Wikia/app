<?=$element->renderLabel()?>
<?// TODO think where we should add label?>
<input name="<?= $name ?>" type="<?= $type ?>" <? if (isset($id)): ?>id="<?= $id ?>" <? endif ?><?= $attributes ?> value="<?= htmlspecialchars($value)?>"/>