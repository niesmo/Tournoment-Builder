<? include('../conf/config.php');
if(isset($_GET['order']) && isset($_GET['round']) && isset($_GET['EntryID']) &&
	isset($_GET['TournamentID'])) {
	$totalEntries = $db->select("Entry", "COUNT(*)")[0][0];
	if($_GET['round'] < log($totalEntries, 2)) { // not final round
		$sister = db->select("`Match`", "EntryID1, EntryID2, Result", 
			"Round='$_GET[round]' AND `Order`=('_GET[order]'%2 == 0 ? " . // for even, go up one
			"_GET[order]+1 : _GET[order]-1)", "", "", "1"); // for odd, go down one
	
		if(!isempty($sister) && $sister['Result'] != "") { // if sister match has a result
			$sisterWinner = $sister[$sister['Result'] == "FIRST" ? 'EntryID1' : 'EntryID2'];
			db->insert("`Match`", "EntryID1, EntryID2, `Order`, Round", min($_GET['EntryID'],
			$sisterWinner) . ", " . max($_GET['EntryID'], $sisterWinner) . // sort entries
			", $_GET['order'] DIV 2, $_GET['round']+1"); // calc next order and round #s
		}
	} else { // final round
		db->update("Tournament", "Status='CLOSE'", "TournamentID='$_GET[TournamentID]'");
	}
} elseif($_GET['round'] == '0' && isset($_GET['TournamentID']) { // first round: gen all matches
	$totalEntries = $db->select("Entry", "COUNT(*)")[0][0];
	$bye = $totalEntries
	for($i=0;$i<floor($totalEntries/2);$i++) {
		
	
	
?>
