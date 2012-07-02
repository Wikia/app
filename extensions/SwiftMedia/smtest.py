#!/usr/bin/python
# http://www.deheus.net/petrik/blog/2005/11/20/creating-a-wikipedia-watchlist-rss-feed-with-python-and-twill/

import sys, string, datetime, time, os, re, stat
import twill
import twill.commands as t
import gd

temp_html = "/tmp/wikipedia.html"
rss_title = "Wikipedia watchlist"
rss_link = "http://en.wikipedia.org"
host = "http://ersch.wikimedia.org/"
#host = "http://127.0.0.1/wiki/"

def login(username, password):
    t.add_extra_header("User-Agent", "python-twill-russnelson@gmail.com")

    t.go(host+"index.php/Special:UserLogin")
    t.fv("1", "wpName", username)
    t.fv("1", "wpPassword", password)
    t.submit("wpLoginAttempt")


def upload_list(browser, pagename, uploads):

    # get the file sizes for later comparison.
    filesizes = []
    for fn in uploads:
        filesizes.append(os.stat(fn)[stat.ST_SIZE])
    filesizes.reverse() # because they get listed newest first.

    # Upload copy #1.
    t.go(host+"index.php/Special:Upload")
    t.formfile("1", "wpUploadFile", uploads[0])
    t.fv("1", "wpDestFile", pagename)
    t.fv("1", "wpUploadDescription", "Uploading %s" % pagename)
    t.submit("wpUpload")

    # Verify that we succeeded.
    t.find("File:%s" % pagename)

    for fn in uploads[1:]:
        # propose that we upload a replacement
        t.go(host+"index.php?title=Special:Upload&wpDestFile=%s&wpForReUpload=1" % pagename)
        t.formfile("1", "wpUploadFile", fn)
        t.fv("1", "wpUploadDescription", "Uploading %s as %s" % (fn, pagename))
        t.submit("wpUpload")

    # get the URLs for the thumbnails
    urls = []
    for url in re.finditer(r'<td><a href="([^"]*?)"><img alt="Thumbnail for version .*?" src="(.*?)"', browser.get_html()):
        urls.append(url.group(1))
        urls.append(url.group(2))

    print filesizes
    for i, url in enumerate(urls):
        t.go(url)
        if i % 2 == 0 and len(browser.get_html()) != filesizes[i / 2]:
            print i,len(browser.get_html()), filesizes[i / 2]
            t.find("Files differ in size")
        t.code("200")
        t.back()

    # delete all versions
    t.go(host+"index.php?title=File:%s&action=delete" % pagename)
    # after we get the confirmation page, commit to the action.
    t.fv("1", "wpReason", "Test Deleting...")
    t.submit("mw-filedelete-submit")

    # make sure that we can't visit their URLs.
    for i, url in enumerate(urls):
        t.go(url)
        if 0 and i % 2 == 1 and i > 0 and browser.get_code() == 200:
            # bug 30192: the archived file's thumbnail doesn't get deleted.
            print "special-casing the last URL"
            continue
        t.code("404")

    # restore the current and archived version.
    t.go(host+"index.php/Special:Undelete/File:%s" % pagename)
    t.fv("1", "wpComment", "Test Restore")
    t.submit("restore")

    # visit the page to make sure that the thumbs get re-rendered properly.
    # when we get the 404 handler working correctly, this won't be needed.
    t.go(host+"index.php?title=File:%s" % pagename)

    # make sure that they got restored correctly.
    for i, url in enumerate(urls):
        t.go(url)
        if i % 2 == 0 and len(browser.get_html()) != filesizes[i / 2]:
            t.find("Files differ in size")
        t.code("200")
        t.back()

    if len(uploads) != 2:
        return

    match = re.search(r'"([^"]+?)" title="[^"]+?">revert', browser.get_html())
    if not match:
        t.find('revert')
    t.go(match.group(1).replace('&amp;', '&'))

def make_files(pagename):
    redfilename = "/tmp/Red-%s" % pagename
    greenfilename = "/tmp/Green-%s" % pagename
    bluefilename = "/tmp/Blue-%s" % pagename

    # create a small test image.
    gd.gdMaxColors = 256
    i = gd.image((200,100))
    black = i.colorAllocate((0,0,0))
    white = i.colorAllocate((255,255,255))
    red = i.colorAllocate((255,55,55))
    green = i.colorAllocate((55,255,55))
    blue = i.colorAllocate((55,55,255))

    # now write a red version
    i.rectangle((0,0),(199,99),red, red)
    i.line((0,0),(199,99),black)
    i.string(gd.gdFontLarge, (5,50), pagename, white)
    i.writePng(redfilename)

    # now write a green version
    i.rectangle((0,0),(199,99),green, green)
    i.line((0,0),(99,99),black)
    i.string(gd.gdFontLarge, (5,50), pagename, white)
    i.writePng(greenfilename)

    # write a blue version
    i.rectangle((0,0),(199,99),blue,blue)
    i.line((0,0),(99,199),black)
    i.string(gd.gdFontLarge, (5,50), pagename, white)
    i.writePng(bluefilename)

    # propose that we delete it (in case it exists)
    t.go(host+"index.php?title=File:%s&action=delete" % pagename)
    # make sure that we've NOT gotten the wrong page and HAVE gotten the right one.
    t.notfind('You are about to delete the file')
    t.find("could not be deleted")

    return (redfilename, greenfilename, bluefilename )

def main():
    try:
        username = sys.argv[1]
        password = sys.argv[2]
    except IndexError:
        print "Please supply username password"
        sys.exit(1)
    browser = twill.get_browser()
    login(username, password)

    serial = time.time()
    pagename = "Test-%s.png" % serial
    filenames = make_files(pagename)
    upload_list(browser, pagename, filenames[0:2])

    # try it again with two replacement files.
#    pagename = "Test-%sA.png" % serial
#    filenames = make_files(pagename)
#    upload_list(browser, pagename, filenames)

    t.showforms()
    t.save_html("/tmp/testabcd")

if __name__ == "__main__":
    main()

