<?php
//http://stackoverflow.com/questions/5853380/php-get-number-of-week-for-month
$day = time(); // or whatever unix timestamp, etc//$date += 86400; //For weeks starting on Sunday
$week_num_in_month = date('W', $day) - date('W', strtotime(date('Y-m-01', $day))) + 1;

echo $week_num_in_month;

?>
USE THIS!
<?php
foreach (range(1, 30) as $day) {
    $test_date = "2013-06-" . str_pad($day, 2, '0', STR_PAD_LEFT);
    echo "$test_date - ";
    echo week_of_month($test_date) . "\n" . '<br />';
}

function week_of_month( $date )
{
	if ( ! is_string($date) ) $date = date('Y-m-d', $date);
	$date_parts = explode('-', $date);
	$date_parts[2] = '01';
	$first_of_month = implode('-', $date_parts);
	$day_of_first = date('N', strtotime($first_of_month));
	$day_of_month = date('j', strtotime($date));
	return floor(($day_of_first + $day_of_month - 1) / 7) + 1;
}
?>