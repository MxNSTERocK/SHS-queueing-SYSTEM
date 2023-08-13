<?php
include('db_connect.php');
if (isset($_GET['id'])) {
	$user = $conn->query("SELECT * FROM users where id =" . $_GET['id']);
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>

<div class="container-fluid">

	<div class="alert alert-danger" role="alert">
	 <small style="color:red">*&nbsp;&nbsp;</small>Please Fill out all field!
	</div>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="manage-user">
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
		<div class="form-group">
			<label for="name">Name <small style="color:red">*&nbsp;&nbsp; </small></label>
			<input type="text" name="name" id="name" class="required-valid form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>">
		</div>
		<div class="form-group">
			<label for="username">Username <small style="color:red">*&nbsp;&nbsp; </small></label>
			<input type="text" name="username" id="username" class="required-valid form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Password <small style="color:red">*&nbsp;&nbsp; </small></label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" required>
			<?php if (isset($meta['id'])) : ?>
				<small><i style="color: red;">This is Required to Update if you click the Update button.</i></small>
			<?php endif; ?>
		</div>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Staff</option>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Admin</option>
			</select>
		</div>
		<div class="form-group" id="window-field">
			<label for="type">Window</label>
			<select name="window_id" id="window_id" class="custom-select select2">
				<option value="" <?php echo isset($meta['window_id']) && $meta['window_id'] == 0 ? 'selected': '' ?>></option>
				<?php
				$query = $conn->query("SELECT w.*,t.name as tname FROM transaction_windows w inner join transactions t on t.id = w.transaction_id where w.status = 1 order by name asc");
				while($row= $query->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($meta['window_id']) && $meta['window_id'] == $row['id'] ? 'selected': ''; ?>><?php echo $row['tname']. ' '. $row['name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
	</form>
</div>



<script>
	$('.select2').select2({
		placeholder: "Please select here",
		width: "100%"
	})
	$('#type').change(function() {
		if ($(this).val() == 1) {
			$('#window-field').hide()
		} else {
			$('#window-field').show()
		}
	})
	
	$('#manage-user').submit(function(e) {
    e.preventDefault();
    var name = $('#name').val().trim();
    var username = $('#username').val().trim();
    var password = $('#password').val();

    // Validate Name field
    if (name === '') {
		alert_toast("Name Required", 'info')
					setTimeout(function() {
						location.reload()
					}, 1500)
        return;
    }

    // Validate Username field
    if (username === '') {
		alert_toast("Username Required", 'Info')
					setTimeout(function() {
						location.reload()
					}, 1500)
        return;
    }

    // Validate Password field
    if (password.length < 8) {
		alert_toast("Password must be at least 8 characters long", 'Info')
					setTimeout(function() {
						location.reload()
					}, 1500)
        return;
    }

    // If all validations pass, proceed with the AJAX request
    start_load();
    $.ajax({
        url: 'ajax.php?action=save_user',
        method: 'POST',
        data: $(this).serialize(),
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Data successfully saved", 'success');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Username already exists or invalid data. Please fill out all fields.", 'danger');
                end_load();
            }
        }
    });
});


	if ($('#type').val() == 1) {
		$('#window-field').hide()
	} else {
		$('#window-field').show()
	}
</script>