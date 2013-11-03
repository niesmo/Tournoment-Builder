<? include('../conf/config.php');
if(isset($_POST['order']) && isset($_POST['round']) && isset($_POST['EntryID']) &&
	isset($_POST['TournamentID'])) {
	$totalEntries = $db->select("`Match`", "COUNT(*)", "Round='$_POST[round]'")[0][0];
	if($_POST['round'] < log($totalEntries, 2)) { // not final round
		$sister = db->select("`Match`", "EntryID1, EntryID2, Result", 
			"Round='$_POST[round]' AND `Order`=('_POST[order]'%2 == 0 ? " . // for even, go up one
			"_POST[order]+1 : _POST[order]-1)", "", "", "1"); // for odd, go down one
	
		if(!isempty($sister) && $sister['Result'] != "") { // if sister match has a result
			$sisterWinner = $sister[$sister['Result'] == "FIRST" ? 'EntryID1' : 'EntryID2'];
			db->insert("`Match`", "EntryID1, EntryID2, `Order`, Round", min($_POST['EntryID'],
			$sisterWinner) . ", " . max($_POST['EntryID'], $sisterWinner) . // sort entries
			", $_POST['order'] DIV 2, $_POST['round']+1"); // calc next order and round #s
		}
	} else { // final round
		db->update("Tournament", "Status='CLOSE'", "TournamentID='$_POST[TournamentID]'");
	}
} ?>
