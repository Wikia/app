$hwnd= WinGetHandle("[active]")
$ParetFolderPath = StringTrimRight ( @ScriptDir, StringLen ( "AutoitScripts" )  )
Local $file = $ParetFolderPath&"ImagesForUploadTests\image001.jpg"
ControlSetText($hwnd, "", "Edit1", $file )
ControlClick($hwnd, "", "button2")
Send ("{ENTER}")