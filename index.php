<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Crawler</title>
	<link rel="icon" type="image/png" href="favicon.ico">	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>    
    
</head>
<body id="body">
	<script type="text/javascript">
		$(document).ready(function(){			
			getLink(1,1);	
		});
		function getLink(p, b){
			$.ajax({
                url: "crawler.php",
                type: "GET",
                async: false,
                data: {
                    p : p,
					b : b
                },
				error : function(){
		            getLink(p, b);			
				},
                success: function(data){
					$('#body').append("<hr>" + data);
					
					if(data.indexOf("end_cate") < 0){
							if(p < 50){ 								
								p++;
								
							}else{
								b++;	
								p = 1;
							}
							getLink(p, b);
					}		
					
					

                }
            });	

		}
	</script>	
</body>
</html>