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

(* Figures out which pages to update, and starts them going. *)

open Printf
open Mysql
open Unix
open Online_command_line
open Wikipedia_api
open Online_db
open Online_types

let max_concurrent_procs = 10
let sleep_time_sec = 1
let custom_line_format = [] @ command_line_format

let _ = Arg.parse custom_line_format noop "Usage: dispatcher";;

let working_children = Hashtbl.create max_concurrent_procs

(* Prepares the database connection information *)
let mediawiki_db = {
  dbhost = Some !mw_db_host;
  dbname = Some !mw_db_name;
  dbport = Some !mw_db_port;
  dbpwd  = Some !mw_db_pass;
  dbuser = Some !mw_db_user;
}

(* Here begins the sequential code *)
let db = new Online_db.db !db_prefix mediawiki_db None !dump_db_calls in
let logger = new Online_log.logger !log_name !synch_log in
let n_processed_events = ref 0 in
let trust_coeff = Online_types.get_default_coeff in

(* There are two types of throttle delay: a second each time we are multiples of an int, 
   or a number of seconds before each revision. *)
let each_event_delay = int_of_float !color_delay in
let every_n_events_delay = 
  let frac = !color_delay -. (floor !color_delay) in 
    if frac > 0.001
    then Some (max 1 (int_of_float (1. /. frac)))
    else None
in

(* Wait for the processes to stop before accepting more *)
let clean_kids k v = (
  let stat = Unix.waitpid [WNOHANG] v in
    match (stat) with
      | (0,_) -> () (* Process not yet done. *)
      | (_, WEXITED s) -> Hashtbl.remove working_children k (* Otherwise, remove the process. *)
      | (_, WSIGNALED s) -> Hashtbl.remove working_children k
      | (_, WSTOPPED s) -> Hashtbl.remove working_children k
) in

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

(* 
   Returns the user id of the user name if we have it, 
   or asks a web service for it if we do not. 
*)
let get_user_id u_name =
  try db # get_user_id u_name with DB_Not_Found -> get_user_id u_name
in

(* Color the asked for revision. *)
let process_revs (page_id : int) (rev_ids : int list) (page_title : string)
    (rev_timestamp : string) (user_id : int) =
  let rec do_processing (rev_id : int) = 
    (* I assume that a user cannot vote on an unprocessed revision here. *)
    if (db # revision_needs_coloring rev_id) then (
      (* Grab the text and color it. *)
      let last_colored_timestamp = try db # get_latest_colored_rev_timestamp 
	page_id with DB_Not_Found -> "19700201000000" in
      let (wpage, wrevs) = fetch_page_and_revs_after page_title last_colored_timestamp in
	match wpage with
	  | None -> Printf.printf "Failed for page %s\n" page_title
	  | Some pp -> (
	      Printf.printf "Got page titled %s\n" pp.page_title;
	      db # write_page pp
	    );
	      let update_and_write_rev rev =
		rev.revision_page <- page_id;
		rev.revision_user <- (get_user_id rev.revision_user_text);
		db # write_revision rev
	      in
	      List.iter update_and_write_rev wrevs;
	      let f rev = 
		evaluate_revision page_id rev.revision_id
	      in
		List.iter f wrevs;
		Unix.sleep sleep_time_sec;
		if !synch_log then flush Pervasives.stdout;
		if (db # revision_needs_coloring rev_id) then (
		  do_processing rev_id
		)
		else ()	
    ) else ( (* Vote! *)
      let process_vote v = (
	if v.vote_page_id == page_id then 
	  evaluate_vote page_id rev_id v.vote_voter_id
      ) in
      let votes = db # fetch_unprocessed_votes !max_events_to_process in
	List.iter process_vote votes
    )
  in
    List.iter do_processing rev_ids;
    Printf.printf "Finished processing page %s\n" page_title;	      
    exit 0 (* No more work to do, stop this process. *)
in

(* Start a new process going which actually processes the missing page. *)
let dispatch_page rev_pages = 
  let new_pages = Hashtbl.create (List.length rev_pages) in
  let is_new_page p =
    try ignore (Hashtbl.find working_children p); false with Not_found -> true
  in
  let set_revs_to_get (r,p,title,time,uid) =
    Printf.printf "page %d\n" p;
    if (is_new_page p) then (
      (
	let current_revs = try Hashtbl.find new_pages p with 
	    Not_found -> ([],title,time,uid) in
	  (Hashtbl.replace new_pages p ((r::(let x,_,_,_  = 
					       current_revs in x)),
					title,time,uid))
      )
    ) else ()
  in 
  let launch_processing p (r,t,rt,uid) = (
    let new_pid = Unix.fork () in
      match new_pid with 
	| 0 -> (
	    Printf.printf "I'm the child\n Running on page %d rev %d\n" p 
	      (List.hd r);
	    process_revs p r t rt uid
	  )
	| _ -> (Printf.printf "Parent of pid %d\n" new_pid;  
		Hashtbl.add working_children p (new_pid)
	       )
  ) in
    Hashtbl.iter clean_kids working_children;
    List.iter set_revs_to_get rev_pages;
    Hashtbl.iter launch_processing new_pages
in

(* Poll to see if there is any more work to be done. *)
let rec main_loop () =
  if (Hashtbl.length working_children) >= max_concurrent_procs then (
      Hashtbl.iter clean_kids working_children
  ) else (
    let revs_to_process = db # fetch_next_to_color 
      (max (max_concurrent_procs - Hashtbl.length working_children) 0) in
      dispatch_page revs_to_process
  );
  Unix.sleep sleep_time_sec;
  if !synch_log then flush Pervasives.stdout;
  main_loop ()
in

main_loop ()
