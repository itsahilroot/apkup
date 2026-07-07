<?php
/**
 * Mobile Bottom Navigation Template (Glassmorphism & Sliding Active Pill Indicator)
 */

$telegram_url = get_theme_mod('au_telegram_menu_url', '');
if (empty($telegram_url)) {
    $telegram_url = get_theme_mod('telegram_url', 'https://t.me/apkgstore');
}

$games_url = get_theme_mod('au_games_menu_url', '');
if (empty($games_url)) {
    $games_url = home_url('/games/');
}

$apps_url = get_theme_mod('au_apps_menu_url', '');
if (empty($apps_url)) {
    $apps_url = home_url('/category/apps/');
}

// Determine active index based on current page/URL
$current_url = $_SERVER['REQUEST_URI'];
$active_index = 0; // Default to Inicio

if (is_front_page() || is_home()) {
    $active_index = 0;
} elseif (
    is_page('juegos') || is_page('games') ||
    (is_category() && (strpos(strtolower(single_cat_title('', false)), 'juego') !== false || strpos(strtolower(single_cat_title('', false)), 'game') !== false)) ||
    (is_single() && (has_category('juegos') || has_category('games') || has_category('game') || has_category('juego')))
) {
    $active_index = 1;
} elseif (
    is_page('apps') || is_page('aplicaciones') ||
    (is_category() && (strpos(strtolower(single_cat_title('', false)), 'app') !== false || strpos(strtolower(single_cat_title('', false)), 'aplicaci') !== false)) ||
    (is_single() && (has_category('apps') || has_category('aplicaciones') || has_category('app')))
) {
    $active_index = 2;
} else {
    // Fallback URL checking
    if (strpos($current_url, '/games') !== false || strpos($current_url, '/juegos') !== false) {
        $active_index = 1;
    } elseif (strpos($current_url, '/apps') !== false || strpos($current_url, '/aplicaciones') !== false) {
        $active_index = 2;
    }
}
?>

<style>
/* Entrance slide-up animation for the menu */
@keyframes mobileNavSlideIn {
    from {
        transform: translate(-50%, 100px);
        opacity: 0;
    }
    to {
        transform: translate(-50%, 0);
        opacity: 1;
    }
}

/* Custom styling for floating premium mobile navigation bar */
.mobile-nav-container, .mobile-bottom-nav {
    position: fixed;
    bottom: 12px;
    left: 50%;
    transform: translate(-50%, 0);
    width: calc(100% - 32px);
    max-width: 600px; /* Wider limit as requested */
    height: 60px;
    border-radius: 24px;
    background: rgba(255, 255, 255, 0.72);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.55);
    box-shadow:
        0 10px 28px rgba(15, 23, 42, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.65);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0; /* Changed to 0 so the 20% widths align exactly with sliding indicator */
    animation: mobileNavSlideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease, background 0.3s ease, border 0.3s ease, box-shadow 0.3s ease;
}

.dark .mobile-nav-container, .dark .mobile-bottom-nav {
    background: rgba(15, 23, 42, 0.68);
    backdrop-filter: blur(26px) saturate(180%);
    -webkit-backdrop-filter: blur(26px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.10);
    box-shadow:
        0 12px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.08);
}

/* Minimized state when closed by toggle */
.mobile-nav-container.minimized {
    transform: translate(-50%, calc(100% + 30px)) !important;
}

/* Active Sliding indicator container */
.mobile-nav-indicator-wrapper {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 20%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
    transition: left 300ms cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 10;
}

/* The active item glass pill capsule background */
.mobile-nav-indicator-pill, .mobile-bottom-nav .active-item {
    width: 58px;
    height: 52px; /* Minimal gap from top and bottom */
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.38);
    backdrop-filter: blur(18px) saturate(180%);
    -webkit-backdrop-filter: blur(18px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.55);
    box-shadow:
        0 6px 18px rgba(26, 115, 232, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.55);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: translateY(-4px); /* Floating slightly above the navigation bar */
    transition: all 0.3s ease;
}

.dark .mobile-nav-indicator-pill, .dark .mobile-bottom-nav .active-item {
    background: rgba(30, 41, 59, 0.62);
    border: 1px solid rgba(255, 255, 255, 0.10);
    box-shadow:
        0 6px 20px rgba(26, 115, 232, 0.18),
        inset 0 1px 0 rgba(255, 255, 255, 0.10);
}

/* Centered blue active dot inside capsule below icon, overlapping neither icon nor label */
.mobile-nav-indicator-dot {
    position: absolute;
    bottom: 18px; /* Centered between icon and label */
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background-color: #1A73E8;
    box-shadow: 0 1px 2px rgba(26, 115, 232, 0.3);
    left: 50%;
    transform: translateX(-50%);
}

/* Nav item design */
.mobile-nav-item {
    width: 20%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #4B5563; /* Inactive color */
    font-size: 10px;
    font-weight: 500;
    position: relative;
    z-index: 20;
    transition: color 280ms ease-in-out;
    box-sizing: border-box;
}

.dark .mobile-nav-item {
    color: #9CA3AF;
}

/* Icon positioning */
.mobile-nav-item .nav-icon-container {
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 280ms ease-in-out;
}

.mobile-nav-item .nav-icon-container svg {
    width: 20px !important;
    height: 20px !important;
}

.mobile-nav-item .nav-dot-spacer {
    height: 8px; /* Empty spacer to prevent dot overlap */
    width: 100%;
}

.mobile-nav-item .nav-label {
    font-size: 10px;
    line-height: 10px;
    font-weight: 500;
    transition: color 280ms ease-in-out;
}

/* Active States */
.mobile-nav-item.active {
    color: #1A73E8; /* Active text turns blue */
}

.mobile-nav-item.active .nav-icon-container {
    color: #1A73E8;
}

/* Open/Close toggle handle */
.mobile-nav-toggle-btn {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    width: 32px;
    height: 14px;
    border-radius: 6px 6px 0 0;
    background: rgba(255, 255, 255, 0.9);
    border-top: 0.5px solid rgba(0, 0, 0, 0.05);
    border-left: 0.5px solid rgba(0, 0, 0, 0.05);
    border-right: 0.5px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 -3px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 100;
    transition: all 0.3s ease;
}

.dark .mobile-nav-toggle-btn {
    background: rgba(30, 41, 59, 0.95);
    border-top: 0.5px solid rgba(255, 255, 255, 0.08);
    border-left: 0.5px solid rgba(255, 255, 255, 0.08);
    border-right: 0.5px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.15);
}

.mobile-nav-toggle-btn svg {
    width: 8px;
    height: 8px;
    color: #4B5563;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.dark .mobile-nav-toggle-btn svg {
    color: #9CA3AF;
}

/* When minimized, adjust toggle handle styling to float at bottom */
.mobile-nav-container.minimized .mobile-nav-toggle-btn {
    top: -24px;
    height: 20px;
    border-radius: 8px;
    box-shadow: 0 -3px 10px rgba(26, 115, 232, 0.15);
    background: #1A73E8;
    border: none;
}

.mobile-nav-container.minimized .mobile-nav-toggle-btn svg {
    transform: rotate(180deg);
    color: #ffffff;
}

/* Custom styles to prevent layout overlap with page content */
body {
    padding-bottom: 80px !important;
}
@media (min-width: 768px) {
    body {
        padding-bottom: 0px !important;
    }
    .mobile-nav-container {
        display: none !important;
    }
}
</style>

<nav class="md:hidden mobile-nav-container mobile-bottom-nav" id="mobile-nav-bar">
    <!-- Toggle Open/Close Handle Button -->
    <div class="mobile-nav-toggle-btn" id="mobile-nav-toggle" title="Minimizar/Mostrar menú">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </div>

    <!-- Sliding active indicator -->
    <div class="mobile-nav-indicator-wrapper" id="mobile-nav-indicator" style="left: <?php echo $active_index * 20; ?>%;">
        <div class="mobile-nav-indicator-pill active-item">
            <div class="mobile-nav-indicator-dot"></div>
        </div>
    </div>

    <!-- 1. Inicio -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-item <?php echo $active_index === 0 ? 'active' : ''; ?>" data-index="0">
        <div class="nav-icon-container">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 10a1 1 0 0 1 .5-.8l8-5.3a1 1 0 0 1 1 0l8 5.3a1 1 0 0 1 .5.8v9.5a2.5 2.5 0 0 1-2.5 2.5h-13A2.5 2.5 0 0 1 3 19.5Z" />
            </svg>
        </div>
        <div class="nav-dot-spacer"></div>
        <span class="nav-label">Inicio</span>
    </a>

    <!-- 2. Juegos (Using gamepad-2 layout) -->
    <a href="<?php echo esc_url($games_url); ?>" class="mobile-nav-item <?php echo $active_index === 1 ? 'active' : ''; ?>" data-index="1">
        <div class="nav-icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gamepad2-icon lucide-gamepad-2 w-6 h-6"><line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/></svg>
        </div>
        <div class="nav-dot-spacer"></div>
        <span class="nav-label">Juegos</span>
    </a>

    <!-- 3. Apps -->
    <a href="<?php echo esc_url($apps_url); ?>" class="mobile-nav-item <?php echo $active_index === 2 ? 'active' : ''; ?>" data-index="2">
        <div class="nav-icon-container">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1.5" />
                <rect x="14" y="3" width="7" height="7" rx="1.5" />
                <rect x="14" y="14" width="7" height="7" rx="1.5" />
                <rect x="3" y="14" width="7" height="7" rx="1.5" />
            </svg>
        </div>
        <div class="nav-dot-spacer"></div>
        <span class="nav-label">Apps</span>
    </a>

    <!-- 4. Telegram -->
    <a href="<?php echo esc_url($telegram_url); ?>" target="_blank" rel="noopener noreferrer" class="mobile-nav-item" data-index="3">
        <div class="nav-icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send-icon lucide-send w-6 h-6"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
        </div>
        <div class="nav-dot-spacer"></div>
        <span class="nav-label">Telegram</span>
    </a>

    <!-- 5. Menú -->
    <button type="button" id="mobile-nav-menu-btn" class="mobile-nav-item" data-index="4">
        <div class="nav-icon-container">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" x2="20" y1="12" y2="12" />
                <line x1="4" x2="20" y1="6" y2="6" />
                <line x1="4" x2="20" y1="18" y2="18" />
            </svg>
        </div>
        <div class="nav-dot-spacer"></div>
        <span class="nav-label">Menú</span>
    </button>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initMobileNav();
});

// Re-init on PJAX loads
document.addEventListener('pjax:complete', function() {
    initMobileNav();
});

function initMobileNav() {
    const navBar = document.getElementById('mobile-nav-bar');
    if (!navBar) return;

    const indicator = document.getElementById('mobile-nav-indicator');
    const navItems = navBar.querySelectorAll('.mobile-nav-item');

    // Restore minimized preference
    if (localStorage.getItem('mobile_nav_minimized') === '1') {
        navBar.classList.add('minimized');
    }

    // Toggle minimize state click listener
    const toggleBtn = document.getElementById('mobile-nav-toggle');
    if (toggleBtn) {
        // Remove existing listener if re-initialized
        const newToggle = toggleBtn.cloneNode(true);
        toggleBtn.parentNode.replaceChild(newToggle, toggleBtn);
        
        newToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            navBar.classList.toggle('minimized');
            const isMinimized = navBar.classList.contains('minimized');
            localStorage.setItem('mobile_nav_minimized', isMinimized ? '1' : '0');
        });
    }

    // Update indicator position and active classes based on current path
    function updateActiveStateByPath() {
        const path = window.location.pathname;
        let activeIdx = 0; // Default to Inicio

        if (path === '/' || path === '' || path.indexOf('/index.php') > -1) {
            activeIdx = 0;
        } else if (path.indexOf('/games') > -1 || path.indexOf('/juegos') > -1) {
            activeIdx = 1;
        } else if (path.indexOf('/apps') > -1 || path.indexOf('/aplicaciones') > -1) {
            activeIdx = 2;
        } else {
            // Keep current php calculated active index class as fallback
            const activeItem = navBar.querySelector('.mobile-nav-item.active');
            if (activeItem) {
                activeIdx = parseInt(activeItem.getAttribute('data-index') || '0', 10);
            }
        }

        // Apply classes and move pill
        navItems.forEach((item, index) => {
            if (index === activeIdx) {
                item.classList.add('active');
            } else if (index < 3) { // Only clear active for Inicio, Juegos, Apps
                item.classList.remove('active');
            }
        });

        if (indicator) {
            indicator.style.left = (activeIdx * 20) + '%';
        }
    }

    updateActiveStateByPath();

    // Menu toggle event listener (toggles mobile menu off-canvas)
    const menuBtn = document.getElementById('mobile-nav-menu-btn');
    if (menuBtn) {
        // Remove existing listener if re-initialized
        const newMenuBtn = menuBtn.cloneNode(true);
        menuBtn.parentNode.replaceChild(newMenuBtn, menuBtn);

        newMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const menu = document.getElementById('off-canvas-menu');
            const overlay = document.getElementById('menu-overlay');
            if (menu) {
                const isOpen = menu.classList.contains('translate-x-0');
                if (isOpen) {
                    // Close the menu
                    const closeBtn = document.getElementById('close-menu');
                    if (closeBtn) {
                        closeBtn.click();
                    } else if (overlay) {
                        overlay.click();
                    } else {
                        // Direct close fallback
                        menu.classList.remove('translate-x-0');
                        menu.classList.add('-translate-x-full');
                        if (overlay) {
                            overlay.classList.remove('opacity-100');
                            overlay.classList.add('opacity-0', 'pointer-events-none');
                        }
                    }
                } else {
                    // Open the menu
                    const headerHamburger = document.getElementById('hamburger-btn');
                    if (headerHamburger) {
                        headerHamburger.click();
                    } else {
                        // Direct open fallback
                        menu.classList.remove('-translate-x-full');
                        menu.classList.add('translate-x-0');
                        if (overlay) {
                            overlay.classList.remove('opacity-0', 'pointer-events-none');
                            overlay.classList.add('opacity-100');
                        }
                    }
                }
            }
        });
    }
}
</script>