<nav>
    <?php foreach ($data as $section_id => $section_links): ?>
        <ul class="<?php print $section_id; ?>">
            <?php foreach ($section_links as $link): ?>
                <li><a class="<?php print ($link['active'] ?? false) ? 'active' : ''; ?>"
                       href="<?php print $link['url']; ?>"><?php print $link['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</nav>