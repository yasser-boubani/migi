<?php

// Main Constants
if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

define("ML", TRUE); // Multiple Languages
define("DEF_LANG", "en");
define("TIMEZONE", "Africa/Algiers");

define("FIX_MODE", FALSE);

// Hosts Constants
define("APP_HOST", "localhost");
define("DB_HOST", "localhost");

// DB Constants
define("USING_DB", FALSE); // Set it TRUE to start using database
define("DB_NAME", "");
define("DB_USERNAME", "");
define("DB_PASS", "");

// Important Directories Paths
define("_APP_", __DIR__ . DS . ".." . DS . "app" . DS);
define("_MODELS_", _APP_ . "models" . DS);
define("_VIEWS_", _APP_ . "views" . DS);
define("_CONTROLLERS_", _APP_ . "controllers" . DS);
define("_EPAGES_", _APP_ . "epages" . DS);

define("_INCLUDES_", __DIR__ . DS . ".." . DS . "includes" . DS);
define("_WORKERS_", __DIR__ . DS . ".." . DS . "workers" . DS);
define("_NEEDS_", __DIR__ . DS . ".." . DS . "needs" . DS);

define("_LANGUAGES_", _INCLUDES_ . "languages" . DS);
define("_LIBRARIES_", _INCLUDES_ . "libraries" . DS);
define("_TEMPLATES_", _INCLUDES_ . "templates" . DS);
define("_COMPONENTS_", _INCLUDES_ . "components" . DS);

// Static Files URLs
define("FRONT_CSS", "/static/front/css/");
define("FRONT_EXTRA_CSS", "/static/front/css/extra/");
define("FRONT_JS", "/static/front/js/");
define("FRONT_EXTRA_JS", "/static/front/js/extra/");

define("BACK_CSS", "/static/back/css/");
define("BACK_EXTRA_CSS", "/static/back/css/extra/");
define("BACK_JS", "/static/back/js/");
define("BACK_EXTRA_JS", "/static/back/js/extra/");
