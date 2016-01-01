
:: http://www.catswhocode.com/blog/19-ffmpeg-commands-for-all-needs
::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libvorbis -ar 22050 -ac 1 -ab 48000 "%~d1%~p1%~n1.ogg"
::-acodec vorbis -aq 60 audio.ogg

::"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libfaac -ar 22050 -ac 1 -ab 48000 "%~d1%~p1%~n1.aac"

:: avconv -i filename.mp4 filename.mp3
:: avconv -i video.mp4 -f mp3 -ab 192000 -vn music.mp3

"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libvorbis -ar 44100 -ab 128000 -ac 2 -metadata track=0 -f ogg -vn "%~d1%~p1%~n1.theora.ogg"

"c:\program files\ffmpeg\bin\ffmpeg.exe" -y -i %1 -acodec libmp3lame -ar 44100 -ab 128000 -ac 2 -metadata track=0 -f mp3 -vn "%~d1%~p1%~n1.mpeg3.mp3"