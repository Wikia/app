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

val tmp_dir : string ref
(* swap file directory: the default is /tmp, but note that it is often
   the case that /tmp is not large enough for some huge images!! *)

val new_tmp_file_name : string -> string
(* [new_swap_file_name prefix] returns a new swap file name with
   prefix [prefix]. *)

val remove_tmp_file : string -> unit
(* [remove_tmp_file fname] removes [fname] if it can; nothing
   happens if [fname] cannot be removed. *)
