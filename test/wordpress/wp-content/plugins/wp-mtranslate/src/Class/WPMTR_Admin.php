<?php

namespace WPMTR\Dt\Class;

/**
 * Main Admin Class.
 *
 * Register and un-register the plugin. Setting Page render.
 *
 * @since 1.0.0
 */
class WPMTR_Admin
{
    private $option_name = "wpmtr_settings";    
    private $options;
    // Possible Google Translate Codes with Name
    private $lang_codes = [
        ['af', __('Afrikaans','wp-mtranslate')],
        ['sq', __('Albanian','wp-mtranslate')],
        ['am', __('Amharic','wp-mtranslate')],
        ['ar', __('Arabic','wp-mtranslate')],
        ['hy', __('Armenian','wp-mtranslate')],
        ['az', __('Azerbaijani','wp-mtranslate')],
        ['eu', __('Basque','wp-mtranslate')],
        ['be', __('Belarusian','wp-mtranslate')],
        ['bn', __('Bengali','wp-mtranslate')],
        ['bs', __('Bosnian','wp-mtranslate')],
        ['bg', __('Bulgarian','wp-mtranslate')],
        ['ca', __('Catalan','wp-mtranslate')],
        ['ceb', __('Cebuano','wp-mtranslate')],
        ['ny', __('Chichewa','wp-mtranslate')],
        ['zh-CN', __('Chinese (Simplified)','wp-mtranslate')],
        ['zh-TW', __('Chinese (Traditional)','wp-mtranslate')],
        ['co', __('Corsican','wp-mtranslate')],
        ['hr', __('Croatian','wp-mtranslate')],
        ['cs', __('Czech','wp-mtranslate')],
        ['da', __('Danish','wp-mtranslate')],
        ['nl', __('Dutch','wp-mtranslate')],
        ['en', __('English','wp-mtranslate')],
        ['eo', __('Esperanto','wp-mtranslate')],
        ['et', __('Estonian','wp-mtranslate')],
        ['tl', __('Filipino','wp-mtranslate')],
        ['fi', __('Finnish','wp-mtranslate')],
        ['fr', __('French','wp-mtranslate')],
        ['fy', __('Frisian','wp-mtranslate')],
        ['gl', __('Galician','wp-mtranslate')],
        ['ka', __('Georgian','wp-mtranslate')],
        ['de', __('German','wp-mtranslate')],
        ['el', __('Greek','wp-mtranslate')],
        ['gu', __('Gujarati','wp-mtranslate')],
        ['ht', __('Haitian Creole','wp-mtranslate')],
        ['ha', __('Hausa','wp-mtranslate')],
        ['haw', __('Hawaiian','wp-mtranslate')],
        ['iw', __('Hebrew','wp-mtranslate')],
        ['hi', __('Hindi','wp-mtranslate')],
        ['hmn', __('Hmong','wp-mtranslate')],
        ['hu', __('Hungarian','wp-mtranslate')],
        ['is', __('Icelandic','wp-mtranslate')],
        ['ig', __('Igbo','wp-mtranslate')],
        ['id', __('Indonesian','wp-mtranslate')],
        ['ga', __('Irish','wp-mtranslate')],
        ['it', __('Italian','wp-mtranslate')],
        ['ja', __('Japanese','wp-mtranslate')],
        ['jw', __('Javanese','wp-mtranslate')],
        ['kn', __('Kannada','wp-mtranslate')],
        ['kk', __('Kazakh','wp-mtranslate')],
        ['km', __('Khmer','wp-mtranslate')],
        ['ko', __('Korean','wp-mtranslate')],
        ['ku', __('Kurdish (Kurmanji)','wp-mtranslate')],
        ['ky', __('Kyrgyz','wp-mtranslate')],
        ['lo', __('Lao','wp-mtranslate')],
        ['la', __('Latin','wp-mtranslate')],
        ['lv', __('Latvian','wp-mtranslate')],
        ['lt', __('Lithuanian','wp-mtranslate')],
        ['lb', __('Luxembourgish','wp-mtranslate')],
        ['mk', __('Macedonian','wp-mtranslate')],
        ['mg', __('Malagasy','wp-mtranslate')],
        ['ms', __('Malay','wp-mtranslate')],
        ['ml', __('Malayalam','wp-mtranslate')],
        ['mt', __('Maltese','wp-mtranslate')],
        ['mi', __('Maori','wp-mtranslate')],
        ['mr', __('Marathi','wp-mtranslate')],
        ['mn', __('Mongolian','wp-mtranslate')],
        ['my', __('Burmese','wp-mtranslate')],
        ['ne', __('Nepali','wp-mtranslate')],
        ['no', __('Norwegian','wp-mtranslate')],
        ['or', __('Odia','wp-mtranslate')],
        ['ps', __('Pashto','wp-mtranslate')],
        ['fa', __('Persian','wp-mtranslate')],
        ['pl', __('Polish','wp-mtranslate')],
        ['pt', __('Portuguese','wp-mtranslate')],
        ['pa', __('Punjabi','wp-mtranslate')],
        ['ro', __('Romanian','wp-mtranslate')],
        ['ru', __('Russian','wp-mtranslate')],
        ['sm', __('Samoan','wp-mtranslate')],
        ['gd', __('Scots Gaelic','wp-mtranslate')],
        ['sr', __('Serbian','wp-mtranslate')],
        ['st', __('Sesotho','wp-mtranslate')],
        ['sn', __('Shona','wp-mtranslate')],
        ['sd', __('Sindhi','wp-mtranslate')],
        ['si', __('Sinhala','wp-mtranslate')],
        ['sk', __('Slovak','wp-mtranslate')],
        ['sl', __('Slovenian','wp-mtranslate')],
        ['so', __('Somali','wp-mtranslate')],
        ['es', __('Spanish','wp-mtranslate')],
        ['su', __('Sundanese','wp-mtranslate')],
        ['sw', __('Swahili','wp-mtranslate')],
        ['sv', __('Swedish','wp-mtranslate')],
        ['tg', __('Tajik','wp-mtranslate')],
        ['ta', __('Tamil','wp-mtranslate')],
        ['te', __('Telugu','wp-mtranslate')],
        ['th', __('Thai','wp-mtranslate')],
        ['tr', __('Turkish','wp-mtranslate')],
        ['uk', __('Ukrainian','wp-mtranslate')],
        ['ur', __('Urdu','wp-mtranslate')],
        ['uz', __('Uzbek','wp-mtranslate')],
        ['vi', __('Vietnamese','wp-mtranslate')],
        ['cy', __('Welsh','wp-mtranslate')],
        ['xh', __('Xhosa','wp-mtranslate')],
        ['yi', __('Yiddish','wp-mtranslate')],
        ['yo', __('Yoruba','wp-mtranslate')],
        ['zu', __('Zulu','wp-mtranslate')],
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
        $p = new WPMTR_Admin();        
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
        $p = new WPMTR_Admin();        
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
            esc_html__('Domain Translate', 'wp-mtranslate'),
            esc_html__('Domain Translate', 'wp-mtranslate'),
            'manage_options',
            'wp-mtranslate',
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
            __('Settings:', 'wp-mtranslate'),
            [$this, 'callback'],
            $this->option_name
        );



        /************************* General ************************************/
        add_settings_field(
            'active',
            __('Active:', 'wp-mtranslate'),
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
            __('Source Lang Code:', 'wp-mtranslate'),
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
            __('Domains:', 'wp-mtranslate'),
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
        $html .="<thead><tr><td>".__("Domain","wp-mtranslate") . "</td><td>" . __("Language","wp-mtranslate") . "</td><td>" . __("Delete","wp-mtranslate") . "</td></tr></thead>";        
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
            })();return false;\">". __("Delete","wp-mtranslate") . "</button></td>";
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
        submit_button(__('Save Settings','wp-mtranslate'));
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
        $msg = __('Settings saved successfully', 'wp-mtranslate');
        foreach($input["domains"] as $k=>$v) {
            if($this->is_valid_domain_name($v["domain"]) == false):
              unset($input["domains"][$k]);
             $msg .= " - " . __('One domain was invalid and was removed', 'wp-mtranslate');
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
        // esc_html_e('Settings added to ', 'wp-mtranslate');
    }
}
