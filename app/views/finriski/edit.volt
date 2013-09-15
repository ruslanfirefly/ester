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
            <div class="row-fluid text-center">
                <h3> Редактирование договора {{ dogovor.dogovor }} от {{ dogovor.time }}</h3>
            </div>
            <div class="row-fluid text-center">
                <div class="span12">
                    <ul class="span6 offset3">
                        {% for mes in messages %}
                            <li style="list-style: none;"><div class="alert alert-error">{{ mes }}</div></li>
                        {% endfor %}
                        {% if m < 0 %}<li style="list-style: none;"><div class="alert alert-error">Неверно указан период страхования</div></li>{% endif %}
                        {% if error %}<li style="list-style: none;"><div class="alert alert-error">Ошибка при сохранении</div></li>{% endif %}
                    </ul>
                </div>
            </div>
            <div class="row-fluid">
                <h4 class="span6" style="padding-left: 10px;">Страхователь:</h4>
                <h4 class="span6" style="padding-left: 10px;">Паспорт:</h4>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid text-center">
                        <label for="fam">Фамилия:</label>
                        <input type="text" name="fam" class="span11" placeholder="Фамилия" value="{{ dogovor.familia }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="imya">Имя:</label>
                        <input type="text" name="imya" class="span11" placeholder="Имя" value="{{ dogovor.imya }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="otchestvo">Отчество:</label>
                        <input type="text" name="otchestvo" class="span11" placeholder="Отчество" value="{{ dogovor.otchestvo }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="dateb">Дата рождения:</label>
                        <input type="text" name="dateb" class="span11" placeholder="Дата рождения" readonly value="{{ dogovor.dateB }}"  style="cursor:pointer" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="tel">Телефон:</label>
                        <input type="text" name="tel" class="span11" placeholder="Телефон" value="{{ dogovor.tel }}" required>
                    </div>
                </div>
                <div class="span6">
                    <div class="row-fluid text-center">
                        <label for="seria">Серия:</label>
                        <input type="text" name="seria" class="span11" placeholder="Серия" value="{{ dogovor.seria_pass }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="nomer">Номер:</label>
                        <input type="text" name="nomer" class="span11" placeholder="Номер" value="{{ dogovor.nomer_pass }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="pass_vidan">Кем и когда выдан:</label>
                        <input type="text" name="pass_vidan" class="span11" placeholder="Кем и когда выдан" value="{{ dogovor.vidan_pass }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="adress">Адрес:</label>
                        <input type="text" name="adress" class="span11" placeholder="Адрес" value="{{ dogovor.propiska }}" required>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <h4 style="padding-left: 10px;">Договор:</h4>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid text-center">
                        <label for="tariff">Тариф:</label>
                        <select name="tariff" class="span11">
                            <option {% if dogovor.tarif == 2 %} selected {% endif %}value="2">2%</option>
                            <option {% if dogovor.tarif == 2.5 %} selected {% endif %} value="2.5">2.5%</option>
                        </select>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="summa">Страховая сумма:</label>
                        <input type="text" name="summa" class="span11" placeholder="Страховая сумма" value="{{ dogovor.summa }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="summa_pro">Страховая сумма(прописью):</label>
                        <input type="text" name="summa_pro" class="span11" placeholder="Страховая сумма(прописью)" value="{{ dogovor.summa_pro }}" required>
                    </div>

                </div>
                <div class="span6">
                    <div class="row-fluid text-center">
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
                    <div class="row-fluid text-center">
                        <label for="premiya">Страховая премия:</label>
                        <input type="text" name="premiya" class="span11" placeholder="Страховая премия" value="{{ dogovor.premiya }}" required>
                    </div>
                    <div class="row-fluid text-center">
                        <label for="premiya_pro">Страховая премия (прописью):</label>
                        <input type="text" name="premiya_pro" class="span11" placeholder="Страховая премия(прописью)" value="{{ dogovor.premiya_pro }}" required>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12 text-center" style="padding: 20px;">
                    <button type="submit" class="btn btn-success"> Сохранить </button>
                    <a href="/finriski/"><button type="button" class="btn btn-danger"> Отменить </button></a>
                </div>
            </div>

        </form>
    </div>
{% endblock %}