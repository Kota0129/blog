# CODING RULES

## BEM命名規則の遵守

NG例
.card ul li a { ... }

.title { ... }          /* どのコンポーネントのtitleか分からない */
.text-red { ... }       /* 見た目ベースで曖昧 */

OK例
.card { ... }                     /* Block */
.card__title { ... }              /* Element */
.card__text { ... }               /* Element */
.card__link { ... }               /* Element */
.card__link--primary { ... }      /* Modifier */

## CSS 詳細度の統一（クラス1つのみ指定）

NG例
.header .nav ul li a { color: red; }    /* セレクタが長すぎる */
#main .content p { margin-bottom: 20px; } /* ID入りでさらに強い */

OK例
.header__nav { color: red; }
.content__text { margin-bottom: 20px; }
レスポンシブは各セレクタ直下に記述

NG例
.card {
  padding: 1rem;
  font-size: 1.4rem;
}

.card__title {
  font-weight: bold;
  font-size: 1.6rem;
}

/* まとめ書きNG */
@media (min-width: 768px) {
  .card {
    padding: 2rem;
    font-size: 1.6rem;
  }

  .card__title {
    font-size: 2rem;
  }
}

OK例
.card {
  padding: 1rem;
  font-size: 1.4rem;
}
@media (min-width: 768px) {
  .card {
    padding: 2rem;
    font-size: 1.6rem;
  }
}

.card__title {
  font-weight: bold;
  font-size: 1.6rem;
}
@media (min-width: 768px) {
  .card__title {
    font-size: 2rem;
  }
}

## 不要なコメントの削除

NG例
<!-- ここにロゴが入ります -->
<header class="header">
  <div class="header__inner">
    <a href="/" class="header__logo">Site Logo</a>
  </div>
</header>
<!-- ここまでヘッダー -->
/* 赤色にしたかったけどやめた */
/* padding: 20px; */

/* divタグです */
.card {
  padding: 16px; /* paddingを設定 */
  background-color: #fff;
}

/* 修正予定だけど多分消す */
.card--red {
  background-color: red;
}
HTML構造をそのまま説明しているだけのコメント
消したコードのコメントアウト残し
「多分使わない」「一時的」など曖昧なコメント

OK例
<!-- header -->
<header class="header" role="banner">
  <div class="header__inner">
    <a href="/" class="header__logo">Site Logo</a>
  </div>
</header>
<!-- /header -->

/* ============== Card Component ============== */
.card {
  padding: 1.6rem;
  background-color: #fff;
}

/* Modifier: highlight version */
.card--highlight {
  background-color: #fffae6;
}
セクション区切り（header, footerなど）は残す
コンポーネントやModifierの意味を説明するコメントは残す
読む人が意図を理解しやすいコメントだけ

## 単位ルール
・remを基本とするプロパティ
font-size, margin, padding, gap（および column-gap, row-gap）

・px / %を基本とするプロパティ
width, height, min/max-width, min/max-height
レイアウト比率は %
アイコンや画像サイズは px

NG例
.title { font-size: 16px; }   /* NG: font-sizeはrem */
.container { margin: 20px; }  /* NG: marginはrem */
.icon { width: 2rem; }        /* NG: width/heightはpxまたは% */

OK例
.title {
  font-size: 1.6rem; /* 16px */
  margin-bottom: 2rem; /* 20px */
}

.img {
  width: 100%;        /* 親幅いっぱい */
  max-width: 320px;   /* 固定寸法 */
  height: auto;
}

## 画像に alt 属性の記述
NG例
<!-- altなし -->
<img src="/img/counseling">

<!-- 装飾なのに説明を入れる（ノイズ） -->
<img src="/img/sparkle" alt="キラキラのアイコン">

OK例
<!-- 意味のある画像 -->
<img src="/img/counseling" alt="医師による個別カウンセリングの様子" width="640" height="360" loading="lazy">

<!-- 装飾画像 -->
<img src="/img/sparkle" alt="" aria-hidden="true" width="24" height="24">

## セマンティックな HTML 構造
NG例
<div class="header">…</div>       <!-- headerを使うべき -->
<div class="main">
  <div class="section">
    <h2 class="title">…</h2>
  </div>
</div>
OK例

<header role="banner">
  <div class="header__inner">…</div>
</header>

<main id="main">
  <section aria-labelledby="about-title">
    <h2 id="about-title">クリニックについて</h2>
    <article>
      <h3>個別カウンセリング</h3>
      <p>…</p>
    </article>
  </section>
</main>

<footer role="contentinfo">…</footer>
ページ骨格：header / main / footer
内容のまとまり：section / article / aside / nav
sectionには見出し（または aria-labelledby）を付ける

## aria-label 属性の追加
NG例

<!-- 可視テキストがあるのに重複 -->
<a href="/reserve" aria-label="無料カウンセリング">無料カウンセリング</a>

<!-- 曖昧なラベル -->
<button aria-label="クリック">…</button>
OK例
<!-- アイコンのみのボタン -->
<button class="header__toggle" aria-label="メニューを開く" aria-controls="g-nav" aria-expanded="false">
  <span class="icon-menu" aria-hidden="true"></span>
</button>

<!-- ナビゲーション領域の説明 -->
<nav class="header__nav" id="g-nav" aria-label="グローバルナビ">…</nav>

<!-- アイコンリンクの補足 -->
<a href="/reserve" aria-label="無料カウンセリング予約へ移動">
  <span class="icon-arrow" aria-hidden="true"></span>
</a>
・可視テキストがない/不足時のみ使用
・ランドマーク（nav/aside/sectionなど）には説明を付与

## 適切な見出し構造（h1 → h2 → h3）
NG例

<h1>BEAUTY CLINIC Ebisu</h1>
<h1>サービス</h1>   <!-- h1複数はNG -->

<h2>料金</h2>
<h4>全身脱毛</h4>   <!-- h3を飛ばすのはNG -->

<p class="big-title">アクセス</p> <!-- 見出しをpで代用 -->
OK例

<main>
  <h1>BEAUTY CLINIC Ebisu</h1>

  <section>
    <h2>サービス</h2>
    <article>
      <h3>医療レーザー脱毛</h3>
      <p>…</p>
    </article>
  </section>

  <section>
    <h2>料金</h2>
    <h3>全身脱毛</h3>
    <h3>VIO脱毛</h3>
  </section>
</main>
h1はページに1つ（ロゴ代用はCSSで）
見出し階層は飛ばさない（h2直下にh4は置かない）

## 見た目の差分はマルチクラスで拡張

目的：
ベースクラス（＝骨格）に色・影などの見た目を直接書かず、
見た目の違いはマルチクラス（複数クラスの組み合わせ）で表現する。
これにより保守性・再利用性を高め、CSSの上書きを最小化する。

❌ NG例（ベースクラスに見た目を含めている）
/* NG：ベースに色や装飾が入ってしまっている */
.btn {
  display: inline-block;
  width: 300px;
  padding: 16px;
  border-radius: 4px;
  text-align: center;
  font-size: 1.6rem;
  line-height: 1.5;
  background-color: #2563eb; /* ← ベースに色指定NG */
  color: #fff;               /* ← 見た目を固定してしまう */
}

/* 他の色を使うたびに上書きが必要 */
.btn--warning {
  background-color: #e11d48;
}

<!-- NG：ベース自体に色が固定されている -->
<button class="btn">送信する</button>
<button class="btn btn--warning">削除する</button>


問題点
・.btn にデザインが固定されており、別色ボタンを作るたびに上書きが必要。
・「形」と「見た目」が分離できていないため、保守性が低下する。
・案件ごとのトンマナ変更に対応しづらい。

✅ OK例（ベース＋見た目クラスの組み合わせ）
/* ベース：形・余白・フォントなど“骨格”のみ */
.btn {
  display: inline-block;
  width: 300px;
  padding: 16px;
  border-radius: 4px;
  text-align: center;
  font-size: 1.6rem;
  line-height: 1.5;
}

/* 見た目は別クラスで拡張 */
.hp-primary {
  background-color: #2563eb;
  color: #fff;
}

.hp-warning {
  background-color: #e11d48;
  color: #fff;
}

.btn--outline {
  background-color: transparent;
  border: 1px solid #ddd;
  color: #222;
}

<!-- OK：ベースと見た目を分離して拡張 -->
<button class="btn hp-primary">送信する</button>
<button class="btn hp-warning">削除する</button>
<a href="#" class="btn btn--outline">詳細を見る</a>


ポイント
・.btn は「共通の骨格」だけを定義。
・.hp-*（テーマカラー）や .btn--*（バリエーション）で見た目を切り替える。
・HTML側で複数クラスを組み合わせることで柔軟に拡張可能。
・新しい色・スタイルを追加しても既存のボタンへ影響なし。

## Flexboxの子要素に対する幅指定の徹底

目的：
ブラウザ間の差異やコンテンツ量によるレイアウト崩れを防ぐため、
Flexboxの子要素（Flex Item）には必ず幅の基準（width または flex-basis）を指定する。

❌ NG例（子要素に幅指定がない）
.flex-container {
  display: flex;
}
/* 子要素のコンテンツ量に依存して幅がバラバラになる */
.flex-item {
  padding: 1.6rem;
}

✅ OK例（width または flex-basis で基準を明示）
.flex-container {
  display: flex;
  gap: 2rem;
}

.flex-item {
  width: calc(50% - 1rem); /* 2カラムの場合 */
  /* または */
  flex-basis: 50%;
}

ポイント：
・等幅に並べる場合は width: 0; flex-grow: 1; などの手法も許容する。
・レスポンシブで 100% に戻す際も、明示的に width: 100%; を記述すること。