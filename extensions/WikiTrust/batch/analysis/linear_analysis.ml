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


(** This is an implementation of the page class based on a linear implementation
    that keeps all revisions in memory, and computes an old format of 
    reduced statistics file.  This is highly inefficient, and the statistics file 
    is outdated, so this class is kept for historical reasons only (that is, 
    to be able to run regression tests on new code).  DO NOT USE OTHERWISE. *)

type word = string 
open Eval_defs

type rev_info_t = {
  mutable delta: float; 
  mutable n_judges: int; 
  mutable tot_spec_qual: float; 
  }


class page 
  (id: int)
  (title: string)
  (out_file: out_channel)
  (n_text_judging: int)
  (n_edit_judging: int)
  (equate_anons: bool) (* if No, then anon users of different IP are considered different *)

  = 
  object (self)

    (* These are all the revisions of a page *)
    val mutable revisions : Revision.cirlin_revision list = []
      (* These are all the revisions of a page, filtered:
         only the last of a group of consecutive revisions by 
         the same author is kept *)
    val mutable filtered_revisions : Revision.cirlin_revision array option = None

    (** Adds a revision.  Note: add all revisions BEFORE calling any 
        revision evaluation function!!  Revisions added after the filtered 
        revisions are needed are not computed. *)
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
      let r = new Revision.cirlin_revision id page_id timestamp time contributor user_id ip_addr username is_minor comment text_init n_edit_judging in 
      (* I know it looks crazy, but this keeps them in rough
         chronological order *)
      revisions <- revisions @ [r]

    method print_id_title = 
      Printf.fprintf out_file "Page: %i Title: %S\n" id title; 
      flush out_file

    method private get_filtered_revisions : Revision.cirlin_revision array = 
      (** In filtered revisions, only the last one of consecutive 
          revisions by the same author is kept.  This function also 
          takes care of ordering revisions chronologically (in 
          the list, they can be in any order. 
          NOTE: once you ask for filtered revisions, you cannot 
          add any more revisions to the list - they will not be considered! *)
      match filtered_revisions with 
        Some f -> f
      | None -> begin
          (* First, we order them chronologically *)
          let revs = Array.of_list revisions in 
          let cmp (r1: Revision.cirlin_revision) (r2: Revision.cirlin_revision) : int = 
            let t1 = r1#get_time in 
            let t2 = r2#get_time in 
            Timeconv.cmp t1 t2 
          in 
          Array.sort cmp revs; 
          (* Then filters them *)
          let fil_rev_l = ref [] in 
          let len = Array.length (revs) in 
          for i = 0 to len - 1 do 
            if (i = len - 1) || (Revision.different_author equate_anons revs.(i) revs.(i+1)) then 
              fil_rev_l := revs.(i) :: !fil_rev_l
          done; 
          let a = Array.of_list (List.rev !fil_rev_l) in
          filtered_revisions <- Some a; 
          a
        end

    method private eval_text = 
      (** This method evaluates the page, using the text longevity method. *)
      let revs = self#get_filtered_revisions in 
      let n_revs = Array.length (revs) in 
      
      (* Writes in each revision the number of judge revisions *)
      for i = 0 to n_revs - 2 do
        (* i is the index of the revision being judged *)
        for j = i + 1 to (min (i + n_text_judging) (n_revs - 1)) do 
          (* j is the judging revision *)
          if Revision.different_author equate_anons revs.(j) revs.(i) 
	  then revs.(i)#inc_n_text_judge_revisions
        done;
      done;
      
      (* Creates the attributes of the words of the first revision *)
      let old_wl = ref revs.(0)#get_words in
      let len_old_wl = Array.length !old_wl in 
      let old_wl_attr = ref (Array.make len_old_wl 0) in 
      let old_chunks = ref [] in 
      let old_chunks_attr = ref [] in 
      (* Gives credit for the creation, in the first revision *)
      revs.(0)#set_created_text len_old_wl; 

      (* Now loops for all revisions past the first, judging: 
         - how much text they create
         - how much text created in previous revisions is still there *)

      for rev_idx = 1 to n_revs - 1 do 
        begin
          (* Analyzes the new revision *)
          (* First, I have to define the new functions for word
             tagging.  c_new is (Created rev_idx); f_inherit updates
             the history appropriately. *)
          let c_new = rev_idx in 
          let f_inherit was_live is_live old_hist = old_hist in 
          let new_wl = revs.(rev_idx)#get_words in 
          (* Now calls the function that analyzes the difference
             between revisions *)

          let (new_wl_attr, new_chunks, new_chunks_attr) 
              = Chdiff.text_survival !old_wl !old_wl_attr !old_chunks !old_chunks_attr new_wl 
                                     f_inherit c_new in 
          (* Gives comments to the preceding revisions, according to the result of 
             the comparison *)
          let uid = revs.(rev_idx)#get_user_id in 
          let rid = revs.(rev_idx)#get_id in 
          (* Gathers the comments done to the n_judging_revisions
             previous revisions; this is to avoid producing one output
             per word! *)
          let credit_text_temp = Array.make n_text_judging 0 in 
          (* We analyze only new_wl_attr, which are the attributes of the live words. 
             credit is the function that assigns credit. *)
          let credit (r: int) : unit = 
            (* credit is given only if not too old, 
               and not to ourselves. *)
            if (rev_idx - r <= n_text_judging)
              && (r < rev_idx) then 
                credit_text_temp.(rev_idx - r - 1) <- credit_text_temp.(rev_idx - r - 1) + 1
          in
          Array.iter credit new_wl_attr; 
          (* Now we must use the results in credit_text_temp to give
             the actual credit, but ONLY if the author receiving the
             credit is different from the current one. *)
          for i = 0 to n_text_judging - 1 do 
            let r = rev_idx - i - 1 in 
            if r >= 0 then 
              begin
                let target_uid = revs.(r)#get_user_id in 
                if Revision.different_author equate_anons revs.(r) revs.(rev_idx) then begin 
                  (* gives credit for the existing text *)
                  revs.(r)#inc_total_life_text credit_text_temp.(i); 
                  (* prints out the credit line *)
                  Printf.fprintf out_file "TextInc %10.0f PageId: %d JudgedRev: %d JudgedUid: %d JudgeRev: %d JudgeUid: %d t: %d q: %d\n"
                    revs.(rev_idx)#get_time
                    id
                    revs.(r)#get_id
                    target_uid
                    rid
                    uid
                    revs.(r)#get_created_text
                    credit_text_temp.(i); 
                end
              end (* if r >= 0 *)
          done; 
          (* Now we must write in rev_idx how much new text has been created *)
          let make_total n r = 
            if rev_idx = r 
            then n + 1
            else n 
          in
          let new_text = Array.fold_left make_total 0 new_wl_attr in 
          revs.(rev_idx)#set_created_text new_text;
          (* Ok, moves on to the next revision *)
          old_wl := new_wl; 
          old_wl_attr := new_wl_attr; 
          old_chunks := new_chunks; 
          old_chunks_attr := new_chunks_attr
        end
      done; 
      (* Now it must print out, for each revision, how much text it created, 
         how many revisions judged it, and what the judgement was. *)
      for rev_idx = 0 to n_revs - 1 do
        revs.(rev_idx)#print_text_life out_file
      done


    method private eval_edit = 
      (** This method evaluates the edit life of a page. *)

      let revs = self#get_filtered_revisions in 
      let n_revs = Array.length (revs) in
      (* This array contains the results for specific quality *)
      let initval = {delta = 0.0; n_judges = 0; tot_spec_qual = 0.0} in  
      let q = Array.make n_revs initval in 
      (* Ok, but this does not really work.  I need to make each entry a different record! *)
      for i = 0 to n_revs - 1 do 
        q.(i) <- {delta = 0.0; n_judges = 0; tot_spec_qual = 0.0}
      done; 

      (* computes all the pairwise distances within the edit-distance horizon *)
      let dist = Array.make_matrix n_revs (n_text_judging - 1) 0.0 in 
      for rev2_idx = 1 to n_revs - 1 do 
        let rev2_t = revs.(rev2_idx)#get_words in 
        let rev2_l = Array.length (rev2_t) in 
        let rev2_i = Chdiff.make_index_diff rev2_t in 
        for rev1_idx = (max 0 (rev2_idx - n_edit_judging)) to rev2_idx - 1 do 
          let rev1_t = revs.(rev1_idx)#get_words in 
          let rev1_l = Array.length (rev1_t) in 
          let edits  = Chdiff.edit_diff rev1_t rev2_t rev2_i in 
          let d      = Editlist.edit_distance edits (max rev1_l rev2_l) in 
          dist.(rev1_idx).(rev2_idx - rev1_idx - 1) <- d
        done
      done; 
      (* Ok, now prints the results *)
      for rev0_idx = 0 to n_revs - 3 do
        let rev1_idx = rev0_idx + 1 in 
        let curr_uid = revs.(rev1_idx)#get_user_id in 
        let delta = dist.(rev0_idx).(rev1_idx - rev0_idx - 1) in 

        (* rev0_idx is the before, rev1_idx is the judged *)
        if delta > 0.0 then 
          begin 
            q.(rev1_idx).delta <- delta; 
            for rev2_idx = rev1_idx + 1 to (min (rev0_idx + n_edit_judging) 
              (n_revs - 1)) do
              begin
                let next_uid = revs.(rev2_idx)#get_user_id in 
                (* We judge a page only if the author is different
                   from the judged author *)
                if Revision.different_author equate_anons revs.(rev1_idx) revs.(rev2_idx) then begin 
                    (* Computes quantities for EditInc and EditLife *)
                    (* d_prev is the distance between the judge and the version before the judged *)
                    let d_prev = dist.(rev0_idx).(rev2_idx - rev0_idx - 1) in 
                    (* d_curr is the distance between the judge and the judged *)
                    let d_curr = dist.(rev1_idx).(rev2_idx - rev1_idx - 1) in 
                    (* qual is the quality of the revision *)
                    let qual = (d_prev -. d_curr) /. delta in 
                    (* Modifies the edit record *)
                    q.(rev1_idx).n_judges <- q.(rev1_idx).n_judges + 1;
                    q.(rev1_idx).tot_spec_qual <- q.(rev1_idx).tot_spec_qual +. qual; 
                    (* Prints out the information on edit incs *)
                    Printf.fprintf out_file "EditInc %10.0f PageId: %d JudgedRev: %d JudgedUid: %d JudgeRev: %d JudgeUid: %d Dbefore: %7.2f Djudged: %7.2f Delta: %7.2f\n"
                      revs.(rev2_idx)#get_time
                      id
                      revs.(rev1_idx)#get_id
                      curr_uid
                      revs.(rev2_idx)#get_id
                      next_uid
                      d_prev
                      d_curr
                      delta
                  end (* if current author <> next author *)
              end (* for rev2_idx *)
            done; (* for rev2_idx *)
            (* Now prints the data related to edit longevity *)
            if q.(rev1_idx).n_judges > 0 then 
              Printf.fprintf out_file "EditLife %10.0f PageId: %d JudgedRev: %d JudgedUid: %d NJudges: %d Delta: %7.2f AvgSpecQ: %6.5f\n"
                revs.(rev1_idx)#get_time
                id
                revs.(rev1_idx)#get_id
                curr_uid
                q.(rev1_idx).n_judges
                delta
                (q.(rev1_idx).tot_spec_qual /. (float_of_int q.(rev1_idx).n_judges))
          end (* if delta > 0 *)
      done 
         

    method eval = 
      (** This method evaluates the page, printing all 
          relevant reduced statistics to standard output. *)
      (* Printf.fprintf out_file "StartTime: %f\n" (Unix.gettimeofday ()); *)
      self#eval_text; 
      flush stdout; 
      self#eval_edit; 
      (* Printf.fprintf out_file "EndTime: %f\n" (Unix.gettimeofday ()); *)
      flush stdout

  end (* page class *)
