<?php
//  Добавление скриптов и стилей
  add_action('wp_enqueue_scripts', 'add_styles'); // Подключаем стили

//
  function add_styles() {
    wp_enqueue_style('my-style', get_stylesheet_uri());
  }
  
// Добавление меню и функций в админку
  add_action('after_setup_theme', 'add_menu');
  
  function add_menu() {
    register_nav_menu('top', 'Главное меню');
    register_nav_menu('bottom', 'Клиники');
    add_theme_support('post-formats', array('aside', 'gallery', ));
    add_theme_support('post_thumbnails', array('post', 'clinics', 'services'));
    add_theme_support('title-tag');
    
  }
  
  add_action( 'init', 'register_post_types' );
  
  function register_post_types(){
    // Создание кастомного типа записи КЛИНИКИ
    register_post_type( 'clinics', [
      'label'  => null,
      'labels' => [
        'name'               => 'Клиники', // основное название для типа записи
        'singular_name'      => 'Клиника', // название для одной записи этого типа
        'add_new'            => 'Добавить клинику', // для добавления новой записи
        'add_new_item'       => 'Добавление клиники', // заголовка у вновь создаваемой записи в админ-панели.
        'edit_item'          => 'Редактирование клиники', // для редактирования типа записи
        'new_item'           => 'Новая клиника', // текст новой записи
        'view_item'          => 'Смотреть клинику', // для просмотра записи этого типа.
        'search_items'       => 'Искать клинику', // для поиска по этим типам записи
        'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
        'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
        'parent_item_colon'  => '', // для родителей (у древовидных типов)
        'menu_name'          => 'Клиники', // название меню
      ],
      'description'         => 'Это все клиники, добавленные в админке',
      'public'              => true,
      'publicly_queryable'  => true, // зависит от public
      'exclude_from_search' => true, // зависит от public
      'show_ui'             => true, // зависит от public
      'show_in_nav_menus'   => true, // зависит от public
      'show_in_menu'        => true, // показывать ли в меню адмнки
      'show_in_admin_bar'   => true, // зависит от show_in_menu
      'show_in_rest'        => true, // добавить в REST API. C WP 4.7
      'rest_base'           => null, // $post_type. C WP 4.7
      'menu_position'       => 4,
      'menu_icon'           => 'dashicons-email-alt2',
      //'capability_type'   => 'post',
      //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
      //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
      'hierarchical'        => false,
      'supports'            => [ 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
      'taxonomies'          => [],
      'has_archive'         => false,
      'rewrite'             => true,
      'query_var'           => true,
    ] );
  
    // Создание кастомного типа записи УСЛУГИ
    register_post_type( 'services', [
      'label'  => null,
      'labels' => [
        'name'               => 'Услуги', // основное название для типа записи
        'singular_name'      => 'Услуга', // название для одной записи этого типа
        'add_new'            => 'Добавить услугу', // для добавления новой записи
        'add_new_item'       => 'Добавление услуги', // заголовка у вновь создаваемой записи в админ-панели.
        'edit_item'          => 'Редактирование услуги', // для редактирования типа записи
        'new_item'           => 'Новая услуга', // текст новой записи
        'view_item'          => 'Смотреть услугу', // для просмотра записи этого типа.
        'search_items'       => 'Искать услугу', // для поиска по этим типам записи
        'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
        'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
        'parent_item_colon'  => '', // для родителей (у древовидных типов)
        'menu_name'          => 'Услуги', // название меню
      ],
      'description'         => 'Это все клиники, добавленные в админке',
      'public'              => true,
      'publicly_queryable'  => true, // зависит от public
      'exclude_from_search' => true, // зависит от public
      'show_ui'             => true, // зависит от public
      'show_in_nav_menus'   => true, // зависит от public
      'show_in_menu'        => true, // показывать ли в меню адмнки
      'show_in_admin_bar'   => true, // зависит от show_in_menu
      'show_in_rest'        => true, // добавить в REST API. C WP 4.7
      'rest_base'           => null, // $post_type. C WP 4.7
      'menu_position'       => 4,
      'menu_icon'           => 'dashicons-cart',
      //'capability_type'   => 'post',
      //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
      //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
      'hierarchical'        => false,
      'supports'            => [ 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
      'taxonomies'          => array('clinics'),
      'has_archive'         => false,
      'rewrite'             => true,
      'query_var'           => true,
    ] );
  }
  
  // Создание Таксономии
  add_action( 'init', 'create_taxonomy' );
  function create_taxonomy(){
    
    // список параметров: wp-kama.ru/function/get_taxonomy_labels
    register_taxonomy( 'clinics', [ 'services' ], [
      'label'                 => '', // определяется параметром $labels->name
      'labels'                => [
        'name'              => 'Клиники',
        'singular_name'     => 'Клиника',
        'search_items'      => 'Найти клиники',
        'all_items'         => 'Все клиники',
        'view_item '        => 'Смотреть все клиники',
        'parent_item'       => 'Родительская клиника',
        'parent_item_colon' => 'Родительская клиника:',
        'edit_item'         => 'Edit Genre',
        'update_item'       => 'Обновить клинику',
        'add_new_item'      => 'Добавить новую клинику',
        'new_item_name'     => 'Новое имя клиники',
        'menu_name'         => 'Клиники',
        'back_to_items'     => '← Вернуться к клиникам',
      ],
      'description'           => 'Все клиники города', // описание таксономии
      'public'                => true,
      'publicly_queryable'    => null, // равен аргументу public
      'show_in_nav_menus'     => true, // равен аргументу public
      'show_ui'               => true, // равен аргументу public
      'show_in_menu'          => true, // равен аргументу show_ui
      'show_tagcloud'         => true, // равен аргументу show_ui
      'show_in_quick_edit'    => null, // равен аргументу show_ui
      'hierarchical'          => false,
      'rewrite'               => true,
    ] );
  }
?>