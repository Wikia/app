(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro

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
 * This file is used to split a wiki into a series of smaller files, each consisting 
 * of a given number of pages.  This enables us to break up the analysis of a large
 * wiki into manageable chunks (in case of failures, etc). 
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

(* To compile: 
   ocamlopt   -c splitwiki.ml
   ocamlopt -o splitwiki   str.cmxa unix.cmxa  splitwiki.cmx
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

let chunk_n_pages = ref 1000
let init_offset = ref 0 (* The offset is useful to resume interrupted work *)
let filename_prefix = ref "wiki_";;
let in_file = ref stdin;;
let set_in_file s = in_file := open_in s;;
let compress_cmd = ref "gzip";;
let command_line_format = [("-n", Arg.Set_int chunk_n_pages, "N. of pages in each chunk (default: 1000)");
                           ("-o", Arg.Set_int init_offset, "Offset: n. of chunks to ignore before starting to split"); 
                           ("-p", Arg.Set_string filename_prefix, "Prefix for output files ( default: wiki_ )");
                           ("-i", Arg.String set_in_file,  "Input file  (default: stdin)"); 
                           ("-c", Arg.Set_string compress_cmd, "Command used to compress the file (default: gzip)")
];;

let _ = Arg.parse command_line_format ignore "Usage: cat wikifile.xml | splitwiki" ;;

let has_tag r s = 
  try 
    ignore (Str.search_forward r s 0); 
    true
  with Not_found -> 
    false;;

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

(* Skips to beginning of wiki, storing the preamble *)
let e = ref true in 
while !e do begin 
    let s = input_line !in_file in
    preamble := !preamble ^ s ^ "\n"; 
    if (has_tag tag_siteinfo_end s) then e := false
end done; 

(* Here is the main loop *)
(* This is the number of chunk being created *)
let chunk_idx = ref 0 in 
let n_pages_read = ref 0 in 
let f = ref None in (* File name where to write *) 
let f_name = ref "" in
let d_name = ref "" in 
Printf.printf "\nchunk_n_pages: %d \n" !chunk_n_pages; 
(* init_offset is the number of chunks to split; converts it to the n. of pages *)
init_offset := !init_offset * !chunk_n_pages;
(* Ok, now there is a sequence of pages *)
let do_more = ref true in 
while !do_more do 
  begin 
    if !n_pages_read >= !init_offset then begin 
      (* Printf.printf "\nWriting chunk index %08d " !chunk_idx; *)
      (* Opens the file for the chunk, and writes the preamble in it *)
      d_name := !filename_prefix ^ (Printf.sprintf "/%03d/" (!chunk_idx / 1000));
      f_name := !d_name ^ "wiki-" ^ (Printf.sprintf "%08d.xml" !chunk_idx);
      (* Creates the directory if needed *)
      if (!chunk_idx mod 1000 = 0) then ignore (Sys.command ("mkdir " ^ !d_name));
      let fp = open_out !f_name in 
      f := Some fp; 
      output_string fp !preamble
    end else begin 
      Printf.printf "\nSkipping chunk index %08d " !chunk_idx; 
    end; 
    (* Now writes the specified number of pages in the file *)
    let pages_written = ref 0 in 

    (* Printf.printf "\nBeginning to read a chunk\n"; flush stdout;  debug *)

    while !do_more && (!pages_written < !chunk_n_pages) do 
      begin
	(* Finds the start of a new page, if there is one *)
	let s = 
	  try 
	    input_line !in_file 
	  with End_of_file -> begin
	    do_more := false; 
	    print_string "Reached the end of the input.\n"; 
	    flush stdout; 
	    "</mediawiki>"
	  end 
	in 
	begin 
	  match !f with 
	    Some fp -> begin 
	      output_string fp s; 
	      output_string fp "\n"
	    end
	  | None -> ()
	end; 

	(* Printf.printf "\nBeginning to read a page\n"; flush stdout;  debug *)
	Printf.fprintf stderr "."; flush stderr; 
	
	if (has_tag tag_page_start s) then 
	  begin 
	    (* Ok, a page has started *)
	    let do_more_page = ref true in 
	    while !do_more_page do 
	      begin 
		(* Reading the fields of the page *)
		let s = input_line !in_file in 
		begin 
		  match !f with 
		    Some fp -> begin 
		      output_string fp s; 
		      output_string fp "\n"
		    end 
		  | None -> ()
		end;  
		if (has_tag tag_page_end s) then do_more_page := false; 
	      end 
	    done;  (* while !do_more_page *)
	    pages_written := !pages_written + 1; 
	    n_pages_read := !n_pages_read + 1
	  end (* if page tag start found *)
      end
    done; (* loops for all pages of a chunk *)

    chunk_idx := !chunk_idx + 1; 
    match !f with 
      Some fp -> begin 
	(* writes the end-of-wiki marker if needed *)
	if !do_more then output_string fp "\n</mediawiki>\n"; 
	(* closes the file *)
	close_out fp; 
	(* and compresses it *)
	do_more := (0 = Sys.command (!compress_cmd ^ " " ^ !f_name ^ "&")) && !do_more 
      end
    | None -> ()
  end
done;; (* loop over all pages *)

