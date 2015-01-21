<?php

class BaiduSubmit_Action extends Typecho_Widget implements Widget_Interface_Do
{

    public function __construct()
    {
        $this->_dir = '.' . __TYPECHO_PLUGIN_DIR__ . '/BaiduSubmit/inc/';
        define('TYPE_ALL', 1);
        define('TYPE_INC', 2);
    }

    public function checksign()
    {
        $checksign = $_GET['checksign'];
        if (!$checksign || strlen($checksign) !== 32) {
            exit;
        }

        $data = Helper::options()->plugin('BaiduSubmit');

        if ($data->checksign == $checksign) {
            echo $data->checksign;
        }
    }


    public function action()
    {
    }

    public function baidusitemap()
    {
        require $this->_dir . 'sitemap.php';
        require $this->_dir . 'setting.php';

        BaidusubmitSetting::checkPasswd();

        $ids = BaidusubmitSitemap::get_post_id_by_range(1, 300);

        $content = BaidusubmitSitemap::gen_elenment_by_cid($ids);

        $this->print_xml_header();
        foreach($content as $v){
            echo $v->toXml();
        }

        $this->print_xml_footer();
    }


    protected function gen_sitemap_all()
    {
        $this->print_xml_header();
        //$this->print_xml_footer();
        $options = $this->widget('Widget_Options');
        $siteUrl = $options->siteUrl;
        echo '<sitemap><loc><![CDATA[', $siteUrl, 'sitemap.xml]]></loc></sitemap>', "\n";
        $this->print_xml_footer();
    }


    protected function print_xml_header()
    {
        header('Content-Type: text/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?><urlset>';
    }


    protected function print_xml_footer()
    {
        echo '</urlset>';
    }

}
