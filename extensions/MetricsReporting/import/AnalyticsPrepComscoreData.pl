#!/usr/bin/perl

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

# Functionality:
# comScore data can be downloaded as csv file, which each contain 14 months history
# This script uses these files to update 'master' csv files which contain all known history
# Note: only entities which are already in master file will be updated!
# Then it merges these master files into one csv file which can be loaded into analytics database
# Data are: reach by region, unique visitors by region, unique visitors by web property

# Parameters:
# -m (required) folder with 'master' csv files (files with all known history)
# -u (required) folder with 'update' csv files (files with lastest 14 months history, produced by comScore)

# Output:
# updated master csv files + merged and formatted csv for import in MySQL

# http://svn.wikimedia.org/viewvc/mediawiki/trunk/wikistats/analytics/

  use Getopt::Std ;
  use Cwd;

  my $options ;
  getopt ("imo", \%options) ;

  $true  = 1 ;
  $false = 0 ;

  $script_name    = "AnalyticsPrepComscoreData.pl" ;
  $script_version = "0.31" ;

# EZ test only
# $source       = "comscore" ;
# $server       = "ez_test" ;
# $generated    = "2011-05-06 00:00:00" ;
# $user         = "ezachte" ;

  $dir_in   = $options {"i"} ;
  $dir_upd  = $options {"m"} ;
  $dir_out  = $options {"o"} ;
  $mode = 'add';
  if (defined $options {'r'})
  { $mode = 'replace'; }

  print "Mode is $mode (specify '-r' for replace)\n\n";

  if (! -d "/home/") # EZ test machine
  {
    $dir_in  = "C:/@ Wikimedia/@ Report Card/Data" ;
    $dir_upd = "C:/MySQL/analytics" ;
    $dir_out = "C:/MySQL/analytics" ;
    $mode = 'replace' ;
  }

  if ($dir_in eq '')
  { Abort ("Specify folder for input file (new comScore data) '-i folder'") ; }
  if ($dir_upd eq '')
  { Abort ("Specify folder for master files (full history) as '-m folder'") ; }
  if ($dir_out eq '')
  { Abort ("Specify folder for output file '-o folder'") ; }

  $file_comscore_reach_master     = "history_comscore_reach_regions.csv" ;
  $file_comscore_reach_update     = "*reach*by*region*csv" ;
  $file_comscore_uv_region_master = "history_comscore_UV_regions.csv" ;
  $file_comscore_uv_region_update = "*UVs*by*region*csv" ;
  $file_comscore_uv_property_master = "history_comscore_UV_properties.csv" ;
  $file_comscore_uv_property_update = "*UV*trend*csv" ;

  $layout_csv_reach      = 1 ;
  $layout_csv_regions    = 2 ;
  $layout_csv_properties = 3 ;

  print "Directories:\n" .
        "Input (new comScore data): '$dir_in'\n".
        "Master files (full history): '$dir_upd'\n" .
        "Output (database feed): '$dir_out'\n\n" ;

  %region_codes = (
    "Europe"=>"EU",
    "North America"=>"NA",
    "Latin America"=>"LA",
    "World-Wide" => "W",
    "Middle East - Africa" => "MA",
    "Asia Pacific"=> "AS",
    "United States" => "US",
    "India" => "I",
    "China" => "C"
  ) ;

  foreach $region_name (keys %region_codes)
  { $region_names {$region_codes {$region_name}} = $region_name ; }

  @months_short = qw "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec" ;

  &ReadMasterComscoreDataReachPerRegion ($file_comscore_reach_master, $file_comscore_reach_update, "%.1f", 1, $layout_csv_reach) ;
  %reach_region_code = %data ;

  &ReadMasterComscoreDataVisitorsPerRegion ($file_comscore_uv_region_master, $file_comscore_uv_region_update, "%.0f", 1000, $layout_csv_regions) ;
  %visitors_region_code = %data ;

  &ReadMasterComscoreDataVisitorsPerProperty ($file_comscore_uv_property_master, $file_comscore_uv_property_update, "%.0f", 1000, $layout_csv_properties) ;
  %visitors_web_property = %data ;

  &WriteDataAnalytics ;

  print "\nReady\n\n" ;
  exit ;

sub ReadMasterComscoreDataReachPerRegion
{
  my ($file_comscore_master, $file_comscore_updates, $precision, $layout_csv) = @_ ;

  print "ReadMasterComscoreDataReachPerRegion\n\n" ;

  undef %months ;
  undef %data ;
  undef @regions ;

  open IN,  '<', "$dir_upd/$file_comscore_master" ;

  $lines = 0 ;
  while ($line = <IN>)
  {
    chomp $line ;
    $line =~ s/\r//g ;

    ($yyyymm,@data) = split (',', $line) ;

    if ($lines++ == 0)
    {
      @regions = @data ;
      print "Regions found: " . (join ',', @regions) . "\n";
      next ;
    }

    $field_ndx = 0 ;
    foreach (@data)
    {
      $region      = $regions [$field_ndx] ;
      $region_code = $region_codes {$region} ;

      $data      = $data [$field_ndx] ;
      if ($data eq '')
      { $data = '0' ; }
      $months {$yyyymm} ++ ;
      $data {"$yyyymm,$region_code"} = $data ;
      # print "Old data $yyyymm,$region_code = $data\n" ;
      $field_ndx++ ;
    }
  }
  close IN ;

  my $updates_found = &UpdateMasterFileFromRecentComscoreData ($file_comscore_master, $file_comscore_updates, 1, $layout_csv, @regions) ;
  return if ! $updates_found ;

  rename "$dir_upd/$file_comscore_master", "$dir_upd/$file_comscore_master.~" ;
  open OUT,  '>', "$dir_upd/$file_comscore_master" ;

  $line_out = "yyyymm" ;
  foreach $region_name (@regions)
  { $line_out .= ",$region_name" ; }
  print OUT "$line_out" ;

  foreach $yyyymm (sort {$b cmp $a} keys %months)
  {
    $line_out = "\n$yyyymm" ;
    foreach $region_name (@regions)
    {
      $yyyymm_region_code = $yyyymm . ',' . $region_codes {$region_name} ;
      $line_out .= "," . sprintf ($precision, $data {$yyyymm_region_code}) ;
    }
    print OUT "$line_out" ;
  }

  close OUT ;
}

sub ReadMasterComscoreDataVisitorsPerRegion
{
  my ($file_comscore_master, $file_comscore_updates, $precision, $multiplier, $layout_csv) = @_ ;

  print "ReadMasterComscoreDataVisitorsPerRegion\n\n";

  undef %months ;
  undef %data ;
  undef @regions ;

  open IN,  '<', "$dir_upd/$file_comscore_master" ;

  $lines  = 0 ;
  $metric = 'unique_visitors' ;
  while ($line = <IN>)
  {
    chomp $line ;
    $line =~ s/\r//g ;
    $line = &GetNumberOnly ($line) ;

    next if $line !~ /(?:yyyymm|\d\d\d\d-\d\d)/ ;

    ($yyyymm,@data) = split (',', $line) ;

    if ($lines++ == 0)
    {
      @regions = @data ;
      print "Regions found: " . (join ',', @regions) . "\n";
      next ;
    }

    $field_ndx = 0 ;
    foreach (@data)
    {
      $region      = $regions [$field_ndx] ;
      $region_code = $region_codes {$region} ;

      $data      = $data    [$field_ndx] ;
      if ($data eq '')
      { $data = '0' ; }

      # print "Old data $yyyymm,$region = $data\n" ;

      $months {$yyyymm} ++ ;
      $data {"$yyyymm,$region_code"} = $data ;

      $field_ndx++ ;
    }
  }
  close IN ;

  my $updates_found = &UpdateMasterFileFromRecentComscoreData ($file_comscore_master, $file_comscore_updates, 1000, $layout_csv, @regions) ;
  return if ! $updates_found ;

  rename "$dir_upd/$file_comscore_master", "$dir_upd/$file_comscore_master.~" ;
  open OUT,  '>', "$dir_upd/$file_comscore_master" ;

  $line_out = "yyyymm" ;
  foreach $region_name (@regions)
  { $line_out .= ",$region_name" ; }
  print OUT "$line_out" ;

  foreach $yyyymm (sort {$b cmp $a} keys %months)
  {
    $line_out = "\n$yyyymm" ;
    foreach $region_name (@regions)
    {
      $yyyymm_region_code = $yyyymm . ',' . $region_codes {$region_name} ;
      $line_out .= "," . sprintf ($precision, $data {$yyyymm_region_code}) ;
    }
    print OUT "$line_out" ;
  }

  close OUT ;
}

sub ReadMasterComscoreDataVisitorsPerProperty
{
  my ($file_comscore_master, $file_comscore_updates, $precision, $multiplier, $layout_csv) = @_ ;

  print "ReadMasterComscoreDataVisitorsPerProperty\n\n";

  undef %months ;
  undef %data ;
  undef @properties ;

  open IN,  '<', "$dir_upd/$file_comscore_master" ;

  $lines = 0 ;
  $metric       = 'unique_visitors' ;
  while ($line = <IN>)
  {
    chomp $line ;
    $line =~ s/\r//g ;

    ($yyyymm,@data) = split (',', $line) ;
    if ($lines++ == 0)
    { @properties = @data ; next ; }

    $field_ndx = 0 ;
    foreach (@data)
    {
      $property = $properties [$field_ndx] ;
      $property =~ s/.*Yahoo.*/Yahoo/ ;
      $data      = $data    [$field_ndx] ;
      if ($data eq '')
      { $data = '0' ; }

      # print "Old data $yyyymm,$property = $data\n" ;

      $months {$yyyymm} ++ ;
      $data {"$yyyymm,$property"} = $data ;

      $field_ndx++ ;
    }
  }
  close IN ;

  my $updates_found = &UpdateMasterFileFromRecentComscoreData ($file_comscore_master, $file_comscore_updates, 1000, $layout_csv, @properties) ;
  return if ! $updates_found ;

  rename "$dir_upd/$file_comscore_master", "$dir_upd/$file_comscore_master.~" ;
  open OUT,  '>', "$dir_upd/$file_comscore_master" ;

  $line_out = "yyyymm" ;
  foreach $property (@properties)
  { $line_out .= ",$property" ; }
  print OUT "$line_out" ;

  foreach $yyyymm (sort {$b cmp $a} keys %months)
  {
    $line_out = "\n$yyyymm" ;
    foreach $property (@properties)
    {
      $yyyymm_property = "$yyyymm,$property" ;
      $line_out .= "," . sprintf ($precision, $data {$yyyymm_property}) ;
    }
    print OUT "$line_out" ;
  }

  close OUT ;
}

sub UpdateMasterFileFromRecentComscoreData
{
  my ($file_comscore_master, $file_comscore_updates, $multiplier, $layout_csv, @white_list) = @_ ;

  print "UpdateMasterFileFromRecentComscoreData\n\n";

  undef %white_list ;
  undef %not_white_listed ;

  print "White list: ". (join (',', @white_list)) . "\n\n";

  foreach $id (@white_list)
  { $white_list {$id} = $true ; }

  if (! -e "$dir_upd/$file_comscore_master")
  { Abort ("File $file_comscore_master not found!") ; }

  $age_all = -M "$dir_upd/$file_comscore_master" ;
  print "Latest comscore master file is " . sprintf ("%.0f", $age_all) . " days old: '$file_comscore_master'\n" ;

  my $cwd = getcwd ;
  chdir $dir_in ;

  @files = glob($file_comscore_updates) ;
  $min_age_upd = 999999 ;
  $file_comscore_updates_latest = '' ;
  foreach $file (@files)
  {
    $age = -M $file ;
    if ($age < $min_age_upd)
    {
      $min_age_upd = $age ;
      $file_comscore_updates_latest = $file ;
    }
  }
  print "Latest comscore update file is " . sprintf ("%.0f", $min_age_upd) . " days old: '$file_comscore_updates_latest'\n" ;

  if ($min_age_upd == 999999)
  {
    print "No valid update file found. Nothing to update." ;
    return ;
  }

  #if ($age_all > $min_age_upd)
  #{
  #  print "File with master data more recent than latest update csv from comScore. Nothing to update." ;
  #  return ;
  #}

  my $updates_found = $false ;

  open CSV, '<', $file_comscore_updates_latest ;
  binmode CSV ;
  while ($line = <CSV>)
  {
    chomp $line ;
    $line =~ s/\r//g ;
    $line = &GetNumberOnly ($line) ;

    if ($line =~ /Jan-\d\d\d\d.*?Feb-\d\d\d\d/) # e.g. 'Location,Location,Jan-2010,Feb-2010,Mar-2010,Apr-2010,...'
    {
      if ($layout_csv == $layout_csv_properties)
      { ($dummy1,$dummy2,$dummy3,@months) = split (',', $line) ; } # web properties csv file
      else
      { ($dummy1,$dummy2,@months) = split (',', $line) ; }         # uv / reach csv files

      @months = &mmm_yyyy2yyyy_mm (@months) ;
    }

    if (($line =~ /^\d+,/) || ($line =~ /,,.*?Total Internet/))
    {
      if ($layout_csv == $layout_csv_properties)
      {
        ($index,$dummy,$property,@data) = split (',', $line) ;
        $property =~ s/^\s+// ;
        $property =~ s/\s+$// ;

        $property =~ s/.*Total Internet.*/Total Internet/i ;
        $property =~ s/.*Google.*/Google/i ;
        $property =~ s/.*Microsoft.*/Microsoft/i ;
        $property =~ s/.*FACEBOOK.*/Facebook/i ;
        $property =~ s/.*Yahoo.*/Yahoo/i ;
        $property =~ s/.*Amazon.*/Amazon/i ;
        $property =~ s/.*Apple.*/Apple/i ;
        $property =~ s/.*AOL.*/AOL/i ;
        $property =~ s/.*Wikimedia.*/Wikimedia/i ;
        $property =~ s/.*Tencent.*/Tencent/i ;
        $property =~ s/.*Baidu.*/Baidu/i ;
        $property =~ s/.*CBS.*/CBS/i ;

        if (! $white_list {$property})
        {
          $not_white_listed {$property}++ ;
          next ;
        }

        $id = $property ;
      }
      else
      {
        ($index,$region,@data) = split (',', $line) ;
        $region =~ s/^\s+// ;
        $region =~ s/\s+$// ;

        if (! $white_list {$region})
        {
          $not_white_listed {$region}++ ;
          next ;
        }

        $id = $region_codes {$region} ;
      }

      for ($m = 0 ; $m <= $#months ; $m++)
      {
        $yyyymm = $months [$m] ;
        $months {$yyyymm} ++ ;
        $yyyymm_id = "$yyyymm,$id" ;
        $data = $data [$m] * $multiplier ;

        if ($mode eq 'add')
        {
          if (! defined $data {$yyyymm_id})
          {
            $updates_found = $true ;
            print "New data found: $yyyymm_id = $data\n" ;
            $data {$yyyymm_id} = $data ;
          }
        }
        else
        {
          $updates_found = $true ;
          print "Data found: $yyyymm_id = $data\n" ;
          $data {$yyyymm_id} = $data ;
        }
      }
    }
  }

  $entities_not_white_listed = join (', ', sort keys %not_white_listed) ;
  if ($entities_not_white_listed ne '')
  { print "\nEntities ignored:\n$entities_not_white_listed\n\n" ; }

  if (! $updates_found)
  { print "No new updates found\n" ; }
  else
  { print "\nUpdates found, rewrite master file '$file_comscore_master'\n\n" ; }

  return ($updates_found) ;
}

sub WriteDataAnalytics
{
  print "WriteDataAnalytics\n\n";

  open OUT, '>', "$dir_out/analytics_in_comscore.csv" ;

  $metric = 'unique_visitors' ;
  foreach $yyyymm (sort keys %months)
  {
    # store meta data elsewhere
    # $line = "$generated,$source,$server,$script_name,$script_version,$user,$yyyymm,$country_code,$region_code,$property,$project,$normalized,$metric,$data\n" ;
    foreach $region_code (sort values %region_codes)
    {
      $country_code = '-' ;
      $property     = '-' ;
      $project      = '-' ;
      $reach        = $reach_region_code     {"$yyyymm,$region_code"} ;
      $visitors     = $visitors_region_code  {"$yyyymm,$region_code"} ;

      if (! defined $reach)    { $reach    = -1 ; }
      if (! defined $visitors) { $visitors = -1 ; }

      next if $reach == -1 and $visitors == -1 ;

      $line = "$yyyymm,$country_code,$region_code,$property,$project,$reach,$visitors\n" ;
      print OUT $line ;
      print     $line ;
    }

    foreach $property (sort @properties)
    {
      $country_code = '-' ;
      $region_code  = '-' ;
      $project      = '-' ;
      $reach        = '-1' ;
      $visitors     = $visitors_web_property {"$yyyymm,$property"} ;

      next if ! defined $visitors ;

      $line = "$yyyymm,$country_code,$region_code,$property,$project,$reach,$visitors\n" ;
      print OUT $line ;
      # print     $line ;
    }
  }
}

sub GetNumberOnly
{
  my $line = shift ;
  $line =~ s/("[^\"]+")/($a=$1,$a=~s#,##g,$a)/ge ; # nested regexp: remove comma's inside double quotes
  $line =~ s/"//g ;
  return $line ;
}

sub mmm_yyyy2yyyy_mm
{
  my @months = @_ ;
  my ($m) ;
  # Jan -> 01, etc
  foreach $month (@months)
  {
    my ($mmm,$yyyy) = split ('-', $month) ;
    for ($m = 0 ; $m <= $#months_short ; $m++)
    {
      if ($mmm eq $months_short [$m])
      {
        $month = "$yyyy-" . sprintf ("%02d", $m+1) ;
        last ;
      }
    }
  }
  return @months ;
}

sub Abort
{
  $msg = shift ;

  print  "\nAbort, reason: $msg\n\n" ;
  exit ;
}
