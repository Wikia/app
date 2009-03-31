(*

Copyright (c) 2008 The Regents of the University of California
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

(** This file contains types that are used by several modules of the 
    online WikiTrust implementation. *)

TYPE_CONV_PATH "UCSC_WIKI_RESEARCH"    

(** Type of an author in the annotated text.  Choose int if you wish to 
    annotate text with author ids, and string if you wish to annotate 
    with author names. *)
type author_t = string with sexp

(** A chunk is a portion of text that used to be part of an article, but that 
    has since been deleted.  We associate a chunk list with each page. *)
type chunk_t = {
  (** The timestamp is the time at which the chunk was deleted from the page. 
      This is to make it possible to delete chunks that have been deleted for 
      very long (otherwise, they could accumulate). *)
  mutable timestamp: float; 
  (** Number of revisions for which a chunk has been deleted. 
      The purpose is similar to above *)
  mutable n_del_revisions: int; 
  (** This is the array of words.  Note that we store the words, not the 
      seps.  This because all we need to know of the deleted chunks is if they 
      are re-inserted, via text comparison, which is based on words. *)
  text: string array; 
  (** This is the trust of the text that has been deleted. *)
  trust: float array;
  (** These are the author signatures for the trust *)
  sigs: Author_sig.packed_author_signature_t array;
  (** This is the revision_id where each word of the text of these 
      deleted chunks was first introduced. *)
  origin: int array;
  (** This is the author of each word *)
  author: author_t array;
} with sexp

(** These are the coefficients used for the evaluation. *)
type trust_coeff_t = {
  (** Number of revision to use for trust computation *)
  mutable n_revs_to_consider : int; 
  (** Length of list of previous high reputation versions of the page *)
  mutable len_hi_rep_revs: int; 
  (** Length of list of previous high trust versions of the page *)
  mutable len_hi_trust_revs: int; 
  (** Threshold of reputation for an author to be included in a hi-reputation list *)
  mutable hi_rep_list_threshold: float;
  (** Max time a chunk can be deleted before it is discarded *)
  mutable max_del_time_chunk : float; 
  (** max n. of revisions for which a chunk can be deleted before being discarded *)
  mutable max_del_revs_chunk : int; 
  (** Max n. of words in a deleted chunk (if longer, it is truncated) *)
  mutable max_dead_chunk_len : int;
  (** how much reputation is lent as trust for new text *)
  mutable lends_rep : float; 
  (** how much the text of revised articles raises in trust towards the 
      reputation of the editor *)
  mutable read_all : float; 
  (** how much the text of revised articles, in the portion of article directly edited, 
      raises in trust towards the reputation of the editor *)
  mutable read_part: float; 
  (** how much the trust of text is lost when text is deleted *)
  mutable kill_decrease: float; 
  (** how much trust propagates from the edges of block moves *)
  mutable cut_rep_radius: float; 
  (** the text of revised articles that is local to an edit increases more in trust
      when revised (see read_part).  This coefficient says how fast this "locality" 
      effect decays at the border of a local area, into the non-local area.  A value
      of 0 is perfectly fine. *)
  mutable local_decay: float; 
  (** scaling for reputation increments *)
  mutable rep_scaling: float; 
  (** a function which returns a value based on how mature the page is. *)
  mutable dynamic_rep_scaling: int -> int -> float;
  (** maximum reputation *)
  mutable max_rep: float;
  (** Whether to equate anonymous users, regardless of their IP. *)
  mutable equate_anons: bool; 
  (** Interval of time for nixing *)
  mutable nix_interval: float; 
  (** Negative quality below which nixing happens *)
  mutable nix_threshold: float;
  (** The high-median of the reputations is used for the white value. 
   We choose it so that 90% of work is done below that value. *)
  mutable hi_median_perc: float;
  (** This is a similar median, but is used to renormalize the weights of 
      authors during the initial phase of a wiki *)
  mutable hi_median_perc_boost: float;
};;

(* Number of past revisions to consider *)
let n_past_revs = 6;;

(* We compute the reputation scaling dynamically taking care of the size of the recent_revision list and 
   the union of the recent revision list, hig reputation list and high trust list *)
let default_dynamic_rep_scaling n_recent_revs max_n_recent_revs = 
  let n_revs_judged = min (n_recent_revs - 2) (max_n_recent_revs / 2) in 
  1. /. (float_of_int n_revs_judged)

let default_trust_coeff = {
  n_revs_to_consider = n_past_revs;
  len_hi_trust_revs = 2;
  len_hi_rep_revs = 2;
  hi_rep_list_threshold = 6.0;
  max_del_time_chunk = 90. *. 24. *. 3600.; (* 3 months *)
  max_del_revs_chunk = 100;
  max_dead_chunk_len = 10000;
  lends_rep = 0.4;
  read_all = 0.2;
  read_part = 0.2;
  kill_decrease = (log 2.0) /. 9.0;
  cut_rep_radius = 4.0;
  local_decay = 0.5 ** (1. /. 10.); 
  (* The reputation scaling is 73.24 when we use n_revs_to_consider = 12, 
     and varies quadratically with n_revs_to_consider - 1. *)
  rep_scaling = 1. /. (73.24 *. ( ((float_of_int n_past_revs) -. 1.) /. 11.) ** 2.);
  dynamic_rep_scaling = default_dynamic_rep_scaling;
  max_rep = 22026.465795 -. 2.0;
  equate_anons = false;
  nix_interval = 24. *. 3600.;
  nix_threshold = 0.1;
  hi_median_perc = 0.9;
  hi_median_perc_boost = 0.7;
};;
 
let get_default_coeff : trust_coeff_t = default_trust_coeff ;;

(** This is the quality information we store with revisions *)
type qual_info_t = {
  (** Number of times the revision has been judged *)
  mutable n_edit_judges: int; 
  (** Total edit quality: the average is given by dividing by n_edit_judges *)
  mutable total_edit_quality: float;
  (** Minimum edit quality of all judgements *)
  mutable min_edit_quality: float; 
  (** Nix bit (see the techrep) *)
  mutable nix_bit: bool;
  (** Delta, or the amount of change done *)
  mutable delta: float;
  (** Total reputation accrued due to the revision *)
  mutable reputation_gain: float;
  (** Overall trust of a revision *)
  mutable overall_trust: float;
} with sexp

let quality_info_default = {
  n_edit_judges = 0;
  total_edit_quality = 0.;
  min_edit_quality = 1000.;
  nix_bit = false;
  delta = 0.0;
  reputation_gain = 0.0;
  overall_trust = 0.0
}

(** This is the type of an edit list, annotated *)
type edit_list_t = {
  (** version of text analysis algo *)
  split_version : string; 
  (** to which version *)
  to_version : int; 
  (** the edit list proper *)
  editlist : Editlist.edit list 
} with sexp

type edit_lists_of_rev_t = edit_list_t list with sexp

(** This is the information associated with a page *)
type page_info_t = { 
  (** List of revision ids by hi rep authors *)
  mutable past_hi_rep_revs : int list;
  (** List of revision ids with high trust *)
  mutable past_hi_trust_revs : int list; 
} with sexp 

let page_info_default = { 
  past_hi_rep_revs = [];
  past_hi_trust_revs = [];
}

(* Timestamp in the DB *)
type timestamp_t = int * int * int * int * int * int;;

(* Types for talking with Wikipedia *)
type wiki_page = {
  page_id : int;
  page_namespace : int;
  page_title : string; 
  page_restrictions : string;
  page_counter : int;
  page_is_redirect : bool;
  page_is_new : bool;
  page_random : float;
  page_touched : string; 
  page_latest : int;
  page_len : int
}

type wiki_revision = {
  revision_id : int;
  mutable revision_page : int;
  revision_text_id : int;
  revision_comment : string;
  mutable revision_user : int;
  revision_user_text : string;
  revision_timestamp : string;
  revision_minor_edit : bool;
  revision_deleted : bool;
  revision_len : int;
  revision_parent_id : int;
  revision_content : string;
}
