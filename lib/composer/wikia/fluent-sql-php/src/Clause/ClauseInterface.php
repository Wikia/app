<?php

/**
 * ClauseInterface
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql\Clause;

use FluentSql\Breakdown;

interface ClauseInterface {
	function build(Breakdown $bk, $tabs);
}
