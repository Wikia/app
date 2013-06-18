<p><?= wfMsg( 'userrollback-form-intro' ); ?></p>
<?php if ( !empty($status) ) { ?>
<p<?= !empty($statusClass) ? " class=\"$statusClass\"" :'' ?>><?= $status ?></p>
<?php } ?>
<form method="POST" class="userrollback-form">
<?php if ( empty($confirmationRequired) ) { // start form ?>
<?= wfMsg( 'userrollback-form-users' ) ?><br />
<?php echo F::app()->renderView( 'UserRollbackSpecial', 'displayErrors', array( 'errors' => $errors, 'name' => 'users' ) ); ?>
<textarea name="users"><?= htmlspecialchars($request->getUsers()) ?></textarea><br />
<?= wfMsg( 'userrollback-form-time' ) ?><br />
<small><?= wfMsg( 'userrollback-form-time-hint' ) ?></small><br />
<?php echo F::app()->renderView( 'UserRollbackSpecial', 'displayErrors', array( 'errors' => $errors, 'name' => 'time' ) ); ?>
<input type="text" name="time" value="<?= htmlspecialchars($request->getTime()) ?>" /><br />
<b><?= wfMsg( 'userrollback-form-priority' ) ?></b><br />
<label><input type="radio" name="priority" value="1"<?= $request->getPriority() != 100 ? ' checked="checked"' : '' ?> /><?= wfMsg( 'userrollback-form-priority-normal' ) ?></label>
<label><input type="radio" name="priority" value="100"<?= $request->getPriority() == 100 ? ' checked="checked"' : '' ?>  /><?= wfMsg( 'userrollback-form-priority-high' ) ?></label>
<br />
<input type="submit" value="<?= wfMsg( 'userrollback-form-submit' ) ?>" />
<?php } else { // $confirmationRequired ?>
<p><?= wfMsg( 'userrollback-form-confirmation' ); ?></p>
<b><?= wfMsg( 'userrollback-form-users' ) ?></b><br />
<ul>
<?php foreach ($request->getUserDetails() as $user) { ?>
<li><?= $user['name'] ?> (<?= wfMsg( 'userrollback-form-user-id', $user['id'] ) ?>)</li>
<?php } ?>
</ul>
<b><?= wfMsg( 'userrollback-form-time' ) ?></b><br />
<ul><li><?= $request->getTime() ?></li></ul>

<b><?= wfMsg( 'userrollback-form-priority' ) ?></b><br />
<ul><li>
<?= $request->getPriority() != 100 ? wfMsg( 'userrollback-form-priority-normal' ) : wfMsg( 'userrollback-form-priority-high' ) ?><br />
</li></ul>

<input type="hidden" name="users" value="<?= htmlspecialchars($request->getUsers()) ?>" />
<input type="hidden" name="time" value="<?= htmlspecialchars($request->getTime()) ?>" />
<input type="hidden" name="priority" value="<?= htmlspecialchars($request->getPriority()) ?>" />

<input type="hidden" name="confirm" value="1" />

<input type="submit" value="<?= wfMsg( 'userrollback-form-confirm' ) ?>" />
<input type="submit" class="secondary" name="back" value="<?= wfMsg( 'userrollback-form-back' ) ?>" />
<?php } ?>
</form>