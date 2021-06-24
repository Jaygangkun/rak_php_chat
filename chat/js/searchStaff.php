<?php

include('../includeDatabase.php');
session_start();

if(isset($_POST['search']) && !empty($_POST['search'])) {
	$teachers = mysqli_query($dbConnect, "SELECT * FROM `bmwUsers` JOIN `groups` ON bmwUsers.facultyDepartment = groups.id WHERE `userTeacher` = '1' AND ( bmwUsers.firstName LIKE '%".$_POST['search']."%' OR bmwUsers.lastName LIKE '%".$_POST['search']."%' OR bmwUsers.userEmail LIKE '%".$_POST['search']."%' OR bmwUsers.jobRole LIKE '%".$_POST['search']."%') ORDER BY bmwUsers.facultyDepartment");
}
else{
	$teachers = mysqli_query($dbConnect, "SELECT * FROM `bmwUsers` JOIN `groups` ON bmwUsers.facultyDepartment = groups.id WHERE `userTeacher` = '1' ORDER BY bmwUsers.facultyDepartment");
}

$cur_group = '';
$group_start = false;
while($teacherData = mysqli_fetch_assoc( $teachers )) {
	$profile_img = $teacherData['profile'];
	if($cur_group != $teacherData['facultyDepartment']){
		if($group_start){
			?>
			</div>
			<?php
		}
		?>
		<div class="user-group">
			<h6 class="user-group__title"><?php echo $teacherData['groupName']?></h6>
			<div class="user-member-wrap">
				<div class="user__photo <?php echo $profile_img == '' ? "no-image": "" ?>" id="profile_preview_img" style="background-image: url('<?php echo $profile_img != '' ? $profile_img."?v=".time() : "assets/images/avatar-default.png" ?>')"></div>
				<p class="user__name"><?php echo $teacherData['firstName'].' '.$teacherData['lastName']?></p>
				<p class="user__role"><?php echo $teacherData['jobRole']?></p>
				<p class="user__email"><?php echo $teacherData['userEmail']?></p>
			</div>
		<?php

		$cur_group = $teacherData['facultyDepartment'];
		$group_start = true;
	}
	else{
		?>
		<div class="user-member-wrap">
			<div class="user__photo <?php echo $profile_img == '' ? "no-image": "" ?>" id="profile_preview_img" style="background-image: url('<?php echo $profile_img != '' ? $profile_img."?v=".time() : "assets/images/avatar-default.png" ?>')"></div>
			<p class="user__name"><?php echo $teacherData['firstName'].' '.$teacherData['lastName']?></p>
			<p class="user__role"><?php echo $teacherData['jobRole']?></p>
			<p class="user__email"><?php echo $teacherData['userEmail']?></p>
		</div>
		<?php
	}
}

if($group_start){
	?>
	</div>
	<?php
}

?> 