/*=====================================
MODO CLARO / OSCURO
=====================================*/

document.addEventListener('DOMContentLoaded', function() {
    
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const icon = themeToggle.querySelector('i');
    
    // Cargar tema guardado
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateIcon(savedTheme);
    
    // Toggle tema
    themeToggle.addEventListener('click', function() {
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateIcon(newTheme);
    });
    
    // Actualizar icono
    function updateIcon(theme) {
        if (theme === 'dark') {
            icon.className = 'fa fa-sun-o';
            themeToggle.title = 'Modo claro';
        } else {
            icon.className = 'fa fa-moon-o';
            themeToggle.title = 'Modo oscuro';
        }
    }
    
});
