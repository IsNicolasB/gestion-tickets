FROM xlrl/mantisbt:latest

# Copiar configuración personalizada
COPY config/config_inc.php /var/www/html/config/config_inc.php

# Permisos correctos
RUN chown -R www-data:www-data /var/www/html/config

# Exponer puerto
EXPOSE 80

# Comando por defecto (ya viene en la imagen base)
CMD ["apache2-foreground"]