{% extends "index/index.volt" %}


{% block title %}Добавление договора ДМС{% endblock %}
{% block content %}
<div class="container-fluid">
    <form class="span12 fireflyForm" action="/dms/add/" method="post" >
            <div class="row-fluid">
                <div class="span12 text-center">
                    <h3>Добавление нового договора</h3>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 text-center">
                    <h4>Страхователь</h4>
                </div>
                <div class="span4 text-center">
                    <h4>Застрахованное лицо</h4>
                    <label><input type="checkbox" name="insurFace" checked="checked">    Является страхователем</label>
                </div>
                <div class="span4 text-center">
                    <h4>Выгодоприобретатель</h4>
                    <label data-toggle="tooltip" data-placement="bottom" title="Если Выгодопреобретатель не указан, то Выгодопреобретателем признается Застрахованное лицо,и в случае смерти Застрахованного лица Выгодопреобретателем признаются наследники Застрахованного лица">
                        <input type="checkbox" name="moneyFace" checked="checked">    Не указывать
                    </label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 text-left" style="padding-left: 5px;">
                    <div class="row-fluid">
                        <label class="span4">Фамилия:</label>
                        <input type="text" class="span8" name = "familia" placeholder="Фамилия" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Имя:</label>
                        <input type="text" class="span8" name = "imya" placeholder="Имя" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Отчество:</label>
                        <input type="text" class="span8" name = "otchestvo" placeholder="Отчество" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">День Рождения:</label>
                        <input type="text" class="span8" name = "dateRozh" maxlength="10" placeholder="дд/мм/гггг" required>
                    </div>
                    <div class="row-fluid">
                        <h5>Удостоверение личности (паспорт)</h5>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Серия:</label>
                        <input type="text" class="span8" name = "pass_seria" placeholder="Серия" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Номер:</label>
                        <input type="text" class="span8" name = "pass_nomer" placeholder="Номер" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Дата выдачи:</label>
                        <input type="text" class="span8" name = "pass_date" placeholder="Дата выдачи (дд/мм/гггг)" required>
                    </div>
                </div>
                <div class="span4 text-center">

                </div>
                <div class="span4 text-center">

                </div>
            </div>
    </form>
</div>
{% endblock %}