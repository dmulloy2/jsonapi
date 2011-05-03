<?php

$input_files = array_merge(array(realpath("../src/methods.json")), glob("../test/plugins/JSONAPI/methods/*.json"));
$data = array();
foreach($input_files as $input_file) {
	$json = json_decode(file_get_contents($input_file), true);
	$namespace = $json['namespace'];
	
	$methods = array();
	foreach($json["methods"] as $k => $v) {
		$methods[] = array(
			"name" => (empty($namespace) ? "" : $namespace.".").$v['name'],
			"desc" => $v['desc'],
			"args" => $v['args'],
			"doclink" => rawurlencode($v['call'])
		);
	}
	
	$data[] = array(
		"name" => $json['name'],
		"methods" => $methods
	);
}

usort($data, function ($v1, $v2) {
	return strcmp($v1['name'], $v2['name']);
});

echo json_encode($data);