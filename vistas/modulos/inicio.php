<?php
$statsInicio = ControladorEnvios::ctrEstadisticasDashboard();
$pedidosRecientes = ControladorEnvios::ctrPedidosRecientes(8);
$configuracionInicio = ControladorConfiguracion::ctrMostrarConfiguracion();
$nombreEmprendimientoInicio = trim((string) ($configuracionInicio["nombre_emprendimiento"] ?? ""));
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
            <p class="inicio-eyebrow">Mi negocio</p>
            <h1 class="inicio-title" id="tituloInicio"><?php echo $nombreEmprendimientoInicio !== "" ? htmlspecialchars($nombreEmprendimientoInicio) : "Panel de control"; ?></h1>
            <p class="inicio-subtitle">Resumen de tu operación de envíos en tiempo real.</p>
        </div>
        <div class="inicio-date"><i class="fa fa-calendar-o"></i> <?php echo date("d/m/Y"); ?></div>
    </section>

    <section class="inicio-grid" aria-label="Estadísticas">
        <div class="inicio-panel">
            <div class="inicio-overview">
                <div class="inicio-stat">
                    <div><div class="inicio-stat-label">Pedidos hoy</div><div class="inicio-stat-value"><?php echo (int) $statsInicio["hoy"]; ?></div></div>
                    <div class="inicio-stat-caption"><i class="fa fa-calendar-check-o"></i> Registros del día</div>
                </div>
                <div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div style="padding:18px;border:1px solid var(--border-color);border-radius:12px;background:var(--bg-card);">
                            <div style="color:var(--text-secondary);font-size:12px;font-weight:700;">Pendientes</div>
                            <div style="font-size:32px;font-weight:800;color:#f59e0b;margin-top:4px;"><?php echo (int) $statsInicio["pendientes"]; ?></div>
                        </div>
                        <div style="padding:18px;border:1px solid var(--border-color);border-radius:12px;background:var(--bg-card);">
                            <div style="color:var(--text-secondary);font-size:12px;font-weight:700;">Completados</div>
                            <div style="font-size:32px;font-weight:800;color:#10b981;margin-top:4px;"><?php echo (int) $statsInicio["completados"]; ?></div>
                        </div>
                        <div style="padding:18px;border:1px solid var(--border-color);border-radius:12px;background:var(--bg-card);grid-column:span 2;">
                            <div style="color:var(--text-secondary);font-size:12px;font-weight:700;">Total envíos</div>
                            <div style="font-size:32px;font-weight:800;color:var(--accent-primary);margin-top:4px;"><?php echo (int) $statsInicio["total"]; ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding:18px;">
                <h2 class="inicio-panel-title">Últimos pedidos</h2>
                <?php if(count($pedidosRecientes) > 0): ?>
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;font-size:13px;">
                        <thead>
                            <tr style="border-bottom:2px solid var(--border-color);">
                                <th style="text-align:left;padding:10px 8px;color:var(--text-secondary);font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;">#</th>
                                <th style="text-align:left;padding:10px 8px;color:var(--text-secondary);font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;">Cliente</th>
                                <th style="text-align:left;padding:10px 8px;color:var(--text-secondary);font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;">Agencia</th>
                                <th style="text-align:left;padding:10px 8px;color:var(--text-secondary);font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pedidosRecientes as $pedido): ?>
                            <tr style="border-bottom:1px solid var(--border-light);">
                                <td style="padding:10px 8px;font-weight:600;color:var(--text-primary);">#<?php echo str_pad((int) $pedido["id"], 5, "0", STR_PAD_LEFT); ?></td>
                                <td style="padding:10px 8px;color:var(--text-primary);"><?php echo htmlspecialchars($pedido["nombre"]); ?></td>
                                <td style="padding:10px 8px;color:var(--text-secondary);"><?php echo htmlspecialchars($pedido["agencia"]); ?></td>
                                <td style="padding:10px 8px;">
                                    <?php if($pedido["estado"] === "pendiente"): ?>
                                        <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;background:rgba(245,158,11,.12);color:#f59e0b;font-size:12px;font-weight:600;"><i class="fa fa-clock-o"></i> Pendiente</span>
                                    <?php elseif($pedido["estado"] === "completado"): ?>
                                        <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;background:rgba(16,185,129,.12);color:#10b981;font-size:12px;font-weight:600;"><i class="fa fa-check-circle"></i> Completado</span>
                                    <?php else: ?>
                                        <span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;background:rgba(107,114,128,.12);color:#6b7280;font-size:12px;font-weight:600;"><?php echo htmlspecialchars($pedido["estado"]); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p style="color:var(--text-secondary);font-size:13px;padding:20px 0;text-align:center;">No hay pedidos registrados aún.</p>
                <?php endif; ?>
                <?php if((int) $statsInicio["total"] > 0): ?>
                <a href="envios" style="display:block;text-align:center;padding:12px;margin-top:14px;border:1px solid var(--border-color);border-radius:10px;color:var(--accent-primary);font-size:13px;font-weight:600;text-decoration:none;transition:background .15s;">Ver todos los envíos <i class="fa fa-arrow-right" style="margin-left:6px;"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <aside class="inicio-panel inicio-guide" aria-label="Acciones rápidas">
            <h2 class="inicio-panel-title">Acciones rápidas</h2>
            <div class="inicio-guide-row"><a href="envios" style="text-decoration:none;color:inherit;"><i class="fa fa-truck inicio-guide-icon"></i><span><strong>Ver envíos</strong><span>Revisar y actualizar respuestas</span></span></a></div>
            <div class="inicio-guide-row"><a href="compartir" style="text-decoration:none;color:inherit;"><i class="fa fa-share-alt inicio-guide-icon"></i><span><strong>Compartir formulario</strong><span>Generar o copiar tu enlace</span></span></a></div>
            <div class="inicio-guide-row"><a href="configuracion" style="text-decoration:none;color:inherit;"><i class="fa fa-cog inicio-guide-icon"></i><span><strong>Configuración</strong><span>Datos, horarios y apariencia</span></span></a></div>
            <?php if(isset($_SESSION["perfil"]) && strtolower(trim((string) $_SESSION["perfil"])) === "administrador"): ?>
            <div class="inicio-guide-row"><a href="usuarios" style="text-decoration:none;color:inherit;"><i class="fa fa-users inicio-guide-icon"></i><span><strong>Usuarios</strong><span>Gestionar cuentas y planes</span></span></a></div>
            <?php endif; ?>
        </aside>
    </section>
</main>