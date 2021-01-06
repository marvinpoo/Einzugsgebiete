<?php
/*
 * Plugin Name:       MPW Data: Einzugsgebiet
 * Plugin URI:        https://mpw-immobilien.de/
 * Description:       Dies ist das Plugin für das Einzugsgebiet inklusive Bezirke, Ortsteile, Bodenrichtwertzonen, Postleitzahlen und Bodenrichtwerte.
 * Version:           1.0.0
 * Author:            Marvin Borisch
 * Author URI:        https://marvinpoo.dev/ 
 * Text Domain:       einzug
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Exclusive Right of Use since 18. November 2019  MPW-Immobilien Michael Werner GmbH
 */

 /* Copyright 2019  Marvin Borisch exklusiv für MPW immobilien

    Conception: Martin Marhold, Marvin Borisch
    Code: Marvin Borisch

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

/* Adding the types */
// Bezirk
require_once( dirname( __FILE__ ) . '/inc/type_bezirk.php' );

// Ortsteil
require_once( dirname( __FILE__ ) . '/inc/type_ot.php' );

// Bodenrichtwertzone
require_once( dirname( __FILE__ ) . '/inc/type_brw.php' );

// Kiezstimmen
require_once( dirname( __FILE__ ) . '/inc/type_ks.php' );

/* Adding the Metas */
// BRW Zonen: Richtwert des Jahres
require_once( dirname( __FILE__ ) . '/inc/meta_year.php' );

// Durchschnittspreise Bezirke/Ortsteile
require_once( dirname( __FILE__ ) . '/inc/meta_avgprice.php' );

// Ortsteil: Postleitzahlen
require_once( dirname( __FILE__ ) . '/inc/meta_plz.php' );

// BRWZ to OT
require_once( dirname( __FILE__ ) . '/inc/meta_ot.php' );

// OT to Bezirk
require_once( dirname( __FILE__ ) . '/inc/meta_bezirk.php' );

// Bezirke: Infos über Bezirke & Ortsteile
require_once( dirname( __FILE__ ) . '/inc/meta_infomatic.php' );

// Required functions
require_once( dirname( __FILE__ ) . '/inc/req_fcn.php' );
require_once(dirname(__FILE__).'/inc/get.php');

require_once( dirname( __FILE__ ) . '/inc/function_injection.php') ;

?>
