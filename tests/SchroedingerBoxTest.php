<?php

declare(strict_types=1);

namespace NorseBlue\Optionals\Tests;

use NorseBlue\Optionals\SchroedingerBox;
use NorseBlue\Optionals\Tests\Helpers\CatObject;
use function NorseBlue\Optionals\Functions\box;

class SchroedingerBoxTest extends TestCase
{
    /** @test */
    public function box_function_builds_a_schroedinger_box_enclosing_the_given_value()
    {
        $subject = box(9);

        $this->assertInstanceOf(SchroedingerBox::class, $subject);
    }

    /** @test */
    public function can_call_method_chain_on_cat_when_it_is_an_object()
    {
        $subject = box(new CatObject())->sum(9)->getValue();

        $this->assertEquals(9, $subject->unbox());
    }

    /** @test */
    public function can_call_method_chain_on_cat_when_it_is_not_an_object()
    {
        $subject = box(9)->sum(9)->getValue();

        $this->assertEquals(null, $subject->unbox());
    }

    /** @test */
    public function can_call_method_chain_on_cat_when_it_is_null()
    {
        $subject = box(null)->sum(9)->getValue();

        $this->assertEquals(null, $subject->unbox());
        $this->assertEquals(9, $subject->unbox(9));
        $this->assertEquals('Value', $subject->unbox('Value'));
    }

    /** @test */
    public function unbox_returns_null_when_chain_call_unsuccessful()
    {
        $subject = box(new CatObject(9))->sum(3)->double()->value;

        $this->assertEquals(null, $subject->unbox());
    }

    /** @test */
    public function unbox_returns_correct_value_when_chain_mixes_method_and_property_calls()
    {
        $subject = box(new CatObject(9))->sum(3)->double()->prop->tenfold()->value;

        $this->assertEquals(240, $subject->unbox());
    }

    /** @test */
    public function unbox_returns_default_override_when_cat_unboxing_is_null_and_default_override_is_given()
    {
        $subject = box(null);

        $this->assertEquals(null, $subject->unbox());
        $this->assertEquals(9, $subject->unbox(9));
        $this->assertEquals('Value', $subject->unbox('Value'));
    }

    /** @test */
    public function unbox_returns_default_value_when_cat_unboxing_is_null()
    {
        $subject = box(null, 9);

        $this->assertEquals(9, $subject->unbox(9));
    }
}
