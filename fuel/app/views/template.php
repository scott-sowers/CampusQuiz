<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        
        <link rel="stylesheet" type="text/css" href="/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/popline.css">
        <?php echo Asset::css('style.css'); ?>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>
