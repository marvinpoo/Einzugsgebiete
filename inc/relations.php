<?php // relationships

/** Many to Many Linker **/
class Many_To_Many_Linker {
  protected $_already_saved = false;
  public function __construct() {
    $this->do_initialize();
  }

  protected function do_initialize() {
    add_action(
      'save_post',
      array( $this, 'save_meta_box_data' ),
      10,
      2
    );

    add_action(
      "add_meta_boxes_for_brwz",
      array( $this, 'setup_brwz_boxes' )
    );

    add_action(
      "add_meta_boxes_for_ot",
      array( $this, 'setup_ot_boxes' )
    );
  }


/** Box for Relation Setup **/

public function setup_brwz_box( \WP_Post $post ) {
  add_meta_box(
    'brwz_related_ot_box',
    __('Gehört zu Ortstteil: ', 'language'),
    array( $this, 'draw_brwz_ot_box' ),
    $post->post_type,
    'advanced',
    'default'
  );
}


/** meta getter default **/

protected function get_brwz_details_meta( $post_id = 0 ) {
  $default = $this->get_default_brwz_details_meta();
  $current = get_post_meta( $post_id, '_brwz_info', true );
  if ( !is_array( $current ) ) {
    $current = $default;
  } else {
    foreach ( $default as $k => $v ) {
      if ( !array_key_exists( "{$k}", $current ) ) {
        $current["{$k}"] = $v;
      }
    }
  }
  return $current;
}


/** Relation Box Functionality **/

public function draw_brwz_ot_box( \WP_Post $post ) {
  $all_ot = $this->get_all_of_post_type( 'ot_type' );

  $linked_ot_ids = $this->get_brwz_ot_ids( $post->ID );

  if ( 0 == count($all_ot) ) {
    $choice_block = '<p>Keine Ortsteile gefunden.</p>';
  } else {
    $choices = array();
    foreach ( $all_ot as $ot ) {
      $checked = ( in_array( $ot->ID, $linked_ot_ids ) ) ? ' checked="checked"' : '';

      $display_name = esc_attr( $ot->post_title );
      $choices[] = <<<HTML
      <label><input type="checkbox" name="ot_ids[]" value="{$ot->ID}" {$checked}/> {$display_name}</label>
      HTML;

    }
    $choice_block = implode("\r\n", $choices);
  }

  # Make sure the user intended to do this.
  wp_nonce_field(
  "updating_{$post->post_type}_meta_fields",
  $post->post_type . '_meta_nonce'
  );

  echo $choice_block;
}


/** Grab all posts of the specified type **/
// Returns an array of post objects
protected function get_all_of_post_type( $type_name = '') {
  $items = array();
  if ( !empty( $type_name ) ) {
    $args = array(
      'post_type' => "{$type_name}",
      'posts_per_page' => -1,
      'order' => 'ASC',
      'orderby' => 'title'
    );
    $results = new \WP_Query( $args );
    if ( $results->have_posts() ) {
      while ( $results->have_posts() ) {
        $items[] = $results->next_post();
      }
    }
  }
  return $items;
}


/** Get array of Ortsteile ids for a particular Bodenrichtwertzone id **/
protected function get_brwz_ot_ids( $brwz_id = 0 ) {
  $ids = array();
  if ( 0 < $brwz_id ) {
    $args = array(
      'post_type' => 'ot_type',
      'posts_per_page' => -1,
      'order' => 'ASC',
      'orderby' => 'title',
      'meta_query' => array(
        array(
          'key' => '_brwz_id',
          'value' => (int)$brwz_id,
          'type' => 'NUMERIC',
          'compare' => '='
        )
      )
    );
    $results = new \WP_Query( $args );
    if ( $results->have_posts() ) {
      while ( $results->have_posts() ) {
        $item = $results->next_post();
        if ( !in_array($item->ID, $ids) ) {
          $ids[] = $item->ID;
        }
      }
    }
  }
  return $ids;
}

/** Gleiches für OT **/

public function setup_ot_boxes( \WP_Post $post ) {
  add_meta_box(
    'ot_related_brwz_box',
    __('Zugehörige Bodenrichtwertzonen', 'language'),
    array( $this, 'draw_ot_brwz_box' ),
    $post->post_type,
      'advanced',
      'default'
  );
}

public function draw_ot_brwz_box( \WP_Post $post ) {
  $all_brwz = $this->get_all_of_post_type( 'brw_type' );
  $linked_brwz_ids = $this->get_ot_brwz_ids( $post->ID );
  if ( 0 == count($all_brwz) ) {
    $choice_block = '<p>Keine Bodenrichtwertzonen gefunden.</p>';
  } else {
    $choices = array();
    foreach ( $all_brwz as $brwz ) {
      $checked = ( in_array( $brwz->ID, $linked_brwz_ids ) ) ? ' checked="checked"' : '';
      $display_name = esc_attr( $brwz->post_title );
      $choices[] = <<<HTML
      <label><input type="checkbox" name="brwz_ids[]" value="{$brwz->ID}" {$checked}/> {$display_name}</label>
      HTML;
    }
    $choice_block = implode("\r\n", $choices);
  }

  # Make sure the user intended to do this.
  wp_nonce_field(
    "updating_{$post->post_type}_meta_fields",
    $post->post_type . '_meta_nonce'
  );
  echo $choice_block;
}

# Grab all properties related to a specific development area
# Returns an array of property post ids
protected function get_ot_brwz_ids( $ot_id = 0 ) {
  $ids = array();
  if ( 0 < $ot_id ) {
    $matches = get_post_meta( $ot_id, '_brwz_id', false);
    if ( 0 < count($matches) ) {
      $ids[] = $matches;
    }
  }
  return $ids;
}

/** Saving Meta Box Datas **/

public function save_meta_box_data( $post_id = 0, \WP_Post $post = null ) {
  $do_save = true;
  $allowed_post_types = array(
    'ot_type',
    'brw_type'
  );
  # Do not save if we have already saved our updates
  if ( $this->_already_saved ) {
    $do_save = false;
  }
  # Do not save if there is no post id or post
  if ( empty($post_id) || empty( $post ) ) {
    $do_save = false;
  } else if ( ! in_array( $post->post_type, $allowed_post_types ) ) {
    $do_save = false;
  }
  # Do not save for revisions or autosaves
  if (
    defined('DOING_AUTOSAVE')
    && (
      is_int( wp_is_post_revision( $post ) )
      || is_int( wp_is_post_autosave( $post ) )
    )
  ) {
    $do_save = false;
  }
    # Make sure proper post is being worked on
  if ( !array_key_exists('post_ID', $_POST) || $post_id != $_POST['post_ID'] ) {
    $do_save = false;
  }
  # Make sure we have the needed permissions to save [ assumes both types use edit_post ]
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
    $do_save = false;
  }
  # Make sure the nonce and referrer check out.
  $nonce_field_name = $post->post_type . '_meta_nonce';
  if ( ! array_key_exists( $nonce_field_name, $_POST) ) {
    $do_save = false;
  } else if ( ! wp_verify_nonce( $_POST["{$nonce_field_name}"], "updating_{$post->post_type}_meta_fields" ) ) {
    $do_save = false;
  } else if ( ! check_admin_referer( "updating_{$post->post_type}_meta_fields", $nonce_field_name ) ) {
    $do_save = false;
  }
  if ( $do_save ) {
    switch ( $post->post_type ) {
      case "ot_type":
      $this->handle_ot_meta_changes( $post_id, $_POST );
      break;
      case "brw_type":
      $this->handle_brwz_meta_changes( $post_id, $_POST );
      break;
      default:
      # We do nothing about other post types
      break;
    }
    # Note that we saved our data
    $this->_already_saved = true;
  }
  return;
}

# Authors can be linked to multiple books
   # Notice that we are editing book meta data here rather than author meta data
   protected function handle_brwz_meta_changes( $post_id = 0, $data = array() ) {

       # META BOX - Details
       $current_details = $this->get_brwz_details_meta( $post_id );

       if ( array_key_exists('favorite_color', $data) && !empty($data['favorite_color'] ) ) {
           $favorite_color = sanitize_text_field( $data['favorite_color'] );
       } else {
           $favorite_color = '';
       }
       if ( array_key_exists('height', $data) && !empty($data['height'] ) ) {
           $height = sanitize_text_field( $data['height'] );
       } else {
           $height = '';
       }
       if ( array_key_exists('eye_color', $data) && !empty($data['eye_color'] ) ) {
           $eye_color = sanitize_text_field( $data['eye_color'] );
       } else {
           $eye_color = '';
       }

       $changed = false;

       if ( $favorite_color != "{$current_details['favorite_color']}" ) {
           $current_details['favorite_color'] = $favorite_color;
           $changed = true;
       }

       if ( $height != "{$current_details['height']}" ) {
           $current_details['height'] = $height;
           $changed = true;
       }

       if ( $eye_color != "{$current_details['eye_color']}" ) {
           $current_details['eye_color'] = $eye_color;
           $changed = true;
       }

       if ( $changed ) {
           update_post_meta( $post_id, '_brwz_info', $current_details );
       }

       # META BOX - Related Books

       # Get the currently linked books for this author
       $linked_ot_ids = $this->get_brwz_ot_ids( $post_id );

       # Get the list of books checked by the user
       if ( array_key_exists('ot_ids', $data) && is_array( $data['ot_ids'] ) ) {
           $chosen_ot_ids = $data['ot_ids'];
       } else {
           $chosen_ot_ids = array();
       }

       # Build a list of books to be linked or unlinked from this author
       $to_remove = array();
       $to_add = array();

       if ( 0 < count( $chosen_ot_ids ) ) {
           # The user chose at least one book to link to
           if ( 0 < count( $linked_ot_ids ) ) {
               # We already had at least one book linked

               # Cycle through existing and note any that the user did not have checked
               foreach ( $linked_ot_ids as $ot_id ) {
                   if ( ! in_array( $ot_id, $chosen_ot_ids ) ) {
                       # Currently linked, but not chosen. Remove it.
                       $to_remove[] = $ot_id;
                   }
               }

               # Cycle through checked and note any that are not currently linked
               foreach ( $chosen_ot_ids as $ot_id ) {
                   if ( ! in_array( $ot_id, $linked_ot_ids ) ) {
                       # Chosen but not in currently linked. Add it.
                       $to_add[] = $ot_id;
                   }
               }

           } else {
               # No previously chosen ids, simply add them all
               $to_add = $chosen_ot_ids;
           }

       } else if ( 0 < count( $linked_ot_ids ) ) {
           # No properties chosen to be linked. Remove all currently linked.
           $to_remove = $linked_ot_ids;
       }

       if ( 0 < count($to_add) ) {
           foreach ( $to_add as $ot_id ) {
               # We use add post meta with 4th parameter false to let us link
               # books to as many authors as we want.
               add_post_meta( $ot_id, '_brwz_id', $post_id, false );
           }
       }

       if ( 0 < count( $to_remove ) ) {
           foreach ( $to_remove as $ot_id ) {
               # We specify parameter 3 as we only want to delete the link
               # to this author
               delete_post_meta( $ot_id, '_brwz_id', $post_id );
           }
       }
   }


   # Books can be linked with multiple authors
    protected function handle_ot_meta_changes( $post_id = 0, $data = array() ) {

        # Get the currently linked authors for this book
        $linked_brwz_ids = $this->get_ot_brwz_ids( $post_id );

        # Get the list of authors checked by the user
        if ( array_key_exists('brwz_ids', $data) && is_array( $data['brwz_ids'] ) ) {
            $chosen_brwz_ids = $data['brwz_ids'];
        } else {
            $chosen_brwz_ids = array();
        }

        # Build a list of authors to be linked or unlinked with this book
        $to_remove = array();
        $to_add = array();

        if ( 0 < count( $chosen_brwz_ids ) ) {
            # The user chose at least one author to link to
            if ( 0 < count( $linked_brwz_ids ) ) {
                # We already had at least one author already linked

                # Cycle through existing and note any that the user did not have checked
                foreach ( $linked_brwz_ids as $brwz_id ) {
                    if ( ! in_array( $brwz_id, $chosen_brwz_ids ) ) {
                        # Currently linked, but not chosen. Remove it.
                        $to_remove[] = $brwz_id;
                    }
                }

                # Cycle through checked and note any that are not currently linked
                foreach ( $chosen_brwz_ids as $brwz_id ) {
                    if ( ! in_array( $brwz_id, $linked_brwz_ids ) ) {
                        # Chosen but not in currently linked. Add it.
                        $to_add[] = $brwz_id;
                    }
                }

            } else {
                # No previously chosen ids, simply add them all
                $to_add = $chosen_brwz_ids;
            }

        } else if ( 0 < count( $linked_brwz_ids ) ) {
            # No properties chosen to be linked. Remove all currently linked.
            $to_remove = $linked_brwz_ids;
        }

        if ( 0 < count($to_add) ) {
            foreach ( $to_add as $brwz_id ) {
                # We use add post meta with 4th parameter false to let us link
                # to as many authors as we want.
                add_post_meta( $post_id, '_brwz_id', $brwz_id, false );
            }
        }

        if ( 0 < count( $to_remove ) ) {
            foreach ( $to_remove as $brwz_id ) {
                # We specify parameter 3 as we only want to delete the link
                # to this author
                delete_post_meta( $post_id, '_brwz_id', $brwz_id );
            }
        }
    }

} # end of the class declaration


if ( is_admin() ) {
  new Many_To_Many_Linker();
}
