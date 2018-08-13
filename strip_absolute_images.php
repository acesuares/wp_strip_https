<?php
/*
Plugin Name: sai - Strip Absolute Images
Plugin URI: http://www.suares.com/sai
Description: Many images are saved with absolute file path. Strip that. https://something.wordpress.com/files/2017/image.jpg -> /files/2017/image.jpg
Version: 1.0
Author: Ace Suares
Author URI: http://opencuracao.com
License: GPL2
*/
/*  Copyright 2018 Ace Suares  (email : ace@suares.com)

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

function sai_callback( $buffer ) {
  // mixed preg_replace ( mixed $pattern , mixed $replacement , mixed $subject [, int $limit = -1 [, int &$count ]] )
  $pattern =  '/https*:..[-0-9a-z]+\.wordpress\.suares\.com/i';
  $replacement = '';
  $replacements = 0;
  $a = preg_replace ( $pattern, $replacement, $buffer, -1, $replacements );

  $pattern =  '/http:\/\/fonts\.googleapis\.com/i';
  $replacement = 'https://fonts.googleapis.com';
  // $replacements = 0;
  $a = preg_replace ( $pattern, $replacement, $a, -1, $replacements );

  // // debugging
  // $handle = fopen("/tmp/wp-http.log", "a");
  // fwrite ( $handle , $replacements );
  // fclose ( $handle );

  return $a;
}

function sai_buffer_start() { ob_start( "sai_callback" ); }

function sai_buffer_end() { ob_end_flush(); }

// thanks to https://github.com/nextend/wp-ob-plugins-themes for adding priority

add_action( 'wp_head', 'sai_buffer_start', -10000 );
add_action( 'wp_footer', 'sai_buffer_end', -10000 );

?>
