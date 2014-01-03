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

require_once("class-wpfront-scroll-top-options.php");

if (!class_exists('WPFront_Scroll_Top')) {

    /**
     * Main class of WPFront Scroll Top plugin
     *
     * @author Syam Mohan <syam@wpfront.com>
     * @copyright 2013 WPFront.com
     */
    class WPFront_Scroll_Top {

        //Constants
        const VERSION = '1.0.1';
        const OPTIONSPAGE_SLUG = 'wpfront-scroll-top';
        const OPTIONS_GROUP_NAME = 'wpfront-scroll-top-options-group';
        const OPTION_NAME = 'wpfront-scroll-top-options';
        const PLUGIN_SLUG = 'wpfront-scroll-top';

        //Variables
        private $pluginURLRoot;
        private $pluginDIRRoot;
        private $iconsDIR;
        private $iconsURL;
        private $options;
        private $markupLoaded;
        private $scriptLoaded;

        function __construct() {
            $this->markupLoaded = FALSE;

            //Root variables
            $this->pluginURLRoot = plugins_url() . '/wpfront-scroll-top/';
            $this->pluginDIRRoot = dirname(__FILE__) . '/../';
            $this->iconsDIR = $this->pluginDIRRoot . 'images/icons/';
            $this->iconsURL = $this->pluginURLRoot . 'images/icons/';

            add_action('init', array(&$this, 'init'));

            //register actions
            if (is_admin()) {
                add_action('admin_init', array(&$this, 'admin_init'));
                add_action('admin_menu', array(&$this, 'admin_menu'));
                add_filter('plugin_action_links', array(&$this, 'action_links'), 10, 2);
            } else {
                add_action('wp_enqueue_scripts', array(&$this, 'enqueue_styles'));
                add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
            }

            add_action('wp_footer', array(&$this, 'write_markup'));
            add_action('shutdown', array(&$this, 'write_markup'));
            add_action('plugins_loaded', array(&$this, 'plugins_loaded'));
        }

        public function init() {
            
        }

        //add scripts
        public function enqueue_scripts() {
            if ($this->enabled() == FALSE)
                return;

            $jsRoot = $this->pluginURLRoot . 'js/';

            wp_enqueue_script('jquery');
            wp_enqueue_script('wpfront-scroll-top', $jsRoot . 'wpfront-scroll-top.js', array('jquery'), self::VERSION);

            $this->scriptLoaded = TRUE;
        }

        //add styles
        public function enqueue_styles() {
            if ($this->enabled() == FALSE)
                return;

            $cssRoot = $this->pluginURLRoot . 'css/';

            wp_enqueue_style('wpfront-scroll-top', $cssRoot . 'wpfront-scroll-top.css', array(), self::VERSION);
        }

        public function admin_init() {
            register_setting(self::OPTIONS_GROUP_NAME, self::OPTION_NAME);
            
            $this->enqueue_styles();
            $this->enqueue_scripts();
        }

        public function admin_menu() {
            $page_hook_suffix = add_options_page($this->__('WPFront Scroll Top'), $this->__('Scroll Top'), 'manage_options', self::OPTIONSPAGE_SLUG, array($this, 'options_page'));

            //register for options page scripts and styles
            add_action('admin_print_scripts-' . $page_hook_suffix, array($this, 'enqueue_options_scripts'));
            add_action('admin_print_styles-' . $page_hook_suffix, array($this, 'enqueue_options_styles'));
        }

        //options page scripts
        public function enqueue_options_scripts() {
            //$this->enqueue_scripts();
//            $jsRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/js/';
//            wp_enqueue_script('jquery.eyecon.colorpicker', $jsRoot . 'colorpicker.js', array('jquery'), self::VERSION);
//            $jsRoot = $this->pluginURLRoot . 'js/';
//            wp_enqueue_script('wpfront-notification-bar-options', $jsRoot . 'options.js', array(), self::VERSION);
        }

        //options page styles
        public function enqueue_options_styles() {
            //$this->enqueue_styles();
//            $styleRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/css/';
//            wp_enqueue_style('jquery.eyecon.colorpicker.colorpicker', $styleRoot . 'colorpicker.css', array(), self::VERSION);

            $styleRoot = $this->pluginURLRoot . 'css/';
            wp_enqueue_style('wpfront-scroll-top-options', $styleRoot . 'options.css', array(), self::VERSION);
        }

        //creates options page
        public function options_page() {
            if (!current_user_can('manage_options')) {
                wp_die($this->__('You do not have sufficient permissions to access this page.'));
                return;
            }

            include($this->pluginDIRRoot . 'templates/options-template.php');
        }

        //add "settings" link
        public function action_links($links, $file) {
            if ($file == 'wpfront-scroll-top/wpfront-scroll-top.php') {
                $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=' . self::OPTIONSPAGE_SLUG . '">' . $this->__('Settings') . '</a>';
                array_unshift($links, $settings_link);
            }
            return $links;
        }

        public function plugins_loaded() {
            //load plugin options
            $this->options = new WPFront_Scroll_Top_Options(self::OPTION_NAME, self::PLUGIN_SLUG);

            //for localization
            load_plugin_textdomain(self::PLUGIN_SLUG, FALSE, $this->pluginDIRRoot . 'languages/');
        }

        //writes the html and script for the bar
        public function write_markup() {
            if ($this->markupLoaded) {
                return;
            }

            if ($this->scriptLoaded != TRUE) {
                return;
            }

            if ($this->enabled()) {
                include($this->pluginDIRRoot . 'templates/scroll-top-template.php');

                echo '<script type="text/javascript">';
                echo 'if(typeof wpfront_scroll_top == "function") ';
                echo 'wpfront_scroll_top(' . json_encode(array(
                    'scroll_offset' => $this->options->scroll_offset(),
                    'button_width' => $this->options->button_width(),
                    'button_height' => $this->options->button_height(),
                    'button_opacity' => $this->options->button_opacity() / 100,
                    'button_fade_duration' => $this->options->button_fade_duration(),
                    'scroll_duration' => $this->options->scroll_duration(),
                    'location' => $this->options->location(),
                    'marginX' => $this->options->marginX(),
                    'marginY' => $this->options->marginY(),
                )) . ');';
                echo '</script>';
            }

            $this->markupLoaded = TRUE;
        }

        //returns localized string
        public function __($key) {
            return __($key, self::PLUGIN_SLUG);
        }

        //for compatibility
        private function submit_button() {
            if (function_exists('submit_button')) {
                submit_button();
            } else {
                echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="' . $this->__('Save Changes') . '" /></p>';
            }
        }

        private function enabled() {
            return $this->options->enabled();
        }

        private function image() {
            if($this->options->image() == 'custom')
                return $this->options->custom_url();
            return $this->iconsURL . $this->options->image();
        }
    }

}