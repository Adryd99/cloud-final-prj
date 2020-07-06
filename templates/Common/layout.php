<html>
<head>
    <title><?=$this->e($title)?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css"/>
    <?=$this->section('head')?>
</head>
<body>
    <?php 
        // default links in navbar
        $btn['Home'] = ['path' => '/', 'public' => true];
        $btn['Dashboard'] = ['path' => '/dashboard', 'public' => false];
        $btn['Photo Manager'] = ['path' => '/photomanager', 'public' => false]; 
        $btn['Photo Maps'] = ['path' => '/photomaps', 'public' => false]; 
        $this->insert('Common/navbar', ['buttons' => $btn, 'user' => $user]); 
    ?>
    <div class="container">
        <?=$this->section('content')?>
    </div>
</body>
</html>