<?php
namespace WISECAMPAIGN\Classes;

use WP_Customize_Control;

/**
 * Custom control class for toggle select.
 *
 * @since  1.0.0
 */
class Alignment_Control extends WP_Customize_Control {
    /**
     * The type of control being rendered
     */
    public $type = 'text_radio_button';
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue() {
        wp_register_style( 'wisecampaign-alignment-controls-css', trailingslashit(WISECAMPAIGN_DIR_PATH) . '/includes/css/alignment_control.css', array(), 1, 'all' );
        wp_enqueue_script('wisecampaign-alignment-controls-css');
    }
    /**
     * Render the control in the customizer
     */
    public function render_content() {
    ?>
        <div class="text_radio_button_control">
            <?php if( !empty( $this->label ) ) { ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php } ?>
            <?php if( !empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php } ?>

            <div class="radio-buttons">
                <?php foreach ( $this->choices as $key => $value ) { ?>
                    <label class="radio-button-label">
                        <input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                        <span><?php echo esc_html( $value ); ?></span>
                    </label>
                <?php	} ?>
            </div>
        </div>
    <?php
    }
}
?>