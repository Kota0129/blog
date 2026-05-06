<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-N5SRMWHW11"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-N5SRMWHW11');
</script>

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
    <!-- <nav class="header__nav">
      <ul class="header__nav-list">
        <li class="header__nav-item">
          <a class="header__nav-link fc-white" href="<?php echo esc_url(home_url('/')); ?>">プロフィール</a>
        </li>
        <li class="header__nav-item">
          <a class="header__nav-link fc-white" href="<?php echo esc_url(home_url('/')); ?>">お問い合わせ</a>
        </li>
      </ul>
    </nav> -->

  </div>
</header>