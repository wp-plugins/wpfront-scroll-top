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

require_once("class-wpfront-options-base.php");

if (!class_exists('WPFront_Scroll_Top_Options')) {

    /**
     * Options class for WPFront Scroll Top plugin
     *
     * @author Syam Mohan <syam@wpfront.com>
     * @copyright 2013 WPFront.com
     */
    class WPFront_Scroll_Top_Options extends WPFront_Options_Base {

        function __construct($optionName, $pluginSlug) {
            parent::__construct($optionName, $pluginSlug);

            //add the options required for this plugin
            $this->addOption('enabled', 'bit', FALSE)->__('Enabled');
            $this->addOption('scroll_offset', 'int', 100, array($this, 'validate_zero_positive'))->__('Scroll Offset');
            $this->addOption('button_width', 'int', 0, array($this, 'validate_zero_positive'));
            $this->addOption('button_height', 'int', 0, array($this, 'validate_zero_positive'));
            $this->addOption('button_opacity', 'int', 80, array($this, 'validate_range_0_100'))->__('Button Opacity');
            $this->addOption('button_fade_duration', 'int', 200, array($this, 'validate_zero_positive'))->__('Button Fade Duration');
            $this->addOption('scroll_duration', 'int', 400, array($this, 'validate_zero_positive'))->__('Scroll Duration');
            $this->addOption('hide_small_device', 'bit', FALSE)->__('Hide on Small Devices');
            $this->addOption('small_device_width', 'int', 640, array($this, 'validate_zero_positive'))->__('Small Device Max Width');
            $this->addOption('hide_small_window', 'bit', FALSE)->__('Hide on Small Window');
            $this->addOption('small_window_width', 'int', 640, array($this, 'validate_zero_positive'))->__('Small Window Max Width');
            
            $this->addOption('location', 'int', 1, array($this, 'validate_range_1_4'))->__('Location');
            $this->addOption('marginX', 'int', 20)->__('Margin X');
            $this->addOption('marginY', 'int', 20)->__('Margin Y');
            
            $this->addOption('image', 'string', '1.png');
            $this->addOption('custom_url', 'string', '');
        }

        protected function validate_zero_positive($arg) {
            if($arg < 0)
                return 0;
            
            return $arg;
        }
        
        protected function validate_range_0_100($arg) {
            if($arg < 0)
                return 0;
            
            if($arg > 100)
                return 100;
            
            return $arg;
        }
        
        protected function validate_range_1_4($arg) {
            if($arg < 1)
                return 1;
            
            if($arg > 4)
                return 4;
            
            return $arg;
        }
    }

}