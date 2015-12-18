<?php

	$curl=curl_init("https://api.github.com/repos/tunapanda/TI-wp-content-theme/issues?state=closed&labels=resolved");
	curl_setopt($curl,CURLOPT_USERPWD,file_get_contents(".githubuserpwd"));
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($curl,CURLOPT_HTTPHEADER,array(
		"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1521.3 Safari/537.36"
	));

	$res=curl_exec($curl);
	$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);

	if ($code!=200)
		exit("error: $code\n$res");

	if (!$res)
		exit("unable to fetch data from github");

	//$res=file_get_contents("test.json");
	$issues=json_decode($res,TRUE);
	$now=time();

	$count=0;
	foreach ($issues as $issue) {
		$issue_t=strtotime($issue["closed_at"]);

		if ($issue_t>=$now-60*60*24*7)
			$count++;
	}

	$ret=array(
		"resolved"=>array(
			"type"=>"integer",
			"value"=>$count,
			"label"=>"Resolved issues last 7 days",
			"strategy"=>"interval"
		)
	);

	echo json_encode($ret,JSON_PRETTY_PRINT);