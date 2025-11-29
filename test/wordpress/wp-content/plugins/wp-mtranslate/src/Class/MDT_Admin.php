<?php

namespace MWPDT\Dt\Class;

/**
 * Main Admin Class.
 *
 * Register and un-register the plugin. Setting Page render.
 *
 * @since 1.0.0
 */
class MDT_Admin
{
    private $option_name = "myridiadt_settings";    
    private $options;
    // Possible Google Translate Codes with Name
    private $lang_codes = [
        ['af', __('Afrikaans','domain-translate')],
        ['sq', __('Albanian','domain-translate')],
        ['am', __('Amharic','domain-translate')],
        ['ar', __('Arabic','domain-translate')],
        ['hy', __('Armenian','domain-translate')],
        ['az', __('Azerbaijani','domain-translate')],
        ['eu', __('Basque','domain-translate')],
        ['be', __('Belarusian','domain-translate')],
        ['bn', __('Bengali','domain-translate')],
        ['bs', __('Bosnian','domain-translate')],
        ['bg', __('Bulgarian','domain-translate')],
        ['ca', __('Catalan','domain-translate')],
        ['ceb', __('Cebuano','domain-translate')],
        ['ny', __('Chichewa','domain-translate')],
        ['zh-CN', __('Chinese (Simplified)','domain-translate')],
        ['zh-TW', __('Chinese (Traditional)','domain-translate')],
        ['co', __('Corsican','domain-translate')],
        ['hr', __('Croatian','domain-translate')],
        ['cs', __('Czech','domain-translate')],
        ['da', __('Danish','domain-translate')],
        ['nl', __('Dutch','domain-translate')],
        ['en', __('English','domain-translate')],
        ['eo', __('Esperanto','domain-translate')],
        ['et', __('Estonian','domain-translate')],
        ['tl', __('Filipino','domain-translate')],
        ['fi', __('Finnish','domain-translate')],
        ['fr', __('French','domain-translate')],
        ['fy', __('Frisian','domain-translate')],
        ['gl', __('Galician','domain-translate')],
        ['ka', __('Georgian','domain-translate')],
        ['de', __('German','domain-translate')],
        ['el', __('Greek','domain-translate')],
        ['gu', __('Gujarati','domain-translate')],
        ['ht', __('Haitian Creole','domain-translate')],
        ['ha', __('Hausa','domain-translate')],
        ['haw', __('Hawaiian','domain-translate')],
        ['iw', __('Hebrew','domain-translate')],
        ['hi', __('Hindi','domain-translate')],
        ['hmn', __('Hmong','domain-translate')],
        ['hu', __('Hungarian','domain-translate')],
        ['is', __('Icelandic','domain-translate')],
        ['ig', __('Igbo','domain-translate')],
        ['id', __('Indonesian','domain-translate')],
        ['ga', __('Irish','domain-translate')],
        ['it', __('Italian','domain-translate')],
        ['ja', __('Japanese','domain-translate')],
        ['jw', __('Javanese','domain-translate')],
        ['kn', __('Kannada','domain-translate')],
        ['kk', __('Kazakh','domain-translate')],
        ['km', __('Khmer','domain-translate')],
        ['ko', __('Korean','domain-translate')],
        ['ku', __('Kurdish (Kurmanji)','domain-translate')],
        ['ky', __('Kyrgyz','domain-translate')],
        ['lo', __('Lao','domain-translate')],
        ['la', __('Latin','domain-translate')],
        ['lv', __('Latvian','domain-translate')],
        ['lt', __('Lithuanian','domain-translate')],
        ['lb', __('Luxembourgish','domain-translate')],
        ['mk', __('Macedonian','domain-translate')],
        ['mg', __('Malagasy','domain-translate')],
        ['ms', __('Malay','domain-translate')],
        ['ml', __('Malayalam','domain-translate')],
        ['mt', __('Maltese','domain-translate')],
        ['mi', __('Maori','domain-translate')],
        ['mr', __('Marathi','domain-translate')],
        ['mn', __('Mongolian','domain-translate')],
        ['my', __('Burmese','domain-translate')],
        ['ne', __('Nepali','domain-translate')],
        ['no', __('Norwegian','domain-translate')],
        ['or', __('Odia','domain-translate')],
        ['ps', __('Pashto','domain-translate')],
        ['fa', __('Persian','domain-translate')],
        ['pl', __('Polish','domain-translate')],
        ['pt', __('Portuguese','domain-translate')],
        ['pa', __('Punjabi','domain-translate')],
        ['ro', __('Romanian','domain-translate')],
        ['ru', __('Russian','domain-translate')],
        ['sm', __('Samoan','domain-translate')],
        ['gd', __('Scots Gaelic','domain-translate')],
        ['sr', __('Serbian','domain-translate')],
        ['st', __('Sesotho','domain-translate')],
        ['sn', __('Shona','domain-translate')],
        ['sd', __('Sindhi','domain-translate')],
        ['si', __('Sinhala','domain-translate')],
        ['sk', __('Slovak','domain-translate')],
        ['sl', __('Slovenian','domain-translate')],
        ['so', __('Somali','domain-translate')],
        ['es', __('Spanish','domain-translate')],
        ['su', __('Sundanese','domain-translate')],
        ['sw', __('Swahili','domain-translate')],
        ['sv', __('Swedish','domain-translate')],
        ['tg', __('Tajik','domain-translate')],
        ['ta', __('Tamil','domain-translate')],
        ['te', __('Telugu','domain-translate')],
        ['th', __('Thai','domain-translate')],
        ['tr', __('Turkish','domain-translate')],
        ['uk', __('Ukrainian','domain-translate')],
        ['ur', __('Urdu','domain-translate')],
        ['uz', __('Uzbek','domain-translate')],
        ['vi', __('Vietnamese','domain-translate')],
        ['cy', __('Welsh','domain-translate')],
        ['xh', __('Xhosa','domain-translate')],
        ['yi', __('Yiddish','domain-translate')],
        ['yo', __('Yoruba','domain-translate')],
        ['zu', __('Zulu','domain-translate')],
        ['', ''],
    ];

    /**
     * Class Constructor.
     *
     * Place Holder for the moment
     *
     * @since 1.0.0
     */
    public function __construct()
    {

    }

    /**
     * Default Activate.
     *
     * Place Holder for the moment
     *
     * @since 1.0.0
     */
    public static function activate()
    {
        $p = new MDT_Admin();        
        $options = ["domains"=>[],"source_lang_code"=>"en","active"=>0];
        if (false == get_option($p->option_name)) {
            update_option($p->option_name, $options);
        }
    }

    /**
     * Default Deactivate.
     *
     * @since 1.0.0
     */
    public static function deactivate()
    {
        $p = new MDT_Admin();        
        delete_option($p->option_name);
    }

    /**
     * Add Menu Setting.
     *
     * The Menu will appear under Settings
     *
     * @since 1.0.0
     */
    public function add_menu_setting()
    {
        add_submenu_page(
            'options-general.php',
            esc_html__('Domain Translate', 'domain-translate'),
            esc_html__('Domain Translate', 'domain-translate'),
            'manage_options',
            'domain-translate',
            [$this, 'wporg_options_page_html'],
            99
        );
    }

    /**
     * Add an API based Setting Page
     * doc: https://developer.wordpress.org/plugins/settings/custom-settings-page/.
     *
     * @since 1.0.0
     */
    public function register_settings()
    {
        // https://developer.wordpress.org/reference/functions/add_settings_section/
        register_setting($this->option_name
                         , $this->option_name
                         ,[
                          'type' => 'string',
                          'sanitize_callback' => [$this, 'validate']
                         ]);

        add_settings_section(
            'section',
            __('Settings:', 'domain-translate'),
            [$this, 'callback'],
            $this->option_name
        );



        /************************* General ************************************/
        add_settings_field(
            'active',
            __('Active:', 'domain-translate'),
            [$this, 'make_checkbox'],
            $this->option_name,
            'section',
            [
                'name' => 'active',
                'label_for' => "{$this->option_name}[active]",
            ]
        );

        add_settings_field(
            'source_lang_code',
            __('Source Lang Code:', 'domain-translate'),
            [$this, 'echo_select'],
            $this->option_name,
            'section',
            [
                'label_for' => "{$this->option_name}[source_lang_code]",
                'name' => 'source_lang_code',
            ]
        );

        /************************* Domains ************************************/
        add_settings_field(
            'domains',
            __('Domains:', 'domain-translate'),
            [$this, 'make_domain_input'],
            $this->option_name,
            'section',
            [
                'name' => 'domains',
                'label_for' => "{$this->option_name}[domains]",
            ]
        );


    }

    /**
     * Generate a text checkbox field.
     *
     * @since 1.0.0
     *
     * @param array $args {Field array }
     *
     * @return string
     */
    public function make_checkbox($args)
    {
        $name = esc_attr($args['name']);
        $o = get_option($this->option_name);
        $checked = '';
        if (isset($o[$name])) {
            if ('on' == $o[$name]) {
                $checked = 'checked=checked';
            }
        }
        $html_content = "<input type='checkbox' name='{$args['label_for']}'  {$checked} />";
        echo wp_kses($html_content, [
            'input' => [
                'id' => [],
                'name' => [],
                'type' => [],
                'value' => [],
                'checked' => [],
            ],
        ]);
    }

    public function make_input($label_for,$k,$name,$value)
    {
        $html = "";
          $html_content = "<input type='text' name='{$label_for}[$k][$name]' value='{$value}'   />";
          $html .= wp_kses($html_content, [
            'input' => [
                'id' => [],
                'name' => [],
                'type' => [],
                'value' => [],
                'checked' => [],
            ],
          ]);
        return $html;
    }


    public function make_select($label_for,$k,$kname,$value)
    {
        $html = "";

          $h = "<select name='{$label_for}[$k][$kname]' />";
          foreach ($this->lang_codes as $x) {
            $code = $x[0];
            $name = $x[1];
            $selected = '';
             if ($value == $code) {
               $selected = 'selected';
             }

            $h .= "<option value='{$code}' {$selected} >{$name}</option>";
        }
        $h .= '</select>';
       
        $html .= wp_kses($h, [
            'select' => [
                'name' => true,
                'id' => true,
                'class' => true,
            ],
            'option' => [
                'value' => true,
                'selected' => true,
            ],
        ]);
        
        return $html;
    }        
    /**
     * Generate a text input field.
     *
     * @since 1.0.0
     *
     * @param array $args {Field array }
     *
     * @return string
     */
    public function make_domain_input($args)
    {

        $html = "<table class='wp-list-table widefat fixed striped'>";
        $html .="<thead><tr><td>".__("Domain","domain-translate") . "</td><td>" . __("Language","domain-translate") . "</td><td>" . __("Delete","domain-translate") . "</td></tr></thead>";        
        $name = esc_attr($args['name']);
        $o = get_option($this->option_name);

        $a  = $o[$name] ;
        //var_dump($a);
        $nk=0;

        foreach($a as $k=>$i ) {
          $html .="<tr>";
          if(isset($i['domain']) && isset($i['lang'])) {
            $nk = $k+1;
            $html .="<td>". $this->make_input($args['label_for'],$k,'domain',$i["domain"]) . "</td>";
            $html .="<td>". $this->make_select($args['label_for'],$k,'lang',$i["lang"]) . "</td>";          

            $html .="<td><button class='button action' onClick=\"(function(){
            const el = this.event.target ;
            el.parentElement.parentElement.remove();
            return false;
            })();return false;\">". __("Delete","domain-translate") . "</button></td>";
            $html .="</tr>";                  
          }
        }
        
        $html .="<tr>";
        $html .="<td>". $this->make_input($args['label_for'],$nk,'domain',"") . "</td>";
        $html .="<td>". $this->make_select($args['label_for'],$nk,'lang',"") . "</td>";        
        $html .="</tr>";                                  
        $html .= "</table>";
        
        echo $html;
    }

    /**
     * Generate HTML Select.
     *
     * @since 1.0.0
     *
     * @param array $args { Field array}
     *
     * @return string
     */
    public function echo_select($args)
    {
        $html = "";
        $name = esc_attr($args['name']);
        $o = get_option($this->option_name);
        $key = '';
        if (isset($o[$name])) {
            $key = esc_attr($o[$name]);
        }


        $html = "<select name='{$args['label_for']}' />";
        foreach ($this->lang_codes as $i) {
            $code = $i[0];
            $name = $i[1];
            $selected = '';
            if ($key == $code) {
                $selected = 'selected';
            }

            $html .= "<option value='{$code}' {$selected} >{$name}</option>";
        }
        $html .= '</select>';

        echo wp_kses($html, [
            'select' => [
                'name' => true,
                'id' => true,
                'class' => true,
            ],
            'option' => [
                'value' => true,
                'selected' => true,
            ],
        ]);

    }

    /**
     * Generate Setting Page.
     *
     * Generate a text input fields for the Domain names
     *
     * @since 1.0.0
     */
    public function wporg_options_page_html()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        settings_errors('wporg_messages');
        ?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
		<form action="options.php" method="post">
	    <?php
        wp_nonce_field('wpds_save', 'wpds_nonce');
        settings_fields($this->option_name);
        do_settings_sections($this->option_name);
        submit_button(__('Save Settings','domain-translate'));
        ?>
		</form>
	</div>
	<?php
    }

    /**
     * Check for valid Domain.
     *
     * @since 1.0.0
     *
     * @param string $domain_name
     *
     * @return bool $ok
     */
    public function is_valid_domain_name($domain_name)
    {
        $ok = preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) // valid chars check
                && preg_match('/^.{1,253}$/', $domain_name) // overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name); // length of each label
        if ('localhost' != $domain_name) {
            if (false == strpos($domain_name, '.')) {
                $ok = false;
            }
        }

        return $ok;
    }

    /**
     * Validate input of valid Domains.
     *
     * @since 1.0.0
     *
     * @param string $input
     *
     * @return string $input
     */
    public function validate($input)
    {
        $msg = __('Settings saved successfully', 'domain-translate');
        foreach($input["domains"] as $k=>$v) {
            if($this->is_valid_domain_name($v["domain"]) == false):
              unset($input["domains"][$k]);
             $msg .= " - " . __('One domain was invalid and was removed', 'domain-translate');
            endif;
        }

        add_settings_error('wporg_messages', 'wporg_message', $msg, 'updated');

        return $input;
    }

    /**
     * Callback after add Settings - for the moment a placeholder.
     *
     * @since 1.0.0
     */
    public function callback()
    {
        // esc_html_e('Settings added to ', 'domain-translate');
    }
}
