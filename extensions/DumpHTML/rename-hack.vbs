' Script to move a file to a multibyte filename
' Workaround for PHP 5's inadequacy
dim dirsToCreate(20)

source = Unescape( WScript.Arguments.Item( 0 ) )
dest = Unescape( WScript.Arguments.Item( 1 ) )
Set fso = CreateObject("Scripting.FileSystemObject")

' Create the destination directory
destDir = fso.GetParentFolderName( fso.GetAbsolutePathName( dest ) )
parent = destDir
numDirs = 0
While parent <> "" and not fso.FolderExists(parent)
	dirsToCreate(numDirs) = parent
	numDirs = numDirs + 1
	parent = fso.GetParentFolderName( parent )
Wend

For i = numDirs - 1 to 0 step -1
	fso.CreateFolder( dirsToCreate( i ) )
Next

' Remove the destination file if it exists already
if fso.FileExists( dest ) then
	fso.DeleteFile( dest )
end if

' Move the temporary file to its destination
fso.MoveFile source, dest

