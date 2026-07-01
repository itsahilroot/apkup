<?php
$post_id = get_the_ID();
$screenshots = get_post_meta($post_id, 'datos_imagenes', true);

if (!empty($screenshots) && is_array($screenshots)) :
?>
<!-- App Screenshots Section -->
<section class="space-y-3.5 my-8">
  <div class="flex items-center justify-between">
    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Capturas de pantalla</h2>
    <button id="viewMoreBtn" onclick="openLightbox(0)" class="text-primary hover:underline text-sm font-bold transition-all cursor-pointer">Ver más</button>
  </div>

  <div class="flex h-[260px] sm:h-[300px] md:h-[340px] space-x-4 overflow-x-auto no-scrollbar py-1 snap-x snap-mandatory cursor-grab active:cursor-grabbing select-none" id="screenshotGallery">
    <?php foreach ($screenshots as $index => $url) : ?>
      <!-- Screenshot Card -->
      <div class="h-full aspect-[16/9] snap-center rounded-2xl relative overflow-hidden shadow-md cursor-pointer border border-slate-200/80 dark:border-brand-darkBorder/60 group shrink-0 transition-all duration-300"
        onclick="openLightbox(<?php echo $index; ?>)">
        <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 9'></svg>"
          data-src="<?php echo esc_url($url); ?>"
          alt="Gameplay Screenshot <?php echo $index + 1; ?>"
          class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 lazyload"
          onload="if (this.naturalHeight > this.naturalWidth) { this.parentNode.classList.remove('aspect-[16/9]'); this.parentNode.classList.add('aspect-[9/16]'); window.dispatchEvent(new Event('resize')); }"
          width="400"
          height="225"
          onerror="this.onerror=null; this.src='https://placehold.co/400x225/0052e0/ffffff?text=Captura+<?php echo $index + 1; ?>';">
      </div>
    <?php endforeach; ?>
  </div>

  <div class="flex-col items-center justify-center mt-3 select-none flex" id="screenTrackContainer">
    <div id="screenTrack" class="w-48 h-2.5 bg-slate-200 dark:bg-slate-800 rounded-full relative cursor-pointer group flex items-center">
      <div class="absolute inset-x-0 h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full group-hover:bg-slate-300 dark:group-hover:bg-slate-700 transition-colors"></div>
      <div id="screenThumb" class="absolute h-2.5 bg-primary rounded-full cursor-grab active:cursor-grabbing transition-transform duration-75 hover:opacity-90 shadow-sm" style="width: 33.0095px; transform: translateX(0px);"></div>
    </div>
    <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold tracking-widest uppercase mt-2 pointer-events-none">Deslizar para ver capturas</span>
  </div>
</section>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300">
  <!-- Close Button -->
  <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-slate-300 p-2 cursor-pointer z-50 bg-black/45 rounded-full" aria-label="Cerrar vista expandida">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
  </button>

  <!-- Prev/Next controls -->
  <button onclick="changeLightboxImage(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-slate-300 p-2.5 cursor-pointer z-50 bg-black/45 rounded-full" aria-label="Imagen anterior">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
    </svg>
  </button>
  <button onclick="changeLightboxImage(1)" class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-slate-300 p-2.5 cursor-pointer z-50 bg-black/45 rounded-full" aria-label="Imagen siguiente">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
    </svg>
  </button>

  <div class="max-w-[90%] max-h-[85%] relative overflow-hidden rounded-2xl border border-white/10 shadow-2xl">
    <img id="lightboxImage" src="" alt="Vista expandida de la captura de pantalla" class="max-w-full max-h-[80vh] object-contain rounded-2xl">
    <div id="lightboxCaption" class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/85 via-black/50 to-transparent p-4 text-white text-sm font-semibold text-center"></div>
  </div>
</div>

<script>
let currentLightboxIndex = 0;
const screenshotUrls = <?php echo json_encode(array_values($screenshots)); ?>;

function openLightbox(index) {
    currentLightboxIndex = index;
    const modal = document.getElementById("lightboxModal");
    const image = document.getElementById("lightboxImage");
    const caption = document.getElementById("lightboxCaption");
    
    if (modal && image) {
        image.src = screenshotUrls[currentLightboxIndex];
        if (caption) {
            caption.innerText = `Captura de pantalla ${currentLightboxIndex + 1}`;
        }
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        setTimeout(() => {
            modal.classList.remove("opacity-0");
            modal.classList.add("opacity-100");
        }, 10);
    }
}

function closeLightbox() {
    const modal = document.getElementById("lightboxModal");
    if (modal) {
        modal.classList.remove("opacity-100");
        modal.classList.add("opacity-0");
        setTimeout(() => {
            modal.classList.remove("flex");
            modal.classList.add("hidden");
        }, 300);
    }
}

function changeLightboxImage(direction) {
    if (!screenshotUrls.length) return;
    currentLightboxIndex = (currentLightboxIndex + direction + screenshotUrls.length) % screenshotUrls.length;
    const image = document.getElementById("lightboxImage");
    const caption = document.getElementById("lightboxCaption");
    if (image) {
        image.src = screenshotUrls[currentLightboxIndex];
        if (caption) {
            caption.innerText = `Captura de pantalla ${currentLightboxIndex + 1}`;
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // Esc/Left/Right Keyboard Navigation
    document.addEventListener("keydown", (e) => {
        const modal = document.getElementById("lightboxModal");
        if (modal && !modal.classList.contains("hidden")) {
            if (e.key === "Escape") closeLightbox();
            if (e.key === "ArrowLeft") changeLightboxImage(-1);
            if (e.key === "ArrowRight") changeLightboxImage(1);
        }
    });

    // Screenshots Gallery Scroll Drag Tracker (Desktop Only)
    const gallery = document.getElementById("screenshotGallery");
    if (gallery) {
        let isDown = false;
        let startX;
        let scrollLeft;

        gallery.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - gallery.offsetLeft;
            scrollLeft = gallery.scrollLeft;
            gallery.style.scrollBehavior = 'auto';
            gallery.style.scrollSnapType = 'none';
        });
        
        gallery.addEventListener('mouseleave', () => {
            isDown = false;
            gallery.style.scrollBehavior = '';
            gallery.style.scrollSnapType = '';
        });
        
        gallery.addEventListener('mouseup', () => {
            isDown = false;
            gallery.style.scrollBehavior = '';
            gallery.style.scrollSnapType = '';
        });
        
        gallery.addEventListener('mousemove', (e) => {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - gallery.offsetLeft;
            const walk = (x - startX) * 1.5;
            gallery.scrollLeft = scrollLeft - walk;
        });
    }

    // Custom Scroll Track/Thumb Logic
    const trackContainer = document.getElementById("screenTrackContainer");
    const track = document.getElementById("screenTrack");
    const thumb = document.getElementById("screenThumb");

    if (gallery && track && thumb) {
        const updateThumb = () => {
            const scrollRange = gallery.scrollWidth - gallery.clientWidth;
            const trackRange = track.clientWidth - thumb.clientWidth;
            if (scrollRange > 0) {
                const pct = gallery.scrollLeft / scrollRange;
                thumb.style.transform = `translateX(${pct * trackRange}px)`;
                if (trackContainer) trackContainer.style.display = 'flex';
            } else {
                thumb.style.transform = 'translateX(0px)';
                if (trackContainer) trackContainer.style.display = 'none';
            }
        };

        const updateThumbWidth = () => {
            const ratio = gallery.clientWidth / gallery.scrollWidth;
            if (ratio < 1) {
                const thumbWidth = Math.max(30, ratio * track.clientWidth);
                thumb.style.width = `${thumbWidth}px`;
                if (trackContainer) trackContainer.style.display = 'flex';
            } else {
                if (trackContainer) trackContainer.style.display = 'none';
            }
        };

        // Recalculate on load and resize
        updateThumbWidth();
        updateThumb();

        gallery.addEventListener('scroll', updateThumb);
        window.addEventListener('resize', () => {
            updateThumbWidth();
            updateThumb();
        });

        // Dragging the thumb to scroll
        let isDraggingThumb = false;
        let startXThumb, startScrollLeftThumb;

        thumb.addEventListener('mousedown', (e) => {
            isDraggingThumb = true;
            startXThumb = e.pageX;
            startScrollLeftThumb = gallery.scrollLeft;
            thumb.classList.add('active:cursor-grabbing');
            document.body.style.userSelect = 'none';
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDraggingThumb) return;
            const dx = e.pageX - startXThumb;
            const scrollRange = gallery.scrollWidth - gallery.clientWidth;
            const trackRange = track.clientWidth - thumb.clientWidth;
            if (trackRange > 0) {
                const scrollAmount = (dx / trackRange) * scrollRange;
                gallery.scrollLeft = startScrollLeftThumb + scrollAmount;
            }
        });

        document.addEventListener('mouseup', () => {
            if (isDraggingThumb) {
                isDraggingThumb = false;
                thumb.classList.remove('active:cursor-grabbing');
                document.body.style.userSelect = '';
            }
        });

        // Dragging on the track to jump to position
        track.addEventListener('click', (e) => {
            if (e.target === thumb) return;
            const rect = track.getBoundingClientRect();
            const clickX = e.clientX - rect.left - (thumb.clientWidth / 2);
            const trackRange = track.clientWidth - thumb.clientWidth;
            const scrollRange = gallery.scrollWidth - gallery.clientWidth;
            if (trackRange > 0) {
                const pct = Math.max(0, Math.min(1, clickX / trackRange));
                gallery.scrollTo({
                    left: pct * scrollRange,
                    behavior: 'smooth'
                });
            }
        });
    }
});
</script>
<?php endif; ?>
