<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Middleware\ReleaseIdentifier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReleaseIdentifierTest extends TestCase
{
    public function testReleaseIdentifierHeader()
    {
        putenv("RELEASE_IDENTIFIER=alphabet");
        $response = $this->get('/');
        $response->assertHeader("Release-Identifier", "alphabet");
        putenv("RELEASE_IDENTIFIER=");
    }
}
