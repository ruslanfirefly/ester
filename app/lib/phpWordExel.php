<?php
/**
 * Based on PHPWord library
 * https://github.com/PHPOffice/PHPWord
 */
class DocumentOpenXML {

    /**
     * ZipArchive
     *
     * @var ZipArchive
     */
    protected $_objZip;

    /**
     * Temporary Filename
     *
     * @var string
     */
    protected $_tempFileName;

    /**
     * Document XML
     *
     * @var string
     */
    protected $_documentXML;

    /**
     * File docx/xlsx
     *
     * @var string
     */
    protected $_file;

    /**
     * Zip archive is closed
     *
     * @var boolean
     */
    protected $_isClosed = false;

    /**
     * Paths to xml
     *
     * @var array
     */
    protected static $_XMLPaths = array(
        'docx'    => 'word/document.xml',
        'xlsx'    => 'xl/sharedStrings.xml'
    );

    /**
     * Current path to xml
     *
     * @var array
     */
    protected $_currentPath;


    /**
     * Create a new PHPWord Object
     *
     * @param string $sFilename
     */
    public function __construct($sFilename){
        $this->loadTemplate($sFilename);
    }

    /**
     * Delete temporary file
     *
     * @param string $sFilename
     */
    public function __destruct(){
        // Delete temporary file
        if(!unlink($this->_tempFileName)){
            throw new Exception('Could not delete file.');
        }
    }

    /**
     * Set a Template value
     *
     * @param mixed $search
     * @param string $replace
     * @return PHPWord for method chaining
     */
    public function set($search, $replace = null) {

        // Allow for array input when setting multiple values
        if (is_null($replace) and is_array($search)) {
            foreach ($search as $k => $v)
            {
                $this->set($k, $v);
            }
            return $this;
        }

       if(substr($search, 0, 2) !== '{{' && substr($search, -2) !== '}}') {
           $search = '{{'.$search.'}}';
       }

        $replace = htmlspecialchars($replace, ENT_XML1);
        $this->_documentXML = str_replace($search, $replace, $this->_documentXML);

        return $this;
    }

    /**
     * Returns array of all variables in template
     * @return array
     */
    public function getVariables() {
        preg_match_all('/\$\{(.*?)}/i', $this->_documentXML, $matches);
        return $matches[1];
    }

    /**
     * Returns document as string
     * @return string
     */
    public function getDocx(){
        if(!$this->_isClosed)
            $this->close();
        return $this->_file;
    }

    /**
     * Turns PHPWord to the string
     * @return  string
     */
    public function __toString() {
        return $this->getDocx();
    }

    /**
     * Load DOCX template
     * @param string $sFilename
     * @return PHPWord for method chaining
     */
    protected function loadTemplate($sFilename) {
        if(!file_exists($sFilename)) {
            throw new Exception('Template file '.$sFilename.' not found.');
        }

        $path = pathinfo($sFilename);

        if(!array_key_exists($path['extension'], self::$_XMLPaths)) {
            throw new Exception('Template file extension '.$path['extension'].' is not allowed.');
        }
        $this->_currentPath = self::$_XMLPaths[$path['extension']];

        $this->_tempFileName = $path['dirname'].DIRECTORY_SEPARATOR.time().'.'.$path['extension'];
        copy($sFilename, $this->_tempFileName); // Copy the source File to the temp File

        $this->_objZip = new ZipArchive();
        $this->_objZip->open($this->_tempFileName);

        $this->_documentXML = $this->_objZip->getFromName($this->_currentPath);

        return $this;
    }


    /**
     * Close zip archive and set _file
     *
     * @param void
     */
    protected function close(){

        $this->_objZip->addFromString($this->_currentPath, $this->_documentXML);

        if($this->_objZip->close() === false) {
            throw new Exception('Could not close zip file.');
        }

        $this->_file = file_get_contents($this->_tempFileName);
        $this->_isClosed = true;
    }

    /*
    public function replaceXML($xml, $file){
        $this->load($file);
        $this->_documentXML = file_get_contents($xml);
        return $this;
    }
    */
}