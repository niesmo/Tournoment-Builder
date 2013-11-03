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
<canvas id="myCanvas" width="100%" height="100%">
Your browser does not support the HTML5 canvas tag.</canvas>

<script>

var num_participants = <? echo $num_participants; ?>;
var c=document.getElementById("myCanvas");
var ctx=c.getContext("2d");
ctx.canvas.width  = window.innerWidth;
ctx.canvas.height = window.innerHeight;
ctx.moveTo(window.innerWidth/2,window.innerHeight/2);
ctx.font="12px Arial";
ctx.fillText("Hello World",10,50);
if(num_participants==4){
	player_height = ctx.canvas.height/4;
	player_width = ctx.canvas.width/3;
	for(var i = 0;i<4;i++){
	ctx.moveTo(player_width * i,player_height * i);
	ctx.lineTo(player_width * (i+1),player_height * (i+1));
	ctx.stroke();		
	}
	
}

</script>
<?
	if($num_participants>0){
		echo "<h3>Current Participants:</h3>";

		if($num_participants==4){
			echo "<h3>4 Participants:</h3>";			
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
