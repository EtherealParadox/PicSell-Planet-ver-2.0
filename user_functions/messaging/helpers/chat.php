<?php 

function getChats($id_1, $id_2, $conn){
   
   $sql = "SELECT * FROM tbl_messages
           WHERE (sender_id=? AND receiver_id=?)
           OR    (receiver_id=? AND sender_id=?)
           ORDER BY message_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_1, $id_2, $id_1, $id_2]);

    if ($stmt->rowCount() > 0) {
    	$chats = $stmt->fetchAll();
    	return $chats;
    }else {
    	$chats = [];
    	return $chats;
    }

}