<?php
//C Create add
//R Read get
//U Update update
//D Delete delete

function afzaliwp_wallet_add( $user_id, $amount, $status = 'pending', $description = '', $payment_info = '' ) {
	date_default_timezone_set( 'Asia/Tehran' );

	global $wpdb, $table_prefix;
	$table = $table_prefix . 'afzaliwp_wallet';

	$date_time = new DateTime();

	return $wpdb->insert( $table, [
		'user_id'      => $user_id,
		'amount'       => $amount,
		'status'       => $status,
		'description'  => $description,
		'payment_info' => $payment_info,
		'created_at' => $date_time->format('Y-m-d H:i'),
		'updated_at' => $date_time->format('Y-m-d H:i'),
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
	date_default_timezone_set( 'Asia/Tehran' );

	global $wpdb, $table_prefix;
	$table = $table_prefix . 'afzaliwp_wallet';
	$date_time = new DateTime();

	return $wpdb->update(
		$table,
		[
			$field => $value,
			'updated_at' => $date_time->format('Y-m-d H:i'),
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