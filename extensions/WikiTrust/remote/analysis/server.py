"""
Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Ian Pye

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice,
this list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution.

3. The names of the contributors may not be used to endorse or promote
products derived from this software without specific prior written
permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.

"""

# Works with RemoteTrust for connecting to a remote wiki.

import MySQLdb
import getopt
import ConfigParser                                                         
import zlib
import gzip
import cStringIO
import time

from mod_python import util
from mod_python import apache

BASE_DIR = "/home/ipye/git/wikitrust/test-scripts/" 
INI_FILE = BASE_DIR + "db_access_data.ini"   
FILE_ENDING_SEP = " "
DB_PREFIX = ""
not_found_text_token = "TEXT_NOT_FOUND"
sleep_time_sec = 3 

connection = None
curs = None

# Compress a string
def compressBuf(buf):
   zbuf = cStringIO.StringIO()
   zfile = gzip.GzipFile(mode = 'wb',  fileobj = zbuf, compresslevel = 6)
   zfile.write(buf)
   zfile.close()
   return zbuf.getvalue()

# Start a persisent connection to the db
def connect_db():
  global connection
  global curs
  global DB_PREFIX

  ## parse the ini file
  ini_config = ConfigParser.ConfigParser()
  ini_config.readfp(open(INI_FILE))

  ## init the DB
  connection = MySQLdb.connect(host=ini_config.get('db', 'host'),
  user=ini_config.get('db', 'user'), passwd=ini_config.get('db', 'pass') \
      , db=ini_config.get('db', 'db') )
  curs = connection.cursor()

  ## Prefix
  DB_PREFIX = ini_config.get('db', 'prefix')

# add the revision to the queue for coloring
def mark_for_coloring(rev_id, page_id, user_id, rev_time, page_title):
  global DB_PREFIX
  global curs

  sql = """INSERT INTO """+DB_PREFIX+"""wikitrust_missing_revs (revision_id, page_id, page_title, rev_time, user_id) VALUES (%(rid)s, %(pid)s, %(title)s, %(time)s, %(vid)s) ON DUPLICATE KEY UPDATE requested_on = now(), processed = false"""
  args = {'rid':rev_id, 'pid':page_id, 'title':page_title, 
          'time':rev_time, 'vid':user_id }

  curs.execute(sql, args)
  connection.commit()

# Insert the vote into the db
def handle_vote(req, rev_id, page_id, user_id, v_time, page_title):
  global DB_PREFIX
  global curs

  sql = """INSERT INTO """+DB_PREFIX+"""wikitrust_vote (revision_id, page_id, voter_id, voted_on) VALUES (%(rid)s, %(pid)s, %(vid)s, %(time)s) ON DUPLICATE KEY UPDATE voted_on = %(time)s"""
  args = {'rid':rev_id, 'pid':page_id, 'vid':user_id, 'time':v_time}
  
  curs.execute(sql, args)
  connection.commit()

  mark_for_coloring(rev_id, page_id, user_id, v_time, page_title)
  
  # token saying things are ok
  req.write("good")

# Return colored text from the DB
def fetch_colored_markup(rev_id, page_id, user_id, rev_time, page_title):
  global DB_PREFIX
  global curs
  global not_found_text_token

  sql = """SELECT revision_text,median FROM """ + DB_PREFIX + \
      """wikitrust_colored_markup JOIN """+ DB_PREFIX + \
      """wikitrust_global WHERE revision_id = %s"""
  args = (rev_id)
  numRows = curs.execute(sql, args)

  if (numRows > 0):
    dbRow = curs.fetchone()
    return "%f,%s" % (dbRow[1],dbRow[0])
  return not_found_text_token

# Return colored text if it exists
def handle_text_request(req, rev_id, page_id, user_id, rev_time, page_title):
  global DB_PREFIX
  global sleep_time_sec
  global not_found_text_token

  res = fetch_colored_markup(rev_id, page_id, user_id, rev_time, page_title)
  if (res == not_found_text_token):
    mark_for_coloring(rev_id, page_id, user_id, rev_time, page_title)
    time.sleep(sleep_time_sec)
   
  res = fetch_colored_markup(rev_id, page_id, user_id, rev_time, page_title) 
  if (res == not_found_text_token):
    req.write(not_found_text_token)
  else:
    compressed = compressBuf(res)
 
    req.content_type = "application/x-gzip"
    req.content_length = len (compressed)
    req.send_http_header()

    req.write(compressed)
  
# Before we start, connect to the db
connect_db()

# Entry point for web request.
def handler(req):

  ## Default mimetype
  req.content_type = "text/plain" 

  # Restart the connection to the DB if its not good.
  if (not connection.ping()):
    connect_db()

  ## Parse the form inputs
  form = util.FieldStorage(req)
  page_id = form.getfirst("page", -1)     
  rev_id = form.getfirst("rev", -1)
  page_title =form.getfirst("page_title", "")
  time_str = form.getfirst("time", "")
  user_id = form.getfirst("user", -1)
  is_vote = form.getfirst("vote", None)
  
  if (page_id < 0) or (rev_id < 0) or (page_title == "") or (time_str == "") \
        or (user_id < 0):
    req.write("bad")
  else:  
    if is_vote:
      handle_vote(req, rev_id, page_id, user_id, time_str, page_title)
    else:
      handle_text_request(req, rev_id, page_id, user_id, time_str, page_title)

  return apache.OK


