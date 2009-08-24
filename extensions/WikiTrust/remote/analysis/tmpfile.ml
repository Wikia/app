(***********************************************************************)
(*                                                                     *)
(*                           Objective Caml                            *)
(*                                                                     *)
(*            François Pessaux, projet Cristal, INRIA Rocquencourt     *)
(*            Pierre Weis, projet Cristal, INRIA Rocquencourt          *)
(*            Jun Furuse, projet Cristal, INRIA Rocquencourt           *)
(*                                                                     *)
(*  Copyright 1999 - 2003                                              *)
(*  Institut National de Recherche en Informatique et en Automatique.  *)
(*  Distributed only by permission.                                    *)
(*                                                                     *)
(***********************************************************************)

(* temporary directory *)
let tmp_dir = ref (try Sys.getenv "CAMLTMPDIR" with Not_found -> "/tmp");;

let cnter = ref 0;;

let rec new_tmp_name prefx =
  incr cnter;
  let name =
    Filename.concat !tmp_dir
      (Printf.sprintf "camltmp-%s-%d" prefx !cnter) in
  if not (Sys.file_exists name) then name else begin
    prerr_endline ("Warning: tmp file " ^ name ^ " already exists");
    new_tmp_name prefx
  end;;

let remove_tmp_file tmpfile = try Sys.remove tmpfile with _ -> ();;

let new_tmp_file_name prefx =
  if not (Sys.file_exists !tmp_dir) then 
    failwith ("Temporary directory " ^ !tmp_dir ^ " does not exist") else
  let f = new_tmp_name prefx in
  at_exit (fun () -> remove_tmp_file f);
  f;;
