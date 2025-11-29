<?php

namespace WPMTR\Dt\Class;

/**
 * Class Frontend.
 *
 * Handle all Request to to browser Frontend
 *
 * @since 1.0.0
 */
class MDT_Frontend
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
                //add_action('wp_enqueue_scripts', [$this, 'add_scripts']);
                //add_action('wp_enqueue_scripts', [$this, 'add_styles']);
            }
        }
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
