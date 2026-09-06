<?php
$totalRespuestasInicio = ControladorEnvios::ctrContarRespuestas();
?>
<style>
    .inicio-page { min-height: calc(100vh - 50px); box-sizing: border-box; overflow-x: hidden; padding: 68px 3.1% 20px !important; background: var(--bg-body); color: var(--text-primary); }
    .inicio-hero { display: flex; align-items: flex-end; justify-content: space-between; width: 100%; max-width: 1180px; gap: 20px; margin: 0 auto 20px; }
    .inicio-eyebrow { margin: 0 0 9px; color: var(--accent-primary); font-size: 10px; font-weight: 800; letter-spacing: 2.4px; text-transform: uppercase; }
    .inicio-title { margin: 0; color: var(--text-primary); font-family: Georgia, 'Times New Roman', serif; font-size: 34px; font-weight: 700; letter-spacing: 0; line-height: 1.16; }
    .inicio-subtitle { max-width: 470px; margin: 14px 0 0; color: var(--text-secondary); font-size: 15px; line-height: 1.72; }
    .inicio-date { padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; background: transparent; color: var(--text-secondary); font-size: 12px; font-weight: 600; white-space: nowrap; }
    .inicio-grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(260px, .8fr); width: 100%; max-width: 1180px; gap: 16px; margin: 0 auto; }
    .inicio-panel { min-width: 0; border: 1px solid var(--border-color); border-radius: 16px; background: var(--bg-card); box-shadow: none; }
    .inicio-overview { display: grid; grid-template-columns: minmax(170px, .82fr) minmax(0, 1.18fr); gap: 16px; padding: 18px; }
    .inicio-stat { display: flex; min-height: 148px; flex-direction: column; justify-content: space-between; padding: 20px; border-radius: 12px; background: var(--button-primary-color); color: var(--button-primary-text); }
    .inicio-stat-label { font-size: 12px; font-weight: 700; letter-spacing: .02em; opacity: .88; }
    .inicio-stat-value { margin: 12px 0 0; font-size: 50px; font-weight: 800; letter-spacing: -.04em; line-height: 1; }
    .inicio-stat-caption { font-size: 12px; opacity: .82; }
    .inicio-panel-title { margin: 0 0 18px; color: var(--text-primary); font-family: Georgia, 'Times New Roman', serif; font-size: 18px; font-weight: 700; line-height: 1.25; }
    .inicio-actions { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
    .inicio-action { display: flex; min-width: 0; min-height: 78px; align-items: center; gap: 12px; padding: 12px; border: 1px solid var(--border-color); border-radius: 10px; background: var(--bg-card); color: var(--text-primary); text-decoration: none !important; transition: transform .18s ease, border-color .18s ease, background-color .18s ease; }
    .inicio-action:hover { border-color: var(--accent-primary); background: var(--bg-hover); color: var(--text-primary); transform: translateY(-2px); }
    .inicio-action i, .inicio-guide-icon { display: grid; width: 34px; height: 34px; flex: 0 0 34px; place-items: center; border-radius: 10px; background: var(--bg-active); color: var(--accent-primary); font-size: 16px; text-align: center; }
    .inicio-action strong { display: block; font-size: 13px; line-height: 1.35; overflow-wrap: anywhere; }
    .inicio-action span { display: block; min-width: 0; margin-top: 5px; color: var(--text-secondary); font-size: 12px; line-height: 1.5; overflow-wrap: anywhere; }
    .inicio-guide { padding: 20px; }
    .inicio-guide-row { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--border-light); }
    .inicio-guide-row:last-child { border-bottom: 0; padding-bottom: 0; }
    .inicio-guide-icon { margin-top: 1px; }
    .inicio-guide strong { display: block; color: var(--text-primary); font-size: 13px; }
    .inicio-guide span { display: block; margin-top: 5px; color: var(--text-secondary); font-size: 12px; line-height: 1.55; }
    @media (max-width: 1050px) { .inicio-grid { grid-template-columns: minmax(0, 1fr) minmax(235px, .72fr); } .inicio-overview { grid-template-columns: minmax(150px, .78fr) minmax(0, 1.22fr); } }
    @media (max-width: 800px) { .inicio-page { padding-top: 46px !important; } .inicio-hero { align-items: flex-start; flex-direction: column; } .inicio-grid { grid-template-columns: 1fr; } }
    @media (max-width: 520px) { .inicio-page { padding: 20px 16px 18px !important; } .inicio-title { font-size: 28px; } .inicio-overview { grid-template-columns: 1fr; padding: 16px; } .inicio-actions { grid-template-columns: 1fr; } .inicio-guide { padding: 20px 16px; } }
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