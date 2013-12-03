{% extends "index/index.volt" %}


{% block title %}Добавление пользователя{% endblock %}
{% block content %}
<div class="container-fluid">
     <form class="span12 fireflyForm user-add" action="/accounts/add/" method="post" >
        <h3 class="text-center">Добавление пользователя</h3>
        <div class="span12">
        <div class="span12">
             <ul class="span6 offset3">
                 {% for mes in messages %}
                     <li style="list-style: none;"><div class="alert alert-error">{{ mes }}</div></li>
                 {% endfor %}
             </ul>
        </div>
        <div class="span3 offset1">
            <label>Логин:</label>
            <input type="text" name="login" class="span12" placeholder="Логин" value="{{ userModel.login }}">
        </div>
        <div class="span3">
            <label>Пароль:</label>
            <input type="password" name="token" class="span12" placeholder="Пароль" value="{{ userModel.token }}">
        </div>
         <div class="span3">
            <label>Повтор пароля:</label>
            <input type="password" name="token2" class="span12" placeholder="Повтор пароля" value="{{ token2 }}">
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
                     {% if userModel.city == city['id'] %}
                         <option value="{{ city['id'] }}" selected>{{ city['city'] }}</option>
                     {% else %}
                         <option value="{{ city['id'] }}">{{ city['city'] }}</option>
                     {% endif %}
                 {% endfor %}
             </select>

        </div>
        <div class="span3">
            <label>Роль:</label>
            <select  name="role" class="span12" onchange="javascript: roleChanging(this);">
                {% for role in roles %}
                    {% if sesRole <= role['id'] %}
                        {% if userModel.role == role['id'] %}
                            <option value="{{ role['id'] }}" selected>{{ role['rolename'] }}</option>
                        {% else %}
                            <option value="{{ role['id'] }}">{{ role['rolename'] }}</option>
                        {% endif %}
                    {% endif %}
                {% endfor %}
            </select>
        </div>
		<div class="span3 text-center">
            <label>Активировать пользователя:</label>
            <select  name="active" class="span12">
                {% if userModel.active == 0 %}
                    <option value = "1">Да</option>
                    <option value = "0" selected>Нет</option>
                 {% else %}
                     <option value = "1" selected>Да</option>
                     <option value = "0">Нет</option>
                 {% endif %}

            </select>
		</div>
         <div class="span3 offset1">
             <label>Email:</label>
             <input type="email" name="email" class="span12" placeholder="email" value="{{ userModel.email }}">

			<label for="tariff">Тариф:</label>
			<select name="tariff" class="span12">
				<option {% if userModel.tariff_rate == NULL %} selected {% endif %} value="">Свободный</option> 
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
		</div>
        </div>
        <div class="span12 text-center" style="padding-top: 25px; padding-bottom: 25px;">
            <button type="submit" class="btn btn-primary">Добавить пользователя</button>
            <a href="/accounts/" class="btn">Отменить</a>
        </div>

    </form>
</div>
{% endblock %}
