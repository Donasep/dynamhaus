<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dynamhaus | FAQ</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <link rel="stylesheet" href="/dynamhaus/public/stylesheets/faq.css" />
  <link rel="icon" href="/dynamHaus/public/icons/dynamhause_logo.svg" sizes="16x16" />
</head>
<body>
  <?php $faqs = $data["articles"]; ?>
  <section class="section_faq">
    <div class="faq-container">
      <h1>FAQ</h1>
      <?php $index = 0; foreach ($faqs as $faq): ?>
      <div class="faq-item">
        <div class="faq-question">
          <h3><?php echo $faq->title; ?></h3>
          <span class="faq-toggle">+</span>
        </div>
        <div class="faq-answer">
          <p><?php echo $faq->description; ?></p>
        </div>
      </div>
      <?php $index += 1; endforeach; ?>
    </div>
  </section>
  <script>
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
      item.querySelector('.faq-question').addEventListener('click', () => {
        item.classList.toggle('active');
        const toggle = item.querySelector('.faq-toggle');
        toggle.textContent = item.classList.contains('active') ? '-' : '+';
      });
    });
  </script>
</body>
</html>
