<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_message_is_saved_and_emailed(): void
    {
        Mail::fake();

        $response = $this->post(route('kontak.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'message' => 'Saya ingin bertanya tentang servis motor.',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('kontak'));

        $contactMessage = ContactMessage::first();

        $this->assertNotNull($contactMessage);
        $this->assertSame('Budi Santoso', $contactMessage->name);
        $this->assertSame('budi@example.com', $contactMessage->email);

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail) use ($contactMessage) {
            return $mail->contactMessage->is($contactMessage);
        });
    }

    public function test_contact_message_requires_valid_input(): void
    {
        $response = $this->from(route('kontak'))->post(route('kontak.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'phone' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }
}
