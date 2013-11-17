{% extends "index/index.volt" %}
{% block title %}Редактирование пользователя.{% endblock %}
{% block content %}
<div class="container-fluid">
    <form class="span12 fireflyForm" action="/accounts/edit/{{ id }}" method="post" >
        <h3 class="text-center">Редактирование пользователя {{ login }}</h3>
        <div class="span12">
            <ul class="span6 offset3">
                {% for mes in messages %}
                    <li style="list-style: none;"><div class="alert alert-error">{{ mes }}</div></li>
                {% endfor %}
            </ul>
        </div>

        <div class="span3 offset1">
            <label>Имя:</label>
            <input type="text" name="firstname" class="span12" placeholder="Имя" value="{{ firstname }}">
        </div>
        <div class="span3">
            <label>Фамилия:</label>
            <input type="text" name="secondname" class="span12" placeholder="Фамилия" value="{{ secondname }}">
        </div>
        <div class="span3">
            <label>Агентский договор:</label>
            <input type="text" name="dogovor" class="span12" placeholder="Номер договора" value="{{ dogovor }}">
        </div>

        <div class="span3 offset1">
            <label>Email:</label>
            <input type="email" name="email" class="span12" placeholder="email" value="{{ email }}">
        </div>

        <div class="span3 ">
            <label>Город:</label>
            <select  name="city" class="span12">
                {% for city in cites %}
                    {% if curCity == city['id'] %}
                        <option value="{{ city['id'] }}" selected>{{ city['city'] }}</option>
                    {% else %}
                        <option value="{{ city['id'] }}">{{ city['city'] }}</option>
                    {% endif %}
                {% endfor %}
            </select>

        </div>
        <div class="span3 ">
            <label>Роль:</label>
            <select  name="role" class="span12" onchange="javascript: roleChanging(this);">
                {% for role in roles %}
                    {% if sesRole <= role['id'] %}
                        {% if curRole == role['id'] %}
                            <option value="{{ role['id'] }}" selected>{{ role['rolename'] }}</option>
                        {% else %}
                            <option value="{{ role['id'] }}">{{ role['rolename'] }}</option>
                        {% endif %}
                    {% endif %}
                {% endfor %}
            </select>
        </div>

        <div class="span3 offset1">
            <label>Активировать пользователя:</label>
            <select  name="active" class="span12">
                {% if active == 0 %}
                    <option value = "1">Да</option>
                    <option value = "0" selected>Нет</option>
                {% else %}
                    <option value = "1" selected>Да</option>
                    <option value = "0">Нет</option>
                {% endif %}
            </select>
        </div>
	
		<div class="span6 subordinate-users {% if subordinateRoles[curRole] is not defined %} hidden {% endif %}">
			<fieldset id="subordinate_users" {% if subordinateRoles[curRole] is not defined %} disabled="disabled" {% endif %}>
			<label>Пользователи в подчинении</label>
			<table class="table table-bordered table-stripped small">
			<tbody>
				{% for usr in users %}
				<tr id="user_role_{{usr['role']}}">
					<td><input id="subuser_{{ usr['id'] }}" type="checkbox" name="subusers[{{ usr['id'] }}]" value="1" {% if subordinateUsers['users'][usr['id']] == usr['id'] %} checked {% endif %}/></td>
					<td><label for="subuser_{{ usr['id'] }}">{{ usr['firstname'] }} {{ usr['secondname'] }}</label></td>
					<td>{{ usr['role'] }}</td>
				</tr>
				{% endfor %}
			</tbody>
			</table>
			</fieldset>
		</div>

        <div class="span12 text-center" style="padding-top: 25px; padding-bottom: 25px;">
            <button type="submit" class="btn btn-primary">Обновить данные пользователя</button>
            <a href="/accounts/" class="btn">Отменить</a>
        </div>

    </form>
</div>
{% endblock %}
