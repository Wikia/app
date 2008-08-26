#!/usr/bin/perl
use strict;
use warnings;
use DBI;
use XML::Writer;
use IO::File;
use utf8;
use Encode;

#Edit here to setup your database connection information
my $dbUser = "root";
my $dbPass = "";
my $dbName = "wiki";
my $dbHost = "127.0.0.1";

my $start = time();
print $start . "\n";
#create and start the xml document
my $output = new IO::File(">wiktionaryz.xml");
my $xmlDoc = new XML::Writer(OUTPUT => $output,
                             DATA_MODE => 1,
                             DATA_INDENT => 4);
$xmlDoc->xmlDecl("UTF-8");
$xmlDoc->doctype("martif", "ISO 12200:1999A//DTD MARTIF core (DXFcdV04)//EN", "TBXcdv04.dtd");

#build the tbx header information
$xmlDoc->startTag("martif", "type"=>"TBX", "xml:lang"=>"en");
$xmlDoc->startTag("martifHeader");
$xmlDoc->startTag("fileDesc");
$xmlDoc->startTag("titleStmt");
$xmlDoc->dataElement("title", "Terminologocial Data");
$xmlDoc->endTag("titleStmt");
$xmlDoc->startTag("sourceDesc");
$xmlDoc->dataElement("p", "from the OmegaWiki Database " . gmtime());
$xmlDoc->endTag("sourceDesc");
$xmlDoc->endTag("fileDesc");
$xmlDoc->startTag("encodingDesc");
$xmlDoc->dataElement("p", "SYSTEM TBXDCSv05b.xml", "type"=>"DCSName");
$xmlDoc->endTag("encodingDesc");
$xmlDoc->endTag("martifHeader");
$xmlDoc->startTag("text");
$xmlDoc->startTag("body");

my $dbh = DBI->connect('dbi:mysql:database=' . $dbName . ';hostname=' . $dbHost . ';port=3306',
                      $dbUser,
                      $dbPass);
if (!$dbh) {
  die("Could not connect to database: " . $DBI::errstr);
}

#uw_expression_ns - contains term and language
#uw_meaning_relations - meaning relations meaning1_mid and meaning2_mid and relation_mid are ids in uw_expression_ns
#uw_syntrans - collections
#The definitions are in the TEXT table. You will find the keys to the
#table using the TRANSLATED_CONTENT table. Each set of languages is
#identified by a SET_ID, which we also refer to as a "Translated Content
#ID" (TCID) from the UW_DEFINED_MEANING table. Using a TCID, you can find
#the different TEXT_IDs for each LANGUAGE_ID, and then get the actual
#texts from the TEXT table.

#get all the distinct concepts (sets)
my @arrCollections;
my $sth = $dbh->prepare('SELECT DISTINCT(defined_meaning_id) FROM uw_syntrans');
$sth->execute();
while (my @ary = $sth->fetchrow_array()){
  push(@arrCollections, $ary[0]);
}
$sth->finish();

#get the expression_id that pertains to each set
foreach (@arrCollections) {
  my @arrExpressions;
  my $sth_coll = $dbh->prepare('SELECT expression_id FROM uw_syntrans WHERE set_id=' . $_);
  $sth_coll->execute();
  while (my @ary = $sth_coll->fetchrow_array()) {
    push(@arrExpressions, $ary[0]);
  }
  $sth_coll->finish();
  
  #check to see if there are expressions in the set
  if ($#arrExpressions > 0) {
    #start the concept
    #print "Processing Concept c" . $_ . "\n";
    $xmlDoc->startTag("termEntry", "id"=>"c".$_);
    
    #get the information about all of the expressions in this set
    my $sql = "SELECT * FROM uw_expression_ns " .
              "LEFT JOIN language ON uw_expression_ns.language_id=language.language_id " .
              "WHERE expression_id IN (" . join(", ", @arrExpressions) . ") " .
              "GROUP BY uw_expression_ns.language_id";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    my $sCurrLang = "";
    my $nCount = 0;
    while (my $result = $sth->fetchrow_hashref()) {
      my $sLangID = $result->{language_id};
      my $sLang = $result->{wikimedia_key};
      my $sID = $result->{expression_id};
      my $sTerm = $result->{spelling};

      #determine if this is a new language set or not
      if (($sCurrLang ne $sLang) && $nCount > 0) {
        #since new language set and this is not the first language then close
        #the last langSet and open a new one
        $sCurrLang = $sLang;
        $xmlDoc->endTag("langSet");
        $xmlDoc->startTag("langSet", "xml:lang" => $sLang);
      }
      elsif (($sCurrLang ne $sLang) && $nCount == 0) {
        #this is the first language set so start a langSet
        $sCurrLang = $sLang;
        $xmlDoc->startTag("langSet", "xml:lang" => $sLang);
      }
      
      #print out language level information
      #get the definition
      my $def_sql = "SELECT old_text FROM uw_defined_meaning " . 
                    "LEFT JOIN translated_content ON meaning_text_tcid=set_id " .
                    "LEFT JOIN `text` ON text_id=old_id " .
                    #"WHERE expression_id=" . $sID;
                    "WHERE expression_id=" . $sID . " AND language_id=" . $sLangID;
      my $def_sth = $dbh->prepare($def_sql);
      $def_sth->execute();
      while (my $def_result = $def_sth->fetchrow_hashref()) {
        my $definition = $def_result->{old_text};
        $definition =~ s/\r\n/ /gi;
        $xmlDoc->startTag("descrip", "type"=>"definition");
        $xmlDoc->characters($definition);
        $xmlDoc->endTag("descrip");
      }
      
      #get the other relationships
      my $rel_sql = "SELECT meaning2_mid, relationtype_mid, spelling " .
                    "FROM uw_meaning_relations " .
                    "LEFT JOIN uw_expression_ns ON meaning2_mid=expression_id " .
                    "WHERE meaning1_mid=" . $sID ;
                    #"WHERE meaning1_mid=" . $sID . " AND language_id=" . $sLangID;
      
      my $rel_sth = $dbh->prepare($rel_sql);
      $rel_sth->execute();
      while (my $rel_result = $rel_sth->fetchrow_hashref()) {
        my $relType = $rel_result->{relationtype_mid};
        my $relTerm = $rel_result->{spelling};
        my $relID = $rel_result->{meaning2_mid};
        
        #broader terms
        if ($relType eq "2" || $relType eq "3") {
          $xmlDoc->startTag("descrip", "type"=>"subjectField");
          $xmlDoc->characters($relTerm);
          $xmlDoc->endTag("descrip");
        }
        elsif ($relType eq "4" || $relType eq "5") {
          $xmlDoc->startTag("descrip", "type"=>"relatedConceptBroader", "target"=>"t".$relID);
          $xmlDoc->characters($relTerm);
          $xmlDoc->endTag("descrip");
        }
        #narrower terms
        elsif ($relType eq "6" || $relType eq "7") {
          $xmlDoc->startTag("descrip", "type"=>"relatedConceptNarrower", "target"=>"t".$relID);
          $xmlDoc->characters($relTerm);
          $xmlDoc->endTag("descrip");
        }
        #related terms
        elsif ($relType eq "8" || $relType eq "9") {
          $xmlDoc->startTag("descrip", "type"=>"relatedConcept", "target"=>"t".$relID);
          $xmlDoc->characters($relTerm);
          $xmlDoc->endTag("descrip");
        }
      }
      #print out the ntig and termGrp
      #print $sTerm . "\n";
      $xmlDoc->startTag("ntig", "id"=>"t".$sID);
      $xmlDoc->startTag("termGrp");
      $xmlDoc->dataElement("term", $sTerm);
      $xmlDoc->endTag("termGrp");
      $xmlDoc->endTag("ntig");
      
      #increment the count
      $nCount++;
    }
    #Close the last langSet that was left open
    $xmlDoc->endTag("langSet");
    $sth->finish();
    #end the concept
    $xmlDoc->endTag("termEntry");
  }
}

#close the database connection
$dbh->disconnect();

#write any end tags required to close the document
$xmlDoc->endTag("body");
$xmlDoc->endTag("text");
$xmlDoc->endTag("martif");
$xmlDoc->end();
my $end = time();
print $end . "\n";
my $dif = $end - $start;
print $dif . " seconds\n";
exit(0);