<html>
<div class="col-lg-6 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
	<h4 class="">Teachers</h4>
	<div class="form-group">
		<label for="exampleInputEmail1">Search for Staff</label>
		<input type="email" class="form-control" id="search_staff" placeholder="">
	</div>
	<div id="user_group_list">
		<?php
		$teachers = mysqli_query($dbConnect, "SELECT * FROM `bmwUsers` JOIN `groups` ON bmwUsers.facultyDepartment = groups.id WHERE `userTeacher` = '1' ORDER BY bmwUsers.facultyDepartment");
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
	</div>
  </div>
</div>
</div>
<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="assets/vendors/datatables.net-fixedcolumns-bs4/fixedColumns.bootstrap4.min.css">
<script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="assets/vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js"></script>
<script src="assets/js/shared/data-table.js"></script>
<script>
	jQuery(document).on("keyup change", '#search_staff', function(e) {
		var thisSearch = jQuery(this).val();
		jQuery.ajax({
			url: 'js/searchStaff.php',
			type: 'post',
			data: {
				search: thisSearch
			},
			success: function(searchData) {
				console.log('resp:', searchData);
				jQuery('#user_group_list').html(searchData);
			}
		})
		
	});
</script>
</html>