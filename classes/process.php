<?php
	class Process{
		public function spot_user_list($MYSQL){
			require "lang/en.php";
			
			if(isset($_GET["delId"])){
				if(is_numeric($_GET["delId"])){
					$delId = $_GET["delId"];
					$where = [ "Username" => $delId ];
					$where_hist = [ "peopleId" => $delId ];
					
					$del_allgroups_pers = $MYSQL->delete($_SESSION["allgroups"], $where);
					if($del_allgroups_pers == TRUE){
						
						$del_table_name_pers = $MYSQL->delete($_SESSION["table_name"], $where);
						if($del_table_name_pers == TRUE){
						
							$del_pers_hit = $MYSQL->delete("offdays_history", $where_hist);
							if($del_pers_hit == TRUE){
								
								header("Location: ./");
							
							} else { print "Error: " . $del_pers_hit ; }
									
						} else { print "Error: " . $del_table_name_pers ; }
					
					} else { print "Error: " . $del_allgroups_pers ; }
				} else { print "Error: " ; }
			}
			
			if((isset($_POST["query"])) OR (!empty($_POST["query"]))){
			 $search = $MYSQL->escape_values($_POST["query"]);
				$spot_select_user = 'SELECT '.$_SESSION["table_name"].'.Username, '.$_SESSION["table_name"].'.Fullname, '.$_SESSION["allgroups"].'.Emailaddress, '.$_SESSION["allgroups"].'.Userphoto, FROM_UNIXTIME('.$_SESSION["allgroups"].'.Lastaccess) AS Lastaccess FROM '.$_SESSION["table_name"].' LEFT JOIN '.$_SESSION["allgroups"].' ON ('.$_SESSION["allgroups"].'.Username = '.$_SESSION["table_name"].'.Username) WHERE '.$_SESSION["allgroups"].'.Emailaddress LIKE "%'.$search.'%" OR '.$_SESSION["table_name"].'.Username LIKE "%'.$search.'%" OR '.$_SESSION["table_name"].'.Fullname LIKE "%'.$search.'%" ORDER BY '.$_SESSION["table_name"].'.Fullname ASC';
			} else {
				$spot_select_user = 'SELECT '.$_SESSION["table_name"].'.Username, '.$_SESSION["table_name"].'.Fullname AS Fullname, '.$_SESSION["allgroups"].'.Emailaddress, '.$_SESSION["allgroups"].'.Userphoto, FROM_UNIXTIME('.$_SESSION["allgroups"].'.Lastaccess) AS Lastaccess FROM '.$_SESSION["table_name"].' LEFT JOIN '.$_SESSION["allgroups"].' ON ('.$_SESSION["allgroups"].'.Username = '.$_SESSION["table_name"].'.Username) ORDER BY '.$_SESSION["table_name"].'.Fullname ASC';
			}

			if($MYSQL->count_results($spot_select_user) > 0) {
				$select_user = $MYSQL->select_while($spot_select_user);
			} else {
				$select_user = 'Data Not Found';
			}
			return array($select_user, $spot_select_user);
		}
		
		public function select_settings($MYSQL){
			require "lang/en.php";
			$spot_offdays_rows = $MYSQL->select('SELECT * FROM `offdays_settings`');

			$arr_can_apply_on = explode (",", $spot_offdays_rows["can_apply_on"]);
			$arr_class_days = explode (",", $spot_offdays_rows["can_take_off_on"]);
			$will_take_effect = $spot_offdays_rows["will_take_effect"] . " On ";

			$all_week_days = $lang["all_week_days"];

			$spot_Monday = date("jS F, Y, l", strtotime("next Monday"));
			
			return array($all_week_days, $arr_can_apply_on, $arr_class_days, $will_take_effect, $spot_Monday, $spot_offdays_rows);
		}	
		
		public function select_history($MYSQL){
			$spot_offdays_hist_re = $MYSQL->select_while('SELECT * FROM offdays_history ORDER BY offdays_historyId DESC');
			return array($spot_offdays_hist_re);
		}
		
		public function get_edit_user($MYSQL){
	
			if((isset($_SESSION["editId"])) OR (isset($_GET["editId"]))){
				
				if(isset($_GET["editId"])){
					$editId = $_GET["editId"];
				}else if(isset($_SESSION["editId"])){
					$editId = $_SESSION["editId"];
				}
				//$sql = 'SELECT '$_SESSION["table_name"]'.user_name, '.$_SESSION["table_name"]'.full_name AS Fullname, '.$_SESSION["table_name"]'.email, '.$_SESSION["table_name"]'.profile_image  WHERE '.$_SESSION["table_name"]'.userid = "$editId";

				//$sql = 'SELECT '. $_SESSION["table_name"].'.user_name, '.$_SESSION["table_name"].'.full_name AS Fullname, '.$_SESSION["table_name"].'.email, '.$_SESSION["table_name"].'.profile_image  FROM '.$_SESSION["table_name"].' WHERE '.$_SESSION["table_name"].'.userid = '. $editId
				$sql = "SELECT user_name, full_name , email, phone_number, profile_image FROM users WHERE userid =". $editId;

				$pers_to_edit = $MYSQL->select($sql);
				
			}else{

			}
			if(isset($_GET["viewId"])){
				return  $pers_to_edit;
			}else{
				return $pers_to_edit;
			}
		}
		
		public function update_settings($MYSQL){
			require "lang/en.php";
			if(isset($_POST["save_settings"])){
				$can_apply_on = $_POST["can_apply_on"];
				$can_take_off_on = $_POST["class_days"];
				$will_take_effect = $_POST["will_take_effect"];
				
				$get_applydays = implode (",", $can_apply_on);
				$get_availabledays = implode (",", $can_take_off_on);
				
				$MYSQL->truncate("offdays_settings");

				$keys = array("can_apply_on", "can_take_off_on", "will_take_effect");
				$values = array($get_applydays, $get_availabledays, $will_take_effect);
				
				$data  = array_combine($keys, $values);
				$insert_offdays = $MYSQL->insert("offdays_settings",$data);
				
				if($insert_offdays == TRUE){
					header("Location: offdays.php");
				}
			}
			function bind_to_template($replacements, $template) {
					return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
						return $replacements[$matches[1]];
					}, $template);
				}

			if(isset($_POST["update_status"])){
				$offdays_historyId = $_POST["offdays_historyId"];
				$offdays_status = implode("", $_POST["offdays_status"]);

					if ($offdays_status == "Deleted"){
						$where = ["offdays_historyId" => $offdays_historyId];
						$update_status = $MYSQL->delete("`offdays_history`",$where);
					}else{
						$data = ["offdays_status" => $offdays_status];
						$where = ["offdays_historyId" => $offdays_historyId];
						$update_status = $MYSQL->update("`offdays_history`",$data,$where);
					}
					
					if ($update_status == TRUE){

				$spot_app_details = $MYSQL->select('SELECT DISTINCT offdays_history.peopleId, '.$_SESSION["table_name"].'.Fullname, '.$_SESSION["allgroups"].'.Emailaddress FROM offdays_history LEFT JOIN '.$_SESSION["allgroups"].' ON (offdays_history.peopleId = '.$_SESSION["allgroups"].'.Username) LEFT JOIN '.$_SESSION["table_name"].' ON (offdays_history.peopleId = '.$_SESSION["table_name"].'.Username) WHERE offdays_history.offdays_historyId = '.$offdays_historyId.' LIMIT 1');

					$replacements = array('student_name' => $spot_app_details["Fullname"], 'status' => $offdays_status);

					date_default_timezone_set('Africa/Nairobi');

						require_once 'mailer/PHPMailerAutoload.php';

						//Create a new PHPMailer instance
						$mail = new PHPMailer;

						//Tell PHPMailer to use SMTP
						$mail->isSMTP();

						//Enable SMTP debugging
						// 0 = off (for production use)
						// 1 = client messages
						// 2 = client and server messages
						$mail->SMTPDebug = 0;

						//Ask for HTML-friendly debug output
						$mail->Debugoutput = 'html';

						//Set the hostname of the mail server
						$mail->Host = 'smtp.gmail.com';
						// use
						// $mail->Host = gethostbyname('smtp.gmail.com');
						// if your network does not support SMTP over IPv6

						//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
						$mail->Port = 587;

						//Set the encryption system to use - ssl (deprecated) or tls
						$mail->SMTPSecure = 'tls';

						//Whether to use SMTP authentication
						$mail->SMTPAuth = true;

						//Username to use for SMTP authentication - use full email address for gmail
						$mail->Username = "bbitalex@gmail.com";

						//Password to use for SMTP authentication
						$mail->Password = "alex2017";

						//Set who the message is to be sent from
						$mail->setFrom('bbit3b@gmail.com', 'bbit3 Bee');

						//Set an alternative reply-to address
						$mail->addReplyTo('bbit3b@gmail.com', 'bbit3 Bee');

						//Set who the message is to be sent to
						$mail->addAddress($spot_app_details["Emailaddress"], $spot_app_details["Fullname"]);

						//Set the subject line
						$mail->Subject = $lang["title"] . ' - Hello ' . $spot_app_details["Fullname"];

						//Read an HTML message body from an external file, convert referenced images to embedded,
						//convert HTML into a basic plain-text alternative body
						// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

						//Replace the plain text body with one created manually
						// $mail->AltBody = 'This is a plain-text message body';
						
						$mail->Body = bind_to_template($replacements, $lang["template"]);

						//Attach an image file
						// $mail->addAttachment('images/phpmailer_mini.png');

						//send the message, check for errors
						if (!$mail->send()) {
							print "Mailer Error: " . $mail->ErrorInfo;
						} else {
							print "Message sent!";
						}				
						header("Location: offdays.php");
				}
			}
			
			if(isset($_POST["apply_offdays_plan"])){
				$offdays_plan = $_POST["offdays_plan"];
				$offdays_status = "Pending";
				$peopleId = $_POST["admissionId"];
				
		$result = $MYSQL->count_results('SELECT '.$_SESSION["allgroups"].'.Username FROM '.$_SESSION["allgroups"].' LEFT JOIN '.$_SESSION["table_name"].' ON ('.$_SESSION["allgroups"].'.Username = '.$_SESSION["table_name"].'.Username) WHERE '.$_SESSION["allgroups"].'.Username = '.$peopleId.' AND '.$_SESSION["allgroups"].'.Emailaddress IS NOT NULL LIMIT 1');

				if ($result > 0){
					$keys = array("peopleId", "offdays_history", "offdays_status");
					$values = array($peopleId, $offdays_plan, $offdays_status);
					
					$data  = array_combine($keys, $values);	
					$insert_offdays_plan = $MYSQL->insert("offdays_history",$data);
					
					if($insert_offdays_plan == TRUE){
						header("Location: offdays.php");
						exit();
					}else{
						print $insert_offdays_plan;
					}
				}else{
					header("Location: offdays.php?not_exist");
					exit();
				}
			}
		}
		
		public function update_user_details($MYSQL){
			if(isset($_POST["save_hobbies"])){
				$hobbiesId = addslashes($_POST["hobbiesId"]);
				$hobbies = addslashes($_POST["hobbies"]);

				$data  = [ "hobbies" => $hobbies ];
				$where = [ "hobbiesId" => $hobbiesId ];

				$insert_hobbies = $MYSQL->update("hobbies_table",$data,$where);
				
				if($insert_hobbies == TRUE){
					header("Location: user_form.php");
				} else {
					print "Error: " . $insert_hobbies;
				}
			}
			
	
			if((isset($_POST["save_details"])) OR (isset($_POST["update_details"]))){
				$Username = addslashes($_POST["Username"]);
				$Fullname = ucwords(strtolower(addslashes($_POST["Fullname"])));
				$Emailaddress = strtolower(addslashes($_POST["Emailaddress"]));
				$short_story = addslashes($_POST["short_story"]);
				$get_hobbies = $_POST["get_hobbies"];
				$Lastaccess = time();
					if(is_array($get_hobbies)){
						$set_hobbies = implode("|", $get_hobbies);
					}

					$init_allgroups_data  = [ "Emailaddress" => $Emailaddress, "short_story" => $short_story, "hobbies" => $set_hobbies, "Lastaccess" => $Lastaccess ];
					$init_Fullname = [ "Fullname" => $Fullname ];
					$init_Username = [ "Username" => $Username ];
					
					if(!empty($_FILES["Userphoto"]["name"])){
						$filenames = $_FILES["Userphoto"]["name"];
						$arr_filenames = explode(".", $filenames);
						$ext = end($arr_filenames);
						$allowedExts = array("image/png", "image/PNG", "image/jpg", "image/JPG", "image/jpeg", "image/JPEG");
						$path = "images/people/";
						$new_Userphoto_name = rand().$Username . '_' . $Fullname . '.';
						$target = $path . $new_Userphoto_name . $ext;
						if((!in_array($_FILES['Userphoto']['type'], $allowedExts)) AND (!empty($_FILES["Userphoto"]["type"]))){
							header ("Location: user_form.php?wrong_ext");
							exit();
						}else {
							if(move_uploaded_file($_FILES['Userphoto']['tmp_name'], $target)) {
								$Userphoto = $new_Userphoto_name . $ext;
							}else {
								$Userphoto = "default.png";
							}
							$init_Userphoto = array("Userphoto" => $Userphoto);
						}
					}else{
							$init_Userphoto = array();
					}
					
					if(isset($_POST["save_details"])){
						$allgroups_data = array_merge_recursive($init_allgroups_data, $init_Username, $init_Userphoto);
						$user_data = array_merge($init_Username, $init_Fullname);

							$insert_in_allgroups = $MYSQL->insert($_SESSION["allgroups"], $allgroups_data);
							
							if($insert_in_allgroups == TRUE){
								
							$insert_in_user = $MYSQL->insert($_SESSION["table_name"], $user_data);

								if($insert_in_user == TRUE){
									if(isset($_SESSION["editId"])){ unset($_SESSION["editId"]); }
									header("Location: ./"); exit();
								} else { print $insert_in_user;}
								
							} else { print $insert_in_allgroups; }
					}					
					if(isset($_POST["update_details"])){
						$allgroups_data = array_merge_recursive($init_allgroups_data, $init_Userphoto);
						$where = $init_Username;
						$user_data = $init_Fullname;
						
						$update_people = $MYSQL->update($_SESSION["allgroups"], $allgroups_data, $where);
						if($update_people == TRUE){

							$update_user = $MYSQL->update($_SESSION["table_name"], $user_data, $where);
							if($update_user == TRUE){
								if(isset($_SESSION["editId"])){ unset($_SESSION["editId"]); }
								header("Location: ./"); exit();
							} else { print $update_user; }

							} else { print $update_people; }
					}
			}
		}
	}
?>