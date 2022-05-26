<?php

// declare(strict_types=1);

// namespace Fleetbase\Omniship\Test\Fleetbase;

// use Fleetbase\Omniship\Fleetbase;
// use Fleetbase\Omniship\Resources\Place;
// use Fleetbase\Omniship\Test\TestCase;

// final class PlaceTest extends TestCase
// {
//     const TEST_RESOURCE_ID = 'place_123';

//     public function testIsCreatable()
//     {
//         $publicKey = $_ENV['FLEETBASE_KEY'];
//         $fleetbase = new Fleetbase($publicKey);

//         $resource = $fleetbase->places->create([
//             'name' => 'Space Needle',
//             'street1' => '400 Broad Street',
//             'city' => 'Seattle',
//             'state' => 'WA',
//             'country' => 'US'
//         ]);

//         $this->assertInstanceOf(Place::class, $resource);
//     }

//     public function testIsListable()
//     {
//         $publicKey = $_ENV['FLEETBASE_KEY'];
//         $fleetbase = new Fleetbase($publicKey);

//         $resources = $fleetbase->places->findAll();

//         $this->assertIsArray($resources);
//         $this->assertInstanceOf(Place::class, $resources[0]);
//     }

//     public function testIsRetrievable()
//     {
//         $publicKey = $_ENV['FLEETBASE_KEY'];
//         $fleetbase = new Fleetbase($publicKey);

//         $resource = $fleetbase->places->findRecord(self::TEST_RESOURCE_ID);

//         $this->assertInstanceOf(Place::class, $resource);
//     }

//     public function testIsSaveable()
//     {
//         $publicKey = $_ENV['FLEETBASE_KEY'];
//         $fleetbase = new Fleetbase($publicKey);

//         $resource = $fleetbase->places->findRecord(self::TEST_RESOURCE_ID);
//         $resource->save();

//         $this->assertInstanceOf(Place::class, $resource);
//     }

//     public function testIsUpdatable()
//     {
//         $publicKey = $_ENV['FLEETBASE_KEY'];
//         $fleetbase = new Fleetbase($publicKey);

//         $newName = 'Space Needle 2';

//         $resource = $fleetbase->places->findRecord(self::TEST_RESOURCE_ID);
//         $resource->update(['name' => $newName]);

//         $this->assertInstanceOf(Place::class, $resource);
//         $this->assertEquals($newName, $resource->getAttribute('name'));
//     }

//     public function testIsDeletable()
//     {
//         $publicKey = $_ENV['FLEETBASE_KEY'];
//         $fleetbase = new Fleetbase($publicKey);

//         $resource = $fleetbase->places->findRecord(self::TEST_RESOURCE_ID);
//         $resource->destroy();

//         $this->assertIsObject($resource);
//         $this->assertTrue($resource->getAttribute('deleted'));
//         $this->assertTrue($resource->isDestroyed);
//         $this->assertEquals(self::TEST_RESOURCE_ID, $resource->id);
//     }
// }
