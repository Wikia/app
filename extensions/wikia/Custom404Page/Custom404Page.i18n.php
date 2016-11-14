<?php

$messages = [];

$messages['en'] = [
	'custom404page-noarticletext-alternative-found' => '=== \'\'\'Did you mean <span class="alternative-suggestion" data-type="alternative-suggestion-question">[[$1]]</span>?\'\'\' ===

Article {{FULLPAGENAME}} was not found. What do you want to do?

* Go to <span class="alternative-suggestion" data-type="alternative-suggestion-action">[[$1]]</span> instead
* Search existing articles for <span class="plainlinks">[{{fullurl:Special:Search|search={{urlencode:{{PAGENAME}}}}}} {{PAGENAME}}]</span>
* Create article <span class="plainlinks">[{{fullurl:{{FULLPAGENAME}}|action=create}} {{FULLPAGENAME}}]</span>',
];

$messages['qqq'] = [
	'custom404page-noarticletext-alternative-found' => 'Message shown when the article was not found, but we have an alternative one to direct user to.',
];
