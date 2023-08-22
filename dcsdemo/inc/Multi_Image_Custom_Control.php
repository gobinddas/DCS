<?php
if (!class_exists('WP_Customize_Image_Control')) {
  return null;
}

class Multi_Image_Custom_Control extends WP_Customize_Control {

  public $width = 1;
  public $height = 1;
  public $fit = 'cover';

  public function enqueue() {
    wp_enqueue_style('multi-image-style', get_template_directory_uri() . '/css/multi-image.css');
    wp_enqueue_script('multi-image-script', get_template_directory_uri() . '/js/multi-image.js', array('jquery'), rand(), true);
  }

  public function render_content() {
    ?>
    <label>
        <span class='customize-control-title'><?= empty($this->label) ? 'Image' : $this->label ?></span>
        <style>
            #customize-control-<?= $this->id ?> .images li img{
                object-fit:<?= $this->fit ?>;
                width:auto;
                <?php if ($this->width > 0 && $this->height > 0) { ?>
                  aspect-ratio: <?= $this->width ?>/<?= $this->height ?>;
                <?php } else { ?>
                <?php } ?>
            }

        </style>
    </label>
    <div>
        <ul class='images'></ul>
    </div>
    <div class='actions'>
        <a class="button-secondary upload control-focus">Add</a>
        <a class="button-secondary reset control-focus">Reset</a>
    </div>
    <span class='customize-control-description'><?= $this->description ?></span>
    <input class="wp-editor-area"   type="hidden" <?php $this->link(); ?>>
    <script>
      (function ($) {
          $(window).load(function () {
              getFun('#customize-control-<?= $this->id ?>')
          });
      })(jQuery);
    </script>
    <?php
  }

}
?>