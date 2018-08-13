<?php
/*
Plugin Name: ffthttp - Force Files To http
Plugin URI: http://www.suares.com/ffthttp
Description: When using Wordpress with wp-admin over SSL (https), images and other files are inserted with a https URL. This causes problems when viewing the site without SSL (http). This plugin changes ALL links of the form https://mysite/[something] to http.
Version: 1.0
Author: Ace Suares
Author URI: http://opencuracao.com
License: GPL2
*/
/*  Copyright 2011-2018 Ace Suares  (email : ace@suares.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// thanks to http://www.dagondesign.com/articles/wordpress-hook-for-entire-page-using-output-buffering/

if ( ! is_ssl()) {

function ffthttp_callback( $buffer ) {
  $a = $buffer;
  // modify buffer here
  $site_url_ssl = get_site_url(null,'','https');
  $site_url     = get_site_url(null,'','http');

  $pattern = $site_url_ssl;
  $replacement = $site_url;
  // return the updated code
  $a = str_replace( $pattern, $replacement, $buffer );

  // $handle = fopen("/tmp/wp-http.log", "a");
  // fwrite ( $handle , $a );
  // fclose ( $handle );

  // malware 
  // $a = str_replace( "traffictrade.life", '', $buffer );
  return $a;
}

function ffthttp_buffer_start() { ob_start( "ffthttp_callback" ); }

function ffthttp_buffer_end() { ob_end_flush(); }


add_action( 'wp_head', 'ffthttp_buffer_start' );
add_action( 'wp_footer', 'ffthttp_buffer_end' );
}

?>
