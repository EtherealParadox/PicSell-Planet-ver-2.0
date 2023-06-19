<?php 

function opened($id_1, $conn, $chats){
    foreach ($chats as $chat) {
    	if ($chat['message_status'] == 0) {
    		$opened = 1;
    		$chat_id = $chat['message_id'];

    		$sql = "UPDATE tbl_messages
    		        SET   message_status = ?
    		        WHERE sender_id=? 
    		        AND   receiver_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$opened, $id_1, $chat_id]);

    	}
    }
}