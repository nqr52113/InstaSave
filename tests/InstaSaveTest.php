<?php

use InstaSave\URL\URL;
use InstaSave\InstaSave;
use InstaSave\Response\Model\Owner;
use InstaSave\Response\Model\Dimension;
use InstaSave\Response\Entity\User;
use InstaSave\Response\Entity\Feed;
use InstaSave\Response\Entity\IGTV;
use InstaSave\Response\Entity\Playlist;
use InstaSave\Enumeration\Entity;
use InstaSave\Enumeration\Resource;
use InstaSave\Exception\URLValidationException;
use InstaSave\Exception\ResponseException;
use InstaSave\Exception\ClientException;
use Alshf\Exceptions\FootmanRequestException;
use PHPUnit\Framework\TestCase;

final class InstaSaveTest extends TestCase {
    public function testProfilePicture() {
        try {
            $instaSave = new InstaSave(new URL('https://www.instagram.com/9gag/'));
            $response = $instaSave->fetch();
        } catch (Exception $e) {
            $this->expectException(sprintf('%s => %s', get_class($e), $e->getMessage()));
        }

        $this->assertInstanceOf(User::class, $response);
        $this->assertObjectHasAttribute('type', $response);
        $this->assertObjectHasAttribute('biography', $response);
        $this->assertObjectHasAttribute('followedBy', $response);
        $this->assertObjectHasAttribute('follow', $response);
        $this->assertObjectHasAttribute('isVerified', $response);
        $this->assertObjectHasAttribute('owner', $response);

        $this->assertInternalType('string', $response->type);
        $this->assertInternalType('int', $response->followedBy);
        $this->assertInternalType('int', $response->follow);
        $this->assertInternalType('bool', $response->isVerified);

        $this->assertNotEmpty($response->type);
        $this->assertEquals($response->type, Entity::user);
        $this->assertNotEmpty($response->followedBy);
        $this->assertNotEmpty($response->follow);
        
        $this->assertInstanceOf(Owner::class, $response->owner);
        $this->assertObjectHasAttribute('id', $response->owner);
        $this->assertObjectHasAttribute('username', $response->owner);
        $this->assertObjectHasAttribute('fullname', $response->owner);
        $this->assertObjectHasAttribute('avator', $response->owner);

        $this->assertInternalType('string', $response->owner->id);
        $this->assertInternalType('string', $response->owner->username);
        $this->assertInternalType('string', $response->owner->fullname);
        $this->assertInternalType('string', $response->owner->avator);

        $this->assertNotEmpty($response->owner->id);
        $this->assertNotEmpty($response->owner->username);
        $this->assertNotEmpty($response->owner->fullname);
        $this->assertNotEmpty($response->owner->avator);
        $this->assertContains('.jpg', $response->owner->avator);
    }

    /**
     * @dataProvider urlProvider
     */
    public function testFeeds($type, $url) {
        try {
            $instaSave = new InstaSave(new URL($url));
            $response = $instaSave->fetch();
        } catch (Exception $e) {
            $this->expectException(sprintf('%s => %s', get_class($e), $e->getMessage()));
        }

        // Entity Validation
        switch ($type) {
            case 'playlist':
                $this->assertInstanceOf(Playlist::class, $response);
                break;
            
            case 'feed':
                $this->assertInstanceOf(Feed::class, $response);
                break;

            case 'igtv':
                $this->assertInstanceOf(IGTV::class, $response);
                break;  
            default:
                throw new Exception('Undefined Type provides for instagram url.');
                break;
        }
            
        $this->assertObjectHasAttribute('id', $response);
        $this->assertObjectHasAttribute('type', $response);
        $this->assertObjectHasAttribute('shortcode', $response);
        $this->assertObjectHasAttribute('comments', $response);
        $this->assertObjectHasAttribute('likes', $response);
        $this->assertObjectHasAttribute('postedAt', $response);
        $this->assertObjectHasAttribute('description', $response);
        $this->assertObjectHasAttribute('owner', $response);
        $this->assertObjectHasAttribute('dimensions', $response);
        $this->assertObjectHasAttribute('resources', $response);

        $this->assertInternalType('string', $response->id);
        $this->assertInternalType('string', $response->type);
        $this->assertInternalType('string', $response->shortcode);
        $this->assertInternalType('int', $response->comments);
        $this->assertInternalType('int', $response->likes);
        $this->assertInternalType('int', $response->postedAt);
        $this->assertInternalType('array', $response->resources);

        $this->assertNotEmpty($response->id);
        $this->assertNotEmpty($response->type);
        $this->assertNotEmpty($response->shortcode);
        $this->assertGreaterThanOrEqual(0, $response->comments);
        $this->assertGreaterThanOrEqual(0, $response->likes);
        $this->assertGreaterThanOrEqual(0, $response->postedAt);
        $this->assertTrue(Entity::isValidValue($response->type));

        $this->assertInstanceOf(Owner::class, $response->owner);
        $this->assertObjectHasAttribute('id', $response->owner);
        $this->assertObjectHasAttribute('username', $response->owner);
        $this->assertObjectHasAttribute('fullname', $response->owner);
        $this->assertObjectHasAttribute('avator', $response->owner);

        $this->assertInternalType('string', $response->owner->id);
        $this->assertInternalType('string', $response->owner->username);
        $this->assertInternalType('string', $response->owner->fullname);
        $this->assertInternalType('string', $response->owner->avator);

        $this->assertNotEmpty($response->owner->id);
        $this->assertNotEmpty($response->owner->username);
        $this->assertNotEmpty($response->owner->fullname);
        $this->assertNotEmpty($response->owner->avator);
        $this->assertContains('.jpg', $response->owner->avator);

        $this->assertInstanceOf(Dimension::class, $response->dimensions);
        $this->assertObjectHasAttribute('width', $response->dimensions);
        $this->assertObjectHasAttribute('height', $response->dimensions);

        $this->assertInternalType('int', $response->dimensions->width);
        $this->assertInternalType('int', $response->dimensions->height);

        $this->assertGreaterThanOrEqual(0, $response->dimensions->width);
        $this->assertGreaterThanOrEqual(0, $response->dimensions->height);

        foreach ($response->resources as $resource) {
            $this->assertObjectHasAttribute('id', $resource);
            $this->assertObjectHasAttribute('type', $resource);
            $this->assertObjectHasAttribute('shortcode', $resource);
            $this->assertObjectHasAttribute('dimensions', $resource);
            $this->assertObjectHasAttribute('thumbnail', $resource);

            $this->assertInternalType('string', $resource->id);
            $this->assertInternalType('string', $resource->type);
            $this->assertInternalType('string', $resource->shortcode);
            $this->assertInternalType('string', $resource->thumbnail);

            $this->assertNotEmpty($resource->id);
            $this->assertNotEmpty($resource->type);
            $this->assertNotEmpty($resource->shortcode);
            $this->assertNotEmpty($resource->thumbnail);
            $this->assertContains('.jpg', $resource->thumbnail);

            $this->assertInstanceOf(Dimension::class, $resource->dimensions);
            $this->assertObjectHasAttribute('width', $response->dimensions);
            $this->assertObjectHasAttribute('height', $response->dimensions);

            $this->assertInternalType('int', $response->dimensions->width);
            $this->assertInternalType('int', $response->dimensions->height);

            $this->assertGreaterThanOrEqual(0, $response->dimensions->width);
            $this->assertGreaterThanOrEqual(0, $response->dimensions->height);

            if ($resource->type === Resource::video) {
                $this->assertObjectHasAttribute('video', $resource);
                $this->assertObjectHasAttribute('duration', $resource);
                $this->assertObjectHasAttribute('views', $resource);

                $this->assertInternalType('string', $resource->video);
                $this->assertInternalType('int', $resource->duration);
                $this->assertInternalType('int', $resource->views);

                $this->assertNotEmpty($resource->video);
                $this->assertGreaterThanOrEqual(0, $response->duration);
                $this->assertGreaterThanOrEqual(0, $response->views);
                $this->assertContains('.mp4', $resource->video);
            }
        }
    }

    public function testInvalidUrl() {
        try {
            new URL('https://www.notValidURL.com/');
        } catch (Exception $e) {
            $this->assertInstanceOf(URLValidationException::class, $e);
        }
    }

    public function testStoriesNoResponse() {
        try {
            $url = new URL('https://www.instagram.com/stories/instagram/');
            $instaSave = new InstaSave($url);
            $instaSave->fetch();
        } catch (Exception $e) {
            $this->assertInstanceOf(ResponseException::class, $e);
        }
    }

    public function testPrivateFeedNoResponse() {
        try {
            $url = new URL('https://www.instagram.com/p/gVcI2cpv84TBEnMGPZQqYAdHUSbVDHm_AKtVE0');
            $instaSave = new InstaSave($url);
            $instaSave->fetch();
        } catch (Exception $e) {
            $this->assertInstanceOf(ResponseException::class, $e);
        }
    }

    public function test404() {
        try {
            $url = new URL('https://www.instagram.com/some404UrlThatDoesntExist/');
            $instaSave = new InstaSave($url);
            $instaSave->fetch();
        } catch (\Exception $e) {
            $this->assertInstanceOf(ClientException::class, $e);
            $this->assertInstanceOf(FootmanRequestException::class, $e->getPrevious());
            $this->assertEquals(404, $e->getPrevious()->getStatusCode());
            $this->assertEquals('Not Found', $e->getPrevious()->getReasonPhrase());
        }
    }

    public function urlProvider() {
        return [
            [
                // Picture
                'type' => Entity::playlist,
                'url' => 'https://www.instagram.com/p/BoHk1haB5tM/'
            ],
            [
                // Video
                'type' => Entity::playlist,
                'url' => 'https://www.instagram.com/p/Bn9URMGjWJG/'
            ],
            [
                // Image
                'type' => Entity::feed,
                'url' => 'https://www.instagram.com/p/BoaOrTsBIvm/'
            ],
            [
                // Video
                'type' => Entity::feed,
                'url' => 'https://www.instagram.com/p/BnXQqMvDIMs/'
            ],
            [
                // IGTV
                'type' => Entity::igtv,
                'url' => 'https://www.instagram.com/tv/BkQjCfsBIzi/'
            ]
        ];
    }
}