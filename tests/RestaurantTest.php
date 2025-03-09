<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require_once 'src/classes/Composant/Restaurant.php';
require_once "src/static/script/modele.php";
final class RestaurantTest extends TestCase
{
    public function testRestaurant(): void
    {
        $restaurants = new Restaurant(0,
                                      "test",
                                      "",
                                      0,
                                      0,
                                      0,
                                      1,
                                      1,
                                      "",
                                      "",
                                      "",
                                      3.5,
                                      120,
                                      false,
                                      false,
                                      true,
                                      true,
                                      false,
                                      "",
                                      [],
                                      []);

        $this->assertTrue($restaurants->getCapacite()>100);

    }
}