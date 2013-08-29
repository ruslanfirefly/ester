
<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <span class="brand" >{{ mainTitle }}</span>
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li class="divider-vertical"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Виды страхования
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/finriski/">Финансовые риски</a></li>
                                <li><a href="#">КАСКО</a></li>
                                <li><a href="#">ОСАГО</a></li>
                                <li><a href="/dms/">Таджики</a></li>
                            </ul>
                        </li>
                        <li class="divider-vertical"></li>
                        {{ menuforactionmiddle }}
                    </ul>

                    <ul class="nav pull-right">
                        <li class="divider-vertical"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                {{ topLogin }}
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Отчеты</a></li>
                                <li><a href="#">Комиссия</a></li>
                                {{ menuforactionright }}
                                <li class="divider"></li>
                                <li><a href="/logout/">Выход</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>