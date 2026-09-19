<h2>Pesan Kontak Baru</h2>

<p><strong>Nama:</strong> {{ $contactMessage->name }}</p>
<p><strong>Email:</strong> {{ $contactMessage->email }}</p>
<p><strong>No. Telepon:</strong> {{ $contactMessage->phone }}</p>

<p><strong>Pesan:</strong></p>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>
