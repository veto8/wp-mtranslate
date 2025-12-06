<?php

namespace WPMTR\Dt\Class;
use WP_HTML_Tag_Processor;

//use $_SERVER['DOCUMENT_ROOT']. "/wp-includes/html-api/class-wp-html-tag-processor.php";
//require_once $_SERVER['DOCUMENT_ROOT']. "/wp-includes/html-api/class-wp-html-tag-processor.php";
//$html = "<p>xxxxx<em>hello</em></p>";
//$tags = new WP_HTML_Tag_Processor( $html );

/**
 * Class Frontend.
 *
 * Handle all Request to to browser Frontend
 *
 * @since 1.0.0
 */
class WPMTR_Frontend
{
    private $option_name = "wpmtr_settings";
    private $domain;
    private $base_domain;
    private $options;
    private $source_lang_code;
    private $target_lang_code;
    private $lang_codes;
    private $domains;

    /**
     * Class Constructor.
     *
     * If Source and Target is set, init the plugins
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        if ($this->is_active()) {
            $this->set_domain();
            $this->set_lang_codes($this->domain, $this->options);
            if ($this->source_lang_code && $this->target_lang_code) {
                //error_log(date("H:i:s"));
                //add_filter('locale', [$this, 'swap_locale'], 10a, 4);
                //add_filter('gettext', [$this, 'swap_gettext'], 10, 3);
                //add_filter('the_content', [$this, 'swap_the_content'], 10, 3);
                add_filter('wp_setup_nav_menu_item', [$this, 'swap_wp_setup_nav_menu_item']);

            }
        }
    }





    public function swap_the_content( $content ) {
        $html = json_encode($content);
        $tags = new WP_HTML_Tag_Processor( $html );        



while ( $tags->next_tag() ) {
while ( $tags->next_token() ) {
if ( '#text' === $tags->get_token_type() ) {
   $source_text = $tags->get_modifiable_text();    
   //$tags->set_modifiable_text("ffffff");                
   error_log($source_text);                
} 
}
}

$content = $tags->get_updated_html();
//error_log(json_encode($html2));

        //error_log($html);
        //$dom = new DOMDocument();
        //$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
         return $content;
    }

    
    public function swap_gettext($translation, $text, $domain){
        global $wpdb;        

        //        if ($translation == "Search") {
            $hash = bin2hex(sodium_crypto_generichash( $translation,"",16));
            $scode = $this->source_lang_code;
            $code = $this->target_lang_code;            
            $tb = $wpdb->prefix . 'wpmtr_translate';
            $sql = "SELECT target_text FROM " . $tb. " WHERE hash = '". $hash . "' AND code = '". $code . "' LIMIT 1";

            $r = $wpdb->get_results($sql);
            if($r) {

                if($r[0]->target_text != "") {
                  $translation = $r[0]->target_text ;
                }
                else {
                    $translation = "xxxxxxxxxxxxxxx";
                }
                //error_log("xxxxxxxxxxxxxxxxxxxxxx");                                
                //error_log("...exist " . $translation);
                 //error_log("xxxxxxxxxxxxxxxxxxxxxx");                                
            }
            
            else {
                //$translation =  str_replace('%s','',$translation);
                /* 
               error_log("...mtranslate " . $translation);                                                         
               $url =  "https://mtranslate.myridia.com/?s=".$scode . "&t=". $code ."&v=".$translation;
               $r2 = wp_remote_get( $url );
               $b = wp_remote_retrieve_body( $r2 );
               $body = json_decode($b);
               $target_text = $body->target_value;
                */


                //error_log("hash: " . $hash);
                //error_log("hash: " . $code);
                //error_log("source: " . $translation);


               $exist = $wpdb->get_var("SELECT ID FROM ".$tb ." WHERE hash = '" . $hash ."'");
                error_log("id exists: " . $exist);                
                if($exist == NULL) {

        $wpdb->insert($tb, 
   	    array( 
		'hash' => $hash, 
		'code' => $code,
		'source_text' => $translation,
	    ) 
        );
        }

        
               //error_log($url);                               
               /*
        $wpdb->insert($tb, 
   	    array( 
		'hash' => $hash, 
		'code' => $code,
		'target_text' => $translation,
	    ) 
        );
               */
            }
            //}
        return $translation;
    }

    public function swap_locale($locale){
        return $locale;
    }    



       /**
     * Overwrite filter hook wp_setup_nav_menu_item.
     *
     * https://developer.wordpress.org/reference/hooks/wp_setup_nav_menu_item
     *
     * @since 1.0.0
     *
     * @return string $menu_item
     */
    public function swap_wp_setup_nav_menu_item($menu_item)
    {
        //$menu_item->url = str_replace($this->siteurl, $this->new_siteurl, $menu_item->url);

        return $menu_item;
    }

    
    /**
     * Class function to set all set domain target language combinations.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function set_lang_codes($domain, $options)
    {
        $domains = [];
        if (isset($options['source_lang_code'])) {
            $this->source_lang_code = esc_attr($options['source_lang_code']);
        }

        foreach($options["domains"] as $k=>$i) {
         $domains[$i["domain"]] = $i["lang"];            
        }
        
        if (array_key_exists($domain, $domains)) {
            $this->target_lang_code = $domains[$domain];
        }
        $this->domains = $domains;
    }

    /**
     * Check if the plugin is set Active.
     *
     * @return boolen - true or false
     *
     * @since 1.0.0
     */
    public function is_active()
    {
        $o = get_option($this->option_name);
        if (isset($o['active'])) {
            $this->options = $o;

            return true;
        } else {
            $this->options = [];

            return false;
        }
    }

    /**
     * Set Class Propertier like actual Domain.
     *
     * @return string - Actual Domain
     *
     * @since 1.0.0
     */
    public function set_domain()
    {
        $domain = get_option('siteurl'); // Set default url from the wordpress setting
        if (isset($_SERVER['HTTP_HOST'])) {
            $unslashed = sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST']));
            if ('' != $unslashed) {
                $domain = $unslashed;
            }
        } elseif (isset($_SERVER['SERVER_NAME'])) {
            $unslashed = sanitize_text_field(wp_unslash($_SERVER['SERVER_NAME']));
            if ('' != $unslashed) {
                $domain = $unslashed;
            }
        }

        $a = array_reverse(explode('.', $domain));
        if (count($a) > 2) {
            $this->base_domain = $a[1].'.'.$a[0];
        }
        $this->domain = $domain;

        return $domain;
    }



}
