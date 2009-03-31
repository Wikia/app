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

open Online_types;;
open Mysql;;
open Eval_defs;;

type word = string;;
exception ReadTextError


(** This is the revision object used for the on-line author reputation and text trust evaluation *)
class revision 
  (db: Online_db.db)
  (rev_id: int) (* revision id *)
  (page_id: int) (* page id *)
  (text_id: int) (* text id, we need it to save a db access later on *)
  (time_string: string) (* time, as a string yyyymmddhhmmss *)
  (user_id: int) (* user id *)
  (username: string) (* name of the user *)
  (is_minor: bool) 
  (comment: string)
  =
  let time      = Timeconv.time_string_to_float time_string in 
  let timestamp = Timeconv.time_string_to_timestamp time_string in 
  let is_anon : bool = (user_id = 0) in 

  object (self : 'a)
      (* These have to do with the revision text.  There is nothing in this, 
         since we do not necessarily read the text of all the revisions we 
         may want to keep track: reading the text is expensive. *)
    val mutable words : word array = [| |]
    val mutable seps  : Text.sep_t array = [| |] 
    val mutable sep_word_idx : int array = [| |] 
    val mutable sigs : Author_sig.packed_author_signature_t array = [| |]
    val mutable trust : float array = [| |]
    val mutable origin : int array = [| |]
    val mutable author : string array = [| |]
    (* These quantities keep track of the quality of a revision *)
    (* First, I have a flag that says whether I have read the quantities 
       or not.  They are not read by default; they reside in a 
       separate table from standard revision data. *)
    (* NOTE: Every revision needs ITS OWN copy of the quality info, so I cannot
       just do quality_info = quality_info_default, or they would all share the
       same copy. *)
    val mutable quality_info : qual_info_t = {
      n_edit_judges = quality_info_default.n_edit_judges;
      total_edit_quality = quality_info_default.total_edit_quality;
      min_edit_quality = quality_info_default.min_edit_quality;
      nix_bit = quality_info_default.nix_bit;
      delta = quality_info_default.delta;
      reputation_gain = quality_info_default.reputation_gain;
      overall_trust = quality_info_default.overall_trust;
    }
    val mutable quality_info_valid = false
    (* Dirty bit to avoid writing back unchanged stuff *)
    val mutable modified_quality_info : bool = false

    (* Sets the quality info *)
    method set_quality_info (q: qual_info_t) = 
      quality_info <- q;
      quality_info_valid <- true;
      modified_quality_info <- false

    (* Basic access methods *)
    method get_id : int = rev_id
    method get_ip : string = if user_id = 0 then username else ""
    method get_time : float = time
    method get_page_id : int = page_id
    method get_user_id : int = user_id
    method get_user_name : string = username 
    method get_is_anon : bool = is_anon
    method get_time_string : string = time_string
    method get_timestamp : timestamp_t = timestamp

      (* Reads the revision text from the db, and splits it appropriately *)
    method read_text : unit = 
      try 
	(* We have to use Textbuf here to split text into smaller chunks, 
	   since otherwise Text chokes on it *)
	let buf = Textbuf.add (db#read_rev_text text_id) Textbuf.empty in 
        let (w, t, o, a, s_idx, s) = Text.split_into_words_seps_and_info false (Textbuf.get buf) in 
        words <- w; 
        seps <- s; 
        sep_word_idx <- s_idx;
      with Online_db.DB_Not_Found -> ()

    (** Reads the text, trust and sigs of text from the db *)
    method read_words_trust_origin_sigs : unit = 
      (* For the older revisions, we don't need the seps. 
	 So, we read the words, trust, etc, from the sigs table, if we can. 
	 This has two advantages.  First, less parsing is needed, so it's faster. 
	 Second, the information is consistent. 
	 If this is not found, then we parse the colored text. *)
      try begin 
	let (w, t, o, a, s) = db#read_words_trust_origin_sigs rev_id in 
	words <- w; 
	trust <- t; 
	origin <- o; 
	author <- a;
	sigs <- s
      end with Online_db.DB_Not_Found -> begin 
	(* Not found: we parse the colored text.  If this is also not found, 
	   we let the error pop up, so that the caller knows that the revision 
	   needs to be colored. *)
	(* We have to use Textbuf here to split text into smaller chunks, 
	   since otherwise Text chokes on it *)
	let buf = Textbuf.add (db#read_colored_markup rev_id) Textbuf.empty in 
        let (w, t, o, a, s_idx, s) = Text.split_into_words_seps_and_info false (Textbuf.get buf) in 
	words <- w; 
	trust <- t; 
	origin <- o; 
	author <- a;
	sigs <- [| |];
	seps <- s; 
	sep_word_idx <- s_idx;
	Printf.printf "Warning: pre-parsed text of revision %d not found, reconstructed.\n" rev_id
      end; 
      (* Checks that the text and trust, sigs information have the same length *)
      let sigs_len = Array.length sigs in 
      let trust_len = Array.length trust in 
      let origin_len = Array.length origin in 
      let author_len = Array.length author in 
      let text_len = Array.length words in 
      if sigs_len <> text_len then begin
	sigs <- Array.create text_len Author_sig.empty_sigs;
	Printf.printf "Warning: reconstructed sigs for revision %d\n" rev_id;
      end;
      if trust_len <> text_len then begin
	trust <- Array.create text_len 0.;
	Printf.printf "Warning: reconstructed trust for revision %d\n" rev_id;
      end;
      if origin_len <> text_len then begin
	origin <- Array.create text_len 0;
	Printf.printf "Warning: reconstructed origin for revision %d\n" rev_id;
      end;
      if author_len <> text_len then begin
	author <- Array.create text_len "";
	Printf.printf "Warning: reconstructed authors for revision %d\n" rev_id;
      end


    (** Writes the trust, origin, and sigs to the db *)
    method write_words_trust_origin_sigs : unit = 
      db#write_words_trust_origin_sigs rev_id words trust origin author sigs

    method get_words : word array = words
    method get_seps : Text.sep_t array = seps
    method get_sep_word_idx : int array = sep_word_idx
    method get_trust : float array = trust
    method set_trust (t: float array) = trust <- t
    method get_origin : int array = origin
    method set_origin (o: int array) = origin <- o 
    method get_author : string array = author
    method set_author (a: string array) = author <- a 
    method get_sigs : Author_sig.packed_author_signature_t array = sigs
    method set_sigs (s: Author_sig.packed_author_signature_t array) = sigs <- s

    (** Reads the quality info if required. *)
    method private read_quality_info : unit = 
      if not quality_info_valid then begin 
	(* We read it at most once, even in case of failure: 
	   otherwise, if we fail, we keep trying to read it. *)
	quality_info_valid <- true;
	try 
          quality_info <- db#read_revision_quality rev_id;
	  modified_quality_info <- false; 
	with Online_db.DB_Not_Found -> ()
      end

    (** Adds edit quality information *)
    method add_edit_quality_info (delta: float) (new_q: float) (rep_gain: float) : unit = 
      self#read_quality_info; 
      (* updated *)
      quality_info.delta <- delta;
      quality_info.total_edit_quality <- quality_info.total_edit_quality +. new_q; 
      if new_q < quality_info.min_edit_quality then quality_info.min_edit_quality <- new_q; 
      quality_info.n_edit_judges <- quality_info.n_edit_judges + 1; 
      quality_info.reputation_gain <- quality_info.reputation_gain +. rep_gain;
      (* flags the change *)
      modified_quality_info <- true

    method set_overall_trust (t: float) : unit = 
      self#read_quality_info; 
      quality_info.overall_trust <- t;
      modified_quality_info <- true

    method get_overall_trust : float = 
      self#read_quality_info; 
      quality_info.overall_trust

    method get_nix : bool = 
      self#read_quality_info; 
      quality_info.nix_bit

    method set_nix_bit : unit = 
      self#read_quality_info; 
      quality_info.nix_bit <- true;
      modified_quality_info <- true 

    (** [write_quality_to_db n_attempts] writes all revision quality information to the db. *)
    method write_quality_to_db : unit = 
      self#read_quality_info; 
      if modified_quality_info then 
	db#write_wikitrust_revision {
	  Online_db.rev_id = rev_id; 
	  Online_db.rev_page = page_id; 
	  Online_db.rev_text_id = text_id; 
	  Online_db.rev_timestamp = time_string; 
	  Online_db.rev_user = user_id; 
	  Online_db.rev_user_text = username;
	  Online_db.rev_is_minor = is_minor;
	  Online_db.rev_comment = comment
	} quality_info
	  
  end (* revision class *)

(** Makes a revision from a revision_t record *)
let make_revision (rev : Online_db.revision_t) db: revision = 
  new revision db 
    rev.Online_db.rev_id
    rev.Online_db.rev_page
    rev.Online_db.rev_text_id
    rev.Online_db.rev_timestamp
    rev.Online_db.rev_user
    rev.Online_db.rev_user_text
    rev.Online_db.rev_is_minor
    rev.Online_db.rev_comment

(** Makes a revision from a database row *)
let make_revision_from_cursor row db: revision = 
  let set_is_minor ism = match ism with
    | 0 -> false
    | 1 -> true
    | _ -> assert false in
  new revision db 
    (not_null int2ml row.(0)) (* rev id *)
    (not_null int2ml row.(1)) (* page id *)        
    (not_null int2ml row.(2)) (* text id *)
    (not_null str2ml row.(3)) (* timestamp *)
    (not_null int2ml row.(4)) (* user id *)
    (not_null str2ml row.(5)) (* user name *)
    (set_is_minor (not_null int2ml row.(6))) (* is_minor *)
    (not_null str2ml row.(7)) (* comment *)

(** Reads a revision from the main database given its revision id *)
let read_revision (db: Online_db.db) (id: int) : revision option = 
  let set_is_minor ism = match ism with
    | 0 -> false
    | 1 -> true
    | _ -> assert false in
  begin 
    match db#read_revision id with 
      None -> None 
    | Some row -> 
	Some (new revision db 
	  (not_null int2ml row.(0)) (* rev id *)
	  (not_null int2ml row.(1)) (* page id *)        
	  (not_null int2ml row.(2)) (* text id *)
	  (not_null str2ml row.(3)) (* timestamp *)
	  (not_null int2ml row.(4)) (* user id *)
	  (not_null str2ml row.(5)) (* user name *)
	  (set_is_minor (not_null int2ml row.(6))) (* is_minor *)
	  (not_null str2ml row.(7)) (* comment *)
	)
  end

(** Reads a revision from the wikitrust_revision table given its 
    revision id.  This reads also the quality data. *)
let read_wikitrust_revision (db: Online_db.db) (id: int) : revision = 
  begin 
    let (r_data, q_data) = db#read_wikitrust_revision id in 
    let rev = new revision db 
      id
      r_data.Online_db.rev_page
      r_data.Online_db.rev_text_id
      r_data.Online_db.rev_timestamp
      r_data.Online_db.rev_user
      r_data.Online_db.rev_user_text
      r_data.Online_db.rev_is_minor
      r_data.Online_db.rev_comment
    in 
    rev#set_quality_info q_data; 
    rev
  end
