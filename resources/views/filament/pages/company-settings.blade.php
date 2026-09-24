<x-filament-panels::page>

    <div style="max-width: 900px; margin: 0 auto;">

        <h2 style="font-size:28px;font-weight:700;margin-bottom:8px;">
            Company Settings
        </h2>

        <p style="opacity:.7;margin-bottom:25px;">
            Manage your company information.
        </p>

        <form wire:submit="save">

            <div style="
                padding:25px;
                border:1px solid #444;
                border-radius:12px;
            ">

                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:20px;
                ">

                    <div>
                        <label>Company Name</label>
                        <input
                            type="text"
                            wire:model="company_name"
                            style="width:100%;padding:12px;margin-top:8px;border-radius:8px;"
                        >
                    </div>

                    <div>
                        <label>Email</label>
                        <input
                            type="email"
                            wire:model="email"
                            style="width:100%;padding:12px;margin-top:8px;border-radius:8px;"
                        >
                    </div>

                    <div>
                        <label>Phone</label>
                        <input
                            type="text"
                            wire:model="phone"
                            style="width:100%;padding:12px;margin-top:8px;border-radius:8px;"
                        >
                    </div>

                    <div>
                        <label>Website</label>
                        <input
                            type="text"
                            wire:model="website"
                            style="width:100%;padding:12px;margin-top:8px;border-radius:8px;"
                        >
                    </div>

                </div>

                <div style="margin-top:20px;">
                    <label>Address</label>

                    <textarea
                        wire:model="address"
                        rows="4"
                        style="width:100%;padding:12px;margin-top:8px;border-radius:8px;"
                    ></textarea>
                </div>

                <div style="margin-top:25px;">

                    <label style="font-weight:600;">
                        Company Logo
                    </label>

                    <input
                        type="file"
                        wire:model="logoFile"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                        style="
                            display:block;
                            width:100%;
                            padding:12px;
                            margin-top:10px;
                            border:1px solid #888;
                            border-radius:8px;
                            background:white;
                            color:#111;
                        "
                    >

                    <div wire:loading wire:target="logoFile"
                         style="margin-top:10px;">
                        Uploading logo...
                    </div>

                    @if ($logoFile)

                        <div style="margin-top:20px;">

                            <p style="font-weight:600;">
                                New Logo Preview
                            </p>

                            <img
                                src="{{ $logoFile->temporaryUrl() }}"
                                style="
                                    width:180px;
                                    height:180px;
                                    object-fit:contain;
                                    border:1px solid #ccc;
                                    border-radius:10px;
                                    padding:10px;
                                    background:white;
                                "
                            >

                        </div>

                    @elseif ($logo)

                        <div style="margin-top:20px;">

                            <p style="font-weight:600;">
                                Current Logo
                            </p>

                            <img
                                src="{{ asset('storage/' . $logo) }}"
                                style="
                                    width:180px;
                                    height:180px;
                                    object-fit:contain;
                                    border:1px solid #ccc;
                                    border-radius:10px;
                                    padding:10px;
                                    background:white;
                                "
                            >

                        </div>

                    @endif

                </div>

                <div style="margin-top:25px;">

                    <button
                        type="submit"
                        style="
                            background:#2563eb;
                            color:white;
                            padding:12px 24px;
                            border:none;
                            border-radius:8px;
                            font-weight:600;
                        "
                    >
                        Save Settings
                    </button>

                </div>

            </div>

        </form>

    </div>

</x-filament-panels::page>
