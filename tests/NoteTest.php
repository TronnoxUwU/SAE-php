<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require_once 'src/classes/Composant/Note.php';


final class NoteTest extends TestCase
{
    public function testCanBeCreatedFromValidEmail(): void
    {
        $not = new Note('aaaa',4,'','','aa','a');

        $email = 'aa';

        $this->assertSame($email, $not->getNomAuteur());
    }
}