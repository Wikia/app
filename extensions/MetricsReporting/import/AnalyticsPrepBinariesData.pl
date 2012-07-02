#!/usr/local/bin/perl

  use Getopt::Std ;

  &ParseArguments ;

  print "Write file '$file_csv_out'\n" ;
  open CSV_OUT, '>', $file_csv_out ;

  foreach $project (qw (wb wk wn wp wq ws wv wx))
  { &ReadStatisticsPerBinariesExtension ($project) ; }

  close CSV_OUT  ;

  print "\n\nReady\n\n" ;
  exit ;

sub ParseArguments
{
  my @options ;
  getopt ("io", \%options) ;

  die ("Specify input folder as: -i path")   if (! defined ($options {"i"})) ;
  die ("Specify output folder as: -o path'") if (! defined ($options {"o"})) ;

  $path_in  = $options {"i"} ;
  $path_out = $options {"o"} ;

  die "Input folder '$path_in' does not exist"   if (! -d $path_in) ;
  die "Output folder '$path_out' does not exist" if (! -d $path_out) ;

  # tests only
  # $path_in  = "C:/@ Wikimedia/# Out Bayes" ;
  # $path_out = "C:/analytics" ; # "w:/@ report card/data" ;

  print "Input  folder: $path_in\n" ;
  print "Output folder: $path_out\n" ;
  print "\n" ;

  $file_csv_out = "$path_out/analytics_in_binaries.csv" ;
}


sub ReadStatisticsPerBinariesExtension
{
  my $project = shift ;
  my $file_csv_in = "$path_in/csv_$project/StatisticsPerBinariesExtension.csv" ;
  $yyyymm_hi = -1 ;

  if (! -e $file_csv_in)
  { die "Input file '$file_csv_in' not found" ; }


  print "Read '$file_csv_in'\n" ;
  open CSV_IN, '<', $file_csv_in ;

  $language_prev = '' ;
  while ($line = <CSV_IN>)
  {
    chomp $line ;
    next if $line !~ /,.*?,/ ;

    ($language,$date,$data) = split (',', $line, 3) ;

    # for each wiki first line shows ext names, no tcounts
    if ($date eq "00/0000")
    {
      if ($language_prev ne '')
      { &WriteMonthlyData ($project, $language_prev) ; }
      $language_prev = $language ;

      undef %ext_name ;
      undef %ext_ndx ;
      undef %ext_cnt ;
      undef %months ;

      @exts = split (',', $data) ;
      $ndx = 0 ;
      foreach $ext (@exts)
      {
        $ext_name {$ndx} = $ext ;
        $ext_ndx  {$ext} = $ndx ;
        $ndx ++ ;
      }
      next ;
    }

    ($month,$year) = split ('\/', $date) ;
    $yyyymm = sprintf ("%04d-%02d", $year, $month) ;
    if ($yyyymm gt $yyyymm_hi)
    { $yyyymm_hi = $yyyymm ; }
    $months {$yyyymm}++ ;

    @counts = split (',', $data) ;
    $ndx = 0 ;
    foreach $count (@counts)
    {
      $ext_cnt {$yyyymm}{$ext_name {$ndx}}  = $count ;
      $ndx ++ ;
    }
  }
  &WriteMonthlyData ($project, $language_prev) ;

  close CSV_IN ;
}

sub WriteMonthlyData
{
  my ($project,$language) = @_ ;
  # get sorted array of extensions, order by count for most recent month
  %ext_cnt_yyyymm_hi = %{$ext_cnt {$yyyymm_hi}} ;
  @ext_cnt_yyyymm_hi = (sort {$ext_cnt_yyyymm_hi {$b} <=> $ext_cnt_yyyymm_hi {$a}} keys %ext_cnt_yyyymm_hi) ;

  foreach $month (sort keys %months)
  {
    $ndx = 0 ;
    foreach $ext (@ext_cnt_yyyymm_hi)
    {
      print CSV_OUT "$project,$language,$month,$ext,${ext_cnt{$yyyymm}{$ext_name {$ndx}}}\n" ;
    # print         "$month,$ext,${ext_cnt{$yyyymm}{$ext_name {$ndx}}}\n" ;
      last if (++ $ndx > 25) ;
    }
  }
}
