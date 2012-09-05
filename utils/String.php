<?php

/* This file is part of the KissFile project.
 * KissFile is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

namespace UString;


/*************************************************************************
  STRING METHODS                   
 *************************************************************************/


// STARTS WITH & ENDS WITH FUNCTIONS
function starts_with( $hay, $needles ) {
	\UArray\must_be_array( $needles );
	foreach( $needles as $needle ) {
		if ( substr( $hay, 0, strlen( $needle ) ) == $needle ) {
			return TRUE;
		}
	}
	return FALSE;
}

function ends_with( $hay, $needles ) {
	\UArray\must_be_array( $needles );
	foreach( $needles as $needle ) {
		if ( substr( $hay, -strlen( $needle ) ) == $needle ) {
			return TRUE;
		}
	}
	return FALSE;
}

function i_starts_with( $hay, $needle ) {
	return starts_with( strtolower( $hay ), strtolower( $needle ) );
}

function i_ends_with( $hay, $needle ) {
	return ends_with( strtolower( $hay ), strtolower( $needle ) );
}

function must_starts_with( &$hay, $needle ) {
	if ( ! starts_with( $hay, $needle ) ) {
		$hay = $needle . $hay;
	}
}

function must_ends_with( &$hay, $needle ) {
	if ( ! ends_with( $hay, $needle ) ) {
		$hay .= $needle;
	}
}

function must_not_starts_with( &$hay, $needle ) {
	if ( starts_with( $hay, $needle ) ) {
		$hay = substr( $hay, strlen( $needle ) );
	}
}

function must_not_ends_with( &$hay, $needle ) {
	if ( ends_with( $hay, $needle ) ) {
		$hay = substr( $hay, 0, -strlen( $needle ) );
	}
}



// CONTAINS FUNCTIONS
function contains( $hay, $needle ) {
	if ( ! empty( $needle ) ) {
		return ( strpos( $hay, $needle ) !== false );
	}
}

function i_contains( $hay, $needle ) {
	return contains( strtolower( $hay ), strtolower( $needle ) );
}



// SUBSTRING FUNCTIONS
function cut_before( &$hay, $needles ) {
	$return = substr_before( $hay, $needles );
	$hay = substr( $hay, strlen( $return ) );
	return $return;
}

function substr_before( $hay, $needles ) {
	\UArray\must_be_array( $needles );
	$return = $hay;
	foreach( $needles as $needle ) {
		if ( ! empty( $needle) && contains( $hay, $needle ) ) {
			$cut = substr( $hay, 0, strpos( $hay, $needle ) );
			if ( strlen( $cut ) < strlen ( $return ) ) {
				$return = $cut;
			}
		}
	}
	$hay = substr( $hay, strlen( $return ) );
	return $return;
}

function cut_before_last( &$hay, $needles ) {
	$return = substr_before_last( $hay, $needles );
	$hay = substr( $hay, strlen( $return ) );
	return $return;
}

function substr_before_last( $hay, $needles ) {
	\UArray\must_be_array( $needles );
	$return = '';
	foreach( $needles as $needle ) {
		if ( ! empty( $needle) && contains( $hay, $needle ) ) {
			$cut = substr( $hay, 0, strrpos( $hay, $needle ) );
			if ( strlen( $cut ) > strlen ( $return ) ) {
				$return = $cut;
			}
		}
	}
	$hay = substr( $hay, strlen( $return ) );
	return $return;
}

function cut_after( &$hay, $needles ) {
	$return = substr_after( $hay, $needles );
	$hay = substr( $hay, 0, - strlen( $return ) );
	return $return;
}

function substr_after( $hay, $needles ) {
	\UArray\must_be_array( $needles );
	$return = '';
	foreach( $needles as $needle ) {
		if ( ! empty( $needle) && contains( $hay, $needle ) ) {
			$cut = substr( $hay, strpos( $hay, $needle ) + strlen( $needle ) );
			if ( strlen( $cut ) > strlen ( $return ) ) {
				$return = $cut;
			}
		}
	}
	return $return;
}

function cut_after_last( &$hay, $needles ) {
	$return = substr_after_last( $hay, $needles );
	$hay = substr( $hay, 0, - strlen( $return ) );
	return $return;
}

function substr_after_last( $hay, $needles ) {
	\UArray\must_be_array( $needles );
	$return = $hay;
	foreach( $needles as $needle ) {
		if ( ! empty( $needle) && contains( $hay, $needle ) ) {
			$cut = substr( $hay, strrpos( $hay, $needle ) + strlen( $needle ) );
			if ( strlen( $cut ) < strlen ( $return ) ) {
				$return = $cut;
			}
		}
	}
	return $return;
}



/*************************************************************************
  RANDOM METHODS                   
 *************************************************************************/
function random( $length = 10 ) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$string = '';    
	for ( $i = 0; $i < $length; $i++ ) {
		$string .= $characters[ mt_rand( 0, strlen( $characters ) - 1 ) ];
	}
	return $string;
}
