<? include("conf/config.php");
includeHeader("View Tournament");
if(!isset($_GET['id'])) {
	echo "Error: No tournament ID supplied";
} else {

	$t_id = $_GET['id'];

	$result = $db->select("Tournament", "*",
		"TournamentID = $t_id")[0]; // get the goods

	$participants =$tournament->getParticipants($t_id);

	$matches =$tournament->getMatches($t_id);

	$num_participants = count($participants);

}
	?>
<canvas id="myCanvas" width="100%" height="100%">
Your browser does not support the HTML5 canvas tag.</canvas>

<script>

var num_participants = <? echo $num_participants; ?>;
var num_buckets = Math.pow(2,(Math.ceil(Math.log(num_participants)/Math.LN2)));

var c=document.getElementById("myCanvas");
var ctx=c.getContext("2d");
ctx.canvas.width  = window.innerWidth;
ctx.canvas.height = window.innerHeight;

ctx.font="40px Arial";
ctx.fillText("<? echo $result['Name']; ?>",window.innerWidth/2,50);

var players = new Array();

var player_height = ctx.canvas.height/num_buckets;
var player_width = 150;
	
	<? foreach($participants as $val){
		echo "players.push( '" . $val['Name'] . "');";
	}?>

//build structure
function drawLines(num_row,column){
	var row_height = (player_height * column);
	var start_height = (player_height * (column-1)*2) -(player_height*.5);


	if(num_row==1){
		ctx.fillText("Winner",player_width * column -150,start_height);
		ctx.moveTo(player_width * column-150, start_height);
		ctx.lineTo(player_width * (column +1),start_height);
		ctx.strokeStyle = '#ff0000';
		ctx.stroke();
	}
	else{
		//var row_height = start_height + (player_height * column);
		for(var i=0;i<num_row;i++){

			
			//start_height + (player_height * (i+.5)));
			ctx.strokeStyle = '#000000';
			ctx.moveTo(player_width * column-150,row_height*i);
			ctx.lineTo(player_width * (column+.5)-150,row_height*i);
			ctx.fillText(column,player_width * column-150,row_height*i);	
			ctx.fillText(row_height,player_width * column-150,row_height*i);	
			ctx.fillText(players[i*column],player_width * column-150,row_height*i);	

			//ctx.lineTo(player_width * (column+2)-150,start_height + (player_height * (i+.5)));
			ctx.stroke();
			//diaganol lines
			if (i%2==0) {
				ctx.lineTo(player_width * (column+1)-150,start_height + (row_height * (i+1.5)));
				ctx.stroke();	
			}else{
				ctx.lineTo(player_width * (column+1)-150,start_height + (row_height * (i-.5)));
				ctx.stroke();	
			}
		}
		drawLines(num_row/2,column+1);
	}
}
   
  window.requestAnimFrame = (function(callback) {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
    function(callback) {
      window.setTimeout(callback, 1000 / 60);
    };
  })();

  function animate() {
    var canvas = document.getElementById('myCanvas');
    var ctx = canvas.getContext('2d');

    // update

    // clear
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.canvas.width  = window.innerWidth;
	ctx.canvas.height = window.innerHeight;
    drawLines(num_buckets,1);
    // draw stuff

    // request new frame
    requestAnimFrame(function() {
      animate();
    });
  }
  animate();


</script>

<?require_once("inc/footer.php")?>
