<?php
$terms = get_the_terms( $post->ID, 'ot_tax' );
foreach($terms as $term): ?>
<h4><?php echo $term->name; ?></h4>
<?php
$post_args = array(
      'posts_per_page' => 1,
      'post_type' => 'brw_type', // you can change it according to your custom post type
      'orderby'=>'meta_value_num',
      'order'=>'ASC',
      'meta_key'=>'bodenrichtwerte_2020',
      'tax_query' => array(
          array(
              'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
              'field' => 'term_id', // this can be 'term_id', 'slug' & 'name'
              'terms' => $term->term_id,
          )
      )
);
$myposts = get_posts($post_args); ?>
<ul>
<?php foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
  <li>
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <?php $brw2020_n = get_post_meta($post->ID,'bodenrichtwerte_2020',true);
    echo '2019 Min: ' . $brw2020_n; ?>
  </li>
<?php endforeach; // Term Post foreach ?>
</ul>
<?php wp_reset_postdata(); ?>

<?php
$post_args = array(
      'posts_per_page' => 1,
      'post_type' => 'brw_type', // you can change it according to your custom post type
      'orderby'=>'meta_value_num',
      'order'=>'DESC',
      'meta_key'=>'bodenrichtwerte_2020',
      'tax_query' => array(
          array(
              'taxonomy' => 'ot_tax', // you can change it according to your taxonomy
              'field' => 'term_id', // this can be 'term_id', 'slug' & 'name'
              'terms' => $term->term_id,
          )
      )
);
$myposts = get_posts($post_args); ?>
<ul>
<?php foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
  <li>
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <?php $brw2020_x = get_post_meta($post->ID,'bodenrichtwerte_2020',true);
    echo '2020 MAX: ' . $brw2020_x; ?>
  </li>
<?php endforeach; // Term Post foreach ?>
</ul>
<?php wp_reset_postdata(); ?>

<?php endforeach; // End Term foreach; ?>
