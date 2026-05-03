jQuery(function ($) {
  // 目次生成
  /* =========================================
   *  見出しID自動付与（h2〜h5）
   * ======================================= */

  const $article  = $('.article__content');
  const $headings = $article.find('h2, h3, h4, h5');

  $headings.each(function (index) {
    const $heading = $(this);

    // 見出しのテキストからID生成
    let text = $heading.text().trim();

    // 日本語・英語混在でもIDに変換できるように整形
    let id = text
      .replace(/\s+/g, '-')                    // 空白 → ハイフン
      .replace(/[^\w\-ぁ-んァ-ン一-龥]/g, '')  // 記号削除
      || `heading-${index + 1}`;               // もし空なら連番

    // 重複チェック → あったら連番付与
    let count = 1;
    let newId = id;
    while (document.getElementById(newId)) {
      newId = `${id}-${count}`;
      count++;
    }

    $heading.attr('id', newId);
  });
  /* =========================================
   *  TOC（目次）生成
   * ======================================= */

  const $tocList = $('.toc__list');
  $tocList.empty(); // 既存の目次を削除

  $headings.each(function () {
    const $heading = $(this);
    const id   = $heading.attr('id');
    const text = $heading.text().trim();
    const tag  = $heading.prop('tagName').toLowerCase(); // 'h2', 'h3', 'h4', 'h5'

    let itemClass = `toc__item--${tag}`;
    let linkClass = 'toc__link';

    // H3とH4にスタイル用クラスを追加
    if (tag === 'h3') {
      itemClass += ' toc__item--indent-1';
    } else if (tag === 'h4') {
      itemClass += ' toc__item--indent-2';
      linkClass += ' toc__link--faint';
    }

    const $li = $(`
      <li class="toc__item ${itemClass}">
        <a href="#${id}" class="${linkClass}">${text}</a>
      </li>
    `);

    $tocList.append($li);
  });


  /* =========================================
   *  目次クリックでスムーススクロール
   * ======================================= */

  const headerHeight = $('.header').outerHeight() || 0;

  $(document).on('click', '.toc__link', function (e) {
    e.preventDefault();

    const targetId = $(this).attr('href');
    const $target  = $(targetId);
    if ($target.length === 0) return;

    const position = $target.offset().top - headerHeight - 20;

    $('html, body').animate(
      { scrollTop: position },
      500 // 0.5秒でスクロール
    );
  });

  /* =========================================
   *  目次の開閉
   * ======================================= */

  $(document).on('click', '.toc__header', function (e) {
    e.preventDefault();

    const $toc    = $(this).closest('.js-toc');
    const $body   = $toc.find('.js-toc-body');
    const $toggle = $toc.find('.js-toc-toggle');

    const isOpen = $toggle.attr('aria-expanded') === 'true';

    if (isOpen) {
      // 閉じる
      $body.slideUp(200);
      $toggle.attr('aria-expanded', 'false');
      $toc.removeClass('is-open');
    } else {
      // 開く
      $body.slideDown(200);
      $toggle.attr('aria-expanded', 'true');
      $toc.addClass('is-open');
    }
  });

});