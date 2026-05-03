<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php wp_head(); ?>
  <!-- Google Fonts の事前接続で高速化 使用時のみ有効化-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header bg-navy">
  <div class="header__inner inner">

    <!-- ロゴ -->
    <h1 class="header__logo">
      <a class="header__logo-link fc-white" href="<?php echo esc_url(home_url('/')); ?>">
        <?php bloginfo('name'); ?>
      </a>
    </h1>

  </div>
</header>