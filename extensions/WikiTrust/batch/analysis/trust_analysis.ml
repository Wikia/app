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
  (rep_histories: Rephist.rephist)
  (trust_coeff_lends_rep: float)
  (trust_coeff_read_all: float) 
  (trust_coeff_cut_rep_radius: float) 
  (trust_coeff_kill_decrease: float)
  (n_rev_to_color: int)
  (equate_anons: bool) 
  =
  object (self) 

    (* This is a dynamically modifiable vector of revisions, used as a
       buffer.  revs[0] is the oldest, and is the revision
       number offset (see later, offset is a field of page) for
       the page. *)
    val mutable revs : Revision.trust_revision Vec.t = Vec.empty 
      (* In the Vec implementation, offset is the offset of the oldest
         (position 0 in revs) revision. *)
    val mutable offset : int = 0
      (* This is the last revision; I don't know yet that I can add it to 
         the array of revisions, as there may be a subsequent one 
         by the same author *)
    val mutable last_rev : Revision.trust_revision option = None 

      (* Arrays of chunks and chunk attributes for the last version of the page. *)
      (* chunks_a is a word array array, and is used to represent both the live text
         (element 0) or the dead text (elements >0) of a page. *)
    val mutable chunks_a : word array array = [| [| |] |] 
      (* This float array array stores a float for each word, and is used to store the 
         trust of each word. *)
    val mutable chunks_trust_a  : float array array = [| [| |] |] 

      (* No titles in the xml file! *)
    method print_id_title = ()

    (** [compute_word_trust new_chunks_a medit_l rep_float] computes the 
	new word trust values of the revision with chunks [new_chunks_a], obtained from 
	the version with word trust values [chunks_trust_a] via the edit list [medit_l]. 
	[rep_float] is the reputation of the author of the new revision. *)
    method private compute_word_trust 
      (new_chunks_a: word array array) 
      (medit_l: Editlist.medit list) 
      (rep_float: float) 
      (rev: Revision.trust_revision) : float array array =
      let f x = Array.make (Array.length x) 0.0 in 
      let new_chunks_trust_a = Array.map f new_chunks_a in 
      let old_live_len = Array.length chunks_trust_a.(0) in 
      let new_live_len = Array.length new_chunks_a.(0) in 
      (* Now, goes over medit_l, and fills in new_chunks_trust_a properly. *)
      let f = function 
	  Editlist.Mins (word_idx, l) -> begin 
            (* This is text added in the current version *)
            (* Computes the reputation of the newly inserted text *)
            let text_rep = rep_float *. trust_coeff_lends_rep in 
            (* Credits the reputation range for the current text *)
            for i = word_idx to word_idx + l - 1 do begin
	      new_chunks_trust_a.(0).(i) <- text_rep 
            end done
	  end
	| Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) -> begin 
            for i = 0 to l - 1 do begin 
              (* a is the old reputation of the word *)
              let a = chunks_trust_a.(src_chunk_idx).(src_word_idx + i) in 
              (* and a' is the new reputation *)
              let a' = 
		if dst_chunk_idx = 0 then begin 
		  (* This is live text *)
		  let j = l - 1 - i in 
		  (* Now i is the distance from the left edge, and j from the right edge.
                     We update the trust of text in a block as follows. 
                     Close to the endpoints of the block, we take the reputation of the 
                     user as the trust of the text.  
                     Far from endpoints, we take the old trust of the block. 
                     We now compute the distance from the endpoints.  The idea is that the 
                     distance from an edge does not matter only if (a) the move is from
                     chunk 0 to chunk 0 (so that the text remains present), and
                     (b) the left edge remains at 0, or the right edge remains at the end
                     of the string. 
                     If a distance from an edge does not matter, we set it to big_distance,
                     so that automatically the formula will not take it into account. 
		   *)
		  let dist = 
                    if src_chunk_idx = 0 then begin 
                      (* the text was live *) 
                      let i' = if src_word_idx = 0 && dst_word_idx = 0 then big_distance else i in 
                      let j' = if src_word_idx + l = old_live_len
			&& dst_word_idx + l = new_live_len
                      then big_distance else j in 
                      min i' j'
                    end else begin 
                      (* the text was dead *)
                      min i j 
                    end
		  in 
		  (* a_cut is the trust of the text, computed according to the distance
                     from the endpoints defined as above. 
                     This distance does not yet take into account the fact that high-reputation 
                     users validate a page as a whole. *)
		  let cut_rep = rep_float *. trust_coeff_lends_rep in 
		  let a_cut = a +. (cut_rep -. a) 
                    *. exp (-. (float_of_int dist) /. trust_coeff_cut_rep_radius) in 
		  (* Now computes a'.  The idea is as follows. 
                     We assume that high-reputation users read a page as a whole, and thus, 
                     if the reputation of the user is greater than that of the text, a bit of the 
                     user reputation percolates to the text as well.  If instead the computed 
                     reputation a_cut is greater than that of the user, we use the value a_cut: 
                     a low-reputation user degrates a page only in proximity of the edits. *)
		  if rep_float > a_cut 
		  then a_cut +. (rep_float -. a_cut) *. trust_coeff_read_all 
		  else a_cut 
		end else begin 
		  (* This is dead text.
                     If the text was already dead, we leave its trust unchanged. 
                     If the text was live, then we lower its trust, the more so 
                     the higher the reputation of the user who deleted it. 
		   *)
		  if src_chunk_idx = 0 then begin 
                    (* was live; reduces the trust *)
                    a *. exp (-. rep_float *. trust_coeff_kill_decrease)
		  end else begin 
                    (* was dead *)
                    a
		  end
		end
              in 
              (* This concludes the computation of a', the new trust of the word. *)
              new_chunks_trust_a.(dst_chunk_idx).(dst_word_idx + i) <- a'
            end done 
	  end
	| Editlist.Mdel _ -> ()
      in 
      List.iter f medit_l; 
      new_chunks_trust_a

    (** [compute_word_longevity chunks_longevity_a new_chunks_a medit_l] computes the 
	new longevity values for the words of the revision with chunks [new_chunks_a], 
	obtained from the version with longevities [chunks_trust_a] via the edit list [medit_l]. 
	[rep_float] is the reputation of the author of the new revision. *)
    method private compute_word_longevity 
	(chunks_longevity_a: int array array) 
	(new_chunks_a: word array array) 
	(medit_l: Editlist.medit list) 
	(rep_float: float) : int array array = 
      let f x = Array.make (Array.length x) 0 in 
      let new_chunks_longevity_a = Array.map f new_chunks_a in 
      (* Now, goes over medit_l, and fills in new_chunks_longevity_a properly. *)
      let f = function 
	  Editlist.Mdel _ | Editlist.Mins _ -> ()
            (* For Mins, this is text added in the current version, and as we fill 
	       the array with 0's initially, we don't need to do anything. *)
	| Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) -> begin 
            for i = 0 to l - 1 do begin 
              (* a is the old longevity of the word *)
              let a = chunks_longevity_a.(src_chunk_idx).(src_word_idx + i) in 
              (* and a' is the new longevity: a' is a+1 if the word is live, and a if it is dead. *)
              let a' = if dst_chunk_idx = 0 then a + 1 else a in 
              new_chunks_longevity_a.(dst_chunk_idx).(dst_word_idx + i) <- a'
            end done 
	  end
      in 
      List.iter f medit_l; 
      new_chunks_longevity_a


    (** This method evaluates the trust of the words of a new revision *)
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
      (* Constructs new_chunks_trust_a, which contains the trust of each word 
	 in the text (both live text, and dead text). *)
      let rep_float = float_of_int rep in 
      let new_chunks_trust_a = self#compute_word_trust new_chunks_a medit_l rep_float rev in 
      (* Now, replaces chunks_trust_a and chunks_a for the next iteration *)
      chunks_trust_a <- new_chunks_trust_a;
      chunks_a <- new_chunks_a;
      (* Also notes in the revision the reputations *)
      rev#set_word_trust new_chunks_trust_a.(0)


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
          r#output_trust_revision out_file
        done;
        Printf.fprintf out_file "</page>\n"
      end (* there is some revision *)

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
      let r = new Revision.trust_revision rev_id page_id timestamp time contributor user_id ip_addr username is_minor comment text_init in 
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
              (* If the buffer is full, evaluates the oldest version and kicks it out *)
              if (Vec.length revs) > n_rev_to_color then begin 
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
          self#gen_output;
          flush out_file
        end

  end (* trust_color_page object *)

