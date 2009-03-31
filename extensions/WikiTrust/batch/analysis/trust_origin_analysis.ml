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


(** This class colorizes a wiki dump file according to text trust, 
    and outputs information about the revision in which each word
    originates. *)

type word = string 
exception Ins_text_in_deleted_chunk
open Eval_defs

class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  (rep_histories: Rephist.rephist)
  (trust_coeff_lends_rep: float)
  (trust_coeff_read_all: float) 
  (trust_coeff_read_part: float) 
  (trust_coeff_part_radius: float)
  (trust_coeff_cut_rep_radius: float) 
  (trust_coeff_kill_decrease: float)
  (n_rev_to_color: int) 
  (equate_anons: bool) 
  =

  object (self) 
    inherit Trust_local_color_analysis.page 
      id title out_file rep_histories
      trust_coeff_lends_rep trust_coeff_read_all 
      trust_coeff_read_part trust_coeff_part_radius
      trust_coeff_cut_rep_radius trust_coeff_kill_decrease
      n_rev_to_color equate_anons 

      (* This array keeps track of the revision id in which each word 
	 was introduced. *)
    val mutable chunks_origin_a : int array array = [| [| |] |]

   (** Tracks word origin *)
    method private compute_origin
      (new_chunks_a: word array array) 
      (medit_l: Editlist.medit list) 
      (rev: Revision.trust_revision) : int array array =
      Compute_trust.compute_origin chunks_origin_a new_chunks_a medit_l rev#get_id


    (** This method evaluates the trust of the words of a new revision, 
        as well as their origin. *)
    method private eval_newest : unit = 
      let rev_idx = (Vec.length revs) - 1 in 
      let rev = Vec.get rev_idx revs in 
      let uid = rev#get_user_id in 
      let t = rev#get_time in 
      (* Gets the reputation of the author of the current revision *)
      let rep = rep_histories#get_rep uid t in 
      let new_wl = rev#get_words in 
      (* Calls the function that analyzes the difference 
         between revisions. Data relative to the previous revision
         is stored in the instance fields chunks_a and chunks_attr_a *)
      let (new_chunks_a, medit_l) = Chdiff.text_tracking chunks_a new_wl in 
      (* Constructs new_chunks_attr_a, which contains the reputation range of the 
         author of each word in the text. *)
      let rep_float = float_of_int rep in 
      let new_chunks_trust_a = self#compute_word_trust new_chunks_a medit_l rep_float rev in 
      (* Computes the origin of the words in the new revision. *)
      let new_chunks_origin_a = self#compute_origin new_chunks_a medit_l rev in 
      (* Now, replaces chunks_trust_a and chunks_a for the next iteration *)
      chunks_trust_a <- new_chunks_trust_a;
      chunks_origin_a <- new_chunks_origin_a; 
      chunks_a <- new_chunks_a;
      (* Also notes in the revision the reputations and the origins *)
      rev#set_word_trust new_chunks_trust_a.(0);
      rev#set_word_origin new_chunks_origin_a.(0)

    (** This method is called once a page has been fully analyzed for text trust, 
        so that we can output the colorized text. *)
    method private gen_output : unit = 
      let n_revs = Vec.length revs in 
      if n_revs > 0 then begin 
        Printf.fprintf out_file "<page>\n<title>%s</title>\n" title; 
        Printf.fprintf out_file "<id>%d</id>\n" id;
        (* Computes the range of revisions to be output *)
        let start_rev = max 0 (n_revs - n_rev_to_color) in 
        (* the range is from start_rev to n_revs - 1 *)
        for rev_idx = start_rev to n_revs - 1 do 
          (* Ok, here we have to output the colorized revision *)
          let r = (Vec.get rev_idx revs) in 
          r#output_trust_origin_revision out_file
        done;
        Printf.fprintf out_file "</page>\n"
      end (* there is some revision *)

  end (* page *)

