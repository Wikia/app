<?php

namespace Wikia\Tasks\Queues;

class RefreshTemplateLinksQueue extends Queue {
	const NAME = 'RefreshTemplateLinks';

	public function name() {
		return 'mediawiki_refresh_template_links';
	}
}
