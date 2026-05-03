<?php get_header(); ?>

<div class="container inner">
  <main class="main-content">
    <section class="blog">
      <div class="blog__inner">

        <div class="card-wrapper">
        <?php if ( have_posts() ) : ?>
          <?php while ( have_posts() ) : the_post(); ?>

            <a class="card" href="<?php the_permalink(); ?>">
            <div class="card__image">
              <?php if ( has_post_thumbnail() ) : ?>
                <?php
                the_post_thumbnail( 'large', array(
                  'alt' => get_the_title(),
                ) );
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
        <?php else : ?>
          <p>記事がありません。</p>
        <?php endif; ?>
        </div>

        <!-- ==============================
          ページネーション
        =============================== -->
        <?php
        global $wp_query;

        if ( $wp_query->max_num_pages > 1 ) :

          $big = 999999999;

          $links = paginate_links( array(
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '',
            'current'   => max( 1, get_query_var('paged') ),
            'total'     => $wp_query->max_num_pages,
            'type'      => 'array',
            'prev_next' => false,
          ) );

          $paged = max(1, get_query_var('paged'));
          $prev_page  = ( $paged > 1 ) ? $paged - 1 : false;
          $next_page  = ( $paged < $wp_query->max_num_pages ) ? $paged + 1 : false;
          $last_page  = $wp_query->max_num_pages;
        ?>

        <nav class="page__pagination" aria-label="ページナビゲーション">

          <div class="page__pagination-btn page__pagination-btn-pc c-gray fw-700">

            <?php if ( $paged > 1 ) : ?>
              <div class="page__pagination-first">
                <a href="<?php echo esc_url( get_pagenum_link(1) ); ?>" class="page__pagination-link">
                  最初
                </a>
              </div>
            <?php endif; ?>

            <?php if ( $prev_page ) : ?>
              <div class="page__pagination-prev">
                <a href="<?php echo esc_url( get_pagenum_link($prev_page) ); ?>" class="page__pagination-link">
                  前のページ
                </a>
              </div>
            <?php endif; ?>

          </div>

          <ul class="page__pagination-list fw-700">
            <?php foreach ( $links as $link ) : ?>
              <li class="page__pagination-item">
                <?php echo $link; ?>
              </li>
            <?php endforeach; ?>
          </ul>

          <div class="page__pagination-btn page__pagination-btn-pc c-gray fw-700">

            <?php if ( $next_page ) : ?>
              <div class="page__pagination-next">
                <a href="<?php echo esc_url( get_pagenum_link($next_page) ); ?>" class="page__pagination-link">
                  次のページ
                </a>
              </div>
            <?php endif; ?>

            <?php if ( $paged < $last_page ) : ?>
              <div class="page__pagination-last">
                <a href="<?php echo esc_url( get_pagenum_link($last_page) ); ?>" class="page__pagination-link">
                  最後
                </a>
              </div>
            <?php endif; ?>

          </div>

        </nav>
        <?php endif; ?>

      </div>
    </section>
  </main>

  <aside class="sidebar">
    <?php get_sidebar(); ?>
  </aside>
</div>

<?php get_footer(); ?>