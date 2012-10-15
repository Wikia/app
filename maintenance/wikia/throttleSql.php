<?php
/* Run SQL statments through a throttle, to avoid overwhelming slaves.
 * Lagged Slaves are bad news. It's easy to overwhelm the slaves
 * with a large import on the master, because the slaves must execute
 * sql statements linearly, while the master is executing them in parallel.
 *
 * This script will take incoming sql statements, run them on the master,
 * and periodically stop and wait for the slaves to catch up as needed.
 *
 * Tips for incoming sql statements:
 * ) While I've tested this on output from mysqldump, any valid sql statements
 * delimited with ";\n" should work.
 * ) This script will throttle sql statements, but if the individual statements
 * take a while to run (such as ALTER TABLE), then the slave will still be lagged.
 * To avoid this, use the "--skip-disable-keys" for mysqldump. The import will
 * be slower, but it will cause less slave lag.
 *
 * @author Nick Sullivan nick at wikia-inc.com
 */

$usage="
Usage: php {$argv[0]} --inputfile=my.sql --database=mydatabase [options]
	--help          : this help message
	--inputfile     : use this inputfile for sql statements, use '-' for STDIN (required)
	--database      : use this database as the destination for the sql statements (required)
	--checkinterval : check for slave lag every x sql statements (default 10)
	--maxlag        : limit slave lag to this many seconds (default 10)
	--limit         : only process this many sql statements
	--offset        : skip this many sql statements before issuing
	--debug         : number for debug output: 0-9, the higher the more verbose\n";
$options = array('inputfile', 'database', 'checkinterval', 'maxlag', 'limit', 'offset', 'progress', 'debug');
require_once( 'commandLine.inc' );

///// Command line options. Defaults, and required fields
if(@$options['help']) {
  echo $usage;
  exit;
}
if (empty($options['database'])){
  echo "Error: 'database' is a required field\n";
  echo $usage;
  exit;
}
if (empty($options['inputfile'])){
  echo "Error: 'inputfile' is a required field\n";
  echo $usage;
  exit;
} else if ($options['inputfile']=='-'){
  $options['inputfile']='php://stdin';
}
if (! $fh=fopen($options['inputfile'],'r')){
  echo " Error opening input file ({$options['inputfile']})\n";
  exit;
}
if (empty($options['maxlag'])){
  $options['maxlag']=10; 
}
if (empty($options['checkinterval'])){
  $options['checkinterval']=10;
}
$options['debug']=intval(@$options['debug']);


///// Let's go
$wgOut->disable();
$dbw = wfGetDB( DB_MASTER );
$dbw->selectDB($options['database']) || die ("Error selecting db: " . $dbw->lastError() . "\n");
$sqlprefix="/*SQL from " . basename(__FILE__) . ", issued by " . getenv('LOGNAME') . "*/";

$sqlcount=0; $sqlbuffer=''; $linecount=0; $sqlerrors=0;
while ($line=fgets($fh)){
  $linecount++;
  $line=rtrim($line); // strip off trailing newline
    
  // Remove empty lines and lines with only comments
  $line=preg_replace('#^/\*.*\*/;$#', '', $line); // sql line with a comment only.
  if ($line=='' || (substr($line, 0, 2) == '--') ){
    if ($options['debug'] >= 8) echo "Skipping empty line $linecount\n";
    continue;
  }

  
  // Tricky: Handle multiline sql statements
  if ($line[strlen($line)-1] == ';'){ // last character is ';'
    // We have a complete sql statmeent
    $sql=$sqlbuffer . $line;
    $sqlbuffer='';
  } else {
    $sqlbuffer.=$line;
    continue; // Read the next line
  }

  //// Handle Offset
  $sqlcount++;
  if (!empty($options['offset']) && ($sqlcount <= $options['offset'])){
    if ($options['debug'] >= 8) echo "Skipping line until {$options['offset']}\n";
    continue;
  }

 
  //// Issue Query.
  if ($options['debug'] >= 6) echo "SQL to be executed: '$sql'\n";
  if (! $dbw->doQuery($sqlprefix . $sql)){
    echo "SQL Error: " . $dbw->lastError();
    $sqlerrors++;
  }
  if ($options['debug'] >=1 ) echo '.'; // Print a tick
  
  if (!empty($options['limit']) && ($sqlcount >= $options['limit'])){
    if ($options['debug'] >= 3) echo "Stopping at max of {$options['limit']}\n"; 
    break;
  }

  //// Here's the magic. Every few sql statements, check the slave lag to make sure everything is ok.
  if (($sqlcount % $options['checkinterval'])==0){
    if ($options['debug'] >=5 ) echo "Checking slave lag\n";
    wfWaitForSlaves( $options['maxlag'] );
  }
}
echo "Done. $linecount lines processed, $sqlcount sql statements executed, $sqlerrors errors.\n";

