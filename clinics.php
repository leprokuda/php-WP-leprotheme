<?php
  /*
  Template Name: clinics
  Template Post Type: post, page, product, cas
  */
  get_header();


?>

<body>
  <div class="header container">
      <?php
        wp_nav_menu([
          'theme_location' => 'top',
          'container' => 'container',
          'menu_class' => 'header__menu',
          'menu_id' => ''
        ])
      ?>
  </div>

  <div class="clinics container">
    <h2 class="page-title"><?php the_title();?></h2>
    <div class="clinics__cards">
      <?php
        // параметры по умолчанию
        $my_posts = get_posts( array(
          'numberposts' => 4,
          'post_type'   => 'clinics',
          'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
        ) );
        global $post;
        foreach( $my_posts as $post ){
          setup_postdata( $post );
          ?>
            <div class="clinics__card">
                <h3><?php the_title();?></h3>
                <p><?php echo get_field('place'); ?></p>
                <div><?php echo get_the_tag_list('<small>Метки: ',', ','</small>'); ?></div>
            </div>
          <?php
        }
        wp_reset_postdata(); // сброс
      ?>
    </div>
    
  </div>

</body>

<?php get_footer(); ?>
