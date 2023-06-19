<?php  

function getUser($useremail, $conn){
   $sql = "SELECT * FROM tbl_user_account 
           WHERE user_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$useremail]);

   if ($stmt->rowCount() === 1) {
   	 $user = $stmt->fetch();
   	 return $user;
   }else {
   	$user = [];
   	return $user;
   }
}