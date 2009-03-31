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

(** This page is used to measure how much text authors in different reputation bins contribute
    to Wikipedia pages. *)

type word = string 
exception Ins_text_in_deleted_chunk
open Eval_defs

class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  (rep_histories: Rephist.rephist)
  (equate_anons: bool) 
  =
  let max_n_of_revs = 3 in 
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

      (* Arrays of chunks and chunk attributes for the last version of the page. *)
      (* chunks_a is a word array array, and is used to represent both the live text
         (element 0) or the dead text (elements >0) of a page. *)
    val mutable chunks_a : word array array = [| [| |] |] 
      (* This is an int array array, and stored an int for each word of chunks_a. 
         The integers represent the reputation of the original author of a word. *)
    val mutable chunks_attr_a : int array array = [| [| |] |]

      (* Array that stores how many words appeared by users in each reputation range *)
    val rep_credit : int array = Array.make (max_rep_val + 1) 0
      (* Array that stores how many words were contributed by users in each reputation range *)
    val rep_new_words : int array = Array.make (max_rep_val + 1) 0

    method print_id_title = 
      Printf.fprintf out_file "\nPage: %i Title: %S" id title; 
      flush out_file

    (** This method analyzes the newest revision just added into the revs Vec. 
        It computes a list of text edit diffs wrt the previous one, and then 
        calls more specialized evaluations as required. *)
    method private eval_newest : unit = 
      let rev_idx = (Vec.length revs) - 1 in 
      let new_rev = Vec.get rev_idx revs in 
      let uid = new_rev#get_user_id in 
      let t = new_rev#get_time in 
      (* Gets the reputation of the author of the current revision *)
      let rep = rep_histories#get_rep uid t in 
      let new_wl = new_rev#get_words in 
      (* Calls the function that analyzes the difference 
         between revisions. Data relative to the previous revision
         is stored in the instance fields chunks_a and chunks_attr_a *)
      let (new_chunks_a, medit_l) = Chdiff.text_tracking chunks_a new_wl in 
      (* Constructs new_chunks_attr_a, which contains the reputation range of the 
         author of each word in the text. *)
      (* First, creates new_chunks_attr_a, by mapping f onto array new_chunks_a. *)
      let f x = Array.create (Array.length x) 0 in 
      let new_chunks_attr_a = Array.map f new_chunks_a in 
      (* Now, goes over medit_l, and fills in new_chunks_attr_a properly, as well as the credits. *)
      let rec f = function 
          Editlist.Mins (word_idx, l) -> begin 
            (* This is text added in the current version *)
            (* Credits the reputation range for the current text *)
            rep_credit.(rep) <- rep_credit.(rep) + l; 
            rep_new_words.(rep) <- rep_new_words.(rep) + l;
            for i = word_idx to word_idx + l - 1 do begin
              new_chunks_attr_a.(0).(i) <- rep
            end done
          end
        | Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) -> begin 
            if dst_chunk_idx = 0 then begin 
              (* This is live text.  Copies the attribute, and gives credit. *)
              for i = 0 to l - 1 do begin 
                let a = chunks_attr_a.(src_chunk_idx).(src_word_idx + i) in 
                new_chunks_attr_a.(dst_chunk_idx).(dst_word_idx + i) <- a; 
                rep_credit.(a) <- rep_credit.(a) + 1
              end done
            end else begin 
              (* This is now dead text.  Only copies the attributes *)
              for i = 0 to l - 1 do 
                new_chunks_attr_a.(dst_chunk_idx).(dst_word_idx + i) <-
                  chunks_attr_a.(src_chunk_idx).(src_word_idx + i);
              done
            end
          end
        | Editlist.Mdel (word_idx, chunk_idx, l) -> ()
      in 
      List.iter f medit_l; 
      (* Now, replaces chunks_attr_a with new_chunks_attr_a for the next iteration *)
      chunks_attr_a <- new_chunks_attr_a;
      (* stores data for the next revision *)
      chunks_a <- new_chunks_a
      (* end *)


    (** This method is called once a page has been fully analized for rep contributions *)
    method private output_rep_contributions : unit = 
      (* First, prints how many words were inserted by each reputation range *)
      Printf.fprintf out_file "\nInsertedByRep:"; 
      for i = 0 to max_rep_val do
        Printf.fprintf out_file " %d" rep_new_words.(i)
      done; 
      (* Then, prints how many words were seen for each reputation range *)
      Printf.fprintf out_file "\nSeenByRep:"; 
      for i = 0 to max_rep_val do
        Printf.fprintf out_file " %d" rep_credit.(i)
      done; 
      (* Then, prints how many words of each reputation range appear on the
         most recent version of the page. *)
      let last_rep_credit = Array.make (max_rep_val + 1) 0 in 
      for w_idx = 0 to (Array.length chunks_attr_a.(0)) - 1 do 
        let r = chunks_attr_a.(0).(w_idx) in 
        last_rep_credit.(r) <- last_rep_credit.(r) + 1
      done; 
      Printf.fprintf out_file "\nLastSeenByRep:"; 
      for i = 0 to max_rep_val do
        Printf.fprintf out_file " %d" last_rep_credit.(i)
      done; 
      flush out_file

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
      let r = new Revision.plain_revision id page_id timestamp time contributor user_id ip_addr username is_minor comment text_init in 
      Printf.fprintf stderr "."; flush stderr; 
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
            (* If the buffer is full, evaluates the oldest version and kicks it out *)
            if (Vec.length revs) > max_n_of_revs then begin 
              (* The parameter 0 is the index of what is considered to be the oldest. 
                 It is used, since in no_more_revisions it may be a larger number *)
              revs <- Vec.remove 0 revs;
              (* increments the offset of the oldest version *)
              offset <- offset + 1 
            end (* if *)
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
          self#output_rep_contributions
        end

  end (* Contribution page *)

