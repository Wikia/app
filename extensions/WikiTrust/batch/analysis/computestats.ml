(*

Copyright (c) 2007-2008 The Regents of the University of California
All rights reserved.

Authors: Luca de Alfaro, B. Thomas Adler

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

(** Computestats.ml.  This module computes the statistics that are
    used to evaluate the predictive value of a reputation *)

open Evaltypes;;

class stats
  (params: params_t) (* The parameters used for evaluation, used basically for max_rep *)
  (time_span: time_intv_t) (* we evaluate events only in this interval of time *)
  =
  let n_bins_init = 1 + int_of_float (log (1.0 +. params.max_rep)) in 
  let n_cols_init = 11 in 
object (self)
  val max_rep : float = params.max_rep 
  val n_bins : int = n_bins_init 
  val n_cols : int = n_cols_init
  val wgt_raw = Array.make_matrix n_bins_init n_cols_init 0.0

  (* pseudodivison, avoids divides by 0 *)
  method normdiv (x: float) (y: float) = if y = 0.0 then 0.0 else x /. y 

  (* log in base 2, for information theory *)
  method log2 (x: float) : float = (log x) /. (log 2.0)

  (* given a float in [-1.0, 1.0], returns an int, providing the column number *)
  method col_of_float (f: float) : int = int_of_float ((1.0 -. f) /. 0.2)


  (* This is the function that is iterated on every event, in order to fill 
     the matrix *)
  method add_event 
      (evt_time: float) (* Time of the event *)
      (rep_weight: float) (* Weight of user's reputation *)
      (evt_mass: float) (* Probability mass of the event (text length, etc) *)
      (evt_qual: float) (* quality of the event, in interval [-1,1] *)
      : unit =
    (* does it only if the time is right *)
    if evt_time >= time_span.start_time & evt_time <= time_span.end_time then 
      begin
	(* bin is the bin of the user reputation for this event *)
	let bin = int_of_float rep_weight in 
	(* col, the column, is the evaluation quality *)
	let col = self#col_of_float evt_qual in 
	(* we need to add the weight of the data point *)
	wgt_raw.(bin).(col) <- wgt_raw.(bin).(col) +. evt_mass
      end

  (* Produces the statistics *)
  method compute_stats 
    (do_text: bool) (* flag indicating whether we do text (true) or edits (false) *)
    (out_ch: out_channel) (* output channel *)
    : stats_t = 
    
    (* matrices for storing the weights *)
    let wgt = Array.make_matrix n_bins n_cols 0.0 in 
    let wgt_below = Array.make_matrix n_bins n_cols 0.0 in 
    let wgt_of_bin = Array.make n_bins 0.0 in 

    (* Renormalizes wgt_raw and puts it into wgt *)
    let total_weight = ref 0.0 in
    for b_idx = 0 to n_bins - 1 do 
      for c_idx = 0 to n_cols - 1 do 
	total_weight := !total_weight +. wgt_raw.(b_idx).(c_idx)
      done
    done;
    for b_idx = 0 to n_bins - 1 do 
      for c_idx = 0 to n_cols - 1 do 
	wgt.(b_idx).(c_idx) <- wgt_raw.(b_idx).(c_idx) /. !total_weight
      done
    done;
    (* Now fixes the tables.  I could have done it before, 
       but this is more efficient. *)
    for b_idx = 0 to n_bins - 1 do 
      let total_below = ref 0.0 in 
      for c_idx = n_cols - 1 downto 0 do 
	begin
	  let w = wgt.(b_idx).(c_idx) in 
	  wgt_of_bin.(b_idx) <- wgt_of_bin.(b_idx) +. w; 
	  total_below := !total_below +. w; 
	  wgt_below.(b_idx).(c_idx) <- !total_below;
	end
      done
    done; 

    (* Ok, fine.  Now the event tables are computed, and we must compute 
       the statistics from these. *)
    (* First, sets the thresholds for the classification of events. *)
    (* columns at or below this level are bad *)
    let bad_col_threshold = 
      if do_text then (self#col_of_float 0.2) else (self#col_of_float (-. 0.8)) in 
    (* bins below this index are considered of low reputation *)
    let low_bin_threshold = int_of_float ((float_of_int n_bins) *. 0.2 +. 0.5) in 
    (* bins at or above this index are considered of high reputation *)
    (* let high_bin_threshold = int_of_float ((float_of_int n_bins) *. 0.66 +. 0.5) in *)

    (* Computes the mutual information between Low and Bad *)
    
    let bad_low = ref 0.0 in 
    let bad_high = ref 0.0 in 
    let good_low = ref 0.0 in 
    let good_high = ref 0.0 in 
    for b_idx = 0 to n_bins - 1 do 
      if b_idx < low_bin_threshold 
      then begin 
	bad_low  := !bad_low  +. wgt_below.(b_idx).(bad_col_threshold); 
	good_low := !good_low +. wgt_of_bin.(b_idx) -. wgt_below.(b_idx).(bad_col_threshold)
      end
      else begin
	bad_high  := !bad_high  +. wgt_below.(b_idx).(bad_col_threshold); 
	good_high := !good_high +. wgt_of_bin.(b_idx) -. wgt_below.(b_idx).(bad_col_threshold)
      end
    done; 
    let bad =  !bad_low  +. !bad_high in 
    let good = !good_low +. !good_high in 
    let low =  !bad_low  +. !good_low in 
    let high = !bad_high +. !good_high in 
    let mutual_info = ref 0.0 in 
    if false then begin 
      Printf.printf "Bad = %f\n" bad; (* debug *)
      Printf.printf "Good = %f\n" good; (* debug *)
      Printf.printf "Low = %f\n" low; (* debug *)
      Printf.printf "High = %f\n" high (* debug *)
    end; 
    if !bad_low > 0.0 then 
      mutual_info := !mutual_info +. !bad_low *. self#log2 (!bad_low /. (bad *. low)); 
    if !bad_high > 0.0 then 
      mutual_info := !mutual_info +. !bad_high *. self#log2 (!bad_high /. (bad *. high)); 
    if !good_low > 0.0 then 
      mutual_info := !mutual_info +. !good_low *. self#log2 (!good_low /. (good *. low)); 
    if !good_high > 0.0 then 
      mutual_info := !mutual_info +. !good_high *. self#log2 (!good_high /. (good *. high)); 
    let entrophy_good_bad = -. bad *. (self#log2 bad) -. good *. (self#log2 good) in 
    let entrophy_high_low = -. low *. (self#log2 low) -. high *. (self#log2 high) in 
    let coeff_of_constraint = !mutual_info /. entrophy_high_low in 
    
    (* Computes the low bad precision: the percentage of revisions, among those with low 
       reputation, which are bad. *)
    let low_bad_precision = !bad_low /. low in 
    
    (* Computes bad recall: the percentage of bad that have also low reputation *)
    let bad_recall = !bad_low /. bad in 
    
    (* Computes bad boost: how much more likely is a revision of low reputation 
       to be bad. *)
    let bad_boost = low_bad_precision /. bad in 
    
    (* Now we must produce the table of results, as a big string *)

    (* Header *)
    Printf.fprintf out_ch "\nMutual information:     %6.5f" !mutual_info;
    Printf.fprintf out_ch "\nCoeff of constraint:    %6.5f" coeff_of_constraint; 
    Printf.fprintf out_ch "\nPrecision:              %6.5f" low_bad_precision; 
    Printf.fprintf out_ch "\nRecall:                 %6.5f" bad_recall; 
    Printf.fprintf out_ch "\nPrecision boost:        %6.5f" bad_boost; 

    (* Produces column sums to renormalize in the right way *)
    let col_tot = Array.make n_cols 0.0 in 
    for b_idx = 0 to n_bins - 1 do 
      for c_idx = 0 to n_cols - 1 do 
	col_tot.(c_idx) <- col_tot.(c_idx) +. wgt.(b_idx).(c_idx)
      done
    done; 
  
    Printf.fprintf out_ch "\n\nPercentage of normalized revisions below the specified quality";
    Printf.fprintf out_ch "\nBin     %%_data  %%<1.0   %%<0.8   %%<0.6   %%<0.4   %%<0.2   %%<0.0   %%<-0.2  %%<-0.4  %%<-0.6  %%<-0.8  %%<-1.0";
    for b_idx = 0 to n_bins - 1 do 
      begin
	Printf.fprintf out_ch "\n %2d    %6.3f" b_idx (100. *. wgt_of_bin.(b_idx)); 
	for c_idx = 0 to n_cols - 1 do 
	  Printf.fprintf out_ch "  %6.3f" (100. *. (self#normdiv wgt_below.(b_idx).(c_idx) wgt_of_bin.(b_idx))); 
	done
      end
    done; 
    
    Printf.fprintf out_ch "\n\nPercentage of normalized revisions of a given quality that belong to a reputaton range (cols sum to 1)";
    Printf.fprintf out_ch "\nBin     %%_data  %%<1.0   %%<0.8   %%<0.6   %%<0.4   %%<0.2   %%<0.0   %%<-0.2  %%<-0.4  %%<-0.6  %%<-0.8  %%<-1.0";
    for b_idx = 0 to n_bins - 1 do 
      begin
	Printf.fprintf out_ch "\n %2d    %6.3f" b_idx (100. *. wgt_of_bin.(b_idx)); 
	for c_idx = 0 to n_cols - 1 do 
	  Printf.fprintf out_ch "  %6.3f" (100. *. (self#normdiv wgt.(b_idx).(c_idx) col_tot.(c_idx))); 
	done
      end
    done; 

    Printf.fprintf out_ch "\n\nPercentage of revisions of a certain reputation that belong to a given quality (rows sum to 1)";
    Printf.fprintf out_ch "\nBin     %%_data  %%<1.0   %%<0.8   %%<0.6   %%<0.4   %%<0.2   %%<0.0   %%<-0.2  %%<-0.4  %%<-0.6  %%<-0.8  %%<-1.0";
    for b_idx = 0 to n_bins - 1 do 
      begin
	Printf.fprintf out_ch "\n %2d    %6.3f" b_idx (100. *. wgt_of_bin.(b_idx)); 
	for c_idx = 0 to n_cols - 1 do 
	  Printf.fprintf out_ch "  %6.3f" (100. *. (self#normdiv wgt.(b_idx).(c_idx) wgt_of_bin.(b_idx))); 
	done
      end
    done; 
    Printf.fprintf out_ch "\n"; 
    flush out_ch; 

    (* Now assembles the result *) 
    {
      stat_mutual_info = !mutual_info; 
      stat_entropy_good_bad = entrophy_good_bad; 
      stat_entropy_high_low = entrophy_high_low; 
      stat_coeff_constraint = coeff_of_constraint; 
      stat_bad_precision = low_bad_precision; 
      stat_bad_recall = bad_recall; 
      stat_bad_boost = bad_boost; 
      stat_total_weight = !total_weight;
      stat_bad_perc = bad *. 100.0;
    }

end;; (* object end *)


