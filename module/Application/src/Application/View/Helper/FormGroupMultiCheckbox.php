<?php
namespace Application\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Element\MultiCheckbox as MultiCheckboxElement;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class FormGroupMultiCheckbox extends \Zend\Form\View\Helper\FormMultiCheckbox
{

    /**
     *
     * @var \Closure
     */
    protected $headCheckCallback;

    /**
     *
     * @var \Closure
     */
    protected $headLabelCallback;

    /**
     *
     * @var unknown
     */
    protected $lastOptionSpec;

    /**
     *
     * @var unknown
     */
    protected $currentOptionSpec;

    /**
     *
     * @var string
     */
    protected $groupContentOpenTag = '<div id="collapse_%d" class="panel-collapse collapse %s" style="padding: 20px;">';

    /**
     *
     * @var string
     */
    protected $groupContentCloseTag = '</div>';

    /**
     *
     * @var string
     */
    protected $headContentOpenTag = '<div class="panel-heading"><h4 class="panel-title">';
   
    /**
     * 
     * @var string
     */
    protected $headContentOpenTagLink = '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion%1$d" href="#collapse_%1$d">';

    /**
     *
     * @var string
     */
    protected $headContentCloseTag = '</a>
					</h4>
				</div>';

    /**
     *
     * @var string
     */
    protected $groupOpenTag = '<div class="panel panel-default">';

    /**
     *
     * @var string
     */
    protected $groupCloseTag = '</div>';

    /**
     */
    protected $conainerTag = '%2$s';

    protected $groupCount = 0;

    /**
     */
    public function render(ElementInterface $element)
    {
        return parent::render($element);
    }

    /**
     */
    protected function renderOptions(MultiCheckboxElement $element, array $options, array $selectedOptions, array $attributes)
    {
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $labelHelper = $this->getLabelHelper();
        $labelClose = $labelHelper->closeTag();
        $labelPosition = $this->getLabelPosition();
        $globalLabelAttributes = $element->getLabelAttributes();
        $closingBracket = $this->getInlineClosingBracket();
        
        if (empty($globalLabelAttributes)) {
            $globalLabelAttributes = $this->labelAttributes;
        }
        
        $combinedMarkup = array();
        $count = 0;
        
        $this->lastOptionSpec = false;
        
        $searchElements = new ArrayCollection($element->getProxy()->getObjects());
        
        foreach ($options as $key => $optionSpec) {
            
            $count ++;
            
            if ($count > 1 && array_key_exists('id', $attributes)) {
                unset($attributes['id']);
            }
            
            $value = '';
            $label = '';
            $inputAttributes = $attributes;
            $labelAttributes = $globalLabelAttributes;
            $selected = isset($inputAttributes['selected']) && $inputAttributes['type'] != 'radio' && $inputAttributes['selected'] != false ? true : false;
            $disabled = isset($inputAttributes['disabled']) && $inputAttributes['disabled'] != false ? true : false;
            
            if (is_scalar($optionSpec)) {
                $optionSpec = array(
                    'label' => $optionSpec,
                    'value' => $key
                );
            }
            
            if (isset($optionSpec['value'])) {
                $value = $optionSpec['value'];
            }
            if (isset($optionSpec['label'])) {
                $label = $optionSpec['label'];
            }
            if (isset($optionSpec['selected'])) {
                $selected = $optionSpec['selected'];
            }
            if (isset($optionSpec['disabled'])) {
                $disabled = $optionSpec['disabled'];
            }
            if (isset($optionSpec['label_attributes'])) {
                $labelAttributes = (isset($labelAttributes)) ? array_merge($labelAttributes, $optionSpec['label_attributes']) : $optionSpec['label_attributes'];
            }
            if (isset($optionSpec['attributes'])) {
                $inputAttributes = array_merge($inputAttributes, $optionSpec['attributes']);
            }
            
            if (in_array($value, $selectedOptions)) {
                $selected = true;
            }
            
            $inputAttributes['value'] = $value;
            $inputAttributes['checked'] = $selected;
            $inputAttributes['disabled'] = $disabled;
            
            $input = sprintf('<input %s%s', $this->createAttributesString($inputAttributes), $closingBracket);
            
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
            
            $label = $escapeHtmlHelper($label);
            $labelOpen = $labelHelper->openTag($labelAttributes);
            $template = '<div>' . $labelOpen . '%s&nbsp;%s' . $labelClose . '</div>' . PHP_EOL;
            
            switch ($labelPosition) {
                case self::LABEL_PREPEND:
                    $markup = sprintf($template, $label, $input);
                    break;
                case self::LABEL_APPEND:
                    $markup = sprintf($template, $input, $label);
                    break;
                default:
                    break;
            }
            
            $criteria = new Criteria();
            $criteria->where($criteria->expr()->eq('id', $optionSpec['value']));
            $current = $searchElements->matching($criteria)->first();
            
            // se preencheu o callback do label e também
            // não é a primeira função-ação ou a anterior é diferente da atual 
            if ($this->headLabelCallback && call_user_func($this->headCheckCallback, $this->lastOptionSpec, $current)) {
                
                $this->groupCount ++;
                $headLabel = call_user_func($this->headLabelCallback, $current);
                
                // selecionar todos elementos abaixo
                $checkAll = new \Zend\Form\Element\Checkbox('checkAll' . $this->groupCount);
                $checkAll->setAttribute('class', 'checkAll');
                $checkAll->setUseHiddenElement(false);
                $renderCheckAll = $this->getView()->formCheckBox($checkAll);
                
                // se tem ultimo função-ação preenchido
                if ($this->lastOptionSpec) {
                	// fecha div do grupo principal [panel-default] 
                    $combinedMarkup[] = $this->groupContentCloseTag;
                    // fecha div do grupo de inputs [panel-collapse]
                    $combinedMarkup[] = $this->groupCloseTag;
                }
                
                // abre div [panel-default] 
                $combinedMarkup[] = $this->groupOpenTag;
                // abre div [panel-heading]
                $combinedMarkup[] = $this->headContentOpenTag . $renderCheckAll . "&nbsp;" . sprintf($this->headContentOpenTagLink, $this->groupCount) . $headLabel . $this->headContentCloseTag;
                // abre div [panel-collapse]
                $combinedMarkup[] = sprintf($this->groupContentOpenTag, $this->groupCount, $selected ? 'in' : '');
                
                // preenche a ultima função-ação a partir da atual
                $this->lastOptionSpec = $current;
            }
            // prenche div do input
            $combinedMarkup[] = $markup;
        }
        // fecha div do grupo principal [panel-default] 
        $combinedMarkup[] = $this->groupContentCloseTag;
        
        $contents = implode($this->getSeparator(), $combinedMarkup);
        return sprintf($this->conainerTag, $element->getName(), $contents);
    }

    /**
     *
     * @param \Closure $headCheckCallback            
     * @return \Application\View\Helper\FormGroupMultiCheckbox
     */
    public function setHeadCheckCallback($headCheckCallback)
    {
        $this->headCheckCallback = $headCheckCallback;
        return $this;
    }

    /**
     *
     * @param \Closure $headLabel            
     * @return \Application\View\Helper\FormGroupMultiCheckbox
     */
    public function setHeadLabelCallback($headLabelCallback)
    {
        $this->headLabelCallback = $headLabelCallback;
        return $this;
    }

    /**
     *
     * @param array $options            
     */
    public function setOptions(array $options)
    {
        if (isset($options['head_check_callback'])) {
            $this->setHeadCheckCallback($options['head_check_callback']);
        }
        if (isset($options['head_label_callback'])) {
            $this->setHeadLabelCallback($options['head_label_callback']);
        }
        return $this;
    }
}
