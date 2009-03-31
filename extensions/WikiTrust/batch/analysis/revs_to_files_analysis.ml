(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, Ian Pye

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


(** This module contains a class that: 
    1) Writes each revision in a separate disk file, named after the revision id. 
    2) Produces an xml file containing empty revision text, that can be used e.g. 
       via mwdumper to load all revision information (but not the revision itself) 
       in the DB for a wiki installation. *)

type word = string 
open Eval_defs

(* This creates the directory name, and the directory *)
let make_dir_name (id: int) (base_name: string) : string = 
  (* Computes the directory name *)
  let s = Printf.sprintf "%012d" id in 
  let dir_name = base_name ^ "/" ^ (String.sub s 0 3) ^ "/" ^ (String.sub s 3 3) ^ "/" ^ 
    (String.sub s 6 3) ^ "/" ^ (String.sub s 9 3) ^ "/" in 
  (* And makes the directory *)
  let d = ref base_name in 
  begin try 
      Unix.mkdir !d 0o755
    with Unix.Unix_error (Unix.EEXIST, _, _) -> () end; 
  for i = 0 to 3 do begin 
    d := !d ^ "/" ^ (String.sub s (i * 3) 3); 
    begin try 
	Unix.mkdir !d 0o755
      with Unix.Unix_error (Unix.EEXIST, _, _) -> () end
  end done; 
  dir_name
	  

(** [page id title base_name digits_per_dir dir_depth]
    writes each revision individually out to disk, in a directory 
    named [base_name]/[part1]/[part2]/.../[part4]/[revision_id.xml], 
    where each of [parti] has length 3
    characters.  The directory name is based on the page id. *)

class page 
  (id: int)
  (title: string)
  (base_name: string)
  (out_file: out_channel)
  =
  object (self) 

    (* At the first revision, it has to write the beginning of the page out. 
       This flag is used to recognize the first revision *)
    val mutable is_first : bool = true 

    (* Prefix for revision file *)
    val file_prefix : string = make_dir_name id base_name

    (* No titles in the xml file! *)
    method print_id_title = ()
 
    (** This method is called to add a new revision to be evaluated for trust. *)
    method add_revision 
      (rev_id: int) (* revision id *)
      (page_id: int) (* page id *)
      (timestamp: string) (* timestamp string *)
      (time: float) (* time, as a floating point *)
      (contributor: string) (* name of the contributor *)
      (user_id: int) (* user id *)
      (ip_addr: string)
      (username: string) (* name of the user *)
      (is_minor: bool) 
      (comment: string)
      (text_init: string Vec.t) (* Text of the revision, still to be split into words *)
      : unit =
      (* If it is the first revision, initializes the page and creates the directory *)
      if is_first then begin 
        Printf.fprintf out_file "<page>\n<title>%s</title>\n" title; 
        Printf.fprintf out_file "<id>%d</id>\n" page_id;
	is_first <- false
      end; 
      (* Creates a revision without text, and prints it out to the empty .xml file *)
      let r = new Revision.write_only_revision rev_id page_id timestamp time contributor user_id 
	ip_addr username is_minor comment Vec.empty in
      r#output_revision out_file;
      (* Now we need to write the text of the revision in its own file *)
      let s = Printf.sprintf "%012d.txt" rev_id in 
      let f = Fileinfo.open_info_out (file_prefix ^ s) in 
      let print_l (b: unit) (d: string) : unit = 
	output_string f d in 
      let print_r (c: unit) (b: unit) : unit = () in 
      Vec.visit_in () print_l print_r text_init;
      Fileinfo.close_info_out f

    (** This method is called when there are no more revisions to evaluate. 
	All it does is write that the page is closed. *)
    method eval: unit = 
      Printf.fprintf out_file "</page>\n"

  end (* page object *)

