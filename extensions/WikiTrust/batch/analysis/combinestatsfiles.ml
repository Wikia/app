(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Gillian Smith, Luca de Alfaro

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

(* Combine stats files uses bucket sort to combine all of the statistics files in a specified directory.
 * It writes its output to a specified file
 * USAGE:
 *     ARG1: stat file directory
 *     ARG2: output directory
 *     ARG3: number of buckets (optional, temporary)
 *)

let filetype = ".stats"

let usage_message = "Usage: combinestats [<directory>]\nAll *.stats files in <directory> will be sorted\n"

let dirname = ref ""
let outfile = ref ""
let outdir  = ref "SORTEDSTATS/"
let numbuckets = ref 1750
let max_lines_in_mem = ref 5000

let tempbuckets = Hashtbl.create 1750
let sortedfilelist = ref ""
(* Get command line arguments *)
let set_dirname (s: string) = dirname := s
let set_outfile (s: string) = outfile := s
let set_outdir  (s: string) = outdir  := s
let set_numbuckets (s: string) = numbuckets := (int_of_string s)
let set_max_lines_in_mem (n) = max_lines_in_mem := n

let command_line_format = [("-outfile", Arg.String (set_outfile),
			    "write entire sorted output to this file (if empty, large output not produced)");
			   ("-outdir",  Arg.String (set_outdir),
			    "write split sorted files to this directory (defaults to ./SORTEDSTATS/)");
			   ("-n", Arg.String (set_numbuckets),
			    "number of buckets (default: 1750, limit: 9999)");
			   ("-flush", Arg.Int (set_max_lines_in_mem),
			    "number of lines to read into memory before flushing to disk (default: 5000)")
			  ]


let _ = Arg.parse command_line_format set_dirname usage_message;;
  
if !dirname = "" then Arg.usage command_line_format usage_message;;
    
(* Create a temporary working directory *)
try Unix.mkdir !outdir 0o740 with e -> begin print_string "Warning: output file directory already exists.\n"; flush stdout end;;

(* Create the temp files ("buckets") *)
for i = 1 to !numbuckets do
  let commandtext = "touch " ^ !outdir ^ (Printf.sprintf "/stats%04d.tstats" i) in 
  ignore (Unix.system commandtext)
done;;

(* Open the stat file directory *)
let statfile_dir = Unix.opendir !dirname;;

let flush_tmp () =
 (* Now writes the hashtable *)
    for i = 1 to !numbuckets do begin 
      let filename = !outdir ^ (Printf.sprintf "/stats%04d.tstats" i) in 
      let file = open_out_gen [Open_append] 0o640 filename in
      (* Gets all lines *)
      let lines_list = Hashtbl.find_all tempbuckets i in 
      let p (l: string) = begin output_string file l; output_string file "\n"; end in 
      List.iter p lines_list;
      close_out file
    end done;
  Hashtbl.clear tempbuckets
in
 
(* This function processes one .stat file *)
let bucketize_file () = 
  (* raises End_of_file when we are done *)
  let lines_read = ref 0 in
  let filename = Unix.readdir statfile_dir in
  (*If it's one of filetype -- NOTE: should replace this with regexp*)
  if (filename <> ".") && (filename <> "..")
    && ((String.length filename) > ((String.length filetype) + 1))
    && ((Str.string_after filename ((String.length filename) - (String.length filetype))) = filetype)
  then begin 
    (* Opens the file *)
    print_string ("Processing: " ^ filename ^ "\n"); flush stdout; 
    let infile = open_in (!dirname ^ filename) in
    let file_todo = ref true in 
    while !file_todo do begin 
      let line = try 
	  input_line infile
	with End_of_file -> begin
	  file_todo := false;
	  ""
	end
      in 
      if !file_todo then begin 
	let l = Str.split (Str.regexp "[ \t]+") line in 
	if (List.length l) > 2 then begin 
	  (* Shorter than 2, and it's not a line that needs sorting *)
	  let timestamp = float_of_string (List.nth l 1) in 
	  let bound num = max 1 (min !numbuckets num) in 
	  let bucketnum = bound ((int_of_float (timestamp/.100000.)) - 10000) in
	  Hashtbl.add tempbuckets bucketnum line;
	  lines_read := !lines_read + 1;
	  if !lines_read >= !max_lines_in_mem then flush_tmp ()
	end
      end 
    end done; (* while loop over lines of file *)
  flush_tmp ();
  end (* bucketize_file *)
in 
(* Bucketizes all files *)
try
  while true do bucketize_file () done
with End_of_file -> ();;
Unix.closedir statfile_dir;;

(* Now sort each of the files *)
for i = 1 to !numbuckets do begin 
  let filename = !outdir ^ (Printf.sprintf "/stats%04d.tstats" i) in 
  let outfilename = !outdir ^ (Printf.sprintf "/stats%04d.sorted" i) in 
  let commandtext = ("sort -n -k 2,2 " ^ filename ^ " > " ^ outfilename) in
  print_string ("Sorting: " ^ filename ^ "\n"); flush stdout;
  ignore (Unix.system commandtext);
  ignore (Unix.system ("rm " ^ filename))
end done;;

(* And concatenate all the sorted files together *)
if !outfile <> "" then begin 
  print_string "Concatenating the result into a single file...\n"; flush stdout; 
  for i = 1 to !numbuckets do begin 
    let filename = !outdir ^ (Printf.sprintf "/stats%04d.sorted" i) in 
    sortedfilelist := (!sortedfilelist ^ " " ^ filename)
  end done;
  ignore (Unix.system ("cat " ^ !sortedfilelist ^ " > " ^ !outfile))
end;;
