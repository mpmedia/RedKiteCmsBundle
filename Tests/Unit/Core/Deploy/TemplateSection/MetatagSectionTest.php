<?php
/**
 * This file is part of the RedKiteCmsBunde Application and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) RedKite Labs <webmaster@redkite-labs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.redkite-labs.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

namespace RedKiteLabs\RedKiteCmsBundle\Tests\Unit\Core\Deploy\TemplateSection;

use RedKiteLabs\RedKiteCmsBundle\Tests\TestCase;
use RedKiteLabs\RedKiteCmsBundle\Core\Deploy\TemplateSection\MetatagSection;


/**
 * TemplateSectionTwigTest
 *
 * @author RedKite Labs <info@redkite-labs.com>
 */
class MetatagsSectionTest extends TestCase
{
    public function testMetatags()
    {
        $urlManager = $this->getMock("RedKiteLabs\RedKiteCmsBundle\Core\UrlManager\AlUrlManagerInterface");
        $theme = $this->getMockBuilder("RedKiteLabs\ThemeEngineBundle\Core\Theme\AlTheme")
                        ->disableOriginalConstructor()
                        ->getMock();
        $themeSlots = $this->getMock("RedKiteLabs\ThemeEngineBundle\Core\ThemeSlots\AlThemeSlotsInterface");
        
        $theme->expects($this->once())
            ->method('getThemeSlots')
            ->will($this->returnValue($themeSlots))
        ;
        
        $pageTree = $this->getMockBuilder('RedKiteLabs\RedKiteCmsBundle\Core\PageTree\AlPageTree')
                                ->disableOriginalConstructor()
                                ->setMethods(array('getMetaTitle', 'getMetaDescription', 'getMetaKeywords'))
                                ->getMock();
        
        $pageTree->expects($this->once())
            ->method('getMetaTitle')
            ->will($this->returnValue('Website title'))
        ;
        
        $pageTree->expects($this->once())
            ->method('getMetaDescription')
            ->will($this->returnValue('Website description'))
        ;
        
        $pageTree->expects($this->once())
            ->method('getMetaKeywords')
            ->will($this->returnValue('website,keywords'))
        ;
        
        $metatagsSection = new MetatagSection($urlManager);
        $options = array(
            "uploadAssetsFullPath" => "",
            "uploadAssetsAbsolutePath" => "",
        );
        
        $expectedResult = PHP_EOL . "{#--------------  METATAGS SECTION  --------------#}" . PHP_EOL;
        $expectedResult .= "{% block title %} Website title {% endblock %}" . PHP_EOL;
        $expectedResult .= "{% block description %} Website description {% endblock %}" . PHP_EOL;
        $expectedResult .= "{% block keywords %} website,keywords {% endblock %}" . PHP_EOL;

        
        $this->assertEquals($expectedResult, $metatagsSection->generateSection($pageTree, $theme, $options));
    }
}