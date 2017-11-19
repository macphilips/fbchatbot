<?php

require_once($_SERVER['DOCUMENT_ROOT']  . '/vendor/autoload.php');
use App\dao\DatabaseHelper;
use App\model\FBUser;


$database = new DatabaseHelper();
/** @var FBUser $user */
$user = $database->getUser('2178859302139932');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>
        Admin
    </title>
    <link type="text/css" rel="stylesheet" href="../resource/css/chatbot.css"/>
    <link type="text/css" rel="stylesheet" href="../resource/css/w3.css"/>

    <link type="text/css" rel="stylesheet" href="../resource/css/chatbot.css"/>
    <link type="text/css" rel="stylesheet" href="../resource/css/w3.css"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", sans-serif
        }
    </style>
    <script src="../chatbot/resource/js/jquery.js"></script>
    <script src="../chatbot/resource/js/underscore.js"></script>
    <script src="../chatbot/resource/js/backbone.js"></script>
    <script src="../resource/js/chatbot.js"></script>

    <script src="../resource/js/jquery.js"></script>
    <script src="../resource/js/underscore.js"></script>
    <script src="../resource/js/backbone.js"></script>
    <script src="../resource/js/chatbot.js"></script>
</head>
<body class="w3-light-grey">
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left"
     style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container">
        <img src="../chatbot/resource/img/avatar_g2.jpg" style="width:45%;" class="w3-round"><br><br>
        <h4><b>Facebook Chatbot</b></h4>
    </div>
    <div class="w3-bar-block">
        <p class="w3-text-grey center-text">Recent Conversation</p>
        <ul id="usr-list">
            <li>
                <div id="<?php echo $user->getUserID() ?>" class="item" onclick="openTab(this.id);"
                     style="cursor:pointer">
                    <div id="profile-pix">
                        <img class="profile-size round-50p center-cropped" src="<?php echo $user->getProfile(); ?>"
                             alt="<?php echo $user->getFirstName() . ' ' . $user->getLastName(); ?>">
                    </div>
                    <div class="profile-detail">
                        <div class="w3-padding-16">
                            <?php echo $user->getFirstName() . ' ' . $user->getLastName() ?>
                        </div>
                        <div></div>
                        <div>
                        </div>

                    </div>
                </div>
                <br>
            </li>
            <li>
                <div id="<?php echo $user->getUserID() ?>" class="item" onclick="openTab(this.id);"
                     style="cursor:pointer">
                    <div id="profile-pix">
                        <img class="profile-size round-50p center-cropped" src="<?php echo $user->getProfile(); ?>"
                             alt="<?php echo $user->getFirstName() . ' ' . $user->getLastName(); ?>">
                    </div>
                    <div class="profile-detail">
                        <div class="w3-padding-16">
                            <?php echo $user->getFirstName() . ' ' . $user->getLastName() ?>
                        </div>
                        <div></div>
                        <div>
                        </div>

                    </div>
                </div>
                <br>
            </li>
            <li>
                <div id="<?php echo $user->getUserID() ?>" class="item" onclick="openTab(this.id);"
                     style="cursor:pointer">
                    <div id="profile-pix">
                        <img class="profile-size round-50p center-cropped" src="<?php echo $user->getProfile(); ?>"
                             alt="<?php echo $user->getFirstName() . ' ' . $user->getLastName(); ?>">
                    </div>
                    <div class="profile-detail">
                        <div class="w3-padding-16">
                            <?php echo $user->getFirstName() . ' ' . $user->getLastName() ?>
                        </div>
                        <div></div>
                        <div>
                        </div>

                    </div>
                </div>
                <br>
            </li>
        </ul>
    </div>
    <!--
    <div class="w3-panel w3-large">
        <i class="fa fa-facebook-official w3-hover-opacity"></i>
        <i class="fa fa-instagram w3-hover-opacity"></i>
        <i class="fa fa-snapchat w3-hover-opacity"></i>
        <i class="fa fa-pinterest-p w3-hover-opacity"></i>
        <i class="fa fa-twitter w3-hover-opacity"></i>
        <i class="fa fa-linkedin w3-hover-opacity"></i>
    </div>
     -->
</nav>
<!-- !PAGE CONTENT! -->
<div class="w3-padding-large" style="margin-left: 300px;position: fixed;height: 100%" id="main">
    <div class="col-sm-3 col-sm-offset-4 frame">
        <div id="chat-history">
            <ul></ul>
        </div>
        <div>
            <div class="msj-rta macro" style="margin:auto">
                <div class="text text-r" style="background:whitesmoke !important">
                    <input class="mytext" placeholder="Type a message"/>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function openTab(clicked_id) {
        $.get("user/" + clicked_id + "/messages", function (data, status) {
            console.log(data);
        });
    }
</script>
</body>
</html>