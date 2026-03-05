# APKUP Theme Recent Updates

## Modern & Minimal UI Overhaul and Download Enhancements

This document outlines the recent changes applied to the theme to modernize the UI design language, remove outdated 3D elements, and add new dynamic features.

### 1. Header & Navigation (Desktop & Mobile)
- **Glassmorphism**: Upgraded the main `<header>` and the Search dropdown "shutter" to feature a modern translucent glass effect (`backdrop-blur` and background opacity).
- **Dynamic Theming**: Removed hard-coded static hover colors (blue/gray) from both the desktop header menu (`components/utils/header.php`) and the footer's mobile off-canvas menu (`components/utils/footer.php`). These elements now dynamically respect the user's selected primary color theme during hover/interaction states.

### 2. General Button Styling
- **Scroll to Top**: The "scroll to top" floating button `.btn-icon` had its old 3D gradients and gloss layer stripped out. It now features a solid primary theme color background with modern drop shadows that lift elegantly on hover (`style.css`).

### 3. Download Page Redesign
- **Modern Progress Bar**: Replaced the bulky, 3D animated wave progress bar with an ultra-thin, sleek animated gradient bar. It now features an elegant glowing effect and modern typography (`style.css` and `components/utils/download.php`).
- **Timing Synchronization**: Fixed the Javascript progress bar timer so that it relies purely on CSS linear transitions bound to the user-defined duration. This ensures butter-smooth animation perfectly synchronized to the countdown clock.
- **Dynamic App Banner Feature**: 
  - Added a new toggle option inside the Admin Panel under **Theme Options -> Descargar** labeled **"App Banner"** (`admin/inc/menu/components/download.php`).
  - Added logic in `components/utils/download.php` to conditionally load the `wp_poster_GP` meta image as a large, full-width faded banner behind the app's main logo and title if the feature is toggled on. It uses modern negative margins (`-mt-32`) to achieve a premium App Store-like cover photo overlay effect.
