<!DOCTYPE html>
<html>
<head>
    <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="/css/myStyle.css" type="text/css" rel="stylesheet">
    <script src="/js/jq.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/myjs.js" type="text/javascript"></script>
    <title>{% block title %}Личный кабинет ЭСТЕР.{% endblock%}</title >
</head>
<body>
<div class="row-fluid">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                {% block mainMenu %}{% include "mainMenu/index.volt" %}{% endblock %}
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
{% block content %}{% endblock %}
</div>
{% block loginForm %}{% endblock %}
</body>
</html>