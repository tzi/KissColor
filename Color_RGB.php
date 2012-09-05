<?php

/* This file is part of the KissColor project.
 * KissColor is a free and unencumbered software released into the public domain.
 * For more information, please refer to <http://unlicense.org/>
 */

namespace KissColor;

class Color_RGB {


	/*************************************************************************
	 ATTRIBUTES
	 *************************************************************************/
	private	$references = [
		'#8888FF' => 'bleu clair',
		'#88FF88' => 'vert clair',
		'#FFFF88' => 'jaune clair',
		'#F6A14A' => 'orange clair',
		'#FF8888' => 'rose',
		'#DA70D6' => 'Orchidée',
		'#94812B' => 'Kaki',
		'#0000FF' => 'bleu',
		'#00FF00' => 'vert',
		'#FFFF00' => 'jaune',
		'#ED7F10' => 'orange',
		'#FF0000' => 'rouge',
		'#660099' => 'violet',
		'#5B3C11' => 'brun',
		'#000088' => 'bleu foncé',
		'#008800' => 'vert foncé',
		'#888800' => 'jaune foncé',
		'#842E1B' => 'brique',
		'#6D071A' => 'bordeaux',
		'#9E0E40' => 'pourpre',
		'#3F2204' => 'brun foncé',
		'#FFFFFF' => 'blanc',
		'#000000' => 'noir',
		'#CCCCCC' => 'gris clair',
		'#888888' => 'gris',
		'#444444' => 'gris foncé',
	];
	private $attr = [ 'r', 'g', 'b' ];
	public $r;
	public $g;
	public $b;


	/*************************************************************************
	 INITIALIZATION METHODS
	 *************************************************************************/
	public function from_string( $string ) {
		return $this->by_hex( $string );
	}

	public function by_rgb( $r, $g, $b ) {
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
		return $this;
	}

	public function by_hex( $hex ) {
		$original_hex = $hex;
		\UString\must_not_starts_with( $hex, '#' );
		if ( strlen( $hex ) == 3 ) {
			$hex = $hex[ 0 ] . $hex[ 0 ] . $hex[ 1 ] . $hex[ 1 ] . $hex[ 2 ] . $hex[ 2 ];
		}
		if ( strlen( $hex ) == 6 ) {
			$start = 0;
			foreach ( $this->attr as $attr ) {
				$this->$attr = base_convert( substr( $hex, $start, 2), 16, 10 );
				$start += 2;
			}
		} else {
			throw new \Exception( 'Invalid hex code: ' . $original_hex );
		}
		return $this;
	}


	/*************************************************************************
	 GETTER METHODS
	 *************************************************************************/
	public function get_distance( $color ) {
		if ( is_string( $color ) ) {
			$color = ( new $this )->from_string( $color );
		}
		$distance = 0;
		foreach ( $this->attr as $attr ) {
			$distance += pow( $color->$attr - $this->$attr, 2 );
		}
		return sqrt( $distance );
	}

	public function get_nearest( $colors ) {
		$color_distances = [ ];
		foreach ( $colors as $color ) {
			$color_distances[ $this->get_distance( $color ) ] = $color;
		}
		ksort( $color_distances );
		return array_shift( $color_distances );
	}

	public function get_nearest_reference_color_name( ) {
		return $this->references[ 
			$this->get_nearest( array_keys( $this->references ) )
		];
	}


	/*************************************************************************
	 TRANSFORMATION METHODS
	 *************************************************************************/
	public function to_hex( ) {
		$hex = '#';
		foreach ( $this->attr as $attr ) {
			$hex .= base_convert( $this->$attr, 10, 16 );
		}
		return $hex;
	}

	public function to_array( ) {
		return $this->to_rgb( );
	}
	public function to_rgb( ) {
		$rgb = [ ];
		foreach ( $this->attr as $attr ) {
			$rgb[ $attr ] = $this->$attr;
		}
		return $rgb;
	}

	public function toString( ) {
		return $this->to_string( );
	}
	public function to_string( ) {
		return 'rgb( ' . implode( ', ', $this->to_rgb( ) ) . ')';
	}
}