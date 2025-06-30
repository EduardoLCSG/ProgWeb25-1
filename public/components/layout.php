<!DOCTYPE html>
<html>

<head>
    <title>ProgWebSolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php require_once ROOT_PATH . '/public/components/header.php'; ?>
    <div>
        <?php require_once $view; // Incluir a view específica da página 
        ?>
    </div>
    <?php require_once ROOT_PATH . '/public/components/footer.php'; ?>
</body>

</html>