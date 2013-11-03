<? include('../conf/config.php');
if(isset($_GET['round']) && isset($_GET['id'])) {
	$initialEntries = $db->select("Entry", "EntryID", "TournamentID=$_GET[id]")[0][0];
	print_r($initialEntries);
	if($_GET['round'] == '0') { // first round: gen from Entry
		gen_matches(0, merge($initialEntries, []));
	} else {
		if($db->select("`Match` as m , Entry as e", "COUNT(*)",
		"(e.EntryID = m.EntryID1 OR e.EntryID = m.EntryID2) AND 
		e.TournamentID = '$_GET[id]' AND m.Round = $_GET[round]-1 AND 
		m.Result != 'null'", "MatchID")[0][0] == 0) { // all results in from previous round

		}
	}
} else echo "round and/or id not found in request!";

function merge($a, $b) {
	$out = [];
	foreach($a as $array) foreach($array as $key => $value)	$out[] = $value;
	foreach($b as $array) foreach($array as $key => $value)	$out[] = $value;
	sort($out);
	return $out;
}

function gen_matches($round, $entryIDs) {
	echo "gen_matches called";
	print_r($entryIDs);
}
?>