<?php
	class class_userDisplay{
		public function grid_fetch($spot_select_user, $select_user, $MYSQL){
			require "lang/en.php";
    $output = "";
    $columns    = 4;                                                  // users pr. row
    $amount     = $MYSQL->count_results($spot_select_user);           // total users
    $amount_td  = $columns * (ceil( $amount / $columns )) - $amount;  // empty rows to create
    $i          = 0;
    $j          = 1;
?>
<div class="table-responsive">
<table class="table table bordered"><tr>
<?php
		if(is_array($select_user)){
foreach($select_user AS $result_row){
        if ( $i >= $columns ) {
            ?>
			</tr><tr>
			<?php
            $i = 0;
        }
        ?>
		<td style = "padding: 10px; text-align: center;"><?php print $result_row["Username"]; ?><br /><?php print $result_row["Fullname"]; ?><br /><?php print $result_row["Emailaddress"]; ?><br />
<a id = "listlinks" title = "More about <?php echo $result_row["Fullname"]; ?>" href = "dispatch.php?viewId=<?php echo $result_row["Username"]; ?>" class = "nyroModal" ><img src = "images/icons/details.png" width = "20px" height = "20px" /></a> | <a id = "listlinks" title = "Edit <?php echo $result_row["Fullname"]; ?>" href = "dispatch.php?editId=<?php echo $result_row["Username"]; ?>"><img src = "images/icons/edit.png" width = "15px" height = "15px" /></a> | <a id = "listlinks" title = "Delete <?php echo $result_row["Fullname"]; ?>" href = "dispatch.php?delId=<?php echo $result_row["Username"]; ?>" onClick = "return confirm('Are you sure you want to delete <?php echo $result_row["Fullname"]; ?> from the database?')"><img src = "images/icons/del.png" width = "15px" height = "15px" /></a>		
		</td>
		<?php
        $i++;
        $j++;
    }
    for( $i = 0; $i < $amount_td; $i++ ) {
        ?><td>&nbsp;</td><?php
    }
		}else{ print '<tr><td colspan = "10">' . $select_user . '</td></tr>'; }
?>
</tr>
		<script type = "text/javascript">
		$(function() {
		  $('.nyroModal').nyroModal();
		});
		</script>
			<?php
		}
		public function list_fetch($select_user, $MYSQL){
			require "lang/en.php";
	?>
		  <div class="table-responsive">
		   <table class="table table bordered">
			<thead>
				<tr>
					<th><?php print ucwords($lang["username"]); ?></th>
					<th><?php print ucwords($lang["fullname"]); ?></th>
					<th><?php print ucwords($lang["emailaddress"]); ?></th>
					<th><?php print ucwords($lang["lastaccess"]); ?></th>
					<th><?php print ucwords($lang["actions"]); ?></th>
				</tr>
			</thead>
	<?php
		if(is_array($select_user)){
			foreach($select_user AS $result_row){
	?>
					<tr>
						<td><?php print $result_row["user_name"]; ?></td>
						<td><?php print $result_row["full_name"]; ?></td>
						<td><?php print $result_row["phonenumber"]; ?></td>
						<td><?php print $result_row["email"]; ?></td>
						<td><?php print date("jS F Y H:i:s", strtotime($result_row["accesstime"])); ?></td>
						<td>
		<a id = "listlinks" title = "More about <?php echo $result_row["full_name"]; ?>" href = "dispatch.php?viewId=<?php echo $result_row["userid"]; ?>" class = "nyroModal" ><img src = "images/icons/details.png" width = "20px" height = "20px" /></a> | <a id = "listlinks" title = "Edit <?php echo $result_row["full_name"]; ?>" href = "dispatch.php?editId=<?php echo $result_row["userid"]; ?>"><img src = "images/icons/edit.png" width = "15px" height = "15px" /></a> | <a id = "listlinks" title = "Delete <?php echo $result_row["full_name"]; ?>" href = "index.php?delId=<?php echo $result_row["Username"]; ?>" onClick = "return confirm('Are you sure you want to delete <?php echo $result_row["full_name"]; ?> from the database?')"><img src = "images/icons/del.png" width = "15px" height = "15px" /></a>
						</td>
					</tr>
	<?php
			}
		}else{ print '<tr><td colspan = "10">' . $select_user . '</td></tr>'; }
	?>
			<tfoot>
				<tr>
					<th><?php print ucwords($lang["username"]); ?></th>
					<th><?php print ucwords($lang["fullname"]); ?></th>
					<th><?php print ucwords($lang["emailaddress"]); ?></th>
					<th><?php print ucwords($lang["lastaccess"]); ?></th>
					<th><?php print ucwords($lang["actions"]); ?></th>
				</tr>
			</tfoot>
			<script type = "text/javascript">
			$(function() {
			  $('.nyroModal').nyroModal();
			});
			</script>
	<?php
	}
	public function modal_fetch($spot_pers_edit_row){
		$arr_hobbies = str_replace("|", ", ", $spot_pers_edit_row["hobbies"]);
	?>
		<div class = "modal-header">
			<h2><?php echo $spot_pers_edit_row['Fullname']; ?></h2>
		</div>
		<div class = "modal-body">
			<p style = "text-align: justify; text-justify: inter-word;"><img src = "images/people/<?php echo $spot_pers_edit_row['Userphoto']; ?>" style = "border: solid #ffffff 0px; width: 100px; height: 100px; padding: 3px;" hspace = "5" align = "left" /><?php echo nl2br(trim($spot_pers_edit_row['short_story']), "<b><br><a>"); ?></p>
		</div>
		<div class = "modal-footer">
			<h4>Interest(s): <?php echo $arr_hobbies; ?> </h4>
			<h3>By: <?php echo $spot_pers_edit_row['Fullname']; ?> &lt; <?php echo $spot_pers_edit_row['Emailaddress']; ?> &gt;</h3>
		</div>
<?php
	}
}
?>
