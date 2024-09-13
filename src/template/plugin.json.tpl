{
    {{ plugin }}: {
        "name": '{{ plugin }},
        "version": {{ version }},
        "author": {{ author}},
        "description": {{ description }},
        "settings": {
            "active": true,
            "directory": "plugins/{{ plugin_name }},
            "source": '{{ sorce_url }},
            "onUpdate": false,
            "namespace": '{{ namespace }}
        }
    }
}