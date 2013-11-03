function submitResult(m_id, res){
    	$.ajax({
		url:'ajax/submit_match_result.php',
		type: 'POST',
		data: {MatchID :m_id ,result : res },
		success: function(data){
			alert(data);
			alert(data.contains("SUCCESS"));
			//if(data.contains("SUCCESS") != -1){
			//	location.reload(true);
			//}
			//else{
		//		alert("Something went wrong!!");
		//	}
			
		}
	});
}

$(document).ready(function(){
    //alert("test");
});
