<?php
$users         = $data[ 'users' ];
$selected_user = $data[ 'selected_user' ];
?>
<div class="wrap">
	<h1><?php _e( 'AfzaliWP Wallet', 'afzaliwp-wallet' ); ?></h1>
	<div id="postbox-container-1" class="postbox-container">
		<div id="normal-sortables" class="meta-box-sortables ui-sortable">
			<div id="" class="postbox ">
				<div class="postbox-header">
					<h3><?php _e( 'Users', 'afzaliwp-wallet' ); ?></h3>
				</div>
				<div class="inside">
					<form action="" method="post">
						<label for="wallet-users">
							<?php _e( 'Users', 'afzaliwp-wallet' ); ?>
						</label>
						<select name="wallet-user" id="wallet-users">
							<?php foreach ( $users as $user ) {
								echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
							} ?>
						</select>

						<button name="afzaliwp-wallet-select-user"
						        type="submit"><?php _e( 'Select User', 'afzaliwp-wallet' ); ?></button>
					</form>
				</div>
			</div>

			<?php if ( $selected_user ) { ?>
				<div id="" class="postbox ">
					<div class="postbox-header">
						<h3><?php _e( 'Actions', 'afzaliwp-wallet' ); ?></h3>
					</div>
					<div class="inside">
						<form action="" method="post" class="admin-edit-user-wallet-form">
							<label for="">
								<?php _e( 'Action', 'afzaliwp-wallet' ); ?>
							</label>
							<select name="" id="">
								<option value="increase"><?php _e( 'Increase', 'afzaliwp-wallet' ); ?></option>
								<option value="decrease"><?php _e( 'Decrease', 'afzaliwp-wallet' ); ?></option>
							</select>

							<?php //TODO: get step from control panel ?>
							<label>
								<span><?php _e( 'Amount', 'afzaliwp-wallet' ); ?></span>
								<input type="number" step="1000" value="0">
							</label>

							<button name="afzaliwp-wallet-action-user"
							        type="submit"><?php _e( 'Submit', 'afzaliwp-wallet' ); ?></button>
						</form>
					</div>
				</div>
				<?php } ?>
		</div>
	</div>
</div>