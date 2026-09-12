# AGENTS.md — MOABCODE Envíos

## Contexto
Aplicación PHP (MVC) para gestión de envíos. **En producción.** Solo hacer cambios puntuales cuando se pida; no tocar archivos no relacionados.

## Arquitectura
- **Stack**: PHP vanilla, MySQL (PDO), jQuery, Bootstrap 3 (AdminLTE), TCPDF.
- **Entry point**: `index.php` → `ControladorPlantilla` → `vistas/plantilla.php`.
- **Routing**: Apache rewrite en `.htaccess` → `?ruta=<modulo>`. Módulos válidos en `plantilla.php:80-87`: `usuarios`, `configuracion`, `inicio`, `salir`, `login`, `compartir`, `envios`, `registro`.
- **MVC**: `controladores/` → `modelo/` → `vistas/modulos/`. AJAX en `ajax/`.
- **Multi-tenant**: Todas las tablas usan prefijo `envio_`. Cada usuario tiene `tenant_id`. Las queries filtran por `tenant_id` a menos que el perfil sea `administrador`.
- **Suscripciones**: Perfiles: `administrador`, `usuario`, `usuario/prueba`, `vendedor`. Planes: `general`, `mensual`, `prueba` (3 días). Sesión controla `solo_lectura` cuando vence.
- **DB auto-migrating**: Los modelos ejecutan `CREATE TABLE IF NOT EXISTS` y `ALTER TABLE` para agregar columnas faltantes. No hay sistema formal de migraciones.

## Convenciones
- Nombres en español, classes en español (`ControladorEnvios`, `ModeloEnvios`).
- Métodos prefijo `ctr` (controladores) / `mdl` (modelos): `ctrGuardarRespuesta`, `mdlListarRespuestas`.
- AJAX retorna JSON `{"estado": "ok/error", ...}`.
- No hay composer, no hay npm scripts, no hay tests, no hay linting configurado.
- CSS inline en módulos PHP (no scss/less).
- Archivos `.sql` en `migraciones/` son referenciales; la DB se actualiza por código PHP.

## Datos sensibles (NO commitear)
- `modelo/conexion.php` está en `.gitignore`.
- `*.sql` excluidos excepto `bk.sql` y `migraciones/`.
- `password*.txt`, `.env` excluidos.

## Base de datos
- **Tabla principal**: `envio_respuestas_formulario` (respuestas de formularios compartidos).
- **Otras tablas**: `envio_usuarios`, `envio_configuracion`, `envio_formularios_compartir`.
- **Tablas externas** (en la misma BD compartida, fuera del esquema): `agencia_shalon`, `agencia_olva`, `agencia_marvisur`, `agencia_dinsides`, `ubicaciones_encomienda`, `distritos_delivery`.
- Default admin: usuario `admin`, password `admin123`.

## Reglas de comportamiento
1. **Antes de editar, haz `git pull`.** El usuario hace cambios manuales; siempre sincroniza antes de tocar archivos.
2. **Solo toca lo que te pidan.** No refactorices archivos circundantes, no muevas código no relacionado. Cada archivo tocado es un riesgo en producción.
3. **Aplica buenas prácticas** del stack actual (PHP, MySQL, jQuery, Bootstrap 3).
4. **No inventes funcionalidad.** Si no estás seguro de algo, pregunta antes de implementar.
5. **Consulta antes de agregar** dependencias, archivos nuevos, o cambios que no se solicitaron.
6. **Después de cada cambio, haz commit y push.** Mensaje de commit breve descriptivo en español (ej: `fix: corrige filtro por agencia en envios`). No dejes archivos sin commitear.
