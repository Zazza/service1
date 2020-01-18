{% extends 'index.volt' %}

{% block content %}
    <a class="btn btn-primary" href="{{ url('/') }}">Назад</a>

    {% if error is not empty %}
        <div class="alert alert-danger m-3" role="alert">
            {{ error }}
        </div>
    {% endif %}

    {% if url is not empty %}
        <div class="alert alert-success m-3" role="alert">
            {{ url }}
        </div>
    {% endif %}

{% endblock %}