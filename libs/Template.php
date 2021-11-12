<?php
class Template{

    // File config (admin/main/template.ini)
    private $_fileConfig;

    // File Template (admin/main/index.php)
    private $_fileTemplate;

    // Folder Template (admin/main/)
    private $_folderTemplate;

    // Controller object
    private $_controller;

    public function __construct($controller)
    {
        $this->_controller = $controller;
    }

    public function load()
    {
        $fileConfig = $this->getFileConfig();
        $folderTemplate = $this->getFolderTemplate();
        $fileTemplate = $this->getFileTemplate();

        $pathfileConfig = TEMPLATE_PATH . $folderTemplate . $fileConfig;
        if(file_exists($pathfileConfig)){
            $arrConfig = parse_ini_file($pathfileConfig);
            $view = $this->_controller->getView();
            
            $view->_title       = $view->createTitle($arrConfig['title']);
            $view->_metaHTTP    = $view->createMeta($arrConfig['metaHTTP'], 'http-equiv');
            $view->_metaName    = $view->createMeta($arrConfig['metaName'], 'name');
            $view->_cssFiles    = $view->createLink($this->_folderTemplate . $arrConfig['dirCss'], $arrConfig['fileCss'], 'css');
                  
            $view->_jsFiles    = $view->createLink($this->_folderTemplate . $arrConfig['dirJs'], $arrConfig['fileJs'], 'js');
            
            $view->_dirImg    = $arrConfig['dirImg'];




            $view->setTemplatePath(TEMPLATE_PATH . $folderTemplate . $fileTemplate);
        }
    }

    
    

    // Set File Template (index.php)
    public function setFileTemplate($value = 'index.php')
    {
        $this->_fileTemplate = $value;
    }

    // Get File Template
    public function getFileTemplate()
    {
        return $this->_fileTemplate;
    }

    // Set File Config (template.ini)
    public function setFileConfig($value = 'template.ini')
    {
        $this->_fileConfig = $value;
    }

    // Get File config
    public function getFileConfig()
    {
        return $this->_fileConfig;
    }

    // Set Folder Template (default/main/)
    public function setFolderTemplate($value = 'default/main/')
    {
        $this->_folderTemplate = $value;
    }

    // Get Folder Template
    public function getFolderTemplate()
    {
        return $this->_folderTemplate;
    }
}