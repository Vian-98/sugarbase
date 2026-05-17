@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')

<section style="max-width:720px;margin:0 auto;">
    <h1 style="font-size:1.4em;margin-bottom:12px;">Edit Profil</h1>

    <div style="background: var(--surface-strong);padding:18px;border-radius:12px;border:1px solid var(--border);">
        @if(session('success'))
            <div style="background: rgba(126,187,152,0.15); border:1px solid #d1fae5; padding:10px; border-radius:8px; margin-bottom:10px; color: var(--dark); font-weight: 600;">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profil.update') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label style="font-size:0.9em;color: var(--text-secondary);">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" style="width:100%;padding:10px;border:1px solid var(--border);border-radius:8px;margin-top:6px;">
                    @error('name') <div style="color: var(--danger);font-size:0.85em;margin-top:6px;">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label style="font-size:0.9em;color: var(--text-secondary);">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width:100%;padding:10px;border:1px solid var(--border);border-radius:8px;margin-top:6px;">
                    @error('phone') <div style="color: var(--danger);font-size:0.85em;margin-top:6px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="margin-top:12px;">
                <label style="font-size:0.9em;color: var(--text-secondary);">Alamat</label>
                <textarea name="alamat" style="width:100%;padding:10px;border:1px solid var(--border);border-radius:8px;margin-top:6px;" rows="4">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat') <div style="color: var(--danger);font-size:0.85em;margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div style="margin-top:14px;display:flex;gap:10px;">
                <button type="submit" style="background:var(--primary);color:white;padding:10px 14px;border-radius:8px;border:none;">Simpan Perubahan</button>
                <a href="{{ route('profil') }}" style="background:var(--light);color:var(--dark);padding:10px 14px;border-radius:8px;text-decoration:none;">Batal</a>
            </div>
        </form>
    </div>
</section>

@endsection
