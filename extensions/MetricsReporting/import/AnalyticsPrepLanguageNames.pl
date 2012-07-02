#!/usr/bin/perl

# This module prepares a csv file with language names for feed into the analytics database
# The main work of collecting these names from different sources is done by
# http://svn.wikimedia.org/viewvc/mediawiki/trunk/wikistats/dumps/WikiReportsLocalizations.pm
# which is part of wikistats reporting phase and once each month updates local master csv files from all sources

# The following code to merge and filter these master csv files is based on parts of the code in WikiReportsLocalizations.pm, function Localization
# To do some day: make a completely independent script out of this code and code from WikiReportsLocalizations.pm which covers the whole production cycle

# Sources for language names:
# - php files
# - translatewiki
# - English Wikipedia API (interwikilinks)

# Right now multilingual support for the analytics database is just a nice idea, so to speed up data feeds, just keep English and German translations

  use Getopt::Std ;

  $true  = 1 ;
  $false = 0 ;

  $max_language_name = 50 ; # truncate if longer

  $file_csv_language_names_php   = "LanguageNamesViaPhp.csv" ;
  $file_csv_language_names_wp    = "LanguageNamesViaWpEnEdited.csv" ;
  $file_csv_analytics_in         = "analytics_in_language_names.csv" ;

  $languages_force_case_uc = "ast|br|de|en|id|nl|wa" ; # incomplete list, based on languages supported by wikistats reporting
  $languages_filter        = "de|en" ;
  foreach $language (split '\|', $languages_filter)
  {  $include_target_language {$language} = $true ; }

  &ParseArguments ;
  &ReadCsvFiles ;
  &WriteCsvFile ;


#  if ($language eq "id") # swap which file takes precedence

  print "\nReady\n\n" ;
  exit ;

sub ParseArguments
{
  my (@options, $arguments) ;

  getopt ("io", \%options) ;

  foreach $arg (sort keys %options)
  { $arguments .= " -$arg " . $options {$arg} . "\n" ; }
  print ("\nArguments\n$arguments\n") ;

  $options {"i"} = "w:/# out bayes/csv_wp" ; # EZ test
  $options {"o"} = "c:/MySQL/analytics" ;    # EZ test

  die ("Specify input folder for projectcounts files as: -i path") if (! defined ($options {"i"})) ;
  die ("Specify output folder as: -o path'")                       if (! defined ($options {"o"})) ;

  ($path_in  = $options {"i"}) =~ s/[\/\\]+$// ; # remove trailing (back)slash if any
  ($path_out = $options {"o"}) =~ s/[\/\\]+$// ; # remove trailing (back)slash if any

  die "Input folder '$path_in' does not exist"   if (! -d $path_in) ;
  die "Output folder '$path_out' does not exist" if (! -d $path_out) ;

  print "Input  folder: $path_in\n" ;
  print "Output folder: $path_out\n\n" ;

  $file_csv_language_names_php = "$path_in/$file_csv_language_names_php" ;
  $file_csv_language_names_wp  = "$path_in/$file_csv_language_names_wp" ;
  $file_csv_analytics_in       = "$path_out/$file_csv_analytics_in" ;

  die "Input file '$file_csv_language_names_php' not found"   if (! -e $file_csv_language_names_php) ;
  die "Input file '$file_csv_language_names_wp' not found"    if (! -e $file_csv_language_names_wp) ;
}

sub ReadCsvFiles
{
  #first read definitions from php message files, then overwrite with definitions from interwiki links when available
  # except for target language 'id' (Indonesian) where quality of php file has been deemed more reliable

  open CSV_IN, "<", $file_csv_language_names_php ;
  while ($line = <CSV_IN>)
  {
    chomp ($line) ;
    ($target_language, $code, $name_unicode, $name_html) = split (',', $line) ;

    next if ! $include_target_language {$target_language} ;

    $out_languages {$target_language} {$code} = &FormatName ($target_language, $name_unicode) ; # forget about html for analytics database
  }
  close CSV_IN ;

  open CSV_IN, "<", $file_csv_language_names_wp ;
  while ($line = <CSV_IN>)
  {
    chomp ($line) ;
    ($target_language, $code, $name_unicode, $name_html) = split (',', $line) ;

    next if ! $include_target_language {$target_language} ;

    next if $target_language eq 'id' and $out_languages {$target_language} {$code} ne '' ;

  # $name_unicode_php = $out_languages {$target_language} {$code} ;           # test only
  # $name_unicode_wp  = &FormatName ($target_language, $name_unicode) ;       # test only
  # if (($name_unicode_php ne '') && ($name_unicode_php ne $name_unicode_wp)) # test only
  # { print "$name_unicode_php => $name_unicode_wp\n" ; }                     # test only

    $out_languages {$target_language} {$code} = &FormatName ($target_language, $name_unicode) ; # forget about html for analytics database
  }
  close CSV_IN ;
}

sub FormatName
{
  my ($target_language, $name_unicode) = @_ ;

  $name_unicode2 = $name_unicode ;

  if ($target_language eq "de")
  { $name_unicode =~ s/e?\s*\-?sprache//i ; }

  if ($target_language =~ /^(?:$languages_force_case_uc)/)
  { $name_unicode = ucfirst $name_unicode ; }
  else
  { $name_unicode = lc $name_unicode ; }

# Test only
# if (($target_language eq 'de') && ($name_unicode ne $name_unicode2))
# { print "$name_unicode2 => $name_unicode\n" ; }

  return ($name_unicode) ;
}

sub WriteCsvFile
{
  open CSV_OUT, ">", $file_csv_analytics_in || die ("File '$file_csv_analytics_in' could not be opened") ;
  binmode CSV_OUT ; # force Unix style linebreak \012 

  foreach $target_language (sort keys %out_languages)
  {
    print "\nTarget language '$target_language'\n" ;
    %translations = %{$out_languages {$target_language}} ;

    foreach $code (sort keys %translations)
    {
      $language_name  = $translations{$code} ;
      $language_name2 = substr ($language_name,0,$max_language_name) ;

      if ($language_name ne $language_name2)
      { print "Language name truncated to $max_language_name chars: '$language_name' -> '$language_name2'\n" ; }

      if ($language_name2 =~ /,/)
      { $language_name2 = "\"$language_name2\"" ; }
      # test only
      print CSV_OUT "$target_language,$code,$language_name2\n" ;
    }
  }

  close CSV_OUT ;
}

