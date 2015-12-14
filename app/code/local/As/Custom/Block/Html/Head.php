<?php
class As_Custom_Block_Html_Head extends Mage_Page_Block_Html_Head
{

    public function getCssJsHtml()
    {
        // separate items by types
        $lines  = array();
        foreach ($this->_data['items'] as $item) {
            if (!is_null($item['cond']) && !$this->getData($item['cond']) || !isset($item['name'])) {
                continue;
            }
            $if     = !empty($item['if']) ? $item['if'] : '';
            $params = !empty($item['params']) ? $item['params'] : '';
            switch ($item['type']) {
                case 'js':        // js/*.js
                case 'skin_js':   // skin/*/*.js
                case 'js_css':    // js/*.css
                case 'skin_css':  // skin/*/*.css
                    $lines[$if][$item['type']][$params][$item['name']] = $item['name'];
                    break;
                default:
                    $this->_separateOtherHtmlHeadElements($lines, $if, $item['type'], $params, $item['name'], $item);
                    break;
            }
        }

        // prepare HTML
        $shouldMergeJs = Mage::getStoreConfigFlag('dev/js/merge_files');
        $shouldMergeCss = Mage::getStoreConfigFlag('dev/css/merge_css_files');
        $html   = '';
        foreach ($lines as $if => $items) {
            if (empty($items)) {
                continue;
            }
            if (!empty($if)) {
                $html .= '<!--[if '.$if.']>'."\n";
            }

            // static and skin css
            $html .= $this->_prepareStaticAndSkinElements('<link rel="stylesheet" type="text/css" href="%s"%s />' . "\n",
                empty($items['js_css']) ? array() : $items['js_css'],
                empty($items['skin_css']) ? array() : $items['skin_css'],
                $shouldMergeCss ? array(Mage::getDesign(), 'getMergedCssUrl') : null
            );

            // static and skin javascripts
            $html .= $this->_prepareStaticAndSkinElements('<script type="text/javascript"  src="%s"%s></script>' . "\n",
                empty($items['js']) ? array() : $items['js'],
                empty($items['skin_js']) ? array() : $items['skin_js'],
                $shouldMergeJs ? array(Mage::getDesign(), 'getMergedJsUrl') : null
            );

            // other stuff
            if (!empty($items['other'])) {
                $html .= $this->_prepareOtherHtmlHeadElements($items['other']) . "\n";
            }

            if (!empty($if)) {
                $html .= '<![endif]-->'."\n";
            }
        }
        return $html;
    }

   protected function &_prepareStaticAndSkinElements($format, array $staticItems, array $skinItems, $mergeCallback = null)
    {
        $designPackage = Mage::getDesign();
        $baseJsUrl = Mage::getBaseUrl('js');
        $items = array();
        if ($mergeCallback && !is_callable($mergeCallback)) {
            $mergeCallback = null;
        }

        // get static files from the js folder, no need in lookups
        foreach ($staticItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $name : $baseJsUrl . $name;
            }
        }

        // lookup each file basing on current theme configuration
        foreach ($skinItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? $designPackage->getFilename($name, array('_type' => 'skin'))
                    : $designPackage->getSkinUrl($name, array());
            }
        }

        $html = '';
        foreach ($items as $params => $rows) {
            // attempt to merge
            $mergedUrl = false;
            if ($mergeCallback) {
                $mergedUrl = call_user_func($mergeCallback, $rows);
            }
            // render elements
            $params = trim($params);
            $params = $params ? ' ' . $params : '';
            if ($mergedUrl) {
            	/*if(strpos($mergedUrl,'.js')!==false){
                $format= '
                <script type="text/javascript" >
			function loadScript1 (){

			    var callback = function(){if(typeof(getA) == "function" && (typeof(getacalled) == "undefined" || !getacalled)) getA();};
			    var url = "%s";
			    var script = document.createElement("script");
			    script.type = "text/javascript";

			    if (script.readyState){  //IE
				script.onreadystatechange = function(){
				    if (script.readyState == "loaded" ||
					    script.readyState == "complete"){
					script.onreadystatechange = null;
					callback();
				    }
				};
			    } else {  //Others
				script.onload = function(){
				    callback();
				};
			    }

			    script.src = url;
			    parentGuest = document.getElementsByTagName("body")[0];
			    if (parentGuest.nextSibling) {
			       parentGuest.parentNode.insertBefore(script, parentGuest.nextSibling);
			    }
			    else {
			       parentGuest.parentNode.appendChild(script);
			    }
			}
			 if (window.addEventListener)
			 window.addEventListener("load", loadScript1, false);
			 else if (window.attachEvent)
			 window.attachEvent("onload", loadScript1);
			 else window.onload = loadScript1;
			 loadScript1 ();
			</script>
	       ';
                
                }*/
                
                $html .=sprintf($format, $mergedUrl, $params);
            } else {
                foreach ($rows as $src) {
                    $html .= sprintf($format, $src, $params);
                }
            }
        }
        return $html;
    }


	private function getExtraScripts()
	{
		$scripts="function initAutocomplete(){
			new Autocomplete('search', {
			serviceUrl   : 'http://cowgirlkim.easysitedemo.info/index.php/ajaxsearch/',
			enableloader : true,
			minChars     : 1,
			maxHeight    : 500,
			width        : 300,
			searchtext   : 'Search Products',
			onSelect     : function (value, data) {setLocation(value.url);}
			});
			}
			if (Prototype.Browser.IE) {
			Event.observe(window, 'load', initAutocomplete);
			} else {
			document.observe(\"dom:loaded\", initAutocomplete);
			}\n
			Query('.bxslider').bxSlider({})\n;
			";
		return $scripts;
	}
}
