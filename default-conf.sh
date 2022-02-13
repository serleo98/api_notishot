#!/bin/bash
set -e
psql -v ON_ERROR_STOP==1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-E0SQL
    CREATE USER evokium_dba WITH PASSWORD 'evokium_dbap';
    CREATE DATABASE evokium;
    GRANT ALL PRIVILEGES ON DATABASE evokium TO evokium_dba;
E0SQL