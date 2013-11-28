{% extends "index/index.volt" %}
{% block mainMenu %}{% include "mainMenu/index.volt" %}{% endblock %}
{% block title %}Финансовые риски{% endblock %}
{% block content %}

	<style>
		.filter {
			min-height: 10px;
			width: 100%;
			background: #EEE;
			border: 1px solid #BBB;
			border-top: 0px;
			margin-top: -20px;
			border-radius: 0px 0px 4px 4px;
			padding-left: 10px;
		}

		.filter .sub-filter {
			display: inline-block;
			height: auto;
			//margin-top: 10px;
		}

		.filter .delimiter {
			width: 0px;
			height: 100px;
			margin: 0 0px 10px 10px;
			display: inline-block;
			border-left:   1px solid #DDD;
			border-top:    0px solid #DDD;
			border-right:  1px solid #FFF;
			border-bottom: 1px solid #FFF;
		}

	</style>
	<script type="text/javascript">
	function apply_page(form_id, page)
	{
		$(form_id).find('[name=filter\\[page\\]]').val(page);
		$(form_id).submit();
	}
	</script>
    <div class="container-fluid">
		<div class="filter span12 container-fluid">
			<form class="span12" id="filter">
			<input type="hidden" name="filter[page]" value="{{ filter['page'] }}" />
			<div class="sub-filter span2 text-center">
				<br/>
				<input type="button" class="span12 btn btn-primary" onclick="return apply_page('#filter', 1)" value="Применить"/>
			</div>
			<div class="delimiter span1"></div>
			<div class="sub-filter span2 container-fluid">
				<div class="span12 row-fluid text-center">
					<h6>Дата</h6>
				</div>
				<div class="span12 row-fluid">
					<div class="span3">c: </div><input name="filter[date][from]" value="{{ filter['date']['from']|escape }}" class="span9" datepicker/>
				</div>
				<div class="span12 row-fluid">
					<div class="span3">по: </div><input name="filter[date][until]" value="{{ filter['date']['until']|escape }}" class="span9" datepicker/>
				</div>
			</div>
			<div class="delimiter span1"></div>
			<div class="sub-filter span2">
				<div class="span12 row-fluid text-center">
					<h6>Диапазон договоров</h6>
				</div>
				<div class="span12 row-fluid">
					<div class="span3">c: </div><input name="filter[orderno][from]" value="{{ filter['orderno']['from']|escape }}" class="span9"/>
				</div>
				<div class="span12 row-fluid">
					<div class="span3">по: </div><input name="filter[orderno][until]" value="{{ filter['orderno']['until']|escape }}" class="span9"/>
				</div>
			</div>
			</form>
		</div>
		<div class="paginator">
			<a class="page page-first{% if page.current <= 1 %} page-current {% endif %}" onclick="return apply_page('#filter', 1);" href="#">&#8606;</a>
			<a class="page page-before{% if page.current <= 1 %} page-current {% endif %}" onclick="return apply_page('#filter', {{ page.before }});" href="#">&#8592;</a>
			{% for pg in 1..page.last %}
				{% if pg == page.current %}
					<a class="page page-current" href="#">{{pg}}</a>
				{% else %}
					<a class="page" href="?page={{ pg }}">{{ pg }}</a>
				{% endif %}
			{% endfor %}
			<a class="page page-next{% if page.current == page.last %} page-current {% endif %}" onclick="return apply_page('#filter', {{ page.next }});" href="#">&#8594;</a>
			<a class="page page-last{% if page.current == page.last %} page-current {% endif %}" onclick="return apply_page('#filter', {{ page.last }});" href="#">&#8608;</a>
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
			<a class="page page-first{% if page.current <= 1 %} page-current {% endif %}" onclick="return apply_page('#filter', 1);" href="#">&#8606;</a>
			<a class="page page-before{% if page.current <= 1 %} page-current {% endif %}" onclick="return apply_page('#filter', {{ page.before }});" href="#">&#8592;</a>
			{% for pg in 1..page.last %}
				{% if pg == page.current %}
					<a class="page page-current" href="#">{{pg}}</a>
				{% else %}
					<a class="page" onclick="return apply_page('#filter', {{pg}});" href="#">{{ pg }}</a>
				{% endif %}
			{% endfor %}
			<a class="page page-next{% if page.current == page.last %} page-current {% endif %}" onclick="return apply_page('#filter', {{ page.next }});" href="#">&#8594;</a>
			<a class="page page-last{% if page.current == page.last %} page-current {% endif %}" onclick="return apply_page('#filter', {{ page.last }});" href="#">&#8608;</a>
		</div>

    </div>

{% endblock %}
