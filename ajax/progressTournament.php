<?require_once("../conf/config.php");
if(isset($_POST['TournamentID']))
  $tournament->closeRegistration($_POST['TournamentID']);
?>
