<?php

use PHPUnit\Framework\TestCase;

class UtilitiesTest extends TestCase
{

    /**
     * @test
     */
    public function textPreviewText() {
        $entry = "      Lorem <div>ipsum dolor</div> sit amet, consectetur adipiscing elit. Etiam euismod nibh a lorem vulputate elementum. Cras cursus lorem quis libero egestas rutrum. Praesent vitae magna <b>eget massa posuere</b> congue. Mauris efficitur nunc neque, quis placerat arcu venenatis at. Nunc aliquet faucibus ante. Vestibulum pretium rutrum diam vel lacinia. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut non tellus dignissim, consequat metus id, maximus dolor. Praesent ultricies posuere.   ";
        $this->assertEquals(
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod nibh a lorem vulputate elementum. Cras cursus lorem quis libero egestas rutrum. Praesent vitae magna eget massa posuere congue. Mauris efficitur nunc neque, quis [...]",
            Utilities::previewText($entry)
        );
    }

}
