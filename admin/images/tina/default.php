<?php

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

// takes URL of image and Path for the image as parameter
function download_image($image_url, $image_file){
    $fp = fopen ($image_file, 'w+');              // open file handle

    $ch = curl_init($image_url);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // enable if you want
    curl_setopt($ch, CURLOPT_FILE, $fp);          // output to file
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000);      // some large value to allow curl to run for a long time
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    // curl_setopt($ch, CURLOPT_VERBOSE, true);   // Enable this line to see debug prints
    curl_exec($ch);

    curl_close($ch);                              // closing curl handle
    fclose($fp);                                  // closing file handle
}

//download_image("http://www.gravatar.com/avatar/10773ae6687b55736e171c038b4228d2", "local_image1.jpg");

for($i = 2; $i <= 160; $i+=2) {
	if($i < 10) {
		$i = '00'.$i;
	} else if ($i > 9 && $i < 100) {
		$i = '0'.$i;
	}
	
	download_image("http://www.avon.co.za/PRSuite/static/ebrochure/ebrochureC05_15_01/en_ZA/assets/images/medium/$i.jpg", "$i.jpg");
}
?>