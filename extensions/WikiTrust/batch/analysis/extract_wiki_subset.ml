(*

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

 *)


(* 
 * This program extracts from a large wiki dump a subset of pages
 *)

(*  This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *)

(* Tags *)
let tag_siteinfo_start    = Str.regexp "<mediawiki"
let tag_siteinfo_end      = Str.regexp "</siteinfo>"
let tag_page_start     = Str.regexp "<page>"
let tag_page_end       = Str.regexp "</page>"
let tag_id             = Str.regexp "<id>\\(.*\\)</id>"
let tag_title          = Str.regexp "<title>\\(.*\\)</title>"
let tag_rev_start      = Str.regexp "<revision>"
let tag_rev_end        = Str.regexp "</revision>"
let tag_timestamp      = Str.regexp "<timestamp>\\(.*\\)</timestamp>"
let tag_comment        = Str.regexp "<comment>\\(.*\\)</comment>"
let tag_user_start     = Str.regexp "<contributor>"
let tag_user_end       = Str.regexp "</contributor>"
let tag_username       = Str.regexp "<username>\\(.*\\)</username>"
let tag_text_start     = Str.regexp "<text xml:space=\"preserve\">"
let tag_text_end       = Str.regexp "</text>"
let tag_the_end        = Str.regexp "</mediawiki>"

type state_t = In_Interesting_Page | Out_Interesting_Page | Out_Any_Id;;
let page_ids = Hashtbl.create 100;;
let page_id_file = ref stdin;;
let set_page_id_file s = page_id_file := open_in s;;
let output_filename = ref "wiki";;
let in_file = ref stdin;;
let set_in_file s = in_file := open_in s;;
let compress_cmd = ref "gzip";;
let command_line_format = [
                           ("-t", Arg.String set_page_id_file, "Target Ids file. A file containing a list of pages ids to extract, with 1 id on each line"); 
                           ("-o", Arg.Set_string output_filename, "Output filename ( default: wiki )");
                           ("-i", Arg.String set_in_file,  "Input file  (default: stdin)"); 
                           ("-c", Arg.Set_string compress_cmd, "Command used to compress the file (default: gzip)")
];;

let _ = Arg.parse command_line_format ignore "Usage: cat wikifile.xml | extract_wiki_subset" ;;

let is_of_interest tag =
  try
    let id = Str.matched_group 1 tag in
      Hashtbl.find page_ids id
  with Not_found -> false
;;

let has_tag r s = 
  try 
    ignore (Str.search_forward r s 0); 
    true
  with Not_found -> 
    false;;

(* Write the list to disk, line by line *)
let rec write_buffer lst fp =
  match lst with
    | hd :: tl -> (
	output_string fp hd; 
	output_string fp "\n";
	write_buffer tl fp
      )
    | [] -> ()
;;

(* Writes the given list to output f, line by line *)
let flush_cache lst f =
  match f with 
      Some fp -> write_buffer (List.rev lst) fp; flush fp
    | None -> ()
;;

let suffix s i = 
  let l = String.length s in 
  let k = l - i in 
  String.sub s i k 

let prefix s i = String.sub s 0 i;;

let preamble = ref "";;

let e = ref true in 
while !e do begin 
    let s = input_line !in_file in
    if (has_tag tag_siteinfo_start s) then begin 
      e := false;
      preamble := (suffix s (Str.match_beginning ())) ^ "\n"
    end
end done; 

(* Reads the page id file, storing it in memory as a Hashtbl *)
let e = ref true in 
while !e do begin 
  try 
    Hashtbl.add page_ids (input_line !page_id_file) true;
  with End_of_file -> e := false;
end done;
  
(* Skips to beginning of wiki, storing the preamble *)
let e = ref true in 
while !e do begin 
    let s = input_line !in_file in
    preamble := !preamble ^ s ^ "\n"; 
    if (has_tag tag_siteinfo_end s) then e := false
end done; 

(* returns the next line of the input file *)
let get_line input =
  try 
    Some (input_line input) 
  with
      End_of_file -> None
in

(* Here is the main loop *)
let rec process_file gl input output buffer state pages_read pages_extracted = 
  let next_line = gl input in
    match next_line with
      | Some s -> (
	  match state with 
	    | In_Interesting_Page -> (
		if (has_tag tag_page_end s) 
		then (flush_cache (s :: buffer) output; 
		      process_file gl input output [] Out_Interesting_Page 
			(pages_read + 1) (pages_extracted + 1)) 
		else 
		  process_file gl input output (s :: buffer) 
		    In_Interesting_Page pages_read pages_extracted
	      )
	    | Out_Any_Id -> (
		if (has_tag tag_id s) && (is_of_interest s) then (
		  print_string "*"; flush stdout;
		  process_file gl input output (s :: buffer) 
		    In_Interesting_Page pages_read pages_extracted )
		else (
		  if (has_tag tag_id s) then (
		    print_string "."; flush stdout;
		    process_file gl input output [] Out_Interesting_Page 
		      pages_read pages_extracted )
		  else
		    process_file gl input output (s :: buffer) Out_Any_Id 
		      pages_read pages_extracted
		)
	      )
	    | Out_Interesting_Page -> (
		if (has_tag tag_page_end s) 
		then  
		  process_file gl input output [] Out_Any_Id 
		    (pages_read + 1) pages_extracted
		else 
		  process_file gl input output [] Out_Interesting_Page 
		    pages_read pages_extracted
	      )
	)
      | None -> (
	  flush_cache [  "</mediawiki>" ] output;
	  (pages_read, pages_extracted)
	)
in

let fp = open_out !output_filename in 
  output_string fp !preamble;
  print_endline "";
  let res = process_file get_line !in_file (Some fp) [] Out_Any_Id 0 0 in
    print_endline "";
    
    (* Compress the output file *)
    ignore (Sys.command (!compress_cmd ^ " " ^ !output_filename ^ "&"));

    (* And say what we did *)
    match res with
      | x,y -> print_endline ("Processed " ^ (string_of_int x) ^ (" Pages, of which I extracted ") ^ (string_of_int y))
