<?php
// Caching disable headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Output as a GIF image
header ('Content-type:image/gif');

// Include the GIFGenerator class
include('../GIFGenerator.class.php');

// Initialize a new GIFGenerator object
$gif = new GIFGenerator();

// Get pending time till next new year
$now = new DateTime();
$year = date("Y")+1;
$future_date = new DateTime($year.'-01-01 00:00:00');
$interval = $future_date->diff($now);

// Create a multidimensional array with all the image frames
$imageFrames = array('repeat' => false, 'frames' => array());

for ($i=1; $i<30; $i++){

	$clockParts = array(
		'd' => $interval->format("%a"),
		'h' => $interval->format("%h"),
		'm' => $interval->format("%i"),
		's' => $interval->format("%s")
	);

	$textDefaults = array(
					'font-size' => 24,
					'angle' => 0,
					'font-color' => '#000',
					'y-position' => 130
					);

	$imageFrames['frames'][$i] = array('image'=>null,'delay'=>null);
	$imageFrames['frames'][$i]['image'] = '../images/newyear_count.jpg';
	$imageFrames['frames'][$i]['delay'] = 100;

	foreach($clockParts as $key => $value){
		$imageFrames['frames'][$i]['text'][$key] = $textDefaults;
		$imageFrames['frames'][$i]['text'][$key]['text'] = $value;
	}

	$imageFrames['frames'][$i]['text']['d']['x-position'] = ($clockParts['d'] < 10) ? 101 : 91;
	$imageFrames['frames'][$i]['text']['h']['x-position'] = ($clockParts['h'] < 10) ? 227 : 217;
	$imageFrames['frames'][$i]['text']['m']['x-position'] = ($clockParts['m'] < 10) ? 352 : 342;
	$imageFrames['frames'][$i]['text']['s']['x-position'] = ($clockParts['s'] < 10) ? 479 : 469;

	// // And again..
	$future_date = $future_date->modify("-1 second");
	$interval = $future_date->diff($now);
}

echo $gif->generate($imageFrames);
?>