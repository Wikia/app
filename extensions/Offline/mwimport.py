#!/usr/bin/env python

import re
import string
import os
import os.path
import sys
import random
from datetime import datetime
from lxml import etree
from collections import namedtuple
from optparse import OptionParser

Page = namedtuple('Page', [
  'id',
  'namespace',
  'title',
  'restrictions',
  'counter',
  'is_redirect',
  'is_new',
  'random',
  'touched',
  'latest',
  'len'
])

Revision = namedtuple('Revision', [
  'id',
  'page',
  'text_id',
  'comment',
  'user',
  'user_text',
  'timestamp',
  'minor_edit',
  'deleted',
  'len',
  'parent_id'
])

Text = namedtuple('Text', [
  'id',
  'text',
  'flags'
])

class Element(object):
  def __init__(self, element, xmlns=None):
    self.element = element
    self.xmlns = xmlns

  def text(self, tag, default='NULL'):
    return self.element.findtext(self.xmlns+tag, default)

  def attr(self, tag, default='NULL'):
    return self.element.get(self.xmlns+tag, default)

  def child(self, tag):
    children = self.element.iterchildren(tag=self.xmlns+tag)
    try:
      return Element(element=children.next(), xmlns=self.xmlns)
    except:
      pass

  def contents(self):
    return self.element.text


class ParsedArticle(object):
  def __init__(self):
    pass

class DumpParser(object):
  def __init__(self, input=None, output_base=None):
    if not input or input == "-":
      self.input = sys.stdin
    else:
      self.input = input
    self.output_base = output_base
    self.xmlns = ''

  def parse(self):
    self.output = Output(basedir=self.output_base)
    self.xmlns = '{http://www.mediawiki.org/xml/export-0.5/}'

    for _, element in etree.iterparse(source=self.input, tag=self.xmlns+'page'):
      tag = element.tag.replace(self.xmlns, '')
      #XXX problem, we would have to listen to tag start events:
      #if tag == 'mediawiki':
      #  self.xmlns = Element(element).attr('xmlns')
      method = getattr(DumpParser, tag, None)
      if method:
        article = method(self, element=Element(element, xmlns=self.xmlns))
        self.output.write_article(article)
      element.clear()

  def page(self, element):
    self.article = ParsedArticle()

    self.article.page_id=element.text('id')
    self.revision(element.child('revision'))

    title = element.text('title')
    if ':' in title:
      namespace, title = title.split(':', 1)
    else:
      namespace = 'Main'

    if re.match("#redirect", self.article.text.text, re.I):
      redirect = 1
    else:
      redirect = 0

    touched = datetime.now().strftime("%Y%m%d%H%M%S") # mysql timestamp

    self.article.page = Page(
      id=self.article.page_id,
      namespace=namespace,
      title=title,
      restrictions=element.text('restrictions', 0),
      counter=0,
      is_redirect=redirect, #XXX
      is_new=0,
      random=random.randint(0, 4000000000),
      touched=touched,
      latest=self.article.revision.id,
      len=self.article.text_len
    )
    return self.article

  def revision(self, element):
    self.article.revision_id = element.text('id')
    self.text(element.child('text'))
    self.contributor(element.child('contributor'))
    self.comment(element.child('comment'))

    parsed_time = datetime.strptime(element.text('timestamp'), "%Y-%m-%dT%H:%M:%SZ")
    timestamp = parsed_time.strftime("%Y%m%d%H%M%S") # mysql timestamp

    self.article.revision = Revision(
      id=self.article.revision_id,
      page=self.article.page_id,
      text_id=self.article.text.id,
      comment=self.article.comment,
      user=self.article.contrib_id,
      user_text=self.article.contrib_user,
      timestamp=timestamp,
      minor_edit=element.text('minor', 0),
      deleted=0,
      len=self.article.text_len,
      parent_id=self.article.page_id
    )

  def text(self, element):
    #XXX deleted, preserve
    self.article.text = Text(
      id=self.article.revision_id,
      text=element.contents(),
      flags='utf-8'
    )
    self.article.text_len = 0
    if self.article.text.text:
      self.article.text_len = len(self.article.text.text)

  def contributor(self, element):
    self.article.contrib_user = element.text('username', element.text('ip'))
    self.article.contrib_id = element.text('id', 0)

  def comment(self, element):
    if element and not element.attr('deleted'):
      self.article.comment = element.contents()
    else:
      self.article.comment = ''


class Output(object):
  def __init__(self, basedir=None):
    self.base = basedir
    if not self.base:
      self.base = "text_sqldata"
    if not os.path.exists(self.base):
      os.makedirs(self.base)

    loader = open(os.path.join(self.base, "import.sql"), "w+")
    tables = { 'text': 'old', 'revision': 'rev', 'page': 'page' }
    for table, mapping in tables.items():
      container_class = globals()[table.capitalize()]
      source = os.path.abspath(os.path.join(self.base, table+".dmp"))
      columns = [mapping+"_"+field for field in container_class._fields]

      loader.write("""
          LOAD DATA INFILE "%s"
            REPLACE
              INTO TABLE %s
                  (%s);\n
      """ % (source, table, ', '.join(columns)))

      dumpfile = open(source, 'w+')
      setattr(self, table+"s", dumpfile) 

  def escape(self, text):
    def tr(match):
      if match.group(0) == "\t":
        return "\\t"
      if match.group(0) == "\n":
        return "\\n"

    if isinstance(text, str) or isinstance(text, unicode):
      return re.sub("(\t|\n)", tr, text).encode("utf_8")
    elif isinstance(text, list) or isinstance(text, tuple):
      return [self.escape(e) for e in text]
    else:
      return repr(text)

  def format_line(self, seq):
    return "\t".join(self.escape(seq))+"\n"
    
  def write_article(self, article):
    self.texts.write(self.format_line(article.text))
    self.revisions.write(self.format_line(article.revision))
    self.pages.write(self.format_line(article.page))


if __name__ == "__main__":
  op = OptionParser()
  op.add_option("-d", "--dir", dest="base_dir",
    help="base directory for output files")
  #op.add_option("-f", "--force", dest="force", action="store_true",
  #  help="ignore processing errors")
  #op.add_option("-s", "--skip", dest="skip", type="int",
  #  help="skip over this many articles before begining import")
  #op.add_option("--import", dest="do_sql", action="store_true",
  #  help="run sql import script when finished with dump")
  #op.add_option("--no-import", dest="do_sql", action="store_false",
  #  help="stop after dump, do not import sql")
  #op.add_option("--ignore-existing", dest="replace", action="store_false",
  #  help="no not overwrite existing data")
  #op.add_option("--replace-existing", dest="replace", action="store_true",
  #  help="generated sql statements will overwrite existing data")
  options, args = op.parse_args()

  if len(args) > 1:
    print "too many input file arguments provided: "+" ".join(args)
    sys.exit(-1)
  elif len(args) == 0 or args[0] == '-':
    f = sys.stdin
  else:
    f = open(args[0])

  p = DumpParser(input=f, output_base=options.base_dir)
  p.parse()
