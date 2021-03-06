<?php
/**
 * @file
 * Represents a pop-up calendar date widget on a Drupal entity form.
 */

namespace Codeception\Module\Drupal\ContentTypeRegistry\Widgets;

/**
 * Class PopUpCalendarWidget
 *
 * @todo currently this only supports entering a single "start" date. Could do with a better way here.
 *
 * @package Codeception\Module\Drupal\ContentTypeRegistry\Widgets
 */
class PopUpCalendarWidget extends Widget
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->name = 'Pop-up calendar';
    }

    /**
     * {@inheritdoc}
     */
    public function getCssOrXpath()
    {
        return '#' . $this->getSelector() . '-0-value-datepicker-popup-0';
    }

    // Nothing needed here as the base class's fill() will take care of filling the text-based date widget.
}
