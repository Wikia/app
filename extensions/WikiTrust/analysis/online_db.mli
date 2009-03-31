(*

Copyright (c) 2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, Ian Pye 

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

(** This class provides a handle for accessing the database in the on-line 
    implementation. *)

open Online_types;;

(** All the methods uniformly return DB_Not_Found when some desired information cannot 
    be read from the database. *)
exception DB_Not_Found;;

(* Raised when a commit fails. *)
exception DB_TXN_Bad;;

(* Which DB should be used for the next transaction? *)
type current_db_t = MediaWiki | WikiTrust | Both;;

(* Represents the revision table in memory *)
type revision_t = {
  rev_id: int; 
  rev_page: int; 
  rev_text_id: int; 
  rev_timestamp: string; 
  rev_user: int; 
  rev_user_text: string;
  rev_is_minor: bool; 
  rev_comment: string
} 

(* Represents a signature *)
type sig_t = {
  words_a: string array;
  trust_a: float array;
  origin_a: int array;
  author_a: string array;
  sig_a: Author_sig.packed_author_signature_t array;
} with sexp

(* This is the type of a vote data *)
type vote_t = {
  vote_time: string;
  vote_page_id: int; 
  vote_revision_id: int;
  vote_voter_id: int;
}

class db : 
  string ->
  Mysql.db ->
  Mysql.db option ->
  bool ->

  object

    (* ================================================================ *)
    (* Disconnect *)
    method close : unit 

    (* ================================================================ *)
    (* Locks. *)

    (** [get_page_lock page_id timeout] gets a lock for page [page_id], to guarantee 
	mutual exclusion on the updates for page [page_id].  The lock is waited for at 
	most time [timeout] seconds.  The function returns [true] if the lock was acquired. *)
    method get_page_lock : int -> int -> bool

    (** [is_page_lock_free page_id] checks whether the lock for page [page_id] is available
	(there is no guarantee that somebody does not lock the page between this test and a 
	subsequent call to [get_page_lock]. *)
    method is_page_lock_free : int -> bool

    (** [release_page_lock page_id] releases the lock for page [page_id], to guarantee 
	mutual exclusion on the updates for page [page_id]. *)
    method release_page_lock : int -> unit

    (** Start a transaction *)
    method start_transaction : current_db_t -> unit

    (** Rollback a transaction *)
    method rollback_transaction : current_db_t -> unit 

    (** Commit of transaction *)
    method commit : current_db_t -> unit

    (* ================================================================ *)
    (* Global methods. *)

    (** [get_histogram] Returns a histogram showing the number of users 
	at each reputation level *)
    method get_histogram : float array * float
    
    (** write_histogram delta_hist median] increments the db histogram of user reputations according
	to the array [delta_hist], and writes that the new median is [median]. *)
    method write_histogram : float array -> float -> unit 

    (** [fetch_last_colored_rev_time_string] returns the timestamp and the 
	revision id of the most recent revision that has been colored. 
        Raises DB_Not_Found if no revisions have been colored. *)    
    method fetch_last_colored_rev_time : timestamp_t * int
    
    (** [sth_select_all_revs_after (int * int * int * int * int * int) rev_id limit] returns all 
        revs created after the given timestamp, or at the same timestamp, with revision id at least [rev_id],
	up to the maximum number [limit]. *)
    method fetch_all_revs_after : timestamp_t -> int -> int -> revision_t list

    (** [sth_select_all_revs_including_after rev_id_incl (int * int * int * int * int * int) rev_id limit] returns all 
        revs created after the given ([timestamp],[rev_id]), or that have revision id [rev_id_incl],
	up to the maximum number [limit]. *)
    method fetch_all_revs_including_after : int -> timestamp_t ->  int -> int -> revision_t list

    (** [fetch_all_revs lim] Returns a pointer to a result set consisting in all the 
	revisions of the database, in ascending temporal order,  with a limit of [lim] revisions. *)
    method fetch_all_revs : int -> revision_t list

    (** [fetch_unprocessed_votes n_events] returns at most [n_events] unprocessed votes, starting from the oldest unprocessed vote. *)
    method fetch_unprocessed_votes : int -> vote_t list

    (** [mark_vote_as_processed (revision_id: int) (voter_id : int)] marks a vote as processed. *)
    method mark_vote_as_processed : int -> int -> unit

    (* ================================================================ *)
    (* Page methods.  We assume we have a lock on the page when calling
       these methods. *)

    (** [write_page_chunks_info page_id chunk_list p_info] writes in the wikitrust_page
	table that the page with id [page_id] is associated 
	with the "dead" strings of text [chunk1], [chunk2], ..., where
	[chunk_list = [chunk1, chunk2, ...] ], and with the page info [p_info]. 
	The chunk_list contains text that used to be present in the article, but has 
	been deleted; the database records its existence. *)
    method write_page_chunks_info : int -> Online_types.chunk_t list -> Online_types.page_info_t -> unit

    (** [write_page_info page_id chunk_list p_info] updates the wikitrust_page table
	to record that the page with id [page_id] is associated 
	with the page info [p_info]. *) 
    method write_page_info : int -> Online_types.page_info_t -> unit

    (** [read_page_info page_id] returns the list of dead chunks associated
	with the page [page_id], along with the page info. *)
    method read_page_info : int -> (Online_types.chunk_t list) * Online_types.page_info_t

    (** [fetch_revs page_id timestamp rev_id fetch_limit] returns a cursor that points to at most [fetch_limit]
	revisions of page [page_id] with time prior or equal to [timestamp], and revision id at most [rev_id]. *)
    method fetch_revs : int -> timestamp_t -> int -> int -> Mysql.result
 
    (** [get_latest_rev_id page_id] returns the revision id of the most 
	recent revision of page [page_id]. *)
    method get_latest_rev_id : int -> int

    (** [get_latest_colored_rev_id page_id] returns the timestamp of the most 
     recent revision of page [page_id]. *)
    method get_latest_colored_rev_timestamp : int -> string

    (** [get_latest_colored_rev_id page title] returns the timestamp of 
	the most recent revision of page [page-title]. *)
    method get_latest_colored_rev_timestamp_by_title : string -> string

    (* ================================================================ *)
    (* Revision methods.  We assume we have a lock on the page to which 
       the revision belongs when calling these methods. *)

    (** [revision_needs_coloring rev_id] checks whether a revision has already been 
	colored for trust. *)
    method revision_needs_coloring : int -> bool

    (** [read_revision rev_id] reads a revision by id, returning the row *)
    method read_revision : int -> string option array option 

    (** [read_wikitrust_revision rev_id] reads a revision from the 
	wikitrust_revision table. *)
    method read_wikitrust_revision : int -> (revision_t * qual_info_t)

    (** [write_revision_info rev_id quality_info elist] writes the wikitrust data 
	associated with revision with id [rev_id] *)
    method write_wikitrust_revision : revision_t -> qual_info_t -> unit

    (** [read_revision_quality rev_id] reads the wikitrust quality information of revision_id *)
    method read_revision_quality : int -> qual_info_t

    (** [fetch_rev_timestamp rev_id] returns the timestamp of revision [rev_id] *)
    method fetch_rev_timestamp : int -> timestamp_t

    (** [get_rev_text text_id] returns the text associated with text id [text_id] *)
    method read_rev_text : int -> string 

    (** [write_colored_markup rev_id markup timestamp] writes, in a table with columns by 
	(revision id, string), that the string [markup] is associated with the 
	revision with id [rev_id]. 
	The [markup] represents the main text of the revision, annotated with trust 
	and origin information; it is what the "colored revisions" of our 
	batch demo are. 
	When visitors want the "colored" version of a wiki page, it is this chunk 
	they want to see.  Therefore, it is very important that this chunk is 
	easy and efficient to read.  A filesystem implementation, for very large wikis, 
	may be used.
	[timestamp] is the timestamp of the reputation information with respect to which the 
	coloring has been computed. 
     *)
    method write_colored_markup : int -> string -> timestamp_t -> unit 

    (** [read_colored_markup rev_id] reads the text markup of a revision with id
	[rev_id].  The markup is the text of the revision, annontated with trust
	and origin information. *)
    method read_colored_markup : int -> string

    (** Same as above but returns the median info as well. *)
    method read_colored_markup_with_median : int -> string * float

    (** [write_trust_origin_sigs rev_id words trust origin sigs] writes that the 
	revision [rev_id] is associated with [words], [trust], [origin], and [sigs]. *)
    method write_words_trust_origin_sigs : 
      int -> 
      string array -> 
      float array -> 
      int array -> 
      string array ->
      Author_sig.packed_author_signature_t array -> unit 

      (** [read_words_trust_origin_sigs rev_id] reads the words, trust, 
	  origin, and author sigs for the revision [rev_id] from the [wikitrust_sigs] table. *)
    method read_words_trust_origin_sigs : 
      int -> 
      (string array * float array * int array * string array * Author_sig.packed_author_signature_t array)

    (** [delete_author_sigs rev_id] removes from the db the author signatures for [rev_id]. *)
    method delete_author_sigs : int -> unit

    (* ================================================================ *)
    (* User methods. *)

    (** [inc_rep uid delta] increments the reputation of user [uid] by [delta] in
	a single operation, so to avoid database problems. *)
    method inc_rep : int -> float -> unit

    (** [get_rep uid] gets the reputation of user [uid], from a table 
	relating user ids to their reputation *)
    method get_rep : int -> float

    (** [get_user_id name] gets the user id for the user with the given user name *)
    method get_user_id : string -> int

    (* ================================================================ *)
    (* Debugging. *)

    (** Totally clear out the db structure -- THIS IS INTENDED ONLY FOR UNIT
    TESTING *)
    method delete_all : bool -> unit

    (** Add the vote to the db *)
    method vote : vote_t -> unit

    (* ================================================================ *)
    (* Server System. *)

    (** Note that the requested rev was needs to be colored *)
    method mark_to_color : int -> int -> string -> string -> int -> unit

    (** Get the next revs to color *)
    method fetch_next_to_color : int -> (int * int * string * string * int) list

    (** Add the page to the db *)
    method write_page : wiki_page -> unit

    (** Add the rev to the db *)
    method write_revision : wiki_revision -> unit

  end
