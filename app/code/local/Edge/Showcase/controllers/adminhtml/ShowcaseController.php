<?php

class Edge_Showcase_ShowcaseController extends Mage_Adminhtml_Controller_Action
{
    protected $article;

    protected function _initAction()
    {
        $this->loadLayout()
			->_title($this->__('Showcase Management'))
            ->_setActiveMenu('cms')
            ->_addBreadcrumb(Mage::helper('edge_showcase')->__('Annie Haak'), Mage::helper('edge_showcase')->__('Annie Haak'))
            ->_addBreadcrumb(Mage::helper('edge_showcase')->__('Showcase Management'), Mage::helper('edge_showcase')->__('Showcase Management'));

        return $this;
    }

    protected function _initModel()
	{
        $this->article = Mage::getModel('showcase/showcase');

        $id = $this->getRequest()->getParam('id', false);
		if ($id !== false){
			$this->article->load($id);
		}

		Mage::register('showcase', $this->article);
		return $this->article;
	}

	public function indexAction()
	{
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('showcase/adminhtml_showcase'))
			->renderLayout();
	}

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_initModel();

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $this->article->setData($data);
        }

        $this->_initAction()
			->_addContent($this->getLayout()->createBlock('showcase/adminhtml_showcase_edit'))
            ->_addLeft($this->getLayout()->createBlock('showcase/adminhtml_showcase_edit_tabs'))
			->renderLayout();
    }

    public function saveAction()
	{
        if ($data = $this->getRequest()->getPost()) {

            foreach ($_FILES as $name => $image) {
                if (isset($data[$name]['delete'])) {
                    $data[$name] = '';
                    continue;
                }
                if (isset($image['name']) && $image['name'] != ''){
                    $uploaded = $this->saveAttachment($name);
                    $data[$name] = $uploaded;
                }
                elseif (is_array($data[$name])) {
                    $data[$name] = $data[$name]['value'];
                }
            }

            if (empty($data['date'])) {
                $data['date'] = date('d M Y');
            }

            $data['url_key'] = 'showcase/' . strtolower(date('Y/F/',strtotime($data['date']))) . preg_replace('~[^-\w]+~', '-', strtolower($data['title']));
            $data['products'] = json_encode($data['products'], JSON_FORCE_OBJECT);

            $article = Mage::getModel('showcase/showcase');
            $article->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {
                $article->save();

                $this->addUrlRewrite(
                        'showcase/article/' . $article->getId(),
                        'showcase/article/view/id/' . $article->getId(),
                        $article->getUrlKey(),
                        false
                );
                $this->addUrlRewrite(
                        'showcase/' . date('Y-m', strtotime($article->getDate())),
                        'showcase/index/index/date/' . date('Y-m', strtotime($article->getDate())),
                        'showcase/' . strtolower(date('Y/F', strtotime($article->getDate())))
                );

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('edge_showcase')->__('Item was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $article->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('edge_showcase')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

    public function saveAttachment($name)
    {
        $path = Mage::getBaseDir('media') . '/showcase/';
        if (!file_exists(($path))){
            mkdir($path);
        }

        if (isset($_FILES[$name]) && (file_exists($_FILES[$name]['tmp_name']))){
            try {
                $uploader = new Varien_File_Uploader($name);
                $image = $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'))
                    ->setAllowRenameFiles(true)
                    ->setFilesDispersion(true)
                    ->save($path, $_FILES[$name]['name']);

                return 'showcase'.$image['file'];

            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getTraceAsString());
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return false;
            }
        }

        return false;
    }

    /**
     * Add a URL Rewrite in to core_url_rewrite table.
     *
     * @param string $idPath ID Path
     * @param string $targetPath Request Path
     * @param string $requestPath Target Path
     * @param string $checkExisting Check if rewrite with the same ID Path already exists (false will overwrite existing rewrite rule)
     * @return boolean
     */
    public function addUrlRewrite($idPath, $targetPath, $requestPath, $checkExisting = true) {
        //Get current rewrite if exists
        $rewrite = Mage::getModel('core/url_rewrite')->loadByIdPath($idPath);

        if($checkExisting && $rewrite->getUrlRewriteId()) {
            return false;
        }

        // Add rewrite
        $rewrite->setIsSystem(0)
            ->setIdPath($idPath)
            ->setTargetPath($targetPath)
            ->setRequestPath($requestPath)
            ->save();

        return true;
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0){
            try {
                $article = Mage::getModel('showcase/showcase');
                $article->setId($this->getRequest()->getParam('id'));
                $article->delete();

                $rewrite = Mage::getModel('core/url_rewrite')->loadByIdPath('showcase/article/' . $article->getId())->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('edge_showcase')->__('Article was successfully deleted'));
                $this->_redirect('*/*/');

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function productGridAction()
    {
        $this->_initModel();

        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('showcase/adminhtml_showcase_edit_tab_product', 'showcase_product_grid')->toHtml()
        );
    }
}