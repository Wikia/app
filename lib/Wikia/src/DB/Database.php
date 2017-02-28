<?php
namespace Wikia\DB;

interface Database {
	const DB_SLAVE = 'db.local.slave';
	const DB_MASTER = 'db.local.master';
}


interface ExternalSharedDatabase {
	const DB_SLAVE = 'db.externalShared.slave';
	const DB_MASTER = 'db.externalShared.master';
}

interface DatawareDatabase {
	const DB_SLAVE = 'db.dataware.slave';
	const DB_MASTER = 'db.dataware.master';
}

interface SpecialsDatabase {
	const DB_SLAVE = 'db.specials.slave';
	const DB_MASTER = 'db.specials.master';
}

interface StatsDatabase {
	const DB_SLAVE = 'db.stats.slave';
	const DB_MASTER = 'db.stats.master';
}
