#!/usr/bin/perl
# Can we get a list of matches?
#

$alist="bla bat cat hat mat ra gosh mosh tosh socks rocks docks batty";

@rhymes_with_bat = ($alist=~/\b(\w*at)\b/g);
@rhymes_with_rocks = ($alist=~/\b(\w*ocks)\b/g);
print join(", ",@rhymes_with_bat).".\n";
print join(", ",@rhymes_with_rocks).".\n";
print $alist."\n";

