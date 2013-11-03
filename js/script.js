function removeParticipant(part_id){
	alert(part_id);	
}

function submitResult(m_id, res){
    	$.ajax({
		url:'ajax/submit_match_result.php',
		type: 'POST',
		data: {MatchID :m_id ,result : res },
		success: function(data){
			//alert(data.toString());
			//data = data.toString();
			//alert(data.contains("SUCCESS"));
			//alert(.contains("SUCCESS"));
			if(data == "SUCCESS"){
				location.reload(true);
			}
			else{
				alert(data);
				alert("Something went wrong!!");
			}
			
		}
	});
}

$(document).ready(function(){
    //alert("test");
});
