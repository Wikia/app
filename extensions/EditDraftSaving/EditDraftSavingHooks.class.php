<?php

class EditDraftSavingHooks {
	static public function onAlternateEdit(EditPage $editPage) {
		RequestContext::getMain()->getOutput()->addModules('ext.wikia.EditDraftSaving');
	}
}
