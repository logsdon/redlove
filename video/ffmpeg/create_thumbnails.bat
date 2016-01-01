
:: http://blogs.visigo.com/chriscoulson/encode-h-264-and-webm-videos-for-mediaelement-js-using-ffmpeg/
REM mp4 (H.264 / ACC)
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -vcodec libx264 -profile:v baseline -level 3.0 -pix_fmt yuv420p -vprofile high -preset fast -b:v 200k -minrate 200k -maxrate 300k -bufsize 1000k -vf scale=trunc(oh*a/2)*2:360 -r 30 -threads 0 -acodec libvo_aacenc -ab 128000 -ar 44100 -ac 2 "%~d1%~p1%~n1.mpeg4.mp4"

:: http://notboring.org/devblog/2009/07/qt-faststartexe-binary-for-windows/
:: http://ffmpeg.zeranoe.com/blog/?p=59
:: http://www.stoimen.com/blog/2010/11/12/how-to-make-mp4-progressive-with-qt-faststart/
::"c:\program files\ffmpeg\bin\qt-faststart.exe" %1 "%~d1%~p1%~n1.qtfaststart%~x1"
"c:\program files\ffmpeg\bin\qt-faststart.exe" "%~d1%~p1%~n1.mpeg4.mp4" "%~d1%~p1%~n1.mpeg4_qtp.mp4"
move "%~d1%~p1%~n1.mpeg4_qtp.mp4" "%~d1%~p1%~n1.mpeg4.mp4"



REM jpeg (screenshot at 10 seconds, but just in case of a short video - take a screenshot earlier and overwrite)
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 0 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 "%~d1%~p1%~n1.0.jpg"
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 1 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 "%~d1%~p1%~n1.1.jpg"
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 2 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 "%~d1%~p1%~n1.2.jpg"
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 3 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 "%~d1%~p1%~n1.3.jpg"
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 5 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 "%~d1%~p1%~n1.5.jpg"
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 10 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 "%~d1%~p1%~n1.10.jpg"

