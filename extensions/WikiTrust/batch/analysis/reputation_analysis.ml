(* 

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler, Vishwanath Raman

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


(** This page is used to produce the reduced statistics file to compute 
    author reputation. *)

type word = string 
exception Ins_text_in_deleted_chunk
exception Del_text_already_del
open Eval_defs


class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  (eval_zip_error: bool)
  (be_precise: bool) 
  (n_text_judging: int)
  (n_edit_judging: int)
  (equate_anons: bool) (* if No, then anon users of different IP are considered different *)
  = 
  let max_n_of_revs = 2 + (max n_text_judging n_edit_judging) in
  object (self)

    (* This is a dynamically modifiable vector of revisions, used as a
       buffer.  revs[0] is the oldest, and is the revision
       number offset (see later, offset is a field of page) for
       the page. *)
    val mutable revs : Revision.reputation_revision Vec.t = Vec.empty 
      (* In the Vec implementation, offset is the offset of the oldest
         (position 0 in revs) revision. *)
    val mutable offset : int = 0
      (* This is the last revision; I don't know yet that I can add it to 
         the array of revisions, as there may be a subsequent one 
         by the same author *)
    val mutable last_rev : Revision.reputation_revision option = None 

      (* Arrays of chunks and chunk attributes for the last version of the page. *)
      (* chunks_a is a word array array, and is used to represent both the live text
         (element 0) or the dead text (elements >0) of a page. *)
    val mutable chunks_a : word array array = [| [| |] |] 
      (* This is an int array array, and stored an int for each word of chunks_a. 
         The integers represent the version where a page 
         was first introduced. *)
    val mutable chunks_attr_a : int array array = [| [| |] |]

      (* If the error in zipping edit lists is greater than this, prints out a message.  
         Useful only if eval_zip_error has been selected. *)
    val max_zip_error : float = 30.0 

    method print_id_title = 
      Printf.fprintf out_file "\nPage: %i Title: %S" id title; 
      flush out_file

    (** This method evaluates the text contribution of the newest page, 
        giving credit to the old authors for the text they inserted. *)
    method private online_eval_newest_text = 
      
      let rev_idx = (Vec.length revs) - 1 in 
      (* If the vec has length 10, rev_idx is 9, and 9 is indeed the 
         maximum number of judges we can have *)
      let max_n_judges = min rev_idx n_text_judging in 
      let new_rev = Vec.get rev_idx revs in 
      let uid = new_rev#get_user_id in 
      let uname = new_rev#get_user_name in
      let rid = new_rev#get_id in 
      let new_time = new_rev#get_time in 
      (* the absolute index of the newest revision *)
      let absolute_idx = rev_idx + offset in 
      
      let new_wl = new_rev#get_words in 
      (* Calls the function that analyzes the difference 
         between revisions. Data relative to the previous revision
         is stored in the instance fields chunks_a and chunks_attr_a *)

      let (new_chunks_a, medit_l) = Chdiff.text_tracking chunks_a new_wl in 

      (* Produces new_chunks_attr_a from chunks_attr_a (the old attributes), and from 
         medit_l (the list of changes), and from new_chunks_a (the new chunks). *)
      (* First, creates new_chunks_attr_a, by mapping f onto array new_chunks_a *)
      let f x = Array.create (Array.length x) 0 in 
      let new_chunks_attr_a = Array.map f new_chunks_a in 
      (* credit_text_temp is used to gather the comments done to the max_n_judging_revisions
         previous revisions; this is to avoid producing one output per word!
         The invariant here is that credit_text_temp.(i) contains the 
         credit to revision absolute_idx - i - 1 *)
      let credit_text_temp = Array.make max_n_judges 0 in 
      (* Now, goes over medit_l, and fills in new_chunks_attr_a properly, as well as the credits. *)
      let rec f = function 
          Editlist.Mins (word_idx, l) -> begin 
            (* This is text added in the current version *)
            new_rev#inc_created_text l; 
            for i = word_idx to word_idx + l - 1 do begin
              new_chunks_attr_a.(0).(i) <- absolute_idx
            end done
          end
        | Editlist.Mmov (src_word_idx, src_chunk_idx, dst_word_idx, dst_chunk_idx, l) -> begin 
            if dst_chunk_idx = 0 then begin 
              (* This is live text.  Copies the attribute, and gives credit. *)
              for i = 0 to l - 1 do begin 
                let a = chunks_attr_a.(src_chunk_idx).(src_word_idx + i) in 
                new_chunks_attr_a.(dst_chunk_idx).(dst_word_idx + i) <- a; 
                let ago = absolute_idx - a - 1 in 
                if ago < max_n_judges then credit_text_temp.(ago) <- credit_text_temp.(ago) + 1
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

      (* debug *)
      if false then begin 
        Printf.printf "\n****************************************************************\n";
        Printf.printf "\nRevision id: %d" rid; 
        Editlist.print_mdiff medit_l; 
        if false then begin 
          Array.iter (function x -> begin 
                        Printf.printf "\n"; 
                        for jj = 0 to (Array.length x) - 1 do Printf.printf "%d:%d " jj x.(jj) done
                      end)
            new_chunks_attr_a
        end;
        flush stdout
      end;

      (* debug *)
      if false then begin 
        Array.iter (function x -> print_string "\n"; Array.iter print_int x) new_chunks_attr_a;
        flush stdout
      end; 

      (* Now we must use the results in credit_text_temp to give
         the actual credit, but ONLY if the userid receiving the
         credit is different from the current one. *)
      (* loop over some preceding revisions *)
      for i = 0 to max_n_judges - 1 do begin 
        let other = Vec.get (rev_idx - i - 1) revs in 
        let other_uid = other#get_user_id in 
        let other_uname = other#get_user_name in
	let other_time = other#get_time in 
        let seen_text = credit_text_temp.(i) in 
        if Revision.different_author equate_anons new_rev other then 
          begin 
            (* gives credit for the existing text *)
            other#inc_total_life_text seen_text; 
            other#inc_n_text_judge_revisions;
            (* prints out the credit line *)
            if not eval_zip_error then 
              Printf.fprintf out_file "\nTextInc %10.0f PageId: %d rev0: %d uid0: %d uname0: %S rev1: %d uid1: %d uname1: %S text: %d left: %d n01: %d t01: %d"
                new_time id
                other#get_id other_uid other_uname rid uid uname
                other#get_created_text seen_text
		(* Difference in n. of revisions and intervening time *)
		(i + 1) (int_of_float (new_time -. other_time))
          end
      end done; (* for i *)
      
      (* stores data for the next revision *)
      chunks_a      <- new_chunks_a;
      chunks_attr_a <- new_chunks_attr_a


    (** This method prints the TextLife output.
        This method should be called after all TextInc operations
        have been performed on the oldest revision.
        This method is "usually" called when the cache is full,
        except in the final clean-up stage.
        
        eval_oldest and eval_newest together replace eval_text
        in the cached version of the algorithm. *)
    method private online_eval_oldest_text = 
      let oldest_r = Vec.get 0 revs in 
      if not eval_zip_error then 
        oldest_r#print_text_life out_file

    (** Computes and prints EditInc and EditLife information.

      eval_newest_edit and eval_oldest_edit together
      replace eval_edit *)
    method private online_eval_newest_edit = 

      (* computes all the pairwise distances within the edit-distance horizon *)
      (* gets last version *)
      let rev2_idx = (Vec.length revs) - 1 in
      let rev2 = Vec.get rev2_idx revs in 
      (* gets text etc of last version *) 
      let rev2_t = rev2#get_words in 
      let rev2_l = Array.length (rev2_t) in 
      let rev2_i = Chdiff.make_index_diff rev2_t in 

      (* loop over some preceding revisions *)
      for rev1_idx = rev2_idx - 1 downto max 0 (rev2_idx - n_edit_judging) do begin
        let i = rev2_idx - rev1_idx in 
        let rev1 = Vec.get rev1_idx revs in 
        let rev1_t = rev1#get_words in 
        let rev1_l = Array.length (rev1_t) in 
        (* Decides which method to use: zipping the lists, or 
           computing the precise distance.  
           If rev1 is the revision before rev2, there is no choice *)
        if be_precise || rev1_idx + 1 = rev2_idx then begin 
          let edits  = Chdiff.edit_diff rev1_t rev2_t rev2_i in 
          let d      = Editlist.edit_distance edits (max rev1_l rev2_l) in 
          rev1#set_distance (Vec.setappend 0.0 d i rev1#get_distance);
          rev1#set_editlist (Vec.setappend [] edits i rev1#get_editlist);
	  if rev1_idx + 1 = rev2_idx then begin 
	    (* Stores the delta *)
	    rev2#set_delta d
	  end
        end else begin 
          (* Picks the intermediary which gives the best coverage *)
          let best_middle_idx = ref (-1) in 
          (* for best_coverage, the smaller, the better: measures uncovered amount *)
          let best_coverage   = ref (rev1_l + rev2_l + 1) in 
          for revm_idx = rev2_idx - 1 downto rev1_idx + 1 do begin 
            let revm = Vec.get revm_idx revs in 
            let revm_e = Vec.get (rev2_idx - revm_idx) revm#get_editlist in 
            let forw_e = Vec.get (revm_idx - rev1_idx) rev1#get_editlist in 
            let zip_e = Compute_edlist.zip_edit_lists revm_e forw_e in 
            let (c1, c2) = Compute_edlist.diff_cover zip_e in 
            (* Computes the amount of uncovered text *)
            let unc1 = rev1_l - c1 in 
            let unc2 = rev2_l - c2 in 
            let unc = min unc1 unc2 in 
            (* Computes the percentages of uncovered *)
            let perc1 = (float_of_int (unc1 + 1)) /. (float_of_int (rev1_l + 1)) in 
            let perc2 = (float_of_int (unc2 + 1)) /. (float_of_int (rev2_l + 1)) in 
            let perc  = min perc1 perc2 in 
            (* If it qualifies, and if it is better than the best, use it *)
            if perc <= max_perc_to_zip && unc <= max_uncovered_to_zip && unc < !best_coverage then begin 
              best_coverage := unc; 
              best_middle_idx := revm_idx
            end
          end done; 
          (* If it found anything suitable, uses it *)
          if !best_middle_idx > -1 then begin 
            (* Then uses the best middle index to zip *)
            let revm = Vec.get !best_middle_idx revs in 
            let revm_e = Vec.get (rev2_idx - !best_middle_idx) revm#get_editlist in 
            let forw_e = Vec.get (!best_middle_idx - rev1_idx) rev1#get_editlist in 
            (* ... and computes the distance via zipping. *)
            let edits = Compute_edlist.edit_diff_using_zipped_edits rev1_t rev2_t forw_e revm_e in 
            let d = Editlist.edit_distance edits (max rev1_l rev2_l) in 
            rev1#set_distance (Vec.setappend 0.0 d i rev1#get_distance);
            rev1#set_editlist (Vec.setappend [] edits i rev1#get_editlist);

            (* Evaluates the error if so asked *)
            if eval_zip_error then begin 
              let edits' = Chdiff.edit_diff rev1_t rev2_t rev2_i in 
              let d'     = Editlist.edit_distance edits' (max rev1_l rev2_l) in 
              let err    = ((d +. 1.) /. (d' +. 1.)) in 
              Printf.printf "\nPrecision: %7.5f d_real: %6.1f d_zip: %6.1f" err d' d;
              (* If the error is large, redoes the critical step, so we can go in with a debugger *)
              if err > max_zip_error then begin 
                Printf.printf "\nRev1 id: %d Rev2 id: %d" rev1#get_id rev2#get_id; 
                Printf.printf "\n================================================================\n"; 
                Editlist.print_diff edits;
                Printf.printf "\n----------------------------------------------------------------\n";
                Editlist.print_diff edits';
                Printf.printf "\n================================================================\n"; 
                (* This is so I can use the debugger *)
                ignore (Compute_edlist.edit_diff_using_zipped_edits rev1_t rev2_t forw_e revm_e)
              end
            end

          end else begin 
            (* Nothing suitable found, uses the brute-force approach of computing 
	       the edit distance from direct text comparison. ¯*)
            let edits   = Chdiff.edit_diff rev1_t rev2_t rev2_i in 
            let d = Editlist.edit_distance edits (max rev1_l rev2_l) in 
            rev1#set_distance (Vec.setappend 0.0 d i rev1#get_distance);
            rev1#set_editlist (Vec.setappend [] edits i rev1#get_editlist);
            if eval_zip_error then Printf.printf "\nPrecision: nonzip"
          end
        end
      end done; 


    (** Computes and prints EditInc and EditLife information.
      Uses data relative to the oldest revision and its
      n_edit_judging successors. *)
    method private online_eval_oldest_edit =
      (* This is for the computation of edit longevity *)
      let n_judges_1 = ref 0 in 
      let tot_qual_1 = ref 0.0 in 
      (* rev0 is the revision before, 
         rev1 is the judged, 
         rev2 is the judge, so in time they are in the order rev0, rev1, rev2.  *)
      let max_idx = min n_edit_judging ((Vec.length revs) - 1) in 
      let rev0 = Vec.get 0 revs in 
      let uid0 = rev0#get_user_id in 
      let uname0 = rev0#get_user_name in
      let rid0 = rev0#get_id in 
      let dist0 = rev0#get_distance in 
      let time0 = rev0#get_time in 
      for rev1_idx = 1 to max_idx - 1 do begin 
        (* I do this only if the authors of rev0 and rev1 are different *)
        let rev1 = Vec.get rev1_idx revs in 
        if Revision.different_author equate_anons rev0 rev1 then begin 
          let d01 = Vec.get rev1_idx dist0 in 
          (* If d01 = 0, nothing to be done *)
          if d01 > 0. then begin 
            let rev1 = Vec.get rev1_idx revs in 
            let uid1 = rev1#get_user_id in 
            let uname1 = rev1#get_user_name in
            let rid1 = rev1#get_id in 
            let time1 = rev1#get_time in 
            let dist1 = rev1#get_distance in 
            for rev2_idx = rev1_idx + 1 to max_idx do begin 
              (* Again, check for different authors *)
              let rev2 = Vec.get rev2_idx revs in 
              let uid2 = rev2#get_user_id in 
              let uname2 = rev2#get_user_name in
              if Revision.different_author equate_anons rev1 rev2 then begin 
                (* Ok, we have a valid distance triple *)
                let d12 = Vec.get (rev2_idx - rev1_idx) dist1 in 
                let d02 = Vec.get rev2_idx dist0 in 
		(* dp2 is the distance between the revision before rev1, and rev2 *)
		let rev_prev = Vec.get (rev1_idx - 1) revs in 
	        let dist_prev = rev_prev#get_distance in
		let dp2 = Vec.get (rev2_idx - rev1_idx + 1) dist_prev in 
                let rid2 = rev2#get_id in 
                let time2 = rev2#get_time in 
                
                (* Prints out the edit inc *)
		match rev1#get_delta with 
		  None -> ()
		| Some delta -> begin 
                    if not eval_zip_error then 
                      Printf.fprintf out_file "\nEditInc %10.0f PageId: %d Delta: %7.2f rev0: %d uid0: %d uname0: %S rev1: %d uid1: %d uname1: %S rev2: %d uid2: %d uname2: %S d01: %7.2f d02: %7.2f d12: %7.2f dp2: %7.2f n01: %d n12: %d t01: %d t12: %d"
			(* time and page id *)
			time2 id delta
			(* revision and user ids *)
			rid0 uid0 uname0 rid1 uid1 uname1 rid2 uid2 uname2
			(* word distances *)
			d01 d02 d12 dp2
			(* distances between revisions in n. of revisions *)
			rev1_idx (rev2_idx - rev1_idx)
			(* distances between revisions in seconds *)
			(int_of_float (time1 -. time0)) (int_of_float (time2 -. time1))
		  end;
                (* If revisions 0 and 1 are consecutive, computes the 
                   contribution to the longevity of revision 1 *)
                if 1 = rev1_idx then begin 
                  let qual = (d02 -. d12) /. d01 in 
                  n_judges_1 := !n_judges_1 + 1; 
                  tot_qual_1 := !tot_qual_1 +. qual
                end
              end
            end done; (* for rev2_idx *)
            (* Now prints the average quality of revision 1 (if we have the data!) *)
            if 1 = rev1_idx && !n_judges_1 > 0 then begin 
              let avg_qual = !tot_qual_1 /. (float_of_int !n_judges_1) in 
              if not eval_zip_error then 
                Printf.fprintf out_file "\nEditLife %10.0f PageId: %d rev0: %d uid0: %d uname0: %S NJudges: %d Delta: %7.2f AvgSpecQ: %6.5f"
                  time1 id rid1 uid1 uname1 !n_judges_1 d01 avg_qual
            end
          end
        end
      end done
      

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
      let r = new Revision.reputation_revision rev_id page_id timestamp time contributor user_id ip_addr username is_minor comment text_init n_edit_judging in 
      match last_rev with 
        (* This is the first we see for this page *)
        None -> last_rev <- Some r
      | Some r' -> begin
          (* Replaces r' by r in last_rev: we could have done this 
             earlier, but then, how to match r'? *)
          last_rev <- Some r; 
          (* If r and r' have different author, puts r' into the vector 
             of revisions, and analyzes it *)
          if Revision.different_author equate_anons r r' then begin 
            revs <- Vec.append r' revs; 
            (* Evaluates the newest version *)
            self#online_eval_newest_text; 
            self#online_eval_newest_edit; 
            (* If the buffer is full, evaluates the oldest version and kicks it out *)
            if (Vec.length revs) > max_n_of_revs then begin 
              (* The parameter 0 is the index of what is considered to be the oldest. 
                 It is used, since in no_more_revisions it may be a larger number *)
              self#online_eval_oldest_text;
              self#online_eval_oldest_edit;
              revs <- Vec.remove 0 revs;
              (* increments the offset of the oldest version *)
              offset <- offset + 1 
            end (* if *)
          end (* if *)
        end (* some *)
  

    (** This method is called when there are no more revisions to evaluate, 
        and processes what is left in the buffer. *) 
    method eval : unit = 
      match last_rev with 
        (* There were no revisions, nothing to do *)
        None -> ()
      | Some r' -> begin 
          (* Evaluates r' as new *)
          revs <- Vec.append r' revs; 
          (* Evaluates the newest version *)
          self#online_eval_newest_text; 
          self#online_eval_newest_edit; 
          (* and evaluates all of the oldest ones, emptying the buffer *)
          for i = 0 to (Vec.length revs) - 1 do begin 
            self#online_eval_oldest_text;
            self#online_eval_oldest_edit;
            revs <- Vec.remove 0 revs
          end done
        end

  end (* page *)
