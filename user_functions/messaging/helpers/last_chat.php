<?php 

function lastChat($id_1, $id_2, $conn){
   
   $sql = "SELECT * FROM tbl_messages
           WHERE (sender_id=? AND receiver_id=?)
           OR    (receiver_id=? AND sender_id=?)
           ORDER BY message_id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_1, $id_2, $id_1, $id_2]);

    if ($stmt->rowCount() > 0) {
    	$chat = $stmt->fetch();
        (strlen($chat['message_content']) > 80 ) ? $msg = substr($chat['message_content'], 0, 80).'...' : $msg = $chat['message_content'];
    	return $msg;
    }else {
    	$chat = '';
    	return $chat;
    }
}

function lastRead($id_1, $id_2, $conn){
    $sql = "SELECT * FROM tbl_messages
        WHERE sender_id=? AND receiver_id=?
        ORDER BY message_id DESC LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_2, $id_1]);

    if ($stmt->rowCount() > 0) {
         $chat = $stmt->fetch();
         return $chat['message_status'];
    }else {
         $chat = '';
         return $chat;
}
}