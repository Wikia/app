/*
 * This software is in the public domain.
 *
 * $Id: counts.d 581 2008-07-29 13:20:14Z emil $
 */

#pragma D option quiet

self int tottime;
BEGIN {
	tottime = timestamp;
}

php$target:::function-entry
	@counts[copyinstr(arg0)] = count();
}

END {
	printf("Total time: %dus\n", (timestamp - tottime) / 1000);
	printf("# calls by function:\n");
	printa("%-40s %@d\n", @counts);
}

