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


(** This module contains a class that evaluates the trust of the text
    of Wikipedia pages, and colors the revisions. *)


type word = string 
exception Ins_text_in_deleted_chunk
open Eval_defs

(** This is the class that goes over the revisions of a page to compute the trust 
    value of all words, and that outputs the trust-colored revisions. *) 

class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  (equate_anons: bool) 
  =
  object (self) 

    (* This is a dynamically modifiable vector of revisions, used as a
       buffer.  revs[0] is the oldest, and is the revision
       number offset (see later, offset is a field of page) for
       the page. *)
    val mutable revs : Revision.plain_revision Vec.t = Vec.empty 
      (* In the Vec implementation, offset is the offset of the oldest
         (position 0 in revs) revision. *)
    val mutable offset : int = 0
      (* This is the last revision; I don't know yet that I can add it to 
         the array of revisions, as there may be a subsequent one 
         by the same author *)
    val mutable last_rev : Revision.plain_revision option = None 

    val authors = Hashtbl.create 100

      (* Arrays of chunks and chunk attributes for the last version of the page. *)
      (* chunks_a is a word array array, and is used to represent both the live text
         (element 0) or the dead text (elements >0) of a page. *)
    val mutable chunks_a : word array array = [| [| |] |] 
      (* This float array array stores a float for each word, and is used to store the 
         trust of each word. *)
    val mutable chunks_trust_a  : float array array = [| [| |] |] 

      (* No titles in the xml file! *)
    method print_id_title = ()

    (** This method counts the number of charactors added in a 
	revision and credits the author. *)
    method private eval_newest : unit = 
      let rev_idx = (Vec.length revs) - 1 in 
      let rev = Vec.get rev_idx revs in 
      let uid = rev#get_user_id in 
      let old_count = try Hashtbl.find authors uid with Not_found -> 0 in
      let new_wl = rev#get_words in 

      (* Here, inserted words rate an increase, while edits and deletions do not. *)
      let rec count_new_words count elst = match elst with
	| [] -> count
	| Editlist.Mins (word_idx, l) :: tl -> count_new_words (l + count) tl
	| Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) :: tl -> 
	    count_new_words (0 + count) tl
	| Editlist.Mdel (i, k, l) :: tl -> count_new_words (0 + count) tl
      in
      (* Calls the function that analyzes the difference 
         between revisions. Data relative to the previous revision
         is stored in the instance fields chunks_a and chunks_attr_a *)
      let (new_chunks_a, medit_l) = Chdiff.text_tracking chunks_a new_wl in
      let words_added = count_new_words 0 medit_l in
	Hashtbl.replace authors uid (old_count + words_added);
	
	(* Now, replace chunks_a for the next iteration *)
	chunks_a <- new_chunks_a
	  
    (** This method is called once a page has been fully analyzed, and
    outputs whatever customized results are desired. *)
    method private gen_output : unit = 
      let print_counts (id,count) =
	Printf.fprintf out_file "%d %d\n" id count 
      in
      let to_list k v lst = (k,v) :: lst in
      let comp (k1,v1) (k2,v2) = v2 - v1 in
      let auth_list = Hashtbl.fold to_list authors [] in
	List.iter print_counts (List.sort comp auth_list)

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
      let r = new Revision.plain_revision rev_id page_id timestamp time contributor user_id ip_addr username is_minor comment text_init in 
      (* To keep track of progress *)
      (* Printf.fprintf stderr "."; flush stderr; *)
      match last_rev with
        (* This is the first we see for this page *)
        None -> last_rev <- Some r; 
      | Some r' -> begin
          last_rev <- Some r; 
          (* If r and r' have different author, puts r' into the vector 
             of revisions, and analyzes it *)
          if Revision.different_author equate_anons r r' then begin 
              revs <- Vec.append r' revs; 
              (* Evaluates the newest version *)
              self#eval_newest; 
            end (* if *)
        end (* some *)
	  

    (** This method is called when there are no more revisions to evaluate, 
        and processes what is left in the buffer. *) 
    method eval: unit = 
      match last_rev with 
        (* There were no revisions, nothing to do *)
        None -> ()
      | Some r -> begin
          (* Adds r to the list of revisions *)
          revs <- Vec.append r revs;
          (* Evaluates the last page *)
          self#eval_newest; 
          (* Outputs the results *)
          self#gen_output;
          flush out_file
        end

  end (* trust_color_page object *)

