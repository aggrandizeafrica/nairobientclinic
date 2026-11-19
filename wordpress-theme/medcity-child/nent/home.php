<?php
/* Nairobi ENT redesign – homepage sections. */
if (!defined('ABSPATH')) exit;
$docs = nent_doctors();
?>
<main id="content" class="nent-home">

  <!-- HERO -->
  <section class="nent-hero" aria-labelledby="nent-hero-title">
    <div class="nent-hero__bg" aria-hidden="true">
      <span class="nent-blob nent-blob--a"></span><span class="nent-blob nent-blob--b"></span><span class="nent-blob nent-blob--c"></span>
      <span class="nent-hero__grid"></span>
    </div>
    <div class="nent-wrap nent-hero__inner">
      <div class="nent-hero__copy">
        <p class="nent-pill nent-anim" style="--d:0"><span class="nent-pill__dot"></span>Ear, nose &amp; throat specialists in Kenya</p>
        <h1 class="nent-hero__title" id="nent-hero-title">
          <span class="nent-line"><span class="nent-anim" style="--d:1">Breathe easier.</span></span>
          <span class="nent-line"><span class="nent-anim" style="--d:2">Hear clearer.</span></span>
          <span class="nent-line"><span class="nent-anim" style="--d:3"><em>Speak freely.</em></span></span>
        </h1>
        <p class="nent-hero__lead nent-anim" style="--d:4">Nairobi ENT Clinic is a multi-specialist ear, nose and throat practice with <strong>8 ENT surgeons</strong> across <strong>6 clinics</strong> in Nairobi and Kisumu, caring for adults and children from first consultation to surgery and recovery.</p>
        <div class="nent-hero__actions nent-anim" style="--d:5">
          <a class="nent-btn nent-btn--primary nent-btn--lg" href="<?php echo esc_url(nent_book_url()); ?>"><?php echo nent_icon('calendar', 20); ?> Book an appointment</a>
          <a class="nent-btn nent-btn--ghost nent-btn--lg" href="<?php echo esc_attr(nent_tel()); ?>"><?php echo nent_icon('phone', 20); ?> <?php echo esc_html(nent_phone()); ?></a>
        </div>
        <ul class="nent-hero__trust nent-anim" style="--d:6">
          <li><?php echo nent_icon('check', 18); ?> Adults &amp; children</li>
          <li><?php echo nent_icon('check', 18); ?> Insurance accepted</li>
          <li><?php echo nent_icon('check', 18); ?> Virtual consultations</li>
        </ul>
      </div>

      <div class="nent-hero__media">
        <figure class="nent-hero__img nent-hero__img--main nent-anim-img" data-nent-parallax="0.06">
          <img src="<?php echo esc_url(nent_img('2024/10/IMG_2720-1024x683.jpg')); ?>" srcset="<?php echo esc_url(nent_img('2024/10/IMG_2720-768x512.jpg')); ?> 768w, <?php echo esc_url(nent_img('2024/10/IMG_2720-1024x683.jpg')); ?> 1024w, <?php echo esc_url(nent_img('2024/10/IMG_2720.jpg')); ?> 1600w" sizes="(max-width: 900px) 92vw, 46vw" alt="An ENT surgeon at Nairobi ENT Clinic examining a patient’s throat with an endoscope" width="1024" height="683" fetchpriority="high">
        </figure>
        <figure class="nent-hero__img nent-hero__img--small nent-anim-img" style="--d:3" data-nent-parallax="-0.08">
          <img src="<?php echo esc_url(nent_img('2024/10/IMG_2674-600x400.jpg')); ?>" alt="A nurse gently caring for a patient in the clinic" width="600" height="400" loading="lazy">
        </figure>
        <div class="nent-float nent-float--team nent-anim" style="--d:6">
          <div class="nent-avatars">
            <?php foreach (array_slice($docs, 0, 4) as $d) : ?><img src="<?php echo esc_url(nent_img(str_replace('-600x600', '-150x150', $d[2]))); ?>" alt="" width="40" height="40"><?php endforeach; ?>
          </div>
          <div><strong>8 ENT surgeons</strong><span>Specialists for every stage of life</span></div>
        </div>
        <a class="nent-float nent-float--book nent-anim" style="--d:7" href="<?php echo esc_url(nent_book_url()); ?>">
          <span class="nent-float__ic"><?php echo nent_icon('calendar', 20); ?></span>
          <span><strong>Book online</strong><span>Choose a clinic &amp; time</span></span>
          <?php echo nent_icon('arrow-up-right', 18); ?>
        </a>
      </div>
    </div>

    <div class="nent-wrap">
      <dl class="nent-stats nent-anim" style="--d:7">
        <div><dt>Clinics</dt><dd><span data-nent-count="6">6</span></dd><p>across Nairobi &amp; Kisumu</p></div>
        <div><dt>ENT surgeons</dt><dd><span data-nent-count="8">8</span></dd><p>with head &amp; neck expertise</p></div>
        <div><dt>Specialist services</dt><dd><span data-nent-count="19">19</span></dd><p>from hearing to voice &amp; sleep</p></div>
        <div><dt>Patients</dt><dd>All ages</dd><p>paediatric &amp; adult care</p></div>
      </dl>
    </div>
  </section>

  <!-- MARQUEE -->
  <div class="nent-marquee" aria-hidden="true">
    <div class="nent-marquee__track">
      <?php for ($k = 0; $k < 2; $k++) : ?>
        <span>General ENT</span><i>✦</i><span>Hearing Centre</span><i>✦</i><span>Rhinology &amp; Allergy</span><i>✦</i><span>Sleep Medicine</span><i>✦</i><span>Voice Clinic</span><i>✦</i><span>Head &amp; Neck Surgery</span><i>✦</i><span>Speech Pathology</span><i>✦</i><span>Paediatric ENT</span><i>✦</i><span>Balance &amp; Vertigo</span><i>✦</i>
      <?php endfor; ?>
    </div>
  </div>

  <!-- ABOUT -->
  <section class="nent-section nent-about" id="about">
    <div class="nent-wrap">
      <p class="nent-kicker" data-reveal>Our story</p>
      <p class="nent-statement" data-nent-words>Founded by ENT, Head and Neck Surgeons Prof. Isaac M. Macharia and Dr. Chimmy Omamo-Olende, Nairobi ENT is a progressive, multi-physician practice built around one simple idea: specialist care that feels personal.</p>
      <div class="nent-about__grid">
        <figure class="nent-about__img" data-reveal>
          <img src="<?php echo esc_url(nent_img('2024/10/IMG_2695-1024x683.jpg')); ?>" alt="Prof. Isaac M. Macharia in a consultation room at Nairobi ENT Clinic" width="1024" height="683" loading="lazy">
        </figure>
        <div class="nent-about__cards">
          <article class="nent-card nent-card--soft" data-reveal>
            <span class="nent-card__ic"><?php echo nent_icon('heart'); ?></span>
            <h3>Our mission</h3>
            <p>To provide high quality, ethical and personalised ENT care through timely and cost-effective services, delivered by well-trained staff using state-of-the-art technology.</p>
          </article>
          <article class="nent-card nent-card--soft" data-reveal style="--rd:1">
            <span class="nent-card__ic"><?php echo nent_icon('sparkles'); ?></span>
            <h3>Our vision</h3>
            <p>The highest quality ear, nose and throat care, with patient comfort and satisfaction at the centre, using the latest advances in technology and treatment.</p>
          </article>
          <ul class="nent-values" data-reveal style="--rd:2">
            <li>Professionalism</li><li>Integrity</li><li>Confidentiality</li><li>Compassion</li><li>Reliability</li><li>Passion</li>
          </ul>
          <a class="nent-link nent-link--lg" href="<?php echo esc_url(nent_u('/about-us/')); ?>" data-reveal>More about us <?php echo nent_icon('arrow', 18); ?></a>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES -->
  <section class="nent-section nent-services" id="services">
    <div class="nent-wrap">
      <div class="nent-head">
        <div>
          <p class="nent-kicker" data-reveal>What we do</p>
          <h2 class="nent-h2" data-reveal>Complete care for your <em>ears, nose &amp; throat</em></h2>
        </div>
        <p class="nent-head__aside" data-reveal>From a blocked nose to complex head and neck surgery, our specialists diagnose, treat and follow you through every step.</p>
      </div>
      <div class="nent-bento">
        <a class="nent-bento__feature" href="<?php echo esc_url(nent_u('/solution/hearing-centre/')); ?>" data-reveal>
          <img src="<?php echo esc_url(nent_img('2024/10/IMG_3610-1024x683.jpg')); ?>" alt="A patient having an ear examination under a microscope" width="1024" height="683" loading="lazy">
          <span class="nent-bento__overlay">
            <span class="nent-tag">Hearing Centre</span>
            <strong>Hearing tests, tinnitus care &amp; hearing aids</strong>
            <span class="nent-link nent-link--light">Explore the Hearing Centre <?php echo nent_icon('arrow', 18); ?></span>
          </span>
        </a>
        <?php $n = 0; foreach (nent_services() as $s) : if ($s[0] === 'Hearing Centre') continue; ?>
          <a class="nent-svc" href="<?php echo esc_url(nent_u($s[1])); ?>" data-reveal style="--rd:<?php echo $n++ % 3; ?>">
            <span class="nent-svc__ic"><?php echo nent_icon($s[2], 24); ?></span>
            <h3><?php echo esc_html($s[0]); ?></h3>
            <p><?php echo esc_html($s[3]); ?></p>
            <span class="nent-svc__go" aria-hidden="true"><?php echo nent_icon('arrow-up-right', 18); ?></span>
          </a>
        <?php endforeach; ?>
        <a class="nent-svc nent-svc--cta" href="<?php echo esc_url(nent_book_url()); ?>" data-reveal style="--rd:2">
          <span class="nent-svc__ic"><?php echo nent_icon('calendar', 24); ?></span>
          <h3>Not sure what you need?</h3>
          <p>Book a consultation and an ENT specialist will guide you to the right care.</p>
          <span class="nent-svc__go" aria-hidden="true"><?php echo nent_icon('arrow-up-right', 18); ?></span>
        </a>
      </div>
    </div>
  </section>

  <!-- CONDITIONS -->
  <section class="nent-section nent-conditions" id="conditions">
    <div class="nent-wrap">
      <div class="nent-head nent-head--center">
        <p class="nent-kicker" data-reveal>Patient information</p>
        <h2 class="nent-h2" data-reveal>Learn about your <em>condition</em></h2>
        <p class="nent-head__aside" data-reveal>Clear, doctor-written guides to common ENT conditions, what causes them and how they are treated.</p>
      </div>
      <div class="nent-tabs" data-nent-tabs data-reveal>
        <div class="nent-tabs__list" role="tablist" aria-label="Condition areas">
          <?php $t = 0; foreach (nent_conditions() as $area => $links) : ?>
            <button role="tab" type="button" id="nent-tab-<?php echo $t; ?>" aria-controls="nent-panel-<?php echo $t; ?>" aria-selected="<?php echo $t === 0 ? 'true' : 'false'; ?>" tabindex="<?php echo $t === 0 ? '0' : '-1'; ?>"><?php echo esc_html($area); ?></button>
          <?php $t++; endforeach; ?>
        </div>
        <?php $t = 0; foreach (nent_conditions() as $area => $links) : ?>
          <div class="nent-tabs__panel" role="tabpanel" id="nent-panel-<?php echo $t; ?>" aria-labelledby="nent-tab-<?php echo $t; ?>"<?php echo $t ? ' hidden' : ''; ?>>
            <?php foreach ($links as $l) : ?>
              <a class="nent-chip" href="<?php echo esc_url(nent_u($l[1])); ?>"><?php echo esc_html($l[0]); ?> <?php echo nent_icon('arrow-up-right', 16); ?></a>
            <?php endforeach; ?>
          </div>
        <?php $t++; endforeach; ?>
      </div>
    </div>
  </section>

  <!-- WHY US -->
  <section class="nent-section nent-why" id="why">
    <div class="nent-wrap nent-why__grid">
      <div class="nent-why__sticky">
        <p class="nent-kicker nent-kicker--light" data-reveal>Why choose us</p>
        <h2 class="nent-h2 nent-h2--light" data-reveal>Care that puts <em>you</em> first</h2>
        <p class="nent-why__lead" data-reveal>Your health and comfort come first, backed by a dedicated team and advanced facilities.</p>
        <figure class="nent-why__img" data-reveal>
          <img src="<?php echo esc_url(nent_img('2024/10/IMG_2785-1024x683.jpg')); ?>" alt="A modern ENT examination room with diagnostic equipment" width="1024" height="683" loading="lazy">
        </figure>
      </div>
      <ol class="nent-why__list">
        <?php
        $why = array(
            array('users', 'Experienced doctors', 'Our team is made up of skilled ENT, head and neck surgeons with years of experience treating adults and children.'),
            array('heart', 'Personalised care', 'We take time to understand your symptoms and build a treatment plan around your needs.'),
            array('sparkles', 'Modern facilities', 'Our clinics are equipped with the latest endoscopy, microscopy and hearing-testing technology for accurate diagnosis.'),
            array('smile', 'Compassionate staff', 'From reception to recovery, we prioritise your comfort and wellbeing in every interaction.'),
            array('pin', 'Convenient locations', 'Six clinics across Nairobi and Kisumu make it easy to get expert care close to home or work.'),
        );
        foreach ($why as $k => $w) : ?>
          <li class="nent-why__item" data-reveal>
            <span class="nent-why__num"><?php echo sprintf('%02d', $k + 1); ?></span>
            <div>
              <h3><?php echo nent_icon($w[0], 22); ?> <?php echo esc_html($w[1]); ?></h3>
              <p><?php echo esc_html($w[2]); ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </section>

  <!-- STEPS -->
  <section class="nent-section nent-steps">
    <div class="nent-wrap">
      <div class="nent-head nent-head--center">
        <p class="nent-kicker" data-reveal>Your visit</p>
        <h2 class="nent-h2" data-reveal>Simple, from <em>booking to recovery</em></h2>
      </div>
      <div class="nent-steps__grid">
        <?php
        $steps = array(
            array('calendar', 'Book', 'Book online, call or WhatsApp us, or choose a virtual consultation.'),
            array('stethoscope', 'Consult', 'Meet an ENT specialist who listens and examines you thoroughly.'),
            array('activity', 'Diagnose & treat', 'Get clear answers from on-site tests and a plan made for you.'),
            array('heart', 'Recover', 'We follow up and support you until you feel like yourself again.'),
        );
        foreach ($steps as $k => $s) : ?>
          <div class="nent-step" data-reveal style="--rd:<?php echo $k; ?>">
            <span class="nent-step__n"><?php echo $k + 1; ?></span>
            <span class="nent-step__ic"><?php echo nent_icon($s[0], 26); ?></span>
            <h3><?php echo esc_html($s[1]); ?></h3>
            <p><?php echo esc_html($s[2]); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- DOCTORS -->
  <section class="nent-section nent-doctors" id="doctors">
    <div class="nent-wrap">
      <div class="nent-head">
        <div>
          <p class="nent-kicker" data-reveal>Meet the team</p>
          <h2 class="nent-h2" data-reveal>Our ENT <em>surgeons</em></h2>
        </div>
        <div class="nent-carousel-ctrl" data-reveal>
          <button type="button" class="nent-round" data-nent-prev aria-label="Previous doctors"><?php echo nent_icon('arrow', 20); ?></button>
          <button type="button" class="nent-round" data-nent-next aria-label="Next doctors"><?php echo nent_icon('arrow', 20); ?></button>
        </div>
      </div>
    </div>
    <div class="nent-carousel" data-nent-carousel tabindex="0" aria-label="ENT surgeons">
      <?php foreach ($docs as $k => $d) : ?>
        <a class="nent-doc" href="<?php echo esc_url(nent_u($d[3])); ?>" data-reveal style="--rd:<?php echo min($k, 3); ?>">
          <span class="nent-doc__img"><img src="<?php echo esc_url(nent_img($d[2])); ?>" alt="<?php echo esc_attr($d[0]); ?>" width="600" height="600" loading="lazy"></span>
          <span class="nent-doc__body">
            <strong><?php echo esc_html($d[0]); ?></strong>
            <span><?php echo esc_html($d[1]); ?></span>
          </span>
          <span class="nent-doc__go" aria-hidden="true"><?php echo nent_icon('arrow-up-right', 18); ?></span>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="nent-wrap nent-center">
      <a class="nent-btn nent-btn--ghost" href="<?php echo esc_url(nent_u('/doctors/')); ?>" data-reveal>View all doctors <?php echo nent_icon('arrow', 18); ?></a>
    </div>
  </section>

  <!-- CLINICS -->
  <section class="nent-section nent-clinics" id="clinics">
    <div class="nent-wrap">
      <div class="nent-head">
        <div>
          <p class="nent-kicker" data-reveal>Locations</p>
          <h2 class="nent-h2" data-reveal>Six clinics, <em>close to you</em></h2>
        </div>
        <p class="nent-head__aside" data-reveal>Visit us in leading hospitals and convenient malls across Nairobi and Kisumu.</p>
      </div>
      <div class="nent-clinics__grid">
        <?php foreach (nent_clinics() as $k => $c) : ?>
          <article class="nent-clinic" data-reveal style="--rd:<?php echo $k % 3; ?>">
            <div class="nent-clinic__top">
              <span class="nent-clinic__ic"><?php echo nent_icon('pin', 22); ?></span>
              <span class="nent-tag nent-tag--soft"><?php echo esc_html($c[5]); ?></span>
            </div>
            <h3><a href="<?php echo esc_url(nent_u($c[4])); ?>"><?php echo esc_html($c[0]); ?></a></h3>
            <p><?php echo esc_html($c[1]); ?></p>
            <div class="nent-clinic__foot">
              <a href="<?php echo esc_attr($c[3]); ?>"><?php echo nent_icon('phone', 16); ?> <?php echo esc_html($c[2]); ?></a>
              <a class="nent-clinic__more" href="<?php echo esc_url(nent_u($c[4])); ?>" aria-label="<?php echo esc_attr($c[0]); ?> details"><?php echo nent_icon('arrow-up-right', 18); ?></a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="nent-section nent-quotes" aria-labelledby="nent-quotes-title">
    <div class="nent-wrap">
      <div class="nent-head nent-head--center">
        <p class="nent-kicker" data-reveal>Patient stories</p>
        <h2 class="nent-h2" id="nent-quotes-title" data-reveal>Kind words from <em>our patients</em></h2>
      </div>
    </div>
    <div class="nent-quotes__rail" data-reveal>
      <div class="nent-quotes__track">
        <?php for ($k = 0; $k < 2; $k++) : foreach (nent_testimonials() as $q) : ?>
          <figure class="nent-quote"<?php echo $k ? ' aria-hidden="true"' : ''; ?>>
            <div class="nent-stars" aria-label="5 out of 5"><?php for ($s = 0; $s < 5; $s++) echo nent_icon('star', 16); ?></div>
            <blockquote>“<?php echo esc_html($q[0]); ?>”</blockquote>
            <figcaption><span class="nent-quote__av"><?php echo esc_html(substr($q[1], 0, 1)); ?></span><?php echo esc_html($q[1]); ?></figcaption>
          </figure>
        <?php endforeach; endfor; ?>
      </div>
    </div>
    <div class="nent-wrap nent-center">
      <a class="nent-link nent-link--lg" href="<?php echo esc_url(nent_u('/patient-testimonials/')); ?>" data-reveal>Read more testimonials <?php echo nent_icon('arrow', 18); ?></a>
    </div>
  </section>

  <?php
  $posts = function_exists('get_posts') ? get_posts(array('numberposts' => 3, 'post_status' => 'publish')) : array();
  if ($posts) : ?>
  <!-- BLOG -->
  <section class="nent-section nent-blog">
    <div class="nent-wrap">
      <div class="nent-head">
        <div>
          <p class="nent-kicker" data-reveal>Health tips</p>
          <h2 class="nent-h2" data-reveal>From our <em>blog</em></h2>
        </div>
        <a class="nent-link nent-link--lg" href="<?php echo esc_url(nent_u('/blog/')); ?>" data-reveal>All articles <?php echo nent_icon('arrow', 18); ?></a>
      </div>
      <div class="nent-blog__grid">
        <?php foreach ($posts as $k => $p) :
            $img = get_the_post_thumbnail_url($p, 'medium_large');
            if (!$img) $img = nent_img('2024/10/IMG_2525-768x512.jpg'); ?>
          <a class="nent-post" href="<?php echo esc_url(get_permalink($p)); ?>" data-reveal style="--rd:<?php echo $k; ?>">
            <span class="nent-post__img"><img src="<?php echo esc_url($img); ?>" alt="" loading="lazy" width="768" height="512"></span>
            <span class="nent-post__meta"><?php echo esc_html(get_the_date('j M Y', $p)); ?></span>
            <strong><?php echo esc_html(get_the_title($p)); ?></strong>
            <span class="nent-link">Read article <?php echo nent_icon('arrow', 16); ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- CTA -->
  <section class="nent-section nent-cta-wrap">
    <div class="nent-wrap">
      <div class="nent-cta" data-reveal>
        <span class="nent-cta__glow" aria-hidden="true"></span>
        <div class="nent-cta__copy">
          <h2 class="nent-h2 nent-h2--light">Ready to feel like <em>yourself again?</em></h2>
          <p>Book a visit at any of our six clinics, chat with us on WhatsApp, or see a specialist from home with a virtual consultation.</p>
        </div>
        <div class="nent-cta__actions">
          <a class="nent-btn nent-btn--white nent-btn--lg" href="<?php echo esc_url(nent_book_url()); ?>"><?php echo nent_icon('calendar', 20); ?> Book appointment</a>
          <a class="nent-btn nent-btn--outline-light nent-btn--lg" href="<?php echo esc_url(nent_whatsapp()); ?>" target="_blank" rel="noopener"><?php echo nent_icon('chat', 20); ?> WhatsApp us</a>
          <a class="nent-link nent-link--light" href="<?php echo esc_url(nent_u('/product/virtual-consultation/')); ?>"><?php echo nent_icon('video', 18); ?> Virtual consultation</a>
        </div>
      </div>
    </div>
  </section>
</main>
