<?php
/* Nairobi ENT redesign – site footer. */
if (!defined('ABSPATH')) exit;
?>
<footer class="nent-footer">
  <div class="nent-wrap">
    <div class="nent-footer__top">
      <div class="nent-footer__brand">
        <img src="<?php echo esc_url(nent_img('2024/10/ENT-light-Logo.svg')); ?>" alt="Nairobi ENT Clinic" width="116" height="80" loading="lazy">
        <p>A progressive multi-physician ear, nose and throat practice founded by ENT, Head &amp; Neck Surgeons Prof. Isaac M. Macharia and Dr. Chimmy Omamo-Olende.</p>
        <div class="nent-social">
          <a href="https://www.facebook.com/NairobiENTClinic/" target="_blank" rel="noopener" aria-label="Facebook"><?php echo nent_social_icon('facebook'); ?></a>
          <a href="https://twitter.com/nentclinic" target="_blank" rel="noopener" aria-label="X (Twitter)"><?php echo nent_social_icon('x'); ?></a>
          <a href="https://www.youtube.com/@nairobientclinic1987" target="_blank" rel="noopener" aria-label="YouTube"><?php echo nent_social_icon('youtube'); ?></a>
        </div>
      </div>
      <div class="nent-footer__col">
        <p class="nent-footer__head">Services</p>
        <ul>
          <?php foreach (array_slice(nent_services(), 0, 6) as $s) : ?>
            <li><a href="<?php echo esc_url(nent_u($s[1])); ?>"><?php echo esc_html($s[0]); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="nent-footer__col">
        <p class="nent-footer__head">Patients</p>
        <ul>
          <li><a href="<?php echo esc_url(nent_book_url()); ?>">Book appointment</a></li>
          <li><a href="<?php echo esc_url(nent_u('/product/virtual-consultation/')); ?>">Virtual clinic</a></li>
          <li><a href="<?php echo esc_url(nent_u('/insurance/')); ?>">Insurance</a></li>
          <li><a href="<?php echo esc_url(nent_u('/preparation-for-surgery/')); ?>">Preparing for surgery</a></li>
          <li><a href="<?php echo esc_url(nent_u('/patient-testimonials/')); ?>">Testimonials</a></li>
          <li><a href="<?php echo esc_url(nent_u('/blog/')); ?>">Health blog</a></li>
        </ul>
      </div>
      <div class="nent-footer__col">
        <p class="nent-footer__head">Clinics</p>
        <ul>
          <?php foreach (nent_clinics() as $c) : ?>
            <li><a href="<?php echo esc_url(nent_u($c[4])); ?>"><?php echo esc_html($c[0]); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="nent-footer__col nent-footer__contact">
        <p class="nent-footer__head">Get in touch</p>
        <a href="<?php echo esc_attr(nent_tel()); ?>"><?php echo nent_icon('phone', 18); ?> <?php echo esc_html(nent_phone()); ?></a>
        <a href="mailto:info@nairobientclinic.com"><?php echo nent_icon('mail', 18); ?> info@nairobientclinic.com</a>
        <a href="<?php echo esc_url(nent_u('/clinics/nairobi-hospital-clinic/')); ?>"><?php echo nent_icon('pin', 18); ?> Anderson Building, 5th Floor, Nairobi Hospital</a>
        <a class="nent-btn nent-btn--white nent-btn--sm" href="<?php echo esc_url(nent_book_url()); ?>"><?php echo nent_icon('calendar', 18); ?> Book appointment</a>
      </div>
    </div>
    <div class="nent-footer__bottom">
      <p>&copy; <?php echo date('Y'); ?> Nairobi ENT Clinic. All rights reserved.</p>
      <p><a href="<?php echo esc_url(nent_u('/contact-us/')); ?>">Contact</a><a href="<?php echo esc_url(nent_u('/gallery/')); ?>">Gallery</a><a href="<?php echo esc_url(nent_u('/events/')); ?>">Events</a></p>
    </div>
  </div>
</footer>
<a class="nent-totop" href="#page" aria-label="Back to top" data-nent-totop><?php echo nent_icon('arrow', 20); ?></a>
