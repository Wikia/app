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

(**
   Ian : Analysis for the poster:
   1) Top k users by text contribution
   2) Word usage histiogram
*)


(** page_factory.ml.  The wiki dumps are analyzed by a class of type page. 
    Page is a virtual class; the various classes that implement it provide
    the functionality, for instance, to compute the statistics for author
    reputation, or to compute text trust.  Objects of type page are produced
    by page_factory; see at the end of the file. 
    Each page, to do its work, uses objects of one of the sub-classes of revision
    in order to store revisions; there are many subclasses, as what we need to store
    for each revision is not always the same. *)


type word = string 

(** type of analysis that is requested *)
type analysis_t = 
    Linear_analysis
  | Circular_analysis
  | Reputation_analysis
  | Contribution_analysis
  | Trust_color
  | Trust_syntactregion_color
  | Trust_and_origin
  | Revcount_analysis 
  | Intertime_analysis
  | Do_nothing
  | Prune_revisions
  | Revisions_to_text
  | AuthorText
  | WordFequency

(** This is the class that stores a page, i.e., an article, and
    contains the methods to work on it.  This is the simplest implementation,
    that does nothing at all.  We can then extend this implemenation 
    to do various things to articles (evaluate reputation,
    evaluate text trust, ...) *)
class page = object
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
    : unit = ()
  method eval : unit = ()
  method print_id_title : unit = ()
end (* page class *)
  

class page_factory 
  = 
  object (self)
    (* Mode for analysis *)
    val mutable mode : analysis_t = Do_nothing
      (* Evaluates the error incurred by zipping edit lists rather than
	 evaluating precise diffs. *)
    val mutable eval_zip_error = false 
      (* Does not use edit-list zipping, but rather, is precise with its 
	 evaluation. *)
    val mutable be_precise = false
      (* These store the reputation histories of the users of the Wikipedia. *)
    val mutable rep_histories = new Rephist.rephist
      (* This hash table associates with each revision its edit longevity, which
	 provides a measure of its quality. *)
    val mutable revision_quality : (int, float) Hashtbl.t = Hashtbl.create 100
      (* Revisions with a quality below this value are considered "bad" from a 
	 statistical viewpoint. *)
    val mutable bad_rev_threshold = -0.7 
      (* This coefficient says how much an author can lend reputation to text he/she
	 creates.  For example, if the coefficient is 0.5, then an author of reputation 
	 9 can create text of trust 4.5.  The purpose of this coefficient is to ensure 
	 that even a high-reputation author needs some validation for his/her 
	 contributions. *)
    val mutable trust_coeff_lends_rep = 0.3 
      (* Coefficient by which the whole text of a page grows in trust after revision
	 by a high-reputation editor.  This is one of the most important parameters. *)
    val mutable trust_coeff_read_all = 0.25
      (* Coefficient by which the text of an edited section of a page
	 (a paragraph unit, a bullet point) grows in trust after revision
	 by a high-reputation editor.  This is one of the most important parameters. *)
    val mutable trust_coeff_read_part = 0.5 
      (* Distance, in number of words, for which the local effect of trust 
	 extends outside of a syntactic unit to the adjacent ones. *)
    val mutable trust_coeff_part_radius = 10.0 
      (* Distance, measured in number of words, that is the decay distance
	 for the edge effect in text trust. *)
    val mutable trust_coeff_cut_rep_radius = 1.0
      (* Factor used to scale down reputation of killed text. 
	 With this choice, text killed by a rep=9 user has its 
	 trust halved. *)
    val mutable trust_coeff_kill_decrease = (log 2.0) /. 9.0
      (* N. of revisions to evaluate for text life *)
    val mutable n_text_judging = 12
      (* N. of revisions to evaluate for edit life *)
    val mutable n_edit_judging = 12 (* This default is the same as n_edit_judging in generate_reputation.ml *)
      (* Number of revisions to color for trust *)
    val mutable n_rev_to_output = 100 
      (* Do we equate all anonymous, regardless of IP? *)
    val equate_anons = ref false
      (* Sequential number of page in the dump *)
    val mutable page_seq_number = 0 
      (* Flag that tells us whether we should trace words *)
    val trace_words = ref false
    (* output colored wikimarkup *)
    val gen_color = ref false
    (* output evaluations *)
    val gen_eval = ref false
  
    (* Count the text given by each author *)
    val count_author_text = ref false

    (* Count the frequency of words *)
    val count_word_frequency = ref false
      
    (* output word origin *)
    val do_origin = ref false
    (* When pruning revisions, keep only revisions after this time *)
    val mutable keep_rev_after = -1000.0
    (* Prefix to use when writing revisions as files *)
    val mutable base_name = "/tmp/"

    (* Files for output *)
    val mutable out_file : out_channel = stderr (* also used for eval_file *)
    val mutable xml_file : out_channel = stderr
    val mutable words_file : out_channel = stderr

    method print_mode = 
      match mode with 
        Linear_analysis -> Printf.fprintf stderr "linear\n"; flush stderr
      | Circular_analysis -> Printf.fprintf stderr "circular\n"; flush stderr
      | Reputation_analysis -> Printf.fprintf stderr "reput\n"; flush stderr
      | Contribution_analysis -> Printf.fprintf stderr "contrib\n"; flush stderr
      | Trust_color -> Printf.fprintf stderr "color\n"; flush stderr
      | Trust_syntactregion_color -> Printf.fprintf stderr "trustsyncolor\n"; flush stderr
      | Trust_and_origin -> Printf.fprintf stderr "trust_and_origin\n"; flush stderr
      | Revcount_analysis -> Printf.fprintf stderr "revcount\n"; flush stderr
      | Intertime_analysis -> Printf.fprintf stderr "intertime\n"; flush stderr
      | Prune_revisions -> Printf.fprintf stderr "prune_revisions\n"; flush stderr
      | Revisions_to_text -> Printf.fprintf stderr "revisions_to_text\n"; flush stderr
      | Do_nothing -> Printf.fprintf stderr "noop\n"; flush stderr
      | AuthorText -> ()
      | WordFequency -> ()

    (* These methods are used to set the appropriate evaluation *)
    method set_linear () = mode <- Linear_analysis
    method set_circular () = mode <- Circular_analysis
    method set_reputation () = mode <- Reputation_analysis
    method set_contribution () = mode <- Contribution_analysis
    method set_trust_color () = mode <- Trust_color
    method set_trust_local_color () = mode <- Trust_syntactregion_color
    method set_revcount () = mode <- Revcount_analysis
    method set_intertime () = mode <- Intertime_analysis
    method set_trust_and_origin () = mode <- Trust_and_origin
    method set_prune () = mode <- Prune_revisions
    method set_revs_to_text () = mode <- Revisions_to_text

    method set_author_text () = mode <- AuthorText
    method set_word_freq () = mode <- WordFequency

    (* This sets various attributes *)
    method set_eval_zip_error () = eval_zip_error <- true
    method set_be_precise () = be_precise <- true
    method set_rep_histories (s : string) = 
      let f = Fileinfo.open_info_in s in 
      rep_histories#read_reps f; 
      Fileinfo.close_info_in f
    method set_trust_coeff_lends_rep (f : float) = trust_coeff_lends_rep <- f
    method set_trust_coeff_read_all (f : float) = trust_coeff_read_all <- f
    method set_trust_coeff_read_part (f : float) = trust_coeff_read_part <- f
    method set_trust_coeff_part_radius (f : float) = trust_coeff_part_radius <- f
    method set_trust_coeff_cut_rep_radius (f : float) = trust_coeff_cut_rep_radius <- f
    method set_trust_coeff_kill_decrease (f : float) = trust_coeff_kill_decrease <- f 
    method set_bad_value (f : float) = bad_rev_threshold <- f
    method set_n_text_judging (n: int) = n_text_judging <- n 
    method set_n_edit_judging (n: int) = n_edit_judging <- n 
    method set_n_rev_to_output (n: int) = n_rev_to_output <- n 
    method set_keep_rev_after (n: string) = keep_rev_after <- Timeconv.convert_time n  
    method set_base_name (n: string) = base_name <- n 

    (* This method gets the argument list part to be used to parse the command line *)      
    method get_arg_parser = 
      [("-linear", Arg.Unit self#set_linear, "Uses the old algorithm that keeps all versions in memory.");

       ("-author-text", Arg.Unit self#set_author_text, "Counts the text each author contributes.");
       ("-word-freq", Arg.Unit self#set_word_freq, "Counts the frequency of each word");

       ("-circular", Arg.Unit self#set_circular, "Uses the on-the-fly algo based on the circular buffer.");
       ("-compute_stats", Arg.Unit self#set_reputation, "Produces the reduced stats files used to compute author reputation."); 
       ("-eval_contrib", Arg.Unit self#set_contribution, "Evaluates the contribution given by users of different reputation."); 
       ("-color_trust", Arg.Unit self#set_trust_color, "Outputs text colored by trust."); 
       ("-color_local_trust", Arg.Unit self#set_trust_local_color, "Colors according to the local trust."); 
       ("-trust_and_origin", Arg.Unit self#set_trust_and_origin, "Colors the text according to trust and adds text origin information."); 
       ("-count_revs", Arg.Unit self#set_revcount, "Counts the number of revisions per page."); 
       ("-intertime", Arg.Unit self#set_intertime, "Produces a histogram of inter-page times, up to 1h."); 
       ("-prune_rev", Arg.Unit self#set_prune, ": Prunes revisions.");
       ("-evalziperror", Arg.Unit self#set_eval_zip_error, "(use with -eval_rep): Evaluates the error involved in using zipped lists.");
       ("-precise", Arg.Unit self#set_be_precise, "(use with -eval_rep): Does pairwise revision comparisons rather than using edit-list zipping.");
       ("-historyfile", Arg.String self#set_rep_histories, "<file>: File containing history of user reputations");
       ("-rep_lends_trust", Arg.Float self#set_trust_coeff_lends_rep, "<float>: how much of an author trust is lent as text reputation."); 
       ("-trust_read_all", Arg.Float self#set_trust_coeff_read_all, "<float>: how much an article's trust can increase due to someone editing anywere in the article."); 
       ("-trust_read_part", Arg.Float self#set_trust_coeff_read_part, "<float>: how much an article's trust can increase due to someone editing in the same syntactic unit (paragraph, itemization point)."); 
       ("-trust_part_radius", Arg.Float self#set_trust_coeff_part_radius, "<float>: how much (n. of words) local trust percolates in adjacent syntactic regions.");
       ("-trust_radius", Arg.Float self#set_trust_coeff_cut_rep_radius, "<float>: trust radius of influence of edits."); 
       ("-kill_decrease", Arg.Float self#set_trust_coeff_kill_decrease, "<float>: trust decrease when text is deleted.");
       ("-bad_qual_thrs", Arg.Float self#set_bad_value, "<float>: edit quality threshold below which a revision is considered bad.");
       ("-n_text_judging", Arg.Int self#set_n_text_judging, "<int>: n. of revisions to consider for text life."); 
       ("-n_edit_judging", Arg.Int self#set_n_edit_judging, "<int>: n. of revisions to consider for edit life."); 
       ("-n_rev_to_output", Arg.Int self#set_n_rev_to_output, "<int>: max n. of revisions to output per page."); 
       ("-equate_anons", Arg.Set equate_anons, "Equates all anonymous editors, regardless of IP address."); 
       ("-trace_words", Arg.Set trace_words, "Samples words at random, and traces their destiny.");
       ("-gen_color", Arg.Set gen_color, "Generate Colored WikiMarkup");
       ("-gen_eval", Arg.Set gen_eval, "Generate Evaluation");
       ("-do_origin", Arg.Set do_origin, "While doing the evaluation of trust, also generates word origin information");
       ("-keep_rev_after", Arg.String self#set_keep_rev_after, "<date>: Keep Revisions after date (date is in Wiki format, e.g., 2006-11-22T14:25:19Z )");
       ("-revisions_to_text", Arg.Unit self#set_revs_to_text, "Writes each revision out as a separate file."); 
       ("-rev_base_name", Arg.String self#set_base_name, "Prefix for writing out each revision as a separate file. Files will be named prefix/000/001/123/456/revision_id.txt ."); 
      ]		   

    (** Makes a page for the primary name space, where analysis must occur. *)
    method make_page (id: int) (title: string) : page = 
      match mode with 
        Linear_analysis -> new Linear_analysis.page id title out_file
	  n_text_judging n_edit_judging !equate_anons
      | Circular_analysis -> new Circbuf_analysis.page id title out_file
 	  n_text_judging n_edit_judging !equate_anons
  
      | AuthorText -> new Author_text_analysis.page id title out_file
 	  !equate_anons
      | WordFequency -> new Word_frequency.page id title out_file
 	  !equate_anons
	

      | Reputation_analysis -> new Reputation_analysis.page id title out_file eval_zip_error be_precise
	  n_text_judging n_edit_judging !equate_anons
      | Contribution_analysis -> new Contribution_analysis.page id title out_file rep_histories
	  !equate_anons
      (* Trust_color does not also do the origin *)
      | Trust_color -> new Trust_analysis.page id title xml_file rep_histories
	  trust_coeff_lends_rep trust_coeff_read_all trust_coeff_cut_rep_radius trust_coeff_kill_decrease
	  n_rev_to_output !equate_anons 
      | Trust_syntactregion_color -> begin
	  if !do_origin 
	  then new Trust_origin_analysis.page id title xml_file rep_histories
	    trust_coeff_lends_rep trust_coeff_read_all trust_coeff_read_part trust_coeff_part_radius 
	    trust_coeff_cut_rep_radius trust_coeff_kill_decrease n_rev_to_output !equate_anons 
	  else new Trust_local_color_analysis.page id title xml_file rep_histories
	    trust_coeff_lends_rep trust_coeff_read_all trust_coeff_read_part trust_coeff_part_radius 
	    trust_coeff_cut_rep_radius trust_coeff_kill_decrease n_rev_to_output !equate_anons
	end
      | Trust_and_origin -> new Trust_origin_analysis.page id title xml_file rep_histories
	  trust_coeff_lends_rep trust_coeff_read_all trust_coeff_read_part trust_coeff_part_radius 
	    trust_coeff_cut_rep_radius trust_coeff_kill_decrease n_rev_to_output !equate_anons 
      | Revcount_analysis -> begin 
	  let n = page_seq_number in 
	  page_seq_number <- n + 1; 
	  new Revcount_analysis.page id title out_file n
	end 
      | Intertime_analysis -> new Intertime_analysis.page id title out_file
      | Prune_revisions -> new Prune_analysis.page id title xml_file n_rev_to_output keep_rev_after false true
      | Revisions_to_text -> new Revs_to_files_analysis.page id title base_name xml_file
      | Do_nothing -> new page

    (** Makes a page for secondary name spaces.  *)
    method make_colon_page (id: int) (title: string) : page = 
      match mode with 
        Linear_analysis 
      | Circular_analysis 
      | Reputation_analysis 
      | Contribution_analysis 
      | Intertime_analysis
      | Do_nothing
      | AuthorText
      | WordFequency
	-> new page

      | Prune_revisions -> new Prune_analysis.page id title xml_file n_rev_to_output keep_rev_after false true 

      | Trust_and_origin 
      | Trust_syntactregion_color 
      | Trust_color -> new Prune_analysis.page id title xml_file n_rev_to_output keep_rev_after true !equate_anons

      | Revcount_analysis -> begin 
	  let n = page_seq_number in 
	  page_seq_number <- n + 1; 
	  new page
	end 

      | Revisions_to_text -> new Revs_to_files_analysis.page id title base_name xml_file


    (* Opens the files, given a basename.  Returns a Vec.t of the names opened. *)
    method open_out_files (base_name: string) : string Vec.t = 
      let default_name = base_name ^ ".out" in 
      let xml_name     = base_name ^ ".xml" in 
      let stats_name   = base_name ^ ".stats" in 
      (* We init this to stderr so we notice if someone writes where he is not supposed to *)
      out_file <- stderr;
      xml_file <- stderr;
      words_file <- stderr;
      (* List of file names to be returned *)
      let names_l = ref Vec.empty in 
      begin 
	match mode with 
	  Linear_analysis | Circular_analysis | Reputation_analysis -> begin 
	    out_file <- Fileinfo.open_info_out stats_name; 
	    names_l := Vec.singleton stats_name
	  end
	| Contribution_analysis | Revcount_analysis | Intertime_analysis -> begin 
	    out_file <- Fileinfo.open_info_out default_name; 
	    names_l := Vec.singleton default_name
	  end
	| Trust_color | Trust_syntactregion_color | Trust_and_origin
	| AuthorText
	| WordFequency
	| Prune_revisions | Revisions_to_text -> begin 
	    xml_file <- Fileinfo.open_info_out xml_name; 
	    names_l := Vec.singleton xml_name
	  end
	| Do_nothing -> ()
      end; 
      !names_l

    (* Uses the same file for all purposes *)
    method set_single_file (f_out: out_channel) : unit = 
      out_file <- f_out; 
      xml_file <- f_out; 
      words_file <- f_out

    (* This method closes the output files *)
    method close_out_files : unit = 
      if out_file <> stderr then begin Fileinfo.close_info_out out_file; out_file <- stderr end;
      if xml_file <> stderr then begin Fileinfo.close_info_out xml_file; xml_file <- stderr end;
      if words_file <> stderr then begin Fileinfo.close_info_out words_file; words_file <- stderr end 

    (* Writes the output preamble if needed *)
    method output_preamble (s : string) : unit = 
      match mode with 
	Trust_color | Trust_syntactregion_color | Prune_revisions | Revisions_to_text 
	  -> output_string xml_file s
      | _ -> ()

  end
