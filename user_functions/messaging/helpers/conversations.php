<?php 

function getConversation($user_id, $conn){
    /**
      Getting all the conversations 
      for current (logged in) user
    **/
    $sql = "SELECT * FROM tbl_messages_userlist
            WHERE sender_id=? OR receiver_id=?
            ORDER BY userlist_date DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $user_id]);

    if($stmt->rowCount() > 0){
        $conversations = $stmt->fetchAll();

        /**
          creating empty array to 
          store the user conversation
        **/
        $user_data = [];
        
        # looping through the conversations
        foreach($conversations as $conversation){
            # if conversations user_1 row equal to user_id
            if ($conversation['sender_id'] == $user_id) {
            	$sql2  = "SELECT *
            	          FROM tbl_user_account WHERE user_id=?";
            	$stmt2 = $conn->prepare($sql2);
            	$stmt2->execute([$conversation['receiver_id']]);
            }else {
            	$sql2  = "SELECT *
            	          FROM tbl_user_account WHERE user_id=?";
            	$stmt2 = $conn->prepare($sql2);
            	$stmt2->execute([$conversation['sender_id']]);
            }

            $allConversations = $stmt2->fetchAll();

            # pushing the data into the array 
            array_push($user_data, $allConversations[0]);
        }

        return $user_data;

    }else {
    	$conversations = [];
    	return $conversations;
    }  

}