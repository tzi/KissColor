<?php

define( 'HTML_EOL', '<br>' . PHP_EOL );

require( dirname( __FILE__ ) . '/utils/String.php' );
require( dirname( __FILE__ ) . '/utils/Array.php' );
require( dirname( __FILE__ ) . '/Color_RGB.php' );

if ( isset( $_GET[ 'c' ] ) ) {
	$color = ( new \KissColor\Color_RGB )->from_string( $_GET[ 'c' ] );
	echo 'Color ' . $color->to_hex( ) . HTML_EOL;
	echo 'Nearest color ' . $color->get_nearest_reference_color_name( ) . HTML_EOL;
} else {
	$color = new \KissColor\Color_RGB( );

	// RGB to HEX
	$color->by_rgb( 150, 130, 130 );
	echo $color->to_hex( ) . HTML_EOL;

	// HEX to RGB
	$color->by_hex( '#968282' );
	echo $color->to_string( ) . HTML_EOL;
}