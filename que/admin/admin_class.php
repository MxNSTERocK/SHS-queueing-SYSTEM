<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function login()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where status = 1 and username = '" . $username . "' and password = '" . md5($password) . " ' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	function save_user()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if (!empty($password))
			$data .= ", password = '" . md5($password) . "' ";
		$data .= ", type = '$type' ";
		$data .= ", status =  1 ";

		$data .= ", window_id = '$window_id' ";

		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' ")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}

		if (empty($id)) {
			if (!$name == NULL and !$username == NULL and !$password == NULL) {

				$save = $this->db->query("INSERT INTO users set " . $data);
			}
		} else {
			if (!$name == NULL and !$username == NULL) {
				$save = $this->db->query("UPDATE users set " . $data . " where id = " . $id);
			}
		}
		if ($save) {
			return 1;
		}
	}

	function delete_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = " . $id);
		if ($delete)
			return 1;
	}
	function signup()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '" . md5($password) . "' ";
		$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
		$save = $this->db->query("INSERT INTO users set " . $data);
		if ($save) {
			$qry = $this->db->query("SELECT * FROM users where username = '" . $email . "' and password = '" . md5($password) . "' ");
			if ($qry->num_rows > 0) {
				foreach ($qry->fetch_array() as $key => $value) {
					if ($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_' . $key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings()
	{
		extract($_POST);
		$data = " name = '" . str_replace("'", "&#x2019;", $name) . "' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '" . htmlentities(str_replace("'", "&#x2019;", $about)) . "' ";
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/img/' . $fname);
			$data .= ", cover_img = '$fname' ";
		}

		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if ($chk->num_rows > 0) {
			$save = $this->db->query("UPDATE system_settings set " . $data);
		} else {
			$save = $this->db->query("INSERT INTO system_settings set " . $data);
		}
		if ($save) {
			$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
			foreach ($query as $key => $value) {
				if (!is_numeric($key))
					$_SESSION['setting_' . $key] = $value;
			}

			return 1;
		}
	}


	function save_transaction()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$cwhere = '';
		if (!empty($id)) {
			$cwhere = " and id != $id ";
		}
		$chk =  $this->db->query("SELECT * FROM transactions where " . $data . $cwhere)->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO transactions set " . $data);
		} else {
			$save = $this->db->query("UPDATE transactions set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	function delete_transaction()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM transactions where id = " . $id);
		if ($delete)
			return 1;
	}

	function save_window()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", transaction_id = '$transaction_id' ";
		$cwhere = '';
		if (!empty($id)) {
			$cwhere = " and id != $id ";
		}
		$chk =  $this->db->query("SELECT * FROM transaction_windows where name = '$name' and transaction_id = '$transaction_id' " . $cwhere)->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO transaction_windows set " . $data);
		} else {
			$save = $this->db->query("UPDATE transaction_windows set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	function delete_window()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM transaction_windows where id = " . $id);
		if ($delete)
			return 1;
	}
	function save_uploads()
	{
		extract($_POST);
		$ids = array();
		for ($i = 0; $i < count($img); $i++) {
			list($type, $img[$i]) = explode(';', $img[$i]);
			list(, $img[$i])      = explode(',', $img[$i]);
			$img[$i] = str_replace(' ', '+', $img[$i]);
			$img[$i] = base64_decode($img[$i]);
			$fname = strtotime(date('Y-m-d H:i')) . "_" . $imgName[$i];
			// $upload = move_uploaded_file($fname,$img[$i],"assets/uploads/");
			$upload = file_put_contents("assets/uploads/" . $fname, $img[$i]);
			$data = " file_path = '" . $fname . "' ";
			if ($upload)
				$save[] = $this->db->query("INSERT INTO file_uploads set" . $data);
			else {
				echo "INSERT INTO file_uploads set" . $data;
				exit;
			}
		}
		if (isset($save)) {
			return 1;
		}
	}
	function delete_uploads()
	{
		extract($_POST);
		$path = $this->db->query("SELECT file_path FROM file_uploads where id = " . $id)->fetch_array()['file_path'];
		$delete = $this->db->query("DELETE FROM file_uploads where id = " . $id);
		if ($delete)
			unlink('assets/uploads/' . $path);
		return 1;
	}

	function save_queue()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", transaction_id = '$transaction_id' ";

		$queue_no = 01;

		$chk = $this->db->query("SELECT * FROM queue_list where transaction_id = $transaction_id and date(date_created) = '" . date("Y-m-d") . "' ")->num_rows;
		if ($chk > 0) {
			$queue_no += $chk;
		}
		$data .= ", queue_no = '$queue_no' ";

		$save = $this->db->query("INSERT INTO queue_list set " . $data);

		if ($save)
			return $this->db->insert_id;
	}

	function get_queue()
	{
		extract($_POST);
		$query = $this->db->query("SELECT q.*,t.name as wname FROM queue_list q inner join transaction_windows t on t.id = q.window_id where date(q.date_created) = '" . date('Y-m-d') . "' and q.transaction_id = '$id' and q.status = 1 order by q.id desc limit 1 ");
		if ($query->num_rows > 0) {
			foreach ($query->fetch_array() as $key => $value) {
				if (!is_numeric($key))
					$data[$key] = $value;
			}
			return json_encode(array('status' => 1, "data" => $data));
		} else {
			return json_encode(array('status' => 0));
		}
	}

	// OLD CODES WORKING

	// function update_queue()
	// {
	// 	$tid = $this->db->query("SELECT * FROM transaction_windows where id =" . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];

	// 	$this->db->query("UPDATE queue_list set status = 1 , window_id = '" . $_SESSION['login_window_id'] . "' where transaction_id = '$tid' and  date(date_created) = '" . date('Y-m-d') . "' and status=0 order by id asc limit 1");

	// 	$query = $this->db->query("SELECT q.*,t.name as wname FROM queue_list q inner join transaction_windows t on t.id = q.window_id where date(q.date_created) = '" . date('Y-m-d') . "' and q.window_id = '" . $_SESSION['login_window_id'] . "' and q.status = 1 order by q.id desc limit 1  ");
	// 	if ($query->num_rows > 0) {
	// 		foreach ($query->fetch_array() as $key => $value) {
	// 			if (!is_numeric($key))
	// 				$data[$key] = $value;
	// 		}
	// 		return json_encode(array('status' => 1, "data" => $data));
	// 	} else {
	// 		return json_encode(array('status' => 0));
	// 	}
	// }



	// THIS CODE IS WORKING BUT NEED A LITTLE CHANGES 
	// NOT FETCHING THE PREVIOUS COLUMN

	// function update_queue()
	// {
	// 	$tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];
	
	// 	// Get the last selected queue number
	// 	$lastQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 1 ORDER BY id DESC LIMIT 1");
	
	// 	if ($lastQueueQuery->num_rows > 0) {
	// 		$lastQueue = $lastQueueQuery->fetch_assoc();
	// 		$lastQueueId = $lastQueue['id'];
	// 	} else {
	// 		$lastQueueId = 0;
	// 	}
	
	// 	// Check if there are any remaining queue numbers with status 0
	// 	$remainingQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 AND id > $lastQueueId ORDER BY id ASC LIMIT 1");
	
	// 	if ($remainingQueueQuery->num_rows > 0) {
	// 		// Fetch the next available queue number with status 0
	// 		$nextQueue = $remainingQueueQuery->fetch_assoc();
			
	// 		// Update the status and window_id for the next available queue number
	// 		$queueId = $nextQueue['id'];
	// 		$this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $queueId");
			
	// 		return json_encode(array('status' => 1, 'data' => $nextQueue));
	// 	} else {
	// 		// Reset the status of all queue numbers to 0
	// 		$this->db->query("UPDATE queue_list SET status = 0 WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "'");
			
	// 		// Fetch the first queue number with status 0
	// 		$firstQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 ORDER BY id ASC LIMIT 1");
			
	// 		if ($firstQueueQuery->num_rows > 0) {
	// 			$firstQueue = $firstQueueQuery->fetch_assoc();
				
	// 			// Update the status and window_id for the first queue number
	// 			$firstQueueId = $firstQueue['id'];
	// 			$this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $firstQueueId");
				
	// 			return json_encode(array('status' => 1, 'data' => $firstQueue));
	// 		} else {
	// 			return json_encode(array('status' => 0));
	// 		}
	// 	}
	// }

	// WORKING BUT NEED SOME CHANGES IN THE LAST COLUMN 
	// RESETTING STATUS TO 0 IF THE LAST COLUMN FETCH
	

// 	function update_queue()
// {
//     $tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];

//     // Get the last selected queue number
//     $lastQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 1 ORDER BY id DESC LIMIT 1");

//     if ($lastQueueQuery->num_rows > 0) {
//         $lastQueue = $lastQueueQuery->fetch_assoc();
//         $lastQueueId = $lastQueue['id'];
//     } else {
//         $lastQueueId = 0;
//     }

//     // Check if there are any remaining queue numbers with status 0
//     $remainingQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 AND id > $lastQueueId ORDER BY id ASC LIMIT 1");

//     if ($remainingQueueQuery->num_rows > 0) {
//         // Fetch the next available queue number with status 0
//         $nextQueue = $remainingQueueQuery->fetch_assoc();
        
//         // Update the status and window_id for the next available queue number
//         $queueId = $nextQueue['id'];
//         $this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $queueId");
        
//         return json_encode(array('status' => 1, 'data' => $nextQueue));
//     } else {
//         // Reset the status of all queue numbers to 0
//         $this->db->query("UPDATE queue_list SET status = 0 WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "'");
        
//         // Fetch the first queue number with status 0
//         $firstQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 ORDER BY id ASC LIMIT 1");
        
//         if ($firstQueueQuery->num_rows > 0) {
//             $firstQueue = $firstQueueQuery->fetch_assoc();
            
//             // Update the status and window_id for the first queue number
//             $firstQueueId = $firstQueue['id'];
//             $this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $firstQueueId");
            
//             return json_encode(array('status' => 1, 'data' => $firstQueue));
//         } else {
//             return json_encode(array('status' => 0));
//         }
//     }
// }

// WORKING GOOD BUT IN THE LAST COLUMN IT RESET TO 0

// function update_queue()
// {
//     $tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];

//     // Get the last selected queue number
//     $lastQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 1 ORDER BY id DESC LIMIT 1");

//     if ($lastQueueQuery->num_rows > 0) {
//         $lastQueue = $lastQueueQuery->fetch_assoc();
//         $lastQueueId = $lastQueue['id'];
//     } else {
//         $lastQueueId = 0;
//     }

//     // Check if there are any remaining queue numbers with status 0
//     $remainingQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 AND id > $lastQueueId ORDER BY id ASC LIMIT 1");

//     if ($remainingQueueQuery->num_rows > 0) {
//         // Fetch the next available queue number with status 0
//         $nextQueue = $remainingQueueQuery->fetch_assoc();
        
//         // Update the status and window_id for the next available queue number
//         $queueId = $nextQueue['id'];
//         $this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $queueId");
        
//         return json_encode(array('status' => 1, 'data' => $nextQueue));
//     } else {
//         if ($lastQueueId > 0) {
//             // Reset the status of the last queue number to 0
//             $this->db->query("UPDATE queue_list SET status = 0 WHERE id = $lastQueueId");
//         }
        
//         // Fetch the first queue number with status 0
//         $firstQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 ORDER BY id ASC LIMIT 1");
        
//         if ($firstQueueQuery->num_rows > 0) {
//             $firstQueue = $firstQueueQuery->fetch_assoc();
            
//             // Update the status and window_id for the first queue number
//             $firstQueueId = $firstQueue['id'];
//             $this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $firstQueueId");
            
//             return json_encode(array('status' => 1, 'data' => $firstQueue));
//         } else {
//             return json_encode(array('status' => 0));
//         }
//     }
// }


// WORKING FINE. FINAL GOOD NO CHANGES AS OF NOW

function update_queue()
{
    $tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];

    // Get the last selected queue number
    $lastQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 1 ORDER BY id DESC LIMIT 1");

    if ($lastQueueQuery->num_rows > 0) {
        $lastQueue = $lastQueueQuery->fetch_assoc();
        $lastQueueId = $lastQueue['id'];
    } else {
        $lastQueueId = 0;
    }

    // Check if there are any remaining queue numbers with status 0
    $remainingQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 AND id > $lastQueueId ORDER BY id ASC LIMIT 1");

    if ($remainingQueueQuery->num_rows > 0) {
        // Fetch the next available queue number with status 0
        $nextQueue = $remainingQueueQuery->fetch_assoc();
        
        // Update the status and window_id for the next available queue number
        $queueId = $nextQueue['id'];
        $this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $queueId");
        
        return json_encode(array('status' => 1, 'data' => $nextQueue));
    } else {
        // Fetch the first queue number with status 0
        $firstQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 ORDER BY id ASC LIMIT 1");
        
        if ($firstQueueQuery->num_rows > 0) {
            $firstQueue = $firstQueueQuery->fetch_assoc();
            
            // Update the status and window_id for the first queue number
            $firstQueueId = $firstQueue['id'];
            $this->db->query("UPDATE queue_list SET status = 1, window_id = '" . $_SESSION['login_window_id'] . "' WHERE id = $firstQueueId");
            
            return json_encode(array('status' => 1, 'data' => $firstQueue));
        } else {
            return json_encode(array('status' => 0));
        }
    }
}



	
	
	
	
	










	///////

	///////

	//  WORKING GOOD BUT NEED SOME CHANGES SPECIALLY IN UPDATING STATUS
	// 	WHEN UPDATING STATUS ALWAYS UPDATING THE FIRST COLUMN NOT THE CURRENT DATA

	// function pending_queue()
	// {
	// 	$tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];
	// 	$currentQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 1 ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();
	// 	if ($currentQueue) {
	// 		$currentQueueNo = $currentQueue['queue_no'];
	// 		$this->db->query("UPDATE queue_list SET status = 0 WHERE queue_no = " . $currentQueueNo);
	// 		$nextQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 0 AND queue_no > " . $currentQueueNo . " ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();
	// 		if ($nextQueue) {
	// 			$nextQueueNo = $nextQueue['queue_no'];
	// 			$this->db->query("UPDATE queue_list SET status = 1 WHERE queue_no = " . $nextQueueNo);
	// 			$nextQueue = $this->db->query("SELECT * FROM queue_list WHERE queue_no = " . $nextQueueNo)->fetch_assoc();
	// 			return json_encode(array('status' => 1, 'data' => $nextQueue));
	// 		} else {
	// 			$firstQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 0 ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();
	// 			if ($firstQueue) {
	// 				$firstQueueNo = $firstQueue['queue_no'];
	// 				$this->db->query("UPDATE queue_list SET status = 1 WHERE queue_no = " . $firstQueueNo);
	// 				$firstQueue = $this->db->query("SELECT * FROM queue_list WHERE queue_no = " . $firstQueueNo)->fetch_assoc();
	// 				return json_encode(array('status' => 1, 'data' => $firstQueue));
	// 			}
	// 		}
	// 	}
	// 	return json_encode(array('status' => 0, 'message' => 'No more pending queues!'));
	// }


// 	function pending_queue()
// {
//     $tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];
//     $currentQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 1 ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();
//     if ($currentQueue) {
//         $currentQueueNo = $currentQueue['queue_no'];
//         $this->db->query("UPDATE queue_list SET status = 0 WHERE queue_no = " . $currentQueueNo);
//         $nextQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 0 AND queue_no > " . $currentQueueNo . " ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();  
//         if ($nextQueue) {
//             $nextQueueNo = $nextQueue['queue_no'];
//             $this->db->query("UPDATE queue_list SET status = 1 WHERE queue_no = " . $nextQueueNo);
//             $nextQueue = $this->db->query("SELECT * FROM queue_list WHERE queue_no = " . $nextQueueNo)->fetch_assoc();
//             return json_encode(array('status' => 1, 'data' => $nextQueue));
//         } else {
//             $firstQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 0 ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();
//             if ($firstQueue) {
//                 $firstQueueNo = $firstQueue['queue_no'];
//                 $this->db->query("UPDATE queue_list SET status = 1 WHERE queue_no = " . $firstQueueNo);
//                 $firstQueue = $this->db->query("SELECT * FROM queue_list WHERE queue_no = " . $firstQueueNo)->fetch_assoc();
//                 return json_encode(array('status' => 1, 'data' => $firstQueue));
//             }
//         }
//     }
//     return json_encode(array('status' => 0, 'message' => 'No more pending queues!'));
// }

// function pending_queue()
// {
//     $tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];
//     $currentQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 1 ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();
//     if ($currentQueue) {
//         $currentQueueNo = $currentQueue['queue_no'];
//         $this->db->query("UPDATE queue_list SET status = 0 WHERE transaction_id = '$tid' AND queue_no = " . $currentQueueNo);
//         $nextQueue = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND status = 0 AND queue_no > " . $currentQueueNo . " ORDER BY queue_no ASC LIMIT 1")->fetch_assoc();  
//         if ($nextQueue) {
//             $nextQueueNo = $nextQueue['queue_no'];
//             $this->db->query("UPDATE queue_list SET status = 1 WHERE transaction_id = '$tid' AND queue_no = " . $nextQueueNo);
//             $nextQueue['status'] = 0;
//             return json_encode(array('status' => 1, 'data' => $nextQueue));
//         } else {
//             $this->db->query("UPDATE queue_list SET status = 1 WHERE transaction_id = '$tid' AND queue_no = " . $currentQueueNo);
//             $currentQueue['status'] = 0;
//             return json_encode(array('status' => 1, 'data' => $currentQueue));
//         }
//     }
//     return json_encode(array('status' => 0, 'message' => 'No more pending queues!'));
// }

function pending_queue()
{
    $tid = $this->db->query("SELECT * FROM transaction_windows WHERE id = " . $_SESSION['login_window_id'])->fetch_array()['transaction_id'];

    // Get the last selected queue number
    $lastQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 1 ORDER BY id DESC LIMIT 1");

    if ($lastQueueQuery->num_rows > 0) {
        $lastQueue = $lastQueueQuery->fetch_assoc();
        $lastQueueId = $lastQueue['id'];

        // Update the status of the last selected queue number to 0
        $this->db->query("UPDATE queue_list SET status = 0 WHERE id = $lastQueueId");
    } else {
        $lastQueueId = 0;
    }

    // Get the next queue number with status 0
    $nextQueueQuery = $this->db->query("SELECT * FROM queue_list WHERE transaction_id = '$tid' AND date(date_created) = '" . date('Y-m-d') . "' AND status = 0 AND id > $lastQueueId ORDER BY id ASC LIMIT 1");

    if ($nextQueueQuery->num_rows > 0) {
        $nextQueue = $nextQueueQuery->fetch_assoc();
        $nextQueueId = $nextQueue['id'];

        // Update the status of the next queue number to 1
        $this->db->query("UPDATE queue_list SET status = 1 WHERE id = $nextQueueId");

        return json_encode(array('status' => 1, 'data' => $nextQueue));
    }

    return json_encode(array('status' => 0, 'message' => 'No more pending queues!'));
}













}
