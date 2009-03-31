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
    the attention of the revisor. *)

type word = string 

(** [compute_trust_chunks chunks_trust_a new_chunks_a new_seps medit_l
    rep_float] computes the new word trust values of the revision with
    chunks [new_chunks_a], obtained from the version with word trust
    values [chunks_trust_a] via the edit list [medit_l].  [new_seps]
    are the new seps of the latest revision. [rep_float] is the
    reputation of the author of the new revision.  What is new about
    this method, compared to the classical compute_word_trust one, is
    that this one takes into account syntactical units to spread the
    trust. *)
val compute_trust_chunks : 
  (* chunks_trust_a *) float array array -> 
  (* new_chunks_a *) word array array -> 
  (* new_seps *) Text.sep_t array -> 
  (* medit_l *) Editlist.medit list -> 
  (* rep_float *) float -> 
  (* trust_coeff_lends_rep *) float -> 
  (* trust_coeff_kill_decrease *) float ->
  (* trust_coeff_cut_rep_radius *) float ->
  (* trust_coeff_read_all *) float ->
  (* trust_coeff_read_part *) float ->
  (* trust_coeff_local_decay *) float -> 
  float array array 

(** [compute_origin chunks_origin_a new_chunks_a medit_l revid] computes the origin of 
    the text in the chunks [new_chunks_a], belonging to a revision with id [revid]. 
    [medit_l] is the edit list explaining the change from previous to current revision. *)
val compute_origin :
  (* chunks_origin_a *) int array array ->
  (* new_chunks_a *) word array array ->
  (* medit_l *) Editlist.medit list ->
  (* revid *) int ->
  int array array
