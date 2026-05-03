<?php get_header(); ?>

<nav class="breadcrumb">
  <ol class="breadcrumb__list inner fw-700" itemscope itemtype="http://schema.org/BreadcrumbList">

    <!-- TOP -->
    <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
      <a class="breadcrumb__link" itemprop="item" href="<?php echo esc_url(home_url()); ?>">
        <span itemprop="name">top</span>
      </a>
      <meta itemprop="position" content="1" />
    </li>

    <!-- カテゴリ -->
    <?php
    $terms = get_the_terms(get_the_ID(), 'blog-cat');
    if (!empty($terms) && !is_wp_error($terms)) :
      $term = $terms[0]; // 1つ目を使う
    ?>
      <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a class="breadcrumb__link" itemprop="item" href="<?php echo esc_url(get_term_link($term)); ?>">
          <span itemprop="name"><?php echo esc_html($term->name); ?></span>
        </a>
        <meta itemprop="position" content="2" />
      </li>
    <?php endif; ?>

    <!-- 記事タイトル -->
    <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
      <span itemprop="name"><?php the_title(); ?></span>
      <meta itemprop="position" content="3" />
    </li>

  </ol>
</nav>

<div class="container inner">
  <main class="main-content">
    <section class="article">
        <div class="article__inner">
            <div class="article__head">
                <h1 class="article__title"><?php the_title(); ?></h1>
                <div class="article__dateCat">
                    <?php
                        $terms = get_the_terms(get_the_ID(), 'blog-cat'); 
                        if (!empty($terms) && !is_wp_error($terms)) :
                            $term = $terms[0];
                        ?>
                            <p class="article__cat bg-navy fc-white inter">
                                <?php echo esc_html($term->name); ?>
                            </p>
                    <?php endif; ?>
                    <p class="article__date"><?php echo get_the_date('Y年n月j日'); ?></p>
                </div>
            </div>
            <div class="article__image">
            <?php
                if (has_post_thumbnail()) :
                the_post_thumbnail('large', [
                    'alt' => get_the_title()
                ]);
                else :
            ?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/no-image.png" alt="アイキャッチ画像なしのためのデフォルト画像">
                <?php endif; ?>
            </div>
            <!-- 目次 -->
            <div class="toc js-toc is-open">
                <button class="toc__header js-toc-toggle" aria-expanded="true">
                    <span class="toc__title fw-500">目次</span>

                    <span class="toc__icon">
                    <svg width="21" height="12" viewBox="0 0 21 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.3926 0L20.7849 11.25H0.000273705L10.3926 0Z" fill="#C8C8C8" />
                    </svg>
                    </span>
                </button>

                <div class="toc__body js-toc-body">
                    <ul class="toc__list">
                    <!-- JSで自動生成 -->
                    </ul>
                </div>
            </div>
            <!-- /.toc -->
            <div class="article__content">
                <?php the_content(); ?>
            </div>

            <!-- ピックアップ -->
             <div class="article__cat">
                <h2 class="cat-title inter">Category</h2>
                <?php
                    $terms = get_terms(array(
                    'taxonomy'   => 'blog-cat',
                    'hide_empty' => false, // 投稿がなくても表示するなら false
                    ));

                    if (!empty($terms) && !is_wp_error($terms)) :
                    ?>
                    <ul class="cat-list">
                        <?php foreach ($terms as $term) : ?>
                        <li class="cat-list__item">
                            <a class="cat-list__link inter bg-navy fc-white"
                            href="<?php echo esc_url(get_term_link($term)); ?>">
                            <?php echo esc_html($term->name); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
             </div>

            <div class="article__a-wrapper">
                <h2 class="article__a-title">関連記事</h2>
                <ul class="article__a-list">
                <?php
                // 現在の投稿IDを取得
                $current_post_id = get_the_ID();

                // 現在の投稿のカテゴリーを取得
                $categories = get_the_terms($current_post_id, 'blog-cat');

                if (!empty($categories) && !is_wp_error($categories)) {
                    // カテゴリーIDを配列に変換
                    $category_ids = wp_list_pluck($categories, 'term_id');

                    // 関連記事のクエリ
                    $args = array(
                        'post_type'      => 'blog', // カスタム投稿タイプ 'blog'
                        'posts_per_page' => 3,      // 表示件数を3件に設定
                        'orderby'        => 'date', // 日付順
                        'order'          => 'DESC', // 降順
                        'post__not_in'   => array($current_post_id), // 現在の投稿を除外
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'blog-cat',
                                'field'    => 'term_id',
                                'terms'    => $category_ids,
                            ),
                        ),
                    );
                    $related_posts = new WP_Query($args);
                ?>

                <?php if ($related_posts->have_posts()) : ?>
                    <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                        <li class="article__a-item">
                            <a class="article__a-link" href="<?php the_permalink(); ?>">
                                <div class="article__a-img">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large'); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/no-image.png" alt="デフォルト画像">
                                    <?php endif; ?>
                                </div>
                                <h3 class="article__a-subTitle"><?php the_title(); ?></h3>
                            </a>
                        </li>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p>関連記事はありません。</p>
                <?php endif; ?>
                <?php } ?>
            </ul>
            </div>
            
        </div>
    </section>
      
  </main>

  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>

<?php get_footer(); ?>