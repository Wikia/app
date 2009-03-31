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


(** This is the type of a page, or a Wikipedia article. *)
class page :
  object
    (** [add_revision revision_id page_id timestamp time contributor user_id username is_minor comment text
] 
        creates a revision with the above indicated fields, and adds it as the last revision of the page. 
        Output may be produced by this function, as some methods evaluate revisions before they have
        all been read. *)
    method add_revision :
      int -> (* revision_id *)
      int -> (* page_id *)
      string -> (* timestamp *)
      float -> (* time *)
      string -> (* contributor *)
      int -> (* user_id *)
      string -> (* ip_addr *)
      string -> (* username *)
      bool -> (* is_minor *)
      string -> (* comment *)
      string Vec.t -> (* text *)
      unit
    (** [eval] evaluates the page.  It must be called once and once only, once all revisions
        have been read. *)
    method eval : unit
    (** [print_id_title] prints the page id and title. *)
    method print_id_title : unit
  end

(** This class produces pages that perform the intended evaluation
    of a Wikipedia dump.  There are many types of evaluation, 
    and this factory takes care to create the pages that perform
    an approprite evaluation. *)

class page_factory :
  object
    (** Returns an argument parser to process the input *)
    method get_arg_parser : (string * Arg.spec * string) list
      (** This is the factory method for pages in the main name space *)
    method make_page : int -> string -> page
      (** This is the factory method for pages in the alternate name space *)
    method make_colon_page : int -> string -> page

      (** The rest of these methods are not interesting to a user; 
	  look at the command line options rather. *)
      (** Linear analysis.  Deprecated.  Kept only for regression tests. *)
    method set_linear : unit -> unit
      (** Circular buffer analysis.  Deprecated. Kept only for regression tests. *)

      (** Do variouse analysis  *)
    method set_word_freq : unit -> unit
    method set_author_text : unit -> unit

    method set_circular : unit -> unit
      (** Reputation analysis of a page.  The two parameters indicate whether we have to be precise
	  (not use edit list zipping), and whether we have to evaluate the error incurred while 
	  zipping. *)
    method set_reputation : unit -> unit
      (** Counts how many revisions each page has. *)
    method set_revcount : unit -> unit
      (** Analysis of how much text was contributed by authors in each reputation range. 
	  The parameter contains the histories of author reputations. *)
    method set_contribution : unit -> unit
      (** Makes a histogram of the inter-arrival time of edits on a page *)
    method set_intertime : unit -> unit
      (** Coloring of text according to trust. 
	  The parameter contains the histories of author reputations. *)
    method set_trust_color : unit -> unit
    method set_trust_local_color : unit -> unit
    method set_trust_and_origin : unit -> unit
    method set_prune : unit -> unit 
    method set_revs_to_text : unit -> unit 

    method print_mode : unit 

    method set_be_precise : unit -> unit
    method set_eval_zip_error : unit -> unit
    method set_rep_histories : string -> unit
    method set_trust_coeff_cut_rep_radius : float -> unit
    method set_trust_coeff_kill_decrease : float -> unit
    method set_trust_coeff_lends_rep : float -> unit
    method set_trust_coeff_read_all : float -> unit
    method set_trust_coeff_read_part : float -> unit
    method set_trust_coeff_part_radius : float -> unit
    method set_bad_value : float -> unit
    method set_n_edit_judging : int -> unit
    method set_n_rev_to_output : int -> unit
    method set_n_text_judging : int -> unit
    method output_preamble : string -> unit
    method open_out_files : string -> string Vec.t
    method set_single_file : out_channel -> unit
    method close_out_files : unit
    method set_keep_rev_after : string -> unit
    method set_base_name : string -> unit
  end

