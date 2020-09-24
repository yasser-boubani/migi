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
define("DB_NAME", "db_name");
define("DB_USERNAME", "db_username");
define("DB_PASS", "db_password");

// Mailer
define("USE_MAILER", TRUE);

// Important Directories Paths
if (!defined("_ROOT_")) {
    define("_ROOT_", __DIR__ . DS . ".." . DS);
}
define("_APP_", __DIR__ . DS . ".." . DS . "App" . DS);
define("_MODELS_", _APP_ . "Models" . DS);
define("_VIEWS_", _APP_ . "Views" . DS);
define("_CONTROLLERS_", _APP_ . "Controllers" . DS);
define("_EPAGES_", _APP_ . "Epages" . DS);

define("_INCLUDES_", __DIR__ . DS . ".." . DS . "includes" . DS);
define("_WORKERS_", __DIR__ . DS . ".." . DS . "Workers" . DS);
define("_NEEDS_", __DIR__ . DS . ".." . DS . "needs" . DS);

define("_LANGUAGES_", _INCLUDES_ . "languages" . DS);
define("_LIBRARIES_", _INCLUDES_ . "libraries" . DS);
define("_TEMPLATES_", _INCLUDES_ . "templates" . DS);
define("_FRONT_TEMPS_", _INCLUDES_ . "templates" . DS . "front" . DS);
define("_BACK_TEMPS_", _INCLUDES_ . "templates" . DS . "back" . DS);
define("_COMPONENTS_", _INCLUDES_ . "components" . DS);

// Static Files URLs
define("CSS", "/static/css/");
define("EXTRA_CSS", "/static/css/extra/");
define("JS", "/static/js/");
define("EXTRA_JS", "/static/js/extra/");
