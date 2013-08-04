{% extends "index/index.volt" %}
{% block mainMenu %}{% include "mainMenu/index.volt" %}{% endblock %}
{% block title %}Редактирование пароля.{% endblock %}
{% block content %}

    <form class="span12 fireflyForm" action="/accounts/passedit/{{ id }}" method="post" >
        <h3 class="text-center">Редактирование пароля пользователя {{ login }}</h3>
        <div class="span12">
            <ul class="span6 offset3">
                {% for mes in messages %}
                    <li style="list-style: none;"><div class="alert alert-error">{{ mes }}</div></li>
                {% endfor %}
            </ul>
        </div>
        <div class="span12 text-center">
            <label>Пароль:</label>
            <input type="password" name="token"  placeholder="Пароль" >
            <label>Повтор пароля:</label>
            <input type="password" name="token2"  placeholder="Повтор пароля" >
        </div>
        <div class="span12 text-center" style="padding-top: 25px; padding-bottom: 25px;">
            <button type="submit" class="btn btn-primary">Обновить пароль</button>
            <a href="/accounts/" class="btn">Отменить</a>
        </div>
    </form>

{% endblock %}