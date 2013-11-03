<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET['id'])) {
	echo "Error: No tournament ID supplied";
} else {

	$t_id = $_GET['id'];

?>
    <div class="row-fluid">
    <div class="span12">
	<?
	$result = $db->select("Tournament", "*",
		"TournamentID = $t_id")[0]; // get name, description, and rules
	echo "<h1>" . $result['Name'] . "</h1>"; // name
	echo "<p>" . $result['Description'] . "</p>"; // description
	echo "<h3>Rules:</h3><p>" . $result['Rules'] . "</p>";

	$participants =$tournament->getParticipants($t_id);
	//$matches =$tournament->getMatches($t_id);
	//print_r($participants);
	$num_participants = count($participants);

	?>
<canvas id="myCanvas" width="200" height="100" style="border:1px solid #d3d3d3;">
Your browser does not support the HTML5 canvas tag.</canvas>

<script>

var num_participants = <? echo $num_participants; ?>;
var c=document.getElementById("myCanvas");
var ctx=c.getContext("2d");
ctx.canvas.width  = window.innerWidth;
ctx.canvas.height = window.innerHeight;
ctx.moveTo(0,0);
ctx.lineTo(200,100);
ctx.stroke();

</script>
<?
	if($num_participants>0){
		echo "<h3>Current Participants:</h3>";

		if($num_participants==4){

		}
		foreach($participants as $val){
			echo "<li>";
			echo $val['Name'];
			echo "</li>\n";
		}	
	}
	else{
		echo "<h3>No Participants</h3>";
	}
}
?>

</div>
</div>
<?require_once("inc/footer.php")?>
