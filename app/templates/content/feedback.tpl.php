<?php if (isset($data['title'])): ?>
    <h2><?php print $data['title']; ?></h2>
<?php endif; ?>

<section id="feedback-table">
    <?php if (isset($data['table'])): ?>
        <?php print $data['table']; ?>
    <?php endif; ?>
</section>

<section id="feedback-form">
    <?php if (isset($data['form'])): ?>
        <?php print $data['form']; ?>
    <?php endif; ?>
</section>
