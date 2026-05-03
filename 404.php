<?php get_header(); ?>

<main class="main-content error404">
  <div class="error__inner inner">
    <h1 class="error__title">404 Not Found</h1>
    <p class="error__text">ページが見つかりませんでした。</p>
    <div class="error__image">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/error__cat.png" alt="404エラー画像">
    </div>
    <a class="btn error__btn fc-white fw-600" href="<?php echo home_url(); ?>">トップへ戻る</a>
  </div>
</main>

<?php get_footer(); ?>