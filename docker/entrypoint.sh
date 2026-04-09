#!/bin/bash
set -e

# Iniciar el demonio de cron
printf "\nAntMaster Pro: Iniciando demonio de Cron...\n"
service cron start

# Iniciar Apache en primer plano (Comando original de la imagen)
printf "AntMaster Pro: Iniciando Servidor Apache...\n\n"
exec apache2-foreground
