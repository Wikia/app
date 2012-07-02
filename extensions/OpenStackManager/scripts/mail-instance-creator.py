#!/usr/bin/python
import urllib
import subprocess

from xml.dom import minidom
from optparse import OptionParser
from socket import gethostname;

def main():
	parser = OptionParser(conflict_handler="resolve")
	parser.set_usage("mail-instance-creator.py <from-email-address> <to-email-address> <languagecode> <wikiaddress>\n\n\texample: mail-instance-creator.py 'test@example.com' 'es' 'http://example.com/w/'")

	(options, args) = parser.parse_args()

	if len(args) != 4:
		parser.error("mail-instance-creator.py expects exactly four arguments.")

	fromaddress = args[0]
	toaddress = args[1]
	lang = args[2]
	wikiaddress = args[3]
	subjecturl = wikiaddress + 'api.php?action=expandtemplates&text={{msgnw:mediawiki:openstackmanager-email-subject/' + lang + '}}&format=xml'
	bodyurl = wikiaddress + 'api.php?action=expandtemplates&text={{msgnw:mediawiki:openstackmanager-email-body/' + lang + '}}&format=xml'
	dom = minidom.parse(urllib.urlopen(subjecturl))
	subject = dom.getElementsByTagName('expandtemplates')[0].firstChild.data
	dom = minidom.parse(urllib.urlopen(bodyurl))
	p = subprocess.Popen("ssh-keygen -lf /etc/ssh/ssh_host_rsa_key.pub", shell=True, stdout=subprocess.PIPE)
	fingerprint = p.communicate()[0]
	fingerprint = fingerprint.split(' ')[1]
	body = dom.getElementsByTagName('expandtemplates')[0].firstChild.data
	body = body + ' ' + gethostname() + ' (' + fingerprint + ')'
	message = "From: %s\nTo: %s\nSubject: %s\n\n%s" % (fromaddress, toaddress, subject, body)
	p = subprocess.Popen("/usr/sbin/sendmail -t", shell=True, stdin=subprocess.PIPE)
	p.communicate(message)
	if p.wait() != 0:
		return 1

if __name__ == "__main__":
	main()
