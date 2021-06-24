<?php

include('../includeDatabase.php');
session_start();

if(isset($_POST['search']) && !empty($_POST['search'])) {
	$teachers = mysqli_query($dbConnect, "SELECT * FROM `bmwusers` JOIN `groups` ON bmwusers.facultyDepartment = groups.id WHERE `userTeacher` = '1' AND ( bmwusers.firstName LIKE '%".$_POST['search']."%' OR bmwusers.lastName LIKE '%".$_POST['search']."%' OR bmwusers.userEmail LIKE '%".$_POST['search']."%' OR bmwusers.jobRole LIKE '%".$_POST['search']."%') ORDER BY bmwusers.facultyDepartment");
}
else{
	$teachers = mysqli_query($dbConnect, "SELECT * FROM `bmwusers` JOIN `groups` ON bmwusers.facultyDepartment = groups.id WHERE `userTeacher` = '1' ORDER BY bmwusers.facultyDepartment");
}

$cur_group = '';
$group_start = false;
while($teacherData = mysqli_fetch_assoc( $teachers )) {
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
				<p class="user__name"><?php echo $teacherData['firstName'].' '.$teacherData['lastName']?></p>
				<p class="user__email"><?php echo $teacherData['userEmail']?></p>
				<p class="user__role"><?php echo $teacherData['jobRole']?></p>
			</div>
		<?php

		$cur_group = $teacherData['facultyDepartment'];
		$group_start = true;
	}
	else{
		?>
		<div class="user-member-wrap">
			<p class="user__name"><?php echo $teacherData['firstName'].' '.$teacherData['lastName']?></p>
			<p class="user__email"><?php echo $teacherData['userEmail']?></p>
			<p class="user__role"><?php echo $teacherData['jobRole']?></p>
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