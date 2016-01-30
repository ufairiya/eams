// JavaScript Document

	function addParam(url, param, value) {
    var a = document.createElement('a');
    a.href = url;
    a.search += a.search.substring(0,1) == "?" ? "&" : "?";
    a.search += encodeURIComponent(param);
    if (value)
        a.search += "=" + encodeURIComponent(value);
    return a.href;
}
function deleteBox(id,data,msg) {
	if(msg == 'Move')
	{
	var msg1 = 'Move to trash ?';
	}
	else
	{
	msg1 = 'Are you sure you want to Permenantly Delete ?';
	}
 if (confirm(msg1))
  {
   
     var dataString = 'data='+data+'&did='+id+'&msg='+msg;
	$("#flash_"+id).show();
    $("#flash_"+id).fadeIn(400).html('<img src="assets/img/ajax-loader.gif"/>');
    $.ajax({
           type: "POST",
           url: "delete.php",
           data: dataString,
           cache: false,
           success: function(result){
		            if(result){
					url = document.URL.split("?")[0];
					if(result == 0)
					{
						var resultss = addParam(url, "msg", "error");	
				        window.location.href = resultss;
					}
					else if(result == 1)
					{
						 var resultss = addParam(url, "msg", "delsuccess");	
				        window.location.href = resultss;
					}
					else if(result == 2)
					{
						 var resultss = addParam(url, "msg", "undelsuccess");	
				        window.location.href = resultss;
					}
					else if(result == 3)
					{
						 var resultss = addParam(url, "msg", "trashsuccess");	
				        window.location.href = resultss;
					}
					
					else
					{
						 window.location.href = url;
					}
					
				}
            }
        });
     }
 
}