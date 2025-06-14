<!DOCTYPE html>
<html>
    <head>
        <title>ProgWebSolar</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
        <?php require_once ROOT_PATH . '/public/components/header.php'; ?>
        <main>
            <?php require_once $view; // Incluir a view específica da página ?>
        </main>
        <?php require_once ROOT_PATH . '/public/components/footer.php'; ?>
    </body>
</html>