#!/usr/bin/env python
# -*- coding: utf-8 -*-

# ebla solvo: http://stackoverflow.com/questions/5414818/how-to-strip-unicode-punctuation-from-python-string
#unicodedata.category(u'a')
#unicodedata.category(u'.')
#unicodedata.category(u',')
#unicodedata.category(u'\ufeff')
#unicodedata.category(u'\u3000')
#E3 80 80 -> \u3000

import re
import sys
import codecs
from malcxapeligu import malcxapeligu

#http://stackoverflow.com/questions/147741/character-reading-from-file-in-python

#country = u'\u3000FRANCE\u3000'
#clean_pattern = re.compile(u'[^A-Z ]+')
#clean_pattern.sub('', country)
#print country
#print country.replace(u'\u3000','')

#infile = codecs.open('unicode.rst', encoding='utf-8')

with open(sys.argv[1], 'r') as infile:
#with codecs.open(sys.argv[1], encoding='utf-8') as infile:
  with open(sys.argv[2], 'w') as outfile:
    for line in infile:
      #print 'hello'
      #print line
      #line = line.encode('utf-8')
      #line = unicode(line)
      #line = line.strip()
      #line = line.replace(u'\u3000',' ')
      line = line.replace('　',' ')
      #print line
      line = line.replace(';;',';0;')
      line = line.replace(';;',';0;')
      line = re.sub(r'^;','0;',line)
      line = re.sub(r';[ \t]*',';',line)
      line = re.sub(r'[ \t]*;',';',line)
      line = re.sub(r'^[ \t]*','',line)
      line = line.strip()
      line = re.sub(r'([^;])$',r'\1;',line)
      line = malcxapeligu(line)

  # sed -i 's/^[^;]*;//' $TMP
      if len(line)>0:
	outfile.write(line+'\n')
  #for line in f:
    #print line.strip()
  #read_data = f.read()
  #print read_data.strip()
