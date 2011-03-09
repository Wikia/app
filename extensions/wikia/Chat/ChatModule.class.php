<?php
class ChatModule extends Module {

	var $wgStylePath;
	var $wgExtensionsPath;
	var $globalVariablesScript;
	var $chatId;
	var $chatName;
	var $chatTopic;
	var $userList;
	var $messages;
	var $isChatMod;

	public function executeIndex() {
		global $wgUser;
		wfProfileIn( __METHOD__ );
	
		// Find the chat for this wiki (or create it, if it isn't there yet).
		$this->chatName = $this->chatTopic = "";
		$this->chatId = Chat::getDefaultChatId($this->chatName, $this->chatTopic);

		// TODO: Check if the user is already in the chat.  If so, boot the other "them" first (probably not needed too much for the prototype, but def before rolling out widely).

		// Join the chat (this user will show up in the user-list).
		$chat = new Chat($this->chatId);
		$chat->join($wgUser->getName());

		if ($wgUser->isAllowed( 'chatmoderator' )) {
			$this->isChatMod = 1;
		} else {
			$this->isChatMod = 0;
		}

		// Load the initial state of the chat.
		$this->userList = $chat->getUserList();
		$this->messages = $chat->getMessages();

		$this->globalVariablesScript = Skin::makeGlobalVariablesScript(Module::getSkinTemplateObj()->data);

		wfProfileOut( __METHOD__ );
	}

}
