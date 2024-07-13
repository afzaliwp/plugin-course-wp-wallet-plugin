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
								$balance = get_user_meta( $user->ID, 'afzaliwp_wallet_balance', true );
								echo sprintf( '<option value="%s">%s (%s)</option>', $user->ID, $user->display_name, $balance );
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
						<p><strong><?php echo __('Name', 'afzaliwp-wallet') . ': ' . $selected_user['ID'] .':'. $selected_user['display_name']; ?></strong></p>
						<p><strong><?php echo __('Balance', 'afzaliwp-wallet') . ': ' . $selected_user['balance'] ?></strong></p>
						<form action="" method="post" class="admin-edit-user-wallet-form">
							<label for="wallet-action">
								<?php _e( 'Action', 'afzaliwp-wallet' ); ?>
							</label>
							<select name="wallet-action" id="wallet-action">
								<option value="increase"><?php _e( 'Increase', 'afzaliwp-wallet' ); ?></option>
								<option value="decrease"><?php _e( 'Decrease', 'afzaliwp-wallet' ); ?></option>
							</select>

							<input type="hidden" name="current-user-current-balance" value="<?php echo $selected_user['balance']; ?>">
							<input type="hidden" name="current-user-id" value="<?php echo $selected_user['ID']; ?>">
							<label>
								<span><?php _e( 'Amount', 'afzaliwp-wallet' ); ?></span>
								<input type="number" name="wallet-amount-to-change" step="1000" value="0">
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