<div class="widget {{ widget_class }}">
    {% if widget_title is defined %}
        <div class="widget-header">
            <h3>{{ widget_title }}</h3>
        </div>
    {% endif %}

    <div class="widget-body">
        {# Afișează conținutul personalizat al widget-ului #}
        {% block widget_content %}
        <p>Conținutul widget-ului va fi afișat aici.</p>
        {% endblock %}
    </div>

    {% if widget_footer is defined %}
        <div class="widget-footer">
            <small>{{ widget_footer }}</small>
        </div>
    {% endif %}
</div>
