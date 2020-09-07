#!/usr/bin/perl

# Copyright (C) 2004 Erik Zachte , email xxx\@chello.nl (nospam: xxx=epzachte)
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License version 2
# as published by the Free Software Foundation.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
# See the GNU General Public License for more details, at
# http://www.fsf.org/licenses/gpl.html

# history:
# 1.5 May 27 2004 :
# - when a chart contains only one bar this bar was always centered in the image
#     now AlignBars works well in this case aslo ("justify" treated as "center")
# - interwiki links reinstalled e.g. [[de:Gorbachev]]
# - error msgs corrected
# - minimum image size fixed
# - line numbering adapted <timeline>spaces<br> does not count as line one in Wikipedia
# - line breaks in wiki links parsed correctly [[Vladimir~Ilyich~Lenin]]
# - partial url shown as hint for external link (in GIF/PNG)
# - BarData: no attribute 'text:..' supplied -> default to space = show no text on axis
# - PlotData: new attribute 'anchor:..'
# - revert html encoding of '<' & '>' by MediaWiki

# 1.6 May 28 2004 :
# - SVG decode special chars in SVG input fixed
# - BarData: new attributes 'barset:..' and 'barcount:..' # autoincrement bar id
# - PlotData: new attribute 'barset:..'
# - LineData: new attribute 'layer:..', draw lines to back or front of bars and texts

# 1.7
# - EscapeShellArg (Tim Starling)

# 1.8 June .. 2004 :
# - optional autosizing of image (implied when auto incrementing bar count (also new))
# - presentation left-right order of bars reversed on TimeAxis = orientation:vertical
# - TimeAxis option 'order:[normal|reverse]' added
# - BarData: option barcount replaced by auto incrementing bar count and 'break' and 'skip' attributes
# - DrawLines -> LineData (command renamed, but also restructured like PlotData, TextData)
# - new drawing options for LineData, now also lines parallel to time axis, or between arbitrary points
# - Preset command added (specify default settings with 'Preset =', two sets to start with)
# - 'text' attribute parsing bugs (# or : in text gave problems, spaces got lost)
# - PlotArea  new attributes 'top' and 'right' make it possible to define plot area margins only
#   so resizing image does not imply adjusting PlotArea 'width' and 'height'
# - PlotData option 'shift': only changing x or y value is now possible, e.g. shift=(,10)
# - command ScaleMajor: subs for time axis can now be specified verbatim in option 'text'
# - extra validation checks, defaults, etc
# - function PlotScale now provides workaround for Ploticus bug: auto incrementing dates failed

# 1.9 June 2004
# - stub display order fixed on non time axis

# 1.10 July 2004
# - tempory debug code (removed)

# 1.11 August 2004
# - dot in folder name in input path was misunderstood as start of file extension
# - utf-8 chars within 160-255 range are translated to extended ascii
#   however internal font used by Ploticus has strange mapping so some are replaced
#   by underscore or unaccented version of character
#   this is a make do solution until full unicode support with external fonts will be added
#
# 1.12 June 2009
# - Don't send -mapfile to ploticus without also sending -csmap, this creates an XSS
#   vulnerability
#
# 1.13 Jan 2010
# - change svg encoding from iso-8859-1 -> UTF-8
# - allow font to be specified using -f option as opposed to hardcoded FreeSans.

use 5.010;

use strict;

our $VERSION = '1.90';

use Time::Local;
use Getopt::Std;
use Cwd;
use English '-no_match_vars';

# Global variables.
# Many of these should be refactored.
my $SVG_ONLY = 0;

my @PlotLines;
my $CntErrors = 0;
my @Errors;
my @Info;
my @Warnings;

my $file_in;
my $file_name;
my $file_bitmap;
my $file_vector;
my $file_png;
my $file_htmlmap;
my $file_html;
my $file_errors;

my %options;
my $listinput;
my $linkmap;
my $makehtml;
my $bypass;
my $showmap;
my $tmpdir;
my $ploticus_command;
my $articlepath;
my $font_file;

my $true  = 1;
my $false = 0;

my $LinkColor              = "brightblue";
my $MapPNG                 = $false;        # switched when link or hint found
my $MapSVG                 = $false;        # switched when link found
my $WarnTextOutsideArea    = 0;
my $WarnOnRightAlignedText = 0;

my $hPerc   = &EncodeInput("\%");
my $hAmp    = &EncodeInput("\&");
my $hAt     = &EncodeInput("\@");
my $hDollar = &EncodeInput("\$");
my $hBrO    = &EncodeInput("\(");
my $hBrC    = &EncodeInput("\)");
my $hSemi   = &EncodeInput("\;");
my $hIs     = &EncodeInput("\=");
my $hLt     = &EncodeInput("\<");
my $hGt     = &EncodeInput("\>");

my $file;
my $image_file_fmt;
my $env;
my $pathseparator;

my $LineNo;
my $InputParsed;
my $CommandNext = q();
my $Command;
my $DateFormat;
my $Line;
my $NoData;

my %Consts;    # see sub GetDefine
my %Colors;    # see sub StoreColor
my %BackgroundColors;
my %Axis;
my @Bars;
my %BarLegend;
my %BarLink;
my @LegendData;
my %LineDefs;
my $AlignBars;
my %ColorLabels;
my %Period;
my @DrawLines;
my %Image;
my %Legend;
my %PlotArea;
my %PlotDefs;
my @PlotBars;
my @PlotText;
my $MaxBarWidth;
my %BarWidths;

my $Preset;
my @PresetList;
my %Scales;
my %TextDefs;

# These two must definitely be refactored
my %Attributes;
my @Attributes;

my $firstcmd;

my @PlotTextsPng;
my @PlotTextsSvg;
my @linksSVG;
my @textsSVG;

my @TextData;

my ($sign, $posy1, $posy2);

my $script;
my @PlotBarsNow;

my $command;

# BEGIN
local $| = 1;    # flush screen output

print "EasyTimeline version $VERSION\n"
    . "Copyright (C) 2004 Erik Zachte\n"
    . "Email xxx\@chello.nl (nospam: xxx=epzachte)\n\n"
    . "This program is free software; you can redistribute it\n"
    . "and/or modify it under the terms of the \n"
    . "GNU General Public License version 2 as published by\n"
    . "the Free Software Foundation\n"
    . "------------------------------------------------------\n";

&SetImageFormat;
&ParseArguments;
&InitFiles;

open "FILE_IN", "<", $file_in;
my @lines = <FILE_IN>;
close "FILE_IN";

&ParseScript;

if ($CntErrors == 0) {
    &WritePlotFile;
}

if ($CntErrors == 1) {
    &Abort("1 error found");
}
elsif ($CntErrors > 1) {
    &Abort("$CntErrors errors found");
}
else {
    if (@Info) {
        print "\nINFO\n";
        print @Info;
        print "\n";
    }

    if (@Warnings) {
        print "\nWARNING(S)\n";
        print @Warnings;
        print "\n";
    }

    if (!(-e $file_bitmap)) {
        print "\nImage $file_bitmap not created.\n";
        if ((!(-e "pl.exe")) && (!(-e "pl"))) {
            print
                "\nPloticus not found in local folder. Is it on your system path?\n";
        }
    }
    elsif (!(-e $file_vector)) {
        print "\nImage $file_vector not created.\n";
    }
    else { print "\nREADY\nNo errors found.\n"; }
}

exit;

sub ParseArguments {
    getopt("iTAPef", \%options);

    &Abort("Specify input file as: -i filename") if (!defined($options{"i"}));

    $file_in   = $options{"i"};
    $listinput = $options{"l"};    # list all input lines (not recommended)
    $linkmap   = $options{"m"};    # make clickmap for inclusion in html
         # make test html file with gif/png + svg output
    $makehtml = $options{"h"};

    # do not use in Wikipedia:bypass some checks
    $bypass = $options{"b"};

    # debug: shows clickable areas in gif/png
    $showmap = $options{"d"};

    # The following parameters are used by MediaWiki
    # to pass config settings from LocalSettings.php to
    # the perl script

    # For MediaWiki: temp directory to use
    $tmpdir = $options{"T"};

    # For MediaWiki: full path of ploticus command
    $ploticus_command = $options{"P"};

    # For MediaWiki: Path of an article, relative to this servers root
    $articlepath = $options{"A"};

    # font to use. Must be in environemnt variable
    # GDFONTPATH unless builtin "ascii" font
    $font_file = $options{"f"};

    if (!defined $options{"f"}) {
        $font_file = "ascii";
    }

    if (!defined $options{"A"}) {
        $articlepath = "http://en.wikipedia.org/wiki/\$1";
    }

    if (defined $options{"s"}) {
        $SVG_ONLY = 1;
    }

    if (!-e $file_in) {
        &Abort("Input file '" . $file_in . "' not found.");
    }
}

sub InitFiles {
    print "\nInput:  Script file $file_in\n";

    $file = $file_in;

    # 1.10 dot ignore dots in folder names ->
    $file =~ s/\.[^\\\/\.]*$//;    # remove extension
    $file_name    = $file;
    $file_bitmap  = $file . "." . $image_file_fmt;
    $file_vector  = $file . ".svg";
    $file_png     = $file . ".png";
    $file_htmlmap = $file . ".map";
    $file_html    = $file . ".html";
    $file_errors  = $file . ".err";

    print "Output: Image files $file_bitmap & $file_vector\n";

    if ($linkmap) {
        print
            "        Map file $file_htmlmap (add to html for clickable map)\n";
    }
    if ($makehtml) { print "        HTML test file $file_html\n"; }

    # remove previous output
    if (-e $file_bitmap)  { unlink $file_bitmap; }
    if (-e $file_vector)  { unlink $file_vector; }
    if (-e $file_png)     { unlink $file_png; }
    if (-e $file_htmlmap) { unlink $file_htmlmap; }
    if (-e $file_html)    { unlink $file_html; }
    if (-e $file_errors)  { unlink $file_errors; }
}

sub SetImageFormat {
    $env = "";

    if ($OSNAME =~ /darwin/i) {
        $env            = "Linux";
        $image_file_fmt = "png";
        $pathseparator  = "/";
    }
    elsif ($OSNAME =~ /win/i) {
        $env            = "Windows";
        $image_file_fmt = "gif";
        $pathseparator  = "\\";
    }
    else {
        $env            = "Linux";
        $image_file_fmt = "png";
        $pathseparator  = "/";
    }

    if ($env ne "") {
        print
            "\nOS $env detected -> create image in $image_file_fmt format.\n";
    }
    else {
        print
            "\nOS not detected. Assuming Windows -> create image in $image_file_fmt format.\n";
        $env = "Windows";
    }
}

sub ParseScript {
    my $command;    # local version, $Command = global
    $LineNo      = 0;
    $InputParsed = $false;
    $CommandNext = "";
    $DateFormat  = "x.y";

    $firstcmd = $true;
    &GetCommand;

    &StoreColor("white",         &EncodeInput("gray(0.999)"),  "");
    &StoreColor("barcoldefault", &EncodeInput("rgb(0,0.6,0)"), "");

    while (!$InputParsed) {
        if ($Command =~ /^\s*$/) { &GetCommand; next; }

        if (!($Command =~ /$hIs/)) {
            &Error("Invalid statement. No '=' found.");
            &GetCommand;
            next;
        }

        if ($Command =~ /$hIs.*$hIs/) {
            &Error("Invalid statement. Multiple '=' found.");
            &GetCommand;
            next;
        }

        my ($name, $value) = split($hIs, $Command);
        $name =~ s/^\s*(.*?)\s*$/$1/;

        if ($name =~ /PlotDividers/i) {
            &Error(
                "Command 'PlotDividers' has been renamed to 'LineData', please adjust."
            );
            &GetCommand;
            next;
        }
        if ($name =~ /DrawLines/i) {
            &Error(
                "Command 'DrawLines' has been renamed to 'LineData', please adjust.\n"
                    . "  Reason for change is consistency: LineData now follows the same syntax rules as PlotData and TextData."
            );
            &GetCommand;
            next;
        }

        if (
            (!($name =~ /^(?:Define)\s/))
            && (
                !(
                    $name =~ /^(?:AlignBars|BarData|
                          BackgroundColors|Colors|DateFormat|LineData|
                          ScaleMajor|ScaleMinor|
                          LegendLeft|LegendTop|
                          ImageSize|PlotArea|Legend|
                          Period|PlotData|Preset|
                          TextData|TimeAxis)$/xi
                )
            )
            )
        {
            &ParseUnknownCommand;
            &GetCommand;
            next;
        }

        $value =~ s/^\s*(.*?)\s*//;
        if (!($name =~ /^(?:BarData|Colors|LineData|PlotData|TextData)$/i)) {
            if ((!(defined($value))) || ($value eq "")) {
                if ($name =~ /Preset/i) {
                    &Error("$name definition incomplete. No value specified\n"
                            . "  At the moment only one preset exists: 'TimeVertical_OneBar_UnitYear'.\n"
                            . "  See also meta.wikipedia.org/wiki/EasyTimeline/Presets"
                    );
                }
                else {
                    &Error(
                        "$name definition incomplete. No attributes specified"
                    );
                }
                &GetCommand;
                next;
            }
        }

        if ($name =~
            /^(?:BackgroundColors|Colors|Period|ScaleMajor|ScaleMinor|TimeAxis)$/i
            )
        {
            my @attributes = split(" ", $value);
            foreach my $attribute (@attributes) {
                my ($attrname, $attrvalue) = split("\:", $attribute);
                if (
                    !(
                        $name . "-" . $attrname =~
                        /^(?:Colors-Value|Colors-Legend|
                                        Period-From|Period-Till|
                                        ScaleMajor-Color|ScaleMajor-Unit|ScaleMajor-Increment|ScaleMajor-Start|
                                        ScaleMinor-Color|ScaleMinor-Unit|ScaleMinor-Increment|ScaleMinor-Start|
                                        BackgroundColors-Canvas|BackgroundColors-Bars|
                                        TimeAxis-Orientation|TimeAxis-Format)$/xi
                    )
                    )
                {
                    &Error(
                        "$name definition invalid. Unknown attribute '$attrname'."
                    );
                    &GetCommand;
                    next;
                }

                if ((!defined($attrvalue)) || ($attrvalue eq "")) {
                    &Error(
                        "$name definition incomplete. No value specified for attribute '$attrname'."
                    );
                    &GetCommand;
                    next;
                }
            }
        }

        if    ($Command =~ /^AlignBars/i)        { &ParseAlignBars; }
        elsif ($Command =~ /^BackgroundColors/i) { &ParseBackgroundColors; }
        elsif ($Command =~ /^BarData/i)          { &ParseBarData; }
        elsif ($Command =~ /^Colors/i)           { &ParseColors; }
        elsif ($Command =~ /^DateFormat/i)       { &ParseDateFormat; }
        elsif ($Command =~ /^Define/i)           { &ParseDefine; }
        elsif ($Command =~ /^ImageSize/i)        { &ParseImageSize; }
        elsif ($Command =~ /^Legend/i)           { &ParseLegend; }
        elsif ($Command =~ /^LineData/i)         { &ParseLineData; }
        elsif ($Command =~ /^Period/i)           { &ParsePeriod; }
        elsif ($Command =~ /^PlotArea/i)         { &ParsePlotArea; }
        elsif ($Command =~ /^PlotData/i)         { &ParsePlotData; }
        elsif ($Command =~ /^Preset/i)           { &ParsePreset; }
        elsif ($Command =~ /^Scale/i)            { &ParseScale; }
        elsif ($Command =~ /^TextData/i)         { &ParseTextData; }
        elsif ($Command =~ /^TimeAxis/i)         { &ParseTimeAxis; }

        &GetCommand;
        $firstcmd = $false;
    }

    if ($CntErrors == 0) { &DetectMissingCommands; }

    if ($CntErrors == 0) { &ValidateAndNormalizeDimensions; }
}

sub GetLine {
    if ($#lines < 0) {
        $InputParsed = $true;
        return ("");
    }

    # running in Wikipedia context and first line empty ?
    # skip first line without incrementing line count
    # this is part behind <timeline> and will not be thought of as line 1
    if (defined $options{"A"}) {
        if (($#lines >= 0) && ($lines[0] =~ /^\s*$/)) {
            $Line = shift(@lines);
        }
    }

    my $commentstart;

    $Line = "";
    while (($#lines >= 0) && ($Line =~ /^\s*$/)) {
        $LineNo++;
        $Line = shift(@lines);
        chomp($Line);

        if ($listinput) {
            print "$LineNo: " . &DecodeInput($Line) . "\n";
        }

        # preserve '#' within double quotes
        $Line =~ s/(\"[^\"]*\")/$a=$1,$a=~s^\#^\%\?\+^g,$a/ge;

        $Line =~ s/#>.*?<#//g;
        if ($Line =~ /#>/) {
            $commentstart = $LineNo;
            $Line =~ s/#>.*?$//;
        }
        elsif ($Line =~ /<#/) {
            undef $commentstart;
            $Line =~ s/^.*?<#//x;
        }
        elsif (defined($commentstart)) { $Line = ""; next; }

        # remove single line comments (keep html char tags, like &#32;)
        $Line =~ s/\&\#/\&\$\%/g;
        $Line =~ s/\#.*$//;
        $Line =~ s/\&\$\%/\&\#/g;
        $Line =~ s/\%\?\+/\#/g;
        $Line =~ s/\s*$//g;
        $Line =~ s/\t/ /g;
    }

    if ($Line !~ /^\s*$/) {
        $Line = &EncodeInput($Line);

        if (!($Line =~ /^\s*Define/i)) {
            $Line =~ s/($hDollar[a-zA-Z0-9]+)/&GetDefine($Line,$1)/ge;
        }
    }

    if (($#lines < 0) && (defined($commentstart))) {
        &Error2(
            "No matching end of comment found for comment block starting at line $commentstart.\n"
                . "Text between \#> and <\# (multiple lines) or following \# (single line) will be treated as comment."
        );
    }
    return ($Line);
}

sub GetCommand {
    undef(%Attributes);
    $Command = "";

    if ($CommandNext ne "") {
        $Command     = $CommandNext;
        $CommandNext = "";
    }
    else { $Command = &GetLine; }

    if ($Command =~ /^\s/) {
        &Error(
            "New command expected instead of data line (= line starting with spaces). Data line(s) ignored.\n"
        );
        $Command = &GetLine;
        while (($#lines >= 0) && ($Command =~ /^\s/)) { $Command = &GetLine; }
    }

    if ($Command =~ /^[^\s]/) {
        my $line = $Command;
        $line =~ s/^.*$hIs\s*//;
        &CollectAttributes($line);
    }
}

sub GetData {
    undef(%Attributes);
    $Command = "";
    $NoData  = $false;
    my $line = &GetLine;

    if ($line =~ /^[^\s]/) {
        $CommandNext = $line;
        $NoData      = $true;
        return ("");
    }

    if ($line =~ /^\s*$/) {
        $NoData = $true;
        return ("");
    }

    $line =~ s/^\s*//g;
    &CollectAttributes($line);
}

sub CollectAttributes {
    my $line = shift;

    # replace colon (:), would conflict with syntax
    $line =~ s/(\slink\:[^\s\:]*)\:/$1'colon'/i;
    $line =~ s/(\stext\:[^\s\:]*)\:/$1'colon'/i;
    $line =~ s/(https?)\:/$1'colon'/i;

    my $text;
    ($line, $text) = &ExtractText($line);
    $text =~ s/'colon'/:/;

    $line =~ s/( $hBrO .+? $hBrC )/&RemoveSpaces($1)/gxe;
    $line =~ s/\s*\:\s*/:/g;
    $line =~ s/([a-zA-Z0-9\_]+)\:/lc($1) . ":"/gxe;
    my @Fields = split(" ", $line);

    my ($name, $value);
    foreach my $field (@Fields) {
        if ($field =~ /\:/) {
            ($name, $value) = split(":", $field);
            $name  =~ s/^\s*(.*)\s*$/lc($1)/gxe;
            $value =~ s/^\s*(.*)\s*$/$1/gxe;
            if (   ($name ne "bar")
                && ($name ne "text")
                && ($name ne "link")
                && ($name ne "legend"))
            {
                $value = lc($value);
            }

            if ($name eq "link")    # restore colon
            {
                $value =~ s/'colon'/:/;
            }

            if ($value eq "") {
                if ($name =~ /Text/i) { $value = " "; }
                else {
                    &Error(
                        "No value specified for attribute '$name'. Attribute ignored."
                    );
                }
            }
            else { $Attributes{$name} = $value; }
        }
        else {
            if (defined($Attributes{"single"})) {
                &Error(
                    "Invalid attribute '$field' ignored.\nSpecify attributes as 'name:value' pair(s)."
                );
            }
            else {
                $field =~ s/^\s*(.*)\s*$/$1/gxe;
                $Attributes{"single"} = $field;
            }
        }
    }
    if (    (defined $name and $name ne "")
        and (defined $Attributes{"single"} and $Attributes{"single"} ne ""))
    {
        &Error(   "Invalid attribute '"
                . $Attributes{"single"}
                . "' ignored.\nSpecify attributes as 'name:value' pairs.");
        delete($Attributes{"single"});
    }

    if ((defined($text)) && ($text ne "")) {
        $Attributes{"text"} = &ParseText($text);
    }
}

sub GetDefine {
    my $command = shift;
    my $const   = shift;
    $const = lc($const);
    my $value = $Consts{ lc($const) };
    if (!defined($value)) {
        &Error("Unknown constant. 'Define $const = ... ' expected.");
        return ($const);
    }
    return ($value);
}

sub ParseAlignBars {
    &CheckPreset("AlignBars");

    my $align = $Attributes{"single"};
    if (!($align =~ /^(?:justify|early|late)$/i)) {
        &Error(
            "AlignBars value '$align' invalid. Specify 'justify', 'early' or 'late'."
        );
        return;
    }

    $AlignBars = lc($align);
}

sub ParseBackgroundColors {
    if (!&ValidAttributes("BackgroundColors")) {
        &GetData;
        next;
    }

    &CheckPreset("BackGroundColors");

    foreach my $attribute (keys %Attributes) {
        my $attrvalue = $Attributes{$attribute};

        if ($attribute =~ /Canvas/i) {
            if (!&ColorPredefined($attrvalue)) {
                if (!defined($Colors{ lc($attrvalue) })) {
                    &Error(
                        "BackgroundColors definition invalid. Attribute '$attribute': unknown color '$attrvalue'.\n"
                            . "  Specify command 'Color' before this command."
                    );
                    return;
                }
            }
            if (defined($Colors{ lc($attrvalue) })) {
                $Attributes{"canvas"} = $Colors{ lc($attrvalue) };
            }
            else {
                $Attributes{"canvas"} = lc($attrvalue);
            }
        }
        elsif ($attribute =~ /Bars/i) {
            if (!defined($Colors{ lc($attrvalue) })) {
                &Error(
                    "BackgroundColors definition invalid. Attribute '$attribute' unknown color '$attrvalue'.\n"
                        . "  Specify command 'Color' before this command.");
                return;
            }

            $Attributes{"bars"} = lc($attrvalue);
        }
    }

    %BackgroundColors = %Attributes;
}

sub ParseBarData {
    &GetData;
    if ($NoData) {
        &Error(
            "Data expected for command 'BarData', but line is not indented.\n"
        );
        return;
    }

    my ($bar, $text, $link, $hint, $barset);    # , $barcount) ;

    BarData:
    while ((!$InputParsed) && (!$NoData)) {
        if (!&ValidAttributes("BarData")) { &GetData; next; }

        $bar    = "";
        $link   = "";
        $hint   = "";
        $barset = "";                           # $barcount = "" ;

        # warn "data: $data";
        my $data2;                              # = $data;
        ($data2, $text) = &ExtractText($data2);
        @Attributes = split(" ", $data2);

        foreach my $attribute (keys %Attributes) {
            my $attrvalue = $Attributes{$attribute};

            if ($attribute =~ /^Bar$/i) {
                $bar = $attrvalue;
            }
            elsif ($attribute =~ /^BarSet$/i) {
                $barset = $attrvalue;
            }

            # elsif ($attribute =~ /^BarCount$/i)
            # {
            #   $barcount = $attrvalue ;
            # if (($barcount !~ /^\d?\d?\d$/) || ($barcount < 2) || ($barcount > 200))
            # { &Error ("BarData attribute 'barcount' invalid. Specify a number between 2 and 200\n") ;
            #   &GetData ; next BarData ; }
            # }
            elsif ($attribute =~ /^Text$/i) {
                $text = $attrvalue;
                $text =~ s/\\n/~/gs;
                if ($text =~ /\~/) {
                    &Warning( "BarData attribute 'text' contains ~ (tilde).\n"
                            . "Tilde will not be translated into newline character (only in PlotData)"
                    );
                }
                if ($text =~ /\^/) {
                    &Warning( "BarData attribute 'text' contains ^ (caret).\n"
                            . "Caret will not be translated into tab character (only in PlotData)"
                    );
                }
            }
            elsif ($attribute =~ /^Link$/i) {
                $link = &ParseText($attrvalue);

                if ($link =~ /\[.*\]/) {
                    &Error(
                        "BarData attribute 'link' contains implicit (wiki style) link.\n"
                            . "Use implicit link style with attribute 'text' only.\n"
                    );
                    &GetData;
                    next BarData;
                }

                $link = &EncodeURL(&NormalizeURL($link));

                $MapPNG = $true;
            }
        }

        if (($bar eq "") && ($barset eq "")) {
            &Error(
                "BarData attribute missing. Specify either 'bar' of 'barset'.\n"
            );
            &GetData;
            next BarData;
        }

        if (($bar ne "") && ($barset ne "")) {
            &Error(
                "BarData attributes 'bar' and 'barset' are mutually exclusive.\nSpecify one of these per data line\n"
            );
            &GetData;
            next BarData;
        }

        # if (($barset ne "") && ($barcount eq ""))
        # { &Error ("BarData attribute 'barset' specified without attribute 'barcount'.\n") ;
        #   &GetData ; next BarData ; }

        # if (($barset eq "") && ($barcount ne ""))
        # { &Error ("BarData attribute 'barcount' specified without attribute 'barset'.\n") ;
        #   &GetData ; next BarData ; }

        if (($barset ne "") && ($link ne "")) {
            &Error(
                "BarData attribute 'link' not valid in combination with attribute 'barset'.\n"
            );
            &GetData;
            next BarData;
        }

        if ($link ne "") {
            if ($text =~ /\[.*\]/) {
                &Warning(
                    "BarData contains implicit link(s) in attribute 'text' and explicit attribute 'link'.\n"
                        . "Implicit link(s) ignored.");
                $text =~ s/\[+ (?:[^\|]* \|)? ([^\]]*) \]+/$1/gx;
            }

            if ($hint eq "") { $hint = &ExternalLinkToHint($link); }
        }

        if (($bar ne "") && ($bar !~ /[a-zA-Z0-9\_]+/)) {
            &Error(
                "BarData attribute bar:'$bar' invalid.\nUse only characters 'a'-'z', 'A'-'Z', '0'-'9', '_'\n"
            );
            &GetData;
            next BarData;
        }

        if ($bar ne "") {
            if ($Axis{"time"} eq "x") { push @Bars, $bar; }
            else                      { unshift @Bars, $bar; }

            if   ($text ne "") { $BarLegend{ lc($bar) } = $text; }
            else               { $BarLegend{ lc($bar) } = " "; }

            if ($link ne "") { $BarLink{ lc($bar) } = $link; }
        }
        else {

            #     for ($b = 1 ; $b <= $barcount ; $b++)
            #     {
            #       $bar = $barset . "#" . $b ;

            $bar = $barset . "#1";
            if ($Axis{"time"} eq "x") { push @Bars, $bar; }
            else                      { unshift @Bars, $bar; }

            if ($text ne "") { $BarLegend{ lc($bar) } = $text . " - " . $b; }
            else             { $BarLegend{ lc($bar) } = " "; }

            #     }
        }

        &GetData;
    }
}

sub ParseColors {
    my $colorname;

    &GetData;
    if ($NoData) {
        &Error(
            "Data expected for command 'Colors', but line is not indented.\n"
        );
        return;
    }

    Colors:
    while ((!$InputParsed) && (!$NoData)) {
        if (!&ValidAttributes("Colors")) { &GetData; next; }

        &CheckPreset("Colors");

        my $addtolegend = $false;
        my $legendvalue = "";
        my $colorvalue  = "";

        foreach my $attribute (keys %Attributes) {
            my $attrvalue = $Attributes{$attribute};

            if ($attribute =~ /Id/i) {
                $colorname = $attrvalue;
            }
            elsif ($attribute =~ /Legend/i) {
                $addtolegend = $true;
                $legendvalue = $attrvalue;
                if ($legendvalue =~ /^[yY]$/) {
                    push @LegendData, $colorname;
                }
                elsif (!($attrvalue =~ /^[nN]$/)) {
                    $legendvalue = &ParseText($legendvalue);
                    push @LegendData, $legendvalue;
                }
            }
            elsif ($attribute =~ /Value/i) {
                $colorvalue = $attrvalue;
                if ($colorvalue =~ /^white$/i) {
                    $colorvalue = "gray" . $hBrO . "0.999" . $hBrC;
                }
            }
        }

        if (&ColorPredefined($colorvalue)) {
            &StoreColor($colorname, $colorvalue, $legendvalue);
            &GetData;
            next Colors;
        }

        if ($colorvalue =~ /^[a-z]+$/i) {
            if (!($colorvalue =~ /^(?:gray|rgb|hsb)/i)) {
                &Error(
                    "Color value invalid: unknown constant '$colorvalue'.");
                &GetData;
                next Colors;
            }
        }

        if (!($colorvalue =~ /^(?:gray|rgb|hsb) $hBrO .+? $hBrC/xi)) {
            &Error(
                "Color value invalid. Specify constant or 'gray/rgb/hsb(numeric values)' "
            );
            &GetData;
            next Colors;
        }

        if ($colorvalue =~ /^gray/i) {
            if ($colorvalue =~ /gray $hBrO (?:0|1|0\.\d+) $hBrC/xi) {
                &StoreColor($colorname, $colorvalue, $legendvalue);
            }
            else {
                &Error(
                    "Color value invalid. Specify 'gray(x) where 0 <= x <= 1' "
                );
            }

            &GetData;
            next Colors;
        }

        if ($colorvalue =~ /^rgb/i) {
            my $colormode = substr($colorvalue, 0, 3);
            if (
                $colorvalue =~ /rgb $hBrO
                                 (?:0|1|0\.\d+) \,
                                 (?:0|1|0\.\d+) \,
                                 (?:0|1|0\.\d+)
                              $hBrC/xi
                )
            {
                &StoreColor($colorname, $colorvalue, $legendvalue);
            }
            else {
                &Error(
                    "Color value invalid. Specify 'rgb(r,g,b) where 0 <= r,g,b <= 1' "
                );
            }

            &GetData;
            next Colors;
        }

        if ($colorvalue =~ /^hsb/i) {
            my $colormode = substr($colorvalue, 0, 3);
            if (
                $colorvalue =~ /hsb $hBrO
                                 (?:0|1|0\.\d+) \,
                                 (?:0|1|0\.\d+) \,
                                 (?:0|1|0\.\d+)
                              $hBrC/xi
                )
            {
                &StoreColor($colorname, $colorvalue, $legendvalue);
            }
            else {
                &Error(
                    "Color value invalid. Specify 'hsb(h,s,b) where 0 <= h,s,b <= 1' "
                );
            }

            &GetData;
            next Colors;
        }

        &Error("Color value invalid.");
        &GetData;
    }
}

sub StoreColor {
    my $colorname   = shift;
    my $colorvalue  = shift;
    my $legendvalue = shift;
    if (defined($Colors{ lc($colorname) })) {
        &Warning("Color '$colorname' redefined.");
    }
    $Colors{ lc($colorname) } = lc($colorvalue);
    if ((defined($legendvalue)) && ($legendvalue ne "")) {
        $ColorLabels{ lc($colorname) } = $legendvalue;
    }
}

sub ParseDateFormat {
    &CheckPreset("DateFormat");

    my $datevalue = lc($Attributes{"single"});
    $datevalue =~ s/\s//g;
    $datevalue = lc($datevalue);
    if (   ($datevalue ne "dd/mm/yyyy")
        && ($datevalue ne "mm/dd/yyyy")
        && ($datevalue ne "yyyy")
        && ($datevalue ne "x.y"))
    {
        &Error(
            "Invalid DateFormat. Specify as 'dd/mm/yyyy', 'mm/dd/yyyy', 'yyyy' or 'x.y'\n"
                . "  (use first two only for years >= 1800)\n");
        return;
    }

    $DateFormat = $datevalue;
}

sub ParseDefine {
    my $command  = $Command;
    my $command2 = $command;
    $command2 =~ s/^Define\s*//i;

    my ($name, $value) = split($hIs, $command2);
    $name  =~ s/^\s*(.*?)\s*$/$1/g;
    $value =~ s/^\s*(.*?)\s*$/$1/g;

    if (!($name =~ /^$hDollar/)) {
        &Error("Define '$name' invalid. Name does not start with '\$'.");
        return;
    }
    if (!($name =~ /^$hDollar[a-zA-Z0-9\_]+$/)) {
        &Error(
            "Define '$name' invalid. Valid characters are 'a'-'z', 'A'-'Z', '0'-'9', '_'."
        );
        return;
    }

    $value =~ s/($hDollar[a-zA-Z0-9]+)/&GetDefine($command,$1)/ge;
    $Consts{ lc($name) } = $value;
}

sub ParseLineData {
    &GetData;
    if ($NoData) {
        &Error(
            "Data expected for command 'LineData', but line is not indented.\n"
        );
        return;
    }

    if ((!(defined($DateFormat))) || (!(defined($Period{"from"})))) {
        if (!(defined($DateFormat))) {
            &Error(
                "LineData invalid. No (valid) command 'DateFormat' specified in previous lines."
            );
        }
        else {
            &Error(
                "LineData invalid. No (valid) command 'Period' specified in previous lines."
            );
        }

        while ((!$InputParsed) && (!$NoData)) { &GetData; }
        return;
    }

    my (
        $at,      $from,    $till,  $atpos,
        $frompos, $tillpos, $color, $layer,
        $width,   $points,  $explanation
    );

    $layer = "front";
    $width = 2.0;

    # warn "data: $data";
    my $data2;    # = $data;

    LineData:
    while ((!$InputParsed) && (!$NoData)) {
        $at      = "";
        $from    = "";
        $till    = "";
        $atpos   = "";
        $frompos = "";
        $tillpos = "";
        $points  = "";

        &CheckPreset("LineData");

        if (!&ValidAttributes("LineData")) { &GetData; next; }

        if (defined($LineDefs{"color"})) { $color = $LineDefs{"color"}; }
        if (defined($LineDefs{"layer"})) { $layer = $LineDefs{"layer"}; }
        if (defined($LineDefs{"width"})) { $width = $LineDefs{"width"}; }
        if (defined($LineDefs{"frompos"})) {
            $frompos = $LineDefs{"frompos"};
        }
        if (defined($LineDefs{"tillpos"})) {
            $tillpos = $LineDefs{"tillpos"};
        }
        if (defined($LineDefs{"atpos"})) { $atpos = $LineDefs{"atpos"}; }

        foreach my $attribute (keys %Attributes) {
            my $attrvalue = $Attributes{$attribute};

            if ($attribute =~ /^(?:At|From|Till)$/i) {
                if ($attrvalue =~ /^Start$/i) {
                    $attrvalue = $Period{"from"};
                }

                if ($attrvalue =~ /^End$/i) { $attrvalue = $Period{"till"}; }

                if (!&ValidDateFormat($attrvalue)) {
                    &Error(   "LineData attribute '$attribute' invalid.\n"
                            . "Date does not conform to specified DateFormat '$DateFormat'."
                    );
                    &GetData;
                    next LineData;
                }

                if (!&ValidDateRange($attrvalue)) {
                    &Error(   "LineData attribute '$attribute' invalid.\n"
                            . "Date '$attrvalue' not within range as specified by command Period."
                    );
                    &GetData;
                    next LineData;
                }

                #       if (substr ($attrvalue,6,4) < 1800)
                #       { &Error ("LineData attribute '$attribute' invalid. Specify year >= 1800.") ;
                #         &GetData ; next LineData ; }

                if ($attribute =~ /At/i) {
                    $at   = $attrvalue;
                    $from = "";
                    $till = "";
                }
                elsif ($attribute =~ /From/i) {
                    $from = $attrvalue;
                    $at   = "";
                }
                else { $till = $attrvalue; $at = ""; }
            }
            elsif ($attribute =~ /^(?:atpos|frompos|tillpos)$/i) {
                if ($attrvalue =~ /^(?:Start|End)$/i) {
                    $attrvalue = lc($attrvalue);
                }
                elsif (!&ValidAbs($attrvalue)) {
                    &Error(   "LineData attribute '$attribute' invalid.\n"
                            . "Specify value as x[.y][px, in, cm] examples: '200', '20px', '1.3in'"
                    );
                    &GetData;
                    next LineData;
                }

                if ($attribute =~ /atpos/i) {
                    $atpos = &Normalize($attrvalue);
                }
                elsif ($attribute =~ /frompos/i) {
                    $frompos = &Normalize($attrvalue);
                }
                else { $tillpos = &Normalize($attrvalue); }
            }
            elsif ($attribute =~ /Color/i) {
                if (   (!&ColorPredefined($attrvalue))
                    && (!defined($Colors{ lc($attrvalue) })))
                {
                    &Error(
                        "LineData  attribute '$attribute' invalid. Unknown color '$attrvalue'.\n"
                            . "  Specify command 'Color' before this command."
                    );
                    &GetData;
                    next LineData;
                }

                if (!&ColorPredefined($attrvalue)) {
                    $attrvalue = $Colors{ lc($attrvalue) };
                }

                $color = $attrvalue;
            }
            elsif ($attribute =~ /Layer/i) {
                if (!($attrvalue =~ /^(?:back|front)$/i)) {
                    &Error(
                        "LineData attribute '$attrvalue' invalid.\nSpecify back(default) or front"
                    );
                    &GetData;
                    next LineData;
                }

                $layer = $attrvalue;
            }
            elsif ($attribute =~ /Points/i) {
                $attribute =~ s/\s//g;

                if ($attrvalue !~ /^$hBrO\d+\,\d+$hBrC$hBrO\d+\,\d+$hBrC$/) {
                    &Error(
                        "LineData attribute '$attrvalue' invalid.\nSpecify 'points:(x1,y1)(x2,y2)'"
                    );
                    &GetData;
                    next LineData;
                }

                $attrvalue =~
                    s/^$hBrO(\d+)\,(\d+)$hBrC$hBrO(\d+)\,(\d+)$hBrC$/$1,$2,$3,$4/;
                $points = $attrvalue;
            }
            elsif ($attribute =~ /Width/i) {
                if (!&ValidAbs($attrvalue)) {
                    &Error(   "LineData attribute '$attribute' invalid.\n"
                            . "Specify value as x[.y][px, in, cm] examples: '200', '20px', '1.3in'"
                    );
                    &GetData;
                    next LineData;
                }

                if (($attrvalue < 0.1) || ($attrvalue > 10)) {
                    &Error(   "LineData attribute '$attribute' invalid.\n"
                            . "Specify value as between 0.1 and 10");
                    &GetData;
                    next LineData;
                }

                $width = $attrvalue;
            }
        }

        if (   ($at eq "")
            && ($from   eq "")
            && ($till   eq "")
            && ($points eq ""))    # upd defaults
        {
            if ($color   ne "") { $LineDefs{"color"}   = $color; }
            if ($layer   ne "") { $LineDefs{"layer"}   = $layer; }
            if ($width   ne "") { $LineDefs{"width"}   = $width; }
            if ($atpos   ne "") { $LineDefs{"atpos"}   = $atpos; }
            if ($frompos ne "") { $LineDefs{"frompos"} = $frompos; }
            if ($tillpos ne "") { $LineDefs{"tillpos"} = $tillpos; }
        }

        if ($layer eq "") { $layer = "back"; }

        if ($color eq "") { $color = "black"; }

        $explanation =
              "\nA line is defined as follows:\n"
            . "  Perpendicular to the time axis: 'at frompos tillpos'\n"
            . "  Parralel to the time axis: 'from till atpos'\n"
            . "  Any direction: points(x1,y1)(x2,y2)\n"
            . "  at,from,till expect date/time values, just like with command PlotData\n"
            . "  frompos,tillpos,atpos,x1,x2,y1,y2 expect coordinates (e.g. pixels values)\n";

        if (   ($at ne "")
            && (($from ne "") || ($till ne "") || ($points ne "")))
        {
            &Error(
                "LineData attribute 'at' can not be combined with 'from', 'till' or 'points'\n"
                    . $explanation);
            $explanation = "";
            &GetData;
            next LineData;
        }

        if (   (($from ne "") && ($till eq ""))
            || (($from eq "") && ($till ne "")))
        {
            &Error(
                "LineData attributes 'from' and 'till' should always be specified together\n"
                    . $explanation);
            $explanation = "";
            &GetData;
            next LineData;
        }

        if (   ($points ne "")
            && (($from ne "") || ($till ne "") || ($at ne "")))
        {
            &Error(
                "LineData attribute 'points' can not be combined with 'at', 'from' or 'till'\n"
                    . $explanation);
            $explanation = "";
            &GetData;
            next LineData;
        }

        if ($at ne "") {
            push @DrawLines,
                sprintf("1|%s|%s|%s|%s|%s|%s\n",
                $at, $frompos, $tillpos, lc($color), $width, lc($layer));
        }

        if ($from ne "") {
            push @DrawLines,
                sprintf("2|%s|%s|%s|%s|%s|%s\n",
                $atpos, $from, $till, lc($color), $width, lc($layer));
        }

        if ($points ne "") {
            push @DrawLines,
                sprintf("3|%s|%s|%s|%s\n",
                $points, lc($color), $width, lc($layer));
        }
        &GetData;
    }
}

sub ParseImageSize {
    if (!&ValidAttributes("ImageSize")) { return; }

    &CheckPreset("ImageSize");

    foreach my $attribute (keys %Attributes) {
        my $attrvalue = $Attributes{$attribute};

        if ($attribute =~ /Width|Height/i) {
            if ($attrvalue !~ /auto/i) {
                if (!&ValidAbs($attrvalue)) {
                    &Error(   "ImageSize attribute '$attribute' invalid.\n"
                            . "Specify value as x[.y][px, in, cm] examples: '200', '20px', '1.3in'"
                    );
                    return;
                }
            }
        }
        elsif ($attribute =~ /BarIncrement/i) {
            if (!&ValidAbs($attrvalue)) {
                &Error(   "ImageSize attribute '$attribute' invalid.\n"
                        . "Specify value as x[.y][px, in, cm] examples: '200', '20px', '1.3in'"
                );
                return;
            }

            $Attributes{"barinc"} = $attrvalue;
        }
    }

    if (   ($Attributes{"width"} =~ /auto/i)
        || ($Attributes{"height"} =~ /auto/i))
    {
        if ($Attributes{"barinc"} eq "") {
            &Error(   "ImageSize attribute 'barincrement' missing.\n"
                    . "Automatic determination of image width or height implies specification of this attribute"
            );
            return;
        }
    }

    if (   ($Attributes{"width"} !~ /auto/i)
        && ($Attributes{"height"} !~ /auto/i))
    {
        if ($Attributes{"barinc"} ne "") {
            &Error(   "ImageSize attribute 'barincrement' not valid now.\n"
                    . "This attribute is only valid (and mandatory) in combination with 'width:auto' or 'height:auto'"
            );
            return;
        }
    }

    %Image = %Attributes;
}

sub ParseLegend {
    if (!&ValidAttributes("Legend")) { return; }

    &CheckPreset("Legend");

    foreach my $attribute (keys %Attributes) {
        my $attrvalue = $Attributes{$attribute};

        if ($attribute =~ /Columns/i) {
            if (($attrvalue < 1) || ($attrvalue > 4)) {
                &Error(
                    "Legend attribute 'columns' invalid. Specify 1,2,3 or 4");
                return;
            }
        }
        elsif ($attribute =~ /Orientation/i) {
            if (!($attrvalue =~ /^(?:hor|horizontal|ver|vertical)$/i)) {
                &Error(
                    "Legend attribute '$attrvalue' invalid. Specify hor[izontal] or ver[tical]"
                );
                return;
            }

            $Attributes{"orientation"} = substr($attrvalue, 0, 3);
        }
        elsif ($attribute =~ /Position/i) {
            if (!($attrvalue =~ /^(?:top|bottom|right)$/i)) {
                &Error(
                    "Legend attribute '$attrvalue' invalid.\nSpecify top, bottom or right"
                );
                return;
            }
        }
        elsif ($attribute =~ /Left/i) {
            if (!&ValidAbsRel($attrvalue)) {
                &Error(
                    "Legend attribute '$attribute' invalid.\nSpecify value as x[.y][px, in, cm] examples: '200', '20px', '1.3in'"
                );
                return;
            }
        }
        elsif ($attribute =~ /Top/i) {
            if (!&ValidAbsRel($attrvalue)) {
                &Error(
                    "Legend attribute '$attribute' invalid.\nSpecify value as x[.y][px, in, cm] examples: '200', '20px', '1.3in'"
                );
                return;
            }
        }
        elsif ($attribute =~ /ColumnWidth/i) {
            if (!&ValidAbsRel($attrvalue)) {
                &Error(
                    "Legend attribute '$attribute' invalid.\nSpecify value as x[.y][px, in, cm] examples: '200', '20px', '1.3in'"
                );
                return;
            }
        }
    }

    if (defined($Attributes{"position"})) {
        if (defined($Attributes{"left"})) {
            &Error(
                "Legend definition invalid. Attributes 'position' and 'left' are mutually exclusive."
            );
            return;
        }
    }
    else {
        if ((!defined($Attributes{"left"})) && (!defined($Attributes{"top"})))
        {
            &Info(
                "Legend definition: none of attributes 'position', 'left' or 'top' have been defined. Position 'bottom' assumed."
            );
            $Attributes{"position"} = "bottom";
        }
        elsif ((!defined($Attributes{"left"}))
            || (!defined($Attributes{"top"})))
        {
            &Error(
                "Legend definition invalid. Specify 'position', or 'left' & 'top'."
            );
            return;
        }
    }

    if ($Attributes{"position"} =~ /right/i) {
        if (defined($Attributes{"columns"})) {
            &Error(
                "Legend definition invalid.\nAttribute 'columns' and 'position:right' are mutually exclusive."
            );
            return;
        }
        if (defined($Attributes{"columnwidth"})) {
            &Error(
                "Legend definition invalid.\nAttribute 'columnwidth' and 'position:right' are mutually exclusive."
            );
            return;
        }
    }

    if ($Attributes{"orientation"} =~ /hor/i) {
        if ($Attributes{"position"} =~ /right/i) {
            &Error(
                "Legend definition invalid.\n'position:right' and 'orientation:horizontal' are mutually exclusive."
            );
            return;
        }
        if (defined($Attributes{"columns"})) {
            &Error(
                "Legend definition invalid.\nAttribute 'columns' and 'orientation:horizontal' are mutually exclusive."
            );
            return;
        }
        if (defined($Attributes{"columnwidth"})) {
            &Error(
                "Legend definition invalid.\nAttribute 'columnwidth' and 'orientation:horizontal' are mutually exclusive."
            );
            return;
        }
    }

    if (   ($Attributes{"orientation"} =~ /hor/i)
        && (defined($Attributes{"columns"})))
    {
        &Error(
            "Legend definition invalid.\nDo not specify attribute 'columns' with 'orientation:horizontal'."
        );
        return;
    }

    if ($Attributes{"columns"} > 1) {
        if (   (defined($Attributes{"left"}))
            && (!defined($Attributes{"columnwidth"})))
        {
            &Error(
                "Legend attribute 'columnwidth' not defined.\nThis is needed when attribute 'left' is specified."
            );
            return;
        }
    }

    if (!defined($Attributes{"orientation"})) {
        $Attributes{"orientation"} = "ver";
    }

    %Legend = %Attributes;
}

sub ParsePeriod {
    if (!defined($DateFormat)) {
        &Error(
            "Period definition ambiguous. No (valid) command 'DateFormat' specified in previous lines."
        );
        return;
    }

    if (!ValidAttributes("Period")) { return; }

    foreach my $attribute (keys %Attributes) {
        my $attrvalue = $Attributes{$attribute};

        if ($DateFormat eq "yyyy") {
            if ($attrvalue !~ /^\-?\d+$/) {
                &Error(
                    "Period definition invalid.\nInvalid year '$attrvalue' specified for attribute '$attribute'."
                );
                return;
            }
        }
        elsif ($DateFormat eq "x.y") {
            if (!($attrvalue =~ /^\-?\d+(?:\.\d+)?$/)) {
                &Error(
                    "Period definition invalid.\nInvalid year '$attrvalue' specified for attribute '$attribute'."
                );
                return;
            }
        }
        else {
            if (   ($attrvalue =~ /^\d+$/)
                && ($attrvalue >= 1800)
                && ($attrvalue <= 2030))
            {
                if ($attribute =~ /^From$/i) {
                    $attrvalue = "01/01/" . $attrvalue;
                }
                if ($attribute =~ /^Till$/i) {
                    if ($DateFormat eq "dd/mm/yyyy") {
                        $attrvalue = "31/12/" . $attrvalue;
                    }
                    else { $attrvalue = "12/31/" . $attrvalue; }
                }
            }

            if (!&ValidDateFormat($attrvalue)) {
                &Error(   "Period attribute '$attribute' invalid.\n"
                        . "Date does not conform to specified DateFormat '$DateFormat'."
                );
                return;
            }
            if (substr($attrvalue, 6, 4) < 1800) {
                &Error(
                    "Period attribute '$attribute' invalid. Specify year >= 1800."
                );
                return;
            }

            $Attributes{$attribute} = $attrvalue;
        }
    }

    %Period = %Attributes;
}

sub ParsePlotArea {
    if (!&ValidAttributes("PlotArea")) {
        return;
    }

    &CheckPreset("PlotArea");

    foreach my $attribute (@Attributes) {
        my $attrvalue = $Attributes{$attribute};
        if (!&ValidAbsRel($attrvalue)) {
            &Error(   "PlotArea attribute '$attribute' invalid.\n"
                    . "Specify value as x[.y][px, in, cm, %] examples: '200', '20px', '1.3in', '80%'"
            );
            return;
        }
    }

    if (($Attributes{"top"} ne "") && ($Attributes{"height"} ne "")) {
        &Error(
            "PlotArea attributes 'top' and 'height' are mutually exclusive. Specify only one of them."
        );
        return;
    }

    if (($Attributes{"right"} ne "") && ($Attributes{"width"} ne "")) {
        &Error(
            "PlotArea attributes 'right' and 'width' are mutually exclusive. Specify only one of them."
        );
        return;
    }

    if (($Attributes{"top"} eq "") && ($Attributes{"height"} eq "")) {
        &Error(
            "PlotArea definition incomplete. Either attribute 'top' (advised) or 'height' should be specified"
        );
        return;
    }

    if (($Attributes{"right"} eq "") && ($Attributes{"width"} eq "")) {
        &Error(
            "PlotArea definition incomplete. Either attribute 'right' (advised) or 'width' should be specified"
        );
        return;
    }

    %PlotArea = %Attributes;
}

#                         command Bars found ?
#                  Y                |                   N
#             bar: found ?          |               bar: found ?
#        Y | N                      |              Y | N
# validate | previous bar: found?   | @Bars contains | previous bar: found?
#   bar:.. |                        |        bar: ?  |    Y | N
#          |     Y | N              |                | copy | assume
#          | copy  |  $#Bars ..     | Y  | N         | bar: | bar:---
#          |  bar: |== 0            | -  | assume    |      |
#          |       | assume bar:--- |    |  bar:---  |      |
#          |       |== 1            |
#          |       | assume $Bar[0] |
#          |       |> 1             |
#          |       | err            |
sub ParsePlotData {
    my $attrvalue2;
    my $BarsCommandFound = @Bars;
    my $prevbar          = "";
    my $barndx;

    if (   (!(defined($DateFormat)))
        || ($Period{"from"} eq "")
        || ($Axis{"time"}   eq ""))
    {
        if (!(defined($DateFormat))) {
            &Error(
                "PlotData invalid. No (valid) command 'DateFormat' specified in previous lines."
            );
        }
        elsif ($Period{"from"} eq "") {
            &Error(
                "PlotData invalid. No (valid) command 'Period' specified in previous lines."
            );
        }
        else {
            &Error(
                "PlotData invalid. No (valid) command 'TimeAxis' specified in previous lines."
            );
        }

        &GetData;
        while ((!$InputParsed) && (!$NoData)) { &GetData; }
        return;
    }

    &GetData;
    if ($NoData) {
        &Error(
            "Data expected for command 'PlotData', but line is not indented.\n"
        );
        return;
    }

    my (
        $bar,     $at,        $from,     $till,   $color,
        $bgcolor, $textcolor, $fontsize, $width,  $text,
        $anchor,  $align,     $shift,    $shiftx, $shifty,
        $mark,    $markcolor, $link,     $hint
    );

    $PlotDefs{"anchor"} = "middle";

    PlotData:
    while ((!$InputParsed) && (!$NoData)) {
        if (!&ValidAttributes("PlotData")) { &GetData; next; }

        $bar       = "";
        $at        = "";
        $from      = "";
        $till      = "";
        $color     = "barcoldefault";
        $bgcolor   = "";
        $textcolor = "black";
        $fontsize  = "S";
        $width     = "0.25";
        $text      = "";
        $align     = "left";
        $shift     = "";
        $shiftx    = "";
        $shifty    = "";
        $anchor    = "";
        $mark      = "";
        $markcolor = "";
        $link      = "";
        $hint      = "";

        &CheckPreset("PlotData");

        if (defined($PlotDefs{"bar"})) { $bar = $PlotDefs{"bar"}; }

        if (defined($PlotDefs{"color"})) { $color = $PlotDefs{"color"}; }
        if (defined($PlotDefs{"bgcolor"})) {
            $bgcolor = $PlotDefs{"bgcolor"};
        }
        if (defined($PlotDefs{"textcolor"})) {
            $textcolor = $PlotDefs{"textcolor"};
        }
        if (defined($PlotDefs{"fontsize"})) {
            $fontsize = $PlotDefs{"fontsize"};
        }
        if (defined($PlotDefs{"width"}))  { $width  = $PlotDefs{"width"}; }
        if (defined($PlotDefs{"anchor"})) { $anchor = $PlotDefs{"anchor"}; }
        if (defined($PlotDefs{"align"}))  { $align  = $PlotDefs{"align"}; }
        if (defined($PlotDefs{"shiftx"})) { $shiftx = $PlotDefs{"shiftx"}; }
        if (defined($PlotDefs{"shifty"})) { $shifty = $PlotDefs{"shifty"}; }
        if (defined($PlotDefs{"mark"}))   { $mark   = $PlotDefs{"mark"}; }
        if (defined($PlotDefs{"markcolor"})) {
            $markcolor = $PlotDefs{"markcolor"};
        }

        #   if (defined ($PlotDefs{"link"}))      { $link      = $PlotDefs{"link"} ; }
        #   if (defined ($PlotDefs{"hint"}))      { $hint      = $PlotDefs{"hint"} ; }

        foreach my $attribute (keys %Attributes) {
            my $attrvalue = $Attributes{$attribute};

            if ($attribute =~ /^Bar$/i) {
                if (!($attrvalue =~ /[a-zA-Z0-9\_]+/)) {
                    &Error(   "PlotData attribute '$attribute' invalid.\n"
                            . "Use only characters 'a'-'z', 'A'-'Z', '0'-'9', '_'\n"
                    );
                    &GetData;
                    next PlotData;
                }

                $attrvalue2 = $attrvalue;

                if ($BarsCommandFound) {
                    if (!&BarDefined($attrvalue2)) {
                        &Error(
                            "PlotData invalid. Bar '$attrvalue' not (properly) defined."
                        );
                        &GetData;
                        next PlotData;
                    }
                }
                else {
                    if (!&BarDefined($attrvalue2)) {
                        if ($Axis{"time"} eq "x") {
                            push @Bars, $attrvalue2;
                        }
                        else {
                            unshift @Bars, $attrvalue2;
                        }
                    }
                }
                $bar     = $attrvalue2;
                $prevbar = $bar;
            }
            elsif ($attribute =~ /^BarSet$/i) {
                if (!($attrvalue =~ /[a-zA-Z0-9\_]+/)) {
                    &Error(   "PlotData attribute '$attribute' invalid.\n"
                            . "Use only characters 'a'-'z', 'A'-'Z', '0'-'9', '_'\n"
                    );
                    &GetData;
                    next PlotData;
                }

                $attrvalue2 = $attrvalue;

                if ($attrvalue =~ /break/i) {
                    $barndx = 0;
                }
                elsif ($attrvalue =~ /skip/i) {
                    $barndx++;
                    &BarDefined($prevbar . "#" . $barndx);
                }
                else {
                    if ($BarsCommandFound) {
                        if (!&BarDefined($attrvalue2 . "#1")) {
                            &Error(
                                "PlotData invalid. BarSet '$attrvalue' not (properly) defined with command BarData."
                            );
                            &GetData;
                            next PlotData;
                        }
                    }
                    $bar = $attrvalue2;
                    if ($bar ne $prevbar) { $barndx = 0; }
                    $prevbar = $bar;
                }
            }
            elsif ($attribute =~ /^(?:At|From|Till)$/i) {
                if ($attrvalue =~ /^Start$/i) {
                    $attrvalue = $Period{"from"};
                }
                if ($attrvalue =~ /^End$/i) { $attrvalue = $Period{"till"}; }

                if (!&ValidDateFormat($attrvalue)) {
                    &Error(   "PlotData attribute '$attribute' invalid.\n"
                            . "Date '$attrvalue' does not conform to specified DateFormat $DateFormat."
                    );
                    &GetData;
                    next PlotData;
                }

                if (!&ValidDateRange($attrvalue)) {
                    &Error(   "Plotdata attribute '$attribute' invalid.\n"
                            . "Date '$attrvalue' not within range as specified by command Period."
                    );

                    &GetData;
                    next PlotData;
                }

                if    ($attribute =~ /^At$/i)   { $at   = $attrvalue; }
                elsif ($attribute =~ /^From$/i) { $from = $attrvalue; }
                else                            { $till = $attrvalue; }
            }

            #      elsif ($attribute =~ /^From$/i)
            #      {
            #        if ($attrvalue =~ /^Start$/i)
            #        { $attrvalue = $Period{"from"} ; }

            #        if (! &ValidDateFormat ($attrvalue))
            #        { &Error ("PlotData invalid.\nDate '$attrvalue' does not conform to specified DateFormat $DateFormat.") ;
            #          &GetData ; next PlotData ; }

            #        if (! &ValidDateRange ($attrvalue))
            #        { &Error ("Plotdata attribute 'from' invalid.\n" .
            #                  "Date '$attrvalue' not within range as specified by command Period.") ;
            #          &GetData ; next PlotData ; }

            #        $from = $attrvalue ;
            #      }
            #      elsif ($attribute =~ /^Till$/i)
            #      {
            #        if ($attrvalue =~ /^End$/i)
            #        { $attrvalue = $Period{"till"} ; }

            #        if (! &ValidDateFormat ($attrvalue))
            #        { &Error ("PlotData invalid. Date '$attrvalue' does not conform to specified DateFormat $DateFormat.") ;
            #          &GetData ; next PlotData ; }

            #        if (! &ValidDateRange ($attrvalue))
            #        { &Error ("Plotdata attribute 'till' invalid.\n" .
            #                  "Date '$attrvalue' not within range as specified by command Period.") ;
            #          &GetData ; next PlotData ; }

            #        $till = $attrvalue ;
            #      }
            elsif ($attribute =~ /^Color$/i) {
                if (!&ColorPredefined($attrvalue)) {
                    if (!defined($Colors{ lc($attrvalue) })) {
                        &Error(
                            "PlotData invalid. Attribute '$attribute' has unknown color '$attrvalue'.\n"
                                . "  Specify command 'Color' before this command."
                        );
                        &GetData;
                        next PlotData;
                    }
                }
                if (defined($Colors{ lc($attrvalue) })) {
                    $color = $Colors{ lc($attrvalue) };
                }
                else { $color = lc($attrvalue); }

                $color = $attrvalue;
            }
            elsif ($attribute =~ /^BgColor$/i) {
                if (!&ColorPredefined($attrvalue)) {
                    if (!defined($Colors{ lc($attrvalue) })) {
                        &Error(
                            "PlotData invalid. Attribute '$attribute' has unknown color '$attrvalue'.\n"
                                . "  Specify command 'Color' before this command."
                        );
                        &GetData;
                        next PlotData;
                    }
                }
                if (defined($Colors{ lc($attrvalue) })) {
                    $bgcolor = $Colors{ lc($attrvalue) };
                }
                else { $bgcolor = lc($attrvalue); }
            }
            elsif ($attribute =~ /^TextColor$/i) {
                if (!&ColorPredefined($attrvalue)) {
                    if (!defined($Colors{ lc($attrvalue) })) {
                        &Error(
                            "PlotData invalid. Attribute '$attribute' contains unknown color '$attrvalue'.\n"
                                . "  Specify command 'Color' before this command."
                        );
                        &GetData;
                        next PlotData;
                    }
                }
                if (defined($Colors{ lc($attrvalue) })) {
                    $textcolor = $Colors{ lc($attrvalue) };
                }
                else { $textcolor = lc($attrvalue); }
            }
            elsif ($attribute =~ /^Width$/i) {
                $width = &Normalize($attrvalue);
                if ($width > $MaxBarWidth) { $MaxBarWidth = $width; }
            }
            elsif ($attribute =~ /^FontSize$/i) {
                if (   ($attrvalue !~ /\d+(?:\.\d)?/)
                    && ($attrvalue !~ /xs|s|m|l|xl/i))
                {
                    &Error(
                        "PlotData invalid. Specify for attribute '$attribute' a number of XS,S,M,L,XL."
                    );
                    &GetData;
                    next PlotData;
                }

                $fontsize = $attrvalue;
                if ($fontsize =~ /(?:XS|S|M|L|XL)/i) {
                    if ($fontsize !~ /(?:xs|s|m|l|xl)/i) {
                        if ($fontsize < 6) {
                            &Warning(
                                "TextData attribute 'fontsize' value too low. Font size 6 assumed.\n"
                            );
                            $fontsize = 6;
                        }
                        if ($fontsize > 30) {
                            &Warning(
                                "TextData attribute 'fontsize' value too high. Font size 30 assumed.\n"
                            );
                            $fontsize = 30;
                        }
                    }
                }
            }
            elsif ($attribute =~ /^Anchor$/i) {
                if (!($attrvalue =~ /^(?:from|till|middle)$/i)) {
                    &Error(
                        "PlotData value '$attribute' invalid. Specify 'from', 'till' or 'middle'."
                    );
                    &GetData;
                    next PlotData;
                }

                $anchor = lc($attrvalue);
            }
            elsif ($attribute =~ /^Align$/i) {
                if (!($attrvalue =~ /^(?:left|right|center)$/i)) {
                    &Error(
                        "PlotData value '$attribute' invalid. Specify 'left', 'right' or 'center'."
                    );
                    &GetData;
                    next PlotData;
                }

                $align = lc($attrvalue);
            }
            elsif ($attribute =~ /^Shift$/i) {
                $shift = $attrvalue;
                $shift =~ s/$hBrO(.*?)$hBrC/$1/;
                $shift =~ s/\s//g;
                my ($shiftx2, $shifty2) = split(",", $shift);
                if ($shiftx2 ne "") { $shiftx = &Normalize($shiftx2); }
                if ($shifty2 ne "") { $shifty = &Normalize($shifty2); }

                if (   ($shiftx < -10)
                    || ($shiftx > 10)
                    || ($shifty < -10)
                    || ($shifty > 10))
                {
                    &Error(
                        "PlotData invalid. Attribute '$shift', specify value(s) between -1000 and 1000 pixels = -10 and 10 inch."
                    );
                    &GetData;
                    next PlotData;
                }
            }
            elsif ($attribute =~ /^Text$/i) {
                $text = &ParseText($attrvalue);
                $text =~ s/\\n/\n/g;
                if ($text =~ /\^/) {
                    &Warning("TextData attribute 'text' contains ^ (caret).\n"
                            . "Caret symbol will not be translated into tab character (use TextData when tabs are needed)"
                    );
                }

                #       $text=~ s/(\[\[ [^\]]* \n [^\]]* \]\])/&NormalizeWikiLink($1)/gxe ;
                $text =~
                    s/(\[\[? [^\]]* \n [^\]]* \]?\])/&NormalizeWikiLink($1)/gxe;
            }
            elsif ($attribute =~ /^Link$/i) {
                $link = &ParseText($attrvalue);
                $link = &EncodeURL(&NormalizeURL($link));
            }

            #     elsif ($attribute =~ /^Hint$/i)
            #     {
            #       $hint = &ParseText ($attrvalue) ;
            #       $hint =~ s/\\n/\n/g ;
            #     }
            elsif ($attribute =~ /^Mark$/i) {
                $attrvalue =~ s/$hBrO (.*) $hBrC/$1/x;
                my (@suboptions) = split(",", $attrvalue);
                $mark = $suboptions[0];
                if (!($mark =~ /^(?:Line|None)$/i)) {
                    &Error(
                        "PlotData invalid. Value '$mark' for attribute 'mark' unknown."
                    );
                    &GetData;
                    next PlotData;
                }

                if (defined($suboptions[1])) {
                    $markcolor = $suboptions[1];

                    if (!&ColorPredefined($markcolor)) {
                        if (!defined($Colors{ lc($markcolor) })) {
                            &Error(
                                "PlotData invalid. Attribute 'mark': unknown color '$markcolor'.\n"
                                    . "  Specify command 'Color' before this command."
                            );
                            &GetData;
                            next PlotData;
                        }
                    }
                    $markcolor = lc($markcolor);
                }
                else { $markcolor = "black"; }
            }
            else {
                &Error(
                    "PlotData invalid. Unknown attribute '$attribute' found."
                );
                &GetData;
                next PlotData;
            }
        }

        #    if ($text =~ /\[\[.*\[\[/s)
        #    { &Error ("PlotData invalid. Text segment '$text' contains more than one wiki link. Only one allowed.") ;
        #      &GetData ; next PlotData ; }

        #    if (($text ne "") || ($link ne ""))
        #    { ($text, $link, $hint) = &ProcessWikiLink ($text, $link, $hint) ; }

        $shift = $shiftx . "," . $shifty;

        if ($MaxBarWidth eq "") { $MaxBarWidth = $width - 0.001; }

        if ($bar ne "") {
            if (!defined($BarLegend{ lc($bar) })) {
                $BarLegend{ lc($bar) } = $bar;
            }
            if (!defined($BarWidths{$bar})) {
                $BarWidths{$bar} = $width;
            }    # was 0 ??
        }

        if (($at eq "") && ($from eq "") && ($till eq ""))    # upd defaults
        {
            if ($bar ne "") { $PlotDefs{"bar"} = $bar; }

            if ($color     ne "") { $PlotDefs{"color"}     = $color; }
            if ($bgcolor   ne "") { $PlotDefs{"bgcolor"}   = $bgcolor; }
            if ($textcolor ne "") { $PlotDefs{"textcolor"} = $textcolor; }
            if ($fontsize  ne "") { $PlotDefs{"fontsize"}  = $fontsize; }
            if ($width     ne "") { $PlotDefs{"width"}     = $width; }
            if ($anchor    ne "") { $PlotDefs{"anchor"}    = $anchor; }
            if ($align     ne "") { $PlotDefs{"align"}     = $align; }
            if ($shiftx    ne "") { $PlotDefs{"shiftx"}    = $shiftx; }
            if ($shifty    ne "") { $PlotDefs{"shifty"}    = $shifty; }
            if ($mark      ne "") { $PlotDefs{"mark"}      = $mark; }
            if ($markcolor ne "") { $PlotDefs{"markcolor"} = $markcolor; }

            &GetData;
            next PlotData;
        }

        if ($bar eq "") {
            if ($prevbar ne "") { $bar = $prevbar; }
            else {

                #        if ($BarsCommandFound)
                #        {
                if ($#Bars > 0) {
                    &Error("PlotData invalid. Specify attribute 'bar'.");
                    &GetData;
                    next PlotData;
                }
                elsif ($#Bars == 0) {
                    $bar = $Bars[0];

                    # warn "data: $data";
                    &Info(
                        q(),    # $data,
                        "PlotData incomplete. Attribute 'bar' missing, value '"
                            . $Bars[0]
                            . "' assumed."
                    );
                }
                else { $bar = "1"; }

                $prevbar = $bar;
            }
        }

        if (&BarDefined($bar . "#1"))    # bar is actually a bar set
        {
            if (($from ne "") || ($at ne "") || ($text eq " "))  # data line ?
            {
                $barndx++;
                if (!&BarDefined($bar . "#" . $barndx)) { $barndx = 1; }
                $bar = $bar . "#" . $barndx;

                # $text = $bar ;
            }
        }

        if (($at ne "") && (($from ne "") || ($till ne ""))) {
            &Error(
                "PlotData invalid. Attributes 'at' and 'from/till' are mutually exclusive."
            );
            &GetData;
            next PlotData;
        }

        if (   (($from eq "") && ($till ne ""))
            || (($from ne "") && ($till eq "")))
        {
            &Error(
                "PlotData invalid. Specify attribute 'at' or 'from' + 'till'."
            );
            &GetData;
            next PlotData;
        }

        if ($at ne "") {
            if ($text ne "") {
                if ($align eq "") {
                    &Error("PlotData invalid. Attribute 'align' missing.");
                    &GetData;
                    next PlotData;
                }
                if ($fontsize eq "") {
                    &Error(
                        "PlotData invalid. Attribute '[font]size' missing.");
                    &GetData;
                    next PlotData;
                }
                if ($text eq "") {
                    &Error("PlotData invalid. Attribute 'text' missing.");
                    &GetData;
                    next PlotData;
                }
            }
        }
        else {
            if (($text ne "") && ($anchor eq "")) {
                &Error("PlotData invalid. Attribute 'anchor' missing.");
                &GetData;
                next PlotData;
            }
            if ($color eq "") {
                &Error("PlotData invalid. Attribute 'color' missing.");
                &GetData;
                next PlotData;
            }
            if ($width eq "") {
                &Error("PlotData invalid. Attribute 'width' missing.");
                &GetData;
                next PlotData;
            }
        }

        if ($from ne "") {
            if (($link ne "") && ($hint eq "")) {
                $hint = &ExternalLinkToHint($link);
            }

            if (($link ne "") || ($hint ne "")) { $MapPNG = $true; }
            if ($link ne "") { $MapSVG = $true; }

            push @PlotBars,
                sprintf("%6.3f,%s,%s,%s,%s,%s,%s,\n",
                $width, $bar, $from, $till, lc($color), $link, $hint);
            if ($width > $BarWidths{$bar}) { $BarWidths{$bar} = $width; }

            if ($text ne "") {
                if    ($anchor eq "from") { $at = $from; }
                elsif ($anchor eq "till") { $at = $till; }
                else                      { $at = &DateMedium($from, $till); }
            }

            if (($mark ne "") && ($mark !~ /none/i)) {
                push @PlotLines,
                    sprintf("%s,%s,%s,%s,,,\n",
                    $bar, $from, $from, lc($markcolor));
                push @PlotLines,
                    sprintf("%s,%s,%s,%s,,,\n",
                    $bar, $till, $till, lc($markcolor));
                $mark = "";
            }
        }

        if ($at ne "") {
            if (($mark ne "") && ($mark !~ /none/i)) {
                push @PlotLines,
                    sprintf("%s,%s,%s,%s,,,\n",
                    $bar, $at, $at, lc($markcolor));
            }

            if ($text ne "") {
                my $textdetails = "";

                if ($link ne "") {
                    if ($text =~ /\[.*\]/) {
                        &Warning(
                            "PlotData contains implicit link(s) in attribute 'text' and explicit attribute 'link'. "
                                . "Implicit link(s) ignored.");
                        $text =~ s/\[+ (?:[^\|]* \|)? ([^\]]*) \]+/$1/gx;
                    }
                    if ($hint eq "") { $hint = &ExternalLinkToHint($link); }
                }

                if ($anchor   eq "") { $anchor   = "middle"; }
                if ($align    eq "") { $align    = "center"; }
                if ($color    eq "") { $color    = "black"; }
                if ($fontsize eq "") { $fontsize = "S"; }

                $text      =~ s/\,/\#\%\$/g;
                $link      =~ s/\,/\#\%\$/g;
                $hint      =~ s/\,/\#\%\$/g;
                $shift     =~ s/\,/\#\%\$/g;
                $textcolor =~ s/\,/\#\%\$/g;
                push @PlotText,
                    sprintf(
                    "%s,%s,%s,%s,%s,%s,%s,%s,%s",
                    $at,        $bar,      $text,
                    $textcolor, $fontsize, $align,
                    $shift,     $link,     $hint
                    );
            }
        }

        &GetData;
    }

    if ((!$BarsCommandFound) && ($#Bars > 1)) {
        &Info2(
            "PlotBars definition: no (valid) command 'BarData' found in previous lines.\nBars will presented in order of appearance in PlotData."
        );
    }

    my $maxwidth = 0;
    foreach my $bar_width (keys %BarWidths) {
        if ($BarWidths{$bar_width} == 0) {
            &Warning(
                "PlotData incomplete. No bar width defined for bar '$bar_width', assume width from widest bar (used for line marks)."
            );
        }
        elsif ($BarWidths{$bar_width} > $maxwidth) {
            $maxwidth = $BarWidths{$bar_width};
        }
    }
    foreach my $bar_width (keys %BarWidths) {
        if ($BarWidths{$bar_width} == 0) {
            $BarWidths{$bar_width} = $maxwidth;
        }
    }
}

sub ParsePreset {
    if (!$firstcmd) {
        &Error(
            "Specify 'Preset' command before any other commands, if desired at all.\n"
        );
        return;
    }

    my $preset = $Attributes{"single"};
    if ($preset !~
        /^(?:TimeVertical_OneBar_UnitYear|TimeHorizontal_AutoPlaceBars_UnitYear)$/i
        )
    {
        &Error(   "Preset value invalid.\n"
                . "  At the moment two presets are available:\n"
                . "  TimeVertical_OneBar_UnitYear and TimeHorizontal_AutoPlaceBars_UnitYear\n"
                . "  See also meta.wikipedia.org/wiki/EasyTimeline/Presets");
        return;
    }

    $Preset = $preset;

    if ($Preset =~ /^TimeVertical_OneBar_UnitYear/i) {
        $DateFormat         = "yyyy";
        $AlignBars          = "early";
        $Axis{"format"}     = "yyyy";
        $Axis{"time"}       = "y";
        $PlotArea{"left"}   = 45;
        $PlotArea{"right"}  = 10;
        $PlotArea{"top"}    = 10;
        $PlotArea{"bottom"} = 10;
        push @PresetList, "PlotArea|+|left|" . $PlotArea{"left"};
        push @PresetList, "PlotArea|+|right|" . $PlotArea{"right"};
        push @PresetList, "PlotArea|+|top|" . $PlotArea{"top"};
        push @PresetList, "PlotArea|+|bottom|" . $PlotArea{"bottom"};
        push @PresetList, "PlotArea|-|width";
        push @PresetList, "PlotArea|-|height";
        push @PresetList, "Dateformat|-||yyyy";
        push @PresetList, "TimeAxis|=|format|" . $Axis{"format"};
        push @PresetList, "TimeAxis|=|orientation|vertical";
        push @PresetList, "ScaleMajor|=|unit|year";
        push @PresetList, "ScaleMinor|=|unit|year";
        push @PresetList, "AlignBars|=||early";
        push @PresetList, "PlotData|+|mark|" . $hBrO . "line,white" . $hBrC;
        push @PresetList, "PlotData|+|align|left";
        push @PresetList, "PlotData|+|fontsize|S";
        push @PresetList, "PlotData|+|width|20";
        push @PresetList, "PlotData|+|shift|" . $hBrO . "20,0" . $hBrC;
    }
    elsif ($Preset =~ /TimeHorizontal_AutoPlaceBars_UnitYear/i) {
        $DateFormat                 = "yyyy";
        $AlignBars                  = "justify";
        $Axis{"format"}             = "yyyy";
        $Axis{"time"}               = "x";
        $PlotArea{"left"}           = 25;
        $PlotArea{"right"}          = 25;
        $PlotArea{"top"}            = 15;
        $PlotArea{"bottom"}         = 30;
        $Image{"height"}            = "auto";
        $Image{"barinc"}            = 20;
        $BackgroundColors{"canvas"} = "gray(0.7)";
        $Legend{"orientation"}      = "ver";
        $Legend{"left"}             = $PlotArea{"left"} + 10;
        $Legend{"top"}              = $PlotArea{"bottom"} + 100;
        &StoreColor("canvas", &EncodeInput("gray(0.7)"), "");
        &StoreColor("grid1",  &EncodeInput("gray(0.4)"), "");
        &StoreColor("grid2",  &EncodeInput("gray(0.2)"), "");
        push @PresetList, "ImageSize|=|height|auto";
        push @PresetList, "ImageSize|+|barincrement|20";
        push @PresetList, "PlotArea|+|left|" . $PlotArea{"left"};
        push @PresetList, "PlotArea|+|right|" . $PlotArea{"right"};
        push @PresetList, "PlotArea|+|top|" . $PlotArea{"top"};
        push @PresetList, "PlotArea|+|bottom|" . $PlotArea{"bottom"};
        push @PresetList, "PlotArea|-|width";
        push @PresetList, "PlotArea|-|height";
        push @PresetList, "Dateformat|-||yyyy";
        push @PresetList, "TimeAxis|=|format|" . $Axis{"format"};
        push @PresetList, "TimeAxis|=|orientation|horizontal";
        push @PresetList, "ScaleMajor|=|unit|year";
        push @PresetList, "ScaleMajor|+|grid|grid1";
        push @PresetList, "ScaleMinor|=|unit|year";
        push @PresetList, "AlignBars|=||justify";
        push @PresetList, "Legend|+|orientation|" . $Legend{"orientation"};
        push @PresetList, "Legend|+|left|" . $Legend{"left"};
        push @PresetList, "Legend|+|top|" . $Legend{"top"};
        push @PresetList, "PlotData|+|align|left";
        push @PresetList, "PlotData|+|anchor|from";
        push @PresetList, "PlotData|+|fontsize|M";
        push @PresetList, "PlotData|+|width|15";
        push @PresetList, "PlotData|+|textcolor|black";
        push @PresetList, "PlotData|+|shift|" . $hBrO . "4,-6" . $hBrC;
    }
}

sub ParseScale {
    my ($scale);

    if   ($Command =~ /ScaleMajor/i) { $scale .= 'Major'; }
    else                             { $scale .= 'Minor'; }

    if (!ValidAttributes("Scale" . $scale)) { return; }

    &CheckPreset('Scale' . $scale);

    $Scales{$scale} = $true;

    foreach my $attribute (keys %Attributes) {
        my $attrvalue = $Attributes{$attribute};

        if ($attribute =~ /Grid/i
            ) # preferred gridcolor instead of grid, grid allowed for compatability
        {
            if (   (!&ColorPredefined($attrvalue))
                && (!defined($Colors{ lc($attrvalue) })))
            {
                &Error(
                    "Scale attribute '$attribute' invalid. Unknown color '$attrvalue'.\n"
                        . "  Specify command 'Color' before this command.");
                return;
            }
            $Attributes{ $scale . " grid" } = $attrvalue;
            delete($Attributes{"grid"});
        }
        elsif ($attribute =~ /Text/i) {
            $attrvalue =~ s/\~/\\n/g;
            $attrvalue =~ s/^\"//g;
            $attrvalue =~ s/\"$//g;
            $Attributes{ $scale . " stubs" } = $attrvalue;
        }
        elsif ($attribute =~ /Unit/i) {
            if ($DateFormat eq "yyyy") {
                if (!($attrvalue =~ /^(?:year|years)$/i)) {
                    &Error(
                        "Scale attribute '$attribute' invalid. DateFormat 'yyyy' implies 'unit:year'."
                    );
                    return;
                }
            }
            else {
                if (!($attrvalue =~ /^(?:year|month|day)s?$/i)) {
                    &Error(
                        "Scale attribute '$attribute' invalid. Specify year, month or day."
                    );
                    return;
                }
            }
            $attrvalue =~ s/s$//;
            $Attributes{ $scale . " unit" } = $attrvalue;
            delete($Attributes{"unit"});
        }
        elsif ($attribute =~ /Increment/i) {
            if ((!($attrvalue =~ /^\d+$/i)) || ($attrvalue == 0)) {
                &Error(
                    "Scale attribute '$attribute' invalid. Specify positive integer."
                );
                return;
            }
            $Attributes{ $scale . " inc" } = $attrvalue;
            delete($Attributes{"increment"});
        }
        elsif ($attribute =~ /Start/i) {
            if (!(defined($DateFormat))) {
                &Error(   "Scale attribute '$attribute' invalid.\n"
                        . "No (valid) command 'DateFormat' specified in previous lines."
                );
                return;
            }

            if (   ($DateFormat eq "dd/mm/yyyy")
                || ($DateFormat eq "mm/dd/yyyy"))
            {
                if (   ($attrvalue =~ /^\d+$/)
                    && ($attrvalue >= 1800)
                    && ($attrvalue <= 2030))
                {
                    $attrvalue = "01/01/" . $attrvalue;
                }
            }

            if (!&ValidDateFormat($attrvalue)) {
                &Error(   "Scale attribute '$attribute' invalid.\n"
                        . "Date does not conform to specified DateFormat '$DateFormat'."
                );
                return;
            }

            if (   ($DateFormat =~ /\d\d\/\d\d\/\d\d\d\d/)
                && (substr($attrvalue, 6, 4) < 1800))
            {
                &Error(   "Scale attribute '$attribute' invalid.\n"
                        . " Specify year >= 1800.");
                return;
            }

            if (!&ValidDateRange($attrvalue)) {
                &Error(   "Scale attribute '$attribute' invalid.\n"
                        . "Date '$attrvalue' not within range as specified by command Period."
                );
                return;
            }

            $Attributes{ $scale . " start" } = $attrvalue;
            delete($Attributes{"start"});
        }
        if ($DateFormat eq "yyyy") {
            $Attributes{ $scale . " unit" } = "year";
        }
    }

    foreach my $attribute (keys %Attributes) {
        $Scales{$attribute} = $Attributes{$attribute};
    }
}

sub ParseTextData {
    my ($posx, $posy);
    &GetData;
    if ($NoData) {
        &Error(
            "Data expected for command 'TextData', but line is not indented.\n"
        );
        return;
    }

    my ($pos, $tabs, $fontsize, $lineheight, $textcolor, $text, $link, $hint);

    TextData:
    while ((!$InputParsed) && (!$NoData)) {
        if (!&ValidAttributes("TextData")) { &GetData; next; }

        &CheckPreset("TextData");

        $pos        = "";
        $tabs       = "";
        $fontsize   = "";
        $lineheight = "";
        $textcolor  = "";
        $link       = "";
        $hint       = "";

        if (defined($TextDefs{"tabs"})) { $tabs = $TextDefs{"tabs"}; }
        if (defined($TextDefs{"fontsize"})) {
            $fontsize = $TextDefs{"fontsize"};
        }
        if (defined($TextDefs{"lineheight"})) {
            $lineheight = $TextDefs{"lineheight"};
        }
        if (defined($TextDefs{"textcolor"})) {
            $textcolor = $TextDefs{"textcolor"};
        }

        my $data2;
        ($data2, $text) = &ExtractText($data2);
        @Attributes = split(" ", $data2);

        foreach my $attribute (keys %Attributes) {
            my $attrvalue = $Attributes{$attribute};

            if ($attribute =~ /^FontSize$/i) {
                if (   ($attrvalue !~ /\d+(?:\.\d)?/)
                    && ($attrvalue !~ /^(?:xs|s|m|l|xl)$/i))
                {
                    &Error(
                        "TextData invalid. Attribute '$attribute': specify number of XS,S,M,L,XL."
                    );
                    &GetData;
                    next TextData;
                }

                $fontsize = $attrvalue;

                if ($fontsize !~ /^(?:xs|s|m|l|xl)$/i) {
                    if ($fontsize < 6) {
                        &Warning(
                            "TextData attribute 'fontsize' value too low. Font size 6 assumed.\n"
                        );
                        $fontsize = 6;
                    }
                    if ($fontsize > 30) {
                        &Warning(
                            "TextData attribute 'fontsize' value too high. Font size 30 assumed.\n"
                        );
                        $fontsize = 30;
                    }
                }
            }
            elsif ($attribute =~ /^LineHeight$/i) {
                $lineheight = &Normalize($attrvalue);
                if (($lineheight < -0.4) || ($lineheight > 0.4)) {
                    if (!$bypass) {
                        &Error(   "TextData attribute 'lineheight' invalid.\n"
                                . "Specify value up to 40 pixels = 0.4 inch\n"
                                . "Run with option -b (bypass checks) when this is correct.\n"
                        );
                    }
                }
            }
            elsif ($attribute =~ /^Pos$/i) {
                $attrvalue =~ s/\s*$hBrO (.*) $hBrC\s*/$1/x;
                ($posx, $posy) = split(",", $attrvalue);
                $posx = &Normalize($posx);
                $posy = &Normalize($posy);
                $pos  = "$posx,$posy";
            }
            elsif ($attribute =~ /^Tabs$/i) {
                $tabs = $attrvalue;
            }
            elsif ($attribute =~ /^(?:Color|TextColor)$/i) {
                if (!&ColorPredefined($attrvalue)) {
                    if (!defined($Colors{ lc($attrvalue) })) {
                        &Error(
                            "TextData invalid. Attribute '$attribute' contains unknown color '$attrvalue'.\n"
                                . "  Specify command 'Color' before this command."
                        );
                        &GetData;
                        next TextData;
                    }
                }
                if (defined($Colors{ lc($attrvalue) })) {
                    $textcolor = $Colors{ lc($attrvalue) };
                }
                else { $textcolor = lc($attrvalue); }
            }
            elsif ($attribute =~ /^Text$/i) {
                $text = $attrvalue;
                $text =~ s/\\n/~/gs;
                if ($text =~ /\~/) {
                    &Warning("TextData attribute 'text' contains ~ (tilde).\n"
                            . "Tilde will not be translated into newline character (only in PlotData)"
                    );
                }

            }
            elsif ($attribute =~ /^Link$/i) {
                $link = &ParseText($attrvalue);
                $link = &EncodeURL(&NormalizeURL($link));
            }
        }

        if ($fontsize eq "") { $fontsize = "S"; }

        if ($lineheight eq "") {
            if ($fontsize =~ /^(?:XS|S|M|L|XL)$/i) {
                if    ($fontsize =~ /XS/i) { $lineheight = 0.11; }
                elsif ($fontsize =~ /S/i)  { $lineheight = 0.13; }
                elsif ($fontsize =~ /M/i)  { $lineheight = 0.155; }
                elsif ($fontsize =~ /XL/i) { $lineheight = 0.24; }
                else                       { $lineheight = 0.19; }
            }
            else {
                $lineheight = sprintf("%.2f", (($fontsize * 1.2) / 100));
                if ($lineheight < $fontsize / 100 + 0.02) {
                    $lineheight = $fontsize / 100 + 0.02;
                }
            }
        }

        if ($textcolor eq "") { $textcolor = "black"; }

        if ($pos eq "") {
            $pos = $TextDefs{"pos"};
            ($posx, $posy) = split(",", $pos);
            $posy -= $lineheight;
            if ($posy < 0) { $posy = 0; }
            $pos = "$posx,$posy";
            $TextDefs{"pos"} = $pos;
        }

        if ($text eq "")    # upd defaults
        {
            if ($pos        ne "") { $TextDefs{"pos"}        = $pos; }
            if ($tabs       ne "") { $TextDefs{"tabs"}       = $tabs; }
            if ($fontsize   ne "") { $TextDefs{"fontsize"}   = $fontsize; }
            if ($textcolor  ne "") { $TextDefs{"textcolor"}  = $textcolor; }
            if ($lineheight ne "") { $TextDefs{"lineheight"} = $lineheight; }
            &GetData;
            next TextData;
        }

        if ($link ne "") {
            if ($text =~ /\[.*\]/) {
                &Warning(
                    "TextData contains implicit link(s) in attribute 'text' and explicit attribute 'link'.\n"
                        . "Implicit link(s) ignored.");
                $text =~ s/\[+ (?:[^\|]* \|)? ([^\]]*) \]+/$1/gx;
            }

            if ($hint eq "") { $hint = &ExternalLinkToHint($link); }
        }

        if ($text =~ /\[ [^\]]* \^ [^\]]* \]/x) {
            &Warning(
                "TextData attribute 'text' contains tab character (^) inside implicit link ([[..]]). Tab ignored."
            );
            $text =~
                s/(\[+ [^\]]* \^ [^\]]* \]+)/($a = $1), ($a =~ s+\^+ +g), $a/gxe;
        }

        if (defined($tabs) && ($tabs ne "")) {
            $tabs =~ s/^\s*$hBrO (.*) $hBrC\s*$/$1/x;
            my @Tabs = split(",", $tabs);
            foreach my $tab (@Tabs) {
                $tab =~ s/\s* (.*) \s*$/$1/x;
                if (!($tab =~ /\d+\-(?:center|left|right)$/)) {
                    &Error(
                        "Specify attribute 'tabs' as 'n-a,n-a,n-a,.. where n = numeric value, a = left|right|center."
                    );
                    while ((!$InputParsed) && (!$NoData)) { &GetData; }
                    return;
                }
            }

            my @Text = split('\^', $text);
            if ($#Text > $#Tabs + 1) {
                &Error(   "TextData invalid. " 
                        . $#Text
                        . " tab characters ('^') in text, only "
                        . ($#Tabs + 1)
                        . " tab(s) defined.");
                &GetData;
                next TextData;
            }
        }

        &WriteText(
            "^",    "",    0,          $posx,
            $posy,  $text, $textcolor, $fontsize,
            "left", $link, $hint,      $tabs
        );

        &GetData;
    }
}

sub ParseTimeAxis {
    if (!&ValidAttributes("TimeAxis")) { return; }

    &CheckPreset("TimeAxis");

    foreach my $attribute (keys %Attributes) {
        my $attrvalue = $Attributes{$attribute};

        if ($attribute =~ /Format/i) {
            if ($attrvalue =~ /^yy$/i) {
                &Error(
                    "TimeAxis attribute '$attribute' valid but not available, waiting for bug fix.\n"
                        . "Please specify 'format:yyyy' instead of 'format:yy'."
                );
                return;
            }

            if ($DateFormat eq "yyyy") {
                if (!($attrvalue =~ /^(?:yy|yyyy)$/i)) {
                    &Error(   "TimeAxis attribute '$attribute' invalid.\n"
                            . "DateFormat 'yyyy' implies 'format:yy' or 'format:yyyy'."
                    );
                    return;
                }
            }
        }

        elsif ($attribute =~ /Order/i) {
            if ($attrvalue !~ /^(?:normal|reverse)$/i) {
                &Error(   "TimeAxis attribute '$attribute' invalid.\n"
                        . "  Specify 'order:normal' (default) or 'order:reverse'\n"
                        . "  normal =\n"
                        . "  vertical axis: highest date on top,\n"
                        . "  horizontal axis: highest date at right side\n");
                return;
            }

            if (($attrvalue =~ /reverse/i) && ($DateFormat ne "yyyy")) {
                &Error(   "TimeAxis attribute '$attribute' invalid.\n"
                        . "  'order:reverse' is only possible with DateFormat=yyyy (sorry)\n"
                );
                return;
            }

            $Attributes{"order"} = lc($attrvalue);
        }

        elsif ($attribute =~ /Orientation/i) {
            if ($attrvalue =~ /^hor(?:izontal)?$/i) {
                $Attributes{"time"} = "x";
            }
            elsif ($attrvalue =~ /^ver(?:tical)?$/i) {
                $Attributes{"time"} = "y";
            }
            else {
                &Error(   "TimeAxis attribute '$attribute' invalid.\n"
                        . "Specify hor[izontal] or ver[tical]");
                return;
            }
            delete($Attributes{"orientation"});
        }
    }

    if (!defined($Attributes{"format"})) { $Attributes{"format"} = "yyyy"; }

    %Axis = %Attributes;
}

sub ParseUnknownCommand {
    my $name = $Command;
    $name =~ s/[^a-zA-Z].*$//;
    &Error("Command '$name' unknown.");
}

sub RemoveSpaces {
    my $text = shift;
    $text =~ s/\s//g;
    return ($text);
}

sub DetectMissingCommands {
    if (!%Image) {
        &Error2("Command ImageSize missing or invalid");
    }
    if (!%PlotArea) {
        &Error2("Command PlotArea missing or invalid");
    }
    if (!$DateFormat) {
        &Error2("Command DateFormat missing or invalid");
    }
    if (!$Axis{"time"}) {
        &Error2("Command TimeAxis missing or invalid");
    }

    if (($Image{"width"} =~ /auto/i) && ($Axis{"time"} =~ /x/i)) {
        &Error2(
            "ImageSize value 'width:auto' only allowed with TimeAxis value 'orientation:vertical'"
        );
    }
    if (($Image{"height"} =~ /auto/i) && ($Axis{"time"} =~ /y/i)) {
        &Error2(
            "ImageSize value 'height:auto' only allowed with TimeAxis value 'orientation:horizontal'"
        );
    }
}

sub Normalize {
    my $number    = shift;
    my $reference = shift;
    my ($val, $dim);

    if (($number eq "") || ($number =~ /auto/i)) { return ($number); }

    $val = $number;
    $val =~ s/[^\d\.\-].*$//g;
    $dim = $number;
    $dim =~ s/\d//g;
    if    ($dim =~ /in/i) { $number = $val; }
    elsif ($dim =~ /cm/i) { $number = $val / 2.54; }
    elsif ($dim =~ /%/)   { $number = $reference * $val / 100; }
    else                  { $number = $val / 100; }
    return (sprintf("%.3f", $number));
}

sub ValidateAndNormalizeDimensions {
    my ($val, $dim);

    if ($Image{"width"} =~ /auto/i) {
        foreach my $attribute ("width", "left", "right") {
            if ($PlotArea{$attribute} =~ /\%/) {
                &Error2(  "You specified 'ImageSize = width:auto'.\n"
                        . "  This implies absolute values in PlotArea attributes 'left', 'right' and/or 'width' (no \%).\n"
                );
                return;
            }
        }

        if (   ($PlotArea{"width"} ne "")
            || ($PlotArea{"left"}  eq "")
            || ($PlotArea{"right"} eq ""))
        {
            &Error2(  "You specified 'ImageSize = width:auto'.\n"
                    . "  This implies  'PlotArea  = width:auto'.\n"
                    . "  Instead of 'width' specify plot margins with PlotArea attributes 'left' and 'right'.\n"
            );
            return;
        }
    }

    if ($Image{"height"} =~ /auto/i) {
        foreach my $attribute ("height", "top", "bottom") {
            if ($PlotArea{$attribute} =~ /\%/) {
                &Error2(  "You specified 'ImageSize = height:auto'.\n"
                        . "  This implies absolute values in PlotArea attributes 'top', 'bottom' and/or 'height' (no \%).\n"
                );
                return;
            }
        }

        if (   ($PlotArea{"height"} ne "")
            || ($PlotArea{"top"} eq "")
            || ($PlotArea{"bottom"} eq ""))
        {
            &Error2(  "You specified 'ImageSize = height:auto'.\n"
                    . "  This implies  'PlotArea  = height:auto'.\n"
                    . "  Instead of 'height' specify plot margins with PlotArea attributes 'top' and 'bottom'.\n"
            );
            return;
        }
    }

    $Image{"width"}     = &Normalize($Image{"width"});
    $Image{"height"}    = &Normalize($Image{"height"});
    $Image{"barinc"}    = &Normalize($Image{"barinc"});
    $PlotArea{"width"}  = &Normalize($PlotArea{"width"}, $Image{"width"});
    $PlotArea{"height"} = &Normalize($PlotArea{"height"}, $Image{"height"});
    $PlotArea{"left"}   = &Normalize($PlotArea{"left"}, $Image{"width"});
    $PlotArea{"right"}  = &Normalize($PlotArea{"right"}, $Image{"width"});
    $PlotArea{"bottom"} = &Normalize($PlotArea{"bottom"}, $Image{"height"});
    $PlotArea{"top"}    = &Normalize($PlotArea{"top"}, $Image{"height"});

    if ($Image{"width"} =~ /auto/i) {
        $PlotArea{"width"} = $#Bars * $Image{"barinc"};
        $Image{"width"} =
            $PlotArea{"left"} + $PlotArea{"width"} + $PlotArea{"right"};
    }

    elsif ($Image{"height"} =~ /auto/i) {
        $PlotArea{"height"} = $#Bars * $Image{"barinc"};
        $Image{"height"} =
            $PlotArea{"top"} + $PlotArea{"height"} + $PlotArea{"bottom"};
    }

    if ($PlotArea{"right"} ne "") {
        $PlotArea{"width"} =
            $Image{"width"} - $PlotArea{"left"} - $PlotArea{"right"};
    }

    if ($PlotArea{"top"} ne "") {
        $PlotArea{"height"} =
            $Image{"height"} - $PlotArea{"top"} - $PlotArea{"bottom"};
    }

    if (($Image{"width"} > 16) || ($Image{"height"} > 20)) {
        if (!$bypass) {
            &Error2(  "Maximum image size is 1600x2000 pixels = 16x20 inch\n"
                    . "  Run with option -b (bypass checks) when this is correct.\n"
            );
            return;
        }
    }

    if (($Image{"width"} < 0.25) || ($Image{"height"} < 0.25)) {
        &Error2("Minimum image size is 25x25 pixels = 0.25x0.25 inch\n");
        return;
    }

    if ($PlotArea{"width"} > $Image{"width"}) {
        &Error2("Plot width larger than image width. Please adjust.\n");
        return;
    }

    if ($PlotArea{"width"} < 0.2) {
        &Error2(
            "Plot width less than 20 pixels = 0.2 inch. Please adjust.\n");
        return;
    }

    if ($PlotArea{"height"} > $Image{"height"}) {
        &Error2("Plot height larger than image height. Please adjust.\n");
        return;
    }

    if ($PlotArea{"height"} < 0.2) {
        &Error2(
            "Plot height less than 20 pixels = 0.2 inch. Please adjust.\n");
        return;
    }

    if ($PlotArea{"left"} + $PlotArea{"width"} > $Image{"width"}) {
        &Error2(
            "Plot width + margins larger than image width. Please adjust.\n");
        return;
    }

    #   $PlotArea{"left"} = $Image{"width"} - $PlotArea{"width"} ; }

    if ($PlotArea{"left"} < 0) { $PlotArea{"left"} = 0; }

    if ($PlotArea{"bottom"} + $PlotArea{"height"} > $Image{"height"}) {
        &Error2(
            "Plot height + margins larger than image height. Please adjust.\n"
        );
        return;
    }

    #   $PlotArea{"bottom"} = $Image{"height"} - $PlotArea{"height"} ; }

    if ($PlotArea{"bottom"} < 0) { $PlotArea{"bottom"} = 0; }

    if (   (defined($Scales{"Major"}))
        || (defined($Scales{"Minor"})))
    {
        my $margin;
        if   (defined($Scales{"Major"})) { $margin = 0.2; }
        else                             { $margin = 0.05; }

        if ($Axis{"time"} eq "x") {
            if ($PlotArea{"bottom"} < $margin) {
                &Error2(
                    "Not enough space below plot area for plotting time axis\n"
                        . " Specify 'PlotArea = bottom:x', where x is at least "
                        . (100 * $margin)
                        . " pixels = $margin inch\n");
                return;
            }
        }
        else {
            if ($PlotArea{"left"} < $margin) {
                &Error2(
                    "Not enough space outside plot area for plotting time axis\n"
                        . " Specify 'PlotArea = left:x', where x is at least "
                        . (100 * $margin)
                        . " pixels = $margin inch\n");
                return;
            }
        }
    }

    if (defined($Legend{"orientation"})) {
        if (defined($Legend{"left"})) {
            $Legend{"left"} = &Normalize($Legend{"left"}, $Image{"width"});
        }
        if (defined($Legend{"top"})) {
            $Legend{"top"} = &Normalize($Legend{"top"}, $Image{"height"});
        }
        if (defined($Legend{"columnwidth"})) {
            $Legend{"columnwidth"} =
                &Normalize($Legend{"columnwidth"}, $Image{"width"});
        }

        if (!defined($Legend{"columns"})) {
            $Legend{"columns"} = 1;
            if (   ($Legend{"orientation"} =~ /ver/i)
                && ($Legend{"position"} =~ /^(?:top|bottom)$/i))
            {
                if ($#LegendData > 10) {
                    $Legend{"columns"} = 3;
                    &Info2(
                        "Legend attribute 'columns' not defined. 3 columns assumed."
                    );
                }
                elsif ($#LegendData > 5) {
                    $Legend{"columns"} = 2;
                    &Info2(
                        "Legend attribute 'columns' not defined. 2 columns assumed."
                    );
                }
            }
        }

        if ($Legend{"position"} =~ /top/i) {
            if (!defined($Legend{"left"})) {
                $Legend{"left"} = $PlotArea{"left"};
            }
            if (!defined($Legend{"top"})) {
                $Legend{"top"} = ($Image{"height"} - 0.2);
            }
            if (   (!defined($Legend{"columnwidth"}))
                && ($Legend{"columns"} > 1))
            {
                $Legend{"columnwidth"} = sprintf(
                    "%02f",
                    (
                        ($PlotArea{"left"} + $PlotArea{"width"} - 0.2) /
                            $Legend{"columns"}
                    )
                );
            }
        }
        elsif ($Legend{"position"} =~ /bottom/i) {
            if (!defined($Legend{"left"})) {
                $Legend{"left"} = $PlotArea{"left"};
            }
            if (!defined($Legend{"top"})) {
                $Legend{"top"} = ($PlotArea{"bottom"} - 0.4);
            }
            if (   (!defined($Legend{"columnwidth"}))
                && ($Legend{"columns"} > 1))
            {
                $Legend{"columnwidth"} = sprintf(
                    "%02f",
                    (
                        ($PlotArea{"left"} + $PlotArea{"width"} - 0.2) /
                            $Legend{"columns"}
                    )
                );
            }
        }
        elsif ($Legend{"position"} =~ /right/i) {
            if (!defined($Legend{"left"})) {
                $Legend{"left"} =
                    ($PlotArea{"left"} + $PlotArea{"width"} + 0.2);
            }
            if (!defined($Legend{"top"})) {
                $Legend{"top"} =
                    ($PlotArea{"bottom"} + $PlotArea{"height"} - 0.2);
            }
        }
    }

    if (!defined($Axis{"order"})) { $Axis{"order"} = "normal"; }
}

sub WriteProcAnnotate {
    my $bar       = shift;
    my $shiftx    = shift;
    my $xpos      = shift;
    my $ypos      = shift;
    my $text      = shift;
    my $textcolor = shift;
    my $fontsize  = shift;
    my $align     = shift;
    my $link      = shift;
    my $hint      = shift;

    if (length($text) > 250) {
        &Error(
            "Text segments can be up to 250 characters long. This segment is "
                . length($text)
                . " chars.\n"
                . "  You can either shorten the text or\n"
                . "  - PlotData: insert line breaks (~)\n"
                . "  - TextData: insert tabs (~) to produce columns\n");
        return;
    }

    if ($textcolor eq "") { $textcolor = "black"; }

    my $textdetails =
        "  textdetails: align=$align size=$fontsize color=$textcolor";

    push @PlotTextsPng, "#proc annotate\n";
    push @PlotTextsSvg, "#proc annotate\n";

    push @PlotTextsPng, "  location: $xpos $ypos\n";
    push @PlotTextsSvg, "  location: $xpos $ypos\n";

    push @PlotTextsPng, $textdetails . "\n";
    push @PlotTextsSvg, $textdetails . "\n";

    my $text2 = $text;
    $text2 =~ s/\[\[//g;
    $text2 =~ s/\]\]//g;
    if ($text2 =~ /^\s/) {
        push @PlotTextsPng, "  text: \n\\$text2\n\n";
    }
    else {
        push @PlotTextsPng, "  text: $text2\n\n";
    }

    $text2 = $text;
    if ($link ne "") {

        # put placeholder in Ploticus input file
        # will be replaced by real link after SVG generation
        # this allows adding color info
        push @linksSVG, &DecodeInput($link);
        my $lcnt = $#linksSVG;
        $text2 =~ s/\[\[ ([^\]]+) \]\]/\[$lcnt\[$1\]$lcnt\]/x;
        $text2 =~ s/\[\[ ([^\]]+) $/\[$lcnt\[$1\]$lcnt\]/x;
        $text2 =~ s/^ ([^\[]+) \]\]/\[$lcnt\[$1\]$lcnt\]/x;
    }

    my $text3 = &EncodeHtml($text2);
    if ($text2 ne $text3) {

        # put placeholder in Ploticus input file
        # will be replaced by real text after SVG generation
        # Ploticus would autoscale image improperly when text contains &#xxx; tags
        # because this would count as 5 chars
        push @textsSVG, &DecodeInput($text3);
        $text3 = "{{" . $#textsSVG . "}}";
        while (length($text3) < length($text2)) { $text3 .= "x"; }
    }

    if ($text3 =~ /^\s/) {
        push @PlotTextsSvg, "  text: \n\\$text3\n\n";
    }
    else {
        push @PlotTextsSvg, "  text: $text3\n\n";
    }

    if ($link ne "") {
        $MapPNG = $true;

        push @PlotTextsPng, "#proc annotate\n";
        push @PlotTextsPng, "  location: $xpos $ypos\n";

        #   push @PlotTextsPng, "  boxmargin: 0.01\n" ;

        if ($align ne "right") {
            push @PlotTextsPng, "  clickmapurl: $link\n";
            if ($hint ne "") {
                push @PlotTextsPng, "  clickmaplabel: $hint\n";
            }
        }
        else {
            if ($bar eq "") {
                if ($WarnOnRightAlignedText++ == 0) {
                    &Warning2(
                        "Links on right aligned texts are only supported for svg output,\npending Ploticus bug fix."
                    );
                }
                return;
            }
            else {
                push @PlotTextsPng, "  clickmapurl: $link\&\&$shiftx\n";
                if ($hint ne "") {
                    push @PlotTextsPng, "  clickmaplabel: $hint\n";
                }
            }
        }

        $textdetails =~ s/color=[^\s]+/color=$LinkColor/;
        push @PlotTextsPng, $textdetails . "\n";

        $text = &DecodeInput($text);
        if ($text =~ /^[^\[]+\]\]/) { $text = "[[" . $text; }
        if ($text =~ /\[\[[^\]]+$/) { $text .= "]]"; }
        my $pos1 = index($text, "[[");
        my $pos2 = index($text, "]]") + 1;
        if (($pos1 > -1) && ($pos2 > -1)) {
            for (my $i = 0; $i < length($text); $i++) {
                my $c = substr($text, $i, 1);
                if ($c ne "\n") {
                    if (($i < $pos1) || ($i > $pos2)) {
                        substr($text, $i, 1) = " ";
                    }
                }
            }
        }

        $text =~ s/\[\[(.*?)\]\]/$1/s;

        if   ($text =~ /^\s/) { push @PlotTextsPng, "  text: \n\\$text\n\n"; }
        else                  { push @PlotTextsPng, "  text: $text\n\n"; }

        #    push @PlotTextsPng, "#proc rect\n" ;
        #    push @PlotTextsPng, "  color: green\n" ;
        #    push @PlotTextsPng, "  rectangle: 1(s)+0.25 1937.500(s)+0.06 1(s)+0.50 1937.500(s)+0.058\n" ;
        #    push @PlotTextsPng, "\n\n" ;
    }
}

sub WriteText {
    my $mode      = shift;
    my $bar       = shift;
    my $shiftx    = shift;
    my $posx      = shift;
    my $posy      = shift;
    my $text      = shift;
    my $textcolor = shift;
    my $fontsize  = shift;
    my $align     = shift;
    my $link      = shift;
    my $hint      = shift;
    my $tabs      = shift;
    my ($link2, $hint2, $tab);
    my $outside = $false;

    if ($Axis{"order"} =~ /reverse/i) {
        if   ($Axis{"time"} eq "y") { $posy =~ s/(.*)(\(s\))/(-$1).$2/xe; }
        else                        { $posx =~ s/(.*)(\(s\))/(-$1).$2/xe; }
    }

    if ($posx !~ /\(s\)/) {
        if ($posx < 0) { $outside = $true; }
        if ($Image{"width"} !~ /auto/i) {
            if ($posx > $Image{"width"} / 100) { $outside = $true; }
        }
    }
    if ($posy !~ /\(s\)/) {
        if ($posy < 0) { $outside = $true; }
        if ($Image{"height"} !~ /auto/i) {
            if ($posy > $Image{"height"} / 100) { $outside = $true; }
        }
    }
    if ($outside) {
        if ($WarnTextOutsideArea++ < 5) {
            $text =~ s/\n/~/g;
            &Error(
                "Text segment '$text' falls outside image area. Text ignored."
            );
        }
        return;
    }

    my @Tabs = split(",", $tabs);
    foreach (@Tabs) {
        s/\s* (.*) \s*$/$1/x;
    }

    my $posx0 = $posx;
    my @Text;
    my $dy = 0;

    if ($text =~ /\[\[.*\]\]/) {
        $link = "";
        $hint = "";
    }

    if ($mode eq "^") {
        @Text = split('\^', $text);
    }
    elsif ($mode eq "~") {
        @Text = split('\n', $text);

        if ($fontsize =~ /^(?:XS|S|M|L|XL)$/i) {
            if    ($fontsize =~ /XS/i) { $dy = 0.09; }
            elsif ($fontsize =~ /S/i)  { $dy = 0.11; }
            elsif ($fontsize =~ /M/i)  { $dy = 0.135; }
            elsif ($fontsize =~ /XL/i) { $dy = 0.21; }
            else                       { $dy = 0.16; }
        }
        else {
            $dy = sprintf("%.2f", (($fontsize * 1.2) / 100));
            if ($dy < $fontsize / 100 + 0.02) {
                $dy = $fontsize / 100 + 0.02;
            }
        }
    }
    else {
        push @Text, $text;
    }

    foreach my $text_item (@Text) {
        if ($text_item !~ /^[\n\s]*$/) {
            $link2 = "";
            $hint2 = "";
            ($text_item, $link2, $hint2) =
                &ProcessWikiLink($text_item, $link2, $hint2);

            if ($link2 eq "") {
                $link2 = $link;
                if (($link ne "") && ($text_item !~ /\[\[.*\]\]/)) {
                    $text_item = "[[" . $text_item . "]]";
                }
            }
            if ($hint2 eq "") { $hint2 = $hint; }

            &WriteProcAnnotate(
                $bar,       $shiftx,   $posx,  $posy,  $text_item,
                $textcolor, $fontsize, $align, $link2, $hint2
            );
        }

        if ($#Tabs >= 0) {
            $tab = shift(@Tabs);
            my $dx;
            ($dx, $align) = split("\-", $tab);
            $posx = $posx0 + &Normalize($dx);
        }

        if ($posy =~ /\+/) {
            ($posy1, $posy2) = split('\+', $posy);
        }
        elsif ($posy =~ /.+\-/) {
            if ($posy =~ /^\-/) {
                ($sign, $posy1, $posy2) = split('\-', $posy);
                $posy2 = -$posy2;
                $posy1 = "-" . $posy1;
            }
            else {
                ($posy1, $posy2) = split('\-', $posy);
                $posy2 = -$posy2;
            }
        }
        else {
            $posy1 = $posy;
            $posy2 = 0;
        }

        $posy2 -= $dy;

        if    ($posy2 == 0) { $posy = $posy1; }
        elsif ($posy2 < 0)  { $posy = $posy1 . "$posy2"; }
        else                { $posy = $posy1 . "+" . $posy2; }
    }
}

sub WritePlotFile {
    &WriteTexts;

    $script = "";

    my $AxisBars;
    if   ($Axis{"time"} eq "x") { $AxisBars = "y"; }
    else                        { $AxisBars = "x"; }

    my $file_script;
    if ($tmpdir ne "") {
        $file_script = $tmpdir . $pathseparator . "EasyTimeline.txt.$$";
    }
    else {
        $file_script = "EasyTimeline.txt";
    }

    print "Ploticus input file = $file_script\n";

    open "FILE_OUT", ">", $file_script;

    # proc page
    $script .= "#proc page\n";
    $script .= "  dopagebox: no\n";
    $script .=
        "  pagesize: " . $Image{"width"} . " " . $Image{"height"} . "\n";
    if (defined($BackgroundColors{"canvas"})) {
        $script .= "  backgroundcolor: " . $BackgroundColors{"canvas"} . "\n";
    }
    $script .= "\n";

    my $barcnt = $#Bars + 1;

    my ($U, $x);

    # if ($AlignBars eq "justify") && ($#Bars > 0)
    #
    # given P = plotwidth in pixels
    # given B = half bar width in pixels
    # get   U = plotwidth in units
    # get   x = half bar width in units
    #
    # first bar plotted at unit 1
    # last  bar plotted at unit c
    # let   C = c - 1 (units between centers of lowest and highest bar) -> x = (U-C) / 2
    #
    # Justify: calculate range for axis in units:
    # axis starts at 1-x and ends at c+x =
    # x/B = U/P                    -> x = BU/P         (1)
    # U = c+x - (1-x) = (c-1) + 2x -> x = (U-(c-1))/2  (2)
    #
    # (1) & (2)   ->  BU/P = (U-(c-1))/2
    #             -> 2BU/P =  U-(c-1)
    #             -> 2BU/P =  U - C
    #             -> 2BU   = PU - PC
    #             -> U (2B-P) = -PC
    #             -> U = -PC/(2B-P)
    # P = $PlotArea{$extent}
    # C = c - 1 = $#Bars
    # 2B = $MaxBarWidth
    if (!defined($AlignBars)) {
        &Info2("AlignBars not defined. Alignment 'early' assumed.");
        $AlignBars = "early";
    }

    my $extent;
    if   ($Axis{"time"} eq "x") { $extent = "height"; }
    else                        { $extent = "width"; }

    if ($MaxBarWidth > $PlotArea{$extent}) {
        &Error2("Maximum bar width exceeds plotarea " . $extent . ".");
        return;
    }

    if ($MaxBarWidth == $PlotArea{$extent}) { $PlotArea{$extent} += 0.01; }

    my ($till, $from);
    if ($MaxBarWidth == $PlotArea{$extent}) {
        $till = 1;
        $from = 1;
    }
    else {
        if ($AlignBars eq "justify") {
            if ($#Bars > 0) {
                $U =
                    -($PlotArea{$extent} * $#Bars) /
                    ($MaxBarWidth - $PlotArea{$extent});
                $x    = ($U - $#Bars) / 2;
                $from = 1 - $x;
                $till = 1 + $#Bars + $x;
            }
            else    # one bar-> "justify" is misnomer here, treat as "center"
            {

                # $x = ($MaxBarWidth /2) / $PlotArea{$extent} ;
                # $from = 0.5 - $x ;
                # $till = $from + 1 ;
                $from = 0.5;
                $till = 1.5;
            }
        }
        elsif ($AlignBars eq "early") {
            $U = $#Bars + 1;
            if ($U == 0) { $U = 1; }
            $x    = (($MaxBarWidth / 2) * $U) / $PlotArea{$extent};
            $from = 1 - $x;
            $till = $from + $U;
        }
        elsif ($AlignBars eq "late") {
            $U    = $#Bars + 1;
            $x    = (($MaxBarWidth / 2) * $U) / $PlotArea{$extent};
            $till = $U + $x;
            $from = $till - $U;
        }
    }

    #  if ($#Bars == 0)
    #  {
    #    $from = 1 - $MaxBarWidth ;
    #    $till = 1 + $MaxBarWidth ;
    #  }
    if ($from eq $till) { $till = $from + 1; }

    #proc areadef
    $script .= "#proc areadef\n";
    $script .=
          "  rectangle: "
        . $PlotArea{"left"} . " "
        . $PlotArea{"bottom"} . " "
        . sprintf("%.2f", $PlotArea{"left"} + $PlotArea{"width"}) . " "
        . sprintf("%.2f", $PlotArea{"bottom"} + $PlotArea{"height"}) . "\n";
    if (($DateFormat eq "yyyy") || ($DateFormat eq "x.y")) {
        $script .= "  " . $Axis{"time"} . "scaletype: linear\n";
    }    # date yyyy
    else {
        $script .= "  " . $Axis{"time"} . "scaletype: date $DateFormat\n";
    }

    if ($Axis{"order"} !~ /reverse/i) {
        $script .= "  "
            . $Axis{"time"}
            . "range: "
            . $Period{"from"} . " "
            . $Period{"till"} . "\n";
    }
    else {
        $script .= "  "
            . $Axis{"time"}
            . "range: "
            . (-$Period{"till"}) . " "
            . (-$Period{"from"}) . "\n";
    }

    $script .= "  " . $AxisBars . "scaletype: linear\n";
    $script .= "  "
        . $AxisBars
        . "range: "
        . sprintf("%.3f", $from - 0.001) . " "
        . sprintf("%.3f", $till) . "\n";
    $script .= "  #saveas: A\n";
    $script .= "\n";

    #proc rect (test)
    #  $script .= "#proc rect\n" ;
    #  $script .= "  rectangle 1.0 1.0 1.4 1.4\n" ;
    #  $script .= "  color gray(0.95)\n" ;
    #  $script .= "  clickmaplabel: Vladimir Ilyich Lenin\n" ;
    #  $script .= "  clickmapurl: http://www.wikipedia.org/wiki/Vladimir_Lenin\n" ;

    #proc legendentry
    foreach my $color (sort keys %Colors) {
        $script .= "#proc legendentry\n";
        $script .= "  sampletype: color\n";

        if ((defined($ColorLabels{$color})) && ($ColorLabels{$color} ne "")) {
            $script .= "  label: " . $ColorLabels{$color} . "\n";
        }
        $script .= "  details: " . $Colors{$color} . "\n";
        $script .= "  tag: $color\n";
        $script .= "\n";
    }

    if (defined($BackgroundColors{"bars"})) {

        #proc getdata / #proc bars
        $script .= "#proc getdata\n";
        $script .= "  delim: comma\n";
        $script .= "  data:\n";

        my $maxwidth = 0;
        foreach my $entry (@PlotBars) {
            my ($width) = split(",", $entry);
            if ($width > $maxwidth) { $maxwidth = $width; }
        }

        for ($b = 0; $b <= $#Bars; $b++) {
            $script .=
                  ($b + 1) . ","
                . $Period{"from"} . ","
                . $Period{"till"} . ","
                . $BackgroundColors{"bars"} . "\n";
        }
        $script .= "\n";

        #proc bars
        $script .= "#proc bars\n";
        $script .= "  axis: " . $Axis{"time"} . "\n";
        $script .= "  barwidth: $maxwidth\n";
        $script .= "  outline: no\n";
        if ($Axis{"time"} eq "x") { $script .= "  horizontalbars: yes\n"; }
        $script .= "  locfield: 1\n";
        $script .= "  segmentfields: 2 3\n";
        $script .= "  colorfield: 4\n";

        #   $script .= "  clickmaplabel: Vladimir Ilyich Lenin\n" ;
        #   $script .= "  clickmapurl: http://www.wikipedia.org/wiki/Vladimir_Lenin\n" ;

        $script .= "\n";
    }

    #proc axis
    if (defined($Scales{"Minor grid"})) { &PlotScale("Minor", $true); }
    if (defined($Scales{"Major grid"})) { &PlotScale("Major", $true); }

    &PlotLines("back");

    @PlotBarsNow = @PlotBars;
    &PlotBars;

    $script .= "\n([inc3])\n\n";    # will be replace by rects

    my ($bar, $width);
    foreach my $entry (@PlotLines) {
        ($bar) = split(",", $entry);
        $bar =~ s/\#.*//;
        $width = $BarWidths{$bar};
        $entry = sprintf("%6.3f", $width) . "," . $entry;
    }

    @PlotBarsNow = @PlotLines;
    &PlotBars;

    my $scriptPng1 = q{};
    my $scriptPng2 = q{};
    my $scriptPng3 = q{};
    my $scriptSvg1 = q{};
    my $scriptSvg2 = q{};

    #proc axis
    if ($#Bars > 0) {
        $scriptPng2 = "#proc " . $AxisBars . "axis\n";
        $scriptSvg2 = "#proc " . $AxisBars . "axis\n";
        if ($AxisBars eq "x") {
            $scriptPng2 .= "  stubdetails: adjust=0,0.09\n";
            $scriptSvg2 .= "  stubdetails: adjust=0,0.09\n";
        }
        else {
            $scriptPng2 .= "  stubdetails: adjust=0.09,0\n";
            $scriptSvg2 .= "  stubdetails: adjust=0.09,0\n";
        }
        $scriptPng2 .= "  tics: none\n";
        $scriptSvg2 .= "  tics: none\n";
        $scriptPng2 .= "  stubrange: 1\n";
        $scriptSvg2 .= "  stubrange: 1\n";
        if ($AxisBars eq "y") {
            $scriptPng2 .=
                "  stubslide: -" . sprintf("%.2f", $MaxBarWidth / 2) . "\n";
            $scriptSvg2 .=
                "  stubslide: -" . sprintf("%.2f", $MaxBarWidth / 2) . "\n";
        }
        $scriptPng2 .= "  stubs: text\n";
        $scriptSvg2 .= "  stubs: text\n";

        my $text;
        my $link;
        my $hint;

        my @Bars2;

        undef(@Bars2);
        foreach my $bar_iter (@Bars) {
            if ($AxisBars eq "y") {
                push @Bars2, $bar_iter;
            }
            else {
                unshift @Bars2, $bar_iter;
            }
        }

        foreach my $bar2_iter (@Bars2) {
            $hint = "";
            $text = $BarLegend{ lc($bar2_iter) };
            if ($text =~ /^\s*$/) { $text = "\\"; }

            $link = $BarLink{ lc($bar2_iter) };
            if (!defined($link)) {
                if ($text =~ /\[.*\]/) {
                    ($text, $link, $hint) =
                        &ProcessWikiLink($text, $link, $hint);
                }
            }

            $text =~ s/\[+([^\]]*)\]+/$1/;
            $scriptPng2 .= "$text\n";
            if (defined($link)) {
                push @linksSVG, $link;
                my $lcnt = $#linksSVG;
                $scriptSvg2 .=
                    "[" . $lcnt . "[" . $text . "]" . $lcnt . "]\n";
            }
            else {
                $scriptSvg2 .= "$text\n";
            }
        }
        $scriptPng2 .= "\n";
        $scriptSvg2 .= "\n";

        $scriptPng2 .= "#proc " . $AxisBars . "axis\n";
        if ($AxisBars eq "x") {
            $scriptPng2 .= "  stubdetails: adjust=0,0.09 color=$LinkColor\n";
        }
        else {
            $scriptPng2 .= "  stubdetails: adjust=0.09,0 color=$LinkColor\n";
        }
        $scriptPng2 .= "  tics: none\n";
        $scriptPng2 .= "  stubrange: 1\n";
        if ($AxisBars eq "y") {
            $scriptPng2 .=
                "  stubslide: -" . sprintf("%.2f", $MaxBarWidth / 2) . "\n";
        }
        $scriptPng2 .= "  stubs: text\n";

        $barcnt = $#Bars + 1;
        foreach my $bars2_iter (@Bars2) {
            $hint = "";
            $text = $BarLegend{ lc($bars2_iter) };
            if ($text =~ /^\s*$/) { $text = "\\"; }

            $link = $BarLink{ lc($bars2_iter) };
            if (!defined($link)) {
                if ($text =~ /\[.*\]/) {
                    ($text, $link, $hint) =
                        &ProcessWikiLink($text, $link, $hint);
                }
            }
            if ((!defined($link)) || ($link eq "")) { $text = "\\"; }
            else {
                $scriptPng3 .= "#proc rect\n";
                $scriptPng3 .=
                      "  rectangle: 0 $barcnt(s)+0.05 "
                    . $PlotArea{"left"}
                    . " $barcnt(s)-0.05\n";
                $scriptPng3 .=
                    "  color: " . $BackgroundColors{"canvas"} . "\n";
                $scriptPng3 .= "  clickmapurl: " . $link . "\n";
                if ((defined($hint)) && ($hint ne "")) {
                    $scriptPng3 .= "  clickmaplabel: " . $hint . "\n";
                }

                $text =~ s/\[+([^\]]*)\]+/$1/;
            }
            $scriptPng2 .= "$text\n";

            $barcnt--;
        }
        $scriptPng2 .= "\n";
    }

    &PlotLines("front");

    $script .= "\n([inc1])\n\n";    # will be replaced by annotations
    $script .= "\n([inc2])\n\n";

    if ($#PlotTextsPng >= 0) {
        foreach my $plot_texts_png_command (@PlotTextsPng) {
            if ($plot_texts_png_command =~ /^\s*location/) {
                $plot_texts_png_command =~
                    s/(.*)\[(.*)\](.*)/$1 . ($#Bars - $2 + 2) . $3/xe;
            }

            $scriptPng1 .= $plot_texts_png_command;
        }
        $scriptPng1 .= "\n";
    }

    if ($#PlotTextsSvg >= 0) {
        foreach my $plot_texts_svg_command (@PlotTextsSvg) {
            if ($plot_texts_svg_command =~ /^\s*location/) {
                $plot_texts_svg_command =~
                    s/(.*)\[(.*)\](.*)/$1 . ($#Bars - $2 + 2) . $3/xe;
            }

            $scriptSvg1 .= $plot_texts_svg_command;
        }
        $scriptSvg1 .= "\n";
    }

    #proc axis
    # repeat without grid to get axis on top of bar
    # needed because axis may overlap bar slightly
    if (defined($Scales{"Minor"})) { &PlotScale("Minor", $false); }
    if (defined($Scales{"Major"})) { &PlotScale("Major", $false); }

    #proc drawcommands
    if ($#TextData >= 0) {
        $script .= "#proc drawcommands\n";
        $script .= "  commands:\n";
        foreach my $entry (@TextData) { $script .= $entry; }
        $script .= "\n";
    }

    #proc legend
    if (defined($Legend{"orientation"})) {
        if (($#LegendData < 0) && ($Preset eq "")) {
            &Error2(
                "Command 'Legend' found, but no entries for the legend were specified.\n"
                    . "  Please remove or disable command (disable = put \# before the command)\n"
                    . "  or specify entries for the legend with command 'Colors', attribute 'legend'\n"
            );
            return;
        }

        my $perColumn = 999;
        if ($Legend{"orientation"} =~ /ver/i) {
            if ($Legend{"columns"} > 1) {
                $perColumn = 0;
                while (($Legend{"columns"} * $perColumn) < $#LegendData + 1) {
                    $perColumn++;
                }
            }
        }

        for (1 .. $Legend{"columns"}) {
            $script .= "#proc legend\n";
            $script .= "  noclear: yes\n";
            if ($Legend{"orientation"} =~ /ver/i) {
                $script .= "  format: multiline\n";
            }
            else { $script .= "  format: singleline\n"; }
            $script .= "  seglen: 0.2\n";
            $script .= "  swatchsize: 0.12\n";
            $script .= "  textdetails: size=S\n";
            $script .=
                  "  location: "
                . ($Legend{"left"} + 0.2) . " "
                . $Legend{"top"} . "\n";
            $script .= "  specifyorder:\n";
            for (1 .. $perColumn) {
                my $category = shift(@LegendData);
                if (defined($category)) { $script .= "$category\n"; }
            }
            $script .= "\n";
            $Legend{"left"} += $Legend{"columnwidth"};
        }
    }

    $script .= "#endproc\n";

    my $pl;
    print "\nGenerating output:\n";
    if ($ploticus_command ne "") {
        $pl = $ploticus_command;
    }
    else {
        $pl = "pl.exe";
        if ($env eq "Linux") { $pl = "pl"; }
    }

    print "Using ploticus command \"" 
        . $pl . "\" ("
        . $ploticus_command . ")\n";

    my $script_save = $script;

    $script =~ s/\(\[inc1\]\)/$scriptSvg1/;
    $script =~ s/\(\[inc2\]\)/$scriptSvg2/;
    $script =~ s/\(\[inc3\]\)//;

    $script =~ s/textsize XS/textsize 7/gi;
    $script =~ s/textsize S/textsize 8.9/gi;

    $script =~ s/textsize M/textsize 10.5/gi;
    $script =~ s/textsize L/textsize 13/gi;
    $script =~ s/textsize XL/textsize 17/gi;
    $script =~ s/size=XS/size=7/gi;
    $script =~ s/size=S/size=8.9/gi;
    $script =~ s/size=M/size=10.5/gi;
    $script =~ s/size=L/size=13/gi;
    $script =~ s/size=XL/size=17/gi;

    $script =~ s/(\n  location:.*)/&ShiftOnePixelForSVG($1)/ge;

    open "FILE_OUT", ">", $file_script;
    print FILE_OUT &DecodeInput($script);
    close "FILE_OUT";

    my $map = ($MapSVG) ? "-map" : "";

    print "Running Ploticus to generate svg file $file_vector\n";

    my $escaped_font_file = EscapeShellArg($font_file);
    my $cmd =
          EscapeShellArg($pl)
        . " $map -" . "svg" . " -o "
        . EscapeShellArg($file_vector) . " "
        . EscapeShellArg($file_script)
        . " -tightcrop"
        . " -font '$escaped_font_file'"
        . " -xml_encoding UTF-8";
    print "$cmd\n";
    system($cmd);

    $script = $script_save;
    $script =~ s/dopagebox: no/dopagebox: yes/;

    $script =~ s/\(\[inc1\]\)/$scriptPng1/;
    $script =~ s/\(\[inc2\]\)/$scriptPng2/;
    $script =~ s/\(\[inc3\]\)/$scriptPng3/;

    $script =~ s/textsize XS/textsize 6/gi;
    $script =~ s/textsize S/textsize 8/gi;
    $script =~ s/textsize M/textsize 10/gi;
    $script =~ s/textsize L/textsize 14/gi;
    $script =~ s/textsize XL/textsize 18/gi;
    $script =~ s/size=XS/size=6/gi;
    $script =~ s/size=S/size=8/gi;
    $script =~ s/size=M/size=10/gi;
    $script =~ s/size=L/size=14/gi;
    $script =~ s/size=XL/size=18/gi;

    open "FILE_OUT", ">", $file_script;
    print FILE_OUT &DecodeInput($script);
    close "FILE_OUT";

    if ($MapPNG && $linkmap) {
        $map = "-csmap -mapfile " . EscapeShellArg($file_htmlmap);
    }
    elsif ($linkmap && $showmap) {
        $map = "-csmapdemo -mapfile " . EscapeShellArg($file_htmlmap);
    }
    else {
        $map = '';
    }

    print "Running Ploticus to generate bitmap file $file_bitmap\n";

    $cmd =
          EscapeShellArg($pl)
        . " $map -"
        . $image_file_fmt . " -o "
        . EscapeShellArg($file_bitmap) . " "
        . EscapeShellArg($file_script)
        . " -tightcrop -font "
        . EscapeShellArg($font_file);
    print "$cmd\n";
    system($cmd);

    if ((-e $file_bitmap) && (-s $file_bitmap > 500 * 1024)) {
        &Error2(  "Output image size exceeds 500 K. Image deleted.\n"
                . "Run with option -b (bypass checks) when this is correct.\n"
        );
        unlink $file_bitmap;
    }

    # not for Wikipedia, only for offline use:
    if ((-e $file_bitmap) && ($image_file_fmt eq "gif")) {
        print "Running nconvert to convert gif image to png format\n\n";
        print
            "---------------------------------------------------------------------------\n";
        $cmd = "nconvert.exe -out png " . EscapeShellArg($file_bitmap);
        system($cmd);
        print
            "---------------------------------------------------------------------------\n";

        if (!(-e $file_png)) {
            print "PNG file not created (is nconvert.exe missing?)\n\n";
        }
    }

    # correct click coordinates of right aligned texts (Ploticus bug)
    if (-e $file_htmlmap) {
        open "FILE_IN", "<", $file_htmlmap;
        my @map = <FILE_IN>;
        close "FILE_IN";

        my @map2;
        foreach my $line (@map) {
            chomp $line;
            if ($line =~ /\&\&/) {
                my $coords = $line;
                my $shift  = $line;
                $coords =~ s/^.*coords\=\"([^\"]*)\".*$/$1/;
                $shift  =~ s/^.*\&\&([^\"]*)\".*$/$1/;         # XXX?
                $line   =~ s/\&\&[^\"]*//;
                my (@updcoords) = split(",", $coords);
                my $maplength = $updcoords[2] - $updcoords[0];
                $updcoords[0] = $updcoords[0] - 2 * ($maplength - 25);
                $updcoords[2] = $updcoords[0] + $maplength;
                my $coordsnew = join(",", @updcoords);
                $line =~ s/$coords/$coordsnew/;
                push @map2, $line . "\n";
            }
            else {
                push @map2, $line . "\n";
            }
        }

        open "FILE_OUT", ">", $file_htmlmap;
        print FILE_OUT @map2;
        close "FILE_OUT";
    }

    if (-e $file_vector) {
        open my $file_vector_handle, '<', $file_vector
            or Abort("Can't open $file_vector for reading: $OS_ERROR");
        my @svg = <$file_vector_handle>;
        close $file_vector_handle
            or Abort("Can't open $file_vector after reading: $OS_ERROR");

        foreach (@svg) {
            s/\{\{(\d+)\}\}x+/$textsSVG[$1]/gxe;

            if ($SVG_ONLY) {
                s{
                    (
                        <text
                        .*?
                    )
                    >
                    \[(\d+)\[
                    (.*?)
                    \]\d+\]
                }
                {$1 style="fill:blue;">$3}gx;
            }
            else {
                s/\[(\d+)\[ (.*?) \]\d+\]/'<a style="fill:blue;" xlink:href="' . $linksSVG[$1] . '">' . $2 . '<\/a>'/gxe;
            }
        }

        open $file_vector_handle, '>', $file_vector
            or Abort("Can't open $file_vector for writing: $OS_ERROR");
        print {$file_vector_handle} @svg;
        close $file_vector_handle
            or Abort("Can't open $file_vector after writing: $OS_ERROR");
    }

    # not for Wikipedia, for offline use:
    if ($makehtml) {
        $map = "";
        if ($linkmap) {
            open "FILE_IN", "<", $file_htmlmap;
            while (my $line = <FILE_IN>) {
                $map .= $line;
            }
            close "FILE_IN";
        }
        print "Generating html test file\n";
        $width = sprintf("%.0f", $Image{"width"} * 100);
        my $height = sprintf("%.0f", $Image{"height"} * 100);
        my $html = <<__HTML__ ;

<html>
<head>
<title>%FILENAME% - EasyTimeline test file</title>\n
</head>

<body>
<h1><font color="green">EasyTimeline</font> - Test Page</h1>

<b>Fixed size version (PNG): file $file_png</b><p>
<map name="map1">
$map</map>

<!--
If you want a border simplest way is set <img .. border='1'>
Here tables are used to draw similar borders around both images (border='1' seems not to work for embed tag)
-->

<table border='1' cellpadding='0' cellspacing='0'><tr><td>
<img src=$file_png usemap='#map1' border='0'>
</td></tr></table>

<hr>
<b>Scalable version (SVG): file $file_vector</b><p>
<table border='1' cellpadding='0' cellspacing='0'><tr><td>
<noembed>Your browser does not support embedded objects</noembed>
<embed src='$file_vector' name='SVGEmbed' border='1'
width='$width' height='$height' type='image/svg-xml' pluginspage='http://www.adobe.com/svg/viewer/install/'>
</td></tr></table>

<p>As you can see the scalable version renders fonts smoother better than the bitmap version.
<br>Any SVG picture can also be rescaled or zoomed into, without annoying artefacts.

<p>Windows users:<br>
<small>&nbsp;&nbsp;Right mouse click on picture for zoom options or</small>
<p><small>&nbsp;&nbsp;Ctrl+click for zoom in</small>
<br><small>&nbsp;&nbsp;Ctrl+Shift+click for zoom out</small>
<br><small>&nbsp;&nbsp;Alt+drag with mouse to move focus</small>

</body>
</html>

__HTML__

        $html =~ s/\%FILENAME\%/$file_name/;

        open "FILE_OUT", ">", $file_html;
        print FILE_OUT $html;
        close "FILE_OUT";
    }

    #  my $cmd = "\"c:\\\\Program Files\\\\XnView\\\\xnview.exe\"" ;
    #  system ("\"c:\\\\Program Files\\\\XnView\\\\xnview.exe\"", "d:\\\\Wikipedia\\Perl\\\\Wo2\\\\Test.png") ;
}

sub WriteTexts {
    my ($xpos, $ypos);

    foreach my $line (@PlotText) {
        my (
            $at,    $bar,   $text, $textcolor, $fontsize,
            $align, $shift, $link, $hint
        ) = split(",", $line);
        $text      =~ s/\#\%\$/\,/g;
        $link      =~ s/\#\%\$/\,/g;
        $hint      =~ s/\#\%\$/\,/g;
        $shift     =~ s/\#\%\$/\,/g;
        $textcolor =~ s/\#\%\$/\,/g;

        my $barcnt = 0;
        for ($b = 0; $b <= $#Bars; $b++) {
            if (lc($Bars[$b]) eq lc($bar)) { $barcnt = ($b + 1); last; }
        }

        if ($Axis{"time"} eq "x") {
            $xpos = "$at(s)";
            $ypos = "[$barcnt](s)";
        }
        else { $ypos = "$at(s)"; $xpos = "[$barcnt](s)"; }

        my ($shiftx, $shifty);
        if ($shift ne "") {
            ($shiftx, $shifty) = split(",", $shift);
            if ($shiftx > 0) { $xpos .= "+$shiftx"; }
            if ($shiftx < 0) { $xpos .= "$shiftx"; }
            if ($shifty > 0) { $ypos .= "+$shifty"; }
            if ($shifty < 0) { $ypos .= "$shifty"; }
        }

        &WriteText(
            "~",    $bar,  $shiftx,    $xpos,
            $ypos,  $text, $textcolor, $fontsize,
            $align, $link, $hint
        );
    }
}

sub PlotBars {
    my @PlotBarsLater;

    #proc getdata / #proc bars
    while ($#PlotBarsNow >= 0) {
        undef @PlotBarsLater;

        my $maxwidth = 0;
        foreach my $entry (@PlotBarsNow) {
            my ($width) = split(",", $entry);
            if ($width > $maxwidth) { $maxwidth = $width; }
        }

        $script .= "#proc getdata\n";
        $script .= "  delim: comma\n";
        $script .= "  data:\n";

        foreach my $entry (@PlotBarsNow) {
            my ($width, $bar, $from, $till, $color, $link, $hint) =
                split(",", $entry);
            if ($width < $maxwidth) {
                push @PlotBarsLater, $entry;
                next;
            }
            for ($b = 0; $b <= $#Bars; $b++) {
                if (lc($Bars[$b]) eq lc($bar)) {
                    $bar = ($#Bars - ($b - 1));
                    last;
                }
            }
            if ($Axis{"order"} !~ /reverse/i) {
                $entry = "$bar,$from,$till,$color,$link,$hint,\n";
            }
            else {
                $entry = "$bar,"
                    . (-$till) . ","
                    . (-$from)
                    . ",$color,$link,$hint,\n";
            }

            $script .= "$entry";
        }
        $script .= "\n";

        # proc bars
        $script .= "#proc bars\n";
        $script .= "  axis: " . $Axis{"time"} . "\n";
        $script .= "  barwidth: $maxwidth\n";
        $script .= "  outline: no\n";

        if ($Axis{"time"} eq "x") { $script .= "  horizontalbars: yes\n"; }
        $script .= "  locfield: 1\n";
        $script .= "  segmentfields: 2 3\n";
        $script .= "  colorfield: 4\n";

        $script .= "  clickmapurl: \@\@5\n";
        $script .= "  clickmaplabel: \@\@6\n";
        $script .= "\n";

        @PlotBarsNow = @PlotBarsLater;
    }
}

sub PlotScale {
    my $scale = shift;
    my $grid  = shift;
    my ($color, $from, $till, $start);

    $from = &DateToFloat($Period{"from"});
    $till = &DateToFloat($Period{"till"});

    #proc areadef
    $script .= "#proc areadef\n";
    $script .= "  #clone: A\n";
    $script .= "  " . $Axis{"time"} . "scaletype: linear\n";    # date yyyy

    if ($Axis{"order"} !~ /reverse/i) {
        $script .= "  " . $Axis{"time"} . "range: $from $till\n";
    }
    else {
        $script .= "  "
            . $Axis{"time"}
            . "range: "
            . (-$till) . " "
            . (-$from) . "\n";
    }

    $script .= "\n";

    $script .= "#proc " . $Axis{"time"} . "axis\n";

    if (($scale eq "Major") && (!$grid)) {

        # temp always show whole years (Ploticus autorange bug)
        if ($Scales{"Major stubs"} eq "")    # ($DateFormat !~ /\//)
        {
            $script .= "  stubs: incremental " . $Scales{"Major inc"} . "\n";
        }
        else { $script .= "  stubs: list " . $Scales{"Major stubs"} . "\n"; }
    }
    else { $script .= "  stubs: none\n"; }

    if ($DateFormat !~ /\//) {
        $script .= "  ticincrement: " . $Scales{"$scale inc"} . "\n";
    }
    else {
        my $unit = 1;
        if ($Scales{"$scale unit"} =~ /month/i) { $unit = 1 / 12; }
        if ($Scales{"$scale unit"} =~ /day/i)   { $unit = 1 / 365; }
        $script .= "  ticincrement: " . $Scales{"$scale inc"} . " $unit\n";
    }

    if (defined($Scales{"$scale start"})) {
        $start = $Scales{"$scale start"};

        $start = &DateToFloat($start);
        if ($Axis{"order"} =~ /reverse/i) {
            my $loop = 0;
            $start = -$start;
            while ($start - $Scales{"$scale inc"} >= -$Period{"till"}) {
                $start -= $Scales{"$scale inc"};
                if (++$loop > 1000) { last; }    # precaution
            }
        }
        $script .= "  stubrange: $start\n";
    }

    if ($scale eq "Major") {
        $script .= "  ticlen: 0.05\n";
        if ($Axis{"time"} eq "y") {
            $script .= "  stubdetails: adjust=0.05,0\n";
        }
        if ($Axis{"order"} =~ /reverse/i) {
            $script .= "  signreverse: yes\n";
        }
    }
    else {
        $script .= "  ticlen: 0.02\n";
    }

    $color .= $Scales{"$scale grid"};

    if (defined($Colors{$color})) { $color = $Colors{$color}; }

    if ($grid) { $script .= "  grid: color=$color\n"; }

    $script .= "\n";

    if ($grid)    # restore areadef
    {

        #proc areadef
        $script .= "#proc areadef\n";
        $script .= "  #clone: A\n";
        $script .= "\n";
    }
}

sub PlotLines {
    my $layer = shift;

    if ($#DrawLines < 0) { return; }

    my @DrawLinesNow;
    undef(@DrawLinesNow);

    foreach my $line (@DrawLines) {
        if ($line =~ /\|$layer\n/) {
            push @DrawLinesNow, $line;
        }
    }

    if ($#DrawLinesNow < 0) { return; }

    foreach my $entry (@DrawLinesNow) {
        chomp($entry);
        $script .= "#proc line\n";

        my ($mode, $at, $from, $till, $color, $width, $points);

        #    $script .= "  notation: scaled\n" ;
        if ($entry =~ /^[12]/) {
            ($mode, $at, $from, $till, $color, $width) = split('\|', $entry);
        }
        else {
            ($mode, $points, $color, $width) = split('\|', $entry);
        }

        $script .= "  linedetails: width=$width color=$color style=0\n";

        if ($mode == 1)    # draw perpendicular to time axis
        {
            if ($Axis{"order"} =~ /reverse/i) { $at = -$at; }

            if ($Axis{"time"} eq "x") {
                if ($from eq "") { $from = $PlotArea{"bottom"} }
                if ($till eq "") {
                    $till = $PlotArea{"bottom"} + $PlotArea{"height"};
                }
                $from += ($width / 200)
                    ;      # compensate for overstrechting of thick lines
                $till -= ($width / 200);
                if ($from > $Image{"height"}) { $from = $Image{"height"}; }
                if ($till > $Image{"height"}) { $till = $Image{"height"}; }
                $script .= "  points: $at(s) $from $at(s) $till\n";
            }
            else {
                if ($from eq "") { $from = $PlotArea{"left"} }
                if ($till eq "") {
                    $till = $PlotArea{"left"} + $PlotArea{"width"};
                }
                $from += ($width / 200);
                $till -= ($width / 200);
                if ($from > $Image{"width"}) { $from = $Image{"width"}; }
                if ($till > $Image{"width"}) { $till = $Image{"width"}; }
                $script .= "  points: $from $at(s) $till $at(s)\n";
            }
        }

        if ($mode == 2)    # draw parralel to time axis
        {
            if ($Axis{"order"} =~ /reverse/i) {
                $from = -$from;
                $till = -$till;
            }

            $from .= "(s)+" . ($width / 200);
            $till .= "(s)-" . ($width / 200);
            if ($Axis{"time"} eq "x") {
                if ($at eq "") { $at = $PlotArea{"bottom"}; }
                if ($at > $Image{"height"}) { $at = $Image{"height"}; }
                $script .= "  points: $from $at $till $at\n";
            }
            else {
                if ($at eq "") { $at = $PlotArea{"left"}; }
                if ($at > $Image{"width"}) { $at = $Image{"width"}; }
                $script .= "  points: $at $from $at $till\n";
            }
        }

        # draw free line
        if ($mode == 3) {
            my @Points = split(",", $points);

            foreach my $point (@Points) {
                $point = &Normalize($point);
            }

            if (   ($Points[0] > $Image{"width"})
                || ($Points[1] > $Image{"height"})
                || ($Points[2] > $Image{"width"})
                || ($Points[3] > $Image{"height"}))
            {
                &Error2(
                    "Linedata attribute 'points' invalid.\n"
                        . sprintf("(%d,%d)(%d,%d)",
                        $Points[0] * 100,
                        $Points[1] * 100,
                        $Points[2] * 100,
                        $Points[3] * 100)
                        . " does not fit in image\n"
                );
                return;
            }
            $script .=
                "  points: $Points[0] $Points[1] $Points[2] $Points[3]\n";
        }
    }

    $script .= "\n";
}

sub ColorPredefined {
    my $color = shift;
    if (
        $color =~
        /^(?:black|white|tan1|tan2|red|magenta|claret|coral|pink|orange|
                     redorange|lightorange|yellow|yellow2|dullyellow|yelloworange|
                     brightgreen|green|kelleygreen|teal|drabgreen|yellowgreen|
                     limegreen|brightblue|darkblue|blue|oceanblue|skyblue|
                      purple|lavender|lightpurple|powderblue|powderblue2)$/xi
        )
    {
        if (!defined($Colors{ lc($color) })) {
            &StoreColor($color, $color, "", $command);
        }
        return ($true);
    }
    else {
        return ($false);
    }
}

# Can be much simpler
sub ValidAbs {
    my $value = shift;
    if ($value =~ /^ \d+ \.? \d* (?:px|in|cm)? $/xi) {
        return ($true);
    }
    else {
        return ($false);
    }
}

# Can be much simpler
sub ValidAbsRel {
    my $value = shift;
    if ($value =~ /^ \d+ \.? \d* (?:px|in|cm|$hPerc)? $/xi) {
        return ($true);
    }
    else {
        return ($false);
    }
}

sub ValidDateFormat {
    my $date = shift;
    my ($day, $month, $year);

    #  if ($date=~ /^\-?\d+$/) # for now full years are always allowed
    #  { return ($true) ; }

    if ($DateFormat eq "yyyy") {
        if (!($date =~ /^\-?\d+$/)) { return ($false); }
        return ($true);
    }

    if ($DateFormat eq "x.y") {
        if (!($date =~ /^\-?\d+(?:\.\d+)?$/)) { return ($false); }
        return ($true);
    }

    if (!($date =~ /^\d\d\/\d\d\/\d\d\d\d$/)) { return ($false); }

    if ($DateFormat eq "dd/mm/yyyy") {
        $day   = substr($date, 0, 2);
        $month = substr($date, 3, 2);
        $year  = substr($date, 6, 4);
    }
    else {
        $day   = substr($date, 3, 2);
        $month = substr($date, 0, 2);
        $year  = substr($date, 6, 4);
    }

    if ($month =~ /^(?:01|03|05|07|08|10|12)$/) {
        if ($day > 31) { return ($false); }
    }
    elsif ($month =~ /^(?:04|06|09|11)$/) {
        if ($day > 30) { return ($false); }
    }
    elsif ($month =~ /^02$/) {
        if (($year % 4 == 0) && ($year % 100 != 0)) {
            if ($day > 29) { return ($false); }
        }
        else {
            if ($day > 28) { return ($false); }
        }
    }
    else { return ($false); }
    return ($true);
}

sub ValidDateRange {
    my $date = shift;
    my ($day, $month, $year, $dayf, $monthf, $yearf, $dayt, $montht, $yeart);

    my $from = $Period{"from"};
    my $till = $Period{"till"};

    if (($DateFormat eq "yyyy") || ($DateFormat eq "x.y")) {
        if (($date < $from) || ($date > $till)) { return ($false); }
        return ($true);
    }

    if ($DateFormat eq "dd/mm/yyyy") {
        $day    = substr($date, 0, 2);
        $month  = substr($date, 3, 2);
        $year   = substr($date, 6, 4);
        $dayf   = substr($from, 0, 2);
        $monthf = substr($from, 3, 2);
        $yearf  = substr($from, 6, 4);
        $dayt   = substr($till, 0, 2);
        $montht = substr($till, 3, 2);
        $yeart  = substr($till, 6, 4);
    }
    if ($DateFormat eq "mm/dd/yyyy") {
        $day    = substr($date, 3, 2);
        $month  = substr($date, 0, 2);
        $year   = substr($date, 6, 4);
        $dayf   = substr($from, 3, 2);
        $monthf = substr($from, 0, 2);
        $yearf  = substr($from, 6, 4);
        $dayt   = substr($till, 3, 2);
        $montht = substr($till, 0, 2);
        $yeart  = substr($till, 6, 4);
    }

    if (
        ($year < $yearf)
        || (
            ($year == $yearf)
            && (   ($month < $monthf)
                || (($month == $monthf) && ($day < $dayf)))
        )
        )
    {
        return ($false);
    }

    if (
        ($year > $yeart)
        || (
            ($year == $yeart)
            && (   ($month > $montht)
                || (($month == $montht) && ($day > $dayt)))
        )
        )
    {
        return ($false);
    }

    return ($true);
}

sub DateMedium {
    my $from = shift;
    my $till = shift;
    if (! defined $from || ! defined $till ) {
    	&Error2("from ($from) or till ($till) is not defined, Returning default to prevent infinite loop");
    	return  "01/01/1800";
    }

    if (($DateFormat eq "yyyy") || ($DateFormat eq "x.y")) {
        return (sprintf("%.3f", ($from + $till) / 2));
    }

    my $from2 = &DaysFrom1800($from);
    my $till2 = &DaysFrom1800($till);
    my $date  = &DateFrom1800(int(($from2 + $till2) / 2));
    return ($date);
}

sub DaysFrom1800 {
    my @mmm = (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    my ($day, $month, $year);
    my $date = shift;
    if ($DateFormat eq "dd/mm/yyyy") {
        $day   = substr($date, 0, 2);
        $month = substr($date, 3, 2);
        $year  = substr($date, 6, 4);
    }
    else {
        $day   = substr($date, 3, 2);
        $month = substr($date, 0, 2);
        $year  = substr($date, 6, 4);
    }
    if ($year < 1800) {
        &Error2("Function 'DaysFrom1800' expects year >= 1800, not '$year'.");
        return;
    }

    my $days = ($year - 1800) * 365;
    $days += int(($year - 1 - 1800) / 4);
    $days -= int(($year - 1 - 1800) / 100);
    if ($month > 1) {
        for (my $m = $month - 2; $m >= 0; $m--) {
            $days += $mmm[$m];
            if ($m == 1) {
                if ((($year % 4) == 0) && (($year % 100) != 0)) { $days++; }
            }
        }
    }
    $days += $day;

    return ($days);
}

sub DateToFloat {
    my $date = shift;
    if ($DateFormat !~ /\//) { return ($date); }
    my $year = $date;
    $year =~ s/.*\///g;    # delete dd mm/mm dd
    my $fraction =
        (&DaysFrom1800($date) - &DaysFrom1800("01/01/" . $year)) / 365.25;
    return ($year + $fraction);
}

sub DateFrom1800 {
    my $days = shift;
    if (! defined $days) {
    	&Error2("days ($days) is not defined, Returning default to prevent infinite loop");
    	return  "01/01/1800";
    }

    my @mmm = (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    my $year = 1800;
    while ($days > 365 + (($year % 4) == 0)) {
        if   ((($year % 4) == 0) && (($year % 100) != 0)) { $days -= 366; }
        else                                              { $days -= 365; }
        $year++;
    }

    my $month = 0;
    while ($days > $mmm[$month]) {
        $days -= $mmm[$month];
        if ($month == 1) {
            if ((($year % 4) == 0) && (($year % 100) != 0)) { $days--; }
        }
        $month++;
    }
    my $day = $days;

    $month++;
    my $date;
    if ($DateFormat eq "dd/mm/yyyy") {
        $date = sprintf("%02d/%02d/%04d", $day, $month, $year);
    }
    else { $date = sprintf("%02d/%02d/%04d", $month, $day, $year); }

    return ($date);
}

sub ExtractText {

    # my $data  = shift;
    my $data2 = shift;
    my $text  = "";

    # special case: allow embedded spaces when 'text' is last attribute
    # $data2 =~ s/\:\:/\@\#\!/g ;
    if ($data2 =~ /text\:[^\:]+$/) {
        $text = $data2;
        $text =~ s/^.*?text\://;

        #   $text =~ s/^\s(.*?)\s*$/$1/ ; ?? ->
        $text  =~ s/^(.*?)\s*$/$1/;
        $text  =~ s/\\n/\n/g;
        $text  =~ s/\"\"/\@\#\$/g;
        $text  =~ s/\"//g;
        $text  =~ s/\@\#\$/"/g;
        $data2 =~ s/text\:.*$//;
    }

    # extract text between double quotes
    $data2 =~ s/\"\"/\@\#\$/g;
    if ($data2 =~ /text\:\s*\"/) {
        $text = $data2;
        $text =~ s/^.*?text\:\s*\"//;

        if (!($text =~ /\"/)) {
            &Error(
                "PlotData invalid. Attribute 'text': no closing \" found.");
            return ("x", "x");
        }

        $text =~ s/\".*$//;
        $text =~ s/\@\#\$/"/g;
        $text =~ s/\\n/\n/g;
    }
    $data2 =~ s/text\:\s*\"[^\"]*\"//;
    $data2 =~ s/\@\#\$/"/g;
    return ($data2, $text);
}

sub ParseText {
    my $text = shift;
    $text =~ s/\_\_/\@\#\$/g;
    $text =~ s/\_/ /g;
    $text =~ s/\@\#\$/_/g;

    $text =~ s/\~\~/\@\#\$/g;
    $text =~ s/\~/\\n/g;
    $text =~ s/\@\#\$/~/g;

    return ($text);
}

sub BarDefined {
    my $bar = shift;
    foreach my $bar2 (@Bars) {
        if (lc($bar2) eq lc($bar)) { return ($true); }
    }

    # not part of barset ? return
    if ($bar !~ /\#\d+$/) {
        return ($false);
    }

    # find previous bar in barset
    my $barcnt = $bar;
    my $barid  = $bar;
    $barcnt =~ s/.*\#(\d+$)/$1/;
    $barid  =~ s/(.*\#)\d+$/$1/;
    $barcnt--;
    $a = $#Bars;
    for (my $b = 0; $b <= $#Bars; $b++) {
        if (lc($Bars[$b]) eq lc($barid . $barcnt)) {
            $b++;
            for (my $b2 = $#Bars + 1; $b2 > $b; $b2--) {
                $Bars[$b2] = $Bars[ $b2 - 1 ];
            }
            $Bars[$b] = lc($bar);
            $BarLegend{ lc($bar) } = " ";
            return ($true);
        }
    }
    return ($false);
}

sub ValidAttributes {
    my $command = shift;

    if ($command =~ /^BackgroundColors$/i) {
        return (CheckAttributes($command, "", "canvas,bars"));
    }

    if ($command =~ /^BarData$/i) {
        return (CheckAttributes($command, "", "bar,barset,link,text"));
    }

    if ($command =~ /^Colors$/i) {
        return (CheckAttributes($command, "id,value", "legend"));
    }

    if ($command =~ /^ImageSize$/i) {
        return (CheckAttributes($command, "", "width,height,barincrement"));
    }

    if ($command =~ /^Legend$/i) {
        return (
            CheckAttributes(
                $command, "",
                "columns,columnwidth,orientation,position,left,top"
            )
        );
    }

    if ($command =~ /^LineData$/i) {
        return (
            CheckAttributes(
                $command,
                "",
                "at,from,till,atpos,frompos,tillpos,points,color,layer,width"
            )
        );
    }

    if ($command =~ /^Period$/i) {
        return (CheckAttributes($command, "from,till", ""));
    }

    if ($command =~ /^PlotArea$/i) {
        return (
            CheckAttributes(
                $command, "", "left,bottom,width,height,right,top"
            )
        );
    }

    if ($command =~ /^PlotData$/i) {
        return (
            CheckAttributes(
                $command,
                "",
                "align,anchor,at,bar,barset,color,fontsize,from,link,mark,shift,text,textcolor,till,width"
            )
        );
    }

    if ($command =~ /^Scale/i) {
        return (
            CheckAttributes(
                $command, "increment,start", "unit,grid,gridcolor,text"
            )
        );
    }

    if ($command =~ /^TextData$/i) {
        return (
            CheckAttributes(
                $command, "",
                "fontsize,lineheight,link,pos,tabs,text,textcolor"
            )
        );
    }

    if ($command =~ /^TimeAxis$/i) {
        return (CheckAttributes($command, "", "orientation,format,order"));
    }

    return ($true);
}

sub CheckAttributes {
    my $name     = shift;
    my @Required = split(",", shift);
    my @Allowed  = split(",", shift);

    my %Attributes2 = %Attributes;

    my $hint = "\nSyntax: '$name =";
    foreach my $required_attribute (@Required) {
        $hint .= " $required_attribute:..";
    }
    foreach my $allowed_attribute (@Allowed) {
        $hint .= " [$allowed_attribute:..]";
    }
    $hint .= "'";

    foreach my $required_attribute (@Required) {
        if (   (!defined($Attributes{$required_attribute}))
            || ($Attributes{$required_attribute} eq ""))
        {
            &Error("$name definition incomplete. $hint");
            undef(@Attributes);
            return ($false);
        }
        delete($Attributes2{$required_attribute});
    }
    foreach my $allowed_attribute (@Allowed) {
        delete($Attributes2{$allowed_attribute});
    }

    my @AttrKeys = keys %Attributes2;
    if ($#AttrKeys >= 0) {
        if ($AttrKeys[0] eq "single") {
            &Error(
                "$name definition invalid. Specify all attributes as name:value pairs."
            );
        }
        else {
            &Error(   "$name definition invalid. Invalid attribute '"
                    . $AttrKeys[0]
                    . "' found. $hint");
        }
        undef(@Attributes);
        return ($false);
    }

    return ($true);
}

sub CheckPreset {
    my $command = shift;
    my ($action, $attrname, $attrvalue);

    my $newcommand = $true;
    my $addvalue   = $true;
    state $prevcommand = q{};
    if (lc $command eq lc $prevcommand) {
        $newcommand = $false;
    }

    if ((!$newcommand) && ($command =~ /^(?:DrawLines|PlotData|TextData)$/i))
    {
        $addvalue = $false;
    }
    $prevcommand = $command;

    foreach my $preset (@PresetList) {
        if ($preset =~ /^$command\|/i) {
            my $attrpreset;
            ($command, $action, $attrname, $attrpreset) =
                split('\|', $preset);
            if ($attrname eq "") { $attrname = "single"; }

            $attrvalue = $Attributes{$attrname};

            if (($action eq "-") && ($attrvalue ne "")) {
                if ($attrname eq "single") {
                    &Error(   "Chosen preset makes this command redundant.\n"
                            . "  Please remove this command.");
                }
                else {
                    &Error("Chosen preset conflicts with '$attrname:...'.\n"
                            . "  Please remove this attribute.");
                }
                $Attributes{$attrname} = "";
            }

            if (($action eq "+") && ($attrvalue eq "")) {
                if ($addvalue) { $Attributes{$attrname} = $attrpreset; }
            }

            if (($action eq "=") && ($attrvalue eq "")) {
                $Attributes{$attrname} = $attrpreset;
            }

            if (   ($action eq "=")
                && ($attrvalue ne "")
                && ($attrvalue !~ /$attrpreset/i))
            {
                if ($attrname eq "single") {
                    &Error(
                        "Conflicting settings.\nPreset defines '$attrpreset'."
                    );
                }
                else {
                    &Error(
                        "Conflicting settings.\nPreset defines '$attrname:$attrpreset'."
                    );
                }
                $Attributes{$attrname} = $attrpreset;
            }
        }
    }
}

sub ShiftOnePixelForSVG {
    my $line = shift;
    $line =~ s/location:\s*//;
    my ($posx, $posy) = split(" ", $line);

    if ($posy =~ /\+/) { ($posy1, $posy2) = split('\+', $posy); }
    elsif ($posy =~ /.+\-/) {
        if ($posy =~ /^\-/) {
            ($sign, $posy1, $posy2) = split('\-', $posy);
            $posy2 = -$posy2;
            $posy1 = "-" . $posy1;
        }
        else { ($posy1, $posy2) = split('\-', $posy); $posy2 = -$posy2 }
    }
    else { $posy1 = $posy; $posy2 = 0; }

    if ($posy1 !~ /(s)/) { $posy += 0.01; }
    else {
        $posy2 += 0.01;
        if    ($posy2 == 0) { $posy = $posy1; }
        elsif ($posy2 < 0)  { $posy = $posy1 . "$posy2"; }
        else                { $posy = $posy1 . "+" . $posy2; }
    }

    $line = "\n  location: $posx $posy";
    return ($line);
}

sub NormalizeURL {
    my $url = shift;
    $url =~ s/(https?)\:?\/?\/?/$1:\/\//
        ;    # add possibly missing special characters
    $url =~ s/ /%20/g;
    return ($url);
}

# wiki style link may include linebreak characters -> split into several wiki links
sub NormalizeWikiLink {
    my $text = shift;

    my $brdouble = $false;
    if ($text =~ /\[\[.*\]\]/) { $brdouble = $true; }

    $text =~ s/\[\[?//;
    $text =~ s/\]?\]//;

    my ($hide, $show) = split('\|', $text);
    if ($show eq "") { $show = $hide; }
    $hide =~ s/\s*\n\s*/ /g;

    my @Show = split("\n", $show);
    $text = "";
    foreach my $part (@Show) {
        if   ($brdouble) { $part = "[[" . $hide . "|" . $part . "]]"; }
        else             { $part = "[" . $hide . "|" . $part . "]"; }
    }
    $text = join("\n", @Show);

    return ($text);
}

sub ProcessWikiLink {
    my $text     = shift;
    my $link     = shift;
    my $hint     = shift;
    my $wikilink = $false;

    chomp($text);
    chomp($link);
    chomp($hint);

    my ($wiki, $title);
    if ($link ne
        "")    # ignore wiki brackets in text when explicit link is specified
    {
        $text =~ s/\[\[ [^\|]+ \| (.*) \]\]/$1/gx;
        $text =~ s/\[\[ [^\:]+ \: (.*) \]\]/$1/gx;

        #   $text =~ s/\[\[ (.*) \]\]/$1/gx ;
    }
    else {
        if ($text =~
            /\[.+\]/)    # keep first link in text segment, remove others
        {
            $link = $text;
            $link =~ s/\n//g;
            $link =~ s/^[^\[\]]*\[/[/x;

            if ($link =~ /^\[\[/) { $wikilink = $true; }

            $link =~ s/^ [^\[]* \[+ ([^\[\]]*) \].*$/$1/x;
            $link =~ s/\|.*$//;
            if ($wikilink) { $link = "[[" . $link . "]]"; }

            $text =~ s/(\[+) [^\|\]]+ \| ([^\]]*) (\]+)/$1$2$3/gx;
            $text =~ s/(https?)\:/$1colon/gx;

            #     $text =~ s/(\[+) [^\:\]]+ \: ([^\]]*) (\]+)/$1$2$3/gx ;  #???

            # remove interwiki link prefix
            $text =~
                s/(\[+) (?:.{2,3}|(?:zh\-.*)|simple|minnan|tokipona) \: ([^\]]*) (\]+)/$1$2$3/gxi
                ;    #???

            $text =~ s/\[+ ([^\]]+) \]+/{{{$1}}}/x;
            $text =~ s/\[+ ([^\]]+) \]+/$1/gx;
            $text =~ s/\{\{\{ ([^\}]*) \}\}\}/[[$1]]/x;
        }
    }

    if ($wikilink) {

        #   if ($link =~ /^\[\[.+\:.+\]\]$/) # has a colon in its name
        if ($link =~
            /^\[\[ (?:.{2,3}|(?:zh\-.*)|simple|minnan|tokipona) \: .+\]\]$/xi
            )    # has a interwiki link prefix
        {

            # This will fail for all interwiki links other than Wikipedia.
            $wiki  = lc($link);
            $title = $link;
            $wiki  =~ s/\[\[([^\:]+)\:.*$/$1/x;
            $title =~ s/^[^\:]+\:(.*)\]\]$/$1/x;
            $title =~ s/ /_/g;
            $link = "http://$wiki.wikipedia.org/wiki/$title";
            $link = &EncodeURL($title);
            if (($hint eq "") && ($title ne "")) { $hint = "$wiki: $title"; }
        }
        else {    # $wiki = "en" ;
            $title = $link;
            $title =~ s/^\[\[(.*)\]\]$/$1/x;
            $title =~ s/ /_/g;
            $link = $articlepath;
            my $urlpart = &EncodeURL($title);
            $link =~ s/\$1/$urlpart/;
            if (($hint eq "") && ($title ne "")) { $hint = "$title"; }
        }
        $hint =~ s/_/ /g;
    }
    else {
        if ($link ne "") { $hint = &ExternalLinkToHint($link); }
    }

    if (($link ne "") && ($text !~ /\[\[/) && ($text !~ /\]\]/)) {
        $text = "[[" . $text . "]]";
    }

    $hint = &EncodeHtml($hint);
    return ($text, $link, $hint);
}

sub ExternalLinkToHint {
    my $hint = shift;
    $hint =~ s/^https?\:?\/?\/?//;
    $hint =~ s/\/.*$//;
    return (&EncodeHtml($hint . "/.."));
}

sub EncodeInput {
    my $text = shift;

    # revert encoding of '<' & '>' by MediaWiki
    $text =~ s/\&lt\;/\</g;
    $text =~ s/\&gt\;/\>/g;
    $text =~
        s/([\`\{\}\%\&\@\$\(\)\;\=])/"%" . sprintf ("%X", ord($1)) . "%";/ge;
    return ($text);
}

sub DecodeInput {
    my $text = shift;
    $text =~ s/\%([0-9A-F]{2})\%/chr(hex($1))/ge;
    return ($text);
}

sub EncodeHtml {
    my $text = shift;
    $text =~ s/([\<\>\&\'\"])/"\&\#" . ord($1) . "\;"/ge;
    $text =~ s/\n/<br>/g;
    return ($text);
}

sub EncodeURL {
    my $url = shift;

    # For some reason everything gets run through this weird internal
    # encoding that's similar to URL-encoding. Armor against this as well,
    # or else adjacent encoded bytes will be corrupted.
    $url =~ s/([^0-9a-zA-Z\%\:\/\._])/"%25%".sprintf ("%02X",ord($1))/ge;
    return ($url);
}

sub Error {
    my $msg = &DecodeInput(shift);
    $msg =~ s/\n\s*/\n  /g;    # indent consecutive lines

    $CntErrors++;
    if (!$listinput) {
        push @Errors, "Line $LineNo: " . &DecodeInput($Line) . "\n";
    }
    push @Errors, "- $msg\n\n";
    if ($CntErrors > 10) { &Abort("More than 10 errors found"); }
}

sub Error2 {
    my $msg = &DecodeInput(shift);
    $msg =~ s/\n\s*/\n  /g;    # indent consecutive lines
    $CntErrors++;
    push @Errors, "- $msg\n";
}

sub Warning {
    my $msg = &DecodeInput(shift);
    $msg =~ s/\n\s*/\n  /g;    # indent consecutive lines
    if (!$listinput) {
        push @Warnings, "Line $LineNo: " . &DecodeInput($Line) . "\n";
    }
    push @Warnings, "- $msg\n\n";
}

sub Warning2 {
    my $msg = &DecodeInput(shift);
    $msg =~ s/\n\s*/\n  /g;    # indent consecutive lines
    push @Warnings, "- $msg\n";
}

sub Info {
    my $msg = &DecodeInput(shift);
    $msg =~ s/\n\s*/\n  /g;    # indent consecutive lines
    if (!$listinput) {
        push @Info, "Line $LineNo: " . &DecodeInput($Line) . "\n";
    }
    push @Info, "- $msg\n\n";
}

sub Info2 {
    my $msg = &DecodeInput(shift);
    $msg =~ s/\n\s*/\n  /g;    # indent consecutive lines
    push @Info, "- $msg\n";
}

sub Abort {
    my $msg = &DecodeInput(shift);

    print "\n\n***** " . $msg . " *****\n\n";
    print @Errors;
    print "Execution aborted.\n";

    open "FILE_OUT", ">", $file_errors;
    print FILE_OUT
        "<p>EasyTimeline $VERSION</p><p><b>Timeline generation failed: "
        . &EncodeHtml($msg)
        . "</b></p>\n";
    foreach my $line (@Errors) {
        print FILE_OUT &EncodeHtml($line) . "\n";
    }
    close "FILE_OUT";

    # generate html test file, which would normally contain png + svg (+ image map)
    if ($makehtml) {
        open "FILE_IN",  "<", $file_errors;
        open "FILE_OUT", ">", $file_html;
        print FILE_OUT
            "<html><head>\n<title>Graphical Timelines - HTML test file</title>\n</head>\n"
            . "<body><h1><font color='green'>EasyTimeline</font> - Test Page</h1>\n\n"
            . "<code>\n";
        print FILE_OUT <FILE_IN>;
        print FILE_OUT "</code>\n\n</body>\n</html>";
        close "FILE_IN";
        close "FILE_OUT";
    }
    exit;
}

sub EscapeShellArg {
    my $arg = shift;
    if ($env eq "Linux") {
        $arg =~ s/'/\\'/;
        $arg = "'$arg'";
    }
    else {
        $arg =~ s/"/\\"/;
        $arg = "\"$arg\"";
    }
    return $arg;
}

# vim: set sts=2 ts=2 sw=2 et :

sub UnicodeToAscii {
    my $unicode = shift;
    my $char    = substr($unicode, 0, 1);
    my $ord     = ord($char);
    my $value;

    if ($ord < 128)    # plain ascii character
    {
        return ($unicode);
    }                  # (will not occur in this script)
    else {

        # for completeness sake complete routine, only 2 byte unicodes sent here
        if    ($ord >= 252) { $value = $ord - 252; }
        elsif ($ord >= 248) { $value = $ord - 248; }
        elsif ($ord >= 240) { $value = $ord - 240; }
        elsif ($ord >= 224) { $value = $ord - 224; }
        else                { $value = $ord - 192; }
        for (my $c = 1; $c < length($unicode); $c++) {
            $value = $value * 64 + ord(substr($unicode, $c, 1)) - 128;
        }

        #   $html = "\&\#" . $value . ";" ; any unicode can be specified as html char

        if (($value >= 128) && ($value <= 255)) {
            return (chr($value));
        }
        else {
            return "?";
        }
    }
}
