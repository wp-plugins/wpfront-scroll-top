<?php
/*
  WPFront Scroll Top Plugin
  Copyright (C) 2013, WPFront.com
  Website: wpfront.com
  Contact: syam@wpfront.com

  WPFront Scroll Top Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Template for WPFront Scroll Top Options
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
?>

<div class="wrap">
    <?php screen_icon(WPFront_Scroll_Top::OPTIONSPAGE_SLUG); ?>
    <h2><?php echo $this->__('WPFront Scroll Top Settings'); ?></h2>

    <div id="wpfront-scroll-top-options" class="inside">
        <form method="post" action="options.php"> 
            <?php @settings_fields(WPFront_Scroll_Top::OPTIONS_GROUP_NAME); ?>
            <?php @do_settings_sections(WPFront_Scroll_Top::OPTIONSPAGE_SLUG); ?>

            <?php if ((isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') || (isset($_GET['updated']) && $_GET['updated'] == 'true')) { ?>
                <div class="updated">
                    <p>
                        <strong><?php echo $this->__('If you have a caching plugin, clear the cache for the new settings to take effect.'); ?></strong>
                    </p>
                </div>
            <?php } ?>

            <h3><?php echo $this->__('Display'); ?></h3>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <?php echo $this->options->enabled_label(); ?>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $this->options->enabled_name(); ?>" <?php echo $this->options->enabled() ? 'checked' : ''; ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->scroll_offset_label(); ?>
                    </th>
                    <td>
                        <input class="pixels" name="<?php echo $this->options->scroll_offset_name(); ?>" value="<?php echo $this->options->scroll_offset(); ?>" />px 
                        <span class="description"><?php echo $this->__('[Number of pixels to be scrolled before the button appears.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->__('Button Size'); ?>
                    </th>
                    <td>
                        <input class="pixels" name="<?php echo $this->options->button_width_name(); ?>" value="<?php echo $this->options->button_width(); ?>" />px 
                        X
                        <input class="pixels" name="<?php echo $this->options->button_height_name(); ?>" value="<?php echo $this->options->button_height(); ?>" />px 
                        <span class="description"><?php echo $this->__('[Set 0px to auto fit.]'); ?></span>

                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->button_opacity_label(); ?>
                    </th>
                    <td>
                        <input class="seconds" name="<?php echo $this->options->button_opacity_name(); ?>" value="<?php echo $this->options->button_opacity(); ?>" />%
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->button_fade_duration_label(); ?>
                    </th>
                    <td>
                        <input class="seconds" name="<?php echo $this->options->button_fade_duration_name(); ?>" value="<?php echo $this->options->button_fade_duration(); ?>" />ms 
                        <span class="description"><?php echo $this->__('[Button fade duration in milliseconds.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->scroll_duration_label(); ?>
                    </th>
                    <td>
                        <input class="seconds" name="<?php echo $this->options->scroll_duration_name(); ?>" value="<?php echo $this->options->scroll_duration(); ?>" />ms 
                        <span class="description"><?php echo $this->__('[Window scroll duration in milliseconds.]'); ?></span>
                    </td>
                </tr>
            </table>
            <h3><?php echo $this->__('Location'); ?></h3>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <?php echo $this->options->location_label(); ?>
                    </th>
                    <td>
                        <select name="<?php echo $this->options->location_name(); ?>">
                            <option value="1" <?php echo $this->options->location() == 1 ? 'selected' : ''; ?> ><?php echo $this->__('Bottom Right'); ?></option>
                            <option value="2" <?php echo $this->options->location() == 2 ? 'selected' : ''; ?> ><?php echo $this->__('Bottom Left'); ?></option>
                            <option value="3" <?php echo $this->options->location() == 3 ? 'selected' : ''; ?> ><?php echo $this->__('Top Right'); ?></option>
                            <option value="4" <?php echo $this->options->location() == 4 ? 'selected' : ''; ?> ><?php echo $this->__('Top Left'); ?></option>
                        </select> 
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->marginX_label(); ?>
                    </th>
                    <td>
                        <input class="pixels" name="<?php echo $this->options->marginX_name(); ?>" value="<?php echo $this->options->marginX(); ?>" />px 
                        <span class="description"><?php echo $this->__('[Negative value allowed.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->marginY_label(); ?>
                    </th>
                    <td>
                        <input class="pixels" name="<?php echo $this->options->marginY_name(); ?>" value="<?php echo $this->options->marginY(); ?>" />px 
                        <span class="description"><?php echo $this->__('[Negative value allowed.]'); ?></span>
                    </td>
                </tr>
            </table>
            <h3><?php echo $this->__('Image'); ?></h3>
            <div class="icons-container">
                <?php
                $files = scandir($this->iconsDIR);
                foreach ($files as $file) {
                    if ($file == '.' || $file == '..')
                        continue;
                    echo '<div ' . ($this->options->image() == $file ? 'class="selected"' : '') . '>';
                    echo '<input id="' . $file . '" name="' . $this->options->image_name() . '" type="radio" value="' . $file . '" ' . ($this->options->image() == $file ? 'checked' : '') . ' />';
                    echo '<label for="' . $file . '"><img src="' . $this->iconsURL . $file . '"/></label>';
                    echo '</div>';
                }
                ?>
            </div>
            <div>
                <input id="custom" name="<?php echo $this->options->image_name(); ?>" type="radio" value="custom" <?php echo ($this->options->image() == 'custom' ? 'checked' : ''); ?> />
                <label for="custom"><?php echo $this->__('Custom URL'); ?>
                    <input class="customImage" name="<?php echo $this->options->custom_url_name(); ?>" value="<?php echo $this->options->custom_url(); ?>"/>
                </label>
            </div>

            <?php @$this->submit_button(); ?>

            <a href="http://wpfront.com/scroll-top-plugin-settings/" target="_blank"><?php echo $this->__('Settings Description'); ?></a>
            |
            <a href="http://wpfront.com/scroll-top-plugin-faq/" target="_blank"><?php echo $this->__('Plugin FAQ'); ?></a>
            |
            <a href="http://wpfront.com/contact/" target="_blank"><?php echo $this->__('Feature Request'); ?></a>
            |
            <a href="http://wpfront.com/contact/" target="_blank"><?php echo $this->__('Report Bug'); ?></a>
            |
            <a href="http://wordpress.org/support/view/plugin-reviews/wpfront-scroll-top" target="_blank"><?php echo $this->__('Write Review'); ?></a>
            |
            <a href="mailto:syam@wpfront.com"><?php echo $this->__('Contact Me (syam@wpfront.com)'); ?></a>

        </form>
    </div>
</script>