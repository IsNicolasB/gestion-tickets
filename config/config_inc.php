<?php

// Helper: leer la misma variable desde getenv, $_ENV o $_SERVER (no agrega nuevas vars)
function env_var(string $name, $default = null) {
    $v = getenv($name);
    if ($v !== false && $v !== '') {
        return $v;
    }
    if (isset($_ENV[$name]) && $_ENV[$name] !== '') {
        return $_ENV[$name];
    }
    if (isset($_SERVER[$name]) && $_SERVER[$name] !== '') {
        return $_SERVER[$name];
    }
    // Algunos entornos Apache establecen REDIRECT_*
    if (isset($_SERVER['REDIRECT_'.$name]) && $_SERVER['REDIRECT_'.$name] !== '') {
        return $_SERVER['REDIRECT_'.$name];
    }
    return $default;
}

// DB settings (usar las mismas variables existentes, solo sustituyo getenv por env_var)
$g_hostname = env_var('MANTIS_DB_HOST');
$g_db_port = env_var('MANTIS_DB_PORT');
$g_db_type = 'pgsql';
$g_database_name = env_var('MANTIS_DB_NAME') ?: env_var('PGSQL_DATABASE');
$g_db_username = env_var('MANTIS_DB_USER') ?: env_var('PGSQL_USER');
$g_db_password = env_var('MANTIS_DB_PASSWORD') ?: env_var('PGSQL_PASSWORD') ;

// Crypto salt (obligatorio)
$g_crypto_master_salt = env_var('MANTIS_CRYPTO_MASTER_SALT') ?: env_var('CRYPTO_SALT');
if (strlen($g_crypto_master_salt) < 16) {
    die('ERROR: $g_crypto_master_salt debe tener al menos 16 caracteres');
}

// Forzar SSL (Aiven lo requiere)
$g_db_use_ssl = true;  

// Resto de configuración leída desde entorno
$g_default_timezone = 'America/Argentina/Jujuy';

// Email por SMTP desde entorno
$g_allow_signup = ON;
$g_enable_email_notification = ON;
$g_phpMailer_method = PHPMAILER_METHOD_SMTP;
$g_smtp_host = 'smtp.gmail.com';
$g_smtp_connection_mode = 'tls';
$g_smtp_port = 587;
$g_smtp_username = env_var('SMTP_USER');
$g_smtp_password = env_var('SMTP_PASS');
$g_administrator_email = env_var('SMTP_USER');

// Logs y acceso
$g_log_level = LOG_EMAIL | LOG_EMAIL_RECIPIENT | LOG_FILTERING | LOG_AJAX;
$g_log_destination = '';
$g_allow_anonymous_bug_submit = ON;
$g_allow_anonymous_login = ON;
$g_anonymous_account = 'invitado';

// OPTIMIZACIONES
$g_use_persistent_connections = ON; // Conexiones persistentes
$g_show_queries_count = OFF; // No mostrar contador de queries
$g_show_timer = OFF; // No mostrar timer
$g_compress_html = ON; // Comprimir HTML

// CACHÉ
$g_cache_lifetime = 600; // 10 minutos de caché