(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, Marco Faella

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

(** This is an implementation of a page based on a circular buffer, 
    and evaluates it for author reputation. 
    The code is outdated, and should not be used.  The code has been 
    kept only for historical reasons, and to be able to run regression tests. 
    The reduced statistics file is not guaranteed to be in the proper format. *)

type word = string 
open Eval_defs


class page
  (id: int)
  (title: string)
  (out_file: out_channel)
  (n_text_judging: int)
  (n_edit_judging: int)
  (equate_anons: bool) (* if No, then anon users of different IP are considered different *)
  = 
  let cache_size = 2 + (max n_edit_judging n_text_judging) in
  object (self)

    (* This is a small cache of revisions, used as a circular
       buffer. Since we only add to the buffer, we do not need to 
       keep two different pointers to head and tail, nor do we need
       to leave one cell empty. *)
    val rev_cache : (Revision.cirlin_revision option) array = Array.make cache_size None

    (* offset + newest is the absolute n. of revisions for the newest revision. *)
    val mutable offset : int = 0
    (* pointer to the position where to insert the newest element in the circular buffer *)
    val mutable newest : int = 0
    
      (* For text life analysis *)
    val mutable wl             = [| |] 
    val mutable wl_attr        = [| |]
    val mutable chunks         = []
    val mutable chunks_attr    = []

    method print_id_title = 
      Printf.fprintf out_file "Page: %i Title: %S\n" id title; 
      flush out_file

    (** This method evaluates the currently newest revision w.r.t. to
        the previous one, using the text longevity method.
        Thus, the currently newest revision should not
        be the very first revision.
        This method should be called just before a new revision is
        inserted in the cache. The cache is not necessarily full here. 
        
        eval_oldest and eval_newest together replace eval_text
        in the cached version of the algorithm. *)
    method private eval_newest = 
      
      let rev_idx = newest in
      let new_rev = match rev_cache.(newest) with
          Some r -> r 
        | None -> raise (Invalid_argument "newest revision not found")
      in
      let uid = new_rev#get_user_id in 
      let rid = new_rev#get_id in 
      (* the absolute index of the newest revision *)
      let absolute_idx = rev_idx + offset in

      (* f_inherit updates the history appropriately. *)
      let f_inherit was_live is_live old_hist = old_hist in 
      let new_wl = new_rev#get_words in 
      (* Now calls the function that analyzes the difference 
         between revisions. Data relative to the previous revision
         is stored in the instance fields wl, wl_attr, chunks, and
         chunks_attr *)

      let (new_wl_attr, new_chunks, new_chunks_attr) =
        Chdiff.text_survival wl wl_attr chunks chunks_attr 
          new_wl f_inherit absolute_idx in 

      (* Gathers the comments done to the n_judging_revisions
         previous revisions; this is to avoid producing one output
         per word! *)
      let credit_text_temp = Array.make n_text_judging 0 in 
      (* We analyze only new_wl_attr, which are the attributes of the live words. 
         credit is the function that assigns credit. *)
      let credit (r: int) : unit = 
        (* credit is given only if not too old, and not to ourselves. *)
        if (absolute_idx - r <= n_text_judging)
          && (r < absolute_idx) then 
            credit_text_temp.(absolute_idx - r - 1) <- 
            credit_text_temp.(absolute_idx - r - 1) + 1
      in
      Array.iter credit new_wl_attr; 

      (* Now we must use the results in credit_text_temp to give
         the actual credit, but ONLY if the userid receiving the
         credit is different from the current one. *)
      (* loop over some preceding revisions *)
      for i = 0 to n_text_judging - 1 do 
        (* index r points to the (i+1)-th revision before the newest;
           it must wrap around the circular buffer *)
        let r_temp = rev_idx - i - 1 in
        let r = 
          if r_temp >= 0 then r_temp
          else cache_size + r_temp
        in
        match rev_cache.(r) with

          Some other ->
            let target_uid = other#get_user_id in 
            if Revision.different_author equate_anons new_rev other then
              begin 
                (* gives credit for the existing text *)
                other#inc_total_life_text credit_text_temp.(i); 
                (* prints out the credit line *)
                Printf.fprintf out_file "TextInc %10.0f PageId: %d JudgedRev: %d JudgedUid: %d JudgeRev: %d JudgeUid: %d t: %d q: %d\n"
                  new_rev#get_time
                  id other#get_id target_uid rid uid
                  other#get_created_text
                  credit_text_temp.(i); 
              end

        | None -> () (* cache is not full *)
      done; (* for i *)
      
      (* Now we must write in new_rev how much new text has been created *)
      let make_total n r = 
        if absolute_idx = r 
        then n + 1
        else n 
      in
      let new_text = Array.fold_left make_total 0 new_wl_attr in 
      new_rev#set_created_text new_text;
      (* stores data for the next revision *)
      wl          <- new_wl;
      wl_attr     <- new_wl_attr;
      chunks      <- new_chunks;
      chunks_attr <- new_chunks_attr


    (** eval_newest_edit and eval_oldest_edit together
      replace eval_edit *)
    method private eval_newest_edit = 

      (* computes all the pairwise distances within the edit-distance horizon *)
      let rev2_idx = newest in
      let rev2 = match rev_cache.(rev2_idx) with
          Some r -> r 
        | None -> raise (Invalid_argument "newest revision not found")
      in
      let rev2_t = rev2#get_words in 
      let rev2_l = Array.length (rev2_t) in 
      let rev2_i = Chdiff.make_index_diff rev2_t in 

      (* loop over some preceding revisions *)
      for i = 0 to n_edit_judging - 1 do
        (* index r wraps around the circular buffer *)
        let r_temp = rev2_idx - i - 1 in
        let rev1_idx = 
          if r_temp >= 0 then r_temp
          else cache_size + r_temp
        in
        match rev_cache.(rev1_idx) with

          Some rev1 ->
            let dist   = rev1#get_dist in 
            let rev1_t = rev1#get_words in 
            let rev1_l = Array.length (rev1_t) in 
            let edits  = Chdiff.edit_diff rev1_t rev2_t rev2_i in 
            let d      = Editlist.edit_distance edits (max rev1_l rev2_l) in 
            dist.(i) <- d

        | None -> () (* cache is not full, not a problem *)
      done (* for i *)


    (** This method sets the "n_text_judge_revisions" field
      of the oldest revision in the cache and then prints
      the TextLife output.
      This method should be called after all TextInc operations
      have been performed on the oldest revision.
      This method is "usually" called when the cache is full,
      except in the final clean-up stage.
      
      eval_oldest and eval_newest together replace eval_text
      in the cached version of the algorithm. *)
    method private eval_oldest = 
      let oldest = (newest + 1) mod cache_size in
      let oldest_r = match rev_cache.(oldest) with
          Some r -> r
        | None -> raise (Invalid_argument "invalid oldest revision")
      in
      (* Writes in oldest_r the number of judge revisions.
         This value is later printed by print_text_life *)
      for j = 0 to cache_size -1 do 
        (* all revisions in the cache are "judging revisions"
           except oldest_r itself *)
        if (j <> oldest) then
          match rev_cache.(j) with
            Some r -> 
	      if Revision.different_author equate_anons r oldest_r 
	      then oldest_r#inc_n_text_judge_revisions
          | None -> ()
      done;
      (* Now it must print out how much text it created, 
         how many revisions judged it, and what the judgement was. *)
      oldest_r#print_text_life out_file


    (** Computes and prints EditInc and EditLife information.
      Uses data relative to the oldest revision and its
      n_edit_judging successors.

      eval_newest_edit and eval_oldest_edit together
      replace eval_edit *)
    method private eval_oldest_edit =
      (* rev0_idx is the before, 
         rev1_idx is the judged, 
         rev2_idx is the judge *)
      let rev0_idx = (newest + 1) mod cache_size in
      let rev1_idx = (rev0_idx + 1) mod cache_size in 
      let rev0 = match rev_cache.(rev0_idx) with
          Some r -> r
        | None -> raise (Invalid_argument "invalid cache status in eval_oldest_edit")
      in
      let rev1 = match rev_cache.(rev1_idx) with
          Some r -> r
        | None -> raise (Invalid_argument "invalid cache status in eval_oldest_edit")
      in
      let curr_uid       = rev1#get_user_id
      and delta          = (rev0#get_dist).(0)
      and n_judges1      = ref 0
      and tot_spec_qual1 = ref 0.0 in

      (* rev0_idx is the before, 
         rev1_idx is the judged, 
         rev2_idx is the judge *)
      if delta > 0.0 then 
        begin 
          (* loop over some of the following revisions *)
          for i = 0 to n_edit_judging - 2 do
            let rev2_idx = (rev1_idx + i + 1) mod cache_size in

            match rev_cache.(rev2_idx) with

              Some rev2 ->
                let rev2_uid = rev2#get_user_id in 
                (* We judge a page only if the judge uid is different
                   from the judged uid *)
                if Revision.different_author equate_anons rev1 rev2 then 
                  begin
                    (* Computes quantities for EditInc and EditLife *)
                    (* d_prev is the distance between the judge and the version before the judged *)
                    let d_prev = (rev0#get_dist).(i+1) in 
                    (* d_curr is the distance between the judge and the judged *)
                    let d_curr = (rev1#get_dist).(i) in 
                    (* qual is the quality of the revision *)
                    let qual = (d_prev -. d_curr) /. delta in 
                    (* Modifies the edit record *)
                    n_judges1      := !n_judges1 + 1;
                    tot_spec_qual1 := !tot_spec_qual1 +. qual;
                
                    (* Prints out the information on edit incs *)
                    Printf.fprintf out_file "EditInc %10.0f PageId: %d JudgedRev: %d JudgedUid: %d JudgeRev: %d JudgeUid: %d Dbefore: %7.2f Djudged: %7.2f Delta: %7.2f\n"
                      rev2#get_time
                      id
                      rev1#get_id
                      curr_uid
                      rev2#get_id
                      rev2_uid d_prev d_curr delta
                  end (* if rev1 author <> rev2 author *)

            | None -> ()
          done; (* for i *)

          (* Now prints the data related to edit total_life *)
          if !n_judges1 > 0 then 
            Printf.fprintf out_file "EditLife %10.0f PageId: %d JudgedRev: %d JudgedUid: %d NJudges: %d Delta: %7.2f AvgSpecQ: %6.5f\n"
              rev1#get_time
              id
              rev1#get_id
              curr_uid
              !n_judges1
              delta
              (!tot_spec_qual1 /. (float_of_int !n_judges1))
        end (* if delta > 0 *)

 
    (** We assume add_revision_onthefly receives revisions in 
       chronological order *)
    method add_revision 
      (id: int) (* revision id *)
      (page_id: int) (* page id *)
      (timestamp: string) (* timestamp string *)
      (time: float) (* time, as a floating point *)
      (contributor: string) (* name of the contributor *)
      (user_id: int) (* user id *)
      (ip_addr: string) (* IP address *)
      (username: string) (* name of the user *)
      (is_minor: bool) 
      (comment: string)
      (text_init: string Vec.t) (* Text of the revision, still to be split into words *)
      : unit =
      let r = new Revision.cirlin_revision id page_id timestamp time contributor user_id ip_addr username is_minor comment text_init n_edit_judging in 
      let newest' = (newest + 1) mod cache_size in
      begin match rev_cache.(newest') with

        Some _ -> (* the cache is full (asymptotical case) *)
          (* consider the previously newest revision *)
          begin match rev_cache.(newest) with

            Some r' ->
              if Revision.different_author equate_anons r r' then begin 
                (* the author of r is different from the author of r'
                   and the cache is full. *)
                (* notice: eval_newest must come before eval_oldest *)
                self#eval_newest;
                self#eval_newest_edit;
                self#eval_oldest;
                self#eval_oldest_edit;
                newest <- newest'; (* increment newest *)
                (* update offset *)
                if newest' = 0 then
                  offset <- offset + cache_size
              end
                (* if the author of r is the same as the one of r',
                   we replace r' with r and perform no calculations *)

          | None -> (* impossible! the cache was supposed to be full! *)
              raise (Invalid_argument "inconsistent cache")
          end;

      | None -> (* the cache is not full yet *)

          (* consider the previously newest revision *)
          begin match rev_cache.(newest) with

            Some r' ->
              if Revision.different_author equate_anons r r' then begin 
                (* the author of r is different from the author of r'
                   and the cache is not full. *)
                if newest = 0 then begin
                  (* r' is the last revision in the first series of
                     revisions by the same author.
                     In other words, it is the revision which is
                     responsible for initializing the algorithm. *)
                  wl          <- r'#get_words;
                  let wl_len = Array.length wl in
                  (* the attribute of each word is the revision where the word
                     originated *)
                  wl_attr     <- Array.make wl_len 0; 
                  chunks      <- [];
                  chunks_attr <- [];
                  (* Gives credit for the creation, in the first revision *)
                  r'#set_created_text wl_len; 
                end else begin
                  self#eval_newest;
                  self#eval_newest_edit;
                end;
                newest <- newest'; (* increment newest *)
                (* update offset *)
                if newest' = 0 then
                  offset <- offset + cache_size
              end
                (* if the author of r is the same as the one of r',
                   we replace r' with r and perform no calculations *)

          | None -> (* r is the very first revision for this page.
                       We add it to the cache, no questions asked *)
                ()
          end;
      end;
      (* in any case, r becomes the "newest" revision *)
      rev_cache.(newest) <- Some r


    (** This method should be called after the last revision has been
      "added_onthefly". It clears the cache producing the appropriate
      output. *)
    method eval : unit = 
      (* notice: we assume there is at least one revision *)
      self#eval_newest;
      self#eval_newest_edit;
      (* now, we have to call eval_oldest on all revisions in the
         cache, starting with the oldest.
         This task is a bit complex, since the cache is not
         necessarily full at this point (a page could have less
         revisions than the size of the cache). *)

      (* eval_oldest assumes that the oldest revision is the one
         that follows the newest in the cache.
         Thus, we advance the newest pointer to the cell that precedes
         the oldest revision in the cache *)
      let i = ref ((newest + 1) mod cache_size) in
      while (rev_cache.(!i) == None) do
        i := (!i + 1) mod cache_size
      done;
      newest <- !i - 1;
      
      (* now, we call eval_oldest on all revisions *)
      let oldest = ref ((newest + 1) mod cache_size) in
      while (rev_cache.(!oldest) <> None) do
        self#eval_oldest;
        (* we should not call eval_oldest_edit on the
           last and the penultimate revision, since
           that raises an excetion. Thus...we ignore it! *)
        begin try
          self#eval_oldest_edit;
        with 
          Invalid_argument x -> ();
        end;    
        rev_cache.(!oldest) <- None;
        newest <- !oldest;
        oldest := (newest + 1) mod cache_size
      done

  end (* page *)
