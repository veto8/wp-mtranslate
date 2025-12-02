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
    private $table = 'wpmtr_translate';    
    private $option_name = "wpmtr_settings";    
    private $options;
    private $lang_codes = [
        ['af', 'Afrikaans'],
        ['sq', 'Albanian'],
        ['am', 'Amharic'],
        ['ar', 'Arabic'],
        ['hy', 'Armenian'],
        ['az', 'Azerbaijani'],
        ['eu', 'Basque'],
        ['be', 'Belarusian'],
        ['bn', 'Bengali'],
        ['bs', 'Bosnian'],
        ['bg', 'Bulgarian'],
        ['ca', 'Catalan'],
        ['ceb', 'Cebuano'],
        ['ny', 'Chichewa'],
        ['zh-CN', 'Chinese (Simplified)'],
        ['zh-TW', 'Chinese (Traditional)'],
        ['co', 'Corsican'],
        ['hr', 'Croatian'],
        ['cs', 'Czech'],
        ['da', 'Danish'],
        ['nl', 'Dutch'],
        ['en', 'English'],
        ['eo', 'Esperanto'],
        ['et', 'Estonian'],
        ['tl', 'Filipino'],
        ['fi', 'Finnish'],
        ['fr', 'French'],
        ['fy', 'Frisian'],
        ['gl', 'Galician'],
        ['ka', 'Georgian'],
        ['de', 'German'],
        ['el', 'Greek'],
        ['gu', 'Gujarati'],
        ['ht', 'Haitian Creole'],
        ['ha', 'Hausa'],
        ['haw', 'Hawaiian'],
        ['iw', 'Hebrew'],
        ['hi', 'Hindi'],
        ['hmn', 'Hmong'],
        ['hu', 'Hungarian'],
        ['is', 'Icelandic'],
        ['ig', 'Igbo'],
        ['id', 'Indonesian'],
        ['ga', 'Irish'],
        ['it', 'Italian'],
        ['ja', 'Japanese'],
        ['jw', 'Javanese'],
        ['kn', 'Kannada'],
        ['kk', 'Kazakh'],
        ['km', 'Khmer'],
        ['ko', 'Korean'],
        ['ku', 'Kurdish (Kurmanji)'],
        ['ky', 'Kyrgyz'],
        ['lo', 'Lao'],
        ['la', 'Latin'],
        ['lv', 'Latvian'],
        ['lt', 'Lithuanian'],
        ['lb', 'Luxembourgish'],
        ['mk', 'Macedonian'],
        ['mg', 'Malagasy'],
        ['ms', 'Malay'],
        ['ml', 'Malayalam'],
        ['mt', 'Maltese'],
        ['mi', 'Maori'],
        ['mr', 'Marathi'],
        ['mn', 'Mongolian'],
        ['my', 'Burmese'],
        ['ne', 'Nepali'],
        ['no', 'Norwegian'],
        ['or', 'Odia'],
        ['ps', 'Pashto'],
        ['fa', 'Persian'],
        ['pl', 'Polish'],
        ['pt', 'Portuguese'],
        ['pa', 'Punjabi'],
        ['ro', 'Romanian'],
        ['ru', 'Russian'],
        ['sm', 'Samoan'],
        ['gd', 'Scots Gaelic'],
        ['sr', 'Serbian'],
        ['st', 'Sesotho'],
        ['sn', 'Shona'],
        ['sd', 'Sindhi'],
        ['si', 'Sinhala'],
        ['sk', 'Slovak'],
        ['sl', 'Slovenian'],
        ['so', 'Somali'],
        ['es', 'Spanish'],
        ['su', 'Sundanese'],
        ['sw', 'Swahili'],
        ['sv', 'Swedish'],
        ['tg', 'Tajik'],
        ['ta', 'Tamil'],
        ['te', 'Telugu'],
        ['th', 'Thai'],
        ['tr', 'Turkish'],
        ['uk', 'Ukrainian'],
        ['ur', 'Urdu'],
        ['uz', 'Uzbek'],
        ['vi', 'Vietnamese'],
        ['cy', 'Welsh'],
        ['xh', 'Xhosa'],
        ['yi', 'Yiddish'],
        ['yo', 'Yoruba'],
        ['zu', 'Zulu'],
        ['', '']];



    /**
     * Create Database
     *
     * @since 1.0.0
     */
    public function __construct()
    {

    }

    public function create_db()
    {
             global $wpdb;
             $table_name = $wpdb->prefix . $this->table;
             $charset_collate = $wpdb->get_charset_collate();
             //$sql = "CREATE TABLE ". $table_name." (id mediumint(9) NOT NULL AUTO_INCREMENT,PRIMARY KEY (id))" . $charset_collate .";";

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  hash varchar(32) DEFAULT '' NOT NULL,
  code varchar(4) DEFAULT '' NOT NULL,
  text text NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE INDEX (hash,code)
) $charset_collate;";

             
             error_log($sql);
             require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
             dbDelta( $sql );
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
        $p->create_db();
    }

    /**
     * Default Deactivate.
     *
     * @since 1.0.0
     */
    public static function deactivate()
    {
        $p = new WPMTR_Admin();        
        //delete_option($p->option_name);
    }


    /**
     * Default Uninstall
     *
     * @since 1.0.0
     */
    public static function uninstall()
    {
       global $wpdb;
       $table_name = $wpdb->prefix . 'wpmtr_translate';
       $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
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
            esc_html__('MTranslate', 'mtranslate'),
            esc_html__('MTranslate', 'mtranslate'),
            'manage_options',
            'mtranslate',
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
            __('Settings:', 'mtranslate'),
            [$this, 'callback'],
            $this->option_name
        );



        /************************* General ************************************/
        add_settings_field(
            'active',
            __('Active:', 'mtranslate'),
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
            __('Source Lang Code:', 'mtranslate'),
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
            __('Domains:', 'mtranslate'),
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
        $html .="<thead><tr><td>".__("Domain","mtranslate") . "</td><td>" . __("Language","mtranslate") . "</td><td>" . __("Delete","mtranslate") . "</td></tr></thead>";        
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
            })();return false;\">". __("Delete","mtranslate") . "</button></td>";
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
        submit_button(__('Save Settings','mtranslate'));
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
        $msg = __('Settings saved successfully', 'mtranslate');
        foreach($input["domains"] as $k=>$v) {
            if($this->is_valid_domain_name($v["domain"]) == false):
              unset($input["domains"][$k]);
             $msg .= " - " . __('One domain was invalid and was removed', 'mtranslate');
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
        // esc_html_e('Settings added to ', 'mtranslate');
    }
}
