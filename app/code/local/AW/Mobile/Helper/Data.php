<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Mobile
 * @version    1.6.7
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


/**
 * aheadWorks Mobile Data Helper
 */
class AW_Mobile_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ALWAYS_MOBILE = 'awmobile/behaviour/always_switch_to_mobile_view';

    const XML_PATH_GA_ACCOUNT = 'awmobile/ganalytics/gacode';

    const XML_PATH_ENABLED = 'awmobile/settings/enabled';
    /**
     * iPhone Response
     */
    const IPHONE_RESPONSE = 'iPhone';

    /**
     * Android Response
     */
    const ANDROID_RESPONSE = 'Android';

    /**
     * BlackBerry Response
     */
    const BLACKBERRY_RESPONSE = 'BlackBerry';

    /**
     * iPhone Response
     */
    const WMOBILE_RESPONSE = 'IEMobile';

    /**
     * iPad Response
     */
    const IPAD_RESPONSE = 'iPad';

    /**
     * Frame Navigation Template path
     */
    const FRAME_NAVIGATION_TEMPLATE = 'catalog/navigation/top.phtml';

    /**
     * Path to Custom Design Config Path
     */
    const XML_PATH_MOBILE_CUSTOM_THEME = 'awmobile/design/custom_design';

    /**
     * Path to Custom Design Config Path
     */
    const XML_PATH_MOBILE_FOOTER_LINKS_BLOCK = 'awmobile/design/footer_links_block';

    /**
     * Path to Copyright Config Path
     */
    const XML_PATH_MOBILE_COPYRIGHT = 'awmobile/design/copyright';

    /**
     * Default package
     */
    const DEFAULT_PACKAGE = 'aw_mobile';

    /**
     * Default theme
     */
    const DEFAULT_THEME = 'iphone';

    /**
     * Target platform
     * @var string
     */
    protected $_target = null;

    /**
     * Is checkout messages prepared
     * @var bool
     */
    protected $_checkoutMessagesPrepared = false;

    /* List of tablet devices
    * @var array
    */
    protected $_tabletDevices = array(
        'BlackBerryTablet'  => 'PlayBook|RIM Tablet',
        'iPad'              => 'iPad|iPad.*Mobile',
        'NexusTablet'       => '^.*Android.*Nexus(?:(?!Mobile).)*$',
        // @reference: http://www.labnol.org/software/kindle-user-agent-string/20378/
        'Kindle'            => 'Kindle|Silk.*Accelerated',
        'SamsungTablet'     => 'SAMSUNG.*Tablet|Galaxy.*Tab|GT-P1000|GT-P1010|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I800|SCH-I815|SCH-I905|SGH-I957|SGH-I987|SGH-T849|SGH-T859|SGH-T869|SPH-P100|GT-P1000|GT-P3100|GT-P3110|GT-P5100|GT-P5110|GT-P6200|GT-P7300|GT-P7320|GT-P7500|GT-P7510|GT-P7511|GT-N8000',
        'HTCtablet'         => 'HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200',
        'MotorolaTablet'    => 'xoom|sholest|MZ615|MZ605|MZ505|MZ601|MZ602|MZ603|MZ604|MZ606|MZ607|MZ608|MZ609|MZ615|MZ616|MZ617',
        'AsusTablet'        => 'Transformer|TF101',
        'NookTablet'        => 'Android.*Nook|NookColor|nook browser|BNTV250A|LogicPD Zoom2',
        'AcerTablet'        => 'Android.*\b(A100|A101|A200|A500|A501|A510|W500|W500P|W501|W501P)\b',
        'YarvikTablet'      => 'Android.*(TAB210|TAB211|TAB224|TAB250|TAB260|TAB264|TAB310|TAB360|TAB364|TAB410|TAB411|TAB420|TAB424|TAB450|TAB460|TAB461|TAB464|TAB465|TAB467|TAB468)',
        'MedionTablet'      => 'Android.*\bOYO\b|LIFE.*(P9212|P9514|P9516|S9512)|LIFETAB',
        'ArnovaTablet'      => 'AN10G2|AN7bG3|AN7fG3|AN8G3|AN8cG3|AN7G3|AN9G3|AN7dG3|AN7dG3ST|AN7dG3ChildPad|AN10bG3|AN10bG3DT',
        // @reference: http://wiki.archosfans.com/index.php?title=Main_Page
        'ArchosTablet'      => 'Android.*ARCHOS|101G9|80G9',
        // @reference: http://en.wikipedia.org/wiki/NOVO7
        'AinolTablet'       => 'NOVO7|Novo7Aurora|Novo7Basic|NOVO7PALADIN',
        'SonyTablet'        => 'Sony Tablet|Sony Tablet S',
        // @ref: db + http://www.cube-tablet.com/buy-products.html
        'CubeTablet'        => 'Android.*(K8GT|U9GT|U10GT|U16GT|U17GT|U18GT|U19GT|U20GT|U23GT|U30GT)',
        // @ref: http://www.cobyusa.com/?p=pcat&pcat_id=3001
        'CobyTablet'        => 'MID1042|MID1045|MID1125|MID1126|MID7012|MID7014|MID7034|MID7035|MID7036|MID7042|MID7048|MID7127|MID8042|MID8048|MID8127|MID9042|MID9740|MID9742|MID7022|MID7010',
        'GenericTablet'     => 'Android.*\b97D\b|Tablet(?!.*PC)|ViewPad7|LG-V909|MID7015|BNTV250A|LogicPD Zoom2|\bA7EB\b|CatNova8|A1_07|CT704|CT1002|\bM721\b|hp-tablet',
    );

    /**
     * Retrives is iPhone Flag
     * @return boolean
     */
    public function iPhone()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return (strpos($_SERVER['HTTP_USER_AGENT'], self::IPHONE_RESPONSE) !== false);
        }
        return false;
    }

    /**
     * Retrives is Android Flag
     * @return boolean
     */
    public function Android()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return (strpos($_SERVER['HTTP_USER_AGENT'], self::ANDROID_RESPONSE) !== false);
        }
        return false;
    }


    /**
     * Retrives is Windows Mobile IE Flag
     * @return boolean
     */
    public function winMobile()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return (strpos($_SERVER['HTTP_USER_AGENT'], self::WMOBILE_RESPONSE) !== false);
        }
        return false;
    }

    /**
     * Find version in the http_user_agent
     *
     * @param string $pattern
     * @param string $text
     * @return string
     */
    protected function _findVersion($pattern, $text)
    {
        $regExp = "/({$pattern} (?:(\d+)\.)?(?:(\d+)\.)?(\*|\d+))/";
        $toDelete = "{$pattern} ";

        $matches = array();
        preg_match($regExp, $text, $matches);
        if (count($matches)) {
            return str_replace($toDelete, "", $matches[0]);
        }
        return '';
    }

    public function getAndroidVersion()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return $this->_findVersion(strtolower(self::ANDROID_RESPONSE), strtolower($_SERVER['HTTP_USER_AGENT']));
        }
        return '';
    }

    /**
     * Retrives is BlackBerry Flag
     * @return boolean
     */
    public function BlackBerry()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return (strpos($_SERVER['HTTP_USER_AGENT'], self::BLACKBERRY_RESPONSE) !== false);
        }
        return false;
    }

    /**
     * Retreive true if Tablet device has been detected
     * @return bool
     */

    public function is_Tablet()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            foreach ($this->_tabletDevices as $_regex) {
                if (preg_match('/'.$_regex.'/is', $_SERVER['HTTP_USER_AGENT'])) {
                   return true;
                }
            }
        }
        return false;
    }
    /**
     * Retrives customer session
     * @return Mage_Customer_Model_Session
     */
    protected function _customerSession()
    {
        return Mage::getSingleton('customer/session');
    }

    /**
     * Retrives Show Desktop flag value
     * @return boolean
     */
    public function getShowDesktop()
    {
        return $this->_customerSession()->getShowDesktop();
    }

    /**
     * Set up State Changed mutex
     * @return AW_Mobile_Helper_Data
     */
    public function setStateChanged()
    {
        $this->_customerSession()->setStateChanged(true);
    }

    /**
     * Retrivces State Changed mutex
     * @return boolean
     */
    public function isStateChanged()
    {
        $state = $this->_customerSession()->getStateChanged();
        $this->_customerSession()->setStateChanged(false);
        return $state;
    }

    /**
     * Retrives Page Cache enabled flag
     * @return boolean
     */
    public function isPageCache()
    {
        return Mage::app()->useCache('full_page');
    }

    /**
     * Set up Forced flag
     * @return AW_Mobile_Helper_Data
     */
    public function setForced()
    {
        $this->_customerSession()->setForced(true);
        return $this;
    }

    /**
     * Retrivces Forced flag
     * @return boolean
     */
    public function isForced()
    {
        return $this->_customerSession()->getForced();
    }

    /**
     * Set From Store flag
     * @return boolean
     */
    public function setFromStore()
    {
        $this->_customerSession()->setData('aw_mobile_switch_from_store', Mage::app()->getStore()->getCode());
        return $this;
    }

    /**
     * Retrieves From Store flag
     * @return boolean
     */
    public function getFromStore()
    {
        return $this->_customerSession()->getData('aw_mobile_switch_from_store');
    }

    /**
     * Set up Show Desktop flag
     * @param boolean $value
     */
    public function setShowDesktop($value)
    {
        $this->setStateChanged();
        $this->setForced();
        $this->_customerSession()->setShowDesktop($value);
    }

    /**
     * Retrive config value of Mobile Detect option
     * @return boolen
     */
    public function confMobileDetect()
    {
        return !!Mage::getStoreConfig('awmobile/behaviour/mobile_detect');
    }

    /**
     * Retrive config value of Android Tablet & iPad Detect option
     * @return boolen
     */
    public function confTabletDetect()
    {
        return !!Mage::getStoreConfig('awmobile/behaviour/tablet_detect');
    }

    /**
     * Compare param $version with magento version
     * @param string $version
     * @param $platform = null
     * @return boolean
     */
    public function checkVersion($version, $platform = null)
    {
        if (is_string($platform)) {
            $currentPlatformCode = Mage::helper('awall/versions')->getPlatform();
            $needPlatformCode = $currentPlatformCode;
            switch($platform) {
                case 'ee':
                    $needPlatformCode = AW_All_Helper_Versions::EE_PLATFORM;
                    break;
                case 'pe':
                    $needPlatformCode = AW_All_Helper_Versions::PE_PLATFORM;
                    break;
                case 'ce':
                    $needPlatformCode = AW_All_Helper_Versions::CE_PLATFORM;
                    break;
            }
            if ($needPlatformCode != $currentPlatformCode) {
                return false;
            }
        }
        return version_compare(Mage::getVersion(), $version, '>=');
    }

    /**
     * Retrive is Magento Enterprise Edition Flag
     * @return boolean
     */
    public function isEE()
    {
        return AW_All_Helper_Versions::getPlatform() == AW_All_Helper_Versions::EE_PLATFORM;
    }

    /**
     * Retrives flag that old POST format required for chechout street address
     * @return boolean
     */
    public function isOldStreetFormat()
    {
        if (!$this->isEE()) {
            return !$this->checkVersion('1.4.2.0');
        } else {
            return !$this->checkVersion('1.9.0.0');
        }
    }


    /**
     * Escape html entities
     *
     * @param   mixed $data
     * @param   array $allowedTags
     * @return  mixed
     */
    public function escapeHtml($data, $allowedTags = null)
    {
        if (is_array($data)) {
            $result = array();
            foreach ($data as $item) {
                $result[] = $this->escapeHtml($item);
            }
        } else {
            // process single item
            if (strlen($data)) {
                if (is_array($allowedTags) and !empty($allowedTags)) {
                    $allowed = implode('|', $allowedTags);
                    $result = preg_replace('/<([\/\s\r\n]*)(' . $allowed . ')([\/\s\r\n]*)>/si', '##$1$2$3##', $data);
                    $result = htmlspecialchars($result);
                    $result = preg_replace('/##([\/\s\r\n]*)(' . $allowed . ')([\/\s\r\n]*)##/si', '<$1$2$3>', $result);
                } else {
                    $result = htmlspecialchars($data);
                }
            } else {
                $result = $data;
            }
        }
        return $result;
    }

    /**
     * Wrapper for standart strip_tags() function with extra functionality for html entities
     *
     * @param string $data
     * @param string $allowableTags
     * @param bool $escape
     * @return string
     */
    public function stripTags($data, $allowableTags = null, $escape = false)
    {
        if (method_exists(Mage::helper('core'), 'stripTags')) {
            return parent::stripTags($data, $allowableTags = null, $escape = false);
        }
        $result = strip_tags($data, $allowableTags);
        return $escape ? $this->escapeHtml($result, $allowableTags) : $result;
    }

    public function categorizr()
    {
        $catergorizeTabletsAsDesktops = TRUE;  //If TRUE, tablets will be categorized as desktops
        $catergorizeTvsAsDesktops     = TRUE;  //If TRUE, smartTVs will be categorized as desktops

        if (!array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return "desktop";
        }
        $ua = $_SERVER['HTTP_USER_AGENT'];
        // Check if session has already started, otherwise E_NOTICE is thrown

        // Check if user agent is a smart TV - http://goo.gl/FocDk
        if ((preg_match('/GoogleTV|SmartTV|Internet.TV|NetCast|NETTV|AppleTV|boxee|Kylo|Roku|DLNADOC|CE\-HTML/i', $ua))) {
            $device = "tv";
        } else if ((preg_match('/Xbox|PLAYSTATION.3|Wii/i', $ua))) {
            // Check if user agent is a TV Based Gaming Console
            $device = "tv";
        } else if ((preg_match('/iP(a|ro)d/i', $ua)) || (preg_match('/tablet/i', $ua)) && (!preg_match('/RX-34/i', $ua)) || (preg_match('/FOLIO/i', $ua))) {
            // Check if user agent is a Tablet
            $device = "tablet";
        } else if ((preg_match('/Linux/i', $ua)) && (preg_match('/Android/i', $ua)) && (!preg_match('/Fennec|mobi|HTC.Magic|HTCX06HT|Nexus.One|SC-02B|fone.945/i', $ua))) {
            // Check if user agent is an Android Tablet
            $device = "tablet";
        } else if ((preg_match('/Kindle/i', $ua)) || (preg_match('/Mac.OS/i', $ua)) && (preg_match('/Silk/i', $ua))) {
            // Check if user agent is a Kindle or Kindle Fire
            $device = "tablet";
        } else if ((preg_match('/GT-P10|SC-01C|SHW-M180S|SGH-T849|SCH-I800|SHW-M180L|SPH-P100|SGH-I987|zt180|HTC(.Flyer|\_Flyer)|Sprint.ATP51|ViewPad7|pandigital(sprnova|nova)|Ideos.S7|Dell.Streak.7|Advent.Vega|A101IT|A70BHT|MID7015|Next2|nook/i', $ua)) || (preg_match('/MB511/i', $ua)) && (preg_match('/RUTEM/i', $ua))) {
            // Check if user agent is a pre Android 3.0 Tablet
            $device = "tablet";
        } else if ((preg_match('/BOLT|Fennec|Iris|Maemo|Minimo|Mobi|mowser|NetFront|Novarra|Prism|RX-34|Skyfire|Tear|XV6875|XV6975|Google.Wireless.Transcoder/i', $ua))) {
            // Check if user agent is unique Mobile User Agent
            $device = "mobile";
        } else if ((preg_match('/Opera/i', $ua)) && (preg_match('/Windows.NT.5/i', $ua)) && (preg_match('/HTC|Xda|Mini|Vario|SAMSUNG\-GT\-i8000|SAMSUNG\-SGH\-i9/i', $ua))) {
            // Check if user agent is an odd Opera User Agent - http://goo.gl/nK90K
            $device = "mobile";
        } else if ((preg_match('/Windows.(NT|XP|ME|9)/', $ua)) && (!preg_match('/Phone/i', $ua)) || (preg_match('/Win(9|.9|NT)/i', $ua))) {
            // Check if user agent is Windows Desktop
            $device = "desktop";
        } else if ((preg_match('/Macintosh|PowerPC/i', $ua)) && (!preg_match('/Silk/i', $ua))) {
            // Check if agent is Mac Desktop
            $device = "desktop";
        } else if ((preg_match('/Linux/i', $ua)) && (preg_match('/X11/i', $ua))) {
            // Check if user agent is a Linux Desktop
            $device = "desktop";
        } else if ((preg_match('/Solaris|SunOS|BSD/i', $ua))) {
            // Check if user agent is a Solaris, SunOS, BSD Desktop
            $device = "desktop";
        } else if ((preg_match('/Bot|Crawler|Spider|Yahoo|ia_archiver|Covario-IDS|findlinks|DataparkSearch|larbin|Mediapartners-Google|NG-Search|Snappy|Teoma|Jeeves|TinEye/i', $ua)) && (!preg_match('/Mobile/i', $ua))) {
            // Check if user agent is a Desktop BOT/Crawler/Spider
            $device = "desktop";
        } else {
            // Otherwise assume it is a Desktop
            $device = "desktop";
        }

        // Categorize Tablets as desktops
        if ($catergorizeTabletsAsDesktops && $device == "tablet") {
            $device = "desktop";
        }

        // Categorize TVs as desktops
        if ($catergorizeTvsAsDesktops && $device == "tv") {
            $device = "desktop";
        }
        return $device;
    }

    // Returns true if desktop user agent is detected
    public function isDesktop()
    {
        $device = $this->categorizr();
        if ($device == "desktop") {
            return TRUE;
        }
        return FALSE;
    }
    // Returns true if tablet user agent is detected
    public function isTablet()
    {
        $device = $this->categorizr();
        if ($device == "tablet") {
            return TRUE;
        }
        return FALSE;
    }
    // Returns true if tablet user agent is detected
    public function isTV()
    {
        $device = $this->categorizr();
        if ($device == "tv") {
            return TRUE;
        }
        return FALSE;
    }
    // Returns true if mobile user agent is detected
    public function isMobile()
    {
        $device = $this->categorizr();
        if ($device == "mobile") {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Retrives target platform
     * @return string
     */
    public function getTargetPlatform()
    {
        if ($this->getDisabledOutput()) {
            return AW_Mobile_Model_Observer::TARGET_DESKTOP;
        }
        if (!$this->_target) {
            /*Hard switch to mobile theme*/
            if (!$this->isForced()) {
                if (Mage::getStoreConfig(self::XML_PATH_ALWAYS_MOBILE, Mage::app()->getStore()->getId())) {
                    $target = AW_Mobile_Model_Observer::TARGET_MOBILE;
                    $this->_target = $target;
                    return $this->_target;
                }
            }
            /*End of Hard switch to mobile theme*/
            $target = AW_Mobile_Model_Observer::TARGET_DESKTOP;
            if ($this->isForced()) {
                $target = $this->getShowDesktop() ? AW_Mobile_Model_Observer::TARGET_DESKTOP : AW_Mobile_Model_Observer::TARGET_MOBILE;
            } elseif ($this->confMobileDetect() && (
                /* Select a platform */
                $this->isMobile()
            )
            ) {
                $target = AW_Mobile_Model_Observer::TARGET_MOBILE;
            } elseif ($this->confTabletDetect() && $this->confMobileDetect() && (
                /* Select a platform */
                $this->is_Tablet()
            )
            ) {
                $target = AW_Mobile_Model_Observer::TARGET_MOBILE;
            }
            $this->_target = $target;
        }
        return $this->_target;
    }

    /**
     * Retrives disabled output of extension flag
     * @return boolean
     */
    public function getDisabledOutput()
    {
        $store = Mage::app()->getStore()->getId();
        if (!Mage::getStoreConfig('advanced/modules_disable_output/AW_Mobile', $store)) {
            return !Mage::getStoreConfig(self::XML_PATH_ENABLED, $store);
        } else {
            return true;
        }
    }

    /**
     * Retrives additional navigation tools
     *
     * @return boolean
     */
    public function wantNavigationTools()
    {
        if ($this->Android() && version_compare($this->getAndroidVersion(), '1.6', '<=')) {
            return true;
        }
        return (!$this->iPhone() && !$this->Android());
    }

    public function isOldAndroid()
    {
        return ($this->Android() && version_compare($this->getAndroidVersion(), '1.6', '<='));
    }

    protected function _getCustomDesign($key)
    {
        $_result = null;
        if ($customTheme = Mage::getStoreConfig(self::XML_PATH_MOBILE_CUSTOM_THEME)) {
            list($package, $theme) = explode('/', $customTheme);
            $_result = $package;
            if ($key == 'theme') {
                $_result = $theme;
            }
        }
        return $_result;
    }

    /**
     * Retrives default package
     * @return string
     */
    public function getMobilePackage()
    {
        if ($this->_getCustomDesign('package')) {
            return $this->_getCustomDesign('package');
        }
        return self::DEFAULT_PACKAGE;
    }

    /**
     * Retrives default theme
     * @return string
     */
    public function getMobileTheme()
    {
        if ($this->_getCustomDesign('theme')) {
            return $this->_getCustomDesign('theme');
        }
        return self::DEFAULT_THEME;
    }

    public function getCustomFooterLinksHtml()
    {
        if ($blockId = Mage::getStoreConfig(self::XML_PATH_MOBILE_FOOTER_LINKS_BLOCK)) {
            $block = Mage::app()->getLayout()->createBlock('cms/block');
            if ($block) {
                return $block->setBlockId($blockId)->toHtml();
            }
        }
        return null;
    }

    public function getCopyright()
    {
        return Mage::getStoreConfig(self::XML_PATH_MOBILE_COPYRIGHT);
    }

    public function prepareCartMessages($messagesBlock, $multishipping = false)
    {
        $cart = Mage::getSingleton('checkout/cart');
        if ($cart->getQuote()->getItemsCount()) {
            if (!$cart->getQuote()->validateMinimumAmount($multishipping)) {
                $warning = Mage::getStoreConfig('sales/minimum_order/description');
                $collection = $messagesBlock->getMessageCollection();
                $messages = array();
                foreach ($collection->getItems() as $message) {
                    if ($message->getCode() !== $warning) {
                        $messages[] = $message;
                    }
                }
                $collection->clear();
                foreach ($messages as $message) {
                    $collection->add($message);
                }
                $collection->add(Mage::getSingleton('core/message')->notice($warning));
                $messagesBlock->setMessages($collection);
            }
        }
    }
}

