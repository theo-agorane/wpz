<?php

class AcfFieldSelectIcon extends acf_field {

    var $name = AGOACFICON_BASENAME;
    var $label = 'Icône';
    var $icons = [];
    var $symbols = '';

    /*
    *  __construct
    *
    *  @type    function
    *  @param   N/A
    *  @return  N/A
    */
    function __construct($icons, $symbols) {
        $this->name = $this->name;
        $this->label = $this->label;
        $this->category = "Agorane";
        $this->defaults = [];
        $this->icons = $icons;
        $this->symbols = $symbols;

        parent::__construct();
    }  

    /*
    *  render_field
    *
    *  @type    function
    *  @param   N/A
    *  @return  N/A
    */
    function render_field($field) {
        $value_icon = null;
        ?>
        <div class="<?php echo $this->name; ?>">
            <span class="toggle-indicator"></span>
            <div class="overlay"></div>
            <div class="dropdown">
                <?php 
                    echo '<div class="option" data-value="">';
                    echo '  <span class="svg">x</span>';
                    echo '  <span>Aucun</span>';
                    echo '</div>';

                    foreach ($this->icons as $icon) {
                        if ($field['value'] == $icon) {
                            $value_icon = $icon;
                        }

                        echo '<div class="option" data-value="'. $icon .'">';
                        echo '  <svg><use href="'. $this->symbols .'#'. $icon .'"></use></svg>';
                        echo '  <span>'. $icon .'</span>';
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="value">
                <?php 
                if ($value_icon) {
                    echo '<svg><use href="'. $this->symbols .'#'. $value_icon .'"></use></svg> ';
                    echo '<span>'. $value_icon .'</span>';
                }
                else {
                    echo '<span class="svg">x</span>';
                    echo '<span>Aucun</span>';
                }
                ?>
            </div>
        </div>
        <input type="hidden" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" >
        <?php
    }

}