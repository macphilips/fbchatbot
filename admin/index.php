<!DOCTYPE HTML>
<html>
<head>
    <title>

    </title>
    <script src="jquery.js"></script>
    <script src="underscore.js"></script>
    <script src="backbone.js"></script>
    <style type="text/css">
        body {
            margin: 0;
        }

        #side-nav {
            float: left;
            width: 20%;
            height: 100%;
            position: fixed;
            background: yellow;
        }

        h1 {

            margin-top: 0;

        }

        #content {
            margin-left: 20%;
            background: burlywood;
        }
    </style>
</head>
<body>
<div id="main">
    <div id="side-nav">

    </div>
    <div id="content">
        <h1>
            Main Content
        </h1>
    </div>
</div>
</body>
<script type="text/javascript">

    var appleData = [
        {
            name: 'fuji',
            url: 'img/fuji.jpg'
        },
        {
            name: 'gala',
            url: 'img/gala.png'
        }
    ]

    var app
    var Apples = Backbone.Collection.extend({})
    var router = Backbone.Router.extend({
        routes: {
            '': 'home',
            'apples/:appleName': 'loadApple'
        },
        initialize: function () {
            var apples = new Apples()
            apples.reset(appleData)
            this.homeView = new homeView({collection: apples})
            this.appleView = new appleView({collection: apples})
        },
        home: function () {
            this.homeView.render()
        },
        loadApple: function (appleName) {
            this.appleView.render(appleName)
        }
    })
    var homeView = Backbone.View.extend({
        el: '#side-nav',
        template: _.template(' <%= data %>'),
        render: function () {
            this.$el.html(this.template({
                data: JSON.stringify(this.collection.models)
            }))
        }
    })



    var appleView = Backbone.View.extend({
        template: _.template('<figure>\ \
                                <img src="<%= attributes.url%>"/>\
                                <figcaption><%= attributes.name %></figcaption>\
                              </figure>'),
        render: function (appleName) {
            var appleModel = this.collection.where({name: appleName})[0]
            var appleHtml = this.template(appleModel)
            $('#content').html(appleHtml)
        }
    })

    $(document).ready(function () {
        app = new router
        Backbone.history.start()
    })

</script>
</html>