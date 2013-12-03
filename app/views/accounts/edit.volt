{% extends "index/index.volt" %}
{% block title %}Редактирование пользователя {{ userModel.login }}.{% endblock %}
{% block content %}
<div class="container-fluid">
    <form class="span12 fireflyForm user-edit" action="/accounts/edit/{{ userModel.id }}" method="post" >
        <h3 class="text-center">Редактирование пользователя {{ userModel.login }}</h3>
        <div class="span12">
            <ul class="span6 offset3">
                {% for mes in messages %}
                    <li style="list-style: none;"><div class="alert alert-error">{{ mes }}</div></li>
                {% endfor %}
            </ul>
        </div>

        <div class="span3 offset1">
            <label>Имя:</label>
            <input type="text" name="firstname" class="span12" placeholder="Имя" value="{{ userModel.firstName }}">
        </div>
        <div class="span3">
            <label>Фамилия:</label>
            <input type="text" name="secondname" class="span12" placeholder="Фамилия" value="{{ userModel.secondName }}">
        </div>
        <div class="span3">
            <label>Агентский договор:</label>
            <input type="text" name="dogovor" class="span12" placeholder="Номер договора" value="{{ userModel.dogovor }}">
        </div>
        <div class="span3 offset1">
            <label>Город:</label>
            <select  name="city" class="span12">
                {% for city in cites %}
                    <option value="{{ city['id'] }}" {% if userModel.city == city['id'] %} selected {% endif %}>{{ city['city'] }}</option>
                {% endfor %}
            </select>

        </div>
        <div class="span3 ">
            <label>Роль:</label>
            <select  name="role" class="span12" onchange="javascript: roleChanging(this);">
                {% for role in roles %}
                   	<option value="{{ role['id'] }}" {% if userModel.role_id == role['id'] %} selected {% endif %}>{{ role['rolename'] }}</option>
                {% endfor %}
            </select>
        </div>

        <div class="span3 ">
            <label>Активировать пользователя:</label>
            <select  name="active" class="span12">
				{% for value,label in userModel.getActivationValues() %}
					<option {% if userModel.active == value %} selected {% endif %} value="{{ value }}">{{ label }}</option>
				{% endfor %}
            </select>
        </div>

        <div class="span3 offset1">
            <label>Email:</label>
            <input type="email" name="email" class="span12" placeholder="email" value="{{ userModel.email }}">
			<label for="tariff">Тариф:</label>
			<select name="tariff" class="span12">
				<option {% if userModel.tariff_rate == '' %} selected {% endif %} value="">Свободный</option> 
				{% for tariff,label in dogovor.getTariffRates() %}
					<option {% if userModel.tariff_rate == tariff %} selected {% endif %} value="{{ tariff }}">{{ label }}</option>
				{% endfor %}
			</select>
        </div>

	
		<div class="span6 subordinate-users {% if subordinateRoles[curRole] is not defined %} hidden {% endif %}">
			<fieldset id="subordinated_to">
				<label>Прикреплен за пользователем:</label>
				<select class="disabled-users" style="display: none">
				</select>
				<select name="subordinated_to[]" multiple class="span12">
					{% for usr in users %}
						<option role="{{usr['role_id']}}" value="{{usr['id']}}" {% if ownerUser[usr['id']] is defined %} selected {% endif %}>
							{% if usr['firstname'] == '' and usr['secondname'] == ''%}
								{{usr['username']}}
							{% else %}
								{{usr['firstname']}} {{usr['secondname']}}
							{% endif %}
						</option>
					{% endfor %}
				</select>
			</fieldset>
			<fieldset id="subordinate_users" {% if subordinateRoles[curRole] is not defined %} disabled="disabled" {% endif %}>
			<label>Пользователи в подчинении</label>
			<table class="table table-bordered table-stripped small">
			<tbody>
				{% for usr in users %}
					{% if subordinateUsers['users'][usr['id']] is defined %}
					<tr id="user_role_{{usr['role']}}">
						<td><a href="/accounts/edit/{{ usr['id'] }}">{{ usr['firstname'] }} {{ usr['secondname'] }}</a></td>
						<td>{{ usr['role'] }}</td>
					</tr>
					{% endif %}
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
