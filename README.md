# APKUP Theme — Changelog

> **Modern & Minimal UI Overhaul · Download Enhancements · Design System Refinements**

This document outlines the recent changes applied to the APKUP theme — modernizing the UI design language, removing outdated 3D elements, and introducing new dynamic features across the header, buttons, download page, and overall design consistency.

---

## Table of Contents

1. [Header & Navigation](#1-header--navigation)
2. [General Button Styling](#2-general-button-styling)
3. [Download Page Redesign](#3-download-page-redesign)
4. [UI Polish & Design Consistency](#4-ui-polish--design-consistency)

---

## 1. Header & Navigation

*Applies to: Desktop & Mobile*

### Glassmorphism Effect

Upgraded the main `<header>` and the Search dropdown "shutter" with a modern translucent glass effect using `backdrop-blur` and layered background opacity, giving the navigation a refined, depth-driven appearance.

### Dynamic Color Theming

Removed hard-coded static hover colors (blue/gray) from both:

- Desktop header menu → `components/utils/header.php`
- Footer mobile off-canvas menu → `components/utils/footer.php`

Hover and interaction states now dynamically inherit the user's selected primary color theme.

---

## 2. General Button Styling

### Scroll to Top Button — `.btn-icon`

Stripped the old 3D gradients and gloss layer from the floating scroll-to-top button. It now uses a **solid primary theme color** background with modern drop shadows that lift cleanly on hover.

**File:** `style.css`

---

## 3. Download Page Redesign

### Modern Progress Bar

Replaced the bulky, 3D animated wave progress bar with an **ultra-thin animated gradient bar** featuring an elegant glowing effect and refined typography.

**Files:** `style.css`, `components/utils/download.php`

### Timing Synchronization — *Bug Fix*

Fixed the JavaScript progress bar timer to rely purely on CSS linear transitions bound to the user-defined duration. This ensures butter-smooth animation perfectly synchronized with the countdown clock.

### Dynamic App Banner — *New Feature*

Added a new toggle in the Admin Panel under **Theme Options → Descargar** labeled **"App Banner"**.

- **Toggle location:** `admin/inc/menu/components/download.php`
- **Logic:** `components/utils/download.php` conditionally loads the `wp_poster_GP` meta image as a large, full-width faded banner behind the app's logo and title when the feature is enabled.
- Uses negative margins (`-mt-32`) to achieve a premium **App Store–style cover photo overlay** effect.

---

## 4. UI Polish & Design Consistency

### Premium Download Banner

Elevated the banner in `components/utils/download.php` from a stretched edge-to-edge image to an **"App Store Card"** design:

| Property | Value |
|---|---|
| Max width | `max-w-5xl` |
| Border radius | `rounded-[2rem]` |
| Shadow | `shadow-2xl` |
| Hover effect | `hover:scale-[1.02]` cinematic zoom |

Includes subtle environmental background gradients for depth and atmosphere.

### Typography Alignment

Applied the `Nunito` font natively to the *Descargar* header on the download page with negative letter spacing (`-0.5px`) — delivering a polished, robust look that harmonizes with surrounding typographic elements.

### Animated Dark Mode Transition — *Bug Fix*

Resolved a layout overflow bug in `components/utils/header.php`.

**Root cause:** The `themeTransitionOverlay` was nested inside the `<header>` element, which restricted the overlay via CSS stacking context caused by `backdrop-blur`.

**Fix:** Moved the overlay outside `<header>` and applied `fixed inset-0 overflow-hidden` — ensuring the sun and moon vector animations originate correctly from the viewport center without triggering horizontal scrolling.

### Minimal Telegram Button — `.btn-join`

Replaced the dated gradient fills and hard drop shadows on the Telegram footer button (`style.css`) with a flat `--app-primary` fill. Hover now uses smooth translation and subtle brightness — precisely matching the clean design language of the new `.btn-primary-action` button.

---

*APKUP Theme · UI Overhaul Release*