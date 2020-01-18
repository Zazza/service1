{% extends 'index.volt' %}

{% block content %}
    <form method="post" action="{{ url('/') }}">

        {% if error is not empty %}
            <div class="alert alert-danger" role="alert">
            {{ error }}
            </div>
        {% endif %}

        {% if assign is not empty %}
            <div class="alert alert-success" role="alert">
                Результат: <a href="http://example.com/{{ assign }}">http://example.com/{{ assign }}</a>
            </div>
        {% endif %}

        <div class="form-group">
            <label for="url">URL</label>
            <input type="url" id="url" name="url" class="form-control">
            <small class="form-text text-muted">URL будет преобразован в короткую ссылку</small>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" id="add" value="Добавить">
        </div>
    </form>

    <hr>

    <form method="post" action="{{ url('/getFromAssign') }}">
        <div class="form-group">
            <label for="assign">Короткая ссылка (только код)</label>
            <input type="text" name="assign" id="assign" class="form-control">
            <small class="form-text text-muted">Короткая ссылка будет преобразована в URL</small>
        </div>

        <div class="form-group">
            <input type="submit" id="add" class="btn btn-primary" value="Получить">
        </div>
    </form>
{% endblock %}