<?php get_header(); ?>
<main class="flex flex-col items-center justify-center min-h-[80vh] px-6 text-center">
    <h1 class="text-[8rem] font-extrabold tracking-tight text-gray-800 dark:text-gray-200 drop-shadow-lg">
        <span class="text-primary">4</span>
        <span class="text-secondary">0</span>
        <span class="text-primary">4</span>
    </h1>
    <h2 class="mt-4 text-3xl font-bold text-gray-700 dark:text-gray-300">
        Oops! Page Not Found
    </h2>
    <p class="mt-3 max-w-md text-lg text-gray-500 dark:text-gray-400">
        The page you’re looking for doesn’t exist or has been moved.
        Try heading back to the homepage or using the menu above.
    </p>
    <div class="mt-8 flex gap-4">
        <a href="<?php echo esc_url(home_url('/')); ?>"
            class="px-6 py-3 text-white bg-primary hover:bg-green-600 rounded-2xl shadow-lg transition transform hover:scale-105">
            Go Home
        </a>
    </div>
    <div class="absolute inset-0 -z-10 flex justify-center">
        <div class="w-72 h-72 bg-primary/20 dark:bg-primary/10 blur-3xl rounded-full"></div>
    </div>
</main>
<?php get_footer(); ?>