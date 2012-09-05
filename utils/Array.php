<?php

/* This file is part of the KissFile project.
 * KissFile is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

namespace UArray;



/*************************************************************************
  ARRAY METHODS                   
 *************************************************************************/
function must_be_array( &$array ) {
	if ( ! is_array( $array ) ) {
		$array = [ $array ];
	}
}

function array_merge_unique( $array1, $array2, $keep_last = FALSE ) {
	if ( $keep_last ) {
		return array_merge_unique_keep_last( $array1, $array2 );
	}
	return array_values( array_unique( array_merge( $array1, $array2 ) ) );
}

function array_merge_unique_keep_last( $array1, $array2 ) {
	return array_reverse( array_values( array_unique( array_reverse( array_merge( $array1, $array2 ) ) ) ) );
}


