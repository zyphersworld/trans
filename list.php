<?
	$book = "nw";
	$dir = "assets/html/$book/";
	$list = [];
	$json_data = [];
	$files = glob($dir . '/page*.{html}', GLOB_BRACE);

	foreach($files as $file) {
		array_push($list, basename($file));
	}

	// USE sort because it re-indexes array unlike natsort
	sort($list,SORT_NATURAL);

	foreach($list as $key => $entry){
		$pageNo = $key + 1;
		$filepath = "$dir" . "$entry";
		$json_data["master"]["page"]["page_".$pageNo]["filename"] = $entry;
		//$json_data["pages"]["$key"]["data"] = base64_encode( file_get_contents($filepath) );
		$json_data["master"]["page"]["page_".$pageNo]["data"] = rawurlencode(file_get_contents($filepath) );
		$json_data["translation"]["page"]["page_".$pageNo]["data"] = "This Should Be Page " . $key;
	}

	$cssMaster="";
	$cssfile = file_get_contents("assets/css/c_base.min.css");
	$cssMaster .= $cssfile;
	$cssfile = file_get_contents("assets/html/$book/bookstyle");
	$cssMaster .= $cssfile;
	$json_data["master"]["css"]= rawurlencode($cssMaster);


	//echo json_encode($json_data, JSON_FORCE_OBJECT);
	$contents = "var book = " . json_encode($json_data);

	if(!file_put_contents("assets/books/$book.js", $contents)){
		echo "FAILED";
	}else{
		echo "WRITTEN TO FILE.";
	}
?>
