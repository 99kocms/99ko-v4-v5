<?php

/*
 * 99ko CMS (since 2010)
 * https://github.com/99kocms/
 *
 * Creator / Developper :
 * Jonathan (j.coulet@gmail.com)
 * 
 * Contributors :
 * Frédéric Kaplon (frederic.kaplon@me.com)
 * Florent Fortat (florent.fortat@maxgun.fr)
 * Maxence Cauderlier (mx.koder@gmail.com)
 */

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Editor is a class to simplify how plugins works with textarea and the editor
 */
class editor {
    
    /**
     * Textarea ID
     * @var string Unique ID (will be the name too)
     */
    protected $id;
    
    /**
     * Display a label before the textarea
     * @var string Text of the textarea label
     */
    protected $label;
    
    /**
     * Textarea Content.
     * See constructor, setContent and getPostContent to set and get it.
     * @var string Textarea Content
     */
    protected $content;
    
    /**
     * Core is only used to call hooks
     * @var \core 99ko Core
     */
    protected $core;

    /**
     * Construct a new textarea editor
     * 
     * @param string ID
     * @param string Content (facultative)
     * @param string label (facultative)
     */
    public function __construct($id, $content = '', $label = false) {
        $this->id = $id ;
        $this->label = $label;        
        $this->core = core::getInstance();
        $this->setContent($content);
    }
    
    /**
     * Allow to display the editor like this : echo $editor;
     * 
     * @return string
     */
    public function __toString() {
        $str = '';
        if ($this->label) {
            $str.= '<label for="' . $this->id . '">' . $this->label . '</label><br>';
        }
        $str .= '<textarea name="' . $this->id . '" id="' . $this->id . '" class="editor">'. $this->content . '</textarea>';
        return $str;
    }
    
    /**
     * Get the textarea content as it was posted, after the core hooks.
     * Return false if no POST data
     * 
     * @return mixed Textarea Posted Content
     */
    public function getPostContent() {
        if (!isset($_POST[$this->id])) {
            return false;
        }
        return $this->core->callHook('beforeGetPostContent', $_POST[$this->id]);
    }
    
    /**
     * Re-set the textarea content. Core hooks are called after setting content.
     * 
     * @param string Content
     */
    public function setContent($content) {
        $this->content = $this->core->callHook('beforeDisplayEditor', $content);
    }
}