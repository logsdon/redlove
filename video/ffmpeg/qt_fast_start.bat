
:: http://notboring.org/devblog/2009/07/qt-faststartexe-binary-for-windows/
:: http://ffmpeg.zeranoe.com/blog/?p=59
:: http://www.stoimen.com/blog/2010/11/12/how-to-make-mp4-progressive-with-qt-faststart/

::"c:\program files\ffmpeg\bin\qt-faststart.exe" %1 "%~d1%~p1%~n1.qtfaststart%~x1"
"c:\program files\ffmpeg\bin\qt-faststart.exe" %1 "%~d1%~p1%~n1.qtfaststart%~x1"
::move "%1" "%~d1%~p1%~n1.original%~x1"
::move "%~d1%~p1%~n1.qtfaststart%~x1" "%1"
pause