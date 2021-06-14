<html>
<div class="col-lg-6 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
	<h4 class="card-title">Shuttle Timetable</h4>
	<p class="card-description"> Below are the timings for the university shuttle bus. </p>
	<div class="table-responsive">
		<table class="table" id="shuttle_table">
		<thead>
			<tr>
			<th>Bus</th>
			<th>Arrival</th>
			<th>Departure</th>
			<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<td>AUH Bus</td>
			<td>8:00 AM</td>
			<td>8:30 AM</td>
			<td>
				<label class="badge badge-danger">Inactive</label>
			</td>
			</tr>
			<tr>
			<td>DXB Bus</td>
			<td>8:00 AM</td>
			<td>8:30 AM</td>
			<td>
				<label class="badge badge-success">Active</label>
			</td>
			</tr>
			<tr>
			<td>Tecom Bus</td>
			<td>8:00 AM</td>
			<td>8:30 AM</td>
			<td>
				<label class="badge badge-success">Active</label>
			</td>
			</tr>
			<tr>
			<td>Mirdif Bus</td>
			<td>8:00 AM</td>
			<td>8:30 AM</td>
			<td>
				<label class="badge badge-success">Active</label>
			</td>
			</tr>
			<tr>
			<td>DXB Late Bus</td>
			<td>10:00 AM</td>
			<td>10:30 AM</td>
			<td>
				<label class="badge badge-success">Active</label>
			</td>
			</tr>
			<tr>
			<td>Tecom Late Bus</td>
			<td>10:00 AM</td>
			<td>10:30 AM</td>
			<td>
				<label class="badge badge-success">Active</label>
			</td>
			</tr>
			<tr>
			<td>Mirdif Late Bus</td>
			<td>10:00 AM</td>
			<td>10:30 AM</td>
			<td>
				<label class="badge badge-success">Active</label>
			</td>
			</tr>
		</tbody>
		</table>
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
	jQuery('#shuttle_table').DataTable({
		"bLengthChange": false,
    	"bFilter": false,
	});
</script>
</html>