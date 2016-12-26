<html>
    <body>
    <?php
	  
 class Emp {
      public $name = "";
      public $hobbies  = "";
      public $birthdate = "";
   }
	
   $e = new Emp();
   $e->name = "sachin";
   $e->hobbies  = "sports";
   $e->birthdate = "12:20:03 p";
   

   // echo json_encode($e);

   // echo json_encode($e);
	?>
<script>
	var dataToDownload = [['<?php echo json_encode($e); ?>']];
	 var str = '';
   

    function onDownload() {
    document.location = 'data:Application/octet-stream,' +
                         encodeURIComponent(data);
}

</script>
 
<a href="javascript:onDownload();">Download</a>
    </body>
</html>	