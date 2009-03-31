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

(** The functions in this module are used to compute the trust of the 
    words of a revision, taking into account the "locality effect" of
    the attention of the revisor. 
    The computation uses a robust method, that includes the consideration
    of author signatures. *)

type word = string
open Eval_defs

(** [compute_trust_chunks chunks_trust_a new_chunks_a new_seps medit_l
    rep_float trust_coeff...] computes the new word trust values of the revision with
    chunks [new_chunks_a], obtained from the version with word trust
    values [chunks_trust_a] via the edit list [medit_l].  [new_seps]
    are the new seps of the latest revision. [rep_float] is the
    reputation of the author of the new revision.  What is new about
    this method, compared to the classical compute_word_trust one, is
    that this one takes into account syntactical units to spread the
    trust. 
    The trust_coeff_... parameters are for trust computation. *)
let compute_robust_trust
  (chunks_trust_a: float array array) 
  (chunks_authorsig_a: Author_sig.packed_author_signature_t array array) 
  (new_chunks_a: word array array) 
  (new_seps: Text.sep_t array)
  (medit_l: Editlist.medit list) 
  (rep_float: float)
  (user_id: int) 
  (trust_coeff_lends_rep: float) 
  (trust_coeff_kill_decrease: float)
  (trust_coeff_cut_rep_radius: float)
  (trust_coeff_read_all: float)
  (trust_coeff_read_part: float)
  (trust_coeff_local_decay: float)
  : (float array array * Author_sig.packed_author_signature_t array array) = 

  (* Produces the new trust array *)
  let f x = Array.make (Array.length x) 0.0 in 
  let new_chunks_trust_a = Array.map f new_chunks_a in 
  let old_live_len = Array.length chunks_trust_a.(0) in 
  let new_live_len = Array.length new_chunks_a.(0) in
  
  (* Produces the new signature array *)
  let f x = Array.make (Array.length x) Author_sig.empty_sigs in 
  let new_chunks_authorsig_a = Array.map f new_chunks_a in 
  (* Produces two auxiliary arrays: one keeps track of whether the author can 
     increase the trust of a word, the second keeps track of whether the author
     has increased the trust of a word. These are just filled with default
     values initially. *)
  let f x = Array.make (Array.length x) true in 
  let new_chunks_canincrease_a = Array.map f new_chunks_a in 
  let f x = Array.make (Array.length x) false in 
  let new_chunks_hasincreased_a = Array.map f new_chunks_a in 

  (* This array keeps track of the syntactic units that have been checked 
     by the author.  It contains one bool per word, which indicates whether 
     the author is likely to have read the word or not. *)
  let looked_at = Array.make new_live_len false in 
  (* We need to have the conversion from words to seps, and the seps, 
     for the current revision. *)
  let seps = new_seps in 
  (* This array contains, for each word, the number of the sectional unit
     to which the word belongs. *)
  let section_of_word = Array.make new_live_len 0 in 
  
  (* Initializes section_of_word *)
  let n_seps = Array.length seps in 
  let n_section = ref 0 in 
  for i = 0 to n_seps - 1 do begin
    match seps.(i) with 
      (* Syntax breaks, no word increase *)
      Text.Par_break _ -> 
	n_section := !n_section + 1
          (* Syntax break before, word increase *)
    | Text.Title_start (_, k) | Text.Bullet (_, k) | Text.Table_cell (_, k) 
    | Text.Table_line (_, k) | Text.Table_caption (_,k) | Text.Indent (_, k) -> begin 
	n_section := !n_section + 1; 
	section_of_word.(k) <- !n_section
      end
        (* Syntax break after, word increase *)
    | Text.Title_end (_, k) -> begin 
	section_of_word.(k) <- !n_section;
	n_section := !n_section + 1
      end
	(* No syntax break, word increase *)
    | Text.Tag (_, k) | Text.Word (_, k) | Text.Redirect (_, k) 
    | Text.Armored_char (_, k) -> 
	section_of_word.(k) <- !n_section
          (* No syntax break, no word increase *)
    | Text.Space _ | Text.Newline _ -> ()
  end done; 

  (* [spread_look n] marks the array looked_at so that all the syntactic unit 
     (paragraph, itemization point) of [n] is labeled true. *)
  let spread_look (n: int) : unit = 
    (* Spreads upward *)
    if not looked_at.(n) then begin 
      let word_idx = ref n in 
      let fatto = ref false in 
      while not !fatto do begin 
	looked_at.(!word_idx) <- true;
	if !word_idx = new_live_len - 1
	then fatto := true
	else begin 
	  word_idx := !word_idx + 1; 
	  fatto := looked_at.(!word_idx) || section_of_word.(!word_idx - 1) <> section_of_word.(!word_idx)
	end
      end done;
      (* Spreads downwards *)
      let word_idx = ref n in 
      let fatto = ref false in 
      while not !fatto do begin 
	looked_at.(!word_idx) <- true;
	if !word_idx = 0
	then fatto := true
	else begin 
	  word_idx := !word_idx - 1; 
	  fatto := looked_at.(!word_idx) || section_of_word.(!word_idx + 1) <> section_of_word.(!word_idx)
	end
      end done
    end (* if not looked_at.(n) *)
  in (* end of spread_look *)

  (* This function is used to determine whether the beginning of a move, that begins at position k, 
     should be marked in trust. 
     The rule is: 
     - text moved from the beginning to the beginning is not marked (this is taken care by the caller)  
     - if the previous text has been inserted, and belongs to a different section, and is of length 
     at least 2, the cut is not marked.  The length 2 requirement is used to ensure that the 
     coloring will be visible. 
     - otherwise, it is marked.  Thus, text after an insertion in the same sectional unit, and text
     that has been rearranged, is marked. *)
  let mark_begin_cut (n: int): bool = 
    (* If the cut starts at 0, then it has been re-arranged, since the 0 to 0 case is taken care 
       by the caller *)
    if n = 0 then true
      (* If the sectional unit has not changed, we do not need to figure out what is the type of the
	 previous block (inserted/moved), we mark it anyway *)
    else if section_of_word.(n) = section_of_word.(n - 1) then true
    else begin 
      (* The previous block is in a different sectional unit.  Checks whether it is an insert. *)
      let rec is_moved = function 
	  [] -> true
	| Editlist.Mins (word_idx, l) :: rest -> 
	    if word_idx + l = n then l < 2 else is_moved rest
	| Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) :: rest -> 
	    if dst_chunk_idx = 0 && dst_word_idx + l = n 
	    then true 
	    else is_moved rest
	| _ :: rest -> is_moved rest 
      in is_moved medit_l
    end
  in (* end of mark_begin_cut *)
  
  (* This function is analogous to mark_begin_cut, but for the end of the cut *)
  let mark_end_cut (n: int): bool = 
    (* If the cut starts at 0, then it has been re-arranged, since the 0 to 0 case is taken care 
       by the caller *)
    if n = new_live_len - 1 then true
      (* If the sectional unit has not changed, we do not need to figure out what is the type of the
	 previous block (inserted/moved), we mark it anyway *)
    else if section_of_word.(n) = section_of_word.(n + 1) then true
    else begin 
      (* The previous block is in a different sectional unit.  Checks whether it is an insert. *)
      let rec is_moved = function 
	  [] -> true
	| Editlist.Mins (word_idx, l) :: rest -> 
	    if word_idx - 1 = n 
	    then l < 2 (* it is an insert *)
	    else is_moved rest
	| Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) :: rest -> 
	    if dst_chunk_idx = 0 && dst_word_idx - 1 = n 
	    then true 
	    else is_moved rest
	| _ :: rest -> is_moved rest 
      in is_moved medit_l
    end
  in (* end of mark_end_cut *)
  
  (* This is a trust bonus that the fresh text is awarded. 
     Note that in any case, this value undergoes the trust increase 
     due to both reading the section where the text is inserted, and
     reading the whole page. *)
  let new_text_trust = rep_float *. trust_coeff_lends_rep in 

  (* Now, goes over medit_l via f, and fills in new_chunks_trust_a and the new signatures properly. *)
  let f = function 
      Editlist.Mins (word_idx, l) -> begin 
        (* This is text added in the current version *)
        (* Credits the reputation range for the current text *)
        for i = word_idx to word_idx + l - 1 do begin
          new_chunks_trust_a.(0).(i) <- new_text_trust;
          looked_at.(i) <- true; 
	  new_chunks_hasincreased_a.(0).(i) <- true;
	  (* new_chunks_canincrease_a.(0).(i) <- true; *) (* true is the default *)
        end done;
        (* One generally looks in the whole syntactic unit where one is editing *)
	spread_look word_idx;
	spread_look (word_idx + l - 1)
      end
    | Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) -> begin 

	(* Checks whether the text is live in the new version *)
        if dst_chunk_idx = 0 then begin 

          (* It is live text *)
          (* First, copies the trust and signatures *) 
          for i = 0 to l - 1 do begin 
	    (* trust *)
            let trust = chunks_trust_a.(src_chunk_idx).(src_word_idx + i) in 
            new_chunks_trust_a.(0).(dst_word_idx + i) <- trust;
	    (* This is the word under consideration *)
	    let w = new_chunks_a.(0).(dst_word_idx + i) in 
	    (* Packed signature of the word *)
	    let hsig = chunks_authorsig_a.(src_chunk_idx).(src_word_idx + i) in 
	    new_chunks_authorsig_a.(0).(dst_word_idx + i) <- hsig;
	    (* This encodes the all-important logic that decides whether a user can increase
	       the trust of a word.  The user has to be not anonymous, and not present 
	       in the signature. *)
	    new_chunks_canincrease_a.(0).(dst_word_idx + i) <- 
	      (user_id <> 0) && not (Author_sig.is_author_in_sigs user_id w hsig);  
	    new_chunks_hasincreased_a.(0).(dst_word_idx + i) <- false; 
          end done; 

          (* Then, applies corrective effects. *)
          (* The first corrective effect is the fact that, at cut places, the text 
             becomes of trust equal to the reputation of the author multiplied by 
             a scaling effect.  The scaling effect is there so that even high-reputation 
             authors cannot single-handedly create trusted content; revisions are 
             always needed. *)

	  (* Processes the beginning *)
          if (src_word_idx <> 0 || dst_word_idx <> 0 || src_chunk_idx <> 0)
	    && (mark_begin_cut dst_word_idx) then begin 
	      (* Spreads the information that the author looked at this chunk of text. *)
	      spread_look dst_word_idx;
	      
	      (* Now computes the correction to the trust from the beginning of the cut block *)
              let word_idx = ref dst_word_idx in 
              let fatto = ref false in 
              while not !fatto do begin 
		(* Changes the trust of this word *)
                (* Cut points are discontinuities, and they inherit trust from the author. *)
                let d = !word_idx - dst_word_idx in 
                let old_trust = new_chunks_trust_a.(0).(!word_idx) in 
                let new_trust = old_trust +. 
                  (new_text_trust -. old_trust) *. exp (-. (float_of_int d) /. trust_coeff_cut_rep_radius) in 
		if new_trust <= old_trust then begin 
                  new_chunks_trust_a.(0).(!word_idx) <- new_trust;
		end; 
		if new_trust > old_trust && new_chunks_canincrease_a.(0).(!word_idx) then begin
                  new_chunks_trust_a.(0).(!word_idx) <- new_trust;
		  new_chunks_hasincreased_a.(0).(!word_idx) <- true;
		end; 
		(* Moves, but not beyond a sectional boundary *)
		if !word_idx = dst_word_idx + l - 1 
		then fatto := true
		else begin 
		  word_idx := !word_idx + 1; 
		  fatto := section_of_word.(!word_idx - 1) <> section_of_word.(!word_idx)
		end
	      end done
	    end; 

	  (* processes the end *)
          if (src_word_idx + l <> old_live_len || dst_word_idx + l <> new_live_len || src_chunk_idx <> 0)
	    && (mark_end_cut (dst_word_idx + l - 1)) then begin 
	      (* Spreads the information that the author looked at this chunk of text. *)
	      spread_look (dst_word_idx + l - 1);
	      
	      (* Computes the correction from the end of the cut block *)
              let word_idx = ref (dst_word_idx + l - 1) in 
              let fatto = ref false in 
              while not !fatto do begin 
		(* Changes the trust of this word *)
                (* Cut points are discontinuities, and they inherit trust from the author. *)
                let d = (dst_word_idx + l - 1) - !word_idx in
                let old_trust = new_chunks_trust_a.(0).(!word_idx) in 
                let new_trust = old_trust +. 
                  (new_text_trust -. old_trust) *. exp (-. (float_of_int d) /. trust_coeff_cut_rep_radius) in 
		if new_trust <= old_trust then begin 
                  new_chunks_trust_a.(0).(!word_idx) <- new_trust;
		end; 
		if new_trust > old_trust && new_chunks_canincrease_a.(0).(!word_idx) then begin
                  new_chunks_trust_a.(0).(!word_idx) <- new_trust;
		  new_chunks_hasincreased_a.(0).(!word_idx) <- true;
		end; 
		(* Moves, but not beyond a sectional boundary *)
		if !word_idx = dst_word_idx
		then fatto := true
		else begin 
		  word_idx := !word_idx - 1; 
		  fatto := section_of_word.(!word_idx + 1) <> section_of_word.(!word_idx)
		end
	      end done
	    end
	    
        end else begin 
          (* dst_chunk_idx > 0, and the text is dead *)
          for i = 0 to l - 1 do begin
	    (* First, copies the trust *)
            let old_trust = chunks_trust_a.(src_chunk_idx).(src_word_idx + i) in 
            let new_trust = 
              if src_chunk_idx = 0 
              then old_trust *. exp (-. rep_float *. trust_coeff_kill_decrease)
              else old_trust 
            in 
            new_chunks_trust_a.(dst_chunk_idx).(dst_word_idx + i) <- new_trust;
	    (* Then, copies the signature *)
	    let hsig = chunks_authorsig_a.(src_chunk_idx).(src_word_idx + i) in 
	    new_chunks_canincrease_a.(dst_chunk_idx).(dst_word_idx + i) <- false; 
	    new_chunks_authorsig_a.(dst_chunk_idx).(dst_word_idx + i) <- hsig;
          end done
	    
        end
      end

    | Editlist.Mdel _ -> ()
  in 
  List.iter f medit_l;
  
  (* Spreads looked_at according to trust_coeff_local_decay, first forward ... *)
  let spread_looked_at = Array.make new_live_len 0.0 in 
  let spread = ref 0.0 in 
  for i = 0 to new_live_len - 1 do begin 
    if looked_at.(i) then spread := 1.0 else spread := !spread *. trust_coeff_local_decay; 
    spread_looked_at.(i) <- !spread
  end done; 
  (* ... and then backwards *)
  let spread = ref 0.0 in 
  for i = new_live_len - 1 downto 0 do begin 
    if looked_at.(i) then spread := 1.0 else spread := !spread *. trust_coeff_local_decay; 
    spread_looked_at.(i) <- spread_looked_at.(i) +. (1.0 -. spread_looked_at.(i)) *. trust_coeff_local_decay
  end done;

  (* Uses spread_looked_at to increase the quality of text due to revision. *)
  for i = 0 to new_live_len - 1 do begin 
    let old_trust = new_chunks_trust_a.(0).(i) in 
    if old_trust < rep_float then
      let new_trust = old_trust +. 
	(rep_float -. old_trust) *. trust_coeff_read_part *. spread_looked_at.(i) in 
      (* Here I know that new_trust > old_trust *)
      if new_chunks_canincrease_a.(0).(i) then begin
        new_chunks_trust_a.(0).(i) <- new_trust;
	new_chunks_hasincreased_a.(0).(i) <- true;
      end
  end done;

  (* Now there is the last of the effects that affect text trust: 
     We give a little bit of prize to all the text, according to the reputation of 
     the author who has made the last edit. *)
  let len0 = Array.length new_chunks_trust_a.(0) in 
  for i = 0 to len0 - 1 do begin 
    let old_trust = new_chunks_trust_a.(0).(i) in
    if rep_float > old_trust then begin 
      let increased_trust = old_trust +. (rep_float -. old_trust) *. trust_coeff_read_all in
      (* Here I know that new_trust > old_trust *)
      if new_chunks_canincrease_a.(0).(i) then begin
	(* If the author can increase the reputation, because it does not appear in the 
	   signature, it increases it. *)
        new_chunks_trust_a.(0).(i) <- increased_trust;
	new_chunks_hasincreased_a.(0).(i) <- true;
      end else begin 
	(* The author cannot perform a normal reputation increase, because it appears in 
	   the signatures.  Nevertheless, it is still reasonable to ensure that the text
	   has at least the same trust as freshly created text by the same author. *)
	if old_trust < new_text_trust then begin
          new_chunks_trust_a.(0).(i) <- new_text_trust;
	  (* As the signature is already present, we do not re-add it, so we do not set 
	     new_chunks_hasincreased_a.(0).(i) <- true *)
	end
      end
    end
  end done; 

  (* Now adds the signature to all places where the trust has increased *)
  for i = 0 to len0 - 1 do begin 
    if new_chunks_hasincreased_a.(0).(i) then
      let w = new_chunks_a.(0).(i) in 
      let old_sig = new_chunks_authorsig_a.(0).(i) in 
      new_chunks_authorsig_a.(0).(i) <- Author_sig.add_author user_id w old_sig
  end done;
  
  (* Returns the new trust *)
  (new_chunks_trust_a, new_chunks_authorsig_a)


(** [compute_origin chunks_origin_a new_chunks_a medit_l revid author_name] 
    computes the origin of the text in the chunks [new_chunks_a],
    belonging to a revision with id [revid] written by a user with
    name [author_name].  [medit_l] is the edit list explaining the
    change from previous to current revision. 
    The information on origin and authors of the old text is given 
    in [chunks_origin_a] and [chunks_author_a], respectively. 
    The function returns a pair [new_origin_a, new_author_a], 
    describing the new origin and author. *)
let compute_origin
    (chunks_origin_a: int array array) 
    (chunks_author_a: string array array)
    (new_chunks_a: word array array) 
    (medit_l: Editlist.medit list) 
    (revid: int) 
    (author_name: string): (int array array * string array array) =
  
  (* Creates the chunks for origin and authors with defaults. *)
  let f x = Array.make (Array.length x) 0 in 
  let new_chunks_origin_a = Array.map f new_chunks_a in 
  let f x = Array.make (Array.length x) "" in 
  let new_chunks_author_a = Array.map f new_chunks_a in 
  
  (* Now, goes over medit_l, and fills in new_chunks_origin_a properly. *)
  let f = function 
      Editlist.Mins (word_idx, l) -> begin 
	for i = word_idx to word_idx + l - 1 do begin
	  new_chunks_origin_a.(0).(i) <- revid;
	  new_chunks_author_a.(0).(i) <- author_name
	end done
      end
    | Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) -> begin 
	for i = 0 to l - 1 do begin
	  new_chunks_origin_a.(dst_chunk_idx).(dst_word_idx + i) <- 
	    chunks_origin_a.(src_chunk_idx).(src_word_idx + i);
	  new_chunks_author_a.(dst_chunk_idx).(dst_word_idx + i) <- 
	    chunks_author_a.(src_chunk_idx).(src_word_idx + i);
	end done
      end
	
    | _ -> ()
  in 
  List.iter f medit_l; 
  (new_chunks_origin_a, new_chunks_author_a)
