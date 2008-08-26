<!-- s:<?= __FILE__ ?> -->
<form action="<?= $title->getLocalUrl( "action=task" ) ?>" method="post">
    <fieldset>
        <legend>Add task</legend>
        <label>Choose task type</label>
        <select name="wpType" id="task-type">
        <?= print_r( $types ) ?>
        <?php foreach( $types as $type => $class ): ?>
            <option value="<?= $class ?>"><?= $type ?></option>
        <?php endforeach ?>
        </select>
        <input type="submit" name="wpSubmit" value="Create new task" />
    </fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
