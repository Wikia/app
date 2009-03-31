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

(** Module Computerep 
    This module computes the reputation, and produces as output two lists, 
    of edit, and data, reputation evaluations *)

open Evaltypes;;
open Rephist;;

let initial_reputation = 0.1
let debug = false
let single_debug = false
let single_debug_id = 57

class users 
  (rep_scaling: float) 
  (max_rep: float)
  (gen_exact_rep: bool)
  (include_domains: bool)
  (ip_nbytes: int)
  (user_history_file: out_channel option) 
  =
  object (self)
    val tbl = Hashtbl.create 1000 

    (* This method, when called for anonymous users returns a user id generated
       from the user ip address, if we want to include user domains in computing
       reputation. It simply returns the user id passed in input, otherwise *)

    method private generate_user_id (uid: int) (ip_addr: string) : int =
      if (uid = 0 && include_domains) then begin
	let domain = ref 0 in
	let rec accumulate (i: int) (bytes: string list) : int =
	  if (i > 0) then begin
	    try
	      domain := !domain lsl 8;
	      domain := !domain lor int_of_string(List.hd bytes);
	      accumulate (i - 1) (List.tl bytes)
	    with _ -> !domain
	  end else !domain
	in
	  -(accumulate ip_nbytes (Str.split (Str.regexp_string ".") ip_addr))
      end else uid

    method inc_rep (uid: int) (username: string) (q: float) (timestamp: Rephist.RepHistory.key) : unit = 
      let user_id = self#generate_user_id uid username in
	if Hashtbl.mem tbl user_id then 
	  begin
	    let u = Hashtbl.find tbl user_id in 
	      if debug then Printf.printf "Uid %d rep: %f " user_id u.rep; 
	      if debug then Printf.printf "inc: %f\n" (q /. rep_scaling);
	      u.rep <- max 0.0 (min max_rep (u.rep +. (q /. rep_scaling)));
	      match user_history_file with 
		  None -> ()
		| Some f -> begin 
		    let new_weight = log (1.0 +. (max 0.0 u.rep)) in 
		      if new_weight > (float_of_int u.rep_bin) +. 1.2 
			|| new_weight < (float_of_int u.rep_bin) -. 0.2 
			|| gen_exact_rep
		      then (* must write out the change in reputation *)
			let new_bin = int_of_float new_weight in 
			  if gen_exact_rep then
			    Printf.fprintf f "%f %7d %2d %2d %f\n" timestamp user_id u.rep_bin new_bin u.rep
			  else
			    Printf.fprintf f "%f %7d %2d %2d\n" timestamp user_id u.rep_bin new_bin;
			  u.rep_bin <- new_bin 
		  end;
		    if user_id = single_debug_id && single_debug then 
		      Printf.printf "Rep of %d: %f\n" user_id u.rep
	  end
	else 
	  begin
	    (* New user *)
	    let u = {
	      uname = username;
	      rep = initial_reputation; 
	      contrib = 0.0;
	      cnt = 0.0; 
	      rep_bin = 0; 
	      rep_history = RepHistory.empty } in 
	      u.rep <- max 0.0 (min max_rep (u.rep +. (q /. rep_scaling)));
	      match user_history_file with 
		  None -> ()
		| Some f -> begin 
		    let new_weight = log (1.0 +. (max 0.0 u.rep)) in 
		    let new_bin = int_of_float new_weight in 
		      if gen_exact_rep then
			Printf.fprintf f "%f %7d %2d %2d %f\n" timestamp user_id (-1) new_bin u.rep
		      else
			Printf.fprintf f "%f %7d %2d %2d\n" timestamp user_id (-1) new_bin;
		      u.rep_bin <- new_bin 
		  end;
		    Hashtbl.add tbl user_id u; 
	  end

    method inc_contrib (uid: int) (username: string) (delta: float) (longevity: float) (include_anons: bool) : unit = 
      if (uid <> 0 || include_anons || include_domains) then 
        begin
	  let user_id = self#generate_user_id uid username in
            if Hashtbl.mem tbl user_id then begin
	      (* Existing user *)
              let u = Hashtbl.find tbl user_id in 
	        if debug then Printf.printf "Uid %d rep: %f " user_id u.rep; 
                u.contrib <- u.contrib +. (delta *. longevity);
            end
          else begin
              (* New user *)
              let u = {
                uname = username;
		rep = initial_reputation; 
                contrib = delta *. longevity;
		cnt = 0.0; 
		rep_bin = 0; 
		rep_history = RepHistory.empty } in 
                Hashtbl.add tbl user_id u; 
            end
        end

    method inc_count (uid: int) (timestamp: float) : unit = 
      if (uid <> 0 || include_domains) then 
        begin
          if Hashtbl.mem tbl uid then 
            begin
              let u = Hashtbl.find tbl uid in 
              u.cnt <- u.cnt +. 1.0
            end
          else 
            begin
              (* New user *)
              let u = {
                uname = "PlaceHolder";
                rep = 0.0; 
                contrib = 0.0; 
                cnt = 1.0; 
                rep_bin = 0; 
                rep_history = RepHistory.empty } in 
                Hashtbl.add tbl uid u
            end
        end

    method get_rep (uid: int) : float = 
      if uid = 0 
      then initial_reputation
      else
        begin
          if Hashtbl.mem tbl uid then 
            begin
              let u = Hashtbl.find tbl uid in 
              u.rep 
            end
          else
            initial_reputation
        end

    method get_contrib (uid: int) : float =
      if uid = 0 
      then 0.0
      else
        begin
          if Hashtbl.mem tbl uid then 
            begin
              let u = Hashtbl.find tbl uid in 
              u.contrib
            end
          else
            0.0
        end

    method get_weight (uid: int) : float = 
      let r = self#get_rep uid in 
      log (1.0 +. (max 0.0 r))
        
    method get_count (uid: int) : float = 
      if uid = 0 
      then 0.0 
      else 
        begin
          if Hashtbl.mem tbl uid then 
            begin
              let u = Hashtbl.find tbl uid in 
              u.cnt
            end
          else
            0.0
        end
      
    method get_users : (int, Evaltypes.user_data_t) Hashtbl.t = tbl

    method print_contributions (out_ch: out_channel) (order_asc: bool) : unit =
      let vec_of_users = ref Vec.empty in
      let insert_user uid u =
        let inserted = ref false in
        let index = ref 0 in
          while not !inserted do
            try
              let (id, v) = Vec.get !index !vec_of_users in
                if order_asc then begin
                  if v.contrib >= u.contrib then begin
                    vec_of_users := Vec.insert !index (uid, u) !vec_of_users;
                    inserted := true;
                  end
                end else begin
                  if v.contrib < u.contrib then begin
                    vec_of_users := Vec.insert !index (uid, u) !vec_of_users;
                    inserted := true;
                  end
                end;
                index := !index + 1
            with Vec.Vec_index_out_of_bounds -> 
              vec_of_users := Vec.insert !index (uid, u) !vec_of_users;
              inserted := true;
          done
      in
        Hashtbl.iter insert_user tbl;
        let write_contrib (uid, v) =
          Printf.fprintf out_ch "Uid %d    Name %S    Reputation %f    Contribution %f\n" 
            uid v.uname v.rep v.contrib
        in
          Vec.iter write_contrib !vec_of_users

  end (* class users *)

class rep 
  (params: params_t) (* The parameters used for evaluation *)
  (include_anons: bool) (* Whether to include anonymous users in evaluation *)
  (rep_intv: time_intv_t) (* The interval of time for which reputation is computed *)
  (eval_intv: time_intv_t) (* The time interval for which reputation is evaluated *)
  (user_history_file: out_channel option) (* File where to write the history of user reputations *)
  (print_monthly_stats: bool) (* Prints monthly precision and recall statistics *)
  (do_cumulative_months: bool) (* True if the monthly statistics have to be cumulative *)
  (do_localinc: bool) (* In EditInc, compares a revision only with the immediately preceding one *)
  (gen_exact_rep: bool) (* True if we want to create an extra column in the user history file with exact rep values *)
  (user_contrib_order_asc: bool) (* The order in which we write out author contributions *)
  (include_domains: bool) (* Indicates that we want to extract reputation for anonymous user domains *)
  (ip_nbytes: int) (* the number of bytes to use from the user ip address *)
  (output_channel: out_channel) (* Used to print automated stuff like monthly stats *)
  (use_reputation_cap: bool) (* use reputation cap *)
  (use_nix: bool) (* Use nixing by higher reputation authors *)
  (use_weak_nix: bool) (* Use nixing by anyone *)
  (nix_interval: float) (* interval in which we expect negative edits if any *)
  (n_edit_judging: int) (* n. of edit judges for each revision; used for nixing *)
  (gen_almost_truthful_rep: bool) (* use algorithm for almost truthful reputation *)
  (gen_truthful_rep: bool) (* use strict algorithm for truthful reputation only *)
  =
object (self)
  (* This is the object keeping track of all users *)
  val user_data = new users params.rep_scaling params.max_rep gen_exact_rep include_domains ip_nbytes user_history_file
    (* These are for computing the statistics on the fly *)
  val mutable stat_text = new Computestats.stats params eval_intv
  val mutable stat_edit = new Computestats.stats params eval_intv
    (* Remembers the last month for which statistics were printed *)
  val mutable last_month = -1
    (* Remembers which revisions have been nixed *)
  val nixed : (int, unit) Hashtbl.t = Hashtbl.create 1000
    (* Which revisions were never nixed. *) 
  val not_nixed : (int, unit) Hashtbl.t = Hashtbl.create 1000

  method add_data (datum: wiki_data_t) : unit = 
    (* quality normalization function *)
    let normalize x = max (min x 1.0) (-. 1.0) in 
    (* Breaks apart the event time *)
    let date = 
      match datum with 
	EditLife e -> begin
          let uid = e.edit_life_uid0 in 
          let uname = e.edit_life_uname0 in
            if (uid <> 0 || include_anons || include_domains) 
	      && e.edit_life_delta > 0. 
              && e.edit_life_time >= rep_intv.start_time
              && e.edit_life_time <= rep_intv.end_time
            then begin
	      if debug then begin 
	        Printf.printf "EditLife T: %f rep_weight: %f data_weight: %f spec_q: %f\n" 
		  e.edit_life_time
		  (user_data#get_weight uid)
		  (e.edit_life_delta *. (float_of_int e.edit_life_n_judges))
		  (normalize e.edit_life_avg_specq) (* debug *)
	      end; 
	      stat_edit#add_event 
	        e.edit_life_time (* time of event *)
	        (user_data#get_weight uid) (* weight of user reputation *)
	        (e.edit_life_delta *. (float_of_int e.edit_life_n_judges)) (* weight of data point *)
	        (normalize e.edit_life_avg_specq); (* edit longevity *)
              user_data#inc_contrib uid uname e.edit_life_delta e.edit_life_avg_specq include_anons
	    end;
	    e.edit_life_time
	end
      | TextLife t -> begin 
          let uid = t.text_life_uid0 in 
          if (uid <> 0 || include_anons || include_domains)
            && t.text_life_time >= rep_intv.start_time
            && t.text_life_time <= rep_intv.end_time 
	    && t.text_life_new_text > 0 
	  then begin 
	    if debug then begin
	      Printf.printf "Textlife T: %f rep_weight: %f data_weight: %f spec_q: %f\n"
		t.text_life_time
		(user_data#get_weight uid)
		(float_of_int t.text_life_new_text)
		(normalize t.text_life_text_decay) (* debug *)
	    end; 
	    stat_text#add_event 
	      t.text_life_time
	      (user_data#get_weight uid)
	      (float_of_int t.text_life_new_text)
              (normalize t.text_life_text_decay)
	  end;
	  t.text_life_time
	end
      | EditInc e -> begin 
          let uid1 = e.edit_inc_uid1 in 
	  let uname1 = e.edit_inc_uname1 in
	  let revid1 = e.edit_inc_rev1 in 
          (* increments non-anonymous users or anonymous user domains, 
	     if delta > 0, and if it is in the time range *)
          if (uid1 <> 0 || include_domains)
	    && e.edit_inc_d01 > 0.
	    && e.edit_inc_delta > 0.
            && e.edit_inc_time >= rep_intv.start_time
            && e.edit_inc_time <= rep_intv.end_time
	    && e.edit_inc_uid2 <> e.edit_inc_uid1 
	    && ((not do_localinc) || (do_localinc && e.edit_inc_n01 = 1))
          then begin
	    let rep0 = user_data#get_rep e.edit_inc_uid0 in 
	    let rep1 = user_data#get_rep e.edit_inc_uid1 in 
	    let rep2 = user_data#get_rep e.edit_inc_uid2 in 
	    (* This is the specific quality based on the versions v0 v1 v2 *)
            let spec_q = min 1.0 
	      ((e.edit_inc_d02 -. e.edit_inc_d12) /. e.edit_inc_d01)
            in 
	    (* This is the specific quality based on the versions (v1 - 1) v1 v2 *)
            let spec_q_p = min 1.0 
	      ((e.edit_inc_dp2 -. e.edit_inc_d12) /. e.edit_inc_delta)
            in 

	    (* Decides nixing, on the basis of the d012 information *)
	    if use_nix then begin
	      (* Yes, we are using robust reputation *)
	      (* Decide whether we nix rev1 *)
	      if (
		(* Nix reason n. 1: negative feedback in the nixing interval *)
		(* Unless the nix is weak, only higher reputation people can nix *)
		(use_weak_nix && spec_q < 0. && e.edit_inc_t12 <= nix_interval) || 
		  (rep2 > rep1 && rep0 > rep1 && spec_q < 0. && e.edit_inc_t12 <= nix_interval) || 
		  (* Nix reason n. 2: too many edits in the nixing interval *)
                  ((e.edit_inc_n01 + e.edit_inc_n12 >= n_edit_judging) 
                    && (e.edit_inc_t01 +. e.edit_inc_t12) <= nix_interval)
	      ) then begin 
		(* Nixes the revision *)
		if not (Hashtbl.mem nixed revid1) then Hashtbl.add nixed revid1 ();
                Hashtbl.remove not_nixed revid1
	      end else begin 
                if not ((Hashtbl.mem nixed revid1) && (Hashtbl.mem not_nixed revid1)) then 
                  Hashtbl.add not_nixed revid1 ()
              end
	    end; (* End of nixing portion *)

	    (* This is the quality to be used *)
	    let qual = 
	      if gen_truthful_rep then begin 
		(* Truthful reputation: counted only if n01 = 1 *)
		if e.edit_inc_n01 = 1 then spec_q else 0.
	      end else begin 
		(* Not truthful rep. *)
		if gen_almost_truthful_rep then (min spec_q spec_q_p) else spec_q
	      end
	    in
	    
	    if qual <> 0. then begin 

	      (* Computes the reputation increment repinc *)
              let judge_w = user_data#get_weight e.edit_inc_uid2 in 
	      let proposed_repinc = e.edit_inc_delta *. qual *. judge_w in 

	      (* Computes the real reputation increment, that takes into account 
		 whether reputation-cap or reputation-cap-nix are used *)
	      let real_repinc = 
		if use_reputation_cap then begin 
		  (* If we use nixing, and the time rev1 to rev2 is greater that nixing interval, and the revision has not been nixed, 
		     then the increment is uncapped *)
		  if use_nix && (proposed_repinc < 0. || (e.edit_inc_t12 > nix_interval && (not (Hashtbl.mem nixed revid1))))
		  then proposed_repinc 
		  else begin 
		    (* We cap the reputation increment *)
		    let rep02 = min rep0 rep2 in 
		    let r_inc = min rep02 (proposed_repinc +. rep1) in 
		    let r_new = max rep1 r_inc in 
		    r_new -. rep1
		  end
		end else begin 
		  (* standard, uncapped reputation *)
		  proposed_repinc 
		end
	      in 

	      (* Increments the reputation *)
	      if debug then Printf.printf "EditInc Uid %d q3 %f\n" uid1 real_repinc; (* debug *)
              user_data#inc_rep uid1 uname1 real_repinc e.edit_inc_time

	    end (* if qual <> 0 *)
          end;
	  e.edit_inc_time 
      end
    | TextInc t -> t.text_inc_time
    in 
    (* Checks whether we have to print precision and recall at the end of the month *)
    let (new_year, new_month, _, _, _, _) = Timeconv.float_to_time date in 
    if new_month <> last_month && print_monthly_stats then begin 
      last_month <- new_month; 
      let null_ch = open_out ("/dev/null") in 
      let se = stat_edit#compute_stats false null_ch in 
      let st = stat_text#compute_stats true  null_ch in 
      Printf.fprintf output_channel "%2d/%4d %f %12.1f %6.3f %7.5f %7.5f %12.1f %6.3f %7.5f %7.5f\n" 
	new_month new_year date 
	se.stat_total_weight se.stat_bad_perc se.stat_bad_precision se.stat_bad_recall 
	st.stat_total_weight st.stat_bad_perc st.stat_bad_precision st.stat_bad_recall; 
      flush output_channel; 
      (* If the statistics are not cumulative, then resets them *)
      if not do_cumulative_months then begin
	stat_text <- new Computestats.stats params eval_intv;
	stat_edit <- new Computestats.stats params eval_intv
      end
    end


  (* This method computes the statistics, and returns the edit_stats * text_stats *)
  method compute_stats (contrib_out_ch: out_channel option) (out_ch: out_channel) : stats_t * stats_t = 
    begin
      match contrib_out_ch with
          Some f -> user_data#print_contributions f user_contrib_order_asc
        | None -> ()
    end;
    let total_revs = (Hashtbl.length nixed) + (Hashtbl.length not_nixed) in
    Printf.fprintf out_ch "%d Revisions out of %d nixed -- %f percent."
        (Hashtbl.length nixed) total_revs (float_of_int (Hashtbl.length nixed) /.
        float_of_int total_revs) ;
    Printf.fprintf out_ch "\nEdit Stats:\n"; 
    let edit_s = stat_edit#compute_stats false out_ch in 
    Printf.fprintf out_ch "\nText Stats:\n";
    let text_s = stat_text#compute_stats true  out_ch in 
    (edit_s, text_s) 

  method get_users : (int, Evaltypes.user_data_t) Hashtbl.t = user_data#get_users

end;; (* class rep *)
