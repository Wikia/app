(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler, Vishwanath Raman

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


(** Module Showstats
    This module computes and displays the statistics regarding
    the predictive power of reputation for a wiki. *)
open Evaltypes;;

(* First, I want to figure out which version I am. *)
let p = Unix.open_process_in "git show --pretty=format:\"%H\" @{0}";;
let version_str = input_line p;;
ignore (Unix.close_process_in p);;
(* Then passes this information to fileinfo *)
Fileinfo.make_info_obj version_str "";;

(* Input defaults *)
let stream_name = ref "" (* Input stream *)
let include_anon = ref false
let do_monthly = ref false
let do_cumulative = ref false 
let do_localinc = ref false
let gen_exact_rep = ref false
let use_reputation_cap = ref false
let use_weak_nix = ref false
let use_nix = ref false
let gen_almost_truthful_rep = ref false
let gen_truthful_rep = ref false
let nix_interval = ref (4. *. 3600.)
let set_nix_interval f = nix_interval := f 
let n_edit_judging = ref 12 (* This default is the same as n_edit_judging in page_factory.ml *)
let set_n_edit_judging n = n_edit_judging := n 
let user_contrib_order_asc = ref false
let include_domains = ref false
let ip_nbytes = ref 0
let time_intv = ref {
  start_time = 0.0; 
  end_time = Timeconv.time_to_float 2020 10 30 0 0 0; 
};;

let user_file = ref None
let set_file_name (s: string) = stream_name := s
let set_user_file s = user_file := Some (Fileinfo.open_info_out s)
let user_contrib_file = ref None
let set_user_contrib_file s = user_contrib_file := Some (Fileinfo.open_info_out s)

let set_ip_nbytes i = 
  if (i < 1 || i > 4) then begin
    Printf.printf "The range for -ip_nbytes is [1, 4]. %d is out of bounds\n" i; 
    flush stdout;
    exit 0;
  end else ip_nbytes := i

let set_end_time (s: string) = 
  let f = float_of_string s in 
  let y = int_of_float f in 
  let f1 = (f -. (float_of_int y)) *. 100. in 
  let m = int_of_float f1 in 
  let f2 = (f1 -. (float_of_int m)) *. 100. in 
  let d = int_of_float f2 in 
  time_intv := { 
    start_time = 0.0; 
    end_time = Timeconv.time_to_float y m d 0 0 0; 
};;

let command_line_format = [("-end", Arg.String (set_end_time), 
			    "End time for the evaluation (YYYY.MMDD)"); 
			   ("-m", Arg.Set (do_monthly), 
			    "Do monthly statistics of precision and recall");
			   ("-u", Arg.String set_user_file, 
			    "<user_file>: produce file with user reputation evolution");
			   ("-cumul", Arg.Set (do_cumulative), 
			    "Do the monthly statistics in cumulative fashion, since the beginning of time");
			   ("-a", Arg.Set (include_anon), 
                            "Include anonymous users in statistics");
			   ("-localinc", Arg.Set (do_localinc),
			    "EditInc uses, as past reference point, only the immediately preceding version");
			   ("-domains", Arg.Set include_domains,
			    "Include user domains for anonymous users in computing reputation");
			   ("-ip_nbytes", Arg.Int set_ip_nbytes, 
			    "<n>: generate user ids using the first n bytes of their ip address. n should be in [1,4]");
			   ("-u_contrib", Arg.String set_user_contrib_file,
			    "<contrib_file>: produce a file with user contribution data");
                           ("-u_contrib_order_asc", Arg.Set (user_contrib_order_asc),
                            "Ascending order of user contributions (default: descending)");
			   ("-gen_exact_rep", Arg.Set (gen_exact_rep),
			    "Generate an extra column in the user reputation file with exact reputation values");
			   ("-use_reputation_cap", Arg.Set use_reputation_cap, 
			    "Use reputation cap.");
			   ("-use_weak_nix", Arg.Set use_weak_nix, 
			    "Use nix by any reputation (low rep can nix high rep).");
			   ("-use_nix", Arg.Set use_nix, 
			    "Use nix in which higher reputation users can nix lower reputation ones"); 
			   ("-nix_inverval", Arg.Float set_nix_interval, 
			    "Nixing interval (in seconds) for robust reputation.");
			   ("-n_edit_judging", Arg.Int set_n_edit_judging, 
			    "N. of edit judges for nixing (this must match the way evalwiki was called to compute the stats"); 
			   ("-local_global_algo", Arg.Set gen_almost_truthful_rep, 
			    "Use algorithm for almost truthful reputation.");
			   ("-local_algo", Arg.Set gen_truthful_rep, 
			    "Use algorithm for truthful reputation.");
]

let _ = Arg.parse command_line_format set_file_name "Usage: generate_reputation [<filename>]\nIf <filename> is missing, stdin is used"

let params = {
  rep_scaling = 73.24;
  max_rep = 22026.465795 -. 2.0; 
}

let all_time_intv = {
  start_time = 0.0; 
  end_time = Timeconv.time_to_float 2008 10 30 0 0 0; 
};;

(* Ensures consistency *)
if (!gen_almost_truthful_rep || !gen_truthful_rep) then begin
  use_nix := true;
  use_reputation_cap := true
end

(* This is the reputation evaluator *)
let r = new Computerep.rep params !include_anon all_time_intv !time_intv !user_file !do_monthly !do_cumulative !do_localinc !gen_exact_rep !user_contrib_order_asc !include_domains !ip_nbytes stdout !use_reputation_cap !use_nix !use_weak_nix !nix_interval !n_edit_judging !gen_almost_truthful_rep !gen_truthful_rep;;

(* Reads the data *)
let stream = if !stream_name = "" 
  then stdin 
  else Fileinfo.open_info_in !stream_name 
in 
ignore (Wikidata.read_data stream r#add_data None);
if !stream_name <> "" then Fileinfo.close_info_in stream;;

(* And prints the results *)
r#compute_stats !user_contrib_file stdout;;

(* Closes the output file *)
match !user_contrib_file with 
  Some f -> Fileinfo.close_info_out f
| None -> ();;
match !user_file with 
  Some f -> Fileinfo.close_info_out f
| None -> ();;

(* Annotate on stdout so that one can include the info with the rest of the information *)
print_newline (); print_endline (Fileinfo.make_xml_string ());;
