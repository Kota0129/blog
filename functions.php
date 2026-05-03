<?php
/* =========================================
 * テーマの基本設定
 * ======================================= */
function start_theme_setup() {
  // titleタグを自動出力
  add_theme_support('title-tag');

  // アイキャッチ画像を有効化
  add_theme_support('post-thumbnails');

  // HTML5対応
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    )
  );
}
add_action('after_setup_theme', 'start_theme_setup');


/* =========================================
 * CSSファイルを読み込む共通関数
 * ======================================= */
function start_enqueue_theme_style($handle, $file_path, $deps = array()) {
  $path = get_theme_file_path($file_path);
  $uri  = get_theme_file_uri($file_path);

  if (file_exists($path)) {
    wp_enqueue_style(
      $handle,
      $uri,
      $deps,
      filemtime($path),
      'all'
    );
  }
}


/* =========================================
 * CSS / JS の読み込み
 * ※ フォントやslickは案件ごとに必要なものだけ有効化
 * ======================================= */
function start_enqueue_scripts() {

  /* ---------- リセットCSS ---------- */
  wp_enqueue_style(
    'ress',
    'https://unpkg.com/ress/dist/ress.min.css',
    array(),
    null,
    'all'
  );

  /* ---------- Google Fonts（必要に応じて切替） ---------- */
  wp_enqueue_style(
    'google-fonts',
    '"https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Noto+Sans+JP:wght@100..900&display=swap"',
    array(),
    null,
    'all'
  );

  /* ---------- 共通CSS ---------- */
  start_enqueue_theme_style(
    'start-common',
    '/css/common.css',
    array('ress', 'google-fonts')
  );

  /* ---------- ページ別CSS（必要なものだけ読み込み） ---------- */
  if (is_front_page()) {
    start_enqueue_theme_style(
      'start-top',
      '/css/top.css',
      array('start-common')
    );
  }

  // single-blog.php用
  if (is_singular('blog')) {
    start_enqueue_theme_style(
      'start-single-blog',
      '/css/single-blog.css',
      array('start-common')
    );
  }

  // taxonomy-blog-cat.php用
  if (is_tax('blog-cat')) {
    start_enqueue_theme_style(
      'start-taxonomy-blog-cat',
      '/css/taxonomy-blog-cat.css',
      array('start-common')
    );
  }

  // if (is_page('about')) {
  //   start_enqueue_theme_style(
  //     'start-about',
  //     '/css/about.css',
  //     array('start-common')
  //   );
  // }


  /* ---------- slick 使用時のみ有効化 ---------- */
  /*
  start_enqueue_theme_style(
    'slick-css',
    '/css/slick.css'
  );

  start_enqueue_theme_style(
    'slick-theme-css',
    '/css/slick-theme.css',
    array('slick-css')
  );

  $slick_js_path = get_theme_file_path('/js/slick.min.js');
  $slick_js_uri  = get_theme_file_uri('/js/slick.min.js');

  if (file_exists($slick_js_path)) {
    wp_enqueue_script(
      'slick-js',
      $slick_js_uri,
      array('jquery'),
      filemtime($slick_js_path),
      true
    );
  }
  */

  /* ---------- メインJS ---------- */
  $script_path = get_theme_file_path('/js/script.js');
  $script_uri  = get_theme_file_uri('/js/script.js');

  if (file_exists($script_path)) {
    wp_enqueue_script(
      'start-script',
      $script_uri,
      array('jquery'),
      filemtime($script_path),
      true
    );

    // defer を付与
    wp_script_add_data('start-script', 'strategy', 'defer');
  }
}
add_action('wp_enqueue_scripts', 'start_enqueue_scripts');


/* =========================================
 * 自動 <p> / <br> の制御
 * ======================================= */

// 固定ページの自動 <p> / <br> 挿入を停止
function start_disable_wpautop_for_page($content) {
  if (is_page()) {
    remove_filter('the_content', 'wpautop');
  }
  return $content;
}
add_filter('the_content', 'start_disable_wpautop_for_page', 9);

// Contact Form 7 の自動 <p> / <br> 挿入を停止
add_filter('wpcf7_autop_or_not', '__return_false');


/* =========================================
 * 管理画面から「投稿」を非表示にする
 * ※ 投稿機能を使わない案件のみ有効化
 * ======================================= */

function start_remove_menus() {
  remove_menu_page('edit.php');
}
add_action('admin_menu', 'start_remove_menus');


/* =========================================
 * カスタム投稿・タクソノミーは案件ごとに追加
 * 必要時のみ下に追記
 * ======================================= */

function start_create_post_type() {

  register_post_type(
    'blog',
    array(
      'label'        => 'ブログ',
      'public'       => true,
      'has_archive'  => true,
      'show_in_rest' => true,
      'rewrite'      => array( 'slug' => 'blog' ),
      'menu_position'=> 5,
      'supports'     => array(
        'title',
        'editor',
        'thumbnail',
        'revisions',
      ),
    )
  );

  register_taxonomy(
    'blog-cat',
    'blog',
    array(
      'label'        => 'カテゴリー',
      'hierarchical' => true,
      'public'       => true,
      'show_in_rest' => true,
    )
  );
}
add_action('init', 'start_create_post_type');

function my_blog_home_query( $query ) {
  if ( is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( $query->is_home() ) {
    $query->set( 'post_type', 'blog' );
    $query->set( 'posts_per_page', 12 );
  }
}
add_action( 'pre_get_posts', 'my_blog_home_query' );