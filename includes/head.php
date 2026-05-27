<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Bursary Portal - NIBS Technical College'; ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='6' fill='%231e73be'/><text x='16' y='22' text-anchor='middle' font-size='18' font-weight='bold' fill='%2310b981'>N</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&family=Roboto+Slab:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
