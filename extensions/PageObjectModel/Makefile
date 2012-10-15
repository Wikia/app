# Simple make file to run PHPUnit tests

all:	testcoverage
 
test:
	phpunit --configuration tests/tests.xml

testcoverage:
	phpunit --configuration tests/tests.xml --coverage-html code_coverage

clean:
	rm -rf code_coverage
	rm PageObjectModel*.tgz

tardist:
	tar -c POM.php POM/ --exclude .svn| gzip >PageObjectModel.tgz
