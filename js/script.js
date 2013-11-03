function submitResult(m_id, res){
    alert(res);
    $.ajax({
       url:'ajax/submit_match_result.php',
       type: 'POST',
       data:{MatchID : m_id , result : res },
       success: function (data){
           alert(data);
       }
        
    });
}

$(document).ready(function(){
    //alert("test");
});
