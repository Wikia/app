#!/usr/local/bin/perl

# Copyright (C) 2011 Wikimedia Foundation
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License version 2
# as published by the Free Software Foundation.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
# See the GNU General Public License for more details, at
# http://www.fsf.org/licenses/gpl.html

# Author:
# Erik Zachte, email ezachte@wikimedia.org
# loosely based on predecessor
# http://svn.wikimedia.org/viewvc/mediawiki/trunk/wikistats/reportcard/ReportCardExtractWikiCountsOutput.pl

# Functionality:
# tba

# Parameters:
# tba

# Output:
# updated csv file for import in MySQL

# http://svn.wikimedia.org/viewvc/mediawiki/trunk/wikistats/analytics/

  use Getopt::Std ;

  $true  = 1 ;
  $false = 0 ;

  @projects = ('wb','wk','wn','wp','wq','ws','wv','wx','commons','*') ;

  $file_csv_monthly_data         = "StatisticsMonthly.csv" ;
  $file_csv_user_activity_spread = "StatisticsUserActivitySpread.csv" ;
  $file_csv_analytics_in         = "analytics_in_wikistats.csv" ;

  &ParseArguments ;
  &ReadStatisticsMonthly ;
  &FindLargestWikis ;
  &WriteMonthlyData ;

  print "\nReady\n\n" ;
  exit ;

sub ParseArguments
{
  print "ParseArguments\n" ;
  my (@options, $arguments) ;

  getopt ("io", \%options) ;

  foreach $arg (sort keys %options)
  { $arguments .= " -$arg " . $options {$arg} . "\n" ; }
  print ("\nArguments\n$arguments\n") ;

  if (! -d '/mnt/') # EZ test
  {
    $path_in  = "c:/\@ wikimedia/# out bayes" ;
    $path_out = "c:/MySQL/analytics" ;
  }
  else
  {
    die ("Specify input folder for projectcounts files as: -i path") if (! defined ($options {"i"})) ;
    die ("Specify output folder as: -o path'")                       if (! defined ($options {"o"})) ;

    $path_in  = $options {"i"} ;
    $path_out = $options {"o"} ;
  }

  die "Input folder '$path_in' does not exist"   if (! -d $path_in) ;
  die "Output folder '$path_out' does not exist" if (! -d $path_out) ;

  print "Input  folder: $path_in\n" ;
  print "Output folder: $path_out\n\n" ;

  $file_csv_out = "$path_out/analytics_in_wikistats.csv" ;
}

sub ReadStatisticsMonthly
{
  print "ReadStatisticsMonthly\n" ;
  &ReadStatisticsMonthlyForProject ("wb") ;
  &ReadStatisticsMonthlyForProject ("wk") ;
  &ReadStatisticsMonthlyForProject ("wn") ;
  &ReadStatisticsMonthlyForProject ("wp") ;
  &ReadStatisticsMonthlyForProject ("wq") ;
  &ReadStatisticsMonthlyForProject ("ws") ;
  &ReadStatisticsMonthlyForProject ("wv") ;
  &ReadStatisticsMonthlyForProject ("wx") ;

# &ReadStatisticsPerBinariesExtensionCommons ;
}

sub ReadStatisticsMonthlyForProject
{
  my $project = shift;
  $all_projects = "*" ;

  my $file_csv_in_1 = "$path_in/csv_$project/$file_csv_monthly_data" ;
  my $file_csv_in_2 = "$path_in/csv_$project/$file_csv_user_activity_spread" ;

  if (! -e $file_csv_in_1)
  { &Abort ("Input file '$file_csv_in_1' not found") ; }
  if (! -e $file_csv_in_2)
  { &Abort ("Input file '$file_csv_in_2' not found") ; }

  my $yyyymm ;

  print "Read '$file_csv_in_1'\n" ;
  open CSV_IN, '<', $file_csv_in_1 ;
  while ($line = <CSV_IN>)
  {
    chomp $line ;
    ($language,$date,$counts) = split (',', $line, 3) ;
    @fields = split (',', $counts) ;

    next if ! &AcceptWiki ($project,$language) ;

    ($month,$day,$year) = split ('\/', $date) ;
    $yyyymm = sprintf ("%04d-%02d", $year, $month) ;

    foreach $field (@fields)
    {
      if ($field eq '-')
      { $field = 0 ; }
    }

    $data = $fields  [0] . ',' . # contributors all time
            $fields  [1] . ',' . # new contributors
            'data2,'           . # place holder for more data, to be inserted later
            $fields  [4] . ',' . # articles
            $fields  [6] . ',' . # articles new per day
            $fields  [9] . ',' . # larger than 0.5 kB
            $fields [10] . ',' . # larger than 2.0 kB
            $fields  [7] . ',' . # mean edits per article
            $fields  [8] . ',' . # mean bytes per article
            $fields [11] . ',' . # edits
            $fields [12] . ',' . # size in bytes
            $fields [13] . ',' . # size in words
            $fields [14] . ',' . # links internal
            $fields [15] . ',' . # links interwiki
            $fields [16] . ',' . # links images
            $fields [17] . ',' . # links external
            $fields [18] ;       # redirects

    $data1 {"$project,$language,$yyyymm"} = $data ;
  }
  close CSV_IN ;

  # now read (very) active editors from newer more accurate file (split data for reg users and bots, unlike StatisticsMonthly.csv)

  print "Read '$file_csv_in_2'\n" ;
  open CSV_IN, '<', $file_csv_in_2 ;
  while ($line = <CSV_IN>)
  {
    chomp $line ;
    ($language,$date,$reguser_bot,$group,@counts) = split (',', $line) ;

    next if ! &AcceptWiki ($project,$language) ;

    if ($reguser_bot ne "R") { next ; }  # R: reg user, B: bot
    if ($group       ne "A") { next ; }  # A: articles, T: talk pages, O: other namespaces

    ($month,$day,$year) = split ('\/', $date) ;
    $yyyymm = sprintf ("%04d-%02d", $year, $month) ;
    $months {$yyyymm} ++ ;
#    print "YYYYMM $yyyymm\n" ;

    # data have been collected in WikiCountsProcess.pm and been written in WikiCountsOutput.pm
    # count user with over x edits
    # threshold starting with a 3 are 10xSQRT(10), 100xSQRT(10), 1000xSQRT(10), etc
    # @thresholds = (1,3,5,10,25,32,50,100,250,316,500,1000,2500,3162,5000,10000,25000,31623,50000,100000,250000,316228,500000,1000000,2500000,3162278,500000,10000000,25000000,31622777,5000000,100000000) ;
    $edits_ge_5   = @counts [2] > 0 ? @counts [2] : 0 ;
    $edits_ge_25  = @counts [4] > 0 ? @counts [4] : 0 ;
    $edits_ge_100 = @counts [7] > 0 ? @counts [7] : 0 ;
    $data2 {"$project,$language,$yyyymm"} = "$edits_ge_5,$edits_ge_25,$edits_ge_100" ;

    $total_edits_ge_5   {"$project,$language"} += $edits_ge_5 ;
    $total_edits_ge_25  {"$project,$language"} += $edits_ge_25 ;
    $total_edits_ge_100 {"$project,$language"} += $edits_ge_100 ;

    # prep string with right amount of comma's
    if ($data2_default eq '')
    {
      $data2_default = $data2 {"$project,$language,$yyyymm"} ;
      $data2_default =~ s/[^,]+/0/g ;
    }
  }
  close CSV_IN ;
}

#sub ReadStatisticsPerBinariesExtensionCommons
#{
#  my $file_csv_in = "$path_in/csv_wx/StatisticsPerBinariesExtension.csv" ;
#  my $mmax = -1 ;

#  if (! -e $file_csv_in)
#  { &Abort ("Input file '$file_csv_in' not found") ; }

#  print "Read '$file_csv_in'\n" ;
#  open CSV_IN, '<', $file_csv_in ;
#  while ($line = <CSV_IN>)
#  {
#    chomp $line ;
#    ($language,$date,$counts) = split (',', $line, 3) ;

#    if ($language ne "commons") { next ; }

#    if ($date eq "00/0000")
#    {
#      @fields = split (',', $counts) ;
#      $field_ndx = 0 ;
#      foreach $field (@fields)
#      {
#        $ext_cnt {-1}{$field_ndx} = $field ;
#      # print "EXT_CNT $field_ndx : $field\n" ;
#        $field_ndx ++ ;
#      }
#      next ;
#    }

#    ($month,$year) = split ('\/', $date) ;
#    my $m = &months_since_2000_01 ($year,$month) ;
#    next if $m < $m_start ;

#    if ($m > $mmax)
#    { $mmax = $m ; }

#    @fields = split (',', $counts) ;
#    $field_ndx = 0 ;
#    foreach $field (@fields)
#    {
#      $ext_cnt {$m}{$field_ndx}  = $field ;
#      $ext_tot {$m}             += $field ;
#      $field_ndx ++ ;
#    }
#  }
#  close CSV_IN ;

#  %ext_cnt_mmax = %{$ext_cnt {$mmax}} ;
#  @ext_cnt_mmax = (sort {$ext_cnt_mmax {$b} <=> $ext_cnt_mmax {$a}} keys %ext_cnt_mmax) ;

#  $extcnt = 0 ;
#  foreach $extndx (@ext_cnt_mmax)
#  {
#    # print "$extndx < ${ext_cnt {-1}{$extndx}} > : ${ext_cnt_mmax {$extndx}}\n" ;
#    push @extndxs, $extndx ;
#    if ($extcnt++ >= 9) { last ; }
#  }
#}

sub FindLargestWikis
{
  print "FindLargestWikis\n" ;
  print "Largest projects (most accumulated very active editors):\n";
  @total_edits_ge_100 = sort {$total_edits_ge_100 {$b} <=> $total_edits_ge_100 {$a}} keys %total_edits_ge_100 ;
  $rank = 0 ;
  foreach $project_language (@total_edits_ge_100)
  {
    $largest_projects {$project_language} = $rank++ ;
    print "$project_language," ;
    last if $rank > 10 ;
  }
  print "\n\n" ;

  foreach $yyyymm (sort keys %months)
  {
    next if $yyyymm lt '2011' ;
    foreach $project_language (keys %largest_projects)
    {
      ($project,$language) = split (',', $project_language) ;
          if ($data2 {"$project,$language,$yyyymm"} eq '')
      {
        print "No data yet for large wiki $project_language for $yyyymm-> skip month $yyyymm\n" ;
        $months {$yyyymm} = 0 ;
      }
    }
  }
}

sub WriteMonthlyData
{
  print "WriteMonthlyData\n" ;
  my $file_csv_out = "$path_out/$file_csv_analytics_in" ;
  open CSV_OUT, '>', $file_csv_out ;
  foreach $project_wiki_month (sort keys %data1)
  {
    ($project,$wiki,$yyyymm) = split (',', $project_wiki_month) ;

    # recent month misses on eor more large wikis?
    next if $months {$yyyymm} == 0 ;

    $data1 = $data1 {$project_wiki_month} ;
    $data2 = $data2 {$project_wiki_month} ;
    if ($data2 eq '')
    {
      print "Editor data missing for $project_wiki_month\n" ;
      $data2 = $data2_default ;
    }
    $data1 =~ s/data2/$data2/ ; # insert rather than append to have all editor fields close together
    print CSV_OUT "$project_wiki_month,$data1\n" ;
  }
  $total_edits_ge_5   {"$project,*,$yyyymm"} += $edits_ge_5 ;
  $total_edits_ge_25  {"$project,*,$yyyymm"} += $edits_ge_25 ;
  $total_edits_ge_100 {"$project,*,$yyyymm"} += $edits_ge_100 ;
  close CSV_OUT ;
}

sub AcceptWiki
{
  my ($project,$language) = @_ ;

  return $false if $language eq 'commons' and $project ne 'wx' ; # commons also in wikipedia csv files (bug, hard to cleanup, just skip)
  return $false if $language eq 'sr'      and $project eq 'wn' ; # ignore insane bot spam on
  return $false if $language =~ /mania|team|comcom|closed|chair|langcom|office|searchcom|sep11|nostalgia|stats|test/i ;

  return $false if $language =~ /^(?:dk|tlh|ru_sib)$/ ; # dk=dumps exist(ed?) but site not, tlh=Klignon, ru-sib=Siberian
  return $false if $project eq 'wk' and ($language eq "als" or $language eq "tlh") ;

  return $true ;
}

sub Abort
{
  my $msg = shift ;
  print "$msg\nExecution aborted." ;
  # to do: log also to file
  exit ;
}


