# Analysis of `app_developer()` and `'desarrollador'` Data Retrieval

This document provides a detailed breakdown of how the developer (`desarrollador`) info function works in the **Appyn** theme, how the data is stored in the database, and how you can implement/reuse this logic in another WordPress theme.

---

## 1. The Function Code

In the Appyn theme, the function is named `app_developer()` and is located in the file [template-tags.php](file:///c:/laragon/www/apkup/wp-content/themes/appyn/includes/template-tags.php#L96-L112):

```php
function app_developer() {
	global $post;

	if( appyn_options( 'post_developer', true ) ) return;

	$developer = get_datos_info( 'desarrollador', false, $post->ID );
    $output = '';
	if( !empty($developer) ) {
		$output = '<span class="developer">'.$developer.'</span>';
	} else {
		$dev_terms = wp_get_post_terms( $post->ID, 'dev', array('fields' => 'all'));
		if( !empty($dev_terms) ) {
			$output = '<span class="developer">'.$dev_terms[0]->name.'</span>';
		}
	}
	return $output;
}
```

---

## 2. How it Works

The function executes the following sequence of checks:

1. **Option Check**: It calls `appyn_options( 'post_developer', true )` to see if displaying the developer is disabled in the theme options. If disabled, it returns early and outputs nothing.
2. **Metadata Lookup**: It calls `get_datos_info( 'desarrollador', false, $post->ID )` to get the developer's name from custom fields (serialized post meta).
3. **Output Formatter (Metadata)**: If a developer name is found in the metadata, it wraps it in a `<span class="developer">...</span>` and returns it.
4. **Taxonomy Fallback**: If the metadata is empty, it queries the taxonomy terms associated with the post under the taxonomy `'dev'` using `wp_get_post_terms()`.
5. **Output Formatter (Taxonomy)**: If any terms exist for `'dev'`, it takes the first term's name (`$dev_terms[0]->name`), wraps it in a `<span class="developer">...</span>`, and returns it.

---

## 3. Where and How the Data is Stored

The theme handles the developer data in two distinct ways:

### A. Serialized Post Meta Key (`datos_informacion`)
* **Meta Key Name**: `datos_informacion`
* **Data Format**: A serialized PHP array of key-value pairs stored in the `wp_postmeta` table.
* **Developer Key**: `'desarrollador'` inside the array.
* **How to retrieve it directly**:
  ```php
  $info = get_post_meta( $post_id, 'datos_informacion', true );
  $developer = isset( $info['desarrollador'] ) ? $info['desarrollador'] : '';
  ```
* **How it gets populated**: 
  - **Import scraper / API bot**: When crawling Google Play Store or the App Store (implemented in `admin/class-eps.php`), it extracts the developer name from the store and saves it in the `datos_informacion` array under the `'desarrollador'` index.
  - **Meta Box**: In `functions.php`, a meta box registers fields for `datos_informacion[...]` which are saved via the `save_post` hook (`px_quote_meta_save()`).

### B. Custom WordPress Taxonomy (`dev`)
* **Taxonomy Name**: `dev`
* **Object Type**: Associated with the `post` post type.
* **How it gets registered**:
  In [functions.php](file:///c:/laragon/www/apkup/wp-content/themes/appyn/functions.php#L324-L340):
  ```php
  add_action( 'init', 'dev_taxonomy_register' );
  function dev_taxonomy_register() {
      register_taxonomy(
          'dev',
          'post',
          array(
              'label' => __( 'Desarrollador', 'appyn' ),
              'sort' => true,
              'args' => array( 'orderby' => 'term_order' ),
              'show_in_rest' => true,
              'rewrite' => array( 'slug' => 'dev' ),
              'labels' => array( 'menu_name' => __( 'Desarrollador', 'appyn' ) )
          )
      );
  }
  ```
* **How to retrieve it directly**:
  ```php
  $terms = wp_get_post_terms( $post_id, 'dev', array( 'fields' => 'all' ) );
  if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
      $developer_name = $terms[0]->name;
  }
  ```

---

## 4. How to Apply This to Your Other Theme

If you want to use the same logic in another theme, here is a clean, self-contained implementation you can drop into the other theme's `functions.php` file:

```php
/**
 * Register the 'dev' (Developer) taxonomy if it doesn't already exist.
 */
function my_custom_dev_taxonomy() {
    if ( ! taxonomy_exists( 'dev' ) ) {
        register_taxonomy(
            'dev',
            'post',
            array(
                'label'        => __( 'Developer', 'textdomain' ),
                'hierarchical' => false,
                'public'       => true,
                'show_in_rest' => true,
                'rewrite'      => array( 'slug' => 'developer' ),
            )
        );
    }
}
add_action( 'init', 'my_custom_dev_taxonomy' );

/**
 * Retrieve the developer name for a post.
 * Supports Appyn-style serialized meta 'datos_informacion' as well as standard 'dev' taxonomy.
 * 
 * @param int|WP_Post|null $post_id Post ID or WP_Post object.
 * @return string Developer name or empty string.
 */
function get_my_theme_developer( $post_id = null ) {
    $post_id = empty( $post_id ) ? get_the_ID() : $post_id;
    if ( ! $post_id ) {
        return '';
    }

    // 1. Check if Appyn metadata format exists
    $info = get_post_meta( $post_id, 'datos_informacion', true );
    if ( is_array( $info ) && ! empty( $info['desarrollador'] ) ) {
        return sanitize_text_field( $info['desarrollador'] );
    }

    // 2. Check if a simple meta field exists (optional fallback)
    $simple_dev = get_post_meta( $post_id, 'desarrollador', true );
    if ( ! empty( $simple_dev ) ) {
        return sanitize_text_field( $simple_dev );
    }

    // 3. Fallback to 'dev' taxonomy terms
    $terms = wp_get_post_terms( $post_id, 'dev', array( 'fields' => 'all' ) );
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        return esc_html( $terms[0]->name );
    }

    return '';
}
```

### Displaying it in your template:
In your other theme's template files (e.g., `single.php`, `content.php`), you can display it using:
```php
$developer = get_my_theme_developer();
if ( ! empty( $developer ) ) {
    echo '<span class="developer">' . esc_html( $developer ) . '</span>';
}
```
