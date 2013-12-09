{% extends "index/index.volt" %}
{% block mainMenu %}{% include "mainMenu/index.volt" %}{% endblock %}
{% block jscss %}
    {{ super() }}
    <link href="/css/datepicker.css" type="text/css" rel="stylesheet">
    <script src="/js/datepicker.js" type="text/javascript"></script>
{% endblock %}
{% block title %}Финансовые риски - Редактирование договора{% endblock %}
{% block content %}
    <div class="container-fluid">
	    <form class="span12 fireflyForm" id = "formAddDogFinR" action="/finriski/edit/{{ dogovor.id }}/" method="post" >
            <div class="row-fluid text-center span12">
                <h3> Редактирование договора {{ dogovor.dogovor }} от {{ dogovor.time }}</h3>
				{% if dogovor.user != currentUser.id %}
					<h5>Куратор договора: {{ currentUser.firstName }} {{ currentUser.secondName }}</h5>
				{% endif %}
            </div>
            <div class="row-fluid text-center">
                <div class="span12 ">
                    <ul class="span6 offset3">
                        {% for mes in messages %}
                            <li style="list-style: none;"><div class="alert alert-error">{{ mes }}</div></li>
                        {% endfor %}
                        {% if m < 0 %}<li style="list-style: none;"><div class="alert alert-error">Неверно указан период страхования</div></li>{% endif %}
                        {% if error %}<li style="list-style: none;"><div class="alert alert-error">Ошибка при сохранении</div></li>{% endif %}
                    </ul>
                </div>
            </div>
			<div class="span11 row-fluid">
				<div class="span12 row-fluid">
					<div class="span6 row-fluid">
						<h4 class="span12">Страхователь:</h4>
						<div class="text-center span12">
							<label for="fam">Фамилия:</label>
							<input type="text" name="fam" class="span12" placeholder="Фамилия" value="{{ dogovor.familia }}" required>
						</div>
						<div class="text-center span12">
							<label for="imya">Имя:</label>
							<input type="text" name="imya" class="span12" placeholder="Имя" value="{{ dogovor.imya }}" required>
						</div>
						<div class="text-center span12">
							<label for="otchestvo">Отчество:</label>
							<input type="text" name="otchestvo" class="span12" placeholder="Отчество" value="{{ dogovor.otchestvo }}" required>
						</div>
						<div class="text-center span12">
							<label for="dateb">Дата рождения:</label>
							<input type="text" name="dateb" class="span12" placeholder="Дата рождения" readonly value="{{ dogovor.dateB }}"  style="cursor:pointer" required>
						</div>
						<div class="text-center span12">
							<label for="tel">Телефон:</label>
							<input type="text" name="tel" class="span12" placeholder="Телефон" value="{{ dogovor.tel }}" required>
						</div>
					</div>
					<div class="span6 row-fluid">
						<h4 class="offset1 span11">Паспорт:</h4>
						<div class="offset1 span11">
							<div class="text-center span2">
								<label for="seria">Серия:</label>
								<input type="text" name="seria" class="span12" placeholder="Серия" value="{{ dogovor.seria_pass }}" required>
							</div>
							<div class="text-center span4">
								<label for="nomer">Номер:</label>
								<input type="text" name="nomer" class="span12" placeholder="Номер" value="{{ dogovor.nomer_pass }}" required>
							</div>
						</div>
						<div class="offset1 text-center span11">
							<label for="pass_vidan">Кем и когда выдан:</label>
							<input type="text" name="pass_vidan" class="span12" placeholder="Кем и когда выдан" value="{{ dogovor.vidan_pass }}" required>
						</div>
						<div class="offset1 text-center span11">
							<label for="adress">Адрес:</label>
							<input type="text" name="adress" class="span12" placeholder="Адрес" value="{{ dogovor.propiska }}" required>
						</div>
					</div>
				</div>
			</div>
            <div class="row-fluid span11">
				<div class="span6">
					<h4 class="span12">Договор:</h4>
					<div class="row-fluid span12">
						<div class="text-center">
							<label for="tariff">Тариф:</label>
							<select name="tariff" class="span12" {% if currentUser.tariff_rate != NULL %} disabled="" {% endif %}>
								{% if currentUser.tariff_rate == NULL %}
									{% for tariff,label in dogovor.getTariffRates() %}
										<option {% if dogovor.tariff_rate == tariff %} selected {% endif %} value="{{ tariff }}">{{ label }}</option>
									{% endfor %}
								{% else %}
									{% for tariff,label in dogovor.getTariffRates() %}
										{% if tariff == currentUser.tariff_rate %}
											<option selected value="{{ currentUser.tariff_rate }}">{{ label }}</option>
										{% endif %}
									{% endfor %}
								{% endif %}
							</select>
						</div>
						<div class="row-fluid text-center">
							<label for="summa">Страховая сумма:</label>
							<input type="text" name="summa" class="span12" placeholder="Страховая сумма" value="{{ dogovor.summa }}" required>
						</div>
						<div class="row-fluid text-center">
							<label for="summa_pro">Страховая сумма(прописью):</label>
							<input type="text" name="summa_pro" class="span12" placeholder="Страховая сумма(прописью)" value="{{ dogovor.summa_pro }}" required>
						</div>
					</div>
					<div class="offset0 span12 row-fluid">
						<div class="row-fluid text-center">
							<label for="summa">Кооператив:</label>
							<input type="text" name="cooperative" class="span12" placeholder="КПК" value="{{ dogovor.cooperative }}" required>
						</div>
						<div class="row-fluid text-center">
							<label for="summa">Исполнитель КПК:</label>
							<input type="text" name="performer" class="span12" placeholder="Исполнитель кредитных потребительских кредитов" value="{{ dogovor.performer }}" required>
						</div>
					</div>
				</div>
                <div class="row-fluid span6">
					<div class="offset1 span11">
						<h4 class="span12">&nbsp;</h4>
						<div class="span11 text-center">
							<label for="insur">Срок страхования:</label>
							<div class="span12 text-center">
								<div class="date span4 offset1 input-prepend" id="dp3" data-date-format="dd/mm/yyyy">
									<span class="add-on">C</span><input type="text" class="span12" maxlength="16" readonly name="start_insur" value="{{ dogovor.insur_from }}" style="cursor: pointer;" >
								</div>
								<div class="date span4 offset1 input-prepend" id="dp3" data-date-format="dd/mm/yyyy">
									<span class="add-on">По</span><input type="text" class="span12" maxlength="16" readonly name="end_insur" value="{{ dogovor.insur_to }}" style="cursor: pointer;" >
								</div>
							</div>
						</div>
						<div class="span12 text-center">
							<label for="premiya">Страховая премия:</label>
							<input type="text" name="premiya" class="span12" placeholder="Страховая премия" value="{{ dogovor.premiya }}" required>
						</div>
						<div class="span12 text-center">
							<label for="premiya_pro">Страховая премия (прописью):</label>
							<input type="text" name="premiya_pro" class="span12" placeholder="Страховая премия(прописью)" value="{{ dogovor.premiya_pro }}" required>
						</div>
						<div class="span12 row-fluid text-center">
							<label for="summa">Вид вклада:</label>
							<input type="text" name="deposit_type" class="span12" placeholder="срочный, до востребования и т.д." value="{{ dogovor.deposit_type }}" required>
						</div>
					</div>
                </div>
            </div>
            <div class="row-fluid span11">
                <div class="span12 text-center" style="padding: 20px;">
                    <button type="submit" class="btn btn-success"> Сохранить </button>
                    <a href="/finriski/"><button type="button" class="btn btn-danger"> Отменить </button></a>
                </div>
            </div>

	    </form>
    </div>
{% endblock %}
