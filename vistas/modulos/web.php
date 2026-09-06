<?php
$landingTitle = "MOABCODE · Gestión de envíos";
?>
<style>
    body:has(.landing-page) { background: #f7f8fb; }
    .landing-page, .landing-page * { box-sizing: border-box; }
    .landing-page { --brand-navy: #09275a; --brand-navy-deep: #061b3d; --brand-gold: #c7922f; --brand-gold-dark: #9a6a12; --brand-gold-soft: #fff4d7; min-height: 100vh; overflow: hidden; color: #182235; background: #f7f8fb; font-family: 'Source Sans Pro', sans-serif; }
    .landing-nav { display: flex; align-items: center; justify-content: space-between; max-width: 1180px; margin: 0 auto; padding: 22px 28px; }
    .landing-brand img { display: block; width: 164px; height: auto; }
    .landing-nav-actions { display: flex; align-items: center; gap: 12px; }
    .landing-menu-toggle { display: none; width: 42px; height: 42px; align-items: center; justify-content: center; border: 1px solid #d8e0ec; border-radius: 9px; background: #fff; color: var(--brand-navy); cursor: pointer; font-size: 18px; }
    .landing-menu-toggle:hover { border-color: var(--brand-gold); color: var(--brand-gold-dark); }
    .landing-link { color: #536176; font-size: 14px; font-weight: 700; text-decoration: none; }
    .landing-link:hover { color: var(--brand-gold-dark); }
    .landing-button { display: inline-flex; align-items: center; justify-content: center; min-height: 42px; padding: 0 18px; border-radius: 9px; font-size: 14px; font-weight: 700; text-decoration: none !important; }
    .landing-button-primary { background: var(--brand-navy); color: #fff; box-shadow: 0 10px 22px rgba(9,39,90,.2); }
    .landing-button-primary:hover { background: var(--brand-navy-deep); color: #fff; }
    .landing-button-quiet { border: 1px solid #d8e0ec; background: #fff; color: #334155; }
    .landing-theme-toggle { display: inline-flex; width: 42px; height: 42px; align-items: center; justify-content: center; border: 1px solid #d8e0ec; border-radius: 9px; background: #fff; color: var(--brand-navy); cursor: pointer; font-size: 16px; }
    .landing-theme-toggle:hover { border-color: var(--brand-gold); color: var(--brand-gold-dark); }
    .landing-visually-hidden { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
    .landing-hero { display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(360px, .95fr); align-items: center; gap: 70px; max-width: 1180px; margin: 0 auto; padding: 72px 28px 96px; }
    .landing-kicker { margin: 0 0 16px; color: var(--brand-gold-dark); font-size: 11px; font-weight: 800; letter-spacing: 2.5px; text-transform: uppercase; }
    .landing-title { max-width: 650px; margin: 0; color: var(--brand-navy-deep); font-family: Georgia, 'Times New Roman', serif; font-size: clamp(42px, 5vw, 70px); font-weight: 700; line-height: 1.03; }
    .landing-title em { color: var(--brand-gold-dark); font-style: normal; }
    .landing-copy { max-width: 555px; margin: 24px 0 0; color: #59677c; font-size: 18px; line-height: 1.65; }
    .landing-hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 30px; }
    .landing-note { display: flex; align-items: center; gap: 8px; margin-top: 18px; color: #7b8799; font-size: 13px; }
    .landing-note i { color: #10b981; }
    .landing-visual { position: relative; padding: 22px; border: 1px solid #dce5f0; border-radius: 22px; background: var(--brand-navy-deep); box-shadow: 0 28px 60px rgba(15,23,42,.16); }
    .landing-visual-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; color: #f8e5b1; font-size: 12px; font-weight: 700; }
    .landing-dots { display: flex; gap: 5px; }
    .landing-dots span { width: 7px; height: 7px; border-radius: 50%; background: #475569; }
    .landing-dots span:first-child { background: #e0b24d; }
    .landing-dashboard { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .landing-metric, .landing-list { border: 1px solid #243a5a; border-radius: 13px; background: #172943; }
    .landing-metric { padding: 18px; }
    .landing-metric small { color: #9db2d0; font-size: 11px; }
    .landing-metric strong { display: block; margin-top: 10px; color: #fff; font-size: 36px; line-height: 1; }
    .landing-metric b { display: inline-block; margin-top: 10px; color: #34d399; font-size: 11px; }
    .landing-list { grid-column: 1 / -1; padding: 15px; }
    .landing-list-head { display: flex; justify-content: space-between; margin-bottom: 12px; color: #dbeafe; font-size: 12px; font-weight: 700; }
    .landing-list-row { display: grid; grid-template-columns: 32px 1fr auto; align-items: center; gap: 10px; padding: 10px 0; border-top: 1px solid #243a5a; color: #a9bbd4; font-size: 12px; }
    .landing-list-row i { display: grid; width: 28px; height: 28px; place-items: center; border-radius: 8px; background: #203b62; color: #60a5fa; }
    .landing-list-row strong { color: #f8fafc; }
    .landing-list-row span:last-child { color: #34d399; font-weight: 700; }
    .landing-section { padding: 84px 28px; background: #fff; }
    .landing-section-inner { max-width: 1180px; margin: 0 auto; }
    .landing-section-heading { max-width: 640px; margin-bottom: 34px; }
    .landing-section-heading h2 { margin: 0; color: #111827; font-family: Georgia, 'Times New Roman', serif; font-size: 38px; line-height: 1.15; }
    .landing-section-heading p { margin: 14px 0 0; color: #64748b; font-size: 16px; line-height: 1.6; }
    .landing-features { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
    .landing-feature { padding: 24px; border: 1px solid #e4eaf2; border-radius: 14px; background: #fff; }
    .landing-feature i { display: grid; width: 42px; height: 42px; place-items: center; margin-bottom: 20px; border-radius: 11px; background: var(--brand-gold-soft); color: var(--brand-gold-dark); font-size: 18px; }
    .landing-feature h3 { margin: 0; color: #1e293b; font-size: 18px; }
    .landing-feature p { margin: 10px 0 0; color: #69778c; font-size: 14px; line-height: 1.6; }
    .landing-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 34px; }
    .landing-step { position: relative; padding-left: 54px; }
    .landing-step-number { position: absolute; top: 0; left: 0; display: grid; width: 36px; height: 36px; place-items: center; border-radius: 50%; background: #111827; color: #fff; font-weight: 800; }
    .landing-step h3 { margin: 4px 0 8px; color: #1e293b; font-size: 17px; }
    .landing-step p { margin: 0; color: #69778c; font-size: 14px; line-height: 1.6; }
    .landing-pricing { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
    .landing-plan { position: relative; display: flex; min-height: 390px; flex-direction: column; padding: 28px; border: 1px solid #e0e7f0; border-radius: 16px; background: #fff; }
    .landing-plan-featured { border-color: var(--brand-gold); box-shadow: 0 18px 38px rgba(199,146,47,.18); transform: translateY(-8px); }
    .landing-plan-badge { position: absolute; top: -12px; left: 24px; padding: 5px 10px; border-radius: 999px; background: var(--brand-gold); color: #fff; font-size: 10px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
    .landing-plan-icon { display: grid; width: 42px; height: 42px; place-items: center; margin-bottom: 20px; border-radius: 11px; background: var(--brand-gold-soft); color: var(--brand-gold-dark); font-size: 18px; }
    .landing-plan h3 { margin: 0; color: #172033; font-size: 21px; }
    .landing-plan-description { min-height: 50px; margin: 10px 0 22px; color: #69778c; font-size: 14px; line-height: 1.55; }
    .landing-plan-price { color: #111827; font-size: 38px; font-weight: 800; line-height: 1; }
    .landing-plan-price small { color: #7b8799; font-size: 13px; font-weight: 600; }
    .landing-plan-list { display: grid; gap: 10px; margin: 24px 0; padding: 0; color: #59677c; font-size: 13px; list-style: none; }
    .landing-plan-list li { display: flex; gap: 8px; line-height: 1.4; }
    .landing-plan-list i { color: #10b981; }
    .landing-plan .landing-button { width: 100%; margin-top: auto; }
    .landing-cta { max-width: 1180px; margin: 0 auto; padding: 86px 28px 100px; text-align: center; }
    .landing-cta-inner { padding: 54px 28px; border-radius: 18px; background: #111827; color: #fff; }
    .landing-cta h2 { margin: 0; font-family: Georgia, 'Times New Roman', serif; font-size: 38px; }
    .landing-cta p { max-width: 570px; margin: 14px auto 24px; color: #b9c5d8; line-height: 1.6; }
    .landing-footer { display: flex; justify-content: space-between; max-width: 1180px; margin: 0 auto; padding: 24px 28px 30px; border-top: 1px solid #dfe6ef; color: #7b8799; font-size: 12px; }
    .landing-footer strong { color: #334155; }
    body:has(.landing-page[data-theme="dark"]) { background: #081426; }
    .landing-page[data-theme="dark"] { --brand-navy: #1f4f91; --brand-navy-deep: #061b3d; --brand-gold: #e0b24d; --brand-gold-dark: #f0c86b; --brand-gold-soft: #3b301d; color: #e5edf8; background: #081426; }
    .landing-page[data-theme="dark"] .landing-link { color: #b8c8de; }
    .landing-page[data-theme="dark"] .landing-link:hover { color: var(--brand-gold); }
    .landing-page[data-theme="dark"] .landing-button-quiet,
    .landing-page[data-theme="dark"] .landing-theme-toggle { border-color: #2b4263; background: #10233e; color: #e5edf8; }
    .landing-page[data-theme="dark"] .landing-section { background: #0d1c31; }
    .landing-page[data-theme="dark"] .landing-title,
    .landing-page[data-theme="dark"] .landing-section-heading h2,
    .landing-page[data-theme="dark"] .landing-plan h3,
    .landing-page[data-theme="dark"] .landing-plan-price { color: #f4f7fb; }
    .landing-page[data-theme="dark"] .landing-copy,
    .landing-page[data-theme="dark"] .landing-section-heading p,
    .landing-page[data-theme="dark"] .landing-feature p,
    .landing-page[data-theme="dark"] .landing-step p,
    .landing-page[data-theme="dark"] .landing-plan-description,
    .landing-page[data-theme="dark"] .landing-plan-list { color: #b5c3d6; }
    .landing-page[data-theme="dark"] .landing-feature,
    .landing-page[data-theme="dark"] .landing-plan { border-color: #263d5d; background: #10233e; }
    .landing-page[data-theme="dark"] .landing-menu-toggle { border-color: #2b4263; background: #10233e; color: #e5edf8; }
    .landing-page[data-theme="dark"] .landing-brand { padding: 6px 10px; border-radius: 8px; background: #fff; }
    .landing-page[data-theme="dark"] .landing-footer { border-color: #263d5d; color: #9fb1c8; }
    .landing-page[data-theme="dark"] .landing-footer strong { color: #dbe7f5; }
    @media (max-width: 1100px) { .landing-features, .landing-pricing { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 900px) { .landing-hero { grid-template-columns: 1fr; gap: 40px; padding-top: 48px; } .landing-visual { max-width: 620px; } .landing-steps, .landing-pricing { grid-template-columns: 1fr; } .landing-plan-featured { transform: none; } }
    @media (max-width: 560px) { .landing-features { grid-template-columns: 1fr; } }
    @media (max-width: 560px) { .landing-nav { position: relative; padding: 18px 16px; } .landing-brand img { width: 135px; } .landing-menu-toggle { display: inline-flex; } .landing-nav-actions { display: none; position: absolute; top: 76px; right: 16px; left: 16px; z-index: 20; flex-direction: column; align-items: stretch; gap: 8px; padding: 14px; border: 1px solid #d8e0ec; border-radius: 12px; background: #fff; box-shadow: 0 18px 36px rgba(15,23,42,.16); } .landing-nav-actions.is-open { display: flex; } .landing-nav-actions .landing-link { display: block; padding: 10px 6px; } .landing-nav-actions .landing-theme-toggle { align-self: flex-start; } .landing-page[data-theme="dark"] .landing-nav-actions { border-color: #2b4263; background: #10233e; } .landing-hero { padding: 36px 16px 64px; } .landing-title { font-size: 43px; } .landing-copy { font-size: 16px; } .landing-section { padding: 60px 16px; } .landing-section-heading h2, .landing-cta h2 { font-size: 31px; } .landing-cta { padding: 60px 16px 70px; } .landing-cta-inner { padding: 38px 20px; } .landing-footer { flex-direction: column; gap: 8px; padding: 20px 16px 26px; } }
</style>
<main class="landing-page">
    <nav class="landing-nav" aria-label="Navegación principal">
        <a class="landing-brand" href="?ruta=web" aria-label="MOABCODE inicio"><img src="LOGO.png" alt="MOABCODE"></a>
        <button class="landing-menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="landingMenu"><i class="fa fa-bars" aria-hidden="true"></i><span class="landing-visually-hidden">Abrir menú</span></button><div class="landing-nav-actions" id="landingMenu"><a class="landing-link" href="#funciones">Funciones</a><a class="landing-link" href="#planes">Planes</a><a class="landing-button landing-button-quiet" href="?ruta=login">Ingresar</a><a class="landing-button landing-button-primary" href="?ruta=registro">Crear cuenta</a><button class="landing-theme-toggle" type="button" aria-label="Activar modo oscuro" title="Activar modo oscuro"><i class="fa fa-moon-o" aria-hidden="true"></i><span class="landing-visually-hidden">Cambiar tema</span></button></div>
    </nav>
    <section class="landing-hero" aria-labelledby="landingTitle">
        <div>
            <p class="landing-kicker">Gestión de envíos para negocios que avanzan</p>
            <h1 class="landing-title" id="landingTitle">Convierte cada pedido en una operación <em>clara y controlada.</em></h1>
            <p class="landing-copy">MOABCODE reúne formularios, datos de clientes, métodos de entrega y respuestas en un solo lugar. Comparte un enlace, recibe la información completa y organiza tus envíos sin perseguir mensajes.</p>
            <div class="landing-hero-actions"><a class="landing-button landing-button-primary" href="?ruta=registro">Empieza gratis <i class="fa fa-arrow-right" style="margin-left:8px"></i></a><a class="landing-button landing-button-quiet" href="#como-funciona">Ver cómo funciona</a></div>
            <p class="landing-note"><i class="fa fa-check-circle"></i> Pensado para crecer con tu negocio y mantener cada cuenta separada.</p>
        </div>
        <div class="landing-visual" aria-label="Vista previa del panel de gestión">
            <div class="landing-visual-top"><span>Panel de operaciones</span><span class="landing-dots"><span></span><span></span><span></span></span></div>
            <div class="landing-dashboard"><div class="landing-metric"><small>Respuestas recibidas</small><strong>248</strong><b><i class="fa fa-arrow-up"></i> 18% este mes</b></div><div class="landing-metric"><small>Entregas en curso</small><strong>36</strong><b><i class="fa fa-check"></i> Operación activa</b></div><div class="landing-list"><div class="landing-list-head"><span>Últimos envíos</span><span>Estado</span></div><div class="landing-list-row"><i class="fa fa-truck"></i><strong>Pedido #MOA-2481</strong><span>Listo</span></div><div class="landing-list-row"><i class="fa fa-map-marker"></i><strong>Pedido #MOA-2478</strong><span>En ruta</span></div><div class="landing-list-row"><i class="fa fa-clock-o"></i><strong>Pedido #MOA-2474</strong><span>Revisión</span></div></div></div>
        </div>
    </section>
    <section class="landing-section" id="funciones"><div class="landing-section-inner"><div class="landing-section-heading"><p class="landing-kicker">Una operación más simple</p><h2>Todo lo que necesitas para dejar de improvisar.</h2><p>Una experiencia pensada para negocios que reciben pedidos por WhatsApp, redes sociales o campañas y necesitan convertirlos en envíos ordenados.</p></div><div class="landing-features"><article class="landing-feature"><i class="fa fa-link"></i><h3>Formulario compartible</h3><p>Genera un enlace único para que tus clientes registren sus datos de forma clara y completa.</p></article><article class="landing-feature"><i class="fa fa-inbox"></i><h3>Respuestas centralizadas</h3><p>Consulta cada respuesta desde un panel organizado, con la información que tu operación realmente necesita.</p></article><article class="landing-feature"><i class="fa fa-cog"></i><h3>Reglas de despacho</h3><p>Configura métodos, horarios, días de despacho y anticipación según la forma en que trabajas.</p></article><article class="landing-feature"><i class="fa fa-file-text-o"></i><h3>Facturación electrónica opcional</h3><p>Agrega la facturación electrónica como un servicio adicional al plan base, según las necesidades de tu negocio.</p></article></div></div></section>
    <section class="landing-section" id="como-funciona"><div class="landing-section-inner"><div class="landing-section-heading"><p class="landing-kicker">Cómo funciona</p><h2>Del pedido al despacho en tres pasos.</h2></div><div class="landing-steps"><article class="landing-step"><span class="landing-step-number">1</span><h3>Configura tu operación</h3><p>Define tus datos, métodos de entrega, horarios y días disponibles.</p></article><article class="landing-step"><span class="landing-step-number">2</span><h3>Comparte tu enlace</h3><p>Envía el formulario por WhatsApp o publícalo en tus canales de venta.</p></article><article class="landing-step"><span class="landing-step-number">3</span><h3>Organiza y responde</h3><p>Revisa la información y actualiza el estado de cada envío con claridad.</p></article></div></div></section>
    <section class="landing-section" id="planes"><div class="landing-section-inner"><div class="landing-section-heading"><p class="landing-kicker">Planes claros, sin complicaciones</p><h2>Elige cómo quieres empezar.</h2><p>Comienza con una prueba, continúa con un plan simple o construye una solución a la medida de tu operación.</p></div><div class="landing-pricing"><article class="landing-plan"><div class="landing-plan-icon"><i class="fa fa-bolt"></i></div><h3>Prueba gratuita</h3><p class="landing-plan-description">Conoce MOABCODE y prueba el flujo completo antes de decidir.</p><div class="landing-plan-price">3 <small>días gratis</small></div><ul class="landing-plan-list"><li><i class="fa fa-check"></i><span>Accede a tu espacio de trabajo</span></li><li><i class="fa fa-check"></i><span>Configura tu formulario</span></li><li><i class="fa fa-check"></i><span>Evalúa tu operación sin compromiso</span></li></ul><a class="landing-button landing-button-quiet" href="?ruta=registro">Probar gratis</a></article><article class="landing-plan landing-plan-featured"><span class="landing-plan-badge">Más elegido</span><div class="landing-plan-icon"><i class="fa fa-line-chart"></i></div><h3>Plan mensual</h3><p class="landing-plan-description">La opción práctica para operar tus envíos con continuidad y orden.</p><div class="landing-plan-price">S/ 30 <small>/ mes</small></div><ul class="landing-plan-list"><li><i class="fa fa-check"></i><span>Gestión de formularios y respuestas</span></li><li><i class="fa fa-check"></i><span>Configuración de métodos y horarios</span></li><li><i class="fa fa-check"></i><span>Una operación lista para crecer</span></li></ul><a class="landing-button landing-button-primary" href="https://wa.me/51916377263?text=Hola%2C%20quiero%20elegir%20el%20plan%20mensual%20de%20MOABCODE." target="_blank" rel="noopener">Elegir plan mensual</a></article><article class="landing-plan"><div class="landing-plan-icon"><i class="fa fa-sliders"></i></div><h3>A tu medida</h3><p class="landing-plan-description">Para negocios que necesitan una experiencia especial, integrada y hecha a pedido.</p><div class="landing-plan-price">Hablemos <small>de tu proyecto</small></div><ul class="landing-plan-list"><li><i class="fa fa-check"></i><span>Definimos juntos tus necesidades</span></li><li><i class="fa fa-check"></i><span>Diseño de flujo personalizado</span></li><li><i class="fa fa-check"></i><span>Una solución adaptada a tu forma de trabajar</span></li></ul><a class="landing-button landing-button-quiet" href="https://wa.me/51916377263?text=Hola%2C%20quiero%20conversar%20sobre%20un%20plan%20a%20la%20medida%20de%20MOABCODE." target="_blank" rel="noopener">Conversar sobre mi plan</a></article><article class="landing-plan"><span class="landing-plan-badge">Opcional</span><div class="landing-plan-icon"><i class="fa fa-file-text-o"></i></div><h3>Facturación electrónica</h3><p class="landing-plan-description">Añade facturación electrónica a tu operación cuando tu negocio lo necesite.</p><div class="landing-plan-price">Consultar <small>según alcance</small></div><ul class="landing-plan-list"><li><i class="fa fa-check"></i><span>Servicio adicional al plan base</span></li><li><i class="fa fa-check"></i><span>Integración con tu operación</span></li><li><i class="fa fa-check"></i><span>Definimos el alcance contigo</span></li></ul><a class="landing-button landing-button-quiet" href="https://wa.me/51916377263?text=Hola%2C%20quiero%20consultar%20la%20opcion%20de%20facturacion%20electronica%20de%20MOABCODE." target="_blank" rel="noopener">Consultar opción</a></article></div></div></section>
    <section class="landing-cta"><div class="landing-cta-inner"><h2>Tu próximo envío puede estar mejor organizado.</h2><p>Empieza con una cuenta y convierte la información dispersa en una operación que puedes controlar.</p><a class="landing-button landing-button-primary" href="?ruta=registro">Crear mi cuenta <i class="fa fa-arrow-right" style="margin-left:8px"></i></a></div></section>
    <footer class="landing-footer"><strong>MOABCODE · Gestión de envíos</strong><span>Operaciones más claras para negocios que quieren crecer.</span></footer>
</main>
<script>
    (function () {
        const page = document.querySelector('.landing-page');
        const toggle = document.querySelector('.landing-theme-toggle');
        const icon = toggle.querySelector('i');
        const menuToggle = document.querySelector('.landing-menu-toggle');
        const menu = document.querySelector('#landingMenu');
        const storageKey = 'moabcode-landing-theme';

        function closeMenu() {
            menu.classList.remove('is-open');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Abrir menú');
            menuToggle.querySelector('i').className = 'fa fa-bars';
        }

        menuToggle.addEventListener('click', function () {
            const isOpen = menu.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            menuToggle.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
            menuToggle.querySelector('i').className = isOpen ? 'fa fa-times' : 'fa fa-bars';
        });

        menu.querySelectorAll('.landing-link').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });

        function applyTheme(theme) {
            const darkMode = theme === 'dark';
            page.dataset.theme = darkMode ? 'dark' : 'light';
            icon.className = darkMode ? 'fa fa-sun-o' : 'fa fa-moon-o';
            toggle.setAttribute('aria-pressed', darkMode ? 'true' : 'false');
            toggle.setAttribute('aria-label', darkMode ? 'Activar modo claro' : 'Activar modo oscuro');
            toggle.setAttribute('title', darkMode ? 'Activar modo claro' : 'Activar modo oscuro');
        }

        let savedTheme = null;
        try {
            savedTheme = window.localStorage.getItem(storageKey);
        } catch (error) {
            savedTheme = null;
        }

        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        applyTheme(savedTheme === 'dark' || savedTheme === 'light' ? savedTheme : systemTheme);

        toggle.addEventListener('click', function () {
            const nextTheme = page.dataset.theme === 'dark' ? 'light' : 'dark';
            applyTheme(nextTheme);
            try {
                window.localStorage.setItem(storageKey, nextTheme);
            } catch (error) {
            }
        });
    }());
</script>
