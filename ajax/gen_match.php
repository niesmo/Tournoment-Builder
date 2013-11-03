<? include('../conf/config.php');
if(isset($_GET['round']) && isset($_GET['id'])) {
	echo "found data from request";
} else echo "round and/or id not found in request!";

private function merge($a, $b) {
	$out = [];
	foreach($a as $array) foreach($array as $key => $value)	$out[] = $value;
	foreach($b as $array) foreach($array as $key => $value)	$out[] = $value;
	sort($out);
	return $out;
}

private function gen_matches($round, $entryIDs) {
	print_r($entryIDs);
}
?>
