<?php
//C Create add
//R Read get
//U Update update
//D Delete delete

function afzaliwp_wallet_add( $user_id, $amount, $status = 'pending', $description = '', $payment_info = '' ) {
	global $wpdb, $table_prefix;
	$table = $table_prefix . 'afzaliwp_wallet';

	return $wpdb->insert( $table, [
		'user_id'      => $user_id,
		'amount'       => $amount,
		'status'       => $status,
		'description'  => $description,
		'payment_info' => $payment_info,
	] );
}

function afzaliwp_wallet_get( $field = 'all', $value = '' ) {
	global $wpdb, $table_prefix;
	$table = $table_prefix . 'afzaliwp_wallet';

	if ( 'all' === $field ) {
		$where = '';
	} else {
		$where = sprintf( 'WHERE `%s`=\'%s\'', $field, $value );
	}

	return $wpdb->get_results( "SELECT * FROM `{$table}` {$where}" );
}

function afzaliwp_wallet_update( $field, $value = '', $where = [] ) {
	global $wpdb, $table_prefix;
	$table = $table_prefix . 'afzaliwp_wallet';

	return $wpdb->update(
		$table,
		[
			$field => $value,
		],
		$where,
		[
			'%s'
		]
	);
}

function afzaliwp_wallet_delete( $where = [] ) {
	global $wpdb, $table_prefix;
	$table = $table_prefix . 'afzaliwp_wallet';

	return $wpdb->delete( $table, $where );
}