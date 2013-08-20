<h1>
	<?= $result !== 'error' ? wfMessage('usersignup-resend-email-heading-success')->escaped() : wfMessage('usersignup-resend-email-heading-failure')->escaped() ?>
</h1>
<p>
	<?= $msg ?>
</p>