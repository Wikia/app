(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler, Vishwanath Raman

All rights reserved.

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

val initial_reputation : float
val debug : bool
val single_debug : bool
val single_debug_id : int
class users :
  float ->
  float ->
  bool ->
  bool ->
  int ->
  out_channel option ->
  object
    method private generate_user_id : int -> string -> int
    method get_count : int -> float
    method get_rep : int -> float
    method get_users : (int, Evaltypes.user_data_t) Hashtbl.t
    method get_contrib : int -> float
    method get_weight : int -> float
    method inc_count : int -> Rephist.RepHistory.key -> unit
    method inc_rep : int -> string -> float -> Rephist.RepHistory.key -> unit
    method inc_contrib : int -> string -> float -> float -> bool -> unit
    method print_contributions : out_channel -> bool -> unit
  end
class rep :
  (* parameters *) Evaltypes.params_t ->
  (* include_anons *) bool ->
  (* rep_intv *) Evaltypes.time_intv_t ->
  (* eval_intv *) Evaltypes.time_intv_t ->
  (* user_history_file *) out_channel option ->
  (* print_monthly_stats *) bool -> 
  (* do_cumulative_months *) bool ->
  (* do_localinc *) bool ->
  (* gen_exact_rep *) bool ->
  (* user_contrib_order_asc *) bool ->
  (* include_domains *) bool ->
  (* ip_nbytes *) int ->
  (* output_channel *) out_channel -> 
  (* use_reputation_cap *) bool -> 
  (* use_nix *) bool ->
  (* use_weak_nix *) bool -> 
  (* nix_interval *) float ->
  (* n_edit_judging *) int -> 
  (* gen_almost_truthful_rep *) bool -> 
  (* gen_truthful_rep *) bool -> 
  object
    method add_data : Evaltypes.wiki_data_t -> unit
    method compute_stats : out_channel option -> out_channel -> Evaltypes.stats_t * Evaltypes.stats_t
    method get_users : (int, Evaltypes.user_data_t) Hashtbl.t
  end
