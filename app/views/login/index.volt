{% extends "index/index.volt" %}
{% block title %}Вход в ситему ЭСТЕР. {% endblock %}
{% block mainMenu %}{% endblock %}
{% block loginForm %}
<div id="loginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <h3 id="myModalLabel">Вход в систему.</h3>
        </div>
        <div class="modal-body">
           <form name="formLogin" action="/login/" method="post">
               <label>Имя пользователя</label>
               <input type="text" name="login" placeholder="Имя пользователя">
               <label>Пароль</label>
               <input type="password" name="pass" placeholder="Пароль">
               <label></label>
               <button type="submit" class="btn pull-right">Bход</button>
           </form>
        </div>
</div>
{% endblock %}