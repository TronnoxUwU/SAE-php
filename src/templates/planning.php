

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/styles/calendrierSemaine.css">
    <link rel="stylesheet" href="../static/styles/calendrierMois.css">
    <link rel="stylesheet" href="../static/styles/planning.css">
    <title>Document</title>
</head>
<body>
        <aside class="sidebar">
            <?php include "./navbar_admin.php" ?>
        </aside>
    <main>
        <div>
            <div class="">
                <?php include 'calendrierMois.php';?>
            </div>
            <div class="semaine">
                <?php include 'calendrierSemaine.php';?>
            </div>
        </div>
        
    </main>
</body>
</html>