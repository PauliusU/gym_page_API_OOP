<section id="hero-image"></section>

<section id="services-container">
    <?php foreach ($data['services'] ?? [] as $service_id => $service): ?>
        <div class="services-item">
            <img src="<?php print $service['image']; ?>" alt="service image">
            <h2><?php print $service['title']; ?></h2>
            <p><?php print $service['description']; ?></p>
        </div>
    <?php endforeach; ?>
</section>

<section id="map">
    <iframe src="<?php print $data['map']; ?>"></iframe>
</section>
