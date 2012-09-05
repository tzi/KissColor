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
	public	$references = [
		'#0089CC' => 'Bleu clair',
		'#8DD304' => 'Vert clair',
		'#F4F482' => 'Jaune clair',
		'#F4C950' => 'Orange clair',
		'#FBB7C5' => 'Rose',
		'#E86CC4' => 'Orchidée',
		'#94812B' => 'Kaki',
		'#0046B6' => 'Bleu',
		'#01B194' => 'Vert',
		'#F8E218' => 'Jaune',
		'#ED6E01' => 'Orange',
		'#ED2C34' => 'Rouge',
		'#98178E' => 'Violet',
		'#956206' => 'Brun',
		'#25193D' => 'Bleu foncé',
		'#144C2A' => 'Vert foncé',
		'#FDC918' => 'Jaune foncé',
		'#BA5500' => 'Brique',
		'#7C222D' => 'Bordeaux',
		'#512246' => 'Pourpre',
		'#4C270C' => 'Brun foncé',
		'#FFFFFF' => 'Blanc',
		'#000000' => 'Noir',
		'#CCCCCC' => 'Gris clair',
		'#888888' => 'Gris',
		'#444444' => 'Gris foncé',
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
		// print_r( $color_distances );
		return array_shift( $color_distances );
	}

	public function get_nearest_reference( ) {
		return ( new \KissColor\Color_RGB )->by_hex( $this->get_nearest( array_keys( $this->references ) ) );
	}


	/*************************************************************************
	 TRANSFORMATION METHODS
	 *************************************************************************/
	public function to_hex( ) {
		$hex = '#';
		foreach ( $this->attr as $attr ) {
			$attr_hex = base_convert( $this->$attr, 10, 16 );
			if ( strlen( $attr_hex ) == 1 ) {
				$attr_hex = 0 . $attr_hex;
			}
			$hex .= $attr_hex;
		}
		return strtoupper( $hex );
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