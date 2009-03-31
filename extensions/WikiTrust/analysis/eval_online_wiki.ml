(*

Copyright (c) 2007-2008 The Regents of the University of California
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

open Printf
open Mysql
open Online_command_line

(** MissingInformation is raised if any of 
    page_id, revision_id, or voter_uid is not specified. *)
exception MissingInformation

(** This is the top-level code of the wiki online xml evaluation. *)

(* Figure out what to do and how we are going to do it. *)
let custom_line_format = [] @ command_line_format

let _ = Arg.parse custom_line_format noop "
This command computes user reputations and text trust for a wiki. 
The command assumes that the wiki database already contains some special 
tables for reputation and trust, and computes the missing reputation and 
trust values, in chronological order.  The code is thread-safe, meaning
that more than one instance can be active at the same time; an instance
terminates when all the work is done, or if there are too many active
instances (measured not from the number of active instances, but from 
the amount of DB contention that is generated, so the code is 
auto-throttling).  The command can be called whenever someone edits a 
revision, in which case it will just color the latest revision 
according to trust, and it will update user reputations accordingly.

Usage: eval_online_wiki";;

let n_processed_events = ref 0;;
let logger = new Online_log.logger !log_name !synch_log;;
let trust_coeff = Online_types.get_default_coeff;;
let f m n = !reputation_speed *. (Online_types.default_dynamic_rep_scaling n m) in 
trust_coeff.Online_types.dynamic_rep_scaling <- f;;

(* There are two types of throttle delay: a second each time we are multiples of an int, 
   or a number of seconds before each revision. *)
let each_event_delay = int_of_float !color_delay;;
let every_n_events_delay = 
  let frac = !color_delay -. (floor !color_delay) in 
  if frac > 0.001
  then Some (max 1 (int_of_float (1. /. frac)))
  else None;;
  

(* Prepares the database connection information *)
let mediawiki_db = {
  dbhost = Some !mw_db_host;
  dbname = Some !mw_db_name;
  dbport = Some !mw_db_port;
  dbpwd  = Some !mw_db_pass;
  dbuser = Some !mw_db_user;
}
let wikitrust_db_opt = 
  if !use_separate_dbs 
  then Some { 
    dbhost = Some !wt_db_host;
    dbname = Some !wt_db_name;
    dbport = Some !wt_db_port;
    dbpwd  = Some !wt_db_pass;
    dbuser = Some !wt_db_user;
  }
  else None

(* Here begins the sequential code *)

let db = new Online_db.db !db_prefix mediawiki_db wikitrust_db_opt !dump_db_calls in 

 
(* If requested, we erase all coloring, and we recompute it from scratch. *)
if !delete_all then begin 
  db#delete_all true; 
  Printf.printf "Cleared the db.\n"
end;


(* This is the function that evaluates a revision. 
   The function is recursive, because if some past revision of the same page 
   that falls within the analysis horizon is not yet evaluated and colored
   for trust, it evaluates and colors it first. 
 *)
let rec evaluate_revision (page_id: int) (rev_id: int): unit = 
  if !n_processed_events < !max_events_to_process then 
    begin 
      begin (* try ... with ... *)
	try 
	  Printf.printf "Evaluating revision %d of page %d\n" rev_id page_id;
	  let page = new Online_page.page db logger page_id rev_id trust_coeff !times_to_retry_trans in
	  n_processed_events := !n_processed_events + 1;
	  if page#eval then begin 
	    Printf.printf "Done revision %d of page %d\n" rev_id page_id;
	  end else begin 
	    Printf.printf "Revision %d of page %d was already done\n" rev_id page_id;
	  end;
	  (* Waits, if so requested to throttle the computation. *)
	  if each_event_delay > 0 then Unix.sleep (each_event_delay); 
	  begin 
	    match every_n_events_delay with 
	      Some d -> begin 
		if (!n_processed_events mod d) = 0 then Unix.sleep (1);
	      end
	    | None -> ()
	  end; 

	with Online_page.Missing_trust (page_id', rev_id') -> 
	  begin
	    (* We need to evaluate page_id', rev_id' first *)
	    (* This if is a basic sanity check only. It should always be true *)
	    if rev_id' <> rev_id then 
	      begin 
		Printf.printf "Missing trust info: we need first to evaluate revision %d of page %d\n" rev_id' page_id';
		evaluate_revision page_id' rev_id';
		evaluate_revision page_id rev_id
	      end (* rev_id' <> rev_id *)
	  end (* with: Was missing trust of a previous revision *)
      end (* End of try ... with ... *)
    end
in


(* This is the code that evaluates a vote *)
let evaluate_vote (page_id: int) (revision_id: int) (voter_id: int) = 
  if !n_processed_events < !max_events_to_process then 
    begin 
      Printf.printf "Evaluating vote by %d on revision %d of page %d\n" voter_id revision_id page_id; 
      let page = new Online_page.page db logger page_id revision_id trust_coeff !times_to_retry_trans in 
      if page#vote voter_id then begin 
	n_processed_events := !n_processed_events + 1;
	Printf.printf "Done revision %d of page %d\n" revision_id page_id;
      end;
      (* Waits, if so requested to throttle the computation. *)
      if each_event_delay > 0 then Unix.sleep (each_event_delay); 
      begin 
	match every_n_events_delay with 
	  Some d -> begin 
	    if (!n_processed_events mod d) = 0 then Unix.sleep (1);
	  end
	| None -> ()
      end; 
    end 
in 

match !eval_type with
  | VOTE -> (
      let page_id = match !requested_page_id with 
	  None -> raise MissingInformation
	| Some d -> d
      in
      let revision_id = match !requested_rev_id with 
	  None -> raise MissingInformation
	| Some d -> d
      in
      let voter_id = match !requested_voter_id with 
	  None -> raise MissingInformation
	| Some d -> d
      in
	evaluate_vote page_id revision_id voter_id
    )
  | EVENT -> (

(* Creates the event feed for the work we wish to do *)
let feed  = new Event_feed.event_feed db !requested_rev_id !times_to_retry_trans in 
(* This hashtable is used to implement the load-sharing algorithm. *)
let tried : (int, unit) Hashtbl.t = Hashtbl.create 10 in 
while !n_processed_events < !max_events_to_process do 
  begin 
    (* This is the main loop *)
    match feed#next_event with 
      None -> 
	(* We are done *)
	n_processed_events := !max_events_to_process
    | Some (event_timestamp, page_id, event) -> begin 
	(* We have an event to process *)
	(* Tracks execution time *)
	let t_start = Unix.gettimeofday () in 
	
	(* Tries to acquire the page lock. 
	   If it succeeds, colors the page. 
	   
	   The page lock is not used for correctness: rather, it is used to limit 
	   transaction parallelism, and to allow revisions to be analyzed in parallel: 
	   otherwise, all processes would be trying to analyze them in the same order, 
	   and they would just queue one behind the next. 
	   The use of these locks, along with the [tried] hashtable, enforces bounded 
	   overtaking, allowing some degree of out-of-order parallelism, while ensuring
	   that the revisions of the same page are tried in the correct order. 
	   
	   We set the timeout for waiting as follows. 
	   - If the page has already been tried, we need to wait on it, so we choose a long timeout. 
	   If we don't get the page by the long timeout, this means that there is too much db 
	   lock contention (too many simultaneously active coloring processes), and we terminate. 
	   - If the page has not been tried yet, we set a short timeout, and if we don't get the lock,
	   we move on to the next revision. 
	   This algorithm ensures an "overtake by at most 1" property: if there are many coloring
	   processes active simultaneously, and r_k, r_{k+1} are two revisions of a page p, it is 
	   possible that a process is coloring r_k while another is coloring a revision r' after r_k 
	   belonging to a different page p', but this revision r' cannot be past r_{k+1}. 
	 *)
	let already_tried = Hashtbl.mem tried page_id in 
	let got_it = 
	  if already_tried 
	  then db#get_page_lock page_id lock_timeout 
	  else db#get_page_lock page_id 0 in 
	(* If we got it, we can process the event *)
	if got_it then begin 
	  (* Processes page *)
	  if already_tried then Hashtbl.remove tried page_id; 
	  begin 
	    match event with 
	      Event_feed.Revision_event revision_id -> evaluate_revision page_id revision_id
	    | Event_feed.Vote_event (revision_id, voter_id) -> evaluate_vote page_id revision_id voter_id
	  end;
	  db#release_page_lock page_id;
	end else begin 
	  (* We could not get the lock.  
	     If we have already tried the page, this means we waited LONG time; 
	     we quit everything, as it means there is some problem. *)
	  if already_tried 
	  then begin
	    n_processed_events := !max_events_to_process;
	    Printf.printf "Waited too long for lock of page %d; terminating.\n" page_id;
	    flush stdout;
	  end
	  else Hashtbl.add tried page_id ();
	end; (* not got it *)
	let t_end = Unix.gettimeofday () in 
	Printf.printf "Analysis took %f seconds.\n" (t_end -. t_start);
	flush stdout
      end (* event that needs processing *)
  end done; (* Loop as long as we need to do events *)

    );

(* Closes the db connection *)
db#close;

(* Close the logger *)
logger#close
