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



(** Here are functions that have to do with time *)

open Unix;;

(** Converts a time as Y,M,D,h,m,s to time as float *)
let time_to_float (year: int) (month: int) (day: int) (hour: int) (minute: int) (second: int) : float = 
  let tmrec = {
    tm_sec = second; 
    tm_min = minute; 
    tm_hour = hour; 
    tm_mday = day; 
    tm_mon = month - 1; 
    tm_year = year - 1900; 
    (* these are bogus *)
    tm_wday = 0; 
    tm_yday = 0; 
    tm_isdst = false
  } in 
  let (time_float, _) = Unix.mktime tmrec in 
  time_float

(** Converts a time as a string yyyymmddhhmmss to a time as a floating point.
    This type of time strings is found in the database. *)
let time_string_to_float (s: string) : float = 
  let yy = int_of_string (String.sub s  0 4) in 
  let mm = int_of_string (String.sub s  4 2) in 
  let dd = int_of_string (String.sub s  6 2) in 
  let h  = int_of_string (String.sub s  8 2) in 
  let m  = int_of_string (String.sub s 10 2) in 
  let s  = int_of_string (String.sub s 12 2) in 
  time_to_float yy mm dd h m s

(** Converts a time as a string yyyymmddhhmmss to a time as a timestamp.
    This type of time strings is found in the database. *)
let time_string_to_timestamp (s: string) : (int * int * int * int * int * int) = 
  let yy = int_of_string (String.sub s  0 4) in 
  let mm = int_of_string (String.sub s  4 2) in 
  let dd = int_of_string (String.sub s  6 2) in 
  let h  = int_of_string (String.sub s  8 2) in 
  let m  = int_of_string (String.sub s 10 2) in 
  let s  = int_of_string (String.sub s 12 2) in 
  (yy, mm, dd, h, m, s)


(** Compare two times as float, i.e. for sorting purposes *)
let cmp (t1: float) (t2: float) : int = compare t1 t2

(** Gets the time of a float *)
let float_to_time f = 
  let tm = Unix.localtime f in 
  ((1900 + tm.tm_year), (1 + tm.tm_mon), tm.tm_mday, tm.tm_hour, tm.tm_min, tm.tm_sec);;

(* Conversion of time in xml dump *)
let convert_time str =
  let year   = (try (int_of_string 
			(try (String.sub str  0 4) with (Invalid_argument "String.sub") -> "0")) 
    with (Failure "int_of_string") -> 0) in
  let month  = (try (int_of_string
			(try (String.sub str  5 2) with (Invalid_argument "String.sub") -> "0")) 
    with (Failure "int_of_string") -> 0) in
  let day    = (try (int_of_string 
			(try (String.sub str  8 2) with (Invalid_argument "String.sub") -> "0")) 
    with (Failure "int_of_string") -> 0) in
  let hour   = (try (int_of_string 
			(try (String.sub str 11 2) with (Invalid_argument "String.sub") -> "0")) 
    with (Failure "int_of_string") -> 0) in
  let minute = (try (int_of_string 
			(try (String.sub str 14 2) with (Invalid_argument "String.sub") -> "0")) 
    with (Failure "int_of_string") -> 0) in
  let second = (try (int_of_string 
			(try (String.sub str 17 2) with (Invalid_argument "String.sub") -> "0")) 
    with (Failure "int_of_string") -> 0) in
  time_to_float year month day hour minute second;;

(* Testing *)
if false then begin 
  let (y, m, d, hh, mm, ss) = float_to_time (time_to_float 2007 06 05 09 43 12) in 
  Printf.printf "%d/%d/%d %d:%d:%d\n" d m y hh mm ss
end;;

