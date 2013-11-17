{% extends "index/index.volt" %}
{% block mainMenu %}{% include "mainMenu/index.volt" %}{% endblock %}
{% block title %}Финансовые риски{% endblock %}
{% block content %}

    <div class="container-fluid">
		<div class="paginator">
			<a class="page page-first{% if page.current <= 1 %} page-current {% endif %}" href="?page=">&#8606;</a>
			<a class="page page-before{% if page.current <= 1 %} page-current {% endif %}" href="?page={{ page.before }}">&#8592;</a>
			{% for pg in 1..page.last %}
				{% if pg == page.current %}
					<a class="page page-current" href="#">{{pg}}</a>
				{% else %}
					<a class="page" href="?page={{ pg }}">{{ pg }}</a>
				{% endif %}
			{% endfor %}
			<a class="page page-next{% if page.current == page.last %} page-current {% endif %}" href="?page={{ page.next }}">&#8594;</a>
			<a class="page page-last{% if page.current == page.last %} page-current {% endif %}" href="?page={{ page.last }}">&#8608;</a>
		</div>

        <table class="table table-hover table-condensed" style="background-color: #fcfcfc">
            <tr>
                <th>Дата</th>
                <th>Договор</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Действия</th>
            </tr>
            {% for dog in page.items %}
                <tr>
                    <td>{{ dog["dog_time"]|escape }}</td>
                    <td>{{ dog["dogovor"]|escape }}</td>
                    <td>{{ dog["familia"]|escape }}</td>
                    <td>{{ dog["imya"]|escape }}</td>
                    <td>{{ dog["otchestvo"]|escape }}</td>
                    <td>
                        <a href="/finriski/print/{{ dog["id"] }}/"><button type="button" class="btn btn-primary">Печатать</button></a>
                        <a href="/finriski/edit/{{ dog["id"] }}/"><button type="button" class="btn btn-warning">Редактировать</button></a>
                    </td>
                </tr>
            {% endfor %}
        </table>

		<div class="paginator">
			<a class="page page-first{% if page.current <= 1 %} page-current {% endif %}" href="?page=">&#8606;</a>
			<a class="page page-before{% if page.current <= 1 %} page-current {% endif %}" href="?page={{ page.before }}">&#8592;</a>
			{% for pg in 1..page.last %}
				{% if pg == page.current %}
					<a class="page page-current" href="#">{{pg}}</a>
				{% else %}
					<a class="page" href="?page={{ pg }}">{{ pg }}</a>
				{% endif %}
			{% endfor %}
			<a class="page page-next{% if page.current == page.last %} page-current {% endif %}" href="?page={{ page.next }}">&#8594;</a>
			<a class="page page-last{% if page.current == page.last %} page-current {% endif %}" href="?page={{ page.last }}">&#8608;</a>
		</div>
    </div>

{% endblock %}
