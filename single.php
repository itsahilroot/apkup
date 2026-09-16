<?php get_header(); ?>
<main class="max-w-7xl mx-auto px-2 sm:px-4 pt-2 space-y-6">
    <?php single_top_ad('div', 'my-4'); ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start space-y-6 lg:space-y-0">
        <div class="lg:col-span-8 space-y-6">
            <article>
                <div class="entry-content prose prose-slate dark:prose-invert max-w-none">
                    <div class="not-prose">
                        <?php get_template_part('components/single/info'); ?>
                    </div>
                    <div class="not-prose">
                        <?php get_template_part('components/single/screenshots'); ?>
                    </div>
                    <?php get_template_part('components/single/content'); ?>
                </div>
            </article>
            
            <?php single_bottom_ad('div', 'my-4'); ?>
            
            <div class="block lg:hidden">
                <?php get_template_part('components/single/recommended'); ?>
            </div>
            
            <section>
                <?php comments_template(); ?>
            </section>
        </div>
        
        <aside class="hidden lg:block lg:col-span-4 sticky top-17 space-y-6">
            <?php get_template_part('components/single/recommended-sidebar'); ?>
        </aside>
    </div>
</main>
<?php get_footer(); ?>