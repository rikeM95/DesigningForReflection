<?php

namespace WPCoder\Update;

defined( 'ABSPATH' ) || exit;

use WPCoder\Dashboard\DBManager;
use WPCoder\WPCoder;

class UpdateDB {

	public static function init(): void {
		$current_db_version = get_option( WPCoder::PREFIX . '_db_version' );

		if ( $current_db_version && version_compare( $current_db_version, '3.2', '>=' ) ) {
			return;
		}

		self::updateDB();
		self::updateDBFields();

		update_option( WPCoder::PREFIX . '_db_version', '3.2' );
	}

	private static function updateDB(): void {
		global $wpdb;
		$table_name      = $wpdb->prefix . WPCoder::PREFIX;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title VARCHAR(200) NOT NULL,
        html_code LONGTEXT,
        css_code LONGTEXT,
        js_code LONGTEXT,
        php_code LONGTEXT,
        param LONGTEXT,
        status BOOLEAN,
        mode BOOLEAN,
        tag TEXT,
        PRIMARY KEY (id)
    ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	private static function updateDBFields(): void {
		$results = DBManager::get_all_data();

		if ( ! empty( $results ) ) {
			foreach ( $results as $key => $val ) {
				$id    = $val->id;
				$title = $val->title;
				$param = maybe_unserialize( $val->param );

				$html_code = ! empty( $param['content_html'] ) ? $param['content_html'] : '';
				if ( ! empty ( $val->html_code ) ) {
					$html_code = $val->html_code;
				}
				$css_code = ! empty( $param['content_css'] ) ? $param['content_css'] : '';
				if ( ! empty ( $val->css_code ) ) {
					$css_code = $val->css_code;
				}

				$js_code = ! empty( $param['content_js'] ) ? $param['content_js'] : '';
				if ( ! empty ( $val->js_code ) ) {
					$js_code = $val->js_code;
				}

				$data = [
					'title'     => $title,
					'html_code' => $html_code,
					'css_code'  => $css_code,
					'js_code'   => $js_code,
					'status'    => 0,
					'mode'      => 0,
					'tag'       => '',
					'param'     => $val->param,
				];

				$where = [ 'id' => $id ];

				$data_formats = [ '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s' ];

				DBManager::update( $data, $where, $data_formats );
			}
		}
	}


}