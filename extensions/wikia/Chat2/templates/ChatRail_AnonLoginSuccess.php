<p class="chat-join">
	<?= wfMessage( 'chat-great-youre-logged-in' )->escaped() ?>
	<button id="modal-join-chat-button" data-event="chat" data-chat-page="<?= $linkToSpecialChat ?>">
		<?= htmlspecialchars($buttonText) ?>
	</button>
</p>
