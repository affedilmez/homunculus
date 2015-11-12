<?php

/**
 * Homonculus -  class for managing CMS-like global HTML without DB overhead
 */
class Homunculus {

    private static $instance;

    private $css    = array();
    private $headJS = array();
    private $footJS = array();

    private $data   = array();
    private $fragmentKey = '';

    private $dir;
  
    /** Set template directory & load ini file */
    private function __construct($templateDir=null) {
        if ($templateDir)
            $this->dir = $templateDir;

        $includes = parse_ini_file($this->dir.'/includes.ini', true);

        foreach (array('css', 'headJS', 'footJS') as $varKey) {
            foreach ($includes[$varKey] as $section => $files) {
                $memberVar = &$this->$varKey;
                $memberVar[urldecode($section)] = $files;
            }
        }
    }


    /** This is how you instantiate/retrieve the class */
    static function getInstance($templateDir=null) {
        if (self::$instance == null) {
            $class = __CLASS__;
            self::$instance = new $class($templateDir);
        }
        return self::$instance;
    }


    /** Prints document definition/opining and <head> element, also see top() */
    function head() {
        include $this->dir.'/head.php';
    }


    /** Prints the opening <body> tag and header region, also see top() */
    function header() {
        include $this->dir.'/header.php';
    }


    /** Prints html <head> and body header */
    function top() {
        $this->head();
        echo "</head>\n";
        $this->header();
    }


    /** Prints footer region */
    function footer() {
        include $this->dir.'/footer.php';
    }


    /** Prints footer region and closes html document */
    function bottom() {
        $this->footer();
        echo "</body>\n</html>";
    }


    /**
     * Stores an arbitrary variable for later retrieval
     * (obviates need for global variables)
     *
     * @param array  $addition Data you wish to use retrieve in another template;
     * used a keyed array, e.g. array('key' => 'value'); multiple key/value pairs
     * can therefore be stored at once
     */
    function store($addition) {
        $this->data = array_merge($this->data, $addition);
    }


    /**
     * Retrieve stored variable
     *
     * @param string $key  Key used for array in store() call
     * @param bool   $echo Whether to echo the value rather than return it;
     * defaults to true (echo)
     */
    function retrieve($key, $echo=true) {
        $value = (isset($this->data[$key])) ? $this->data[$key] : false;
        if ($echo)
            echo $value;
        else
            return $value;
    }


    /**
     * Print HTML fragment stored in fragments.php (this works similarly
     * store() and retrieve() but is designed for longer fragments)
     * 
     * @param string $key Identifier used in switch block in fragments.php
     */
    function retrieveFragment($key) {
        $this->fragmentKey = $key;
        include $this->dir.'/fragments.php';
    }


    /** Used only in fragments.php to determine which fragment to retrieve */
    function getFragmentKey() { return $this->fragmentKey; }


    /**
     * Add CSS files to be used in header
     *
     * @param array  $addition Array of CSS URLs to include
     * @param string $key      If specified, encloses include statement in an 'IF'
     * block using this condition (e.g., 'IE')
     */
    function addCSS($addition, $key='all') {
        $this->css[$key] = $this->mergeIncludes($this->css, $addition, $key);
    }


    /**
     * Add JavaScript files to be included in page
     *
     * @param array  $addition Array of JavaScript URLs to include
     * @param string $key      If specified, encloses include statement in an 'IF'
     * block using this condition (e.g., 'IE'). Defaults to 'all'.
     * @param bool   $head     Specifies whether to include in <head> element or
     * just before document close.  Defaults to true (<head>)
     */
    function addJS($addition, $key='all', $head=true) {
        if ($head)
            $this->headJS[$key] = $this->mergeIncludes($this->headJS, $addition, $key);
        else
            $this->footJS[$key] = $this->mergeIncludes($this->footJS, $addition, $key);
    }


    /**
     * Prints include lines for CSS or JS. Only used in head.php and footer.php
     *
     * @param string $links The set of files to include;
     * possible values are 'css', 'headJS', or 'footJS'
     */
    function htmlInclude($links) {
        $type = ($links == 'css') ? 'css' : 'js';
        $links = $this->$links;

        // all browsers
        if (isset($links['all'])) {
            foreach ($links['all'] as $file)
                $this->includeLink($file, $type);
            unset($links['all']);
        }

        // conditional includes
        foreach ($links as $condition => $files) {
            echo "<!--[if $condition]>\n";
            foreach ($files as $file)
                $this->includeLink($file, $type);
            echo "<![endif]-->\n";
        }
    
    }


    /**
     * Private function to include individual file; used by htmlInclude()
     *
     * @param string $file URL of file to be included
     * @param string $type Type of file ('css' or 'js')
     */
    private function includeLink($file, $type) {
        if ($type == 'css')
            echo "<link rel=\"stylesheet\" type=\"text/css\" href='$file' />\n";
        elseif ($type == 'js')
            echo "<script src=\"$file\"></script>\n";
        else
            echo "<!-- unkown file type '$type' -->\n";
    }


    /**
     * Private function to help organize CSS/JS files to be included
     *
     * @param array  $target   Set of files to merge
     * @param array  $addition Array of files to add
     * @param string $section  Conditional element (e.g., 'IE');
     */
    private function mergeIncludes($target, $addition, $section) {
        return (isset($target[$section]))
            ? array_merge($target[$section], $addition)
            : $target[$section] = $addition;
    }

}
