<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php print $data['title'] ?></title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- CSS -->
    <?php foreach ($data['css'] as $path) : ?>
        <link rel="stylesheet" href="<?php print $path; ?>">
    <?php endforeach; ?>
    <!-- JS -->
    <?php foreach ($data['js'] as $path) : ?>
        <script src="<?php print $path; ?>" defer></script>
    <?php endforeach; ?>
</head>
<body class="index__body">
<header>
    <?php print $data['header'] ?>
</header>
<main>
    <?php print $data['content']; ?>
</main>
<footer>
    <?php print $data['footer'] ?>
</footer>
</body>
</html>
