<?php
class UserDetailsForm{
	public function registration_form($pers_to_edit){
		require "lang/en.php";
?>
		<tr>
			<td style = "width: 50%">
			<fieldset style = "width: 100%;">
						<legend><?php echo $lang["personal_info"]; ?></legend>
					<table border = "0" align = "center" style = "width: 100%;" >
						<form action = "" method = "POST" enctype = "multipart/form-data">
							<tr>
								<td style = "width: 100%;">
									<input class = "user_form" type = "text" name = "Username" placeholder = "<?php echo $lang["username"];?>" <?php if(isset($_SESSION['editId'])){ ?> value = "<?php echo $pers_to_edit["user_name"]; ?>" disabled <?php } ?> autofocus required />
								</td>
							</tr>
							<tr>
								<td style = "width: 100%;">
									<input class = "user_form" type = "text" name = "Fullname" placeholder = "<?php echo $lang["fullname"];?>"<?php if(isset($_SESSION['editId'])){ ?> value = "<?php echo $pers_to_edit["full_name"]; ?>"<?php } ?> required />
								</td>
							</tr>
							<tr>
								<td>
									<input class = "user_form" type = "email" name = "email" placeholder = "<?php echo $lang["email"];?>" <?php if(isset($_SESSION['editId'])){ ?> value = "<?php echo $pers_to_edit["email"]; ?>"<?php } ?> required />
								</td>
							</tr>
							<tr>
								<td>
									<input class = "user_form" type = "phonenumber" name = "phonenumber" placeholder = "<?php echo $lang["phonenumber"];?>" <?php if(isset($_SESSION['editId'])){ ?> value = "<?php echo $pers_to_edit["phone_number"];?>"<?php } ?> required />
								</td>
							</tr>
							<tr>
								<td>
								<?php if(isset($_GET["wrong_ext"])){?><p class = "blink_me error"><?php print $lang["profile_image"]; ?></p><?php }?>
								
									<input class = "user_form" type = "file" name = "Userphoto" />
								</td>
							</tr>
<!-- 							<tr>
								<td>
									<ul>
										<?php foreach($arr_spot_hobbies AS $set_hobbies){?>
										<li><input style = "margin-right: 10px;" type = "checkbox" name = "get_hobbies[]" value = "<?php echo $set_hobbies; ?>" id = "<?php echo $set_hobbies; ?>" <?php if(isset($_SESSION['editId'])){ if(in_array($set_hobbies, $arr_hobbies)){echo 'checked'; }} ?> /><label for = "<?php echo $set_hobbies; ?>"><?php echo $set_hobbies; ?></label></li>
										<?php } ?>
									</ul>
								</td>
							</tr>
 -->							<tr>
								<td>
	<?php if(isset($_SESSION['editId'])){ ?>
		<input class = "user_form" type = "submit" name = "update_details" value = "<?php echo $lang["updatedetailsbutton"]; ?>" />
		<input type = "hidden" name = "Username" value = "<?php echo $pers_to_edit["user_name"]; ?>" />
	<?php }else{ ?>
		<input class = "user_form" type = "submit" name = "save_details" value = "<?php echo $lang["savedetailsbutton"]; ?>" />
	<?php } ?>
		<input class = "user_form" type = "button" OnClick = "parent.location='./'" value = "<?php echo $lang["returnbutton"]; ?>" />	
								</td>
							</tr>
						</form>
					</table>
				</fieldset>
			</td>
<!-- 			<td style = "width: 50%">
			<fieldset style = "width: 100%;">
				<legend><?php echo $lang["movetoadmin"]; ?></legend>
				<table border = "0" align = "left" style = "width: 100%;" >
				<form action = "" method = "POST">
					<tr>
						<td style = "width: 80%; text-align: left;">
							<textarea class = "user_form" name = "hobbies" placeholder = "Add hobbies separated by a single comma(,)" required ><?php echo $spot_hobbies_row["hobbies"]; ?></textarea>
							<?php echo $lang["hobbieshelp"]; ?>
						</td>
					</tr>
					<tr>
						<td >
							<input type = "hidden" name = "hobbiesId" value = "<?php echo $spot_hobbies_row["hobbiesId"]; ?>" />
							<input class = "user_form" type = "submit" name = "save_hobbies" value = "<?php echo $lang["updatehobbiesbutton"]; ?>" />
						</td>
					</tr>
				</form>
				</table>
			</fieldset>
			</td>
 -->		</tr>
<?php
}
}
?>