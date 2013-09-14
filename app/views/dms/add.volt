{% extends "index/index.volt" %}
{% block jscss %}
    {{ super() }}
    <link href="/css/datepicker.css" type="text/css" rel="stylesheet">
    <script src="/js/datepicker.js" type="text/javascript"></script>
{% endblock %}

{% block title %}Добавление договора ДМС{% endblock %}
{% block content %}
<div class="container-fluid">
    <form class="span12 fireflyForm" id = "formAddDogDms" action="/dms/add/" method="post" >
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
                    <label id="insurFace_check"><input type="checkbox" name="insurFace" checked>    Является страхователем</label>
                </div>
                <div class="span4 text-center">
                    <h4>Выгодоприобретатель</h4>
                    <label data-toggle="tooltip" data-placement="bottom" title="Если Выгодопреобретатель не указан, то Выгодопреобретателем признается Застрахованное лицо,и в случае смерти Застрахованного лица Выгодопреобретателем признаются наследники Застрахованного лица">
                        <input type="checkbox" name="moneyFace" checked="checked">    Не указывать
                    </label>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span4 text-left padding5px" >
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
                    <div class="row-fluid date">
                        <label class="span4">День Рождения:</label>
                            <input type="text" class="span8"  data-date-format="dd/mm/yyyy" name = "dateRozh" maxlength="10" placeholder="дд/мм/гггг" required>
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
                    <div class="row-fluid date">
                        <label class="span4">Дата выдачи:</label>
                        <input type="text" class="span8"  data-date-format="dd/mm/yyyy" name = "pass_date" placeholder="Дата выдачи (дд/мм/гггг)" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Кем выдан:</label>
                        <input type="text" class="span8" name = "take_from" placeholder="Кем выдан" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Адрес:</label>
                        <input type="text" class="span8" name = "propiska" placeholder="Адрес" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Телефон:</label>
                        <input type="text" class="span8" name = "telefon" placeholder="Телефон" required>
                    </div>
                </div>

                <div class="span4 text-left" style="padding-left: 5px;" id="insurFace">
                        <div class="row-fluid">
                            <label class="span4">Фамилия:</label>
                            <input type="text" class="span8" name = "familia_inf" placeholder="Фамилия" required>
                        </div>
                        <div class="row-fluid">
                            <label class="span4">Имя:</label>
                            <input type="text" class="span8" name = "imya_inf" placeholder="Имя" required>
                        </div>
                        <div class="row-fluid">
                            <label class="span4">Отчество:</label>
                            <input type="text" class="span8" name = "otchestvo_inf" placeholder="Отчество" required>
                        </div>
                        <div class="row-fluid date">
                            <label class="span4">День Рождения:</label>
                            <input type="text" class="span8" data-date-format="dd/mm/yyyy" name = "dateRozh_inf" maxlength="10" placeholder="дд/мм/гггг" required>
                        </div>
                        <div class="row-fluid">
                            <h5>Удостоверение личности (паспорт)</h5>
                        </div>
                        <div class="row-fluid">
                            <label class="span4">Серия:</label>
                            <input type="text" class="span8" name = "pass_seria_inf" placeholder="Серия" required>
                        </div>
                        <div class="row-fluid">
                            <label class="span4">Номер:</label>
                            <input type="text" class="span8" name = "pass_nomer_inf" placeholder="Номер" required>
                        </div>
                        <div class="row-fluid date">
                            <label class="span4">Дата выдачи:</label>
                            <input type="text" class="span8" data-date-format="dd/mm/yyyy" name = "pass_date_inf" placeholder="Дата выдачи (дд/мм/гггг)" required>
                        </div>
                        <div class="row-fluid">
                            <label class="span4">Кем выдан:</label>
                            <input type="text" class="span8" name = "take_from_inf" placeholder="Кем выдан" required>
                        </div>
                        <div class="row-fluid">
                            <label class="span4">Адрес:</label>
                            <input type="text" class="span8" name = "propiska_inf" placeholder="Адрес" required>
                        </div>
                        <div class="row-fluid">
                            <label class="span4">Телефон:</label>
                            <input type="text" class="span8" name = "telefon_inf" placeholder="Телефон" required>
                        </div>
                    </div>

                <div class="span4 text-left" style="padding-left: 5px;" id="vigFace">
                    <div class="row-fluid">
                        <label class="span4">Фамилия:</label>
                        <input type="text" class="span8" name = "familia_vig" placeholder="Фамилия" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Имя:</label>
                        <input type="text" class="span8" name = "imya_vig" placeholder="Имя" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Отчество:</label>
                        <input type="text" class="span8" name = "otchestvo_vig" placeholder="Отчество" required>
                    </div>
                    <div class="row-fluid date">
                        <label class="span4">День Рождения:</label>
                        <input type="text" class="span8" data-date-format="dd/mm/yyyy" name = "dateRozh_vig" maxlength="10" placeholder="дд/мм/гггг" required>
                    </div>
                    <div class="row-fluid">
                        <h5>Удостоверение личности (паспорт)</h5>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Серия:</label>
                        <input type="text" class="span8" name = "pass_seria_vig" placeholder="Серия" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Номер:</label>
                        <input type="text" class="span8" name = "pass_nomer_vig" placeholder="Номер" required>
                    </div>
                    <div class="row-fluid date">
                        <label class="span4">Дата выдачи:</label>
                        <input type="text" class="span8" data-date-format="dd/mm/yyyy" name = "pass_date_vig" placeholder="Дата выдачи (дд/мм/гггг)" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Кем выдан:</label>
                        <input type="text" class="span8" name = "take_from_vig" placeholder="Кем выдан" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Адрес:</label>
                        <input type="text" class="span8" name = "propiska_vig" placeholder="Адрес" required>
                    </div>
                    <div class="row-fluid">
                        <label class="span4">Телефон:</label>
                        <input type="text" class="span8" name = "telefon_vig" placeholder="Телефон" required>
                    </div>
                </div>
            </div>
        <div class="row-fluid padding5px">
            <label class="span4">С назначением Выгодопреобретателя согласно Застрахованное лицо, либо законный представитель Застрахованного лица.</label>
            <div class="span8">
                <input type="radio" name="aprove_nasl" value="1" checked> Застрахованное лицо <br>
                <input type="radio" name="aprove_nasl" value="2" style="margin-bottom: 14px;"> <input type="text" class="span8" name="ap_zakon_pred" placeholder="Законный представитель">
           </div>
        </div>
        <div class="row-fluid padding5px">
            <label class="span4">Место пребывания (маршрут и цель поездки).</label>
            <div class="span8">
               <input type="text" class="span8" name="way_trip" placeholder="Место пребывания" value="Санкт-Петербург и Л.О.">
            </div>
        </div>
        <div class="row-fluid padding5px">
            <label class="span4">Программа:</label>
            <div class="span8 input-prepend">
                <span class="add-on">№</span><input type="text" class="span1" maxlength="2" name="num_prog" value="4">
            </div>
        </div>
        <div class="row-fluid padding5px">
            <label class="span4">Период страхования:</label>
            <div class="span8">
                 <div class="date span2 input-prepend" id="dp3" data-date-format="dd/mm/yyyy">
                     <span class="add-on">C</span><input type="text" class="span12" maxlength="16" name="start_insur" >
                  </div>
                  <div class="date span2 input-prepend" id="dp3" data-date-format="dd/mm/yyyy">
                      <span class="add-on">По</span><input type="text" class="span12" maxlength="16" name="end_insur" >
                  </div>
            </div>
        </div>
    </form>
</div>
{% endblock %}