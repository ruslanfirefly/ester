{% extends "index/index.volt" %}

{% block mainMenu %}{% include "mainMenu/index.volt" %}{% endblock %}
{% block title %}Пользователи системы ЭСТЕР. {% endblock %}
{% block content %}
<table class="table table-hover table-condensed" style="background-color: #fcfcfc">
    <tr>
        <th class="span1">Логин</th>
        <th class="span1">Имя</th>
        <th class="span1">Фамилия</th>
        <th class="span1">Эл.почта</th>
        <th class="span1">Роль</th>
        <th class="span1">Город</th>
        <th class="span1">Договор</th>
        <th class="span1">Активен</th>
        <th class="span3">Действия</th>
    </tr>

    {% for user in users %}
        <tr>
            <td >{{ user['username'] }}</td>
            <td >{{ user['firstname'] }}</td>
            <td >{{ user['secondname'] }}</td>
            <td >{{ user['email'] }}</td>
            <td >{{ user['role'] }}</td>
            <td >{{ user['city'] }}</td>
            <td >{{ user['dogovor'] }}</td>
            <td >
                {% if user['active']  %}
                    да
                {% else %}
                    нет
                {% endif %}
            </td>
            <td >
                <a href="/accounts/delete/{{ user['id'] }}" class="btn btn-danger">Удалить</a>
                <a href="/accounts/edit/{{ user['id'] }}" class="btn btn-success">Редактировать</a>
                <a href="/accounts/passedit/{{ user['id'] }}" class="btn btn-success">Изм. пароль</a>
            </td>
        </tr>
        {% endfor %}
</table>
{% endblock %}