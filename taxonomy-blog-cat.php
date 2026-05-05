<?php get_header(); ?>

<nav class="breadcrumb">
  <ol class="breadcrumb__list fw-700" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
      <a class="breadcrumb__link" itemprop="item" href="<?php echo esc_url( home_url() ); ?>">
        <span itemprop="name">top</span>
      </a>
      <meta itemprop="position" content="1" />
    </li>
    <li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
      <span itemprop="name"><?php single_term_title(); ?></span>
      <meta itemprop="position" content="2" />
    </li>
  </ol>
</nav>

<div class="container inner">
  <main class="main-content">
    <section class="archive">
      <div class="archive__inner">
        <h1 class="archive__title">
          <?php single_term_title(); ?><span class="archive__title-c fw-700">最新の投稿</span>
        </h1>

        <div class="archive__content">
          <div class="card-wrapper">
            <?php
            $current_term = get_queried_object();

            // ページ番号を取得
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            $args = array(
              'post_type'      => 'blog',
              'posts_per_page' => 12,
              'paged'          => $paged,
              'orderby'        => 'date',
              'order'          => 'DESC',
              'tax_query'      => array(
                array(
                  'taxonomy' => 'blog-cat',
                  'field'    => 'term_id',
                  'terms'    => $current_term->term_id,
                ),
              ),
            );

            $results_query = new WP_Query($args);
            ?>

            <?php if ($results_query->have_posts()) : ?>
              <?php while ($results_query->have_posts()) : $results_query->the_post(); ?>

                <a class="card" href="<?php the_permalink(); ?>">
                <div class="card__image">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php
                    the_post_thumbnail('large', array(
                      'alt' => get_the_title(),
                    ));
                    ?>
                  <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/no-image.png" alt="<?php echo esc_attr( get_the_title() . 'のデフォルト画像' ); ?>">
                  <?php endif; ?>
                </div>

                  <div class="card__body">
                    <h3 class="card__title"><?php the_title(); ?></h3>
                    <div class="card__content">
                      <p class="card__date"><?php echo get_the_date('Y年n月j日'); ?></p>
                      <?php
                      $terms = get_the_terms(get_the_ID(), 'blog-cat');
                      if (!empty($terms) && !is_wp_error($terms)) :
                        $term = $terms[0];
                      ?>
                        <p class="card__cat bg-navy fc-white inter">
                          <?php echo esc_html($term->name); ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  </div>
                </a>

              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
            <?php else : ?>
              <p>該当する記事はありません。</p>
            <?php endif; ?>
          </div>

          <!-- ==============================
            ページネーション
          =============================== -->
          <?php
          if ( $results_query->max_num_pages > 1 ) :

            $big = 999999999;

            $links = paginate_links( array(
              'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
              'format'    => '?paged=%#%',
              'current'   => max( 1, $paged ),
              'total'     => $results_query->max_num_pages,
              'type'      => 'array',
              'prev_next' => false,
            ) );

            $prev_page = ( $paged > 1 ) ? $paged - 1 : false;
            $next_page = ( $paged < $results_query->max_num_pages ) ? $paged + 1 : false;
            $last_page = $results_query->max_num_pages;
          ?>

<nav class="page__pagination" aria-label="ページナビゲーション">

<!-- 左側ボタンエリア -->
<div class="page__pagination-btn page__pagination-btn-pc c-gray fw-700">
  <div class="page__pagination-first">
    <?php if ( $paged > 1 ) : ?>
      <a href="<?php echo esc_url( get_pagenum_link( 1 ) ); ?>" class="page__pagination-link">最初</a>
    <?php endif; ?>
  </div>

  <div class="page__pagination-prev">
    <?php if ( $prev_page ) : ?>
      <a href="<?php echo esc_url( get_pagenum_link( $prev_page ) ); ?>" class="page__pagination-link">前のページ</a>
    <?php endif; ?>
  </div>
</div>

<!-- 中央数字エリア -->
<ul class="page__pagination-list fw-700">
  <?php foreach ( $links as $link ) : ?>
    <li class="page__pagination-item">
      <?php echo $link; ?>
    </li>
  <?php endforeach; ?>
</ul>

<!-- 右側ボタンエリア -->
<div class="page__pagination-btn page__pagination-btn-pc c-gray fw-700">
  <div class="page__pagination-next">
    <?php if ( $next_page ) : ?>
      <a href="<?php echo esc_url( get_pagenum_link( $next_page ) ); ?>" class="page__pagination-link">次のページ</a>
    <?php endif; ?>
  </div>

  <div class="page__pagination-last">
    <?php if ( $paged < $last_page ) : ?>
      <a href="<?php echo esc_url( get_pagenum_link( $last_page ) ); ?>" class="page__pagination-link">最後</a>
    <?php endif; ?>
  </div>
</div>

</nav>
          <?php endif; ?>
        </div>

        <div class="archive__cat">
          <h2 class="cat-title inter">Category</h2>
          <ul class="cat-list">
            <?php
            $terms = get_terms(array(
              'taxonomy'   => 'blog-cat',
              'hide_empty' => false,
              'exclude'    => array($current_term->term_id),
            ));

            if (!empty($terms) && !is_wp_error($terms)) :
              foreach ($terms as $term) :
            ?>
                <li class="cat-list__item">
                  <a class="cat-list__link inter bg-navy fc-white" href="<?php echo esc_url(get_term_link($term)); ?>">
                    <?php echo esc_html($term->name); ?>
                  </a>
                </li>
            <?php
              endforeach;
            endif;
            ?>
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