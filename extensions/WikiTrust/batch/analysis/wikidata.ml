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


(** Module wikidata.ml
    This module contains functions for reading the reduced statistics file. 
    The main function is read_data. 
 *)

(* Reduced statistics file format: 
   (It is documented here, so that it is versioned with the rest of the code) 

   General information: 

   Each page has an associated, unique, id, called the page id. 
   Similarly, each revision (more properly, it should be called version) has a unique integer id, 
   and the id is unique among all revisions of all pages. 
   Each user also has an integer id; if the id is 0, then the user is the "anonymous" user: 
   someone who is editing the Wikipedia without having first registered. 

   File format: 

   The reduced statistics file contains the following types of lines.  Here, "fixed string"
   means a string that is the same in all lines of the same type.  The description of each
   field is introduced by ;;. 


   Page: 1 Title: "Alessandro Manzoni"

        This line is at the beginning of a group of lines for a page, and contains some general 
        page data. 

        Page: ;; fixed string, identifying the type of the line. 
        1     ;; page id, an integer identifying the page
        Title: "Alessandro Manzoni" ;; an Ocaml-escaped string containing the page title. 

   TextInc 1030872359 PageId: 8179 rev0: 101832 uid0: 0 uname0: "Joe Black" rev1: 334539 uid1: 0 uname1: "God" text: 49 left: 47 n01: 3 t01: 16191768

	This line contains the information necessary to compute the increment of reputation of user 
	uid0 caused by uid1 still leaving, in its revision, some of the text that was introduced by 
	uid0. 

        TextInc ;; fixed string.
	1082314029 ;; Timestamp in seconds since UNIX epoch at which the judge revision (in this case 47128) was made.
	PageId: 1  ;; the page id is 1. 
	rev0: 29479 ;; the revision where the text was introduced has id 29479.
	uid0: 0 ;; the user who did revision 29479 is the user 0 (in this case, the anonymous user).
        uname0: "Joe Black" ;; the user name for uid0
	rev1: 47128 ;; the revision where we are measuring how much text is left is the revision 47128.
	uid1: 23 ;; the user who provides the comments is the user with id 23.
        uname1: "God" ;; the user name for uid1
	text: 846 ;; amount of original text: in revision 29479, 846 words were introduced. 
	left: 855 ;; amount of residual text: in revision 47128, 855 words are left of the contribution done in 29479. 
                     (evidently, in this case some words have been duplicated; duplicated words are still attributed to 
		     the original author). 
        n01: 3 ;; The number of revisions between rev0 and rev1, including rev1. In this case 3. So, the third revision
                  after rev0 was rev1.
        t01: 16191768 ;; The intervening time between rev0 and rev1. 

   TextLife 1073107958 PageId: 1 rev0: 29479 uid0: 0 uname0: "Joe Black" NJudges: 9 NewText: 846 Life: 7665

        This line summarizes the longevity of the text introduced at a particular revision. 

	TextLife ;; fixed string.
	1082314029 ;; Timestamp in seconds since UNIX epoch at which the revision was made.
	PageId: 1  ;; the page id is 1. 
	rev0: 29479 ;; The revision where the text was introduced is the 29479.
	uid0: 0 ;; The revision was done by user 0 (the anonymous one in this case).
        uname0: "Joe Black" ;; the user name for uid0
	NJudges: 9 ;; 9 other users then reviewed the page, and are judging the longevity of the edit done at revision 29479.
	NewText: 846 ;;  amount of original text: in revision 29479, 846 words were introduced.
	Life: 7665 ;; 7665 words of the text introduced at version 29479 appeared in the next 9 revisions.

   EditInc 1113671446 PageId: 7954 Delta:    2.50 rev0: 10550535 uid0: 55767 uname0: "R. fiend" rev1: 11805828 uid1: 0 uname1: "210.49.80.154" rev2: 12543256 uid2: 231414 uname2: "Jack39" d01:   16.00 d02:  611.67 d12:  613.17  dp2: 302.00 n01: 6 n12: 3 t01: 3429205 t12: 1543097


	This line is used to compute an increment (positive or negative) to the reputation of the author of a revision, 
	according to how much the edits are still present at a later revision. 

	EditInc ;; fixed string.
	1113671446 ;; timestamp at which the edit was made.
	PageId: 7954 ;; the page id is 1.
        Delta: 2.50 ;; how much was the edit distance between this revision and the previous one
	rev0: 10550535 ;; there are the revision id, user id, and user name of the revision that is the reference point in the past. 
	uid0: 55767 ;; 
        uname0: "R. fiend" ;; 
	rev1: 11805828 ;;this is the revision whose change is being judged. 
	uid1: 0 ;; '0' means anonymous
        uname1: "210.49.80.154" ;; for anonymous users, the name is the IP
	rev2: 12543256 ;; this is the judge revision, userid, and username, in the future of rev1. 
	uid2: 231414 ;;
        uname2: "Jack39" ;;
	d01: 16.00 ;; The distance between rev0 and rev1
	d02: 611.67 ;; The distance between rev1 and rev2
	d12: 613.17 ;; The distance between rev0 and rev2
        dp2: 302.00 ;; the distance between the revision before rev1, and rev2
        n01: 6 ;; The number of revisions between rev0 and rev1, including rev1.
        n12: 3 ;; The number of revisions between rev1 and rev2, including rev2.
        t01: 3429205 ;; The elapsed time between rev0 and rev1.
        t12: 1543097 ;; The elapsed time between rev1 and rev2.

   EditLife 1082322340 PageId: 1 rev0: 47136 uid0: 24 NJudges: 4 Delta:    3.52 AvgSpecQ: -0.06902

	This line gives the "edit longevity" of an edit. 

	"EditLife" ;; fixed string.
	1082322340 ;; timestamp at which the edit was made.
	PageId: 1 ;; the page id.
	rev0: 47136 ;; the revision where the edit was made.
	uid0: 24 ;; the user who did the revision is user 24.
        uname0: Tintin1107 ;; the name of user 24
	NJudges: 4 ;; the contribution of user 24 has been judged by 4 subsequent users.
	Delta: 3.52 ;; this is how much change user 24 has done (not much in this case).
	AvgSpecQ: -0.06902 ;; this is the "edit longevity" of the edit by user 24.  Here it is negative, denoting
		a contribution that did not go with the flow of the change in the page (but note that the 
		change in text is minimal). 

 *)

open Evaltypes;;


(** Reads the wiki data from a file.  Can be used from stdin or from a file. 
    Returns a list of comments, from newest to oldest (suitable for fold_right) *)
let read_data 
    (f: in_channel) (* File to be read *)
    (consumer: wiki_data_t -> unit) (* data consumer *)
    (page_titles: string Vec.t option) (* array of page titles, to be built *)
    : string Vec.t option = 
  flush stdout; (* debug *)
  let page_titles_ref = ref page_titles in 
  (* data_ord is used to display progress information *) 
  let data_ord = ref 0 in 
  (* reads the data *)
  let page_id = ref 0 in 
  (* To check that the file is sorted *)
  let last_time = ref 0. in 
  let last_time_warned = ref false in 
  begin
    try
      while true do
	begin 
          let l = input_line f in 
	  (* Printf.printf "%s\n" l; *) (* debug *)
	  (* if !data_ord mod 100000 = 0 then Printf.printf "%d read\n" !data_ord; 
	  flush stdout; *) (* debug *)
          if String.length l > 7 then 
            begin
              (* Now we must figure out which line l is *)
              if (String.sub l 0 7) = "EditInc" then 
		begin
		  (* Current format *)
		  try begin 
                    let make_t t p delta r0 u0 un0 r1 u1 un1 r2 u2 un2 b a d dp n1 n2 t1 t2=
		      if t < !last_time then begin
			if not !last_time_warned then begin
			  last_time_warned := true;
			  Printf.printf "Warning: input file not sorted in increasing time order!\n";
			  flush stdout
			end
		      end;
		      last_time := t; 
		      EditInc {
			edit_inc_time = t; 
			edit_inc_page_id = p;
			edit_inc_delta = delta;
			edit_inc_rev0 = r0;
			edit_inc_uid0 = u0;
			edit_inc_uname0 = un0;
			edit_inc_rev1 = r1;
			edit_inc_uid1 = u1;
			edit_inc_uname1 = un1;
			edit_inc_rev2 = r2;
			edit_inc_uid2 = u2;
			edit_inc_uname2 = un2;
			edit_inc_d01 = b;
			edit_inc_d02 = a;
			edit_inc_d12 = d;
			edit_inc_dp2 = dp; 
			edit_inc_n01 = n1;
			edit_inc_n12 = n2;
			edit_inc_t01 = t1;
			edit_inc_t12 = t2;
                      }
                    in
                    let x = Scanf.sscanf l "EditInc %f PageId: %d Delta: %f rev0: %d uid0: %d uname0: %S rev1: %d uid1: %d uname1: %S rev2: %d uid2: %d uname2: %S d01: %f d02: %f d12: %f dp2: %f n01: %d n12: %d t01: %f t12: %f" make_t in
                    consumer x
		  end with Scanf.Scan_failure _ -> begin 
		    (* Older format *)
                    let make_t1 t p delta r0 u0 un0 r1 u1 un1 r2 u2 un2 b a d n1 n2 t1 t2=
		      if t < !last_time then begin
			if not !last_time_warned then begin
			  last_time_warned := true;
			  Printf.printf "Warning: input file not sorted in increasing time order!\n";
			  flush stdout
			end
		      end;
		      last_time := t; 
		      EditInc {
			edit_inc_time = t; 
			edit_inc_page_id = p;
			edit_inc_delta = delta;
			edit_inc_rev0 = r0;
			edit_inc_uid0 = u0;
			edit_inc_uname0 = un0;
			edit_inc_rev1 = r1;
			edit_inc_uid1 = u1;
			edit_inc_uname1 = un1;
			edit_inc_rev2 = r2;
			edit_inc_uid2 = u2;
			edit_inc_uname2 = un2;
			edit_inc_d01 = b;
			edit_inc_d02 = a;
			edit_inc_d12 = d;
			edit_inc_dp2 = 0.;
			edit_inc_n01 = n1;
			edit_inc_n12 = n2;
			edit_inc_t01 = t1;
			edit_inc_t12 = t2;
                      }
                    in
                    let x = Scanf.sscanf l "EditInc %f PageId: %d Delta: %f rev0: %d uid0: %d uname0: %S rev1: %d uid1: %d uname1: %S rev2: %d uid2: %d uname2: %S d01: %f d02: %f d12: %f n01: %d n12: %d t01: %f t12: %f" make_t1 in
                    consumer x
		  end
		end
              else if (String.sub l 0 7) = "TextInc" then 
		begin
                  let make_t t p jr ju jn r u n nt q n1 t1 = 
		    if t < !last_time then begin
		      if not !last_time_warned then begin
			last_time_warned := true;
			Printf.printf "Warning: input file not sorted in increasing time order!\n";
			flush stdout
		      end
		    end;
		    last_time := t;
		    TextInc { 
		      text_inc_time = t; 
		      text_inc_page_id = p; 
		      text_inc_rev0 = jr;
		      text_inc_uid0 = ju;
                      text_inc_uname0 = jn;
		      text_inc_rev1 = r;
		      text_inc_uid1 = u;
                      text_inc_uname1 = n;
		      text_inc_orig_text = nt; 
		      text_inc_seen_text = q;
		      text_inc_n01 = n1;
		      text_inc_t01 = t1;
                    }
                  in 
                  let x = Scanf.sscanf l "TextInc %f PageId: %d rev0: %d uid0: %d uname0: %S rev1: %d uid1: %d uname1: %S text: %d left: %d n01: %d t01: %f" make_t in 
                  consumer x
		end
              else if (String.sub l 0 8) = "TextLife" then 
		begin
                  let make_t t p jr ju jn nj nt tl = 
		    if t < !last_time then begin
		      if not !last_time_warned then begin
			last_time_warned := true;
			Printf.printf "Warning: input file not sorted in increasing time order!\n";
			flush stdout
		      end
		    end;
		    last_time := t; 
                    (* We need to compute the text decay factor *)
                    let compute (l: int) (n: int) (t: int) : float = 
                      (* l is the life, n is the n. of judges, t is the text *)
                      if t = 0 then 1.0 
                      else if l = 0 then 0.0 
                      else begin
			(* I am solving by truncated Newton's method the equation: 
                           (1 - alpha) l = alpha t (1 - alpha^n) *)
			let fl = float_of_int l in 
			let fn = float_of_int n in 
			let ft = float_of_int t in 
			let alpha = ref 0.0 in 
			for i = 1 to 5 do 
                          begin
                            (* function whose zero is to be found *)
                            let f = (1.0 -. !alpha) *. fl -. !alpha *. ft *. (1.0 -. (!alpha ** fn)) in
                            (* first derivative:
                               -l -t * (1 - alpha^n) + alpha * t * n * alpha^(n-1) *)
                            let f' = -.fl -.ft *. (1.0 -. (!alpha ** fn)) +. !alpha *. ft *. fn *. (!alpha ** (fn -. 1.0)) in 
                            (* new estimate *)
                            alpha := !alpha -. f /. f' 
                          end
			done;
			!alpha
                      end
                    in
		    TextLife {
		      text_life_time = t; 
		      text_life_page_id = p; 
		      text_life_rev0 = jr;
		      text_life_uid0 = ju;
                      text_life_uname0 = jn;
		      text_life_n_judges = nj; 
		      text_life_new_text = nt; 
		      text_life_text_life = tl; 
		      text_life_text_decay = compute tl nj nt;
                    }
                  in 
                  let x = Scanf.sscanf l "TextLife %f PageId: %d rev0: %d uid0: %d uname0: %S NJudges: %d NewText: %d Life: %d" make_t in 
                  consumer x
		end
              else if (String.sub l 0 8) = "EditLife" then 
		begin
                  let make_t t p jr ju jn nj d q = 
		    if t < !last_time then begin
		      if not !last_time_warned then begin
			last_time_warned := true;
			Printf.printf "Warning: input file not sorted in increasing time order!\n";
			flush stdout
		      end
		    end;
		    last_time := t; 
                    EditLife { 
		      edit_life_time = t;
		      edit_life_page_id = p; 
		      edit_life_rev0 = jr; 
                      edit_life_uid0 = ju;
                      edit_life_uname0 = jn;
                      edit_life_n_judges = nj; 
                      edit_life_delta = d;
                      edit_life_avg_specq = q;
                    }
                  in 
                  let x = Scanf.sscanf l "EditLife %f PageId: %d rev0: %d uid0: %d uname0: %S NJudges: %d Delta: %f AvgSpecQ: %f" make_t in 
                  consumer x
		end
            end; (* if length > 7 *)
          if (String.length l > 4) & (String.sub l 0 4) = "Page" then 
            begin
              let make_t d t = 
		begin 
		  page_id := d; 
		  match !page_titles_ref with 
		    None -> ()
		  | Some titles -> page_titles_ref := Some (Vec.setappend "" t d titles)
		end 
	      in 
              Scanf.sscanf l "Page: %d Title: %S" make_t 
            end;
	  data_ord := !data_ord + 1;
	end (* while *)
      done (* while *)
    with End_of_file -> ()
  end; (* try *)
  Printf.printf "Read all.\n";
  flush stdout; 
  !page_titles_ref;;

