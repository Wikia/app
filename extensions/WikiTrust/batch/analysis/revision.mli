(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler, Ian Pye

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

open Editlist

type word = string
class revision :
  int ->
  int ->
  string ->
  float ->
  string ->
  int ->
  string ->
  string ->
  bool ->
  string ->
  string Vec.t ->
  object
    val is_anon : bool
    method get_id : int
    method get_ip : string
    method get_is_anon : bool
    method get_page_id : int
    method get_time : float
    method get_user_id : int
    method get_user_name : string
  end
val different_author :
  bool ->
  < get_ip : string; get_user_id : int; get_is_anon : bool; ..> ->
  < get_ip : string; get_user_id : int; get_is_anon : bool; ..> -> bool
class plain_revision :
  int ->
  int ->
  string ->
  float ->
  string ->
  int ->
  string ->
  string ->
  bool ->
  string ->
  string Vec.t ->
  object
    val is_anon : bool
    val words : Text.word array
    method get_id : int
    method get_ip : string
    method get_is_anon : bool
    method get_n_words : int
    method get_page_id : int
    method get_time : float
    method get_user_id : int
    method get_user_name : string
    method get_words : Text.word array
    method print_words : unit
  end
class cirlin_revision :
  int ->
  int ->
  string ->
  float ->
  string ->
  int ->
  string ->
  string ->
  bool ->
  string ->
  string Vec.t ->
  int ->
  object
    val mutable created_text : int
    val dist : float array
    val is_anon : bool
    val mutable n_text_judge_revisions : int
    val mutable total_life_text : int
    val words : Text.word array
    method get_created_text : int
    method get_dist : float array
    method get_id : int
    method get_ip : string
    method get_is_anon : bool
    method private get_n_text_judge_revisions : int
    method get_n_words : int
    method get_page_id : int
    method get_time : float
    method get_total_life_text : int
    method get_user_id : int
    method get_user_name : string
    method get_words : Text.word array
    method inc_created_text : int -> unit
    method inc_n_text_judge_revisions : unit
    method inc_total_life_text : int -> unit
    method print_text_life : out_channel -> unit
    method print_words : unit
    method set_created_text : int -> unit
  end
  
class write_only_revision :
  int ->
  int ->
  string ->
  float ->
  string ->
  int ->
  string ->
  string ->
  bool ->
  string ->
  string Vec.t ->
  object
    method get_id : int
    method get_ip : string
    method get_is_anon : bool
    method get_n_words : int
    method get_page_id : int
    method get_time : float
    method get_user_id : int
    method get_user_name : string
    method get_words : Text.word array
    method print_words : unit
    method get_size : int
    method output_revision : out_channel -> unit
  end
  
class reputation_revision :
  int ->
  int ->
  string ->
  float ->
  string ->
  int ->
  string ->
  string ->
  bool ->
  string ->
  string Vec.t ->
  int ->
  object
    val mutable created_text : int
    val dist : float array
    val mutable distance : float Vec.t
    val mutable editlist : Editlist.edit list Vec.t
    val is_anon : bool
    val mutable n_text_judge_revisions : int
    val mutable total_life_text : int
    val words : Text.word array
    method get_created_text : int
    method get_distance : float Vec.t
    method get_editlist : Editlist.edit list Vec.t
    method get_id : int
    method get_ip : string
    method get_is_anon : bool
    method private get_n_text_judge_revisions : int
    method get_n_words : int
    method get_page_id : int
    method get_time : float
    method get_total_life_text : int
    method get_user_id : int
    method get_user_name : string
    method get_words : Text.word array
    method inc_created_text : int -> unit
    method inc_n_text_judge_revisions : unit
    method inc_total_life_text : int -> unit
    method print_text_life : out_channel -> unit
    method print_words : unit
    method set_created_text : int -> unit
    method set_distance : float Vec.t -> unit
    method set_editlist : Editlist.edit list Vec.t -> unit
    method set_delta : float -> unit
    method get_delta : float option
  end
class trust_revision :
  int ->
  int ->
  string ->
  float ->
  string ->
  int ->
  string ->
  string ->
  bool ->
  string ->
  string Vec.t ->
  object
    val is_anon : bool
    val sep_word_idx : int array
    val seps : Text.sep_t array
    val mutable word_origin : int array
    val mutable word_trust : float array
    val words : Text.word array
    method get_id : int
    method get_ip : string
    method get_is_anon : bool
    method get_n_words : int
    method get_page_id : int
    method get_sep_word_idx : int array
    method get_seps : Text.sep_t array
    method get_time : float
    method get_user_id : int
    method get_user_name : string
    method get_word_origin : int array
    method get_word_trust : float array
    method get_words : Text.word array
    method output_revision : out_channel -> unit
    method output_trust_origin_revision : out_channel -> unit
    method output_trust_revision : out_channel -> unit
    method print_words : unit
    method print_words_and_seps : unit
    method set_word_origin : int array -> unit
    method set_word_trust : float array -> unit
    (* private *)  method output_rev_preamble : out_channel -> unit
    (* private *)  method output_rev_text : bool -> out_channel -> unit
  end

(** [produce_annotated_markup seps word_trust word_origin trust_is_float include_origin combined]
    produces the annotated text of the revision, with trust, and returns a Buffer.t buffer. 
    The parameters are: 
    [seps] : the seps array
    [word_trust] : the word trust array
    [word_origin] : the word origin array
    [word_author] : the word author array
    [trust_is_float] : do we need to write out trust as a float?
    [include_origin] : do we need to include origin information? 
    [include_author] : do we need to include author information?
 *)
val produce_annotated_markup : 
  (Text.sep_t array) -> (float array) -> (int array) -> (string array) -> bool -> bool -> bool -> Buffer.t
