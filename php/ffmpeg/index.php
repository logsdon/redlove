<?php
/**
* Reference for FFmpeg
*
* @package RedLove
* @subpackage PHP
* @category Reference
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* @version 0.0.0
* 
* Resources: 
* FFmpeg - http://ffmpeg.org/
* 
* Usage: 
* 



* 
*/


//http://ffmpeg.org/ffmpeg-doc.html

// ffmpeg [[infile options][`-i' infile]]... {[outfile options] outfile}...
//$tmp = exec("c:\\Image\\gm.exe convert c:\\Image\\file1.tiff c:\\Image\\file1.jpg", $output, $return_var);
//$tmp = exec("C:\xampp\htdocs\ffmpeg_test\ffmpeg-0.5\ffmpeg.exe convert C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.mp4 C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.flv", $output, $return_var);
//$tmp = exec('C:\xampp\htdocs\ffmpeg_test\ffmpeg-0.5\ffmpeg -i C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.mp4 -vcodec copy -acodec copy C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.flv', $output, $return_var);

//exec($ffmpegPath . " -i " . $srcFile . " -ar 22050 -ab 32 -f flv -s 420 * 320 " . $destFile . " ",$op);

//@unlink('C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.flv');

$executable = 'C:\xampp\htdocs\ffmpeg_test\ffmpeg\ffmpeg';
$input_file = 'C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.mp4';
$output_file = 'C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.flv';
$video_options = '-f flv -vcodec flv -b 64k -r 24 -g 300 -s 320x240 -aspect 4:3';// -f flv -vcodec flv -b 64k -r 24 -g 300 -s 320x240 -aspect 4:3// -sameq// -qscale 31
$audio_options = '-acodec libmp3lame -ar 22050 -ab 8k -ac 1';// -ar 22050 -ab 64k -ac 1
// -pass 1 -passlogfile files/videos/temp/2pass-1
$command = $executable .' -i '. $input_file .' -y '. $video_options .' '. $audio_options .' '. $output_file;

echo $command;
$tmp = exec( $command, $output, $return_var );
//$tmp = exec( 'C:\xampp\htdocs\ffmpeg_test\ffmpeg-0.5\ffmpeg -i C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.mp4 -y -acodec copy -ar 22050 -ab 64k -ac 1 C:\xampp\htdocs\ffmpeg_test\sample_mpeg4.flv', $output, $return_var );

echo var_dump($output);
echo var_dump($return_var);
echo '<br>';


//http://stream0.org/2008/02/howto-extract-images-from-a-vi.html

// Image
$output_file = 'C:\xampp\htdocs\ffmpeg_test\sample_mpeg4_single-image%d.jpg';
$video_options = '-r 1 -ss 00:00:02 -t 00:00:00.001 -vframes 1 -s 640x480 -f image2';
$command = $executable .' -i '. $input_file .' -y '. $video_options .' '. $output_file;
$tmp = exec( $command, $output, $return_var );

echo var_dump($output);
echo var_dump($return_var);
echo '<br>';


// Multiple Images - one every second
$output_file = 'C:\xampp\htdocs\ffmpeg_test\sample_mpeg4-%03d.jpeg';
$video_options = '-r 1 -s 640x480 -f image2';// -ss 00:00:10 -t 00:00:00.001
$command = $executable .' -i '. $input_file .' -y '. $video_options .' '. $output_file;
$tmp = exec( $command, $output, $return_var );

echo var_dump($output);
echo var_dump($return_var);
echo '<br>';

