<?php
$totalRespuestasInicio = ControladorEnvios::ctrContarRespuestas();
?>
<style>
    .inicio-page { min-height: calc(100vh - 50px); padding: 100px 3.1% 42px !important; background: var(--bg-body); color: var(--text-primary); }
    .inicio-hero { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; max-width: 1180px; margin: 0 auto 28px; }
    .inicio-eyebrow { margin: 0 0 8px; color: var(--accent-primary); font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
    .inicio-title { margin: 0; color: var(--text-primary); font-size: 34px; font-weight: 800; line-height: 1.08; }
    .inicio-subtitle { max-width: 470px; margin: 10px 0 0; color: var(--text-secondary); font-size: 16px; line-height: 1.5; }
    .inicio-date { padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; background: var(--bg-card); color: var(--text-secondary); font-size: 13px; white-space: nowrap; }
    .inicio-grid { display: grid; grid-template-columns: 1.2fr .8fr; gap: 20px; max-width: 1180px; margin: 0 auto; }
    .inicio-panel { border: 1px solid var(--border-color); border-radius: 16px; background: var(--bg-card); box-shadow: var(--shadow-sm); }
    .inicio-overview { display: grid; grid-template-columns: minmax(180px, .8fr) 1.2fr; gap: 20px; padding: 24px; }
    .inicio-stat { display: flex; min-height: 170px; flex-direction: column; justify-content: space-between; padding: 20px; border-radius: 13px; background: linear-gradient(145deg, var(--accent-primary), #1d4ed8); color: #fff; }
    .inicio-stat-label { font-size: 14px; font-weight: 700; opacity: .88; }
    .inicio-stat-value { margin: 10px 0 0; font-size: 52px; font-weight: 800; line-height: 1; }
    .inicio-stat-caption { font-size: 13px; opacity: .82; }
    .inicio-panel-title { margin: 0 0 16px; color: var(--text-primary); font-size: 17px; font-weight: 800; }
    .inicio-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .inicio-action { display: flex; min-height: 76px; align-items: center; gap: 12px; padding: 14px; border: 1px solid var(--border-color); border-radius: 11px; background: var(--bg-card); color: var(--text-primary); text-decoration: none !important; transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease; }
    .inicio-action:hover { border-color: var(--accent-primary); box-shadow: var(--shadow-md); color: var(--text-primary); transform: translateY(-2px); }
    .inicio-action i { width: 36px; color: var(--accent-primary); font-size: 20px; text-align: center; }
    .inicio-action strong { display: block; font-size: 14px; }
    .inicio-action span { display: block; margin-top: 3px; color: var(--text-secondary); font-size: 12px; }
    .inicio-guide { padding: 24px; }
    .inicio-guide-row { display: flex; gap: 12px; padding: 13px 0; border-bottom: 1px solid var(--border-light); }
    .inicio-guide-row:last-child { border-bottom: 0; padding-bottom: 0; }
    .inicio-guide-icon { flex: 0 0 30px; color: var(--accent-success); font-size: 18px; text-align: center; }
    .inicio-guide strong { display: block; color: var(--text-primary); font-size: 14px; }
    .inicio-guide span { display: block; margin-top: 3px; color: var(--text-secondary); font-size: 13px; line-height: 1.35; }
    @media (max-width: 800px) { .inicio-hero { align-items: flex-start; flex-direction: column; } .inicio-grid { grid-template-columns: 1fr; } }
    @media (max-width: 520px) { .inicio-page { padding: 64px 16px 30px !important; } .inicio-title { font-size: 28px; } .inicio-overview { grid-template-columns: 1fr; padding: 16px; } .inicio-actions { grid-template-columns: 1fr; } .inicio-guide { padding: 20px 16px; } }
</style>

<main class="content-wrapper inicio-page">
    <section class="inicio-hero" aria-labelledby="tituloInicio">
        <div>
            <p class="inicio-eyebrow">Gestión de envíos</p>
            <h1 class="inicio-title" id="tituloInicio">Todo listo para trabajar</h1>
            <p class="inicio-subtitle">Administra tus formularios, revisa respuestas y mantén tu operación en un solo lugar.</p>
        </div>
        <div class="inicio-date"><i class="fa fa-calendar-o"></i> <?php echo date("d/m/Y"); ?></div>
    </section>

    <section class="inicio-grid" aria-label="Resumen de operación">
        <div class="inicio-panel inicio-overview">
            <div class="inicio-stat">
                <div><div class="inicio-stat-label">Respuestas registradas</div><div class="inicio-stat-value"><?php echo (int) $totalRespuestasInicio; ?></div></div>
                <div class="inicio-stat-caption"><i class="fa fa-inbox"></i> Registros recibidos desde tus formularios</div>
            </div>
            <div>
                <h2 class="inicio-panel-title">Accesos rápidos</h2>
                <div class="inicio-actions">
                    <a class="inicio-action" href="envios"><i class="fa fa-truck"></i><span><strong>Ver envíos</strong><span>Revisar y actualizar respuestas</span></span></a>
                    <a class="inicio-action" href="compartir"><i class="fa fa-share-alt"></i><span><strong>Compartir formulario</strong><span>Generar o copiar tu enlace</span></span></a>
                    <a class="inicio-action" href="configuracion"><i class="fa fa-cog"></i><span><strong>Configuración</strong><span>Datos, horarios y apariencia</span></span></a>
                    <?php if(isset($_SESSION["perfil"]) && strtolower(trim((string) $_SESSION["perfil"])) === "administrador"): ?>
                        <a class="inicio-action" href="usuarios"><i class="fa fa-users"></i><span><strong>Usuarios</strong><span>Gestionar cuentas y planes</span></span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <aside class="inicio-panel inicio-guide" aria-label="Estado del flujo">
            <h2 class="inicio-panel-title">Flujo de trabajo</h2>
            <div class="inicio-guide-row"><i class="fa fa-share-alt inicio-guide-icon"></i><span><strong>Comparte tu formulario</strong><span>Recibe datos de tus clientes mediante un enlace único.</span></span></div>
            <div class="inicio-guide-row"><i class="fa fa-inbox inicio-guide-icon"></i><span><strong>Revisa las respuestas</strong><span>Filtra, busca y organiza los envíos registrados.</span></span></div>
            <div class="inicio-guide-row"><i class="fa fa-check-circle inicio-guide-icon"></i><span><strong>Actualiza el estado</strong><span>Marca los envíos completados cuando estén listos.</span></span></div>
        </aside>
    </section>
</main>