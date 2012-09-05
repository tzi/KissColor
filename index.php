<?php

define( 'HTML_EOL', '<br>' . PHP_EOL );

require( dirname( __FILE__ ) . '/utils/String.php' );
require( dirname( __FILE__ ) . '/utils/Array.php' );
require( dirname( __FILE__ ) . '/Color_RGB.php' );

if ( isset( $_GET[ 'c' ] ) ) {
	$color = ( new \KissColor\Color_RGB )->from_string( $_GET[ 'c' ] );
	$reference = $color->get_nearest_reference( );
	echo '<div style="height:50px; text-align: center; background-color: ' . $color->to_hex( ) . '">Votre couleur ' . $_GET[ 'c' ] . ' semble proche de... </div>';
	echo '<div style="height:50px; text-align: center; background-color: ' . $reference->to_hex( ) . '">' . $color->references[ $reference->to_hex( ) ] . '</div>';
} else {
	$color = new \KissColor\Color_RGB( );

	// RGB to HEX
	$color->by_rgb( 150, 130, 130 );
	echo $color->to_hex( ) . HTML_EOL;

	// HEX to RGB
	$color->by_hex( '#968282' );
	echo $color->to_string( ) . HTML_EOL;
}