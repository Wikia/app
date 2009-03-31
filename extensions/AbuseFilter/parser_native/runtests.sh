#! /bin/ksh

PATH=/usr/xpg4/bin:$PATH

npass=0
nfail=0
ntotal=0

for test in *.t; do
	printf "%-20s " "$test"
	filter=$(head -1 $test)
	vars=$(tail -n +2 $test)
	expect=$(cat ${test%.t}.r)
	result=$(../maketest "$filter" $vars | (cd ..; ./af_parser))
	if [ "$expect" = "$result" ]; then
		echo ...ok 
		npass=$((npass + 1))
	else
		echo ...FAIL
		nfail=$((nfail + 1))
	fi

	ntotal=$((ntotal + 1))
done

echo "Ran $ntotal tests.  PASS: $npass  FAIL: $nfail"
