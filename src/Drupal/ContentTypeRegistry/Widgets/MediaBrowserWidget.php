<?php
/**
 * @file
 * Represents a media module browser widget on a Drupal entity form.
 */

namespace Codeception\Module\Drupal\ContentTypeRegistry\Widgets;

/**
 * Class MediaBrowserWidget
 *
 * Same as MediaWidget, but has a different label.
 *
 * @package Codeception\Module\Drupal\ContentTypeRegistry\Widgets
 */
class MediaBrowserWidget extends MediaWidget
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->name = 'Media browser';
    }

    /**
     * This will search for a file in the media browser library and attach it.
     *
     * @param Actor $I
     *   The Actor.
     * @param string $value
     *   The file name to select.
     */
    public function fill($I, $value)
    {
        if (!$value) {
            return;
        }

        if (!method_exists($I, "waitForElementVisible")) {
            throw new \RuntimeException("WebDriver is required for MediaBrowserWidget::fill()");
        }

        $selector = $this->getSelector();

        if (!preg_match('/^#[\w\-]+\-upload$/', $selector)) {
            throw new \InvalidArgumentException("Must specify the input[@type='file'] field, ending in -upload");
        }

        $button = str_replace("-upload", "-browse-button", $selector);
        $I->click($button);
        $I->waitForElementVisible("#mediaBrowser");
        $I->executeJS("document.getElementById('mediaBrowser').name = 'tmp'");
        $I->switchToIFrame("tmp");
        $I->click("//a[@title='Library']");
        $I->waitForElement("#edit-filename");
        $I->fillField("#edit-filename", basename($value));
        $I->click("#edit-submit-media-default");
        $I->waitForElementVisible(".ajax-progress");
        $I->waitForElementNotVisible(".ajax-progress");
        $I->click("#media-browser-library-list img");
        $I->click("a.fake-submit");
        $I->switchToWindow();

        $fn = basename($value);
        $I->waitForElement("$selector div[title='$fn']");
    }
}
