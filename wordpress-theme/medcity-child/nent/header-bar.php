<?php
/* Nairobi ENT redesign – site header + mobile drawer. */
if (!defined('ABSPATH')) exit;
$nent_menu = nent_menu();
$nent_logo = nent_img('2024/10/ENT-Logo-dark.svg');
?>
<a class="nent-skip" href="#content">Skip to content</a>
<header class="nent-header" data-nent-header>
  <div class="nent-header__inner">
    <a class="nent-logo" href="<?php echo esc_url(nent_u('/')); ?>" aria-label="Nairobi ENT Clinic – home">
      <img src="<?php echo esc_url($nent_logo); ?>" alt="Nairobi ENT Clinic" width="88" height="61">
    </a>
    <nav class="nent-nav" aria-label="Main">
      <ul class="nent-nav__list">
        <?php foreach ($nent_menu as $i => $item) : ?>
          <?php if (!empty($item['url'])) : ?>
            <li><a class="nent-nav__link" href="<?php echo esc_url(nent_u($item['url'])); ?>"><?php echo esc_html($item['label']); ?></a></li>
          <?php elseif (!empty($item['mega'])) : ?>
            <li class="nent-has-drop nent-has-mega">
              <button class="nent-nav__link" type="button" aria-expanded="false" aria-controls="nent-drop-<?php echo $i; ?>"><?php echo esc_html($item['label']); ?><?php echo nent_icon('chevron', 16); ?></button>
              <div class="nent-mega nent-mega--<?php echo esc_attr($item['mega']); ?>" id="nent-drop-<?php echo $i; ?>">
                <div class="nent-mega__cols">
                  <?php foreach ($item['cols'] as $head => $links) : ?>
                    <div class="nent-mega__col">
                      <p class="nent-mega__head"><?php echo esc_html($head); ?></p>
                      <ul>
                        <?php foreach ($links as $l) : ?>
                          <li><a href="<?php echo esc_url(nent_u($l[1])); ?>"><?php echo esc_html($l[0]); ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endforeach; ?>
                </div>
                <?php if ($item['mega'] === 'services') : ?>
                  <a class="nent-mega__feature" href="<?php echo esc_url(nent_book_url()); ?>">
                    <img src="<?php echo esc_url(nent_img('2024/10/IMG_2720-600x400.jpg')); ?>" alt="" loading="lazy" width="600" height="400">
                    <span class="nent-mega__feature-body">
                      <strong>Not sure where to start?</strong>
                      <span>Book a consultation and our ENT surgeons will guide you.</span>
                      <span class="nent-link">Book appointment <?php echo nent_icon('arrow', 16); ?></span>
                    </span>
                  </a>
                <?php endif; ?>
              </div>
            </li>
          <?php else : ?>
            <li class="nent-has-drop">
              <button class="nent-nav__link" type="button" aria-expanded="false" aria-controls="nent-drop-<?php echo $i; ?>"><?php echo esc_html($item['label']); ?><?php echo nent_icon('chevron', 16); ?></button>
              <div class="nent-drop" id="nent-drop-<?php echo $i; ?>">
                <ul>
                  <?php foreach ($item['items'] as $l) : $ext = strpos($l[1], 'http') === 0; ?>
                    <li><a href="<?php echo esc_url($ext ? $l[1] : nent_u($l[1])); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($l[0]); ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="nent-header__cta">
      <a class="nent-header__phone" href="<?php echo esc_attr(nent_tel()); ?>"><span class="nent-header__phone-ic"><?php echo nent_icon('phone', 16); ?></span><span><?php echo esc_html(nent_phone()); ?></span></a>
      <a class="nent-btn nent-btn--primary nent-btn--sm nent-header__book" href="<?php echo esc_url(nent_book_url()); ?>"><span class="nent-hide-sm">Book appointment</span><span class="nent-show-sm">Book</span></a>
      <button class="nent-burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="nent-drawer" data-nent-burger><?php echo nent_icon('menu', 24); ?></button>
    </div>
  </div>
</header>

<div class="nent-drawer" id="nent-drawer" data-nent-drawer aria-hidden="true">
  <div class="nent-drawer__panel" role="dialog" aria-modal="true" aria-label="Menu">
    <div class="nent-drawer__top">
      <img src="<?php echo esc_url($nent_logo); ?>" alt="Nairobi ENT Clinic" width="70" height="48">
      <button class="nent-drawer__close" type="button" aria-label="Close menu" data-nent-close><?php echo nent_icon('x', 24); ?></button>
    </div>
    <nav class="nent-drawer__nav" aria-label="Mobile">
      <a class="nent-drawer__link" href="<?php echo esc_url(nent_u('/')); ?>">Home</a>
      <?php foreach ($nent_menu as $item) : ?>
        <?php if (!empty($item['url'])) : ?>
          <a class="nent-drawer__link" href="<?php echo esc_url(nent_u($item['url'])); ?>"><?php echo esc_html($item['label']); ?></a>
        <?php else : ?>
          <details class="nent-drawer__group">
            <summary class="nent-drawer__link"><?php echo esc_html($item['label']); ?><?php echo nent_icon('chevron', 18); ?></summary>
            <div class="nent-drawer__sub">
              <?php if (!empty($item['cols'])) : foreach ($item['cols'] as $head => $links) : ?>
                <p class="nent-drawer__head"><?php echo esc_html($head); ?></p>
                <?php foreach ($links as $l) : ?><a href="<?php echo esc_url(nent_u($l[1])); ?>"><?php echo esc_html($l[0]); ?></a><?php endforeach; ?>
              <?php endforeach; else : foreach ($item['items'] as $l) : $ext = strpos($l[1], 'http') === 0; ?>
                <a href="<?php echo esc_url($ext ? $l[1] : nent_u($l[1])); ?>"<?php echo $ext ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html($l[0]); ?></a>
              <?php endforeach; endif; ?>
            </div>
          </details>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>
    <div class="nent-drawer__cta">
      <a class="nent-btn nent-btn--primary nent-btn--block" href="<?php echo esc_url(nent_book_url()); ?>"><?php echo nent_icon('calendar', 18); ?> Book appointment</a>
      <a class="nent-btn nent-btn--ghost nent-btn--block" href="<?php echo esc_attr(nent_tel()); ?>"><?php echo nent_icon('phone', 18); ?> <?php echo esc_html(nent_phone()); ?></a>
    </div>
  </div>
</div>
