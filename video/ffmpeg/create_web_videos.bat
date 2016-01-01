:: http://www.computerhope.com/batch.htm

:: http://ffmpeg.org/ffmpeg.html#SEC7

:: http://backroom.bostonproductions.com/?p=378
::@echo ————————— >> "%~d1%~p1%convert.log"
::@echo Conversion for %1 started on %DATE% %TIME%  >> "%~d1%~p1%convert.log"
::@echo ————– DONE – SUCCESS ———————- >> "%~d1%~p1%convert.log"
::@echo ——————————– >> "%~d1%~p1%convert.log"
::@echo "%~d1%~p1%~n1.jpg" already exists >> "%~d1%~p1%convert.log"
::pause

::IF EXIST "%~d1%~p1%~n1.jpg" GOTO exit

:: The aspect ratio in examples is x/360, presumably 640x360

:: http://blogs.visigo.com/chriscoulson/encode-h-264-and-webm-videos-for-mediaelement-js-using-ffmpeg/
REM mp4 (H.264 / ACC)
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -vcodec libx264 -pix_fmt yuv420p -vprofile high -preset fast -b:v 300k -maxrate 500k -bufsize 1000k -vf scale=trunc(oh*a/2)*2:360 -r 30 -threads 0 -acodec libvo_aacenc -b:a 128k "%~d1%~p1%~n1.mpeg4.mp4"

:: http://notboring.org/devblog/2009/07/qt-faststartexe-binary-for-windows/
:: http://ffmpeg.zeranoe.com/blog/?p=59
:: http://www.stoimen.com/blog/2010/11/12/how-to-make-mp4-progressive-with-qt-faststart/
::"c:\program files\ffmpeg\bin\qt-faststart.exe" %1 "%~d1%~p1%~n1.qtfaststart%~x1"
"c:\program files\ffmpeg\bin\qt-faststart.exe" "%~d1%~p1%~n1.mpeg4.mp4" "%~d1%~p1%~n1.mpeg4_qtp.mp4"
move "%~d1%~p1%~n1.mpeg4_qtp.mp4" "%~d1%~p1%~n1.mpeg4.mp4"


REM webm (VP8 / Vorbis)
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -vcodec libvpx -quality good -cpu-used 5 -b:v 300k -maxrate 500k -bufsize 1000k -vf scale=trunc(oh*a/2)*2:360 -r 30 -threads 0 -acodec libvorbis -f webm "%~d1%~p1%~n1.webmvp8.webm"


REM ogv  (Theora / Vorbis)
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -vcodec libtheora -b:v 300k -maxrate 500k -bufsize 1000k -vf scale=trunc(oh*a/2)*2:360 -r 30 -threads 0 -acodec libvorbis "%~d1%~p1%~n1.theora.ogv"


REM jpeg (screenshot at 10 seconds, but just in case of a short video - take a screenshot earlier and overwrite)
"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 0 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 "%~d1%~p1%~n1.jpg"
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 1 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 %1.jpg
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 2 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 %1.jpg
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 3 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 %1.jpg
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 5 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 %1.jpg
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -ss 10 -vframes 1 -r 1 -vf scale=trunc(oh*a/2)*2:360 -f image2 %1.jpg

:: Batch
:: for /r %1 %%i in (*.wmv) do "c:\program files\ffmpeg\CreateWebVideos.bat" %%i



:: http://johndyer.name/ffmpeg-settings-for-html5-codecs-h264mp4-theoraogg-vp8webm/
REM mp4  (H.264 / ACC)
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -i %1 -b 1500k -vcodec libx264 -vpre slow -vpre baseline -g 30 -s 640x360 %1.mp4
REM webm (VP8 / Vorbis)
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -i %1 -b 1500k -vcodec libvpx -acodec libvorbis -ab 160000 -f webm -g 30 -s 640x360 %1.webm
REM ogv  (Theora / Vorbis)
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -i %1 -b 1500k -vcodec libtheora -acodec libvorbis -ab 160000 -g 30 -s 640x360 %1.ogv
REM jpeg (screenshot at 10 seconds)
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -i %1 -ss 00:10 -vframes 1 -r 1 -s 640x360 -f image2 %1.jpg


:: http://stackoverflow.com/questions/5487085/ffmpeg-covert-html-5-video-not-working






:: http://www.catswhocode.com/blog/19-ffmpeg-commands-for-all-needs
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libvorbis -ar 22050 -ac 1 -ab 48000 "%~d1%~p1%~n1.ogg"
::-acodec vorbis -aq 60 audio.ogg

::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libfaac -ar 22050 -ac 1 -ab 48000 "%~d1%~p1%~n1.aac"

:: avconv -i filename.mp4 filename.mp3
:: avconv -i video.mp4 -f mp3 -ab 192000 -vn music.mp3

"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libvorbis -ar 44100 -ab 128000 -ac 2 -metadata track=0 -f ogg -vn "%~d1%~p1%~n1.theora.ogg"

"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libmp3lame -ar 44100 -ab 128000 -ac 2 -metadata track=0 -f mp3 -vn "%~d1%~p1%~n1.mpeg3.mp3"