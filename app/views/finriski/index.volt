{% extends "index/index.volt" %}
{% block mainMenu %}{% include "mainMenu/index.volt" %}{% endblock %}
{% block title %}Финансовые риски{% endblock %}
{% block content %}

    <div class="container-fluid">
        <table class="table table-hover table-condensed" style="background-color: #fcfcfc">
            <tr>
                <th>Дата</th>
                <th>Договор</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Действия</th>
            </tr>
            {% for dog in dogovors %}
                <tr>
                    <td>{{ dog["dog_time"] }}</td>
                    <td>{{ dog["dogovor"] }}</td>
                    <td>{{ dog["familia"] }}</td>
                    <td>{{ dog["imya"] }}</td>
                    <td>{{ dog["otchestvo"] }}</td>
                    <td>
                        <a href="/finriski/print/{{ dog["id"] }}/"><button type="button" class="btn btn-primary">Печатать</button></a>
                        <a href="/finriski/edit/{{ dog["id"] }}/"><button type="button" class="btn btn-warning">Редактировать</button></a>
                    </td>
                </tr>
            {% endfor %}
        </table>
    </div>

{% endblock %}