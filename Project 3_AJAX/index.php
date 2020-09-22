<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
<style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
		img{
			width:100px;
			height:50px;
		}
</style>
<script>

$(document).ready(function(){
  $("#btn1").click(function(){
	  //alert();
	$.get("loadData.php", function(data, status){
	//alert("Data: " + data + "\nStatus: " + status);
	$("#div1").html(data);
    });
  });
});

</script>
</head>
<body>
<img src="pic1.jpg"/>
<button id="btn1">Send an HTTP GET request to a page and get the result back</button>
<div id="div1"></div>


</body>
</html>
