import re

# The regex to test (for rewrite.py)
regex = r'^/(?P<proj>[^/]+)/(?P<lang>[^/]+)/((?P<zone>thumb|temp)/)?(?P<path>((temp|archive)/)?[0-9a-f]/(?P<shard>[0-9a-f]{2})/.+)$'

# [url,proj,lang,zone,shard,path]
cases = []
cases.append( ['/wikipedia/commons/a/ab/file.jpg',
 'wikipedia', 'commons', None, 'ab', 'a/ab/file.jpg'] )
cases.append( ['/wikipedia/commons/archive/a/ab/file.jpg',
 'wikipedia', 'commons', None, 'ab', 'archive/a/ab/file.jpg'] )
cases.append( ['/wikipedia/commons/thumb/a/ab/file.jpg',
 'wikipedia', 'commons', 'thumb', 'ab', 'a/ab/file.jpg'] )
cases.append( ['/wikipedia/commons/thumb/archive/a/ab/file.jpg',
 'wikipedia', 'commons', 'thumb', 'ab', 'archive/a/ab/file.jpg'] )
cases.append( ['/wikipedia/commons/thumb/temp/a/ab/file.jpg',
 'wikipedia', 'commons', 'thumb', 'ab', 'temp/a/ab/file.jpg'] )
cases.append( ['/wikipedia/commons/temp/a/ab/file.jpg',
 'wikipedia', 'commons', 'temp', 'ab', 'a/ab/file.jpg'] )

# Tests for valid URLs
print "Testing valid URLs..."
for case in cases:
    url = case[0]
    proj = case[1]
    lang = case[2]
    zone = case[3]
    shard = case[4]
    path = case[5]

    match = re.match(regex, url)
    if match:
        if match.group('proj') != proj:
            print "FAILED for url %s; expected %s but got %s" % (url,proj,match.group('proj'))
        elif match.group('lang') != lang:
            print "FAILED for url %s; expected %s but got %s" % (url,lang,match.group('lang'))
        elif match.group('zone') != zone:
            print "FAILED for url %s; expected %s but got %s" % (url,zone,match.group('zone'))
        elif match.group('shard') != shard:
            print "FAILED for url %s; expected %s but got %s" % (url,shard,match.group('shard'))
        elif match.group('path') != path:
            print "FAILED for url %s; expected %s but got %s" % (url,path,match.group('path'))
        else:
            print "PASSED for url %s" % url
    else:
        print "FAILED; no match for url %s" % url

# Tests for invalid URLs
print "\nTesting invalid URLs..."
cases = []
cases.append( '/wikipedia/commons/deleted/a/ab/file.jpg' ); # private
cases.append( '/wikipedia/commons/thumb' ); # no file
cases.append( '/wikipedia/commons/thumb/a/' ); # no file
cases.append( '/wikipedia/commons/thumb/a/ab/' ); # no file

for url in cases:
    if re.match(regex, url):
        print "FAILED; should not match url %s" % url
    else:
        print "PASSED for url %s" % url