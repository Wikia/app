(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler, Vishwanath Raman, Ian Pye

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

(* This module contains the function do_eval, which performs the evaluation of an .xml file, 
   producing any required output. *)

(* Tags *)
let tag_siteinfo_start    = Str.regexp "<mediawiki"
let tag_siteinfo_end      = Str.regexp "</siteinfo>"
let tag_page_start        = Str.regexp "<page>"
let tag_page_end          = Str.regexp "</page>"
let tag_id                = Str.regexp "<id>\\(.*\\)</id>"
let tag_ip                = Str.regexp "<ip>\\(.*\\)</ip>"
let tag_title             = Str.regexp "<title>\\(.*\\)</title>"
let tag_rev_start         = Str.regexp "<revision>"
let tag_rev_end           = Str.regexp "</revision>"
let tag_timestamp         = Str.regexp "<timestamp>\\(.*\\)</timestamp>"
let tag_minor             = Str.regexp "<minor />"
let tag_comment           = Str.regexp "<comment>\\(.*\\)</comment>"
let tag_contributor_start = Str.regexp "<contributor>"
let tag_contributor_end   = Str.regexp "</contributor>"
let tag_username          = Str.regexp "<username>\\(.*\\)</username>"
let tag_text_start        = Str.regexp "<text xml:space=\"preserve\">"
let tag_text_end          = Str.regexp "</text>"
let tag_the_end           = Str.regexp "</mediawiki>"

exception ProcError

(* Some tiny helper functions *)
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

let prefix s i = 
  String.sub s 0 i 

let print_vec v = 
  let p i = Printf.printf " %s" i in 
  Printf.printf "["; Vec.iter p v; Printf.printf " ]\n"
    

(* It is a silly idea to read a line without the final \n! *)
let input_line_cr fp = (input_line fp) ^ "\n"

(* This is the function that does all the work *)
let do_eval 
    (* The page factory that is in charge of analyzing pages *)
    (factory: Page_factory.page_factory) 
    (* The input xml stream to analyze (already open) *)
    (in_file: in_channel)
    : unit =

  (* This function reads a revision, and passes it to the page created by the page factory *)
  let read_revisions p page_id = 
    (* Writes the title, if needed *)
    p#print_id_title; 
    let do_more_page = ref true in 
    while !do_more_page do 
      begin 
	(* Reads all the revisions of a page *)
	let rev_id = ref 0 in 
	let rev_uid = ref 0 in 
	let rev_ip = ref "" in 
	let rev_timestamp = ref "" in 
	let rev_time = ref 0. in 
	let rev_contributor = ref "" in 
	let rev_comment = ref "" in 
	let rev_username = ref "" in 
	let rev_is_minor = ref false in 
	let rev_text = ref (Textbuf.cr ()) in 
	let do_more_rev = ref true in 
	while !do_more_rev do 
	  begin 
	    (* Reading the fields of a revision *)
	    let s = input_line_cr in_file in 
	    if (has_tag tag_id s) then begin 
	      try
		rev_id := int_of_string (Str.matched_group 1 s)
	      with Not_found -> ()
	    end; 
	    if (has_tag tag_timestamp s) then begin 
	      rev_timestamp := Str.matched_group 1 s; 
	      try 
		rev_time := Timeconv.convert_time !rev_timestamp
	      with Not_found -> ()
	    end; 
	    if (has_tag tag_contributor_start s) then 
	      begin 
		(* Reads the user data *)
		let do_more_user = ref true in
		rev_uid := 0; 
		while !do_more_user do 
		  begin 
		    let s = input_line_cr in_file in 
		    if (has_tag tag_id s) then begin 
		      try 
			rev_uid := int_of_string (Str.matched_group 1 s) 
		      with Not_found -> ()
		    end; 
		    if (has_tag tag_username s) then begin 
		      try 
			rev_username := Str.matched_group 1 s
		      with Not_found -> () 
		    end; 
		    if (has_tag tag_ip s) then begin 
		      try
			rev_ip := Str.matched_group 1 s 
		      with Not_found -> ()
		    end;
		    if (has_tag tag_contributor_end s) 
		    then do_more_user := false
		      (* accumulates contributor string *)
		    else rev_contributor := !rev_contributor ^ s 
		  end
		done
	      end; (* read user data *)
	    if (has_tag tag_minor s) then begin 
	      rev_is_minor := true
	    end; 
	    if (has_tag tag_comment s) then begin 
	      try 
		rev_comment := Str.matched_group 1 s 
	      with Not_found -> ()
	    end; 
	    if (has_tag tag_text_start s) then 
	      begin 
		(* Ok, this is the revison text *)
		let t = ref (suffix s (Str.match_end ())) in 
		let do_more_text = ref true in 
		while !do_more_text do 
		  begin 
		    if (has_tag tag_text_end !t) then begin 
		      rev_text := Textbuf.add (prefix !t (Str.match_beginning ())) !rev_text; 
		      do_more_text := false
		    end
		    else begin
		      rev_text := Textbuf.add !t !rev_text;
		      t := input_line_cr in_file 
		    end
		  end
		done
	      end;
	    if (has_tag tag_rev_end s) then 
	      begin 
		(* Ok, now I have all the text. I can create the revision, and 
		   add it to the page. *)
		p#add_revision 
		  !rev_id page_id !rev_timestamp !rev_time 
		  !rev_contributor !rev_uid !rev_ip !rev_username 
		  !rev_is_minor !rev_comment (Textbuf.get !rev_text);
		do_more_rev := false 
	      end
	  end
	done; (* while !do_more_rev *)
	(* Now we must check: either there is another revision to be done, 
	   or the page ends *)
	do_more_rev := true; 
	while !do_more_rev do 
	  begin 
	    let s = input_line_cr in_file in 
	    (* This reads illogical, but it goes to the next rev of the page, which is correct *)
	    if (has_tag tag_rev_start s) then do_more_rev := false; 
	    if (has_tag tag_page_end s) then begin
	      do_more_rev := false;
	      do_more_page := false
	    end
	  end
	done
      end
    done; (* while !do_more_page *)
    (* Now is the time to evaluate a page, or to finish its evaluation *)
    p#eval
  in 

  (* Skips to beginning of the preamble
     (some of our chopped wikis contain junk at the beginning) *)
  let preamble = ref "" in 
  let e = ref true in 
  while !e do begin 
    let s = input_line_cr in_file in
    if (has_tag tag_siteinfo_start s) then begin 
      e := false;
      preamble := (suffix s (Str.match_beginning ()))
    end
  end done; 

  (* Skips to beginning of wiki, storing the preamble *)
  let e = ref true in 
  while !e do begin 
    let s = input_line_cr in_file in
    preamble := !preamble ^ s;
    if (has_tag tag_siteinfo_end s) then e := false
  end done;

  (* If we are coloring, prints the preamble out on the wiki trust file *)
  factory#output_preamble !preamble; 

  (* Ok, now there is a sequence of pages *)
  let do_more = ref true in 
  while !do_more do
    begin
      (* Finds the start of a new page, if there is one *)
      let s = 
	try 
	  input_line_cr in_file 
	with End_of_file -> begin
	  do_more := false; 
	  factory#output_preamble "</mediawiki>\n";
	  ""
	end 
      in 
      if !do_more && (has_tag tag_page_start s) then 
	begin 
	  (* Ok, a page has started *)
	  let do_more_page = ref true in 
	  let page_title = ref "" in 
	  let page_id = ref (-1) in 
	  while !do_more_page do 
	    begin 
	      (* Reading the fields of the page *)
	      let s = input_line_cr in_file in 
	      if (has_tag tag_title s) then begin 
		try 
		  page_title := Str.matched_group 1 s
		with Not_found -> ()
	      end;
	      (* The check for !page_id < 0 is there because there are many ids
		 in a page, and we only want the first one to matter as page id.
		 (this is important only if the page is skipped) *)
	      if !page_id < 0 && (has_tag tag_id s) then begin
		try
		  page_id := int_of_string (Str.matched_group 1 s)
		with Not_found -> ()
	      end; 
	      if (has_tag tag_page_end s) then do_more_page := false; 
	      (* If the revisions start, and the page title does not contain ":", 
		 then this is a page in the main namespace, and we need to examine it. 
		 If the page title contains ":", the page is skipped. *)
	      if (has_tag tag_rev_start s) then begin 
		(* Creates the appropriate page object, depending on whether the page
		   is in the main name space (no ':' in title), or in a secondary 
		   name space *)
		let p = 
		  if String.contains !page_title ':'
		  then factory#make_colon_page !page_id !page_title
		  else factory#make_page !page_id !page_title
		in
		read_revisions p !page_id; 
		do_more_page := false
	      end
	    end 
	  done (* while !do_more_page *)
	end (* if page tag start found *)
    end (* loops over all pages *)
  done

(* Does the evaluation on a single file that comes from stdin *)
let do_single_eval 
    (factory: Page_factory.page_factory)
    (f_in: in_channel)
    (f_out: out_channel) = 
  factory#set_single_file f_out; 
  do_eval factory f_in;
  factory#close_out_files

(* Does the evaluation on multiple files, even uncompressing them if needed. 
   It returns the list of file names created. *)
let do_multi_eval 
    (input_files: string Vec.t) 
    (factory: Page_factory.page_factory)
    (working_dir: string) 
    (unzip_cmd: string)
    (continue: bool) : string Vec.t = 
  let output_names = ref Vec.empty in 
  for file_idx = 0 to (Vec.length input_files) - 1 do begin 
    (* We must set in_file, out_file *) 
    let in_file = Vec.get file_idx input_files in 
    (* We need to add manually track of this file, since we do not read it 
       with a normal open_in *)
    Fileinfo.track_file in_file; 
    let local_in_file = try 
	let pos_slash = Str.search_backward (Str.regexp "/") in_file ((String.length in_file) - 1)
	in Str.string_after in_file pos_slash
      with Not_found -> in_file in 
    let base_name = try 
	let pos_xml = Str.search_forward (Str.regexp ".xml") local_in_file 0 
	in Str.string_before local_in_file pos_xml
      with Not_found -> local_in_file in 
    (* Opens the output files *)
    let new_output_names = factory#open_out_files (working_dir ^ base_name) in 
    output_names := Vec.concat !output_names new_output_names; 
    let in_f = ref stdin in 
    let use_decomp = ref false in 
    try 
      begin 
	if String.length in_file > 4 then begin 
	  if Str.last_chars in_file 4 <> ".xml" then begin 
	    (* We need to uncompress the file *)
	    use_decomp := true;
	    let forked = ref false in 
	    while not !forked do begin 
	      forked := begin 
		try 
		  in_f := Unix.open_process_in (unzip_cmd ^ " " ^ in_file); 
		  true
		with Unix.Unix_error (Unix.EAGAIN, _, _) -> false 
	      end
	    end done; (* while *)
	    (* Waits a bit before reading from the pipe *)
	    Unix.sleep 1
	  end else in_f := Fileinfo.open_info_in in_file
	end else in_f := Fileinfo.open_info_in in_file; 
	(* Both in and out files are open.  Does the evaluation *)
	do_eval factory !in_f;
	(* Closes the files *)
	factory#close_out_files; 

	if !use_decomp then begin 
	  try ignore (Unix.close_process_in !in_f) 
	  with Unix.Unix_error (Unix.ECHILD, _, _) -> ()
	end else Fileinfo.close_info_in !in_f 
      end
    with x -> begin 
      Printf.fprintf stderr "Error while processing input %s\n" in_file; 
      if continue then begin 
	begin try 
	    if !use_decomp 
	    then ignore (Unix.close_process_in !in_f) 
	    else Fileinfo.close_info_in !in_f with  _ -> () 
	end; 
	begin try factory#close_out_files with _ -> () end
      end else raise x 
    end
  end done;
  !output_names

