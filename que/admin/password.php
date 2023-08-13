<?php
require 'db_connect.php';
include 'include-admin/header.php';
?>

<div class="mdl-layout mdl-js-layout color--gray is-small-screen login">
		<main class="mdl-layout__content">
			<div class="mdl-card mdl-card__login mdl-shadow--1dp">
				<div class="mdl-card__supporting-text color--dark-gray">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
							<span class="login-name text-color--white text-center">Change Password</span>
							<span class="login-secondary-text text-color--smoke"></span>
						</div>
						<div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
							<form action="code.php" method="POST">
								<div class="form-group">
									<label for="password" class="control-label">Password</label>
									<input type="text" class="mdl-textfield__input" id="password" name="old" class="form-control">
								</div>
								<div class="form-group">
									<label for="new" class="control-label">New Password</label>
									<input type="password" class="mdl-textfield__input" id="password" name="new" class="form-control">
								</div>
                                <div class="form-group">
									<label for="retype" class="control-label">Confirm Password</label>
									<input type="password" class="mdl-textfield__input" id="password" name="confirm" class="form-control">
								</div>
								<button type="submit" name="change-password" class="btn btn-primary" style="float: right;">Login</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>

<?php
include 'include-admin/script.php';
?>