<?php
/**
 * Clause
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

interface ClauseBuild {
	function build(Breakdown $bk, $tabs);
}