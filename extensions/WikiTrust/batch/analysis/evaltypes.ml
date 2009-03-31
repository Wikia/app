(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler, Vishwanath Raman, Ian Pye

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


(** Here are some types used for evaluating reputation. 
    It is convenient to keep them all here, so we can just open this module. *)


(* **************************************************************** *)
(* Types for reading partial statistics *)

type edit_inc_t = {
  edit_inc_time: float; 
  edit_inc_page_id: int; 
  edit_inc_delta: float;
  edit_inc_rev0: int; 
  edit_inc_uid0: int; 
  edit_inc_uname0: string;
  edit_inc_rev1: int; 
  edit_inc_uid1: int; 
  edit_inc_uname1: string;
  edit_inc_rev2: int; 
  edit_inc_uid2: int; 
  edit_inc_uname2: string;
  edit_inc_d01: float;
  edit_inc_d02: float;
  edit_inc_d12: float;
  edit_inc_dp2: float;
  edit_inc_n01: int;
  edit_inc_n12: int;
  edit_inc_t01: float;
  edit_inc_t12: float;
}

type edit_life_t = {
  edit_life_time: float; 
  edit_life_page_id: int; 
  edit_life_rev0: int; 
  edit_life_uid0: int; 
  edit_life_uname0: string;
  edit_life_n_judges: int;  (* n. of judging revisions *)
  edit_life_delta: float;  (* how much change went on *)
  edit_life_avg_specq: float; (* specific quality of edit *)
}

type text_inc_t = {
  text_inc_time: float; 
  text_inc_page_id: int; 
  text_inc_rev0: int; 
  text_inc_uid0: int; 
  text_inc_uname0: string;
  text_inc_rev1: int; 
  text_inc_uid1: int; 
  text_inc_uname1: string;
  text_inc_orig_text: int; 
  text_inc_seen_text: int; 
  text_inc_n01: int;
  text_inc_t01: float;
}

type text_life_t = {
  text_life_time: float; 
  text_life_page_id: int; 
  text_life_rev0: int; 
  text_life_uid0: int; 
  text_life_uname0: string;
  text_life_n_judges: int;
  text_life_new_text: int;
  text_life_text_life: int;
  text_life_text_decay: float; 
}

(* Type of an evaluation comment as read from the file *)
type wiki_data_t = 
    EditInc of edit_inc_t 
  | EditLife of edit_life_t
  | TextInc of text_inc_t 
  | TextLife of text_life_t


(* **************************************************************** *)
(* Types for evaluating reputation *)

type params_t = {
  rep_scaling: float;
  max_rep: float; 
}
  
type time_intv_t = {
  start_time: float; 
  end_time: float; 
};;

type user_data_t = {
  mutable uname : string;
  mutable rep: float; 
  mutable contrib: float; 
  mutable cnt: float; 
  mutable rep_bin: int; (* Last reputation bin where the user was *)
  mutable rep_history: int Rephist.RepHistory.t
}

type stats_t = {
  stat_mutual_info: float; (* mutual info between high/low rep and good/bad  *)
  stat_entropy_good_bad: float; (* entropy of good/bad division *)
  stat_entropy_high_low: float; (* entropy of high/low division *)
  stat_coeff_constraint: float; (* coefficient of constraint on bad vs. low *)
  stat_bad_precision: float; (* precision of bad label *)
  stat_bad_recall: float; (* recall of bad label *)
  stat_bad_boost: float; (* How much more likely it is for a low to be bad? *)
  stat_total_weight: float; (* Total of editing taking place (total n. of words) *)
  stat_bad_perc: float; (* Total of bad weight *)
}

