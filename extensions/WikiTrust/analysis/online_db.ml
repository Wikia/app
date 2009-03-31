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


open Online_types
open Mysql
open Sexplib.Conv
open Sexplib.Sexp
open Sexplib
open Printf

TYPE_CONV_PATH "UCSC_WIKI_RESEARCH"

(* Returned whenever something is not found *)
exception DB_Not_Found
(* Internal error *)
exception DB_Internal_Error

(* Commit failed, or other database error that may have to cause a rollback. *)
exception DB_TXN_Bad

(* This is the function that sexplib uses to convert floats *)
Sexplib.Conv.default_string_of_float := (fun n -> sprintf "%.3f" n);;

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

let set_is_minor ism = match ism with
  | 0 -> false
  | 1 -> true
  | _ -> assert false 

(* Given a row, return a new online revision *)
let rev_row2revision_t row =
  {
    rev_id = (not_null int2ml row.(0)); (* rev id *)
    rev_page = (not_null int2ml row.(1)); (* page id *)        
    rev_text_id = (not_null int2ml row.(2)); (* text id *)
    rev_timestamp = (not_null str2ml row.(3)); (* timestamp *)
    rev_user = (not_null int2ml row.(4)); (* user id *)
    rev_user_text = (not_null str2ml row.(5)); (* user name *)
    rev_is_minor = (set_is_minor (not_null int2ml row.(6))); (* is_minor *)
    rev_comment = (not_null str2ml row.(7)); (* comment *)
  } 

(* This is the type of a vote data *)
type vote_t = {
  vote_time: string;
  vote_page_id: int; 
  vote_revision_id: int;
  vote_voter_id: int;
}

let vote_row2vote_t row =
  {
    vote_time = (not_null str2ml row.(0));
    vote_page_id = (not_null int2ml row.(1));
    vote_revision_id = (not_null int2ml row.(2));
    vote_voter_id = (not_null int2ml row.(3));
  }

let next2color_row row =
  ((not_null int2ml row.(0)), 
   (not_null int2ml row.(1)), 
   (not_null str2ml row.(2)),
   (not_null str2ml row.(3)),
   (not_null int2ml row.(4)))
    
(** This class provides a handle for accessing the database in the on-line 
    implementation. *)

class db  
  (db_prefix : string)
  (db_mediawiki : Mysql.db)
  (db_wikitrust_opt : Mysql.db option)
  (debug_mode : bool) =
  
  let mediawiki_dbh = Mysql.connect db_mediawiki in
  let wikitrust_dbh = match db_wikitrust_opt with
    | None -> mediawiki_dbh
    | Some d -> Mysql.connect d in
  let separate_dbs = match db_wikitrust_opt with 
      None -> false
    | Some _ -> true in 
  (* name used for locking *)
  let wikitrust_database = begin 
    match db_wikitrust_opt with 
      None -> begin 
	match db_mediawiki.dbname with 
	  Some x -> x
	| None -> "wikitrust"
      end
    | Some d -> begin 
	match d.dbname with 
	  Some x -> x
	| None -> "wikitrust"
      end
  end in 
    
  object(self)

    method private db_exec dbh s = 
      if debug_mode then begin 
	print_endline s;
	flush stdout
      end;
      try 
	Mysql.exec dbh s
      with Mysql.Error e -> if debug_mode then 
	begin print_endline e; flush stdout end; 
	raise DB_TXN_Bad

    (* ================================================================ *)
    (* Disconnect *)
    method close : unit = 
      Mysql.disconnect mediawiki_dbh;
      if separate_dbs then Mysql.disconnect wikitrust_dbh

    (* ================================================================ *)
    (* Locks and commits. *)

    (** [get_page_lock page_id timeout] gets a lock for page [page_id], to guarantee 
	mutual exclusion on the updates for page [page_id].  The lock is waited for at 
	most time [timeout] seconds.  The function returns [true] if the lock was acquired. *)
    method get_page_lock (page_id: int) (timeout: int) : bool = 
      let lock_name = Printf.sprintf "%s.%swikitrust_page.%d" wikitrust_database db_prefix page_id in 
      let s = Printf.sprintf "SELECT GET_LOCK(%s,%s)" (ml2str lock_name) (ml2int timeout) in 
      match fetch (self#db_exec wikitrust_dbh s) with 
	None -> raise DB_Internal_Error
      | Some row -> ((not_null int2ml row.(0)) = 1)

    (** [is_page_lock_free page_id] checks whether the lock for page [page_id] is available
	(there is no guarantee that somebody does not lock the page between this test and a 
	subsequent call to [get_page_lock]. *)
    method is_page_lock_free (page_id: int) : bool = 
      let lock_name = Printf.sprintf "%s.%swikitrust_page.%d" wikitrust_database db_prefix page_id in 
      let s = Printf.sprintf "SELECT IS_FREE_LOCK(%s)" (ml2str lock_name) in 
      match fetch (self#db_exec wikitrust_dbh s) with 
	None -> raise DB_Internal_Error
      | Some row -> ((not_null int2ml row.(0)) = 1)

    (** [release_page_lock page_id] releases the lock for page [page_id], to guarantee 
	mutual exclusion on the updates for page [page_id]. *)
    method release_page_lock (page_id: int) : unit = 
      let lock_name = Printf.sprintf "%s.%swikitrust_page.%d" wikitrust_database db_prefix page_id in 
      let s = Printf.sprintf "SELECT RELEASE_LOCK(%s)" (ml2str lock_name) in 
      ignore (self#db_exec wikitrust_dbh s)

    (** Start a transaction. *)
    method start_transaction (cdb : current_db_t) : unit =
      match cdb with
	| MediaWiki -> ignore (self#db_exec mediawiki_dbh "START TRANSACTION")
	| WikiTrust -> ignore (self#db_exec wikitrust_dbh "START TRANSACTION")
	| Both -> begin 
	    ignore (self#db_exec mediawiki_dbh "START TRANSACTION");
	    if separate_dbs then ignore (self#db_exec wikitrust_dbh "START TRANSACTION")
	  end

    (** rollback a transaction. *)
    method rollback_transaction (cdb : current_db_t) : unit =
      Printf.printf "ROLLBACK\n";
      begin 
	match cdb with
	| MediaWiki -> ignore (self#db_exec mediawiki_dbh "ROLLBACK")
	| WikiTrust -> ignore (self#db_exec wikitrust_dbh "ROLLBACK")
	| Both -> begin
	    ignore (self#db_exec mediawiki_dbh "ROLLBACK");
	    if separate_dbs then ignore (self#db_exec wikitrust_dbh "ROLLBACK")
	  end
      end
	    
    (* Commits any changes to the db *)
    method commit (cdb : current_db_t) : unit =
      let commit_mw () = begin
	ignore (self#db_exec mediawiki_dbh "COMMIT");
	match Mysql.status mediawiki_dbh with 
	| StatusError err -> raise DB_TXN_Bad
	| _ -> ()
      end in 
      let commit_wt () = begin
	ignore (self#db_exec wikitrust_dbh "COMMIT");
	match Mysql.status wikitrust_dbh with 
	| StatusError err -> raise DB_TXN_Bad
	| _ -> ()
      end in 
      match cdb with
      | MediaWiki -> commit_mw ()
      | WikiTrust -> commit_wt ()
      | Both -> begin
	  commit_mw ();
	  if separate_dbs then commit_wt ()
	end

	    
    (* ================================================================ *)
    (* Global methods. *)
	      
    (** [get_histogram] Returns a histogram showing the number of users 
	at each reputation level, and the median. *)
    method get_histogram : float array * float =
    let s = Printf.sprintf "SELECT * FROM %swikitrust_global" db_prefix in
      match fetch (self#db_exec wikitrust_dbh s) with
        None -> raise DB_Not_Found
      | Some row -> ([| not_null float2ml row.(1); not_null float2ml row.(2); not_null float2ml row.(3); 
	                not_null float2ml row.(4);  not_null float2ml row.(5);
	                not_null float2ml row.(6);  not_null float2ml row.(7);
	                not_null float2ml row.(8);  not_null float2ml row.(9); not_null float2ml row.(10);
	             |], (not_null float2ml row.(0)))
    
    (** write_histogram delta_hist median] increments the db histogram of user reputations according
	to the array [delta_hist], and writes that the new median is [median]. *)
    method write_histogram (delta_hist : float array) (median: float) : unit = 
      let s = Printf.sprintf  "UPDATE %swikitrust_global SET median = %s, rep_0 = rep_0 + %s, rep_1 = rep_1 + %s, rep_2 = rep_2 + %s, rep_3 = rep_3 + %s, rep_4 = rep_4 + %s, rep_5 = rep_5 + %s, rep_6 = rep_6 + %s, rep_7 = rep_7 + %s, rep_8 = rep_8 + %s, rep_9 = rep_9 + %s" 
	db_prefix
	(ml2float median)
	(ml2float delta_hist.(0)) (ml2float delta_hist.(1)) (ml2float delta_hist.(2)) (ml2float delta_hist.(3)) 
	(ml2float delta_hist.(4)) (ml2float delta_hist.(5)) (ml2float delta_hist.(6)) (ml2float delta_hist.(7)) 
	(ml2float delta_hist.(8)) (ml2float delta_hist.(9)) in 
      ignore (self#db_exec wikitrust_dbh s)


    (** [fetch_last_colored_rev_time_string] returns the timestamp and the 
	revision id of the most recent revision that has been colored. 
        Raises DB_Not_Found if no revisions have been colored. *)    
    method fetch_last_colored_rev_time : (timestamp_t * int) = 
    let s = Printf.sprintf "SELECT revision_createdon, revision_id FROM %swikitrust_colored_markup ORDER BY revision_createdon DESC, revision_id DESC LIMIT 1" db_prefix in
      match fetch (self#db_exec wikitrust_dbh s) with
        None -> raise DB_Not_Found
        | Some row -> (not_null timestamp2ml row.(0), not_null int2ml row.(1)) 
	    
  
    (** [sth_select_all_revs_after (int * int * int * int * int * int) rev_id limit] returns all 
        revs created after the given timestamp, or at the same timestamp, with revision id at least [rev_id], 
	up to the maximim number [limit]. *)
    method fetch_all_revs_after (timestamp : timestamp_t) (rev_id: int) (max_revs_to_return: int) : revision_t list =  
      let s = Printf. sprintf "SELECT rev_id, rev_page, rev_text_id, rev_timestamp, rev_user, rev_user_text, rev_minor_edit, rev_comment FROM %srevision WHERE (rev_timestamp, rev_id) > (%s, %s) ORDER BY rev_timestamp ASC, rev_id ASC LIMIT %s" 
	db_prefix
	(ml2timestamp timestamp) (ml2int rev_id) (ml2int max_revs_to_return) in
      	Mysql.map (self#db_exec mediawiki_dbh s) rev_row2revision_t

    (** [sth_select_all_revs_including_after rev_id_incl (int * int * int * int * int * int) rev_id limit] returns all 
        revs created after the given ([timestamp],[rev_id]), or that have revision id [rev_id_incl],
	up to the maximum number [limit]. *)
    method fetch_all_revs_including_after (rev_id_incl: int) (timestamp : timestamp_t) (rev_id: int) (max_revs_to_return: int): revision_t list =  
      (* Note: the >= is very important in the following query, to correctly handle the case
	 of revisions with the same timestamp. *)
      let s = Printf. sprintf "SELECT rev_id, rev_page, rev_text_id, rev_timestamp, rev_user, rev_user_text,rev_minor_edit, rev_comment FROM %srevision WHERE (rev_timestamp, rev_id) >= (%s, %s) OR rev_id = %s ORDER BY rev_timestamp ASC, rev_id ASC LIMIT %s" 
	db_prefix
	(ml2timestamp timestamp) (ml2int rev_id) (ml2int rev_id_incl) (ml2int max_revs_to_return) in
      	Mysql.map (self#db_exec mediawiki_dbh s) rev_row2revision_t

    (** [fetch_all_revs] returns a cursor that points to all revisions in the database, 
	in ascending order of timestamp. *)
    method fetch_all_revs (max_revs_to_return: int) : revision_t list = 
      let s= Printf.sprintf  "SELECT rev_id, rev_page, rev_text_id, rev_timestamp, rev_user, rev_user_text, rev_minor_edit, rev_comment FROM %srevision ORDER BY rev_timestamp ASC, rev_id ASC LIMIT %s" db_prefix (ml2int max_revs_to_return) in
	Mysql.map (self#db_exec mediawiki_dbh s) rev_row2revision_t
	    
    (** [fetch_unprocessed_votes n_events] returns at most [n_events] unprocessed votes, 
	starting from the oldest unprocessed vote. *)
    method fetch_unprocessed_votes (n_events: int) : vote_t list = 
      let s= Printf.sprintf  "SELECT voted_on, page_id, revision_id, voter_id FROM %swikitrust_vote WHERE NOT processed ORDER BY voted_on ASC LIMIT %s" db_prefix (ml2int n_events) in
	Mysql.map (self#db_exec wikitrust_dbh s) vote_row2vote_t

    (** [mark_vote_as_processed (revision_id: int) (voter_id : int)] marks a vote as processed. *)
    method mark_vote_as_processed (revision_id: int) (voter_id : int) : unit = 
      let s = Printf.sprintf "UPDATE %swikitrust_vote SET processed = TRUE WHERE revision_id = %s AND voter_id = %s" 
	db_prefix (ml2int revision_id) (ml2int voter_id) in
      ignore (self#db_exec wikitrust_dbh s)


    (* ================================================================ *)
    (* Page methods. *)

    (** [write_page_info page_id chunk_list] writes, in a table indexed by 
	(page id, string list) that the page with id [page_id] is associated 
	with the "dead" strings of text [chunk1], [chunk2], ..., where
	[chunk_list = [chunk1, chunk2, ...] ]. 
	The chunk_list contains text that used to be present in the article, but has 
	been deleted; the database records its existence. *)
    method write_page_chunks_info (page_id : int) (c_list : chunk_t list) (p_info: page_info_t) : unit = 
      let chunks_string = ml2str (string_of__of__sexp_of (sexp_of_list sexp_of_chunk_t) c_list) in 
      let info_string = ml2str (string_of__of__sexp_of sexp_of_page_info_t p_info) in 
      let s = Printf.sprintf "INSERT INTO %swikitrust_page (page_id, deleted_chunks, page_info) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE deleted_chunks = %s, page_info = %s" 
	db_prefix
	(ml2int page_id) chunks_string info_string chunks_string info_string in  
      ignore (self#db_exec wikitrust_dbh s)

    method write_page_info (page_id : int) (p_info: page_info_t) : unit = 
      let info_string = ml2str (string_of__of__sexp_of sexp_of_page_info_t p_info) in 
      let s = Printf.sprintf "UPDATE %swikitrust_page SET page_info = %s WHERE page_id = %s"
	db_prefix info_string (ml2int page_id) in 
      ignore (self#db_exec wikitrust_dbh s)

    (** [read_page_info page_id] returns the list of dead chunks associated
	with the page [page_id]. *)
    method read_page_info (page_id : int) : (chunk_t list) * page_info_t =
      let s = Printf.sprintf "SELECT deleted_chunks, page_info FROM %swikitrust_page WHERE page_id = %s" db_prefix (ml2int page_id ) in
      let result = self#db_exec wikitrust_dbh s in 
      match Mysql.fetch result with 
	None -> raise DB_Not_Found
      | Some x -> (
	  of_string__of__of_sexp (list_of_sexp chunk_t_of_sexp) (not_null str2ml x.(0)), 
	  of_string__of__of_sexp page_info_t_of_sexp (not_null str2ml x.(1)))

    (** [fetch_revs page_id timestamp rev_id fetch_limit] returns a cursor that points to at most [fetch_limit]
	revisions of page [page_id] with time prior or equal to [timestamp], and revision id at most [rev_id]. *)
    method fetch_revs (page_id : int) (timestamp: timestamp_t) (rev_id: int) (fetch_limit: int): Mysql.result =
      let s = Printf.sprintf "SELECT rev_id, rev_page, rev_text_id, rev_timestamp, rev_user, rev_user_text, rev_minor_edit, rev_comment FROM %srevision WHERE rev_page = %s AND (rev_timestamp, rev_id) <= (%s, %s) ORDER BY rev_timestamp DESC, rev_id DESC LIMIT %s" db_prefix (ml2int page_id) (ml2timestamp timestamp) (ml2int rev_id) (ml2int fetch_limit) in 
      self#db_exec mediawiki_dbh s

    (** [get_latest_rev_id page_id] returns the revision id of the most 
	recent revision of page [page_id]. *)
    method get_latest_rev_id (page_id: int) : int = 
      let s = Printf.sprintf "SELECT rev_id FROM %srevision WHERE rev_page = %s ORDER BY rev_timestamp DESC, rev_id DESC LIMIT 1" db_prefix (ml2int page_id) in 
      match fetch (self#db_exec mediawiki_dbh s) with 
	None -> raise DB_Not_Found
      | Some x -> not_null int2ml x.(0)

    (** [get_latest_colored_rev_id page_id] returns the timestamp of the most 
	recent revision of page [page_id]. *)
    method get_latest_colored_rev_timestamp (page_id : int) : string =
      let s = Printf.sprintf "SELECT time_string FROM %swikitrust_revision WHERE page_id = %s ORDER BY time_string DESC, revision_id DESC LIMIT 1" db_prefix (ml2int page_id) in 
	match fetch (self#db_exec mediawiki_dbh s) with 
	    None -> raise DB_Not_Found
	  | Some x -> not_null str2ml x.(0)      

    (** [get_latest_colored_rev_id page title] returns the timestamp of 
	the most recent revision of page [page-title]. *)
    method get_latest_colored_rev_timestamp_by_title (page_title : string) : string =
      let s = Printf.sprintf "SELECT time_string FROM %swikitrust_revision AS A join page AS B on (A.page_id = B.page_id) WHERE B.page_title = %s ORDER BY time_string DESC, revision_id DESC LIMIT 1" db_prefix (ml2str page_title) in 
	match fetch (self#db_exec mediawiki_dbh s) with 
	    None -> raise DB_Not_Found
	  | Some x -> not_null str2ml x.(0)  

    (* ================================================================ *)
    (* Revision methods. *)

    (** [revision_needs_coloring rev_id] checks whether a revision has already been 
	colored for trust. *)
    method revision_needs_coloring (rev_id: int) : bool = 
      let s = Printf.sprintf "SELECT revision_createdon FROM %swikitrust_colored_markup WHERE revision_id = %s" db_prefix (ml2int rev_id) in 
      match fetch (self#db_exec wikitrust_dbh s) with
	None -> true
      | Some _ -> false

    (** [read_revision rev_id] reads a revision by id, returning the row *)
    method read_revision (rev_id: int) : string option array option = 
      let s = Printf.sprintf "SELECT rev_id, rev_page, rev_text_id, rev_timestamp, rev_user, rev_user_text, rev_minor_edit, rev_comment FROM %srevision WHERE rev_id = %s" db_prefix (ml2int rev_id) in
      fetch (self#db_exec mediawiki_dbh s)

    (** [read_wikitrust_revision rev_id] reads a revision from the 
	wikitrust_revision table. *)
    method read_wikitrust_revision (revision_id: int) : (revision_t * qual_info_t) = 
      let s = Printf.sprintf "SELECT revision_id, page_id, text_id, time_string, user_id, username, is_minor, comment, quality_info FROM %swikitrust_revision WHERE revision_id = %s" db_prefix (ml2int revision_id) in 
      let result = self#db_exec wikitrust_dbh s in 
      match fetch result with 
	None -> raise DB_Not_Found
      | Some x -> begin 
	  let r = {
	    rev_id = not_null int2ml x.(0); 
	    rev_page = not_null int2ml x.(1); 
	    rev_text_id = not_null int2ml x.(2); 
	    rev_timestamp = not_null str2ml x.(3); 
	    rev_user = not_null int2ml x.(4); 
	    rev_user_text = not_null str2ml x.(5); 
	    rev_is_minor = set_is_minor (not_null int2ml x.(6)); 
	    rev_comment = not_null str2ml x.(7); 
	  } in 
	  let q = of_string__of__of_sexp qual_info_t_of_sexp (not_null str2ml x.(8)) in 
	  (r, q)
	end

    (** [write_revision_info rev_id quality_info elist] writes the wikitrust data 
	associated with a revision *)
    method write_wikitrust_revision (revision_info: revision_t) (quality_info: qual_info_t) : unit = 
      (* Revision parameters *)
      let rev_id = ml2int revision_info.rev_id in
      let page_id = ml2int revision_info.rev_page in 
      let text_id = ml2int revision_info.rev_text_id in 
      let time_string = ml2str revision_info.rev_timestamp in 
      let user_id = ml2int revision_info.rev_user in 
      let username = ml2str revision_info.rev_user_text in 
      let is_minor = ml2int (if revision_info.rev_is_minor then 1 else 0) in 
      let comment = ml2str revision_info.rev_comment in 
      (* Quality parameters *)
      let q1 = ml2str (string_of__of__sexp_of sexp_of_qual_info_t quality_info) in 
      let q2 = ml2float quality_info.reputation_gain in 
      let q3 = ml2float quality_info.overall_trust in
      (* Db write access *)
      let s2 =  Printf.sprintf "INSERT INTO %swikitrust_revision (revision_id, page_id, text_id, time_string, user_id, username, is_minor, comment, quality_info, reputation_delta, overall_trust) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE quality_info = %s, reputation_delta = %s, overall_trust = %s"
	db_prefix rev_id page_id text_id time_string user_id username is_minor comment q1 q2 q3 q1 q2 q3 in 
      ignore (self#db_exec wikitrust_dbh s2)

    (** [read_revision_info rev_id] reads the wikitrust information of revision_id *)
    method read_revision_quality (rev_id: int) : qual_info_t = 
      let s = Printf.sprintf "SELECT quality_info FROM %swikitrust_revision WHERE revision_id = %s" db_prefix (ml2int rev_id) in 
      let result = self#db_exec wikitrust_dbh s in
      match fetch result with
        None -> raise DB_Not_Found
      | Some x -> of_string__of__of_sexp qual_info_t_of_sexp (not_null str2ml x.(0))

   (** [fetch_rev_timestamp rev_id] returns the timestamp of revision [rev_id] *)
    method fetch_rev_timestamp (rev_id: int) : timestamp_t = 
      let s = Printf.sprintf "SELECT rev_timestamp FROM %srevision WHERE rev_id = %s" db_prefix (ml2int rev_id) in 
      let result = self#db_exec mediawiki_dbh s in 
      match fetch result with 
	None -> raise DB_Not_Found
      | Some row -> not_null timestamp2ml row.(0)

    (** [get_rev_text text_id] returns the text associated with text id [text_id] *)
    method read_rev_text (text_id: int) : string =
      let s = Printf.sprintf "SELECT old_text FROM %stext WHERE old_id = %s" db_prefix (ml2int text_id) in
      let result = self#db_exec mediawiki_dbh s in 
      match Mysql.fetch result with 
        None -> raise DB_Not_Found
      | Some y -> not_null str2ml y.(0)

    (** [write_colored_markup rev_id markup] writes, in a table with columns by 
	(revision id, string), that the string [markup] is associated with the 
	revision with id [rev_id]. 
	The [markup] represents the main text of the revision, annotated with trust 
	and origin information; it is what the "colored revisions" of our 
	batch demo are. 
	When visitors want the "colored" version of a wiki page, it is this chunk 
	they want to see.  Therefore, it is very important that this chunk is 
	easy and efficient to read.  A filesystem implementation, for small wikis, 
	may be highly advisable. *)
    (* This is currently a first cut, which will be hopefully optimized later *)
    method write_colored_markup (rev_id : int) (markup : string) (createdon : timestamp_t) : unit =
      let db_mkup = ml2str markup in 
      let s = Printf.sprintf "INSERT INTO %swikitrust_colored_markup (revision_id, revision_text, revision_createdon) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE revision_text = %s, revision_createdon = %s"
	db_prefix
	(ml2int rev_id) db_mkup (ml2timestamp createdon) db_mkup (ml2timestamp createdon) in 
      ignore (self#db_exec wikitrust_dbh s)


    (** [read_colored_markup rev_id] reads the text markup of a revision with id
	[rev_id].  The markup is the text of the revision, annontated with trust
	and origin information. *)
    method read_colored_markup (rev_id : int) : string =
      let s = Printf.sprintf  "SELECT revision_text FROM %swikitrust_colored_markup WHERE revision_id = %s"  db_prefix (ml2int rev_id) in 
      let result = self#db_exec wikitrust_dbh s in
      match Mysql.fetch result with
        None -> raise DB_Not_Found
      | Some x -> not_null str2ml x.(0)

    (** [read_colored_markup_and_median rev_id] reads the text markup of a revision with id
	[rev_id].  The markup is the text of the revision, annontated with trust
	and origin information. This method also returns the median value *)
    method read_colored_markup_with_median (rev_id : int) : string * float =
      let s = Printf.sprintf  "SELECT revision_text,median FROM %swikitrust_colored_markup JOIN %swikitrust_global WHERE revision_id = %s" db_prefix db_prefix 
	(ml2int rev_id) in 
      let result = self#db_exec wikitrust_dbh s in
	match Mysql.fetch result with
            None -> raise DB_Not_Found
	  | Some x -> (not_null str2ml x.(0), not_null float2ml x.(1))

    (** [write_trust_origin_sigs rev_id words trust origin sigs] writes that the 
	revision [rev_id] is associated with [words], [trust], [origin], and [sigs]. *)
    method write_words_trust_origin_sigs (rev_id: int) 
      (words: string array)
      (trust: float array)
      (origin: int array)
      (author: string array)
      (sigs: Author_sig.packed_author_signature_t array) : unit =
      let signature = {
	words_a = words;
	trust_a = trust;
	origin_a = origin;
	author_a = author;
	sig_a = sigs;
      } in 
      let signature_string = ml2str (string_of__of__sexp_of sexp_of_sig_t signature) in 
      let sdb = Printf.sprintf "INSERT INTO %swikitrust_sigs (revision_id, revision_data) VALUES (%s, %s) ON DUPLICATE KEY UPDATE revision_data  = %s" db_prefix (ml2int rev_id) signature_string signature_string in 
      ignore (self#db_exec wikitrust_dbh sdb)

      (** [read_words_trust_origin_sigs rev_id] reads the words, trust, 
	  origin, and author sigs for the revision [rev_id] from the [wikitrust_sigs] table. *)
    method read_words_trust_origin_sigs (rev_id: int) 
      : (string array * float array * int array * string array * Author_sig.packed_author_signature_t array) = 
      let s = Printf.sprintf  "SELECT revision_data FROM %swikitrust_sigs WHERE revision_id = %s" db_prefix (ml2int rev_id) in 
      let result = self#db_exec wikitrust_dbh s in 
      match Mysql.fetch result with 
	None -> raise DB_Not_Found
      | Some x -> begin
	  let signature = of_string__of__of_sexp sig_t_of_sexp (not_null str2ml x.(0)) in 
	  (signature.words_a, signature.trust_a, signature.origin_a, signature.author_a, signature.sig_a)
	end

   (** [delete_author_sigs rev_id] removes from the db the author signatures for [rev_id]. *)
    method delete_author_sigs (rev_id: int) : unit =
      let s = Printf.sprintf  "DELETE FROM %swikitrust_sigs WHERE revision_id = %s" db_prefix (ml2int rev_id) in  
      ignore (self#db_exec wikitrust_dbh s)

    (* ================================================================ *)
    (* User methods. *)

    (** [inc_rep uid delta] increments the reputation of user [uid] by [delta] in
	a single operation, so to avoid database problems. *)
    method inc_rep (uid : int) (delta : float) =
      let s = Printf.sprintf "INSERT INTO %swikitrust_user (user_id, user_rep) VALUES (%s, %s) ON DUPLICATE KEY UPDATE user_rep = user_rep + %s" 
	db_prefix
	(ml2int uid) (ml2float delta) (ml2float delta) in 
      ignore (self#db_exec wikitrust_dbh s)
  
    (** [get_rep uid] gets the reputation of user [uid], from a table 
	      relating user ids to their reputation 
        @raise DB_Not_Found if no tuple is returned by the database.
    *)
    method get_rep (uid : int) : float =
      let s = Printf.sprintf "SELECT user_rep FROM %swikitrust_user WHERE user_id = %s" db_prefix (ml2int uid) in
      let result = self#db_exec wikitrust_dbh s in
      match Mysql.fetch result with 
        None -> raise DB_Not_Found
      | Some x -> not_null float2ml x.(0)
      
	  
    (** [get_user_id name] gets the user id for the user with the given user name *)
    method get_user_id (user_name : string) : int =
      let s = Printf.sprintf "SELECT user_id FROM %swikitrust_revision WHERE username = %s" db_prefix (ml2str user_name) in
      let result = self#db_exec wikitrust_dbh s in
	match Mysql.fetch result with 
            None -> raise DB_Not_Found
	  | Some x -> not_null int2ml x.(0)      
	      
    (* ================================================================ *)

    (** Add the vote to the db *)
    method vote (vote : vote_t) =
      let s = Printf.sprintf "INSERT INTO %swikitrust_vote (revision_id, page_id, voter_id, voted_on) VALUES (%s, %s, %s, %s)" db_prefix (ml2int vote.vote_revision_id) (ml2int vote.vote_page_id) (ml2int vote.vote_voter_id) (ml2str vote.vote_time) in
	ignore (self#db_exec wikitrust_dbh s)

    (* ================================================================ *)

    (** Note that the requested rev was needs to be colored *)
    method mark_to_color (rev_id : int) (page_id : int) (page_title : string) 
      (rev_time : string) (user_id : int) =
      let s = Printf.sprintf "INSERT INTO %swikitrust_missing_revs (revision_id, page_id, page_title, rev_time, user_id) VALUES (%s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE requested_on = now(), processed = false" db_prefix (ml2int rev_id) (ml2int page_id) (ml2str page_title) (ml2str rev_time) (ml2int user_id) in
	ignore (self#db_exec wikitrust_dbh s)

    (** Get the next revs to color *)
    method fetch_next_to_color (max_to_get : int) : 
      (int * int * string * string * int) list =
      let s = Printf.sprintf "SELECT revision_id, page_id, page_title, rev_time, user_id FROM %swikitrust_missing_revs WHERE NOT processed ORDER BY requested_on ASC LIMIT %s" db_prefix (ml2int max_to_get) in
      let results = Mysql.map (self#db_exec wikitrust_dbh s) next2color_row in
      let mark_as_done (rev,_,_,_,_) = 
	let s = Printf.sprintf "UPDATE %swikitrust_missing_revs SET processed = true WHERE revision_id = %s" db_prefix (ml2int rev) in
	  ignore (self#db_exec wikitrust_dbh s)
      in
	List.iter mark_as_done results;
	results

    (** Add the page to the db *)
    method write_page (page : wiki_page) =
      let s = Printf.sprintf "INSERT INTO %spage (page_id, page_namespace, page_title, page_restrictions, page_counter, page_is_redirect, page_is_new, page_random, page_touched, page_latest, page_len) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE page_latest = %s" db_prefix (ml2int page.page_id) (ml2int page.page_namespace) (ml2str page.page_title) (ml2str page.page_restrictions) (ml2int page.page_counter) (if page.page_is_redirect then "true" else "false") (if page.page_is_new then "true" else "false") (ml2float page.page_random) (ml2str page.page_touched) (ml2int page.page_latest) (ml2int page.page_len) (ml2int page.page_latest)
      in
	ignore (self#db_exec wikitrust_dbh s)

    (** Add the rev to the db *)
    method write_revision (rev : wiki_revision) = 
      (* Add the content. *)
      let s = Printf.sprintf "INSERT INTO %stext (old_id, old_text, old_flags) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE old_flags = %s" db_prefix (ml2int rev.revision_id) (ml2str rev.revision_content) (ml2str "utf8") (ml2str "utf8") in
	ignore (self#db_exec wikitrust_dbh s);
	  (* And then the revision metadata. *)
	let s = Printf.sprintf "INSERT INTO %srevision (rev_id, rev_page, rev_text_id, rev_comment, rev_user, rev_user_text, rev_timestamp, rev_minor_edit, rev_deleted, rev_len, rev_parent_id) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE rev_len = %s" db_prefix (ml2int rev.revision_id) (ml2int rev.revision_page) (ml2int rev.revision_id) (ml2str rev.revision_comment) (ml2int rev.revision_user) (ml2str rev.revision_user_text) (ml2str rev.revision_timestamp) (if rev.revision_minor_edit then "true" else "false") (if rev.revision_deleted then "true" else "false") (ml2int rev.revision_len) (ml2int rev.revision_parent_id) (ml2int rev.revision_len) in
	ignore (self#db_exec wikitrust_dbh s)

    (** Clear everything out (except for the votes) *)
    method delete_all (really : bool) =
      match really with
        true -> (
	  ignore (self#db_exec wikitrust_dbh "DELETE FROM wikitrust_global");
	  ignore (self#db_exec wikitrust_dbh "INSERT INTO wikitrust_global VALUES (0,0,0,0,0,0,0,0,0,0,0)");
          ignore (self#db_exec wikitrust_dbh "TRUNCATE TABLE wikitrust_page" );
          ignore (self#db_exec wikitrust_dbh "TRUNCATE TABLE wikitrust_revision" );
          ignore (self#db_exec wikitrust_dbh "TRUNCATE TABLE wikitrust_colored_markup" );
          ignore (self#db_exec wikitrust_dbh "TRUNCATE TABLE wikitrust_sigs" );
          ignore (self#db_exec wikitrust_dbh "TRUNCATE TABLE wikitrust_user" ); 
	  ignore (self#db_exec wikitrust_dbh "UPDATE wikitrust_vote SET processed = FALSE" ); 
          (* Note that we do NOT delete the votes!! *)
          ignore (self#db_exec wikitrust_dbh "COMMIT"))
	| false -> ignore (self#db_exec wikitrust_dbh "COMMIT")
	    
  end;; (* online_db *)

