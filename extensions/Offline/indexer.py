#!/usr/bin/env python
import os
import fcntl
import subprocess
import bz2
import re
import xapian
import sys
import string

class Indexer(object):
  def __init__(self, xmlbz2_path):
    self.base_dir = os.path.dirname(xmlbz2_path)
    self.xmlbz2_path = xmlbz2_path
    self.splits_dir = self.base_dir
    self.db_dir = os.path.join(self.base_dir, "db")
    #self.splits_dir = os.path.join(self.base_dir, "wiki-splits")

  def Semaphored(f):
    def f_wrapped(self, *args, **kw):
      m = Mutex(self.base_dir, f.__name__)
      if m.lock():
        f(self, *args, **kw)
        m.done()
    return f_wrapped

  @Semaphored
  def split_dump(self):
    try:
      if not os.path.exists(self.splits_dir):
        os.makedirs(self.splits_dir)
      else:
        for dirpath, subdirs, files in os.walk(self.splits_dir):
          for f in files:
            if f.startswith('rec'):
              os.remove(os.path.join(dirpath, f))
  
      subprocess.call(["bzip2recover", os.path.abspath(self.xmlbz2_path)])
    except:
      raise
    print "Perfect, spliting complete. You should remove the original dumpfile."

  #def subdirize(self):
  #  die("oops--this is for the special case where you have done an initial split, then want to make smaller files.")

  @Semaphored
  def index(self):
    db = Db(self.db_dir)
    article_title_re = re.compile(' *<title>([^<]+)</title>')
    for dirpath, subdirs, files in os.walk(self.splits_dir):
      for f in files:
        if re.match('rec.*\.bz2', f):
          offset = 0
          try:
            plain = bz2.BZ2File(os.path.join(dirpath, f))
            for line in plain:
              title_match = article_title_re.match(line)
              if title_match:
                title = string.strip(title_match.group(1))
                db.add(f, offset, title)
              offset += len(line)
          except:
            raise
    print "Index built - we are done"


class Db(object):
  def __init__(self, db_path):
    try:
      # Open the database for update, creating a new database if necessary.
      self.database = xapian.WritableDatabase(db_path, xapian.DB_CREATE_OR_OPEN)

      self.indexer = xapian.TermGenerator()
      self.stemmer = xapian.Stem("english") # XXX
      self.indexer.set_stemmer(self.stemmer)
    except:
      raise

  def add(self, filename, offset, article_title):
    try:
      doc = xapian.Document()

      para = ":".join([filename, str(offset), article_title])
      doc.set_data(para)

      self.indexer.set_document(doc)
      self.indexer.index_text(para)

      self.database.add_document(doc)
    except StopIteration:
      pass
    except:
      raise


class Mutex(object):
  def __init__(self, dir_path, name):
    self.dir_path = dir_path
    self.name = name
    self.path = os.path.join(dir_path, "."+name)

  def done_mutex(self):
    return Mutex(self.dir_path, self.name+"-done")

  def done(self):
    self.done_mutex().lock()
    self.unlock()

  def busy(self):
    return os.path.exists(self.path)

  def lock(self):
    f = open(self.path, "w")
    try:
      fcntl.flock(f, fcntl.LOCK_EX | fcntl.LOCK_NB)
      if not self.done_mutex().busy():
        return True
      print "Already completed: %s" % self.name
      self.unlock()
    except:
      print "Failed to obtain lock for process: %s" % self.name
      raise
    return False
  
  def unlock(self):
    try:
      if os.path.exists(self.path):
        f = open(self.path, "w")
        fcntl.flock(f, fcntl.LOCK_UN)
        os.remove(self.path)
    except:
      raise

if __name__ == '__main__':
  if len(sys.argv) == 2:
    indexer = Indexer(xmlbz2_path=sys.argv[1])
    indexer.split_dump()
    indexer.index()
  else:
    print "Usage: indexer.py DUMP.xml.bz2"
