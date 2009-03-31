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


(** This module contains a class that prunes the revisions in a page *)


type word = string 
open Eval_defs

(** [page id title out_file keep_rev keep_rev_after require_uid_change equate_anons] 
    writes only a certain number of latest revisions of a page. 
    [id] and [title] of the page
    [out_file] is where to write the revisions, in xml format
    [keep_rev] is the max n. of revisions to keep 
    [keep_rev_after] is a date that specifies a time threshold for revisions to be kept
    [require_uid_change] indicates whether only the last revision, among consecutive 
      revisions from the same author, is to be kept.
    [equate_anons] indicates whether anonymous users have to be considered all equal, 
      or whether their ip address is used to distinguish them. *)

class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  (keep_rev: int)
  (keep_rev_after: float)
  (require_uid_change: bool)
  (equate_anons: bool)
  =
  object (self) 

    (* This is a dynamically modifiable vector of revisions, used as a
       buffer.  revs[0] is the oldest, and is the revision
       number offset (see later, offset is a field of page) for
       the page. *)
    val mutable revs : Revision.write_only_revision Vec.t = Vec.empty 

      (* This is the last revision; I don't know yet that I can add it to 
         the array of revisions, as there may be a subsequent one 
         by the same author *)
    val mutable last_rev : Revision.write_only_revision option = None 

      (* No titles in the xml file! *)
    method print_id_title = ()

    (** This method is called once a page has been fully analyzed for text trust, 
        so that we can output the colorized text. *)
    method private gen_output : unit = 
      let n_revs = Vec.length revs in 
      if n_revs > 0 then begin 
        Printf.fprintf out_file "<page>\n<title>%s</title>\n" title; 
        Printf.fprintf out_file "<id>%d</id>\n" id;
        (* Computes the range of revisions to be output *)
        let start_rev = max 0 (n_revs - keep_rev) in 
        (* the range is from start_rev to n_revs - 1 *)               
        for rev_idx = start_rev to n_revs - 1 do 
          (* Ok, here we have to output the reduced revision *)
          let r = (Vec.get rev_idx revs) in 
          r#output_revision out_file; 
        done;
        Printf.fprintf out_file "</page>\n"
      end (* there is some revision *)

    (** This method is called to add a new revision to be evaluated for trust. *)
    method add_revision 
      (id: int) (* revision id *)
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
      if keep_rev_after <= time then begin (* Only add those revisions after time keep_after_time *)
        let r = new Revision.write_only_revision id page_id timestamp time contributor user_id ip_addr username is_minor comment text_init in 
        (* To keep track of progress *)
        (* Printf.fprintf stderr "."; flush stderr; *)
        match last_rev with
          (* This is the first we see for this page *)
          None -> last_rev <- Some r; 
        | Some r' -> begin
            last_rev <- Some r; 
	    (* Checks whether it has to consider the revision *)
	    if (not require_uid_change) ||
	      (Revision.different_author equate_anons r r') then begin 
		(* Puts r' into the vector of revisions, and analyzes it *)
		revs <- Vec.append r' revs;              
		(* If the buffer is full, evaluates the oldest version and kicks it out *)
		if (Vec.length revs) > keep_rev then begin 
		  (* The parameter 0 is the index of what is considered to be the oldest. 
                     It is used, since in no_more_revisions it may be a larger number *)
		  revs <- Vec.remove 0 revs;
		end (* if *)
	      end (* if authors different or we don't check author difference *)
	  end (* match some some *)
      end (* if *)

    (** This method is called when there are no more revisions to evaluate, 
        and processes what is left in the buffer. *) 
    method eval: unit = 
      match last_rev with 
        (* There were no revisions, nothing to do *)
        None -> ()
      | Some r -> begin
          (* Adds r to the list of revisions *)
          revs <- Vec.append r revs;
          (* Outputs the results *)
          self#gen_output;
          flush out_file
        end

  end (* page object *)

