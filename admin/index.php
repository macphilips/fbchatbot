<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="resources/css/style.css"/>
    <style type="text/css">
        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", sans-serif
        }

        body {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
<div class="container clearfix">
    <div class="people-list" id="people-list">
        <ul id="people-list-content" class="list"></ul>
    </div>

    <div class="chat">
        <div id="chat-header" class="chat-header clearfix">
            <div class="round-50p" style="height:55px;width: 55px;display: inline;"></div>
            <div class="chat-about">
                <div class="chat-with">.</div>
                <div class="chat-num-messages">.</div>
            </div>
        </div> <!-- end chat-header -->

        <div id="chat-history" class="chat-history">
            <ul id="chat-history-content"></ul>
        </div> <!-- end chat-history -->
        <div class="clearfix"></div>


    </div> <!-- end chat -->

</div>
<!-- end container -->

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.0/handlebars.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js'></script>

<script src="resources/js/index.js"></script>

</body>
</html>
