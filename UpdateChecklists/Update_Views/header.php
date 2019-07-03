<?php require('../../Globals/init.php');?>
    <html>

    <head>
        <meta charset="UTF-8">
        <title> Update Checklist </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="../../Globals/js/jquery-2.2.0.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link rel="stylesheet" href="../css/style.css">
        
        <script type="text/javascript" src="../../Globals/js/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="../../Globals/js/Script.js"></script>
    </head>

    <body>
    <?php $invalidUser = getUser();

//var_dump($_SERVER);
if($invalidUser == 'CS' || $invalidUser == "MAGIC" || $invalidUser == "SIX" || $invalidUser == "ROGERS"):?>
<script>
alert('User: <?php echo $invalidUser;?> is not authorized. Please close the browser and try again');
</script>

<?php    
exit();
        endif;?>

