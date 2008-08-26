#!/usr/bin/perl
#
# applicaton/x-external-editor 
# reference implementation of the helper application
#
# written by Erik Möller - public domain
#
# User documentation:      http://meta.wikimedia.org/wiki/Help:External_editors
# Technical documentation: http://meta.wikimedia.org/wiki/Help:External_editors/Tech
#
# To do: Edit conflicts
#
use Config::IniFiles;  # Module for config files in .ini syntax
use LWP::UserAgent;    # Web agent module for retrieving and posting HTTP data
use URI::Escape;       # Urlencode functions
use Gtk2 '-init';      # Graphical user interface, requires GTK2 libraries
use Encode qw(encode); # UTF-8/iso8859-1 encoding
use HTML::Entities;    # Encode or decode strings with HTML entities

# Load interface messages
initmsg();

# By default, config will be searched for in your Unix home directory 
# (e.g. ~/.ee-helper/ee.ini). Change path of the configuration file if needed!
#
# Under Windows, set to something like 
#   $cfgfile='c:\ee\ee.ini'; 
# (note single quotes!)
$cfgfile=$ENV{HOME}."/.ee-helper/ee.ini";


$cfgfile=getunixpath($cfgfile);

$DEBUG=0;
$NOGUIERRORS=0;
$LANGUAGE="en";

# Read config
my $cfg = new Config::IniFiles( -file => $cfgfile )  or vdie (_("noinifile",$cfgfile));

# Treat spaces as part of input filename
my $args=join(" ",@ARGV);

# Where do we store our files?
my $tempdir=$cfg->val("Settings","Temp Path") or vdie (_("notemppath",$cfgfile));

# Remove slash at the end of the directory name, if existing
$/="/";  
chomp($tempdir);
$/="\\";
chomp($tempdir);
my $unixtempdir=getunixpath($tempdir);

if($DEBUG) {
	# Make a copy of the control (input) file in the log
	open(DEBUGLOG,">$unixtempdir/debug.log");
	open(INPUT,"<$args");
	$/=undef; # slurp mode
	while(<INPUT>) {
	$inputfile=$_;
	}
	print DEBUGLOG $inputfile;
	close(INPUT);
}

# Read the control file
if(-e $args) {
	$input = new Config::IniFiles( -file => $args );
} else {
	vdie (_("nocontrolfile"));
}

# Initialize the browser as Firefox 1.0 with new cookie jar
$browser=LWP::UserAgent->new();
$browser->cookie_jar( {} );
@ns_headers = (
   'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20041107 Firefox/1.0',
   'Accept' => 'image/gif, image/x-xbitmap, image/jpeg,
        image/pjpeg, image/png, */*',
   'Accept-Charset' => 'iso-8859-1,*,utf-8',
   'Accept-Language' => 'en-US',
);

# Obtain parameters from control file
$special=$input->val("Process","Special namespace");
$fileurl=$input->val("File","URL");
$type=$input->val("Process","Type");
$script=$input->val("Process","Script");
$server=$input->val("Process","Server");
$path=$input->val("Process","Path");
$login_url=$script."?title=$special:Userlogin&action=submitlogin";
$ext=$input->val("File","Extension");
if($special eq "") { $special="Special"; };

# Edit file: change an image, sound etc. in an external app
# Edit text: change a regular text file
# In both cases, we need to construct the relevant URLs
# to fetch and post the data.
if($type eq "Edit file") {
	$filename=substr($fileurl,rindex($fileurl,"/")+1);
	# Image: is canonical namespace name, should always work
	$view_url=$script."?title=Image:$filename"; 
	$upload_url=$script."?title=$special:Upload";
} elsif($type eq "Edit text") {
	$fileurl=~m|\?title=(.*?)\&action=|i;
	$pagetitle=$1;
	$filename=uri_unescape($pagetitle);
        # substitute illegal or special characters
	$filename =~ s/:/__/g; # : - illegal on Windows
	$filename =~ s|/|__|g; # / - path character under Unix and others
	# potential shell metacharacters:
	$filename =~ s/[\[\]\{\}\(\)~!#\$\^\&\*;'"<>\?]/__/g;
	
	$filename=$filename.".wiki";
	$edit_url=$script."?title=$pagetitle&action=submit";
	$view_url=$script."?title=$pagetitle";	
} elsif($type eq "Diff text") {
	$secondurl=$input->val("File 2","URL");
	if(!$secondurl) {
		vdie (_("twofordiff"));
	}
	$diffcommand=$cfg->val("Settings","Diff");
	if(!$diffcommand) {
		vdie (_("nodifftool"));	
	}
} else {
		# Nothing we know!
		vdie (_("unknownprocess"));	
}


# Obtain settings from config file
$previewclient=$cfg->val("Settings","Browser");	
$browseaftersave=$cfg->val("Settings","Browse after save");	

# The config file can contain definitions for any number
# of site. Each one of them should have an "URL match", which is
# a simple string expression that needs to be part of the
# URL in the control file in order for it to be recognized
# as that site. Using this methodology, we can define usernames
# and passwords for sites relatively easily.
#
# Here we try to match the URL in the control file against the 
# URL matches in all sections to determine the username and
# password.
#
@sections=$cfg->Sections();
foreach $section(@sections) {
	if($search=$cfg->val($section,"URL match")) {		
		if(index($fileurl,$search)>=0) {
			$username=$cfg->val($section,"Username");
			$password=$cfg->val($section,"Password");
		}
	}

}

# Log into server
# Note that we also log in for diffs, as the raw text might only be available
# to logged in users (depending on the wiki security settings), and we may want
# to offer GUI-based rollback functionality later
$response=$browser->post($login_url,@ns_headers,
Content=>[wpName=>$username,wpPassword=>$password,wpRemember=>"1",wpLoginAttempt=>"Log in"]);

# We expect a redirect after successful login
if($response->code!=302 && !$ignore_login_error) {
	vdie (_("loginfailed",$login_url,$username,$password));
}

$response=$browser->get($fileurl,@ns_headers);
if($type eq "Edit file") {

	open(OUTPUT,">$unixtempdir/".$filename);
	binmode(OUTPUT);
	select OUTPUT; $|=1; select STDOUT;
	print OUTPUT $response->content;
	close(OUTPUT);

}elsif($type eq "Edit text") {

	# Do we need to convert UTF-8 into ISO 8859-1?
	if($cfg->val("Settings","Transcode UTF-8") eq "true") {
		$transcode=1;
	}
	
	# MediaWiki 1.4+ uses edit tokens, we need to get one 
	# before we can submit edits. So instead of action=raw, we use 
	# action=edit, and get the token as well as the text of the page
	# we want to edit in one go.
	$ct=$response->header('Content-Type');
	$editpage=$response->content;
	$editpage=~m|<input type='hidden' value="(.*?)" name="wpEditToken" />|i;
	$token=$1;
	$editpage=~m|<textarea.*?name="wpTextbox1".*?>(.*?)</textarea>|is;
	$text=$1;
	$editpage=~m|<input type='hidden' value="(.*?)" name="wpEdittime" />|i;
	$time=$1;
	
	# Do we need to convert ..?
	if($ct=~m/charset=utf-8/i) {
		$is_utf8=1; 
	}	
	# ..if so, do it.
	if($is_utf8 && $transcode) {
		Encode::from_to($text,'utf8','iso-8859-1');
	}
	
	# decode HTML entities
	HTML::Entities::decode($text);
	
	# Flush the raw text of the page to the disk
	open(OUTPUT,">$unixtempdir/".$filename);
	select OUTPUT; $|=1; select STDOUT;
	print OUTPUT $text;
	close(OUTPUT);
	
}


# Search for extension-associated application
@extensionlists=$cfg->Parameters("Editors");
foreach $extensionlist(@extensionlists) {
	@exts=split(",",$extensionlist);
	foreach $extensionfromlist(@exts) {
		if ($extensionfromlist eq $ext) { 
			$app=$cfg->val("Editors",$extensionlist);
		}
	}
}

# In most cases, we'll want to run the GUI for managing saves & previews,
# and run the external editor application.
if($type ne "Diff text") {
	
	if($^O eq "MSWin32") {
	
		$appstring="$app $tempdir\\$filename";
	} else {
		$appstring="$app $tempdir/$filename";
	}
	$cid=fork();
	if(!$cid) {
 		exec($appstring);
	}
	makegui();

} else {
	# For external diffs, we need to create two temporary files.
	$response1=$browser->get($fileurl,@ns_headers);
	$response2=$browser->get($secondurl,@ns_headers);
	open(DIFF1, ">$unixtempdir/diff-1.txt");
	select DIFF1; $|=1; select STDOUT;
	open(DIFF2, ">$unixtempdir/diff-2.txt");
	select DIFF2; $|=1; select STDOUT;
	print DIFF1 $response1->content;
	print DIFF2 $response2->content;
	close(DIFF1);
	close(DIFF2);
	if($^O eq "MSWin32") {
		$appstring="$diffcommand $tempdir\\diff-1.txt $tempdir\\diff-2.txt";
	} else {
		$appstring="$diffcommand $tempdir/diff-1.txt $tempdir/diff-2.txt";
	}
	system($appstring);	
}
	
# Create the GTK2 graphical user interface
# It should look like this:
#  _______________________________________________
# | Summary: ____________________________________ |
# |                                               |
# | [Save] [Save & Cont.] [Preview] [Cancel]      |
# |_______________________________________________|
#
# Save: Send data to the server and quit ee.pl
# Save & cont.: Send data to the server, keep GUI open for future saves
# Preview: Create local preview file and view it in the browser (for text)
# Cancel: Quit ee.pl
#
sub makegui {
	$title_label = Gtk2::Label->new($filename);

	$vbox = Gtk2::VBox->new;
	$hbox = Gtk2::HBox->new;
	$label =  Gtk2::Label->new(_("summary"));
	$entry = Gtk2::Entry->new;
	$hbox->pack_start_defaults($label);
	$hbox->pack_start_defaults($entry);
	
	$hbox2 = Gtk2::HBox->new;
	$savebutton =  Gtk2::Button->new(_("save"));
	$savecontbutton =  Gtk2::Button->new(_("savecont"));
	$previewbutton =  Gtk2::Button->new(_("preview"));
	$cancelbutton = Gtk2::Button->new(_("cancel"));
	$hbox2->pack_start_defaults($savebutton);
	$hbox2->pack_start_defaults($savecontbutton);
	$hbox2->pack_start_defaults($previewbutton);
	$hbox2->pack_start_defaults($cancelbutton);		
	$vbox->pack_start_defaults($title_label);
	$vbox->pack_start_defaults($hbox);
	$vbox->pack_start_defaults($hbox2);
	if($type ne "Edit file") {
		$hbox3 = Gtk2::HBox->new;
		$minoreditcheck = Gtk2::CheckButton->new_with_label(_("minoredit"));
		$watchcheck = Gtk2::CheckButton->new_with_label(_("watchpage"));
		$hbox3->pack_start_defaults($minoreditcheck);
		$hbox3->pack_start_defaults($watchcheck);
		$vbox->pack_start_defaults($hbox3);
		if ($cfg->val("Settings","Minor edit default") =~ m/^(?:true|1)$/i) {
			$minoreditcheck->set_active(1);
		}
		if ($cfg->val("Settings","Watch default") =~ m/^(?:true|1)$/i) {
			$watchcheck->set_active(1);
		}

	}

	# Set up window
	$window = Gtk2::Window->new;
	$window->set_title (_("entersummary"));
	$window->signal_connect (delete_event => sub {Gtk2->main_quit});
	$savebutton->signal_connect (clicked => \&save);
	$savecontbutton->signal_connect ( clicked => \&savecont);
	$previewbutton->signal_connect ( clicked => \&preview);	
	$cancelbutton->signal_connect (clicked => \&cancel);
	if($type ne "Edit file") {
		$minoreditcheck->get_active();
		$watchcheck->get_active();
	}
	# Add vbox to window
	$window->add($vbox);
	$window->show_all;
	Gtk2->main;

} 

# Just let save function know that it shouldn't quit
sub savecont {

	save("continue");
	
}

# Just let save function know that it shouldn't save
sub preview {
	$preview=1;
	save("continue");
}

sub save {

	my $cont=shift;
	my $summary=$entry->get_text();	
	my ($minorvar, $watchvar);
	if($type ne "Edit file") {
		$minorvar=$minoreditcheck->get_active();
		$watchvar=$watchcheck->get_active();	
	}
	# Spam the summary if room is available :-)
	if(length($summary)<190) {
		my $tosummary=_("usingexternal");
		if(length($summary)>0) {
			$tosummary=" [".$tosummary."]";
		}
		$summary.=$tosummary;
	}
	if($is_utf8) {
		$summary=Encode::encode('utf8',$summary);	
	}
	# Upload file back to the server and load URL in browser
	if($type eq "Edit file") {		
		print $upload_url;
 		$response=$browser->post($upload_url,
 		@ns_headers,Content_Type=>'form-data',Content=>
 		[
 		wpUploadFile=>["$unixtempdir/".$filename],
 		wpUploadDescription=>$summary,
 		wpUploadAffirm=>"1",
 		wpUpload=>"Upload file",
 		wpIgnoreWarning=>"1"
 		]);		
		if($browseaftersave eq "true" && $previewclient && !$preview) {
			$previewclient=~s/\$url/$view_url/i;			
			system(qq|$previewclient|);
			$previewclient=$cfg->val("Settings","Browser");	
		} 
	# Save text back to the server & load in browser
	} elsif($type eq "Edit text") {	
		open(TEXT,"<$unixtempdir/".$filename);
		$/=undef;
		while(<TEXT>) {
			$text=$_;
		}
		close(TEXT);
		if($is_utf8 && $transcode) {
			Encode::from_to( $text, 'iso-8859-1','utf8');
		}
		@content = (		
			Content=>[
			wpTextbox1=>$text,
			wpSummary=>$summary,
			wpEdittime=>$time,
			wpEditToken=>$token]
			);		
		$watchvar && push @{$content[1]}, (wpWatchthis=>"1");
		$minorvar && push @{$content[1]}, (wpMinoredit=>"1");
		$preview && push @{$content[1]}, (wpPreview=>"true");
		if($preview) {	
			$response=$browser->post($edit_url,@ns_headers,
			@content);
			open(PREVIEW,">$unixtempdir/preview.html");
			$preview=$response->content;
			# Replace relative URLs with absolute ones	
			$preview=~s|<head>|<head>\n    <base href="$server$path">|gi;
			print PREVIEW $preview;
			close(PREVIEW);	
			if($previewclient) {
				$previewurl="file://$unixtempdir/preview.html";
				$previewclient=~s/\$url/$previewurl/i;
				system(qq|$previewclient|);
				$previewclient=$cfg->val("Settings","Browser");	
			}
		} else {		
			$response=$browser->post($edit_url,@ns_headers,@content);		
		}
		if($browseaftersave eq "true" && $previewclient && !$preview) {
			$previewclient=~s/\$url/$view_url/i;
			system(qq|$previewclient|);	
			$previewclient=$cfg->val("Settings","Browser");	
		}
		$preview=0;
	}
	if($cont ne "continue") {
		Gtk2->main_quit;
		exit 0;
	}
}
sub cancel {

	Gtk2->main_quit;

}

sub _{
	my $message=shift;
	@subst=@_;	
	my $suffix;
	if($LANGUAGE ne "en") { $suffix = "_".$LANGUAGE; }
	$msg=$messages{$message.$suffix};
	foreach $substi(@subst) {
		$msg=~s/____/$substi/s;	
	}
	return $msg;
}

sub vdie {

	my $errortext=shift;
	if(!$NOGUIERRORS) {
		errorbox($errortext);
	}
	die($errortext);

}

sub errorbox {

	my $errortext=shift;
	
	my $dialog = Gtk2::MessageDialog->new ($window,
					[qw/modal destroy-with-parent/],
					'error',
					'ok',
					$errortext);
	$dialog->run;
	$dialog->destroy;
				   
}

sub getunixpath {

	my $getpath=shift;
	if($^O eq 'MSWin32') {
		$getpath=~s|\\|/|gi;
	}
	return $getpath;
}

sub initmsg {

%messages=(

noinifile=>
"____ could not be found.
Please move the configuration file (ee.ini) there, or edit ee.pl 
and point the variable \$cfgfile to the proper location.",

noinifile_de=>
"____ konnte nicht gefunden werden.
Bitte verschieben Sie die Konfigurations-Datei (ee.ini) dorthin, 
oder bearbeiten Sie ee.pl und zeigen Sie die Variable \$cfgfile 
auf die korrekte Datei.",

notemppath=>
"No path for temporary files specified. Please edit ____ 
and add an entry like this:

[Settings]
Temp Path=/tmp\n",
notemppath_de=>
"Kein Pfad für temporäre Dateien festgelegt. 
Bitte bearbeiten Sie ____
und fügen Sie einen Eintrag wie folgt ein:

[Settings]
Temp Path=/tmp\n",

nocontrolfile=>
"No control file specified.
Syntax: perl ee.pl <control file>\n",
nocontrolfile_de=>
"Keine Kontrolldatei angegeben.
Syntax: perl ee.pl <Kontrolldatei>\n",

twofordiff=>
"Process is diff, but no second URL contained in control file\n",
twofordiff_de=>
"Dateien sollen verglichen werden, Kontrolldatei enthält aber nur eine URL.",

nodifftool=>
"Process is diff, but ee.ini does not contain a 'Diff=' definition line
in the [Settings] section where the diff tool is defined.\n",
nodifftool_de=>
"Dateien sollen verglichen werden, ee.ini enthält aber keine
'Diff='-Zeile im Abschnitt Settings, in der das Diff-Werkzeug 
definiert wird.\n",

unknownprocess=>
"The process type defined in the input file (Type= in the [Process] section) 
is not known to this implementation of the External Editor interface. Perhaps 
you need to upgrade to a newer version?\n",
unknownprocess_de=>
"Der in der Kontrolldatei definierte Prozesstyp (Type= im Abschnitt [Process])
ist dieser Implementierung des application/x-external-editor-Interface nicht
bekannt. Vielleicht müssen Sie Ihre Version des Skripts aktualisieren.\n",

loginfailed=>
"Could not login to 
____ 
with username '____' and password '____'.

Make sure you have a definition for this website in your ee.ini, and that
the 'URL match=' part of the site definition contains a string that is part
of the URL above.\n",

loginfailed_de=>
"Anmeldung bei 
____ 
gescheitert. Benutzername: ____ Passwort: ____

Stellen Sie sicher, dass Ihre ee.ini eine Definition für diese Website
enthält, und in der 'URL match='-Zeile ein Text steht, der Bestandteil der
obigen URL ist.\n",

summary=>
"Summary",
summary_de=>
"Zusammenfassung",

save=>
"Save",
save_de=>
"Speichern",

savecont=>
"Save and continue",
savecont_de=>
"Speichern und weiter",

preview=>
"Preview",
preview_de=>
"Vorschau",

cancel=>
"Cancel",
cancel_de=>
"Abbruch",

entersummary=>
"Enter edit summary",
entersummary_de=>
"Zusammenfassung eingeben",

minoredit=>
"Check as minor edit",
minoredit_de=>
"Kleine Änderung",

watchpage=>
"Watch this page",
watchpage_de=>
"Seite beobachten",

usingexternal=>
"using [[Help:External editors|an external editor]]",
usingexternal_de=>
"mit [[Hilfe:Externe Editoren|externem Editor]]",

);

}