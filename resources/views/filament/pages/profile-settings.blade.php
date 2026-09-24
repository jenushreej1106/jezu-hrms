<x-filament-panels::page>

    <div style="max-width:900px;margin:0 auto;">

        <h2 style="font-size:28px;font-weight:700;margin-bottom:8px;">
            Profile Settings
        </h2>

        <p style="opacity:.7;margin-bottom:25px;">
            Update your account information and password.
        </p>

        <form wire:submit="save">

            <div style="
                padding:25px;
                border:1px solid #444;
                border-radius:12px;
            ">

                <!-- Name -->
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600;">
                        Name
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        style="
                            width:100%;
                            padding:12px;
                            margin-top:8px;
                            border-radius:8px;
                            border:1px solid #888;
                        "
                    >

                    @error('name')
                        <div style="color:#dc2626;margin-top:5px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600;">
                        Email
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        style="
                            width:100%;
                            padding:12px;
                            margin-top:8px;
                            border-radius:8px;
                            border:1px solid #888;
                        "
                    >

                    @error('email')
                        <div style="color:#dc2626;margin-top:5px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr style="margin:30px 0;border-color:#555;">

                <h3 style="
                    font-size:20px;
                    font-weight:700;
                    margin-bottom:20px;
                ">
                    Change Password
                </h3>

                <!-- Current Password -->
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600;">
                        Current Password
                    </label>

                    <input
                        type="password"
                        wire:model="current_password"
                        style="
                            width:100%;
                            padding:12px;
                            margin-top:8px;
                            border-radius:8px;
                            border:1px solid #888;
                        "
                    >

                    @error('current_password')
                        <div style="color:#dc2626;margin-top:5px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- New Password -->
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600;">
                        New Password
                    </label>

                    <input
                        type="password"
                        wire:model="new_password"
                        style="
                            width:100%;
                            padding:12px;
                            margin-top:8px;
                            border-radius:8px;
                            border:1px solid #888;
                        "
                    >

                    @error('new_password')
                        <div style="color:#dc2626;margin-top:5px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div style="margin-bottom:25px;">
                    <label style="font-weight:600;">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        wire:model="new_password_confirmation"
                        style="
                            width:100%;
                            padding:12px;
                            margin-top:8px;
                            border-radius:8px;
                            border:1px solid #888;
                        "
                    >

                    @error('new_password_confirmation')
                        <div style="color:#dc2626;margin-top:5px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button
                    type="submit"
                    style="
                        background:#2563eb;
                        color:white;
                        padding:12px 24px;
                        border:none;
                        border-radius:8px;
                        font-weight:600;
                        cursor:pointer;
                    "
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</x-filament-panels::page>
