<?php

/**
*  Remember to include this metabox in functions.php
*  include_once( get_stylesheet_directory() . '/inc/meta_boxes/CustomMetabox.php' );
*/

    class ajotka_custom_metabox {
        /** 
         *  [REQUIRED]
         *  The type of writing screens on which to show the edit screen section
         *  includes: 'post','page','dashboard','link','attachment','custom_post_type','comment'
         *  
         *  @param array $screens 
         */
        public $screens = array('page');
        
        /**
         *  [REQUIRED]
         *  @param string $id = null HTML 'id' attribute of the edit screen section
         */
        public $id = 'ajotka_custom';
        
        /**
         *  [REQUIRED]
         *  @param string $title Title of the edit screen section, visible to user
         */
        public $title = 'AJOTKA Custom metabox';
        
        /**
         *  [REQUIRED]
         *  Function that prints out the HTML for the edit screen section. The function name as a string,
         *  or, within a class, an array to call one of the class's methods.
         *  The callback can accept up to two arguments: the first argument is the $post object for
         *  the post or page that is currently being edited. 
         *  The second argument is the full $metabox item (an array).
         *  
         *  @param callback $callback = null
         */
        public $callback = null;
        
        /**
         *  The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side').
         *  (Note that 'side' doesn't exist before 2.7)
         *  
         *  @param string $context = 'advanced'
         */
        public $context = 'normal';
        
        /**
         *  The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
         *  
         *  @param string $priority = 'default'
         */
        public $priority = 'high';
        
        /**
         *  Arguments to pass into your callback function. The callback will receive the $post object and whatever
         *  parameters are passed through this variable.
         *  
         *  @param array $callback_args = null
         */
        public $callback_args = null;
        
        /**
         *  @param array $fields Array of field names to be saved
         */
        public $fields = array(
            'ajotka_custom',
        );
        
        /**
         *  Construct
         */
        public function __construct() {
            // $this->screens = ( empty( $this->screens ) )? array('post') : $this->screens;
            $this->callback = array($this, 'render_metabox');
            
            add_action('add_meta_boxes',        array($this, 'add_metabox'));
            add_action('save_post',             array($this, 'save'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        }
        
        /**
         *  Add metabox
         */
        public function add_metabox() {
            foreach ( $this->screens as $screen ) {
                add_meta_box(
                    $this->id,
                    $this->title,
                    $this->callback,
                    $screen,
                    $this->context,
                    $this->priority,
                    $this->callback_args
                );
            }
        }
        
        /**
         *  Output metabox content
         */
        public function render_metabox( $post ) {
            ?>

            <p>
                <label for="ajotka_custom" style="display: block;"><strong>Select</strong></label>
                <select name="ajotka_custom" id="ajotka_custom">
                    <option value=""></option>
                    <option value="val1" selected="selected">Option 1</option>
                    <option value="val2">Option 2</option>
                </select>
            </p>
            <script>
                (function($){
                    $('select#ajotka_custom').select2({
                        placeholder: 'Select...',
                        allowClear: true,
                        width: '100%',
                        tags: true,
                        tokenSeparators: [',', ' ']
                    });
                })(jQuery);
            </script>

            <?php
        }
        
        /**
         *  Save metadata to database
         */
        public function save( $post_id ) {
 
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
              return;
      
            if ( array_key_exists('ajotka_custom', $_POST) ) {
                update_post_meta($post_id, 'ajotka_custom', $_POST['ajotka_custom'] ) ;
            }
            
        }

        public function enqueue_scripts( $hook ) {
            if ( ! in_array( $hook , array('post.php','post-new.php')) )
                return;
            global $post_type;
            if ( 'signup' != $post_type )
                return;

            wp_enqueue_style( 'select2-css',      get_stylesheet_directory_uri() . '/lib/select2/select2.min.css',          array(),                 '4.0.1'); 
            wp_enqueue_script( 'select2-js',      get_stylesheet_directory_uri() . '/lib/select2/select2.min.js',           array('jquery'),         '4.0.1');
        }
    }
    new ajotka_custom_metabox();
?>
