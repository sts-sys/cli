{% extends "base_widget.html" %}

{% block widget_content %}
    {% if loginError %}
        <div class="alert alert-danger">{{ loginError }}</div>
    {% endif %}

    <form method="post" action="">
        <div class="form-group">
            <label for="username">Nume de utilizator:</label>
            <input type="text" id="username" name="username" value="{{ username }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Parolă:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Logare</button>
    </form>
{% endblock %}
