<div class="afzaliwp-wallet-wrapper">
	<div class="side increase-balance">
		<form action="" method="post">
			<?php //TODO: get step from control panel ?>
			<label>
				<span><?php _e( 'Enter the amount to charge:', 'afzaliwp-wallet' ); ?></span>
				<input type="number" step="1000">
			</label>
			<button type="submit"><?php _e( 'Pay', 'afzaliwp-wallet' ); ?></button>
		</form>
	</div>
	<div class="main balance-stats">
		<p><strong><?php _e( 'Balance:', 'afzaliwp-wallet' ); ?></strong></p>
		<div class="transactions-history">
			<ul>
				<li>
					<div><?php _e('Date:', 'afzaliwp-wallet'); ?>  2012-4-4 6:54</div>
					<div><?php _e('Amount:', 'afzaliwp-wallet'); ?>  100</div>
					<div><?php _e('Status:', 'afzaliwp-wallet'); ?>  <span style="color: green;">Succeed</span></div>
				</li>
				<li>
					<div><?php _e('Date:', 'afzaliwp-wallet'); ?>  2012-4-4 6:54</div>
					<div><?php _e('Amount:', 'afzaliwp-wallet'); ?>  456</div>
					<div><?php _e('Status:', 'afzaliwp-wallet'); ?>  <span style="color: darkred;">Failed</span></div>
				</li>
			</ul>
		</div>
	</div>
</div>