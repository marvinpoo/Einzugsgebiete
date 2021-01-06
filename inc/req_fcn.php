<?php

/** Krautmenü **/
// Menü

function einzugsgebiet_menu() {
  add_menu_page(
    'Einzugsgebiet',
    'Einzugsgebiet',
    'read',
    'einzugsgebiet',
    '',
    'dashicons-admin-multisite',
    5
  );
}
add_action( 'admin_menu', 'einzugsgebiet_menu' );

// Style
add_action('admin_head', 'mdo_custom_menu');
function mdo_custom_menu() {
   echo '
   <style type="text/css">
   #toplevel_page_einzugsgebiet {
    background-color: #bd1101 !important;
   }
   #toplevel_page_einzugsgebiet .wp-menu-name {
     font-weight: 600 !important;
   }
   #toplevel_page_einzugsgebiet:hover, #adminmenu li#toplevel_page_einzugsgebiet:hover, #adminmenu li.opensub>a#toplevel_page_einzugsgebiet, #adminmenu li>a#toplevel_page_einzugsgebietp:focus, a#toplevel_page_einzugsgebiet.opensub {
    background-color: #a70e00 !important;
   }
   #toplevel_page_einzugsgebiet:hover, #adminmenu li#toplevel_page_einzugsgebiet:hover, #adminmenu li.opensub>a#toplevel_page_einzugsgebiet, #adminmenu li>a#toplevel_page_einzugsgebiet:focus, #toplevel_page_einzugsgebiet a.menu-top:focus, #toplevel_page_einzugsgebiet a.menu-top:hover, #adminmenu li#toplevel_page_einzugsgebiet.opensub>a.menu-top {
    background-color: #a70e00 !important;
   }
   #adminmenu li#toplevel_page_einzugsgebiet a:focus div.wp-menu-image:before,
   #adminmenu li#toplevel_page_einzugsgebiet.opensub div.wp-menu-image:before,
   #adminmenu li#toplevel_page_einzugsgebiet:hover div.wp-menu-image:before {
     color: #ffffff;
   }
   #toplevel_page_einzugsgebiet a, #adminmenu li#toplevel_page_einzugsgebiet a, #adminmenu li.opensub>a#toplevel_page_einzugsgebiet a, a#toplevel_page_einzugsgebiet.opensub a {
     color: #ffffff;
   }
   #toplevel_page_einzugsgebiet a:hover, #adminmenu li#toplevel_page_einzugsgebiet a:hover, #adminmenu li.opensub>a#toplevel_page_einzugsgebiet a:hover, a#toplevel_page_einzugsgebiet.opensub a:hover {
     color: #ffffff;
   }
   #toplevel_page_einzugsgebiet .wp-first-item {
     font-weight: 700;
     color: #ced6ff !important;
   }
   #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu {
     background-color: #223180;
   }
   #adminmenu .awaiting-mod, #adminmenu .update-plugins, .yoast-issue-counter {
     background-color: #bd1101 !important;
   }
   #update-nag, .update-nag {
     border-left: 2px solid #bd1101 !important;
   }
   a {
     color: #223180;
   }
   a:hover {
     color: #011b50;
   }
   </style>
   ';
 }
