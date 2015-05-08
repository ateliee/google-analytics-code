<?php
/*
Plugin Name: google-analytics-code
Description: googleアナリティクスコードを埋め込むだけのプラグイン
Author: ateliee
Version: 0.1
Author URI: http://www.ateliee.com
*/

class GoogleAnalyticsCode {
    static $OPTIONS_ID = 'google_analytics_code';

    /**
     *
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_pages'));
        add_action('wp_head', array($this, 'wp_head'));
    }

    /**
     *
     */
    public function add_pages() {
        add_menu_page('Google Analytics','Google Analytics',  'level_8', __FILE__, array($this,'show_text_option_page'), '', 26);
    }

    /**
     * @param $id
     * @return null
     */
    public function get_option($id) {
        $opt = get_option(self::$OPTIONS_ID);
        return isset($opt[$id]) ? $opt[$id]: null;
    }

    /**
     *
     */
    public function wp_head(){
        $codes = $this->get_option('code');
        if($codes){
            print $codes."\n";
        }
    }

    /**
     *
     */
    public function show_text_option_page() {
        //$_POST['showtext_options'])があったら保存
        if ( isset($_POST[self::$OPTIONS_ID])) {
            check_admin_referer('shoptions');
            $opt = stripslashes_deep($_POST[self::$OPTIONS_ID]);
            update_option(self::$OPTIONS_ID, $opt);
            ?><div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p></div><?php
        }
        ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"><br /></div><h2>テキスト設定</h2>
            <form action="" method="post">
                <?php
                wp_nonce_field('shoptions');
                $show_text = $this->get_option('code');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><label for="inputtext">アナリティクスコード</label></th>
                        <td><textarea name="<?php print self::$OPTIONS_ID; ?>[code]" class="large-text code" rows="20"><?php echo esc_textarea($show_text); ?></textarea></td>
                    </tr>
                </table>
                <p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
            </form>
            <!-- /.wrap --></div>
    <?php
    }
}
$googleanalyticscode = new GoogleAnalyticsCode;