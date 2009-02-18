#!/usr/bin/perl

my $wikia_lib;
BEGIN {
	$wikia_lib = "/home/wikicities/conf/mediawiki/wikia-utils/lib";
}

use DBI;
use Cwd;
use Getopt::Long;
use Data::Dumper;
use Time::Local ;
use Encode;
use POSIX qw(setsid uname);
use Date::Manip;
use IPC::Run qw( run timeout close_terminal);
use FindBin qw($Bin);

use lib $wikia_lib;
use Wikia::Config;
use Wikia::Utils;
use Wikia::DB;

=info
Some globals here!
=cut
my $oConf = new Wikia::Config( {logfile => "/tmp/loader.log" } );
my $db_ext = new Wikia::DB( {"host" => DB_EXT_SLAVE} );
my $scriptPath = $Bin."/daemons/";
my $logdir = "/tmp";

#read long options
sub do_help()
{
    print <<EOF
Usage: dmon_loader start|stop|status|list
    dmon_loader start <task_id> - start task (with --current param starts today's daemons, with --all (default option) param starts all daemons)
    dmon_loader stop <task_id> - stop task (with --current param starts today's daemons, --all (default option) param starts all daemons)	
    dmon_loader status - show which daemons are running
    dmon_loader list - list defined daemons 
    dmon_loader help - show this help
EOF
;
}

# read config options from DB (dbarchive)
sub readconfig() 
{
	my @tasks = ();

	my $select = "dj_id, dj_dt_id, dj_start, dj_end, dj_frequency, dj_param_values, dj_result_emails";
	my $from = "`dataware`.`daemon_tasks_jobs`";
	my @where = (
		"dj_start < date_format(now(), '%Y%m%d')",
		"dj_end >= date_format(now(), '%Y%m%d')",
		"dj_visible = 1"
	);
	my @options = ("order by dj_id");

	my $sth = $db_ext->select_many($select, $from, \@where, \@options);
	if ($sth) {
		while(my $values = $sth->fetchrow_hashref()) {
			push @tasks, $values;
		}
		$sth->finish();
	}
	#----
    return ( \@tasks, parse_config(\@tasks) );
}

# read daemons from DB (dbarchive)
sub readdaemons() 
{
	my $tasks = ();

	my $select = "dt_id, dt_name, dt_script";
	my $from = "`dataware`.`daemon_tasks`";
	my @where = ( "dt_visible = 1" );
	my @options = ("order by dt_id");
	
	my $sth = $db_ext->select_many($select, $from, \@where, \@options);
	if ($sth) {
		while(my $values = $sth->fetchrow_hashref()) {
			$tasks->{$values->{dt_id}} = $values;
		}
		$sth->finish();
	}
	
    return $tasks;
}

### parse list of tasks
sub parse_config($)
{
    my $tasks = shift;
    
    my $counter = 0;
    my @config = ();

	my $today = substr (&ParseDate("today"), 0, 8);
    foreach ( @{$tasks} ) {
        $counter++;
        my $mask = "0:1:0:0:0:0:0";
        if ($_->{dj_frequency} eq 'day') {
        	$mask = "0:0:0:1:0:0:0";
		} elsif ($_->{dj_frequency} eq 'week') {
			$mask = "0:0:1:0:0:0:0";
		} elsif ($_->{dj_frequency} eq 'month') {
			$mask = "0:1:0:0:0:0:0";
		}
		# substr only date from date and time string
        @date = map { substr ($_, 0, 8) } &ParseRecur($mask,$_->{dj_start},$_->{dj_start},$_->{dj_end});
        next if (!grep /^\Q$today\E$/,@date);
        
        push @config, $_;
    }
    
    return \@config;
}

sub do_list($$)
{
    my ($Config, $Daemons) = @_;

	$oConf->log("Number of daemons to run: " . scalar @{$Config});
	my $row;
    foreach (@{$Config}) {
    	$row++;
        $oConf->log(sprintf("(taskid: %d) %s %s\n",$_->{dj_id}, $scriptPath . $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values}));
    }
}

sub check_if_running($)
{
	my $daemon = shift;

	foreach(split("\\n", `ps aux | grep '$daemon'`)) {
		my $line = $_;
		$line =~ s/(\s+)/;/sg;
		my ($user, $pid, ) = split /\;/, $line;
		unless ($_  =~ m/$0|grep|launcher/) {
			return $pid;
		}
	}

	return 0;
}

sub do_status($$)
{
    my ($Config, $Daemons) = @_;
	
	$oConf->log ("checking tasks:");
    foreach (@{$Config}) {
    	my $daemon = sprintf("%s %s", $scriptPath . $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values});
		my $chpid = check_if_running($daemon);
		my $_txt = "script (taskid: " . $_->{dj_id} . ") " . $daemon . "\t";
		if ($chpid) {
			$_txt .= "running ($chpid)";
		} else {
			$_txt .= "not running";
		}
		$oConf->log($_txt);
    }
}

sub do_stop($$;$)
{
	my ( $Config, $Daemons, $taskid ) = @_;
	
	unless (defined($taskid)) {
		$oConf->log("Give taskid or --all if you want to start all daemons");
		exit(1);
	}
	
	if ( ($taskid eq '--all') || ($taskid eq '--current') ) {
		##
		## killall @!$$!$#$^$%$#%$#^%
		##
		foreach (@{$Config}) {
			my $daemon = sprintf("%s (params: %s)", $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values});
			my $daemon_path = sprintf("%s %s", $scriptPath . $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values});
            my $_tmp =  "Stopping script: " . $daemon . "\t"; 
			my $chpid = check_if_running($daemon_path);
			if ($chpid) {
				kill -9, $chpid;
				$_tmp .= "(pid ".$chpid.")\n";
			} else {
				$_tmp .= "not running!"
			}
			$oConf->log($_tmp);
		}
	} else {
		##
		## kill one daemon
		##
		my $loop = 0;
		foreach (@{$Config}) { 
			next if ($_->{dj_id} != $taskid);
			$loop++;
			# found something
			my $daemon = sprintf("%s (params: %s)", $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values});
			my $daemon_path = sprintf("%s %s", $scriptPath . $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values});
            my $_tmp = "Stopping script: " . $daemon . "\t"; 
			my $chpid = check_if_running($daemon_path);
			if ($chpid) {
				kill -9, $chpid;
                $_tmp .= "(pid ".$chpid.")\n";
			} else {
				$_tmp .= "not running!"
			}
			$oConf->log($_tmp);
		}
		$oConf->log ("Daemon with taskid: ".$taskid." not defined database. Exiting...") unless ( $loop ) ;
    }
}

sub do_start($$;$)
{
    my ( $Config, $Daemons, $taskid ) = @_;
    
	unless (defined($taskid)) {
		print "Give taskid or --all if you want to start all daemons\n";
		exit(1);		
	}
	
	if ( ($taskid eq '--all') || ($taskid eq '--current') ) {
        foreach (@{$Config}) {
            run_daemon($_->{dj_id}, $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values});
        }
    } else {
    	my $loop = 0;
        foreach (@{$Config}) {
        	if ($_->{dj_id} == $taskid) {
				run_daemon($_->{dj_id}, $Daemons->{$_->{dj_dt_id}}->{dt_script}, $_->{dj_param_values});
        		$loop++;
			}
        }
		$oConf->log ("Daemon with taskid: $taskid not defined in config file. Exiting...\n") unless ($loop);
    }        
}

sub get_now()
{
    my ($sec,$min,$hour,$day,$mon,$year,$wday,$yday,$isdst) = localtime(time);
    
    return sprintf("%04d-%02d-%02d %02d:%02d", $year+1900, $mon+1, $day, $hour, $min);
}

sub run_daemon($$;$) 
{
	my ($id, $daemon, $params) = @_; 

	return 0 unless defined($daemon);
	### create lock directory
	
	my $daemonPath = sprintf("%s %s", $scriptPath . $daemon, $params);
	my $chpid = check_if_running($daemonPath);
	if ( ($chpid) && (kill 0, $chpid) ) {
		$oConf->log(printf("It seems that %s is running with pid = %d\n", $daemon, $chpid));
		$oConf->log("Check process list.\n");
		return;
	}

	my $logfile = "$logdir/$daemon.log";
	my $rstfile = "$logdir/restart.log";

	$oConf->log( sprintf("Starting %s with params: %s", $daemon, $params) );
	### forkujemy
	my $pid = fork;
	unless (defined($pid)) {
		$oConf->log ("fork failed, $!\n");
		return 0;
	}

	if ($pid != 0) {
		return 1;
	}
	setsid();
	$oConf->log ("process PID: ". $$.$/);

	open(OUT,">>",$logfile) or warn("Cannot open $logfile");
	open(ERR,">>",$logfile) or warn("Cannot open $logfile");
	open(LOG,">>",$rstfile) or warn("Cannot open $rstfile");

	close_terminal();

	autoflush OUT, 1;
	autoflush ERR, 1;
	autoflush LOG, 1;

	$oConf->log ("Logs go to $logfile");

	my @args = ("perl", $scriptPath . $daemon, $params, "--TASKID=$id");
	$oConf->log(Dumper(@args));
	run \@args, \undef, \*OUT, \*ERR; 
	
	return 1;
}

#############################################################################
################################   main   ###################################

my ($AllTasks, $Config) = readconfig();
my $Daemons = readdaemons();

if (@ARGV) {
	if ($ARGV[0] eq 'start') {
		do_start(($ARGV[1] eq '--current') ? $Config : $AllTasks, $Daemons, $ARGV[1]);
	} elsif ($ARGV[0] eq 'stop') {
		do_stop(($ARGV[1] eq '--current') ? $Config : $AllTasks, $Daemons, $ARGV[1]);
	} elsif ($ARGV[0] eq 'status') {
		do_status($AllTasks, $Daemons);
	} elsif ($ARGV[0] eq 'list') {
		do_list($AllTasks, $Daemons);
	} else {
		do_help();
	}
} else {
	do_help();
}    
exit(0);
