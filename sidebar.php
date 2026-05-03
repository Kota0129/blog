<div class="sidebar__inner">

<div class="sidebar__p">
  <div class="sidebar__p-head">
    <div class="sidebar__p-img">
      <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/8.svg" alt="プロフィール画像">
    </div>
    <p class="sidebar__p-name fw-700">Kota</p>
    <p class="sidebar__p-work">Webコーダー</p>
  </div>
  <div class="sidebar__c">
    <h2 class="sidebar__c-title">経歴</h2>
    <ul class="sidebar__c-list">
      <li class="sidebar__c-item">医療業界で営業職として10年以上勤務</li>
      <li class="sidebar__c-item">独学でWeb制作の学習を開始</li>
      <li class="sidebar__c-item">副業でWeb制作案件を獲得</li>
      <li class="sidebar__c-item">現在は兼業コーダーとして活動中</li>
    </ul>
    <a class="btn sidebar__btn mb fc-white" href="<?php echo esc_url('https://kotaweboffice.com/'); ?>" target="_blank" rel="noopener noreferrer">
      ホームページはこちら
    </a>
    <a class="btn sidebar__btn fc-white" href="<?php echo esc_url('https://x.com/KOO86079816'); ?>" target="_blank" rel="noopener noreferrer">
      X(旧Twitter)はこちら
    </a>
  </div>
</div>
<div class="sidebar__a">
  <h2 class="sidebar__a-title">最新記事</h2>
<ul class="sidebar__a-list">
  <?php
    // 最新の3件の投稿を取得
    $args = array(
      'post_type'      => 'blog', // カスタム投稿タイプ 'blog'
      'posts_per_page' => 2,      // 表示件数を3件に設定
      'orderby'        => 'date', // 日付順
      'order'          => 'DESC', // 降順
    );
    $latest_posts = new WP_Query($args);
  ?>

  <?php if ($latest_posts->have_posts()) : ?>
    <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
      <li class="sidebar__a-item">
        <a class="sidebar__a-link" href="<?php the_permalink(); ?>">
          <h3 class="sidebar__a-subTitle"><?php the_title(); ?></h3>
          <div class="sidebar__a-img">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large'); ?>
            <?php else : ?>
              <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/no-image.png" alt="デフォルト画像">
            <?php endif; ?>
          </div>
        </a>
      </li>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php else : ?>
    <p>最新の記事はありません。</p>
  <?php endif; ?>　
</ul>
</div>

</div>