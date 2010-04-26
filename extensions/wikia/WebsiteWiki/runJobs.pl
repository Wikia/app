#!/usr/bin/perl

#
# run with -I/usr/wikia/source/backend/lib parameter
#
use common::sense;
use Wikia::LB;
use FindBin qw($Bin);
use File::Basename;


my $dbh = Wikia::LB->instance->getConnection( Wikia::LB::DB_SLAVE, undef, Wikia::LB::CENTRALSHARED );

#
# find $IP value
#
my $IP =  $Bin ."/../../../";

#
# find LocalSettings file
#
my $LocalSettings = sprintf( "%s/wiki.factory/LocalSetting.php", dirname( Wikia::LB->instance->yml ) );

#
# get all wikis with wgMakeWikiWebsiteNew enabled
#

my $sth = $dbh->prepare(qq{
	SELECT cv_value, cv_city_id
	FROM   city_variables
	WHERE  cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name='wgMakeWikiWebsiteNew' )
});

$sth->execute();
while( my $row = $sth->fetchrow_hashref ) {
	my $cmd = sprint(
		"SERVER_ID=%d php %s/maintenance/runJobs.php --type newsite --conf %s",
		$row->{"cv_city_id"},
		$IP,
		$LocalSettings
	);

	print $cmd;
}
